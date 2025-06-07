<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\EventsMaster;

class EventController extends Controller
{
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:events_master,name',
            'status' => 'required|in:Active,Deactive',
        ]);

        $event = EventsMaster::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event added successfully!',
            'event' => $event
        ]);
    }

    public function update(Request $request, EventsMaster $event)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Deactive',
        ]);

        // Update event with validated data
        $event->update($validated);

        // Return JSON response (for AJAX)
        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event,
        ]);
    }
    public function show($id)
    {
        $event = EventsMaster::findOrFail($id);
        return response()->json([
            'event' => $event
        ]);
    }
     public function destroy($id)
    {
        $events = EventsMaster::find($id);

        if (!$events) {
            return response()->json(['success' => false, 'message' => 'Events not found.'], 404);
        }

        $events->delete();

        return response()->json(['success' => true, 'message' => 'Events deleted successfully.']);
    }

}
