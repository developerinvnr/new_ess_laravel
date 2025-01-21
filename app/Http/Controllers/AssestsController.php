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
    ->whereNotIn ('hrm_asset_name_emp.AssetNId', [11, 12, 18]) // Filter for specific AssetNId values
    ->select('hrm_asset_name_emp.*', 'hrm_asset_name.*')  // Select all columns from both tables
    ->get();


    $mobileeligibility = \DB::table('hrm_employee_eligibility')
        ->select('Mobile_Hand_Elig','Mobile_Hand_Elig_Rs','GPSSet')
        ->where('EmployeeID',$employeeId)
        ->where('Status','A')
        ->first();
    $AssetRequest = AssetRequest::where('EmployeeID', $employeeId)->get(); // Fetches all records where EmployeeID matches
    
    $assets_requestss = \DB::table('hrm_asset_employee_request')
    ->join('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')
    ->leftJoin('hrm_employee', 'hrm_asset_employee_request.EmployeeID', '=', 'hrm_employee.EmployeeID')
    ->where(function ($query) use ($employeeId) {
        $query->where('ReportingId', $employeeId)
              ->orWhere('HodId', $employeeId);
    })
    ->when(true, function ($query) use ($employeeId) {
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('ITId', $employeeId)
                     ->where('HODApprovalStatus', 2);
        });
    })
    ->when(true, function ($query) use ($employeeId) {
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('AccId', $employeeId)
                     ->where('HODApprovalStatus', 2)
                     ->where('ITApprovalStatus', 2);
        });
    })
    ->where(function ($query) {
        $query->where('hrm_employee.EmpStatus', 'A')
              ->orWhereNull('hrm_employee.EmpStatus');
    })
    
    ->select('hrm_asset_employee_request.*', 'hrm_asset_name.AssetName', 'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.Lname','hrm_employee.EmpCode')
    ->orderBy('hrm_asset_employee_request.ReqDate', 'desc') // Sort by ReqDate in descending order to get the most recent request
    ->get();

    // Fetch the most recent request for the employee with AssetNId in [11, 12, 18]
    $assets_request_mobile = \DB::table('hrm_asset_employee_request')
    ->select('hrm_asset_employee_request.AssetNId', 'hrm_asset_employee_request.ReqDate', 'hrm_asset_employee_request.ReqAmt')
    ->whereIn('hrm_asset_employee_request.AssetNId', [11, 12, 18])  // Filter for specific AssetNId values
    ->where('EmployeeID', $employeeId)
    ->orderBy('ReqDate', 'desc') // Sort by ReqDate in descending order to get the most recent request
    ->first(); // Get only the most recent record
    $mobileeliprice = null;
    // Calculate amount to be subtracted if GPSSet is 'N' and if certain assets are requested
            if ($mobileeligibility && ($mobileeligibility->GPSSet === 'N'|| $mobileeligibility->GPSSet === '')) {
                if($assets_request_mobile){
                    // Check if the asset ID is in the list [11, 12, 18]
                    if (in_array($assets_request_mobile->AssetNId, [11, 12, 18])) {
                        
                        // Get the current date and calculate the date 2 years ago
                        $currentDate = now();
                        $twoYearsAgo = $currentDate->subYears(2);

                        // Check if ReqDate is within the last 2 years
                        if ($assets_request_mobile->ReqDate >= $twoYearsAgo) {
                            // Perform the subtraction of Mobile_Hand_Elig_Rs from ReqAmt if the request is within 2 years
                            $mobileeliprice = $mobileeligibility->Mobile_Hand_Elig_Rs - $assets_request_mobile->ReqAmt ;
                        } else {
                            // If the request date is outside the 2 years window, keep the original amount
                            $mobileeliprice = $assets_request_mobile->ReqAmt;
                        }
                    }
                    
                }
                }
        


        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $employeeId)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists
    // Pass assets_request and assets to the view

    return view('employee.assests', compact('assets', 'assets_requestss','AssetRequest','exists','mobileeligibility','mobileeliprice'));
}


}
