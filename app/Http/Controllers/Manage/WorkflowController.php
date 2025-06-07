<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Backend\MasterTransactionName;
use Illuminate\Support\Facades\Route;

class WorkflowController extends Controller
{
    public function newJoining() {
        $masterTransactionNames = MasterTransactionName::where('status', 1)
            ->whereNull('parentid')
            ->get();
        return view('manage.hroperations.workflowoperations.new-joining',compact('masterTransactionNames'));
    }
   public function transfer()
    {
        // Fetch all records to access both parent and children
        $allTransactionNames = MasterTransactionName::where('status', 1)->get();

        // Get only the top-level menu items (parentid is NULL)
        $masterTransactionNames = $allTransactionNames->whereNull('parentid');

        // Find the "Transfer" entry by route_define (safer than name)
        $transfer = $allTransactionNames->firstWhere('route_define', 'workflow.transfer');

        // Now get submenu items where parentid matches Transfer's ID and the route is valid
        $submenuItems = $allTransactionNames
            ->where('parentid', $transfer?->id)
            ->filter(function ($item) {
                $route = $item->route_define;
                return $route && $route !== '#' && $route !== '[]' && Route::has($route);
            });

        // return view with both menus
        return view('manage.hroperations.workflowoperations.transfer', compact('masterTransactionNames', 'submenuItems'));
    }


    public function deputation() {

            $masterTransactionNames = MasterTransactionName::where('status', 1)
            ->whereNull('parentid')
            ->get();
        return view('manage.hroperations.workflowoperations.deputation',compact('masterTransactionNames'));
    }

    public function confirmation() {
        return view('manage.hroperations.workflowoperations.confirmation');
    }
}

