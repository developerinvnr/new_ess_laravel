<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        // Fetch the notification
        $notification = DB::table('notification')->where('id', $id)->first();

        if ($notification) {
            // Update the notification status to read
            DB::table('notification')
                ->where('id', $id)
                ->update(['notification_read' => 1]);

            // Redirect to the notification link
            return redirect()->to($notification->notification_link);
        }

        // Redirect back if the notification does not exist
        return redirect()->back()->with('error', 'Notification not found.');
    }
}
