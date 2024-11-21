<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetName;
use App\Models\AssetsEmployeeCondition;
use App\Models\AssetRequest;
use Illuminate\Support\Facades\Auth;

class AssestsController extends Controller
{
    public function assests()
{
    // Get the authenticated user's EmployeeID
    $employeeId = Auth::user()->EmployeeID;

    // Fetch all asset names from the 'AssetName' table
    $assets = \DB::table('hrm_asset_name_emp')
    ->leftJoin('hrm_asset_name', 'hrm_asset_name_emp.AssetNId', '=', 'hrm_asset_name.AssetNId')
    ->where('hrm_asset_name_emp.EmployeeID', $employeeId)
    ->select('hrm_asset_name_emp.*', 'hrm_asset_name.*')  // Select all columns from both tables
    ->get();
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
        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $employeeId)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists

    // Pass assets_request and assets to the view
    return view('employee.assests', compact('assets', 'assets_request','AssetRequest','exists'));
}


}
