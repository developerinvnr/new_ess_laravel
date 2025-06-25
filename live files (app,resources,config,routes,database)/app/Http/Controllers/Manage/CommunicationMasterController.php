<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\CommControl;

class CommunicationMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communicationModules = CommControl::all();

        return view('manage.basic.master.comm_master',compact('communicationModules'));
    }

    public function store(Request $request)
    {
        
        // Check if module already exists
        $existingModule = CommControl::where('module_name', $request->module_name)->first();

        if ($existingModule) {
            return response()->json([
                'success' => false,
                'message' => 'Module name already exists.',
            ], 409); // 409 Conflict status code
        }

        // Create new module
        $module = CommControl::create([
            'module_name' => $request->module_name,
            'status' => $request->status,
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Communication Module added successfully',
            'id' => $module->id,

        ]);
    }
    public function toggleStatus(Request $request)
    {
        $module = CommControl::findOrFail($request->id);
        $module->status = $request->status;
        $module->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
    public function update(Request $request)
    {
        
        $module = CommControl::find($request->id);
        $module->module_name = $request->module_name;
        $module->status = $request->status;
        $module->save();

        return response()->json([
            'success' => true,
            'message' => 'Module updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        CommControl::destroy($request->id);
        return response()->json(['status' => 'success']);
    }
}