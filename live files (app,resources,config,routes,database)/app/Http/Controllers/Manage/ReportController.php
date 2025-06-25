<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Report;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{

    public function store(Request $request)
    {
        // Manually validate to catch and return custom error JSON
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:admin_report_masters,report_name',
            'status' => 'required|in:Active,Deactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Map and create
        $data = [
            'report_name' => $request->name,
            'status' => $request->status,
        ];

        $report = Report::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Report added successfully!',
            'report' => $report,
        ]);
    }




    public function update(Request $request, Report $report)
    {
        // Find the policy by ID
        $report = Report::findOrFail($request->report_id);

        // Update the policy
        $report->update([
            'report_name' => $request->name,
            'status' => $request->status,
        ]);

        // Return JSON response (for AJAX)
        return response()->json([
            'message' => 'Report updated successfully',
            'report' => $report,
        ]);
    }
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return response()->json([
            'report' => $report
        ]);
    }
    public function destroy($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Report not found.'], 404);
        }

        $report->delete();

        return response()->json(['success' => true, 'message' => 'Report deleted successfully.']);
    }
}
