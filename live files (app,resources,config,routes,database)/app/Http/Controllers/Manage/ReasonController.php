<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\ReasonMaster;
class ReasonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Deactive',
        ]);

        $reason = ReasonMaster::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reason added successfully!',
            'reason' => $reason,
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Deactive',
        ]);

        $reason = ReasonMaster::findOrFail($id);
        $reason->update($request->only('name', 'status'));

        return response()->json(['reason' => $reason]);
    }
      public function destroy($id)
    {
        $reasons = ReasonMaster::find($id);

        if (!$reasons) {
            return response()->json(['success' => false, 'message' => 'Reasons not found.'], 404);
        }

        $reasons->delete();

        return response()->json(['success' => true, 'message' => 'Reasons deleted successfully.']);
    }


}
