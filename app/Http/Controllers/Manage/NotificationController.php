<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\NotificationMaster;

class NotificationController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'noti' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:Active,Deactive',
        ]);

        $notification = NotificationMaster::create([
            'name' => $request->name,
            'notification_type' => $request->noti,
            'message' => $request->message,
            'status' => $request->status,
        ]);

        // Return JSON for AJAX
        return response()->json($notification);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification = NotificationMaster::findOrFail($id);

        $notification->name = $request->name;
        $notification->type = $request->type;
        $notification->status = $request->status;
        $notification->message = $request->message;
        $notification->save();

        return response()->json([
            'id' => $notification->id,
            'name' => $notification->name,
            'type' => $notification->type,
            'status' => $notification->status,
            'message' => $notification->message,
        ]);
    }
    public function destroy($id)
    {
        $notification = NotificationMaster::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }


}
