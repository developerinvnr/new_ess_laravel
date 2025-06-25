<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Policy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PolicyController extends Controller
{

public function store(Request $request)
{
    // Manually validate to catch and return custom error JSON
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:admin_policy_masters,policy_name',
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
        'policy_name' => $request->name,
        'status' => $request->status,
    ];

    $policy = Policy::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Policy added successfully!',
        'Policy' => $policy,
    ]);
}




    public function update(Request $request, Policy $Policy)
    {
        // Find the policy by ID
        $policy = Policy::findOrFail($request->policy_id);

        // Update the policy
        $policy->update([
            'policy_name' => $request->name,
            'status' => $request->status,
        ]);

        // Return JSON response (for AJAX)
        return response()->json([
            'message' => 'Policy updated successfully',
            'Policy' => $Policy,
        ]);
    }
    public function show($id)
    {
        $Policy = Policy::findOrFail($id);
        return response()->json([
            'Policy' => $Policy
        ]);
    }
    public function destroy($id)
    {
        $Policy = Policy::find($id);

        if (!$Policy) {
            return response()->json(['success' => false, 'message' => 'Policy not found.'], 404);
        }

        $Policy->delete();

        return response()->json(['success' => true, 'message' => 'Policy deleted successfully.']);
    }
}
