<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function profile()
    {
        $employeeId = Auth::user()->EmployeeID; // The EmployeeID you're fetching data for

        $employeeDataDuration = \DB::table('hrm_employee_general as eg')
            ->join('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
            ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentID')
            ->join('hrm_company_basic as cb', 'e.CompanyId', '=', 'cb.CompanyId')
            ->select('e.EmployeeID', 'eg.DateJoining', 'e.DateOfSepration', 'eg.DepartmentId', 'd.DepartmentName', 'e.CompanyID', 'cb.CompanyName')
            ->where('e.EmployeeID', $employeeId)
            ->first();
              // Format the dates as dd-mm-yyyy
              // Format the dates as 'M Y' (e.g., Jan 2020)
    $employeeDataDuration->DateJoining = \Carbon\Carbon::parse($employeeDataDuration->DateJoining)->format('M Y');
    $employeeDataDuration->DateOfSepration = \Carbon\Carbon::parse($employeeDataDuration->DateOfSepration)->format('M Y');
        $separationRecord = \DB::table('hrm_employee_separation')->where('EmployeeID', $employeeId)->first();
        if ($separationRecord) {
            return view('seperation.profile',compact('employeeDataDuration')); // Adjust the view name as needed
        }

        return view('employee.profile',compact('employeeDataDuration')); // Adjust the view name as needed
    }
}
