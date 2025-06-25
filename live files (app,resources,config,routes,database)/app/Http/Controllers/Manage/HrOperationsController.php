<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\MasterTransactionName;
use App\Models\Backend\Activity;
use App\Models\Backend\EventsMaster;
use App\Models\Backend\NotificationMaster;
use App\Models\Backend\Policy;
use App\Models\Backend\ReasonMaster;
use App\Models\Backend\Report;


class HrOperationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manage.hroperations.hroperations');
    }
    public function hroperations_master()
    {
        $menuItems = Menu::whereNull('parent_id')->where('module','HROperations')->with('children')->orderBy('menu_position')->get();
        return view('manage.hroperations.master.index', compact('menuItems'));
    }
     public function hroperationsworkflow_master()
    {
        $allTransactionNames = MasterTransactionName::where('status', 1)->get();

        // Get only the top-level menu items (parentid is NULL)
        $masterTransactionNames = $allTransactionNames->whereNull('parentid');

        return view('manage.hroperations.hroperationview.workflow',compact('masterTransactionNames'));
    }
    public function transactions()
    {
        $transactions = MasterTransactionName::with(['parent', 'creator', 'updater'])->get();

        return view('manage.hroperations.hroperationview.transactions',compact('transactions'));
    }
    public function activity()
    {
        $activities = Activity::all();
        return view('manage.hroperations.hroperationview.activity',compact('activities'));
    }
    public function events()
    {
        $events = EventsMaster::all();
        return view('manage.hroperations.hroperationview.events',compact('events'));
    }
    public function notification()
    {
        $notifications = NotificationMaster::all();

        return view('manage.hroperations.hroperationview.notification',compact('notifications'));
    }
    public function policy()
    {        
        $policies = Policy::all();
        return view('manage.hroperations.hroperationview.policy',compact('policies'));
    }
    public function reason()
    {
        $reasons = ReasonMaster::all();
        return view('manage.hroperations.hroperationview.reason',compact('reasons'));
    }
    public function reports()
    {
        $reports = Report::all();

        return view('manage.hroperations.hroperationview.report',compact('reports'));
    }
   public function store(Request $request)
    {
        // Check for duplicate entry with same name and parentid
        $duplicate = MasterTransactionName::where('name', $request->name)
            ->where('parentid', $request->parentid)
            ->exists();

        if ($duplicate) {
            return response()->json([
                'error' => 'This transaction already exists under the selected parent.',
            ], 422); // 422 Unprocessable Entity
        }

        $transaction = new MasterTransactionName();
        $transaction->name = $request->name;
        $transaction->parentid = $request->parentid;
        $transaction->route_define = $request->route;
        $transaction->status = $request->status;
        $transaction->created_by = Auth::user()->EmployeeID;
        $transaction->updated_by = Auth::user()->EmployeeID;

        $transaction->save();

        // Eager load creator and updater
        $transaction->load('creator', 'updater', 'parent');

        return response()->json([
            'success' => 'Transaction added successfully!',
            'data' => [
                'id' => $transaction->id,
                'name' => $transaction->name,
                'status' => $transaction->status,
                'parentid' => $transaction->parentid,
                'route' => $transaction->route_define,
                'parent_name' => $transaction->parent?->name ?? '',
                'created_by_name' => $transaction->creator
                    ? $transaction->creator->Fname . ' ' . $transaction->creator->Sname . ' ' . $transaction->creator->Lname
                    : '',
                'updated_by_name' => $transaction->updater
                    ? $transaction->updater->Fname . ' ' . $transaction->updater->Sname . ' ' . $transaction->updater->Lname
                    : '',
                'created_at' => $transaction->created_at
                    ? $transaction->created_at->format('d-m-Y')
                    : '',
                'updated_at' => $transaction->updated_at
                    ? $transaction->updated_at->format('d-m-Y')
                    : '',
            ],
        ]);
    }
   public function update(Request $request, $id)
{
    $tran = MasterTransactionName::findOrFail($id);

    // Check duplicate
    $exists = MasterTransactionName::where('name', $request->name)
        ->where('parentid', $request->parentid)
        ->where('id', '!=', $id)
        ->exists();

    if ($exists) {
        return response()->json(['error' => 'Duplicate entry under selected parent.']);
    }
    $tran->name = $request->name;
    $tran->parentid = $request->parentid;
    $tran->status = $request->status;
    $tran->route_define = $request->route;
    $tran->updated_by = Auth::user()->EmployeeID;
    $tran->updated_at = now();
    $tran->save();
    $tran->load('creator', 'updater');
    if ($tran->status == 0) {
        MasterTransactionName::where('parentid', $tran->id)->update(['status' => 0]);
    } else {
        MasterTransactionName::where('parentid', $tran->id)->update(['status' => 1]);
    }

    // Get affected children
    $mainid = MasterTransactionName::where('id', $tran->id)->get(['id']);
    return response()->json([
        'success' => 'Transaction updated successfully.',
        'data' => [
            'id' => $tran->id,
            'name' => $tran->name,
            'parentid' => $tran->parentid,
            'status' => $tran->status,
            'route' => $tran->route_define,
            'updated_by_name' => $tran->updater
                ? $tran->updater->Fname . ' ' . $tran->updater->Sname . ' ' . $tran->updater->Lname
                : '',
            'created_by_name' => $tran->creator
                ? $tran->creator->Fname . ' ' . $tran->creator->Sname . ' ' . $tran->creator->Lname
                : '',
            'updated_at' => $tran->updated_at ? $tran->updated_at->format('d-m-Y') : '',
            'mainid' => $mainid->pluck('id') // pass only their IDs
        ]
    ]);
}

   public function getParentOptions()
   {
        $options = MasterTransactionName::pluck('name', 'id');

        return response()->json($options);
    }
    public function destroy($id)
    {
        // Delete child records first
        MasterTransactionName::where('parentid', $id)->delete();

        // Delete the main parent record
        MasterTransactionName::where('id', $id)->delete();

        return response()->json(['success' => 'Transaction and its children deleted', 'deleted_ids' => [$id]]);
    }
    public function parentOptions()
    {
        $transactions = MasterTransactionName::select('id', 'name')->get();
        return response()->json($transactions);
    }






}
