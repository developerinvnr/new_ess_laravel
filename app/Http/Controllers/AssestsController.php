<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetName;
use App\Models\AssetRequest;
use Illuminate\Support\Facades\Auth;

class AssestsController extends Controller
{
    public function assests()
{
    // Get the authenticated user's EmployeeID
    $employeeId = Auth::user()->EmployeeID;

    // Fetch all asset names from the 'AssetName' table
    $assets = AssetName::all();  // This fetches all records
    $AssetRequest = AssetRequest::where('EmployeeID', $employeeId)->get(); // Fetches all records where EmployeeID matches

    // Fetch the asset requests based on the employee's role (Reporting, Hod, IT, Acc)
    $assets_request = \DB::table('hrm_asset_employee_request')
    ->where(function ($query) use ($employeeId) {
        // Base condition for ReportingId and HodId
        $query->where('ReportingId', $employeeId)
              ->orWhere('HodId', $employeeId);
    })
    ->when(true, function ($query) use ($employeeId) {
        // Add ITId condition only if HODApprovalStatus = 1
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('ITId', $employeeId)
                     ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
        });
    })
    ->when(true, function ($query) use ($employeeId) {
        // Add AccId condition only if HODApprovalStatus = 1 and ITApprovalStatus = 1
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('AccId', $employeeId)
                     ->where('HODApprovalStatus', 1)  // Include AccId only when HODApprovalStatus = 1
                     ->where('ITApprovalStatus', 1); // Include AccId only when ITApprovalStatus = 1
        });
    })
    ->get();

    // Loop through the requests to fetch the associated employee name based on EmployeeID
    foreach ($assets_request as $request) {
        // Fetch the associated employee name using the EmployeeID from the request
        $employee = \DB::table('hrm_employee')->where('EmployeeID', $request->EmployeeID)->first();
        
        // If employee exists, concatenate the name (Fname, Sname, Lname)
        $employeeName = $employee ? $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname : 'N/A';
        
        // Attach the employee name to the request object
        $request->employee_name = $employeeName;
    }

    // Pass assets_request and assets to the view
    return view('employee.assests', compact('assets', 'assets_request','AssetRequest'));
}


}
