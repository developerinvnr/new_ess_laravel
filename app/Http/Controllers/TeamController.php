<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaySlip;
use App\Models\EmployeeGeneral;
use App\Models\Employee;
use App\Models\AttendanceRequest;
use App\Models\EmployeeSeparation;
use App\Models\EmployeeSeparationNocDeptEmp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class TeamController extends Controller
{
    public function team(Request $request)
    {
    $EmployeeID = Auth::user()->EmployeeID;
    $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        if($isHodView){

            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
            $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            $attendanceData = [];

            foreach ($employeeChain as $employee) {
                $employee->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;

                $attendance = \DB::table('hrm_employee_attendance')
                ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee


                $employeeDetails = \DB::table('hrm_employee as e')
                        ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                        ->join('hrm_designation as d', 'eg.DesigId', '=', 'd.DesigId')  // Join to fetch DesigName
                        ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
                        ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
                        ->leftJoin('hrm_department as dp', 'eg.DepartmentId', '=', 'dp.DepartmentId')  // Left Join to fetch DepartmentName
                        ->where('e.EmployeeID', $employee->EmployeeID)
                        ->where('e.EmpStatus', 'A')

                        ->select(
                            'e.*', 
                            'eg.*', 
                            'd.DesigCode', 
                            'v.VerticalName', 
                            'g.GradeValue', 
                            'dp.DepartmentCode'  // Select DepartmentName from hrm_department
                        )  // Select all columns from e, eg, and the additional columns
                        ->get(); 
                           // If the employee has data, check if they have a team
                           if ($employeeDetails->isNotEmpty()) {
                            // Append hasTeam property
                            $employeeDetails->first()->hasTeam = $this->checkIfEmployeeHasTeam($employee->EmployeeID);
                        } else {
                            // If no data found, set hasTeam to false (or handle accordingly)
                            $employeeDetails->hasTeam = false;
                        }
                        
                        // Fetch the results (array of objects)
                $currentYear = now()->year;  // Get the current year
                $currentMonth = now()->month;  // Get the current month

                // Fetch attendance data for all employees in the current month and year
                $attendanceSummary = \DB::table('hrm_employee_attendance')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                    ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                    ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                    
                    ->select(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode',
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
                    )  // Select the required fields and counts for each attendance value
                    ->groupBy(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode'
                    )
                    ->get();  // Execute the query and get the results
                    $leaveApplications = \DB::table('hrm_employee_applyleave')
                    ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                    ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                    ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                    ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                    ->where('hrm_employee_applyleave.LeaveStatus', '!=', '1')
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname','hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                    ->get();

                    $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('0')  // Assuming 0 means pending requests
                    ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                    ->select(
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        'hrm_employee.EmployeeID',
                        'hrm_employee_attendance_req.*'
                    )
                    ->get();

                    
                    $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                            ->join('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
                            ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                            ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
                            ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
                            ->select(
                                'hrm_employee_monthlyleave_balance.EmployeeID',
                                'hrm_employee_monthlyleave_balance.OpeningCL',
                                'hrm_employee_monthlyleave_balance.AvailedCL',
                                'hrm_employee_monthlyleave_balance.BalanceCL',
                                'hrm_employee_monthlyleave_balance.OpeningSL',
                                'hrm_employee_monthlyleave_balance.AvailedSL',
                                'hrm_employee_monthlyleave_balance.BalanceSL',
                                'hrm_employee_monthlyleave_balance.OpeningPL',
                                'hrm_employee_monthlyleave_balance.AvailedPL',
                                'hrm_employee_monthlyleave_balance.BalancePL',
                                'hrm_employee_monthlyleave_balance.OpeningEL',
                                'hrm_employee_monthlyleave_balance.AvailedEL',
                                'hrm_employee_monthlyleave_balance.BalanceEL',
                                'hrm_employee_monthlyleave_balance.OpeningOL',
                                'hrm_employee_monthlyleave_balance.AvailedOL',
                                'hrm_employee_monthlyleave_balance.BalanceOL',
                                'hrm_employee_monthlyleave_balance.EC',
                                'hrm_employee.Fname',
                                'hrm_employee.Sname',
                                'hrm_employee.EmpCode'
                            )
                            ->get();

                $attendanceData[] = [
                    'attendance' => $attendance,
                    'attendanceSummary'=>$attendanceSummary,
                    'leaveApplications'=>$leaveApplications,
                    'leaveBalances'=>$leaveBalances,
                    'attendnacerequest'=>$requestsAttendnace,
                ];
                $employeeData[] = $employeeDetails;

            }
            return view("employee.team",compact('employeeData','attendanceData','isReviewer'));

        }

        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $EmployeeID)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists
        if($exists){
            $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();  // Get all employees reporting to the RepEmployeeID
            $attendanceData = [];
            $employeeData = [];    // Array to store employee data for all employees

            foreach ($employeesReportingTo as $employee) {
                $attendance = \DB::table('hrm_employee_attendance')
                ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee


                $employeeDetails = \DB::table('hrm_employee as e')
                        ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                        ->join('hrm_designation as d', 'eg.DesigId', '=', 'd.DesigId')  // Join to fetch DesigName
                        ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
                        ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
                        ->leftJoin('hrm_department as dp', 'eg.DepartmentId', '=', 'dp.DepartmentId')  // Left Join to fetch DepartmentName
                        ->where('e.EmployeeID', $employee->EmployeeID)
                        ->where('e.EmpStatus', 'A')

                        ->select(
                            'e.*', 
                            'eg.*', 
                            'd.DesigCode', 
                            'v.VerticalName', 
                            'g.GradeValue', 
                            'dp.DepartmentCode'  // Select DepartmentName from hrm_department
                        )  // Select all columns from e, eg, and the additional columns
                        ->get(); 
                        
                        // Fetch the results (array of objects)
                $currentYear = now()->year;  // Get the current year
                $currentMonth = now()->month;  // Get the current month

                // Fetch attendance data for all employees in the current month and year
                $attendanceSummary = \DB::table('hrm_employee_attendance')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                    ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                    ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                    
                    ->select(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode',
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
                    )  // Select the required fields and counts for each attendance value
                    ->groupBy(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode'
                    )
                    ->get();  // Execute the query and get the results
                    $leaveApplications = \DB::table('hrm_employee_applyleave')
                    ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                    ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                    ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                    ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                    ->where('hrm_employee_applyleave.LeaveStatus', '!=', '1')
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                    ->get();

                    $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('0')  // Assuming 0 means pending requests
                    ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                    ->select(
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        'hrm_employee.EmployeeID',
                        'hrm_employee_attendance_req.*'
                    )
                    ->get();
                    
                    $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                            ->join('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
                            ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                            ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
                            ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
                            ->select(
                                'hrm_employee_monthlyleave_balance.EmployeeID',
                                'hrm_employee_monthlyleave_balance.OpeningCL',
                                'hrm_employee_monthlyleave_balance.AvailedCL',
                                'hrm_employee_monthlyleave_balance.BalanceCL',
                                'hrm_employee_monthlyleave_balance.OpeningSL',
                                'hrm_employee_monthlyleave_balance.AvailedSL',
                                'hrm_employee_monthlyleave_balance.BalanceSL',
                                'hrm_employee_monthlyleave_balance.OpeningPL',
                                'hrm_employee_monthlyleave_balance.AvailedPL',
                                'hrm_employee_monthlyleave_balance.BalancePL',
                                'hrm_employee_monthlyleave_balance.OpeningEL',
                                'hrm_employee_monthlyleave_balance.AvailedEL',
                                'hrm_employee_monthlyleave_balance.BalanceEL',
                                'hrm_employee_monthlyleave_balance.OpeningOL',
                                'hrm_employee_monthlyleave_balance.AvailedOL',
                                'hrm_employee_monthlyleave_balance.BalanceOL',
                                'hrm_employee_monthlyleave_balance.EC',
                                'hrm_employee.Fname',
                                'hrm_employee.Sname',
                                'hrm_employee.EmpCode'
                            )
                            ->get();
                        // If the employee has data, check if they have a team
                        if ($employeeDetails->isNotEmpty()) {
                            // Append hasTeam property
                            $employeeDetails->first()->hasTeam = $this->checkIfEmployeeHasTeam($employee->EmployeeID);
                        } else {
                            // If no data found, set hasTeam to false (or handle accordingly)
                            $employeeDetails->hasTeam = false;
                        }

                $attendanceData[] = [
                    'attendance' => $attendance,
                    'attendanceSummary'=>$attendanceSummary,
                    'leaveApplications'=>$leaveApplications,
                    'leaveBalances'=>$leaveBalances,
                    'attendnacerequest'=>$requestsAttendnace,
                ];
                $employeeData[] = $employeeDetails;


            }

        }
            // Fetch the asset requests based on the employee's role (Reporting, Hod, IT, Acc)
        $assets_request = \DB::table('hrm_asset_employee_request')
        ->where(function ($query) use ($EmployeeID) {
            // Base condition for ReportingId and HodId
            $query->where('ReportingId', $EmployeeID)
                ->orWhere('HodId', $EmployeeID);
        })
        ->when(true, function ($query) use ($EmployeeID) {
            // Add ITId condition only if HODApprovalStatus = 1
            $query->orWhere(function ($subQuery) use ($EmployeeID) {
                $subQuery->where('ITId', $EmployeeID)
                        ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
            });
        })
        ->when(true, function ($query) use ($EmployeeID) {
            // Add AccId condition only if HODApprovalStatus = 1 and ITApprovalStatus = 1
            $query->orWhere(function ($subQuery) use ($EmployeeID) {
                $subQuery->where('AccId', $EmployeeID)
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
            // Step 2: Fetch the Employee model instance using the EmployeeID
            // $employee = Employee::find($EmployeeID);

            // // Step 3: Ensure that the employee exists before calling the method
            // if ($employee) {
            //     // Step 4: Call the getReportsHierarchy() method to get the employee hierarchy
            // // $employeeChain = $employee->getReportingHierarchy($EmployeeID);

            // } else {
            //     // Handle the case where the employee does not exist
            //     dd('Employee not found!');
            // }
             // Check if the current user is a reviewer in the hrm_employee_reporting table
                $isReviewer = \DB::table('hrm_employee_reporting')
                ->where('ReviewerId', Auth::user()->EmployeeID)
                ->exists();  // Returns true if the EmployeeID is found in ReviewerID
  
        return view("employee.team",compact('employeeData','exists','assets_request','attendanceData','isReviewer'));
    }
            // Method to check if an employee has any team members
        private function checkIfEmployeeHasTeam($employeeID)
        {
            // Query to check if the employee has any team members in the 'hrm_general' table
            return DB::table('hrm_employee_general')
                ->where('RepEmployeeID', $employeeID)  // Assuming 'ReportingTo' refers to the employee ID
                ->exists();
        }
    public function getEmployeeReportingChain($EmployeeID, &$processed = [])
    {
        // Check if the current employee has already been processed
        if (in_array($EmployeeID, $processed)) {
            return [];
        }
    
        // Mark this employee as processed
        $processed[] = $EmployeeID;
    
        // Get all employees who report to the given EmployeeID
        $employeesReportingTo = DB::table('hrm_employee_general')
        ->join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the hrm_employee table
        ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)  // Filter by RepEmployeeID
        ->where('hrm_employee.EmpStatus', 'A')  // Only select employees with EmpStatus = 'A'
        ->get();  // Fetch the results
    
        // Initialize an array to hold the reporting chain
        $chain = [];
    
        // Loop through each employee found and recursively get the chain
        foreach ($employeesReportingTo as $employee) {
            // Add the employee to the chain
            $chain[] = $employee;
    
            // Recursively find employees reporting to the current employee
            $subChain = $this->getEmployeeReportingChain($employee->EmployeeID, $processed);
    
            // Merge the sub-chain into the main chain
            $chain = array_merge($chain, $subChain);
        }
    
        // Return the full chain of reporting employees
        return $chain;
    }
    
    public function getEmployeeTeam($employeeID)
    {
        // Fetch employees reporting to the given EmployeeID
        $team = DB::table('hrm_employee_general')
                  ->join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                  ->where('hrm_employee_general.RepEmployeeID', $employeeID)
                  ->select('hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.Lname','hrm_employee.EmployeeID')  // Adjust based on what fields you need
                  ->get();
    
        // Return the data as JSON response
        return response()->json(['team' => $team]);
    }
    
    public function teamtrainingsep(Request $request){
        $EmployeeID =Auth::user()->EmployeeID;
        $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID


        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $trainingData = \DB::table('hrm_company_training_participant as ctp')
            ->join('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId')
            ->join('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID')
            ->whereIn('ctp.EmployeeID', $employeeIds)
            ->where('e.EmpStatus', 'A')
            ->select('ct.*', 'e.Fname', 'e.Lname', 'e.Sname')
            ->get();

        // Group the data by employee full name (Fname + Lname + Sname)
        $groupedTrainingData = $trainingData->groupBy(function($item) {
            return $item->Fname . ' ' . $item->Lname . ' ' . $item->Sname;
        });

        // Sort the grouped data alphabetically by the employee name (keys)
        $groupedTrainingData = $groupedTrainingData->sortKeys();

        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked

        // Get the employee IDs under the same team (where RepEmployeeID matches current user)
        // $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        if($isHodView){
            $employeeChain = collect($this->getEmployeeReportingChain($EmployeeID)); // Convert to collection
            // Now you can use pluck to get the EmployeeID
            $employeeIds = $employeeChain->pluck('EmployeeID'); 
          
            $trainingData = \DB::table('hrm_company_training_participant as ctp')
            ->join('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId')
            ->join('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID')
            ->whereIn('ctp.EmployeeID', $employeeIds)
            ->where('e.EmpStatus', 'A')
            ->select('ct.*', 'e.Fname', 'e.Lname', 'e.Sname')
            ->get();

        // Group the data by employee full name (Fname + Lname + Sname)
        $groupedTrainingData = $trainingData->groupBy(function($item) {
            return $item->Fname . ' ' . $item->Lname . ' ' . $item->Sname;
        });

        // Sort the grouped data alphabetically by the employee name (keys)
        $groupedTrainingData = $groupedTrainingData->sortKeys();
            return view('employee.teamtrainingsep',compact('groupedTrainingData','isReviewer'));
    
            
            }  
   
        return view('employee.teamtrainingsep',compact('groupedTrainingData','isReviewer'));

    }
    public function teameligibility(Request $request){
        $EmployeeID =Auth::user()->EmployeeID;
        $eligibilityData = [];
        $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID


        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        if($isHodView){
            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);

            foreach ($employeeChain as $employee) {
                // DD($employee);
               //$employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        // $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
        // ->where('hrm_employee.empstatus', 'A')
        // ->where('hrm_employee_general.RepEmployeeID', $employee->EmployeeID)
        // ->pluck('hrm_employee_general.EmployeeID');

        $eligibilitydata = \DB::table('hrm_employee_eligibility as ee')
        ->join('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
        ->join('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID') // Join with employee general table
        ->join('hrm_designation as d', 'd.DesigId', '=', 'eg.DesigId') // Join with the designation table
        ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
        ->join('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table to fetch net, gross, and deductions
        ->where('ee.EmployeeID', $employee->EmployeeID)
        ->where('e.EmpStatus', 'A')
        ->where("ctc.Status",'=','A')
        ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
        ->select(
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.EmpCode',
            'd.DesigName',
            'g.GradeValue', 
            'eg.DesigId', // Include designation ID
            'd.DesigCode', // Fetch the designation name from the designation table
            'ee.*', // Fetch all columns from hrm_employee_eligibility
            'ctc.NetMonthSalary_Value as NetSalary', // Fetch Net Salary from CTC table
            'ctc.Tot_GrossMonth as GrossSalary', // Fetch Gross Salary from CTC table
             'ctc.Tot_CTC as TotalCTC'
         )
        ->get();
        
        $eligibility[] = $eligibilitydata; // This will store eligibility data for each employee

            }
            return view('employee.teameligibility',compact('eligibility','isReviewer'));

        }
        //$employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                               ->where('hrm_employee.empstatus', 'A')
                               ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)
                               ->pluck('hrm_employee_general.EmployeeID');

                               $eligibilitydata = \DB::table('hrm_employee_eligibility as ee')
                               ->join('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
                               ->join('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID') // Join with employee general table
                               ->join('hrm_designation as d', 'd.DesigId', '=', 'eg.DesigId') // Join with the designation table
                               ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
                               ->join('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table to fetch net, gross, and deductions
                               ->whereIn('ee.EmployeeID', $employeeIds)
                               ->where('e.EmpStatus', 'A')
                               ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
                               ->where("ctc.Status",'=','A')
                               ->select(
                                   'e.Fname',
                                   'e.Lname',
                                   'e.Sname',
                                   'e.EmpCode',
                                   'd.DesigName',
                                   'g.GradeValue', 
                                   'eg.DesigId', // Include designation ID
                                   'd.DesigCode', // Fetch the designation name from the designation table
                                   'ee.*', // Fetch all columns from hrm_employee_eligibility
                                   'ctc.NetMonthSalary_Value as NetSalary', // Fetch Net Salary from CTC table
                                   'ctc.Tot_GrossMonth as GrossSalary', // Fetch Gross Salary from CTC table
                                    'ctc.Tot_CTC as TotalCTC'
                                )
                               ->get();
        $eligibility[] = $eligibilitydata; // This will store eligibility data for each employee

                           

// Get current month and year
$currentMonth = Carbon::now()->format('m');  // Current month in 'mm' format
$currentYear = Carbon::now()->format('Y');  // Current year in 'yyyy' format
// Fetch the monthly payslip data for the current month and year
$monthlyPayslip = \DB::table('hrm_employee_monthlypayslip as ems')
    ->join('hrm_employee as e', 'e.EmployeeID', '=', 'ems.EmployeeID')  // Join with the employee table
    ->join('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID')  // Join with the employee general table
    ->join('hrm_designation as d', 'd.DesigId', '=', 'eg.DesigId')  // Join with the designation table
    ->whereMonth('ems.Month', '=', $currentMonth)  // Filter by the current month
    ->whereYear('ems.Year', '=', $currentYear)  // Filter by the current year
    ->whereIn('ems.EmployeeID', $employeeIds)  // Fetch data for specific employees
    ->select(
        'e.Fname',
        'e.Lname',
        'e.Sname',
        'e.empcode',
        'eg.DesigId',
        'd.DesigName',
        'ems.*'  // All fields from the monthly payslip table
    )
    ->get();
    return view('employee.teameligibility',compact('eligibility','isReviewer'));


    }

    // public function teamassets(){
    //     return view('employee.teamassets');


    // }
    public function teamassets(Request $request)
    {
    $EmployeeID = Auth::user()->EmployeeID;
    $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
    $isReviewer = \DB::table('hrm_employee_reporting')
    ->where('ReviewerId', $EmployeeID)
    ->exists();  // Returns true if the EmployeeID is found in ReviewerID

    $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();
        if($isHodView){

            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
            $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            $attendanceData = [];

            foreach ($employeeChain as $employee) {
                $empid = $employee->EmployeeID;
                
                // Fetch asset requests based on the employee's role (Reporting, Hod, IT, Acc)
                $assets_request = DB::table('hrm_asset_employee_request')
                    // Join with the hrm_employee table to filter by EmpStatus
                    ->join('hrm_employee as e', 'hrm_asset_employee_request.EmployeeID', '=', 'e.EmployeeID')
                    // Apply the condition to only select active employees
                    ->where('e.EmpStatus', 'A')
                    // Fetch asset requests for employees with the given role IDs
                    ->where(function ($query) use ($empid) {
                        $query->where('ReportingId', $empid)
                            ->orWhere('HodId', $empid);
                    })
                    ->when(true, function ($query) use ($empid) {
                        $query->orWhere(function ($subQuery) use ($empid) {
                            $subQuery->where('ITId', $empid)
                                ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
                        });
                    })
                    ->when(true, function ($query) use ($empid) {
                        $query->orWhere(function ($subQuery) use ($empid) {
                            $subQuery->where('AccId', $empid)
                                ->where('HODApprovalStatus', 1)
                                ->where('ITApprovalStatus', 1); // Include AccId only when HODApprovalStatus = 1 and ITApprovalStatus = 1
                        });
                    })
                    ->get();

                // Loop through the asset requests to fetch the associated employee name based on EmployeeID
                foreach ($assets_request as $request) {
                    // Ensure the employee fetched is active
                    $employee = DB::table('hrm_employee')
                        ->where('EmployeeID', $request->EmployeeID)
                        ->where('EmpStatus', 'A')  // Ensure only active employees are considered
                        ->first();

                    // If employee is found and is active, add the employee name to the request
                    if ($employee) {
                        $employeeName = $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname;
                        $request->employee_name = $employeeName;
                    } else {
                        // If no active employee is found, set the employee name as 'N/A'
                        $request->employee_name = 'N/A';
                    }
                }
            }
            return view("employee.teamassets",compact('assets_request','isReviewer'));

        }

        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $EmployeeID)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists
            if($exists){
                foreach ($employeesReportingTo as $employee) {
                    $empid = $employee->EmployeeID;
                
                                $assets_request = DB::table('hrm_asset_employee_request')
                        // Join with the hrm_employee table to filter by EmpStatus
                        ->join('hrm_employee as e', 'hrm_asset_employee_request.EmployeeID', '=', 'e.EmployeeID')
                        // Apply the condition to only select active employees
                        ->where('e.EmpStatus', 'A')
                        // Fetch asset requests for employees with the given role IDs
                        ->where(function ($query) use ($empid) {
                            $query->where('ReportingId', $empid)
                                ->orWhere('HodId', $empid);
                        })
                        ->when(true, function ($query) use ($empid) {
                            $query->orWhere(function ($subQuery) use ($empid) {
                                $subQuery->where('ITId', $empid)
                                    ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
                            });
                        })
                        ->when(true, function ($query) use ($empid) {
                            $query->orWhere(function ($subQuery) use ($empid) {
                                $subQuery->where('AccId', $empid)
                                    ->where('HODApprovalStatus', 1)
                                    ->where('ITApprovalStatus', 1); // Include AccId only when HODApprovalStatus = 1 and ITApprovalStatus = 1
                            });
                        })
                        ->get();

                    // Loop through the asset requests to fetch the associated employee name based on EmployeeID
                    foreach ($assets_request as $request) {
                        // Ensure the employee fetched is active
                        $employee = DB::table('hrm_employee')
                            ->where('EmployeeID', $request->EmployeeID)
                            ->where('EmpStatus', 'A')  // Ensure only active employees are considered
                            ->first();

                        // If employee is found and is active, add the employee name to the request
                        if ($employee) {
                            $employeeName = $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname;
                            $request->employee_name = $employeeName;
                        } else {
                            // If no active employee is found, set the employee name as 'N/A'
                            $request->employee_name = 'N/A';
                        }
                    }
                    
                }
            }

                return view("employee.teamassets",compact('assets_request','isReviewer'));
            }
    public function teamquery(){
        
        $isReviewer = \DB::table('hrm_employee_reporting')
                    ->where('ReviewerId', Auth::user()->EmployeeID)
                    ->exists();  // Returns true if the EmployeeID is found in ReviewerID

        return view('employee.teamquery',compact('isReviewer'));


    }
    public function getQueriesForUser(Request $request){
        $EmployeeID = Auth::user()->EmployeeID;
        // Get all employees reporting to the current employee (EmployeeID)
        $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();
    
        // Array to hold all queries
        $queriesteam = [];
        $isHodView = $request->hod_view; // This will be true if the checkbox is checked
       
        if($isHodView == '1'){
            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
            foreach ($employeeChain as $employee) {
    
                // Get queries assigned to employees who are reporting to the current employee
                $queries = \DB::table('hrm_employee_queryemp')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
                    ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID')
                    ->select(
                        'hrm_employee_queryemp.*',
                        'hrm_department.DepartmentName'
                    )
                    ->where('hrm_employee_queryemp.EmployeeID', $employee->EmployeeID) // Filter by the reporting employee's ID
                    ->whereNull('hrm_employee_queryemp.deleted_at') // Make sure the query is not deleted
                    ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by created date
                    ->get();
        
                // Check if there are queries for this employee
                if ($queries->isNotEmpty()) {
                    // Loop through the queries and get employee details for each
                    foreach ($queries as $query) {
                        // Get the employee details (First Name, Surname, Last Name) for the employee assigned to the query
                        $employeeDetails = \DB::table('hrm_employee')
                            ->where('EmployeeID', $query->EmployeeID)  // Match the EmployeeID from the query
                            ->select('Fname', 'Sname', 'Lname')  // Select the first name, surname, and last name
                            ->first(); // Use first() to get a single result
        
                        // Add the employee details to the query if available
                        if ($employeeDetails) {
                            $query->Fname = $employeeDetails->Fname;
                            $query->Sname = $employeeDetails->Sname;
                            $query->Lname = $employeeDetails->Lname;
                        }
        
                        // Add this query to the team queries array
                        $queriesteam[] = $query;
                    }
                }
            }
                            
            return response()->json($queriesteam); // Return data as JSON
        }
        if($isHodView == '0'){
            foreach ($employeesReportingTo as $employee) {
        
                // Get queries assigned to employees who are reporting to the current employee
                $queries = \DB::table('hrm_employee_queryemp')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
                    ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID')
                    ->select(
                        'hrm_employee_queryemp.*',
                        'hrm_department.DepartmentName'
                    )
                    ->where('hrm_employee_queryemp.EmployeeID', $employee->EmployeeID) // Filter by the reporting employee's ID
                    ->whereNull('hrm_employee_queryemp.deleted_at') // Make sure the query is not deleted
                    ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by created date
                    ->get();
        
                // Check if there are queries for this employee
                if ($queries->isNotEmpty()) {
                    // Loop through the queries and get employee details for each
                    foreach ($queries as $query) {
                        // Get the employee details (First Name, Surname, Last Name) for the employee assigned to the query
                        $employeeDetails = \DB::table('hrm_employee')
                            ->where('EmployeeID', $query->EmployeeID)  // Match the EmployeeID from the query
                            ->select('Fname', 'Sname', 'Lname')  // Select the first name, surname, and last name
                            ->first(); // Use first() to get a single result
        
                        // Add the employee details to the query if available
                        if ($employeeDetails) {
                            $query->Fname = $employeeDetails->Fname;
                            $query->Sname = $employeeDetails->Sname;
                            $query->Lname = $employeeDetails->Lname;
                        }
        
                        // Add this query to the team queries array
                        $queriesteam[] = $query;
                    }
                }
            }
        }
        return response()->json($queriesteam); // Return data as JSON


    }
    public function teamleaveatt(Request $request)
    {
        
        $EmployeeID = Auth::user()->EmployeeID;
        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        $currentYear = now()->year;
        $currentMonth = now()->month;
        
        // Capture the selected month from the request
        $selectedMonth = $request->input('month', $currentMonth); // Default to current month if no input
        
        // Calculate the month that is two months ago
        $twoMonthsBack = now()->subMonths(2)->month;
        
        // If the selected month is two months back, use the specific table for that year
        if ($selectedMonth <= $twoMonthsBack) {
            // Adjust the table to be specific to the year for two months back
            $attendanceTable = 'hrm_employee_attendance_' . $currentYear;
        } else {
            // Use the default attendance table
            $attendanceTable = 'hrm_employee_attendance';
        }

        // Calculate the number of days in the selected month
        $daysInMonth = Carbon::createFromDate($currentYear, $selectedMonth)->daysInMonth;
        $isReviewer = \DB::table('hrm_employee_reporting')
                    ->where('ReviewerId', Auth::user()->EmployeeID)
                    ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            $attendanceData = [];
            if($isHodView){
                $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
                foreach ($employeeChain as $employee) {
                    $attendance = \DB::table('hrm_employee_attendance')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                    ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                    ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                    ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                    ->get(); // Get attendance records for the employee

                    $requestsAttendnace_approved = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('1')  // Assuming 0 means pending requests
                    ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                    ->select(
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        'hrm_employee.EmployeeID',
                        'hrm_employee_attendance_req.*'
                    )
                    ->get();

                    $currentYear = now()->year;  // Get the current year
                    $currentMonth = now()->month;  // Get the current month

                    // Fetch attendance data for all employees in the current month and year
                    $attendanceSummary = \DB::table('hrm_employee_attendance')
                        ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                        ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                        ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
                        ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                        
                        ->select(
                            'hrm_employee_attendance.EmployeeID',
                            'hrm_employee.Fname',
                            'hrm_employee.Sname',
                            'hrm_employee.Lname',
                            'hrm_employee.EmpCode',
                            \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
                            \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
                            \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
                            \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
                        )  // Select the required fields and counts for each attendance value
                        ->groupBy(
                            'hrm_employee_attendance.EmployeeID',
                            'hrm_employee.Fname',
                            'hrm_employee.Sname',
                            'hrm_employee.Lname',
                            'hrm_employee.EmpCode'
                        )
                        ->get();  // Execute the query and get the results
                        $leaveApplications = \DB::table('hrm_employee_applyleave')
                        ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                        ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                        ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                        ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                        ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                        ->where('hrm_employee_applyleave.LeaveStatus', '!=', '1')
                        ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                        'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                        'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                        'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                        ->get();
                        $leaveApplications_approval = \DB::table('hrm_employee_applyleave')
                        ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                        ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                        ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                        ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                        ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                        ->where('hrm_employee_applyleave.LeaveStatus', '=', '1')
                        ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                        'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                        'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                        'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                        ->get();
                        $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                        ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                        ->whereStatus('0')  // Assuming 0 means pending requests
                        ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                        ->select(
                            'hrm_employee.Fname',
                            'hrm_employee.Lname',
                            'hrm_employee.Sname',
                            'hrm_employee.EmpCode',
                            'hrm_employee.EmployeeID',
                            'hrm_employee_attendance_req.*'
                        )
                        ->get();
                        
                            // Build the query for attendance details and balances
            $emploid = $employee->EmployeeID;

            $query = DB::table($attendanceTable . ' as a') // Dynamically set the table for attendance
                    ->join('hrm_employee_monthlyleave_balance as l', function($join) use ($selectedMonth, $currentYear, $emploid) {
                    $join->on('a.EmployeeID', '=', 'l.EmployeeID')
                        ->where('l.Month', '=', $selectedMonth)
                        ->where('l.Year', '=', $currentYear);
                })
                ->join('hrm_employee as e', 'a.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee
                ->where('a.EmployeeID', $emploid)
                ->where('e.EmpStatus', 'A')
                ->whereYear('a.AttDate', $currentYear)
                ->whereMonth('a.AttDate', $selectedMonth)
                ->select(
                    'a.EmployeeID',
                    'e.Fname',
                    'e.Lname',
                    'e.Sname',
                    'e.empcode',
                    'l.OpeningCL',
                    'l.OpeningPL',
                    'l.OpeningEL',
                    'l.OpeningOL',
                    'l.OpeningSL',
                    'l.BalanceCL',
                    'l.BalancePL',
                    'l.BalanceEL',
                    'l.BalanceOL',
                    'l.BalanceSL'
                );

            // Dynamically generate the CASE WHEN for each day of the month
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.AttValue END) AS day_$i"));
            }

            // Add totals for OD, A, P
            $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "OD" THEN 1 ELSE 0 END) AS total_OD'));
            $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "A" THEN 1 ELSE 0 END) AS total_A'));
            $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "P" THEN 1 ELSE 0 END) AS total_P'));

            // Group by necessary fields
            $query->groupBy(
                'a.EmployeeID',
                'e.Fname', 
                'e.Lname', 
                'e.Sname', 
                'e.empcode', 
                'l.OpeningCL',
                'l.OpeningPL',
                'l.OpeningEL',
                'l.OpeningOL',
                'l.OpeningSL',
                'l.BalanceCL',
                'l.BalancePL',
                'l.BalanceEL',
                'l.BalanceOL',
                'l.BalanceSL'
            );

            // Execute the query
            $empdataleaveattdata[] = $query->get();
                        
                        $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                                ->join('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
                                ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                                ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
                                ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
                                ->select(
                                    'hrm_employee_monthlyleave_balance.EmployeeID',
                                    'hrm_employee_monthlyleave_balance.OpeningCL',
                                    'hrm_employee_monthlyleave_balance.AvailedCL',
                                    'hrm_employee_monthlyleave_balance.BalanceCL',
                                    'hrm_employee_monthlyleave_balance.OpeningSL',
                                    'hrm_employee_monthlyleave_balance.AvailedSL',
                                    'hrm_employee_monthlyleave_balance.BalanceSL',
                                    'hrm_employee_monthlyleave_balance.OpeningPL',
                                    'hrm_employee_monthlyleave_balance.AvailedPL',
                                    'hrm_employee_monthlyleave_balance.BalancePL',
                                    'hrm_employee_monthlyleave_balance.OpeningEL',
                                    'hrm_employee_monthlyleave_balance.AvailedEL',
                                    'hrm_employee_monthlyleave_balance.BalanceEL',
                                    'hrm_employee_monthlyleave_balance.OpeningOL',
                                    'hrm_employee_monthlyleave_balance.AvailedOL',
                                    'hrm_employee_monthlyleave_balance.BalanceOL',
                                    'hrm_employee_monthlyleave_balance.EC',
                                    'hrm_employee.Fname',
                                    'hrm_employee.Sname',
                                    'hrm_employee.EmpCode'
                                )
                                ->get();
                        
                    $attendanceData[] = [
                    'attendance' => $attendance,
                    'attendanceSummary'=>$attendanceSummary,
                    'leaveApplications'=>$leaveApplications,
                    'leaveBalances'=>$leaveBalances,
                    'attendnacerequest'=>$requestsAttendnace,
                    'approved_attendnace_status'=>$requestsAttendnace_approved,
                    'approved_leave_request'=>$leaveApplications_approval

                ];
                }
                                
            return view('employee.teamleaveatt',compact('selectedMonth','attendanceData','empdataleaveattdata','daysInMonth','isReviewer','isHodView'));
        }

        $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();  // Get all employees reporting to the RepEmployeeID
                
     
            foreach ($employeesReportingTo as $employee) {
                $attendance = \DB::table('hrm_employee_attendance')
                ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee
                
                $currentYear = now()->year;  // Get the current year
                $currentMonth = now()->month;  // Get the current month

                // Fetch attendance data for all employees in the current month and year
                $attendanceSummary = \DB::table('hrm_employee_attendance')
                    ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                    ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                    ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                    
                    ->select(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode',
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
                        \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
                    )  // Select the required fields and counts for each attendance value
                    ->groupBy(
                        'hrm_employee_attendance.EmployeeID',
                        'hrm_employee.Fname',
                        'hrm_employee.Sname',
                        'hrm_employee.Lname',
                        'hrm_employee.EmpCode'
                    )
                    ->get();  // Execute the query and get the results
                    $leaveApplications = \DB::table('hrm_employee_applyleave')
                    ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                    ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                    ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                    ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                    ->where('hrm_employee_applyleave.LeaveStatus', '!=', '1')
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname','hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                    ->get();
                    $leaveApplications_approval = \DB::table('hrm_employee_applyleave')
                        ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                        ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                        ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                        ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                        ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                        ->where('hrm_employee_applyleave.LeaveStatus', '=', '1')
                        ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                        'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                        'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                        'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                        ->get();
                    $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('0')  // Assuming 0 means pending requests
                    ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                    ->select(
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        'hrm_employee.EmployeeID',
                        'hrm_employee_attendance_req.*'
                    )
                    ->get();
                    $requestsAttendnace_approved = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('1')  // Assuming 0 means pending requests
                    ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
                    ->select(
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        'hrm_employee.EmployeeID',
                        'hrm_employee_attendance_req.*'
                    )
                    ->get();
                           // Build the query for attendance details and balances
        $emploid = $employee->EmployeeID;

        $query = DB::table($attendanceTable . ' as a') // Dynamically set the table for attendance
                ->join('hrm_employee_monthlyleave_balance as l', function($join) use ($selectedMonth, $currentYear, $emploid) {
                $join->on('a.EmployeeID', '=', 'l.EmployeeID')
                    ->where('l.Month', '=', $selectedMonth)
                    ->where('l.Year', '=', $currentYear);
            })
            ->join('hrm_employee as e', 'a.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee
            ->where('a.EmployeeID', $emploid)
            ->where('e.EmpStatus', 'A')
            ->whereYear('a.AttDate', $currentYear)
            ->whereMonth('a.AttDate', $selectedMonth)
            ->select(
                'a.EmployeeID',
                'e.Fname',
                'e.Lname',
                'e.Sname',
                'e.empcode',
                'l.OpeningCL',
                'l.OpeningPL',
                'l.OpeningEL',
                'l.OpeningOL',
                'l.OpeningSL',
                'l.BalanceCL',
                'l.BalancePL',
                'l.BalanceEL',
                'l.BalanceOL',
                'l.BalanceSL'
            );

        // Dynamically generate the CASE WHEN for each day of the month
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.AttValue END) AS day_$i"));
        }

        // Add totals for OD, A, P
        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "OD" THEN 1 ELSE 0 END) AS total_OD'));
        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "A" THEN 1 ELSE 0 END) AS total_A'));
        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "P" THEN 1 ELSE 0 END) AS total_P'));

        // Group by necessary fields
        $query->groupBy(
            'a.EmployeeID',
            'e.Fname', 
            'e.Lname', 
            'e.Sname', 
            'e.empcode', 
            'l.OpeningCL',
            'l.OpeningPL',
            'l.OpeningEL',
            'l.OpeningOL',
            'l.OpeningSL',
            'l.BalanceCL',
            'l.BalancePL',
            'l.BalanceEL',
            'l.BalanceOL',
            'l.BalanceSL'
        );

        // Execute the query
        $empdataleaveattdata[] = $query->get();
                    
                    $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                            ->join('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
                            ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                            ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
                            ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
                            ->select(
                                'hrm_employee_monthlyleave_balance.EmployeeID',
                                'hrm_employee_monthlyleave_balance.OpeningCL',
                                'hrm_employee_monthlyleave_balance.AvailedCL',
                                'hrm_employee_monthlyleave_balance.BalanceCL',
                                'hrm_employee_monthlyleave_balance.OpeningSL',
                                'hrm_employee_monthlyleave_balance.AvailedSL',
                                'hrm_employee_monthlyleave_balance.BalanceSL',
                                'hrm_employee_monthlyleave_balance.OpeningPL',
                                'hrm_employee_monthlyleave_balance.AvailedPL',
                                'hrm_employee_monthlyleave_balance.BalancePL',
                                'hrm_employee_monthlyleave_balance.OpeningEL',
                                'hrm_employee_monthlyleave_balance.AvailedEL',
                                'hrm_employee_monthlyleave_balance.BalanceEL',
                                'hrm_employee_monthlyleave_balance.OpeningOL',
                                'hrm_employee_monthlyleave_balance.AvailedOL',
                                'hrm_employee_monthlyleave_balance.BalanceOL',
                                'hrm_employee_monthlyleave_balance.EC',
                                'hrm_employee.Fname',
                                'hrm_employee.Sname',
                                'hrm_employee.EmpCode'
                            )
                            ->get();
                     
                $attendanceData[] = [
                    'attendance' => $attendance,
                    'attendanceSummary'=>$attendanceSummary,
                    'leaveApplications'=>$leaveApplications,
                    'leaveBalances'=>$leaveBalances,
                    'attendnacerequest'=>$requestsAttendnace,
                    'approved_attendnace_status'=>$requestsAttendnace_approved,
                    'approved_leave_request'=>$leaveApplications_approval
                ];
            }
            
            
        return view('employee.teamleaveatt',compact('selectedMonth','attendanceData','empdataleaveattdata','daysInMonth','isReviewer','isHodView'));
    }
    public function teamcost( Request $request) {
        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        $EmployeeID = Auth::user()->EmployeeID;
        $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

        // Get the employee IDs under the same team (where RepEmployeeID matches current user)
        // $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        if($isHodView){
            $employeeChain = collect($this->getEmployeeReportingChain($EmployeeID)); // Convert to collection

            // Now you can use pluck to get the EmployeeID
            $employeeIds = $employeeChain->pluck('EmployeeID'); 
          
            $ctcttotal = \DB::table('hrm_employee as e')
            ->join('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table
            ->whereIn('e.EmployeeID', $employeeIds)  // Use whereIn to handle the collection of employee IDs
            ->where('e.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
            ->where('ctc.Status', '=', 'A')  // Filter CTC status = 'A'
            //->select('ctc.Tot_CTC as TotalCTC','e.EmployeeID')
            ->sum('ctc.Tot_CTC');  // Get the sum of Tot_CTC for all employees
        
        
                // Define the months mapping
                $months = [
                    4 => 'APR', 5 => 'MAY', 
                    6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
                    11 => 'NOV', 12 => 'DEC',1 => 'JAN', 2 => 'FEB', 3 => 'MAR',
                ];
                
                // Define payment heads (the attribute names in your payslip data)
                $paymentHeads = [
                    'Gross Earning' => 'Tot_Gross', 
                    'Basic' => 'Basic',
                    'House Rent Allowance' => 'Hra', 
                    'Bonus' => 'Bonus_Month', 
                    'Bonus/ Exgeatia' => 'Bonus', 
                    'Special Allowance' => 'Special',
                    'DA'=>'DA',
                    'Arrear'=>'Arreares',
                    'Leave Encash'=>'LeaveEncash',
                    'Car Allowance'=>'Car_Allowance',
                    'Incentive'=>'Incentive',
                    'Var Remburmnt'=>'VarRemburmnt',
                    'Variable Adjustment'=>"VariableAdjustment",
                    'City Compensatory Allowance'=>'CCA',
                    'Relocation Allownace'=>'RA',
                    'Arrear Basic'=>'Arr_Basic',
                    'Arrear Hra'=>'Arr_Hra',
                    'Arrear Spl'=>'Arr_Spl',
                    'Arrear Conv'=>'Arr_Conv',
                    'CEA'=>'YCea',
                    'MR'=>'YMr',
                    'LTA'=>'YLta',
                    'Arrear Car Allowance'=>'Car_Allowance_Arr',
                    'Arrear Leave Encash'=>'Arr_LvEnCash',
                    'Arrear Bonus'=>'Arr_Bonus',
                    'Arrear LTA Remb.'=>'Arr_LTARemb',
                    'Arrear RA'=>'Arr_RA',
                    'Arrear PP'=>'Arr_PP',
                    'Bonus Adjustment'=>'Bonus_Adjustment',
                    'Performance Incentive'=>'PP_Inc',
                    'National pension scheme'=>'NPS',
                    'PerformancePay' => 'PerformancePay',
                ];
                
                $deductionHeads = [
                    'Gross Deduction' => 'Tot_Deduct', 
                    'TDS' => 'TDS', 
                    'Provident Fund' => 'Tot_Pf', 
                    'ESIC'=>'ESCI_Employee',
                    'NPS Contribution'=>'NPS_Value',
                    'Arrear Pf'=>'Arr_Pf',
                    'Arrear Esic'=>'Arr_Esic',
                    'Voluntary Contribution'=>'VolContrib',
                    'Deduct Adjustment'=>'DeductAdjmt',
                    'Recovery Spl. Allow'=>'RecSplAllow',
                ];
            
                // Get payslip data for the employee IDs for all months
                $payslipData = PaySlip::whereIn('EmployeeID',$employeeIds)->where('PaySlipYearId','13')
                                      ->select('EmployeeID', 'Month', 
                                        ...array_values($paymentHeads), // select all payment heads columns
                                        ...array_values($deductionHeads) // select all deduction heads columns
                                      )
                                      ->get();
                
                // Flatten the data into a simple structure: [EmployeeID, Month, Payment Heads, Deduction Heads]
                $flattenedPayslips = $payslipData->map(function ($payslip) use ($months, $paymentHeads, $deductionHeads) {
                    $payslipData = [
                        'EmployeeID' => $payslip->EmployeeID,
                        'Month' => $months[$payslip->Month], // Month name
                    ];
                    
                    // Add payment head data only if it's non-zero
                    foreach ($paymentHeads as $label => $column) {
                        $value = $payslip->$column ?? 0;
                        if ($value != 0) {
                            $payslipData[$label] = $value;  // Only add if the value is non-zero
                        }
                    }
                    
                    // Add deduction head data only if it's non-zero
                    foreach ($deductionHeads as $label => $column) {
                        $value = $payslip->$column ?? 0;
                        if ($value != 0) {
                            $payslipData[$label] = $value;  // Only add if the value is non-zero
                        }
                    }
                    
                    return $payslipData;
                });
            
                // Filter out heads that have no data across all months for any employee
                $filteredPaymentHeads = $paymentHeads;
                $filteredDeductionHeads = $deductionHeads;
            
                foreach ($paymentHeads as $label => $column) {
                    $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
                    if (!$hasData) {
                        unset($filteredPaymentHeads[$label]);
                    }
                }
            
                foreach ($deductionHeads as $label => $column) {
                    $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
                    if (!$hasData) {
                        unset($filteredDeductionHeads[$label]);
                    }
                }
            
                // Group the payslip data by EmployeeID for easier display in the view
                $groupedPayslips = $flattenedPayslips->groupBy('EmployeeID');
                
                // Get the employee details
                $employeeData = Employee::whereIn('EmployeeID', $employeeIds)
                
                                        ->select('EmployeeID', 'Fname', 'Sname', 'Lname')
                                        ->get();
                
                
                // Pass the necessary data to the view
                return view("employee.teamcost", compact('employeeData', 'groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads','ctcttotal','isReviewer'));
            }
        $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
    ->where('RepEmployeeID', $EmployeeID)  // Filter by RepEmployeeID
    ->where('hrm_employee.EmpStatus', 'A') // Filter by EmpStatus = 'A'
    ->pluck('hrm_employee_general.EmployeeID'); // Pluck the EmployeeID from EmployeeGeneral


    $ctcttotal = \DB::table('hrm_employee as e')
    ->join('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table
    ->whereIn('e.EmployeeID', $employeeIds)  // Use whereIn to handle the collection of employee IDs
    ->where('e.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
    ->where('ctc.Status', '=', 'A')  // Filter CTC status = 'A'
    //->select('ctc.Tot_CTC as TotalCTC','e.EmployeeID')
    ->sum('ctc.Tot_CTC');  // Get the sum of Tot_CTC for all employees


        // Define the months mapping
        $months = [
            4 => 'APR', 5 => 'MAY', 
            6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
            11 => 'NOV', 12 => 'DEC',1 => 'JAN', 2 => 'FEB', 3 => 'MAR',
        ];
        
        // Define payment heads (the attribute names in your payslip data)
        $paymentHeads = [
            'Gross Earning' => 'Tot_Gross', 
            'Basic' => 'Basic',
            'House Rent Allowance' => 'Hra', 
            'Bonus' => 'Bonus_Month', 
            'Bonus/ Exgeatia' => 'Bonus', 
            'Special Allowance' => 'Special',
            'DA'=>'DA',
            'Arrear'=>'Arreares',
            'Leave Encash'=>'LeaveEncash',
            'Car Allowance'=>'Car_Allowance',
            'Incentive'=>'Incentive',
            'Var Remburmnt'=>'VarRemburmnt',
            'Variable Adjustment'=>"VariableAdjustment",
            'City Compensatory Allowance'=>'CCA',
            'Relocation Allownace'=>'RA',
            'Arrear Basic'=>'Arr_Basic',
            'Arrear Hra'=>'Arr_Hra',
            'Arrear Spl'=>'Arr_Spl',
            'Arrear Conv'=>'Arr_Conv',
            'CEA'=>'YCea',
            'MR'=>'YMr',
            'LTA'=>'YLta',
            'Arrear Car Allowance'=>'Car_Allowance_Arr',
            'Arrear Leave Encash'=>'Arr_LvEnCash',
            'Arrear Bonus'=>'Arr_Bonus',
            'Arrear LTA Remb.'=>'Arr_LTARemb',
            'Arrear RA'=>'Arr_RA',
            'Arrear PP'=>'Arr_PP',
            'Bonus Adjustment'=>'Bonus_Adjustment',
            'Performance Incentive'=>'PP_Inc',
            'National pension scheme'=>'NPS',
            'PerformancePay' => 'PerformancePay',
        ];
        
        $deductionHeads = [
            'Gross Deduction' => 'Tot_Deduct', 
            'TDS' => 'TDS', 
            'Provident Fund' => 'Tot_Pf', 
            'ESIC'=>'ESCI_Employee',
            'NPS Contribution'=>'NPS_Value',
            'Arrear Pf'=>'Arr_Pf',
            'Arrear Esic'=>'Arr_Esic',
            'Voluntary Contribution'=>'VolContrib',
            'Deduct Adjustment'=>'DeductAdjmt',
            'Recovery Spl. Allow'=>'RecSplAllow',
        ];
    
        // Get payslip data for the employee IDs for all months
        $payslipData = PaySlip::whereIn('EmployeeID', $employeeIds)->where('PaySlipYearId','13')
                              ->select('EmployeeID', 'Month', 
                                ...array_values($paymentHeads), // select all payment heads columns
                                ...array_values($deductionHeads) // select all deduction heads columns
                              )
                              ->get();
        
        // Flatten the data into a simple structure: [EmployeeID, Month, Payment Heads, Deduction Heads]
        $flattenedPayslips = $payslipData->map(function ($payslip) use ($months, $paymentHeads, $deductionHeads) {
            $payslipData = [
                'EmployeeID' => $payslip->EmployeeID,
                'Month' => $months[$payslip->Month], // Month name
            ];
            
            // Add payment head data only if it's non-zero
            foreach ($paymentHeads as $label => $column) {
                $value = $payslip->$column ?? 0;
                if ($value != 0) {
                    $payslipData[$label] = $value;  // Only add if the value is non-zero
                }
            }
            
            // Add deduction head data only if it's non-zero
            foreach ($deductionHeads as $label => $column) {
                $value = $payslip->$column ?? 0;
                if ($value != 0) {
                    $payslipData[$label] = $value;  // Only add if the value is non-zero
                }
            }
            
            return $payslipData;
        });
    
        // Filter out heads that have no data across all months for any employee
        $filteredPaymentHeads = $paymentHeads;
        $filteredDeductionHeads = $deductionHeads;
    
        foreach ($paymentHeads as $label => $column) {
            $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
            if (!$hasData) {
                unset($filteredPaymentHeads[$label]);
            }
        }
    
        foreach ($deductionHeads as $label => $column) {
            $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
            if (!$hasData) {
                unset($filteredDeductionHeads[$label]);
            }
        }
    
        // Group the payslip data by EmployeeID for easier display in the view
        $groupedPayslips = $flattenedPayslips->groupBy('EmployeeID');
        
        // Get the employee details
        $employeeData = Employee::whereIn('EmployeeID', $employeeIds)
        
                                ->select('EmployeeID', 'Fname', 'Sname', 'Lname')
                                ->get();
        
        // Pass the necessary data to the view
        return view("employee.teamcost", compact('employeeData', 'groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads','ctcttotal','isReviewer'));
    
    }
    public function teamconfirmation(Request $request) {
        $EmployeeID = Auth::user()->EmployeeID;
        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

        // Get the employee IDs under the same team (where RepEmployeeID matches current user)
        // $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        if($isHodView){
            $employeeChain = collect($this->getEmployeeReportingChain($EmployeeID)); // Convert to collection
       
            // Now you can use pluck to get the EmployeeID
            $employeeIds = $employeeChain->pluck('EmployeeID'); 
      
                // Get the current date and the date 15 days from now
                $currentDate = Carbon::now();  // Today's date
                $endDate = $currentDate->copy()->addDays(15);  // Add 15 days to today's date

                // Fetch all employee data (no changes to the original query)
                $employeeDataConfirmation = \DB::table('hrm_employee_general as eg')
                    ->join('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
                    ->join('hrm_designation as ds', 'ds.DesigId', '=', 'eg.DesigId')  // Designation table
                    ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
                    ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left join to get grade info
                    ->join('hrm_department as d', 'd.DepartmentId', '=', 'eg.DepartmentId')  // Department table
                    ->join('hrm_headquater as hq', 'eg.HqId', '=', 'hq.HqId')  // Join with Headquater table
                    ->whereIn('eg.EmployeeID', $employeeIds)  // Ensure we are filtering by employee IDs (as per the original code)
                    ->select(
                        'e.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode',
                        'eg.DateJoining', 'hq.HqName', 'ds.DesigName', 'g.GradeValue',
                        'v.VerticalName', 'd.DepartmentCode', 'eg.DateConfirmation','eg.RepEmployeeID'
                    )
                    ->get();

                // Add a flag for employees who have DateConfirmation within the next 15 days
                $employeeDataConfirmation->map(function($employee) use ($currentDate, $endDate) {

                    // Ensure the DateConfirmation is properly parsed as a Carbon instance
                    $confirmationDate = Carbon::parse($employee->DateConfirmation);

                    // Set the flag for recently confirmed employees
                    // Check if the DateConfirmation is within the next 15 days
                    $employee->isRecentlyConfirmed = $confirmationDate->isBetween($currentDate, $endDate);
                    $employee->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;

                    return $employee;
                });
                // Pass the necessary data to the view
                return view("employee.teamconfirmation",compact('employeeDataConfirmation','isReviewer'));
            }     
        // Get the list of EmployeeIDs for the team members of the logged-in employee
        $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->where('RepEmployeeID', Auth::user()->EmployeeID)  // Filter by RepEmployeeID
            ->where('hrm_employee.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
            ->pluck('hrm_employee.EmployeeID');  // Get the list of EmployeeIDs
    
     // Get the current date and the date 15 days from now
     $currentDate = Carbon::now();  // Today's date
     $endDate = $currentDate->copy()->addDays(15);  // Add 15 days to today's date
 
     // Fetch all employee data (no changes to the original query)
     $employeeDataConfirmation = \DB::table('hrm_employee_general as eg')
         ->join('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
         ->join('hrm_designation as ds', 'ds.DesigId', '=', 'eg.DesigId')  // Designation table
         ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
         ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left join to get grade info
         ->join('hrm_department as d', 'd.DepartmentId', '=', 'eg.DepartmentId')  // Department table
         ->join('hrm_headquater as hq', 'eg.HqId', '=', 'hq.HqId')  // Join with Headquater table
         ->whereIn('eg.EmployeeID', $employeeIds)  // Ensure we are filtering by employee IDs (as per the original code)
         ->select(
             'e.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode',
             'eg.DateJoining', 'hq.HqName', 'ds.DesigName', 'g.GradeValue',
             'v.VerticalName', 'd.DepartmentCode', 'eg.DateConfirmation','eg.RepEmployeeID'
         )
         ->get();
 
     // Add a flag for employees who have DateConfirmation within the next 15 days
     $employeeDataConfirmation->map(function($employee) use ($currentDate, $endDate) {
         // Ensure the DateConfirmation is properly parsed as a Carbon instance
         $confirmationDate = Carbon::parse($employee->DateConfirmation);
 
         // Set the flag for recently confirmed employees
         // Check if the DateConfirmation is within the next 15 days
         $employee->isRecentlyConfirmed = $confirmationDate->isBetween($currentDate, $endDate);
         $employee->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
         return $employee;
     });
            return view("employee.teamconfirmation",compact('employeeDataConfirmation','isReviewer'));
        }

    public function teamseprationclear(Request $request){
        $EmployeeID =Auth::user()->EmployeeID;
        $isReviewer = \DB::table('hrm_employee_reporting')
        ->where('ReviewerId', Auth::user()->EmployeeID)
        ->exists();  // Returns true if the EmployeeID is found in ReviewerID

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked

        $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get(); 
        $seperationData = [];
        if($isHodView){
            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);

            foreach ($employeeChain as $employee) {

                $seperation = \DB::table('hrm_employee_separation as es')
                ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
                ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
                ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch department name
                ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
                ->where('e.EmpStatus','A')  // Filter by employee ID
    
                ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.DepartmentName','eg.EmailId_Vnr','dg.DesigName')  // Select the required fields
                ->get();
    
                if ($seperation->isNotEmpty()) {
                    $seperationData[] = [
                        'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                        'seperation' => $seperation
                    ];
                }
            }    
            // Step 1: Fetch department_id from hrm_department where department_code == 'HR'
            $department = Department::where('DepartmentCode', 'HR')->first();
            if (!$department) {
                return response()->json(['success' => false, 'message' => 'HR Department not found.'], 404);
            }
            
            // Step 4: Fetch the data from hrm_employee_separation where Rep_Approved == 'Y' and Rep_RelievingDate is valid
            $separationsforhr = EmployeeSeparation::where('HR_UserId', Auth::user()->EmployeeID)
                ->where('Rep_Approved', 'Y')
                ->whereNotNull('Rep_RelievingDate')
                ->whereRaw('Rep_RelievingDate != "0000-00-00"') // Ensuring invalid dates like '0000-00-00' are excluded
                ->get(); 
    
            // Loop through separations and add employee details
            $separationsforhr->each(function ($separation) {
                // Query to get employee details by EmployeeID
                $employee = DB::table('hrm_employee')
                    ->select('Fname', 'Lname', 'Sname')
                    ->where('EmployeeID', $separation->EmployeeID)
                    ->first();
                
                // If employee exists, add their details to the separation data
                if ($employee) {
                    // Add employee data to separation
                    $separation->Fname = $employee->Fname;
                    $separation->Lname = $employee->Lname;
                    $separation->Sname = $employee->Sname;
                } else {
                    // If employee not found, set them as null or handle accordingly
                    $separation->Fname = null;
                    $separation->Lname = null;
                    $separation->Sname = null;
                }
            });
    
            // Now if you want to get all the attributes including the dynamically added ones, you can use:
            $separationsforhr = $separationsforhr->toArray(); // or use this in the view
                // Fetch the CompanyID from the hrm_general table for the given EmployeeID
            $companyId = DB::table('hrm_employee')
            ->where('EmployeeID', $EmployeeID)
            ->pluck('CompanyId')
            ->first();  // Using first() to get a single value (CompanyID)
    
            // Fetch EmployeeIDs and their respective DepartmentCodes for departments LOGISTICS and IT
            $employeeDepartmentDetails = DB::table('hrm_employee_separation_nocdept_emp')
                ->join('hrm_department', 'hrm_department.DepartmentID', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
                ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
                ->whereIn('hrm_department.DepartmentCode', ['LOGISTICS', 'IT','FINANCE','HR'])  // Filter departments LOGISTICS and IT
                ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'hrm_department.DepartmentCode', 'hrm_department.DepartmentID')  // Select relevant fields
                ->get();
                // Get the current month and year
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
    
                // Fetching approved employees with additional employee details
                    $approvedEmployees = DB::table('hrm_employee_separation as es')
                    ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                    ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                    ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                    ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
                    ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                    ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                    ->where(function($query) {
                        // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                        $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                            ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
                    })
                    ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                    ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                    ->select(
                        'es.*',
                        'e.Fname',  // First name
                        'e.Lname',  // Last name
                        'e.Sname',  // Surname
                        'e.EmpCode',  // Employee Code
                        'd.DepartmentName',  // Department name
                        'eg.EmailId_Vnr',  // Email ID from the employee general table
                        'dg.DesigName'  // Designation name
                    )
                    ->get();
    
    
                    return view('employee.teamseprationclear',compact('seperationData','separationsforhr','employeeDepartmentDetails','approvedEmployees','isReviewer'));
    
        }

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
            ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
            ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
            ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch department name
            ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
            ->where('e.EmpStatus','A')  // Filter by employee ID

            ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.DepartmentName','eg.EmailId_Vnr','dg.DesigName')  // Select the required fields
            ->get();

            if ($seperation->isNotEmpty()) {
                $seperationData[] = [
                    'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                    'seperation' => $seperation
                ];
            }
        }    
        // Step 1: Fetch department_id from hrm_department where department_code == 'HR'
        $department = Department::where('DepartmentCode', 'HR')->first();
        if (!$department) {
            return response()->json(['success' => false, 'message' => 'HR Department not found.'], 404);
        }
        
        // Step 4: Fetch the data from hrm_employee_separation where Rep_Approved == 'Y' and Rep_RelievingDate is valid
        $separationsforhr = EmployeeSeparation::where('HR_UserId', Auth::user()->EmployeeID)
            ->where('Rep_Approved', 'Y')
            ->whereNotNull('Rep_RelievingDate')
            ->whereRaw('Rep_RelievingDate != "0000-00-00"') // Ensuring invalid dates like '0000-00-00' are excluded
            ->get(); 

        // Loop through separations and add employee details
        $separationsforhr->each(function ($separation) {
            // Query to get employee details by EmployeeID
            $employee = DB::table('hrm_employee')
                ->select('Fname', 'Lname', 'Sname')
                ->where('EmployeeID', $separation->EmployeeID)
                ->first();
            
            // If employee exists, add their details to the separation data
            if ($employee) {
                // Add employee data to separation
                $separation->Fname = $employee->Fname;
                $separation->Lname = $employee->Lname;
                $separation->Sname = $employee->Sname;
            } else {
                // If employee not found, set them as null or handle accordingly
                $separation->Fname = null;
                $separation->Lname = null;
                $separation->Sname = null;
            }
        });

        // Now if you want to get all the attributes including the dynamically added ones, you can use:
        $separationsforhr = $separationsforhr->toArray(); // or use this in the view
            // Fetch the CompanyID from the hrm_general table for the given EmployeeID
        $companyId = DB::table('hrm_employee')
        ->where('EmployeeID', $EmployeeID)
        ->pluck('CompanyId')
        ->first();  // Using first() to get a single value (CompanyID)

        // Fetch EmployeeIDs and their respective DepartmentCodes for departments LOGISTICS and IT
        $employeeDepartmentDetails = DB::table('hrm_employee_separation_nocdept_emp')
            ->join('hrm_department', 'hrm_department.DepartmentID', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
            ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
            ->whereIn('hrm_department.DepartmentCode', ['LOGISTICS', 'IT','FINANCE','HR'])  // Filter departments LOGISTICS and IT
            ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'hrm_department.DepartmentCode', 'hrm_department.DepartmentID')  // Select relevant fields
            ->get();
            // Get the current month and year
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetching approved employees with additional employee details
                $approvedEmployees = DB::table('hrm_employee_separation as es')
                ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
                ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                ->where(function($query) {
                    // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                    $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                        ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
                })
                ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                ->select(
                    'es.*',
                    'e.Fname',  // First name
                    'e.Lname',  // Last name
                    'e.Sname',  // Surname
                    'e.EmpCode',  // Employee Code
                    'd.DepartmentName',  // Department name
                    'eg.EmailId_Vnr',  // Email ID from the employee general table
                    'dg.DesigName'  // Designation name
                )
                ->get();


                return view('employee.teamseprationclear',compact('seperationData','separationsforhr','employeeDepartmentDetails','approvedEmployees','isReviewer'));

            }
    public function teamclear(){
        return view('employee.teamclear');

    }
    
    
    
    // public function teamcost() {
    //     $EmployeeID = Auth::user()->EmployeeID;
    
    //     // Get the employee IDs under the same team (where RepEmployeeID matches current user)
    //     $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
    
    //     // Define the months mapping
    //     $months = [
    //         1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR', 5 => 'MAY', 
    //         6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
    //         11 => 'NOV', 12 => 'DEC'
    //     ];
    
    //     // Define payment heads (the attribute names in your payslip data)
    //     $paymentHeads = [
    //         'Basic' => 'Basic', 
    //         'House Rent Allowance' => 'Hra', 
    //         'Special Allowance' => 'Special', 
    //         'Bonus' => 'Bonus_Month', 
    //         'Gross Earning' => 'Tot_Gross', 
    //         'Provident Fund' => 'Tot_Pf', 
    //         'Gross Deduction' => 'Tot_Deduct', 
    //         'Net Amount' => 'Tot_NetAmount'
    //     ];
    
    //     // Get payslip data for the employee IDs
    //     $payslipData = PaySlip::whereIn('EmployeeID', $employeeIds)->get();
    //     // $payslipData = PaySlip::join('hrm_employee', 'hrm_employee_monthlypayslip.EmployeeID', '=', 'hrm_employee.EmployeeID')
    //     // ->whereIn('hrm_employee_monthlypayslip.EmployeeID', $employeeIds)
    //     // ->select(
    //     //     'hrm_employee_monthlypayslip.EmployeeID',
    //     //     'hrm_employee.Fname',
    //     //     'hrm_employee.Sname',
    //     //     'hrm_employee.Lname',
    //     //     'hrm_employee_monthlypayslip.*',
    //     // )
    //     // ->get();
    //     // Group payslips by EmployeeID for easier processing
    //     $groupedPayslips = $payslipData->groupBy('EmployeeID');
    //     $employeeData =Employee::whereIn('EmployeeID', $employeeIds)
    //                 ->select('EmployeeID', 'Fname', 'Sname', 'Lname')
    //                 ->get();
     
    //     // Pass the necessary data to the view
    //     return view("employee.teamcost", compact( 'employeeData','groupedPayslips','months', 'paymentHeads'));
    // }
    public function showDetails($employeeId)
    {   
        // $employee = DB::table('hrm_employee as e')
        //     ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        //     ->join('hrm_employee_reporting as r', 'e.EmployeeID', '=', 'r.EmployeeID')
        //     ->join('hrm_employee_personal as hp', 'e.EmployeeID', '=', 'hp.EmployeeID')
        //     ->join('hrm_designation as de', 'g.DesigId', '=', 'de.DesigId') 
        //     ->join('hrm_department as d', 'g.DepartmentId', '=', 'd.DepartmentId') 
        //     ->join('hrm_headquater as hq', 'g.HqId', '=', 'hq.HqId') 
        //     ->leftJoin('hrm_employee_experience as ee', 'e.EmployeeID', '=', 'ee.EmployeeID') // Left Join to include all experiences
        //     // Join the employee table again for the reviewer
        //     ->Join('hrm_employee as e2', 'r.ReviewerId', '=', 'e2.EmployeeID') // Join for Reviewer details
        //     ->where('e.EmployeeID', $employeeId)
        //     ->select(
        //         'e.EmpCode', 
        //         'e.Fname', 
        //         'e.Lname', 
        //         'e.Sname',
        //         'g.DateJoining',
        //         'g.ReportingName',
        //         'r.ReviewerId',
        //         'de.DesigName',
        //         'd.DepartmentName',
        //         'hp.Qualification',
        //         'hq.HqName',
        //         DB::raw('COALESCE(SUM(ee.ExpTotalYear), 0) as TotalExperienceYears'), // Sum of experience years
        //         'e2.Fname as ReviewerFname',
        //         'e2.Lname as ReviewerLname',
        //         'e2.Sname as ReviewerSname',
        //        // Concatenate multiple experience records into one string, excluding '0000-00-00' from ExpToDate
        //             DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpComName END) as ExperienceCompanies'),
        //             DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpDesignation END) as ExperienceDesignations'),
        //             DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpFromDate END) as ExperienceFromDates'),
        //             DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpToDate END) as ExperienceToDates'),
        //             DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpTotalYear END) as ExperienceYears')
        //         )
        //     ->groupBy(
        //         'e.EmpCode', 
        //         'e.Fname', 
        //         'e.Lname', 
        //         'e.Sname',
        //         'g.DateJoining',
        //         'g.ReportingName',
        //         'r.ReviewerId',   
        //         'de.DesigName',
        //         'd.DepartmentName',
        //         'hp.Qualification',
        //         'hq.HqName',
        //         'e2.Fname',      
        //         'e2.Lname',      
        //         'e2.Sname'
        //     )
        //     ->first();

        //using lag in mysql (5) doesnit support 
    //     $employee = DB::table('hrm_employee as e')
    // ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
    // ->join('hrm_employee_reporting as r', 'e.EmployeeID', '=', 'r.EmployeeID')
    // ->join('hrm_employee_personal as hp', 'e.EmployeeID', '=', 'hp.EmployeeID')
    // ->join('hrm_designation as de', 'g.DesigId', '=', 'de.DesigId') 
    // ->join('hrm_department as d', 'g.DepartmentId', '=', 'd.DepartmentId') 
    // ->join('hrm_headquater as hq', 'g.HqId', '=', 'hq.HqId') 
    // ->leftJoin('hrm_employee_experience as ee', 'e.EmployeeID', '=', 'ee.EmployeeID') // Left Join to include all experiences
    // ->leftJoin('hrm_employee as e2', 'r.ReviewerId', '=', 'e2.EmployeeID') // Join for Reviewer details
    // ->leftJoin('hrm_pms_appraisal_history as a', 'e.EmployeeID', '=', 'a.EmployeeID') // Join the appraisal history table to get current grade, department, and designation
    // ->where('e.EmployeeID', $employeeId)
    // ->select(
    //     'e.EmpCode', 
    //     'e.Fname', 
    //     'e.Lname', 
    //     'e.Sname',
    //     'g.DateJoining',
    //     'g.ReportingName',
    //     'r.ReviewerId',
    //     'de.DesigName',
    //     'd.DepartmentName',
    //     'hp.Qualification',
    //     'hq.HqName',
    //     DB::raw('COALESCE(SUM(ee.ExpTotalYear), 0) as TotalExperienceYears'), // Sum of experience years
    //     'e2.Fname as ReviewerFname',
    //     'e2.Lname as ReviewerLname',
    //     'e2.Sname as ReviewerSname',
    //     // Concatenate multiple experience records into one string, excluding '0000-00-00' from ExpToDate
    //     DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpComName END) as ExperienceCompanies'),
    //     DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpDesignation END) as ExperienceDesignations'),
    //     DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpFromDate END) as ExperienceFromDates'),
    //     DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpToDate END) as ExperienceToDates'),
    //     DB::raw('GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpTotalYear END) as ExperienceYears'),
    //     // Fetch current grade, department, and designation
    //     'a.Current_Grade', 
    //     'a.Department as Current_Department',
    //     'a.Current_Designation',
    //     // Calculate salary change duration only if there is a change in grade, department, or designation
    //     DB::raw('CASE 
    //                 WHEN a.Current_Grade != LAG(a.Current_Grade) OVER (PARTITION BY a.EmployeeID ORDER BY a.SalaryChangeDate) 
    //                      OR a.Department != LAG(a.Department) OVER (PARTITION BY a.EmployeeID ORDER BY a.SalaryChangeDate)
    //                      OR a.Current_Designation != LAG(a.Current_Designation) OVER (PARTITION BY a.EmployeeID ORDER BY a.SalaryChangeDate)
    //                 THEN DATEDIFF(NOW(), a.SalaryChangeDate) 
    //                 ELSE NULL 
    //             END as SalaryChangeDuration')
    // )
    // ->groupBy(
    //     'e.EmpCode', 
    //     'e.Fname', 
    //     'e.Lname', 
    //     'e.Sname',
    //     'g.DateJoining',
    //     'g.ReportingName',
    //     'r.ReviewerId',   // Add ReviewerId to GROUP BY
    //     'de.DesigName',
    //     'd.DepartmentName',
    //     'hp.Qualification',
    //     'hq.HqName',
    //     'e2.Fname',      // Reviewer First Name
    //     'e2.Lname',      // Reviewer Last Name
    //     'e2.Sname',      // Reviewer Surname
    //     'a.Current_Grade', 
    //     'a.Department',
    //     'a.Current_Designation'
    // )
    // ->first();
    // $employee = DB::table('hrm_employee as e')
    // ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
    // ->join('hrm_employee_reporting as r', 'e.EmployeeID', '=', 'r.EmployeeID')
    // ->join('hrm_employee_personal as hp', 'e.EmployeeID', '=', 'hp.EmployeeID')
    // ->join('hrm_designation as de', 'g.DesigId', '=', 'de.DesigId') 
    // ->join('hrm_department as d', 'g.DepartmentId', '=', 'd.DepartmentId') 
    // ->join('hrm_headquater as hq', 'g.HqId', '=', 'hq.HqId') 
    // ->leftJoin('hrm_employee_experience as ee', 'e.EmployeeID', '=', 'ee.EmployeeID') // Left Join to include all experiences
    // ->join('hrm_employee as e2', 'r.ReviewerId', '=', 'e2.EmployeeID') // Join for Reviewer details
    // ->leftJoin('hrm_pms_appraisal_history as ah', 'e.EmployeeID', '=', 'ah.EmployeeID') // Left join to get all appraisal history
    // ->where('e.EmployeeID', $employeeId)
    // ->select(
    //     'e.EmpCode', 
    //     'e.Fname', 
    //     'e.Lname', 
    //     'e.Sname',
    //     'g.DateJoining',
    //     'g.ReportingName',
    //     'r.ReviewerId',
    //     'de.DesigName',
    //     'd.DepartmentName',
    //     'hp.Qualification',
    //     'hq.HqName',
    //     DB::raw('COALESCE(SUM(ee.ExpTotalYear), 0) as TotalExperienceYears'), // Sum of experience years
    //     'e2.Fname as ReviewerFname',
    //     'e2.Lname as ReviewerLname',
    //     'e2.Sname as ReviewerSname',
        
    //     // Separate the experience data handling in a subquery
    //     DB::raw('(
    //         SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpComName END)
    //         FROM hrm_employee_experience ee
    //         WHERE ee.EmployeeID = e.EmployeeID
    //     ) as ExperienceCompanies'),
    //     DB::raw('(
    //         SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpDesignation END)
    //         FROM hrm_employee_experience ee
    //         WHERE ee.EmployeeID = e.EmployeeID
    //     ) as ExperienceDesignations'),
    //     DB::raw('(
    //         SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpFromDate END)
    //         FROM hrm_employee_experience ee
    //         WHERE ee.EmployeeID = e.EmployeeID
    //     ) as ExperienceFromDates'),
    //     DB::raw('(
    //         SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpToDate END)
    //         FROM hrm_employee_experience ee
    //         WHERE ee.EmployeeID = e.EmployeeID
    //     ) as ExperienceToDates'),
    //     DB::raw('(
    //         SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpTotalYear END)
    //         FROM hrm_employee_experience ee
    //         WHERE ee.EmployeeID = e.EmployeeID
    //     ) as ExperienceYears'),

    //     // Concatenate appraisal history records by Current_Grade and Current_Designation
    //     DB::raw('GROUP_CONCAT(DISTINCT ah.Current_Grade ORDER BY ah.SalaryChange_Date) as CurrentGrades'),
    //     DB::raw('GROUP_CONCAT(DISTINCT ah.Current_Designation ORDER BY ah.SalaryChange_Date) as CurrentDesignations'),
    //     // Concatenate salary change dates and format as range
    //     DB::raw('GROUP_CONCAT(DISTINCT CONCAT(
    //                 DATE_FORMAT(ah.SalaryChange_Date, "%Y-%m-%d"), " - ", 
    //                 (SELECT DATE_FORMAT(MAX(SalaryChange_Date), "%Y-%m-%d") 
    //                  FROM hrm_pms_appraisal_history 
    //                  WHERE EmployeeID = ah.EmployeeID AND ah.SalaryChange_Date < SalaryChange_Date)
    //                 ) ORDER BY ah.SalaryChange_Date SEPARATOR ", ") as SalaryChangeDates')
    // )
    // ->groupBy(
    //     'e.EmpCode', 
    //     'e.Fname', 
    //     'e.Lname', 
    //     'e.Sname',
    //     'g.DateJoining',
    //     'g.ReportingName',
    //     'r.ReviewerId',   
    //     'de.DesigName',
    //     'd.DepartmentName',
    //     'hp.Qualification',
    //     'hq.HqName',
    //     'e2.Fname',      
    //     'e2.Lname',      
    //     'e2.Sname',
    //     'e.EmployeeID',   // Add e.EmployeeID to GROUP BY to comply with the ONLY_FULL_GROUP_BY mode
    //     'g.DepartmentId',  // Ensure that all required columns are part of GROUP BY
    //     'hq.HqId'          // Add any additional necessary fields here
    // )
    // ->first();
    $employee = DB::table('hrm_employee as e')
    ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
    ->join('hrm_employee_reporting as r', 'e.EmployeeID', '=', 'r.EmployeeID')
    ->join('hrm_employee_personal as hp', 'e.EmployeeID', '=', 'hp.EmployeeID')
    ->join('hrm_designation as de', 'g.DesigId', '=', 'de.DesigId') 
    ->join('hrm_department as d', 'g.DepartmentId', '=', 'd.DepartmentId') 
    ->join('hrm_headquater as hq', 'g.HqId', '=', 'hq.HqId') 
    ->leftJoin('hrm_employee_experience as ee', 'e.EmployeeID', '=', 'ee.EmployeeID') // Left Join to include all experiences
    ->join('hrm_employee as e2', 'r.ReviewerId', '=', 'e2.EmployeeID') // Join for Reviewer details
    ->leftJoin('hrm_pms_appraisal_history as ah', 'e.EmployeeID', '=', 'ah.EmployeeID') // Left join to get all appraisal history
    ->where('e.EmployeeID', $employeeId)
    ->select(
        'e.EmpCode', 
        'e.Fname', 
        'e.Lname', 
        'e.Sname',
        'g.DateJoining',
        'g.ReportingName',
        'r.ReviewerId',
        'de.DesigName',
        'd.DepartmentName',
        'hp.Qualification',
        'hq.HqName',
        DB::raw('COALESCE(SUM(CASE WHEN ee.ExpTotalYear IS NOT NULL THEN CAST(ee.ExpTotalYear AS DECIMAL(10,2)) ELSE 0 END), 0) as TotalExperienceYears'), // Ensure correct casting and null handling
        'e2.Fname as ReviewerFname',
        'e2.Lname as ReviewerLname',
        'e2.Sname as ReviewerSname',
        
        // Separate the experience data handling in a subquery
        DB::raw('(
            SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpComName END)
            FROM hrm_employee_experience ee
            WHERE ee.EmployeeID = e.EmployeeID
        ) as ExperienceCompanies'),
        DB::raw('(
            SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpDesignation END)
            FROM hrm_employee_experience ee
            WHERE ee.EmployeeID = e.EmployeeID
        ) as ExperienceDesignations'),
        DB::raw('(
            SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpFromDate END)
            FROM hrm_employee_experience ee
            WHERE ee.EmployeeID = e.EmployeeID
        ) as ExperienceFromDates'),
        DB::raw('(
            SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpToDate END)
            FROM hrm_employee_experience ee
            WHERE ee.EmployeeID = e.EmployeeID
        ) as ExperienceToDates'),
        DB::raw('(
            SELECT GROUP_CONCAT(CASE WHEN ee.ExpToDate != "0000-00-00" THEN ee.ExpTotalYear END)
            FROM hrm_employee_experience ee
            WHERE ee.EmployeeID = e.EmployeeID
        ) as ExperienceYears'),

        // Concatenate appraisal history records by Current_Grade and Current_Designation
        DB::raw('GROUP_CONCAT(DISTINCT ah.Current_Grade ORDER BY ah.SalaryChange_Date) as CurrentGrades'),
        DB::raw('GROUP_CONCAT(DISTINCT ah.Current_Designation ORDER BY ah.SalaryChange_Date) as CurrentDesignations'),
        // Concatenate salary change dates and format as range
        DB::raw('GROUP_CONCAT(DISTINCT CONCAT(
                    DATE_FORMAT(ah.SalaryChange_Date, "%Y-%m-%d"), " - ", 
                    (SELECT DATE_FORMAT(MAX(SalaryChange_Date), "%Y-%m-%d") 
                     FROM hrm_pms_appraisal_history 
                     WHERE EmployeeID = ah.EmployeeID AND ah.SalaryChange_Date < SalaryChange_Date)
                    ) ORDER BY ah.SalaryChange_Date SEPARATOR ", ") as SalaryChangeDates')
    )
    ->groupBy(
        'e.EmpCode', 
        'e.Fname', 
        'e.Lname', 
        'e.Sname',
        'g.DateJoining',
        'g.ReportingName',
        'r.ReviewerId',   
        'de.DesigName',
        'd.DepartmentName',
        'hp.Qualification',
        'hq.HqName',
        'e2.Fname',      
        'e2.Lname',      
        'e2.Sname',
        'e.EmployeeID',   // Add e.EmployeeID to GROUP BY to comply with the ONLY_FULL_GROUP_BY mode
        'g.DepartmentId',  // Ensure that all required columns are part of GROUP BY
        'hq.HqId'          // Add any additional necessary fields here
    )
    ->first();

    
        // If no employee data is found, return an error
        if (!$employee) {
            return response()->json(['error' => 'Data not found for this employee ']);
        }
    
        // Return the employee data as JSON
        return response()->json($employee);
    }
    public function singleprofileemployee($id){
           // Fetch data from the tables hrm_employee, hrm_employee_general, hrm_employee_personal, and hrm_employee_contact
    $employee = \DB::table('hrm_employee as e')
    ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
    ->join('hrm_headquater as hq', 'eg.HqId', '=', 'hq.HqId') 
    ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId') 
    ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
    ->join('hrm_designation as de', 'eg.DesigId', '=', 'de.DesigId') 
    ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match

    ->where('e.EmployeeID', $id)
    ->select(
        'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'eg.DateJoining','eg.EmailId_Vnr',
        'eg.DateConfirmation', 'de.DesigName', 'd.DepartmentName', 'hq.HqName','v.VerticalName','g.GradeValue', 

    )
    ->first();
        return view('employee.singleprofile',compact('employee'));

    }
    
}
