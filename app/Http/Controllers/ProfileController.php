<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ProfileController extends Controller
{
    public function profile()
{
    $employeeId = Auth::user()->EmployeeID; // The EmployeeID you're fetching data for

    // Fetch employee data for the profile
    $employeeDataDuration = \DB::table('hrm_employee_general as eg')
        ->join('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
        ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentID')
        ->join('hrm_company_basic as cb', 'e.CompanyId', '=', 'cb.CompanyId')
        ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
        ->select('e.EmployeeID', 'eg.DateJoining', 'e.DateOfSepration', 'eg.DepartmentId', 'd.DepartmentName','v.VerticalName', 
        'e.CompanyID', 'cb.CompanyName')
        ->where('e.EmployeeID', $employeeId)
        ->first();

    // Format the dates as 'M Y' (e.g., Jan 2020)
    $employeeDataDuration->DateJoining = \Carbon\Carbon::parse($employeeDataDuration->DateJoining)->format('M Y');
    $employeeDataDuration->DateOfSepration = \Carbon\Carbon::parse($employeeDataDuration->DateOfSepration)->format('M Y');
        // Fetch the DateJoining of the employee
        // $employeeData = \DB::table('hrm_employee_general')
        // ->where('EmployeeID', $employeeId)
        // ->select('DateJoining',)
        // ->first();

        $employeeData = \DB::table('hrm_employee_general')
    ->join('hrm_headquater', 'hrm_employee_general.HqId', '=', 'hrm_headquater.HqId')  // Join with the hrm_headquater table
    ->where('hrm_employee_general.EmployeeID', $employeeId)
    ->select('hrm_employee_general.DateJoining', 'hrm_headquater.HqName')  // Select DateJoining and HqName
    ->first();
    $hqname=$employeeData->HqName;


    if ($employeeData) {
        // Parse the DateJoining
        $dateJoined = \Carbon\Carbon::parse($employeeData->DateJoining);
        $currentDate = \Carbon\Carbon::now();
    
        // Get the difference in years and months
        $diff = $dateJoined->diff($currentDate);
    
        // Extract years and months
        $years = $diff->y;  // Years
        $months = $diff->m;  // Months
    
        // You can format this as needed
        $experience = "{$years} years {$months} months";
    
        // Optional: If you want the total as a float (years and months as a decimal, like 4.777)
        $totalYears = $years + ($months / 12);  // Convert months to fraction of a year
    
        // Round the total years if needed (e.g., 4.777)
        $roundedYears = round($totalYears, 2);
    
        // Debugging
        
    }

   
  // Fetch the appraisal history of the employee
  $appraisalHistory = DB::table('hrm_pms_appraisal_history')
  ->where('EmployeeID', $employeeId)
  ->orderBy('SalaryChange_Date', 'asc') // Order by the salary change date
  ->get();

// Group by grade and normalized, case-insensitive designation
$groupedData = collect($appraisalHistory)->groupBy(function ($item) {
  // Normalize designation: lowercase and replace multiple spaces with a single space
  $normalizedDesignation = preg_replace('/\s+/', ' ', strtolower(trim($item->Current_Designation)));
  return $item->Current_Grade . '-' . $normalizedDesignation;  // Combine grade and normalized designation as a key
});

$finalResult = [];

// Process each group of grade and designation
foreach ($groupedData as $key => $items) {
  $startDate = null;
  $endDate = null;

  // Iterate over the items in each group and determine the date range
  foreach ($items as $index => $item) {
      if ($startDate === null) {
          // Set start date for the first record in the group
          $startDate = $item->SalaryChange_Date;
      }

      // Set the end date as the most recent salary change date
      $endDate = $item->SalaryChange_Date;
  }

  // After processing all items for this group, push the result to $finalResult
  $finalResult[] = [
      'Current_Grade' => $items->first()->Current_Grade,
      'Current_Designation' => $items->first()->Current_Designation,
      'SalaryChange_Date' => \Carbon\Carbon::parse($startDate)->format('d-m-Y') . ' To ' . \Carbon\Carbon::parse($endDate)->format('d-m-Y'),  // Format as dd-mm-yyyy
    ];
}

    return view('employee.profile', compact('employeeDataDuration', 'finalResult','years','hqname','experience', 'totalYears', 'roundedYears'));
}
}
