<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'approve' => ['required', Rule::in(['Yes', 'No'])],
                'reject' => ['required', Rule::in(['Yes', 'No'])],
                'modules' => 'nullable|string', // comma-separated
                'notification_type' => 'nullable|string', // comma-separated
                'status' => ['required', Rule::in(['Active', 'Deactive'])],
            ]);

            // 🔒 Check if the name already exists
            $existing = Activity::where('name', $validatedData['name'])->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'An activity with this name already exists.',
                ], 409); // 409 Conflict
            }

            // Convert comma-separated strings to arrays for JSON storage
            $validatedData['modules'] = $validatedData['modules'] ? explode(',', $validatedData['modules']) : [];
            $validatedData['notification_type'] = $validatedData['notification_type'] ? explode(',', $validatedData['notification_type']) : [];

            $activity = Activity::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Activity added successfully!',
                'activity' => $activity,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the activity.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request)
    {


        // Find activity by ID
        $activity = Activity::findOrFail($request->id);


        // Update activity
        $activity->update([
            'name' => $request->name,
            'approve' => $request->approve,
            'reject' => $request->reject,
            'modules' => $request->modules,
            'notification_type' => $request->notification_type,
            'status' => $request->status,
        ]);

        // Return success response with updated activity data
        return response()->json([
            'success' => true,
            'message' => 'Activity Updated successfully!',
            'activity' => $activity
        ], 201);
    }
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return response()->json($activity);
    }
    public function destroy($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json(['success' => false, 'message' => 'Activity not found.'], 404);
        }

        $activity->delete();

        return response()->json(['success' => true, 'message' => 'Activity deleted successfully.']);
    }

}
