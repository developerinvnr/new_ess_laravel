<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaySlip;
use App\Models\EmployeeGeneral;
use App\Models\Employee;
use App\Models\HrmYear;
use App\Models\AttendanceRequest;
use App\Models\EmployeeSeparation;
use App\Models\EmployeeSeparationNocDeptEmp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function team(Request $request)
    {
    $EmployeeID = Auth::user()->EmployeeID;
    $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
    $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
    $getEmployeeReportingChaind3js = $this->getEmployeeReportingChaind3js($EmployeeID);

        if($isHodView){

            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
            $getEmployeeReportingChaind3js = $this->getEmployeeReportingChaind3js($EmployeeID);

            $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            $attendanceData = [];

            foreach ($employeeChain as $employee) {

                $attendance = \DB::table('hrm_employee_attendance')
                ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee

                // Add 'direct_reporting' field to each record in attendance
                $attendance = $attendance->map(function($item) use ($employee) {
                    $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                    return $item;
                });
                $employeeDetails = \DB::table('hrm_employee as e')
                        ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                        ->leftJoin('core_designation as d', 'eg.DesigId', '=', 'd.id')  // Join to fetch designation_name
                        ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
                        ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
                        ->leftJoin('core_departments as dp', 'eg.DepartmentId', '=', 'dp.id')  // Left Join to fetch DepartmentName
                        ->leftJoin('core_functions as cf', 'eg.EmpFunction', '=', 'cf.id') 
                        ->where('e.EmployeeID', $employee->EmployeeID)
                        ->where('e.EmpStatus', 'A')
                       
                        ->select(
                            'e.*', 
                            'eg.*', 
                            'd.designation_name', 
                            'v.vertical_name', 
                            'g.grade_name', 
                            'dp.department_code','cf.function_name'
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
                    ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
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

                    // Add 'direct_reporting' field to each record in attendance summary
                    $attendanceSummary = $attendanceSummary->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });
                    $leaveApplications = \DB::table('hrm_employee_applyleave')
                    ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                    ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                    ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                    ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                    ->where('hrm_employee_applyleave.LeaveStatus', '=', '0')
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate','hrm_employee_applyleave.Apply_Date',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_DuringAddress',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname','hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                    ->get();
                    $leaveApplications = $leaveApplications->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });

                    $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('0')  // Assuming 0 means pending requests
                    ->whereYear('hrm_employee_attendance_req.AttDate', $currentYear)  // Filter by current year
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
                    // Add 'direct_reporting' field to each request record
                    $requestsAttendnace = $requestsAttendnace->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });

                    
                    $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                            ->leftJoin('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
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
                            // Add 'direct_reporting' flag to each record
                    $leaveBalances = $leaveBalances->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });
                    $employeeDatadetails = \DB::table('hrm_employee_general')
                    ->leftjoin('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')  // Join with the hrm_headquater table
                    ->where('hrm_employee_general.EmployeeID', $employee->EmployeeID)
                    ->select('hrm_employee_general.DateJoining')  // Select DateJoining and HqName
                    ->select('hrm_employee_general.DateJoining', 'core_city_village_by_state.city_village_name','hrm_employee_general.DepartmentId','hrm_employee_general.TerrId')  // Select DateJoining and HqName
                    ->first();
                    $results = DB::table('core_departments as d')
                    ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
                    ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
                    ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
                    ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
                    ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
                    ->where('d.id', '=', $employeeDatadetails->DepartmentId)
                    ->first();

                    $functionName = $results->FunName ?? null;
                $attendanceData[] = [
                    'attendance' => $attendance,
                    'attendanceSummary'=>$attendanceSummary,
                    'leaveApplications'=>$leaveApplications,
                    'leaveBalances'=>$leaveBalances,
                    'attendnacerequest'=>$requestsAttendnace,

                ];
                $employeeData[] = $employeeDetails;

            }

            return view("employee.team",compact('employeeData','attendanceData','isReviewer','employeeChain','getEmployeeReportingChaind3js','functionName'));

        }

        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->leftJoin('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
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
                ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee
                // Add 'direct_reporting' field to each record in attendance
                $attendance = $attendance->map(function($item) use ($employee) {
                    $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                    return $item;
                });

                $employeeDetails = \DB::table('hrm_employee as e')
                        ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                        ->leftJoin('core_designation as d', 'eg.DesigId', '=', 'd.id')  // Join to fetch designation_name
                        ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
                        ->leftJoin('core_functions as cf', 'eg.EmpFunction', '=', 'cf.id') 
                        ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
                        ->leftJoin('core_departments as dp', 'eg.DepartmentId', '=', 'dp.id')  // Left Join to fetch DepartmentName
                        ->where('e.EmployeeID', $employee->EmployeeID)
                        ->where('e.EmpStatus', 'A')
                        ->select(
                            'e.*', 
                            'eg.*', 
                            'd.designation_name', 
                            'v.vertical_name', 
                            'g.grade_name', 
                            'dp.department_code','cf.function_name'  // Select DepartmentName from hrm_department
                        )  // Select all columns from e, eg, and the additional columns
                        ->get(); 
              
                        // Fetch the results (array of objects)
                $currentYear = now()->year;  // Get the current year
                $currentMonth = now()->month;  // Get the current month

                // Fetch attendance data for all employees in the current month and year
                $attendanceSummary = \DB::table('hrm_employee_attendance')
                    ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
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
                    // Add 'direct_reporting' field to each record in attendance summary
                    $attendanceSummary = $attendanceSummary->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });

                    $leaveApplications = \DB::table('hrm_employee_applyleave')
                    ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
                    ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
                    ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
                    ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
                    ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
                    ->where('hrm_employee_applyleave.LeaveStatus', '=', '0')
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_Date',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define','hrm_employee_applyleave.Apply_DuringAddress',
                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
                    ->get();
                    $leaveApplications = $leaveApplications->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });

                    $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
                    ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
                    ->whereStatus('0')  // Assuming 0 means pending requests
                    ->whereYear('hrm_employee_attendance_req.AttDate', $currentYear)  // Filter by current year
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
                    // Add 'direct_reporting' field to each request record
                    $requestsAttendnace = $requestsAttendnace->map(function($item) use ($employee) {
                        $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                        return $item;
                    });

                    $employeeDatadetails = \DB::table('hrm_employee_general')
                    ->leftjoin('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')  // Join with the hrm_headquater table
                    ->where('hrm_employee_general.EmployeeID', $employee->EmployeeID)
                    ->select('hrm_employee_general.DateJoining')  // Select DateJoining and HqName
                    ->select('hrm_employee_general.DateJoining', 
                    'core_city_village_by_state.city_village_name',
                    'hrm_employee_general.DepartmentId','hrm_employee_general.TerrId')  // Select DateJoining and HqName
                    ->first();

                    $results = DB::table('core_departments as d')
                    ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
                    ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
                    ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
                    ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
                    ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
                    ->where('d.id', '=', $employeeDatadetails->DepartmentId)
                    ->first();
                    // $results = DB::table('core_departments as d')
                    // ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
                    // ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
                    // ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
                    // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
                    // ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
                    // ->where('d.id', '=', $employeeDatadetails->DepartmentId)
                    // ->first();
                    $functionName = $results->FunName ?? null;

                    $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
                            ->leftJoin('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
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
                            $leaveBalances = $leaveBalances->map(function($item) use ($employee) {
                                $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                                return $item;
                            });
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
           
             // Check if the current user is a reviewer in the hrm_employee_reporting table
                $isReviewer = \DB::table('hrm_employee_reporting')
                ->where('ReviewerId', Auth::user()->EmployeeID)
                ->exists();  // Returns true if the EmployeeID is found in ReviewerID
  
        return view("employee.team",compact('employeeData','exists','assets_request','attendanceData','isReviewer','employeeChain','getEmployeeReportingChaind3js','functionName'));
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
        ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the hrm_employee table
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
    public function getEmployeeReportingChainseparation($EmployeeID, &$processed = [])
    {
        // Check if the current employee has already been processed
        if (in_array($EmployeeID, $processed)) {
            return [];
        }
    
        // Mark this employee as processed
        $processed[] = $EmployeeID;
    
        // Get all employees who report to the given EmployeeID
        $employeesReportingTo = DB::table('hrm_employee_general')
        ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the hrm_employee table
        ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)  // Filter by RepEmployeeID
        ->get();  // Fetch the results
    
        // Initialize an array to hold the reporting chain
        $chain = [];
    
        // Loop through each employee found and recursively get the chain
        foreach ($employeesReportingTo as $employee) {
            // Add the employee to the chain
            $chain[] = $employee;
    
            // Recursively find employees reporting to the current employee
            $subChain = $this->getEmployeeReportingChainseparation($employee->EmployeeID, $processed);
    
            // Merge the sub-chain into the main chain
            $chain = array_merge($chain, $subChain);
        }
    
        // Return the full chain of reporting employees
        return $chain;
    }
    public function getEmployeeReportingChaind3js($EmployeeID)
    {
        // Recursive function to build the hierarchy
        $buildHierarchy = function($employeeId, $level = 0) use (&$buildHierarchy) {
            // Fetch the current employee's data
            $employee = DB::table('hrm_employee_general')
                ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->where('hrm_employee_general.EmployeeID', $employeeId)  // Fetch specific employee
                ->where('hrm_employee.EmpStatus', 'A')  // Only active employees
                ->leftJoin('core_designation as d', 'd.id', '=', 'hrm_employee_general.DesigId') // Join with the designation table
                ->leftJoin('core_grades as g', 'hrm_employee_general.GradeId', '=', 'g.id')  // Join to fetch GradeValue
                ->first();
    
            if (!$employee) {
                return null; // Return null if employee not found
            }
    
            // Build the current employee's node
            $node = [
                'name' => $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname,
                'title' => $employee->designation_name,
                'children' => []  // Initialize an empty children array
            ];
    
            // Fetch all subordinates of the current employee
            $subordinates = DB::table('hrm_employee_general')
                ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->where('hrm_employee_general.RepEmployeeID', $employeeId)  // Subordinates
                ->where('hrm_employee.EmpStatus', 'A')  // Only active employees
                ->leftJoin('core_designation as d', 'd.id', '=', 'hrm_employee_general.DesigId') // Join with the designation table
                ->leftJoin('core_grades as g', 'hrm_employee_general.GradeId', '=', 'g.id')  // Join to fetch GradeValue
                ->get();
    
            // Recursively build the children nodes
            foreach ($subordinates as $subordinate) {
                $childNode = $buildHierarchy($subordinate->EmployeeID, $level + 1);
                if ($childNode) {
                    $node['children'][] = $childNode;
                }
            }
    
            return $node;
        };
    
        // Start building the hierarchy from the root employee
        $hierarchy = $buildHierarchy($EmployeeID);
    
        // Return the resulting hierarchy
        return $hierarchy;
    }
    
    private function getSubordinates($EmployeeID, &$processed, &$chain, $level)
    {
        // Check if the current employee has already been processed (to avoid infinite recursion)
        if (in_array($EmployeeID, $processed)) {
            return;
        }
    
        // Mark the current employee as processed
        $processed[] = $EmployeeID;
    
        // Get employees who report to the given EmployeeID
        $employeesReportingTo = DB::table('hrm_employee_general')
            ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)  // Find reports to this employee
            ->where('hrm_employee.EmpStatus', 'A')  // Only select active employees
            ->leftJoin('core_designation as d', 'd.id', '=', 'hrm_employee_general.DesigId') // Join with the designation table
            ->leftJoin('core_grades as g', 'hrm_employee_general.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
            ->get();  // Fetch the results
    
        // Loop through the found employees and add them to the chain
        foreach ($employeesReportingTo as $employee) {
            // Add the employee to the chain (formatted for D3)
            $chain[] = [
                'EmployeeID' => $employee->EmployeeID,
                'RepEmployeeID' => $employee->RepEmployeeID,  // The employee they report to
                'Fname' => $employee->Fname,
                'Sname' => $employee->Sname,
                'Lname' => $employee->Lname,
                'DesigName' => $employee->DesigName,
                'Grade' => $employee->GradeValue,
                'level' => $level // Add the level of the employee
            ];
    
            // Recursively find employees reporting to the current employee
            $this->getSubordinates($employee->EmployeeID, $processed, $chain, $level + 1);
        }
    }
    

    

    
    public function getEmployeeTeam($employeeID)
    {
        // Fetch employees reporting to the given EmployeeID
        $team = DB::table('hrm_employee_general')
                  ->leftJoin('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                  ->where('hrm_employee_general.RepEmployeeID', $employeeID)
                  ->where('hrm_employee.EmpStatus', 'A')
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
            ->leftJoin('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId')
            ->leftJoin('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID')
            ->whereIn('ctp.EmployeeID', $employeeIds)
            ->where('e.EmpStatus', 'A')
            ->select('ct.*', 'e.Fname', 'e.Lname', 'e.Sname')
            ->get();

        // Group the data by employee full name (Fname + Lname + Sname)
        $groupedTrainingData = $trainingData->groupBy(function($item) {
            return $item->Fname . ' ' . $item->Sname . ' ' . $item->Lname;
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
            ->leftJoin('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId')
            ->leftJoin('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID')
            ->whereIn('ctp.EmployeeID', $employeeIds)
            ->where('e.EmpStatus', 'A')
            ->select('ct.*', 'e.Fname', 'e.Lname', 'e.Sname')
            ->get();

        // Group the data by employee full name (Fname + Lname + Sname)
        $groupedTrainingData = $trainingData->groupBy(function($item) {
            return $item->Fname . ' ' . $item->Sname . ' ' . $item->Lname;
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
   

        $eligibilitydata = \DB::table('hrm_employee_eligibility as ee')
        ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
        ->leftJoin('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID') // Join with employee general table
        ->leftJoin('core_designation as d', 'd.id', '=', 'eg.DesigId') // Join with the designation table
        ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
        ->leftJoin('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table to fetch net, gross, and deductions
        ->where('ee.EmployeeID', $employee->EmployeeID)
        ->where('e.EmpStatus', 'A')
        ->where("ctc.Status",'=','A')
        ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
        ->select(
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.EmpCode',
            'd.designation_name',
            'g.grade_name', 
            'eg.DesigId', // Include designation ID
            'd.designation_name', // Fetch the designation name from the designation table
            'ee.*', // Fetch all columns from hrm_employee_eligibility
            'ctc.NetMonthSalary_Value as NetSalary', // Fetch Net Salary from CTC table
            'ctc.Tot_GrossMonth as GrossSalary', // Fetch Gross Salary from CTC table
            'ctc.Tot_Gross_Annual as GrossAnnualSalary',
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
                               ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
                               ->leftJoin('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID') // Join with employee general table
                               ->leftJoin('core_designation as d', 'd.id', '=', 'eg.DesigId') // Join with the designation table
                               ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
                               ->leftJoin('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table to fetch net, gross, and deductions
                               ->whereIn('ee.EmployeeID', $employeeIds)
                               ->where('e.EmpStatus', 'A')
                               ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
                               ->where("ctc.Status",'=','A')
                               ->select(
                                   'e.Fname',
                                   'e.Lname',
                                   'e.Sname',
                                   'e.EmpCode',
                                   'd.designation_name',
                                   'g.grade_name', 
                                   'eg.DesigId', // Include designation ID
                                   'd.designation_name', // Fetch the designation name from the designation table
                                   'ee.*', // Fetch all columns from hrm_employee_eligibility
                                   'ctc.NetMonthSalary_Value as NetSalary', // Fetch Net Salary from CTC table
                                   'ctc.Tot_GrossMonth as GrossSalary', // Fetch Gross Salary from CTC table
                                   'ctc.Tot_Gross_Annual as GrossAnnualSalary', 
                                    'ctc.Tot_CTC as TotalCTC'
                                )
                               ->get();
        $eligibility[] = $eligibilitydata; // This will store eligibility data for each employee

                           

// Get current month and year
$currentMonth = Carbon::now()->format('m');  // Current month in 'mm' format
$currentYear = Carbon::now()->format('Y');  // Current year in 'yyyy' format
// Fetch the monthly payslip data for the current month and year
$monthlyPayslip = \DB::table('hrm_employee_monthlypayslip as ems')
    ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'ems.EmployeeID')  // Join with the employee table
    ->leftJoin('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID')  // Join with the employee general table
    ->leftJoin('core_designation as d', 'd.id', '=', 'eg.DesigId')  // Join with the designation table
    ->whereMonth('ems.Month', '=', $currentMonth)  // Filter by the current month
    ->whereYear('ems.Year', '=', $currentYear)  // Filter by the current year
    ->whereIn('ems.EmployeeID', $employeeIds)  // Fetch data for specific employees
    ->select(
        'e.Fname',
        'e.Lname',
        'e.Sname',
        'e.empcode',
        'eg.DesigId',
        'd.designation_name',
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
    $assets_request = [];

    $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();
        if($isHodView){

            $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
            $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            // $assets_request = [];

            foreach ($employeeChain as $employee) {
                $empid = $employee->EmployeeID;
            
                $assets_requests = DB::table('hrm_asset_employee_request')
                    // Join with the hrm_employee table to filter by EmpStatus
                    ->leftJoin('hrm_employee as e', 'hrm_asset_employee_request.EmployeeID', '=', 'e.EmployeeID')
                    ->leftJoin('hrm_employee_general as eg', 'hrm_asset_employee_request.EmployeeID', '=', 'eg.EmployeeID')
                    ->where('e.EmpStatus', 'A')
                    ->where('hrm_asset_employee_request.EmployeeID','=',$empid)
                    ->select(
                        'e.Fname',
                        'e.Lname',
                        'e.Sname',
                        'e.EmpCode','eg.MobileNo_Vnr',
                        'hrm_asset_employee_request.*',
                    )
                    // // Fetch asset requests for employees with the given role IDs
                    // ->where(function ($query) use ($empid) {
                    //     $query->where('ReportingId', $empid)
                    //         ->orWhere('HodId', $empid);
                    // })
                    // ->when(true, function ($query) use ($empid) {
                    //     $query->orWhere(function ($subQuery) use ($empid) {
                    //         $subQuery->where('ITId', $empid)
                    //             ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
                    //     });
                    // })
                    // ->when(true, function ($query) use ($empid) {
                    //     $query->orWhere(function ($subQuery) use ($empid) {
                    //         $subQuery->where('AccId', $empid)
                    //             ->where('HODApprovalStatus', 1)
                    //             ->where('ITApprovalStatus', 1); // Include AccId only when HODApprovalStatus = 1 and ITApprovalStatus = 1
                    //     });
                    // })
                    ->get();
                    $assets_request[] = $assets_requests;

            }
            return view("employee.teamassets",compact('assets_request','isReviewer'));

        }

        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->leftJoin('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $EmployeeID)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists
            if($exists){
                foreach ($employeesReportingTo as $employee) {
                    $empid = $employee->EmployeeID;
                
                    $assets_requests = DB::table('hrm_asset_employee_request')
                        // Join with the hrm_employee table to filter by EmpStatus
                        ->leftJoin('hrm_employee as e', 'hrm_asset_employee_request.EmployeeID', '=', 'e.EmployeeID')
                        ->leftJoin('hrm_employee_general as eg', 'hrm_asset_employee_request.EmployeeID', '=', 'eg.EmployeeID')
                        ->where('e.EmpStatus', 'A')
                        ->where('hrm_asset_employee_request.EmployeeID','=',$empid)
                        ->select(
                            'e.Fname',
                            'e.Lname',
                            'e.Sname',
                            'e.EmpCode','eg.MobileNo_Vnr',
                            'hrm_asset_employee_request.*',
                        )
                        // // Fetch asset requests for employees with the given role IDs
                        // ->where(function ($query) use ($empid) {
                        //     $query->where('ReportingId', $empid)
                        //         ->orWhere('HodId', $empid);
                        // })
                        // ->when(true, function ($query) use ($empid) {
                        //     $query->orWhere(function ($subQuery) use ($empid) {
                        //         $subQuery->where('ITId', $empid)
                        //             ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
                        //     });
                        // })
                        // ->when(true, function ($query) use ($empid) {
                        //     $query->orWhere(function ($subQuery) use ($empid) {
                        //         $subQuery->where('AccId', $empid)
                        //             ->where('HODApprovalStatus', 1)
                        //             ->where('ITApprovalStatus', 1); // Include AccId only when HODApprovalStatus = 1 and ITApprovalStatus = 1
                        //     });
                        // })
                        ->get();
                        $assets_request[] = $assets_requests;

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
                $queries = DB::table('hrm_employee_queryemp')
                    ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
                    ->leftJoin('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id')
                    ->leftJoin('hrm_deptquerysub', 'hrm_employee_queryemp.QSubjectId', '=', 'hrm_deptquerysub.DeptQSubId')  // Join core_departments based on DepartmentId
                    ->select(
                        'hrm_employee_queryemp.*',
                        'core_departments.department_name',
                        'hrm_deptquerysub.DeptQSubject'       // Select all fields from hrm_Department
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

                         $forwardFields = [
                            'Level_1QFwdEmpId', 'Level_1QFwdEmpId2', 'Level_1QFwdEmpId3',
                            'Level_2QFwdEmpId', 'Level_2QFwdEmpId2', 'Level_2QFwdEmpId3',
                            'Level_3QFwdEmpId', 'Level_3QFwdEmpId2', 'Level_3QFwdEmpId3',
                        ];

                        // Build a map of EmployeeID => full name for all forward IDs
                        $allForwardIds = collect($forwardFields)->map(fn($f) => $query->$f)->filter()->unique();

                        $forwardedEmpMap = \DB::table('hrm_employee as e')
                            ->leftJoin('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                            ->leftJoin('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                            ->whereIn('e.EmployeeID', $allForwardIds)
                            ->select(
                                'e.EmployeeID',
                                'e.Fname',
                                'e.Sname',
                                'e.Lname',
                                'd.department_name'
                            )
                            ->get()
                            ->mapWithKeys(function ($emp) {
                                $fullName = trim("{$emp->Fname} {$emp->Sname} {$emp->Lname}");
                                $dept = $emp->department_name ?: 'N/A';
                                return [$emp->EmployeeID => $fullName . ' (' . $dept . ')'];
                            });


                        // Now attach each forward name back to the query object in order
                        foreach ($forwardFields as $field) {
                            $empId = $query->$field;
                            $query->{$field . '_name'} = $empId && isset($forwardedEmpMap[$empId]) ? $forwardedEmpMap[$empId] : null;
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
                ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
                ->leftJoin('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id')
                ->leftJoin('hrm_deptquerysub', 'hrm_employee_queryemp.QSubjectId', '=', 'hrm_deptquerysub.DeptQSubId')  // Join core_departments based on DepartmentId
                ->select(
                    'hrm_employee_queryemp.*',
                    'core_departments.department_name',
                    'hrm_deptquerysub.DeptQSubject'       // Select all fields from hrm_Department
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
        
                        $forwardFields = [
                            'Level_1QFwdEmpId', 'Level_1QFwdEmpId2', 'Level_1QFwdEmpId3',
                            'Level_2QFwdEmpId', 'Level_2QFwdEmpId2', 'Level_2QFwdEmpId3',
                            'Level_3QFwdEmpId', 'Level_3QFwdEmpId2', 'Level_3QFwdEmpId3',
                        ];

                        // Build a map of EmployeeID => full name for all forward IDs
                        $allForwardIds = collect($forwardFields)->map(fn($f) => $query->$f)->filter()->unique();

                        $forwardedEmpMap = DB::table('hrm_employee')
                            ->whereIn('EmployeeID', $allForwardIds)
                            ->select('EmployeeID', 'Fname', 'Sname', 'Lname')
                            ->get()
                            ->mapWithKeys(function ($emp) {
                                return [$emp->EmployeeID => trim("{$emp->Fname} {$emp->Sname} {$emp->Lname}")];
                            });

                        // Now attach each forward name back to the query object in order
                        foreach ($forwardFields as $field) {
                            $empId = $query->$field;
                            $query->{$field . '_name'} = $empId && isset($forwardedEmpMap[$empId]) ? $forwardedEmpMap[$empId] : null;
                        }

                        $queriesteam[] = $query;
                    }
                }
            }
        }
        return response()->json($queriesteam);
    }
   public function teamleaveatt(Request $request)
{
    $EmployeeID = Auth::user()->EmployeeID;
    $isHodView = $request->has('hod_view');
    $currentYear = now()->year;
    $currentMonth = now()->month;
    $selectedMonth = $request->input('month', $currentMonth);
    $daysInMonth = Carbon::createFromDate($currentYear, $selectedMonth)->daysInMonth;

    $isReviewer = DB::table('hrm_employee_reporting')
        ->where('ReviewerId', $EmployeeID)
        ->exists();

    $attendanceData = [];
    $empdataleaveattdata = [];

    $employeeChain = $isHodView
        ? $this->getEmployeeReportingChain($EmployeeID)
        : DB::table('hrm_employee_general')->where('RepEmployeeID', $EmployeeID)->get();

    $dailyreports = DB::table("hrm_employee_moreve_report_{$currentYear} as r")
        ->leftJoin('hrm_employee as e', 'r.EmployeeID', '=', 'e.EmployeeID')
        ->leftJoin('hrm_employee_general as g', 'r.EmployeeID', '=', 'g.EmployeeID')
        ->leftJoin('hrm_employee_personal as p', 'r.EmployeeID', '=', 'p.EmployeeID')
        ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
        ->where('g.RepEmployeeID', $EmployeeID)
        ->when($request->month, fn($q) => $q->whereMonth('r.MorEveDate', $request->month))
        ->when($request->employee, fn($q) => $q->where('r.EmployeeID', $request->employee))
        ->select([
            'r.*', 'g.DepartmentId', 'g.DesigId', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname',
            'p.Married', 'p.Gender', 'hq.city_village_name', 'p.DR'
        ])->get();

    foreach ($employeeChain as $employee) {
        $empId = $employee->EmployeeID;

        $attendance = DB::table('hrm_employee_attendance as a')
            ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'a.EmployeeID')
            ->where('a.EmployeeID', $empId)
            ->whereDate('a.AttDate', now())
            ->select('a.Inn', 'a.Outt', 'e.Fname', 'e.Sname', 'e.Lname')
            ->get();

        $attendanceSummary = DB::table('hrm_employee_attendance as a')
            ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'a.EmployeeID')
            ->where('a.EmployeeID', $empId)
            ->whereYear('a.AttDate', $currentYear)
            ->whereMonth('a.AttDate', $currentMonth)
            ->select(
                'a.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode',
                DB::raw('COUNT(CASE WHEN a.AttValue = "P" THEN 1 END) as Present'),
                DB::raw('COUNT(CASE WHEN a.AttValue = "A" THEN 1 END) as Absent'),
                DB::raw('COUNT(CASE WHEN a.AttValue = "OD" THEN 1 END) as OD'),
                DB::raw('COUNT(CASE WHEN a.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
            )
            ->groupBy('a.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode')
            ->get();

        $leaveApplications = DB::table('hrm_employee_applyleave as l')
            ->leftJoin('hrm_employee as e', 'l.EmployeeID', '=', 'e.EmployeeID')
            ->where('l.EmployeeID', $empId)
            ->whereNull('l.deleted_at')
            ->whereYear('l.Apply_Date', $currentYear)
            ->select('l.*', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode', 'e.EmployeeID')
            ->get()
            ->map(function ($item) use ($employee) {
                $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID);
                return $item;
            });

        $requestsAttendance = AttendanceRequest::join('hrm_employee as e', 'e.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
            ->where('hrm_employee_attendance_req.EmployeeID', $empId)
            ->whereStatus('0')
            ->whereYear('hrm_employee_attendance_req.AttDate', $currentYear)
            ->select('e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode', 'e.EmployeeID', 'hrm_employee_attendance_req.*')
            ->orderByDesc('hrm_employee_attendance_req.AttDate')
            ->get()
            ->map(function ($item) use ($employee) {
                $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID);
                return $item;
            });

        $requestsAttendanceApproved = AttendanceRequest::join('hrm_employee as e', 'e.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
            ->where('hrm_employee_attendance_req.EmployeeID', $empId)
            ->whereStatus('1')
            ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)
            ->select('e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode', 'e.EmployeeID', 'hrm_employee_attendance_req.*')
            ->get();

        $query = DB::table('hrm_employee as e')
            ->leftJoin('hrm_employee_attendance as a', function ($join) use ($selectedMonth, $currentYear) {
                $join->on('a.EmployeeID', '=', 'e.EmployeeID')
                    ->whereYear('a.AttDate', $currentYear)
                    ->whereMonth('a.AttDate', $selectedMonth);
            })
            ->leftJoin('hrm_employee_monthlyleave_balance as l', function ($join) use ($selectedMonth, $currentYear) {
                $join->on('l.EmployeeID', '=', 'e.EmployeeID')
                    ->where('l.Month', '=', $selectedMonth)
                    ->where('l.Year', '=', $currentYear);
            })
            ->where('e.EmployeeID', $empId)
            ->where('e.EmpStatus', 'A')
            ->select(
                'e.EmployeeID', 'e.Fname', 'e.Lname', 'e.Sname', 'e.empcode',
                'l.OpeningCL', 'l.OpeningPL', 'l.OpeningEL', 'l.OpeningOL', 'l.OpeningSL',
                'l.BalanceCL', 'l.BalancePL', 'l.BalanceEL', 'l.BalanceOL', 'l.BalanceSL'
            );

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.AttValue END) AS day_$i"));
            $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Inn END) AS Inn_$i"));
            $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Outt END) AS Outt_$i"));
        }

        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "OD" THEN 1 ELSE 0 END) AS total_OD'));
        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "A" THEN 1 ELSE 0 END) AS total_A'));
        $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "P" THEN 1 ELSE 0 END) AS total_P'));

        $query->groupBy(
            'e.EmployeeID', 'e.Fname', 'e.Lname', 'e.Sname', 'e.empcode',
            'l.OpeningCL', 'l.OpeningPL', 'l.OpeningEL', 'l.OpeningOL', 'l.OpeningSL',
            'l.BalanceCL', 'l.BalancePL', 'l.BalanceEL', 'l.BalanceOL', 'l.BalanceSL'
        );

        $empdataleaveattdata[] = $query->get();

        $leaveBalances = DB::table('hrm_employee_monthlyleave_balance as l')
            ->leftJoin('hrm_employee as e', 'l.EmployeeID', '=', 'e.EmployeeID')
            ->where('l.EmployeeID', $empId)
            ->where('l.Year', $currentYear)
            ->where('l.Month', $currentMonth)
            ->select('l.*', 'e.Fname', 'e.Sname', 'e.EmpCode')
            ->get();

        $attendanceData[] = [
            'attendance' => $attendance,
            'attendanceSummary' => $attendanceSummary,
            'leaveApplications' => $leaveApplications,
            'leaveBalances' => $leaveBalances,
            'attendnacerequest' => $requestsAttendance,
            'approved_attendnace_status' => $requestsAttendanceApproved,
            'approved_leave_request' => $leaveApplications
        ];
    }

    return view('employee.teamleaveatt', compact(
        'selectedMonth', 'attendanceData', 'empdataleaveattdata',
        'daysInMonth', 'isReviewer', 'isHodView', 'dailyreports'
    ));
}

    // public function teamleaveatt(Request $request)
    // {
        
    //     $EmployeeID = Auth::user()->EmployeeID;
    //     $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
    //     $currentYear = now()->year;
    //     $currentMonth = now()->month;
       
    //     // Capture the selected month from the request
    //     $selectedMonth = $request->input('month', $currentMonth); // Default to current month if no input
        
    //     // Calculate the month that is two months ago
    //     $twoMonthsBack = now()->subMonths(2)->month;
        
    //     $attendanceTable = 'hrm_employee_attendance';
       

    //     // Calculate the number of days in the selected month
    //     $daysInMonth = Carbon::createFromDate($currentYear, $selectedMonth)->daysInMonth;
    //     $isReviewer = \DB::table('hrm_employee_reporting')
    //                 ->where('ReviewerId', Auth::user()->EmployeeID)
    //                 ->exists();  // Returns true if the EmployeeID is found in ReviewerID

    //         $attendanceData = [];
    //         if($isHodView){
    //                 $employeeChain = $this->getEmployeeReportingChain($EmployeeID);
    //                 foreach ($employeeChain as $employee) {
    //                     $attendance = \DB::table('hrm_employee_attendance')
    //                     ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
    //                     ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
    //                     ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
    //                     ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
    //                     ->get(); // Get attendance records for the employee

    //                     $requestsAttendnace_approved = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
    //                     ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
    //                     ->whereStatus('1')  // Assuming 0 means pending requests
    //                     ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
    //                     ->select(
    //                         'hrm_employee.Fname',
    //                         'hrm_employee.Lname',
    //                         'hrm_employee.Sname',
    //                         'hrm_employee.EmpCode',
    //                         'hrm_employee.EmployeeID',
    //                         'hrm_employee_attendance_req.*'
    //                     )
    //                     ->get();

    //                     $currentYear = now()->year;  // Get the current year
    //                     $currentMonth = now()->month;  // Get the current month

    //                     // Fetch attendance data for all employees in the current month and year
    //                     $attendanceSummary = \DB::table('hrm_employee_attendance')
    //                         ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
    //                         ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
    //                         ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
    //                         ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                            
    //                         ->select(
    //                             'hrm_employee_attendance.EmployeeID',
    //                             'hrm_employee.Fname',
    //                             'hrm_employee.Sname',
    //                             'hrm_employee.Lname',
    //                             'hrm_employee.EmpCode',
    //                             \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
    //                             \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
    //                             \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
    //                             \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
    //                         )  // Select the required fields and counts for each attendance value
    //                         ->groupBy(
    //                             'hrm_employee_attendance.EmployeeID',
    //                             'hrm_employee.Fname',
    //                             'hrm_employee.Sname',
    //                             'hrm_employee.Lname',
    //                             'hrm_employee.EmpCode'
    //                         )
    //                         ->get();  // Execute the query and get the results
    //                         $leaveApplications = \DB::table('hrm_employee_applyleave')
    //                         ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
    //                         ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                         ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
    //                         ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
    //                         // ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
    //                         // ->where('hrm_employee_applyleave.LeaveStatus', '=', '0')
    //                         ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
    //                         'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_Date',
    //                         'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define','hrm_employee_applyleave.Apply_DuringAddress',
    //                         'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
    //                         ->get();
    //                         $leaveApplications = $leaveApplications->map(function($item) use ($employee) {
    //                             $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
    //                             return $item;
    //                         });
    //                         $leaveApplications_approval = \DB::table('hrm_employee_applyleave')
    //                         ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
    //                         ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                         ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
    //                         ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
    //                         // ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
    //                         // ->where('hrm_employee_applyleave.LeaveStatus', '=', '1')
    //                         ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
    //                         'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_Date',
    //                         'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
    //                         'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
    //                         ->get();
    //                         $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
    //                     ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
    //                     ->whereStatus('0')  // Assuming 0 means pending requests
    //                     ->whereYear('hrm_employee_attendance_req.AttDate', $currentYear)  // Filter by current year
    //                     // ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
    //                     ->select(
    //                         'hrm_employee.Fname',
    //                         'hrm_employee.Lname',
    //                         'hrm_employee.Sname',
    //                         'hrm_employee.EmpCode',
    //                         'hrm_employee.EmployeeID',
    //                         'hrm_employee_attendance_req.*'
    //                     )
    //                     ->orderBy('hrm_employee_attendance_req.AttDate', 'desc')  // Order by Attendance Date in descending order
    //                     ->get();
    //                     $requestsAttendnace = $requestsAttendnace->map(function($item) use ($employee) {
    //                         $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
    //                         return $item;
    //                     });
    //                     $year = $request->input('Y', date('Y'));
    //                     $month = $request->input('m', date('m'));
    //                     $tableName = "hrm_employee_moreve_report_" . $year;

    //                     $dailyreportsQuery = DB::table($tableName . ' as r')
    //                     ->leftJoin('hrm_employee as e', 'r.EmployeeID', '=', 'e.EmployeeID')
    //                     ->leftJoin('hrm_employee_general as g', 'r.EmployeeID', '=', 'g.EmployeeID')
    //                     ->leftJoin('hrm_employee_personal as p', 'r.EmployeeID', '=', 'p.EmployeeID')
    //                     ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id') // Join with Headquater table
    //                     ->where('g.RepEmployeeID',  Auth::user()->EmployeeID)
    //                     ->select([
    //                         'r.*',
    //                         'g.DepartmentId',
    //                         'g.DesigId',
    //                         'e.EmpCode',
    //                         'e.Fname',
    //                         'e.Sname',
    //                         'e.Lname',
    //                         'p.Married',
    //                         'p.Gender',
    //                         'hq.city_village_name',
    //                         'p.DR'
    //                     ]);
                
    //                 // Apply month and employee filters if selected
    //                 if ($request->month) {
    //                     $dailyreportsQuery->whereMonth('r.MorEveDate', $request->month);
    //                 }
                
    //                 if ($request->employee) {
    //                     $dailyreportsQuery->where('r.EmployeeID', $request->employee);
    //                 }
                
    //                 // Get daily reports
    //                 $dailyreports = $dailyreportsQuery->get();
                            
    //                             // Build the query for attendance details and balances
    //                 $emploid = $employee->EmployeeID;

    //                 $query = DB::table('hrm_employee as e')  // Start from employee table now
    //                 ->leftJoin($attendanceTable . ' as a', function($join) use ($selectedMonth, $currentYear) {
    //                     $join->on('a.EmployeeID', '=', 'e.EmployeeID')
    //                         ->whereYear('a.AttDate', $currentYear)
    //                         ->whereMonth('a.AttDate', $selectedMonth);
    //                 })
    //                 ->leftJoin('hrm_employee_monthlyleave_balance as l', function($join) use ($selectedMonth, $currentYear) {
    //                     $join->on('l.EmployeeID', '=', 'e.EmployeeID')
    //                         ->where('l.Month', '=', $selectedMonth)
    //                         ->where('l.Year', '=', $currentYear);
    //                 })
    //                 ->where('e.EmployeeID', $emploid)    // Filter employee ID from employee table
    //                 ->where('e.EmpStatus', 'A')
    //                 ->select(
    //                     'e.EmployeeID',
    //                     'e.Fname',
    //                     'e.Lname',
    //                     'e.Sname',
    //                     'e.empcode',
    //                     'l.OpeningCL',
    //                     'l.OpeningPL',
    //                     'l.OpeningEL',
    //                     'l.OpeningOL',
    //                     'l.OpeningSL',
    //                     'l.BalanceCL',
    //                     'l.BalancePL',
    //                     'l.BalanceEL',
    //                     'l.BalanceOL',
    //                     'l.BalanceSL'
    //                 );

    //                 // Your loop for days — same as before
    //                 for ($i = 1; $i <= $daysInMonth; $i++) {
    //                     $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.AttValue END) AS day_$i"));
    //                     $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Inn END) AS Inn_$i"));
    //                     $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Outt END) AS Outt_$i"));
    //                 }

    //                 // Totals — unchanged
    //                 $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "OD" THEN 1 ELSE 0 END) AS total_OD'));
    //                 $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "A" THEN 1 ELSE 0 END) AS total_A'));
    //                 $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "P" THEN 1 ELSE 0 END) AS total_P'));

    //                 // Group by employee and leave balance fields — only change 'a.EmployeeID' to 'e.EmployeeID'
    //                 $query->groupBy(
    //                 'e.EmployeeID',
    //                 'e.Fname',
    //                 'e.Lname',
    //                 'e.Sname',
    //                 'e.empcode',
    //                 'l.OpeningCL',
    //                 'l.OpeningPL',
    //                 'l.OpeningEL',
    //                 'l.OpeningOL',
    //                 'l.OpeningSL',
    //                 'l.BalanceCL',
    //                 'l.BalancePL',
    //                 'l.BalanceEL',
    //                 'l.BalanceOL',
    //                 'l.BalanceSL'
    //                 );


    //                 // Execute the query
    //                 $empdataleaveattdata[] = $query->get();
                            
    //                         $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
    //                                 ->leftJoin('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
    //                                 ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                                 ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
    //                                 ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
    //                                 ->select(
    //                                     'hrm_employee_monthlyleave_balance.EmployeeID',
    //                                     'hrm_employee_monthlyleave_balance.OpeningCL',
    //                                     'hrm_employee_monthlyleave_balance.AvailedCL',
    //                                     'hrm_employee_monthlyleave_balance.BalanceCL',
    //                                     'hrm_employee_monthlyleave_balance.OpeningSL',
    //                                     'hrm_employee_monthlyleave_balance.AvailedSL',
    //                                     'hrm_employee_monthlyleave_balance.BalanceSL',
    //                                     'hrm_employee_monthlyleave_balance.OpeningPL',
    //                                     'hrm_employee_monthlyleave_balance.AvailedPL',
    //                                     'hrm_employee_monthlyleave_balance.BalancePL',
    //                                     'hrm_employee_monthlyleave_balance.OpeningEL',
    //                                     'hrm_employee_monthlyleave_balance.AvailedEL',
    //                                     'hrm_employee_monthlyleave_balance.BalanceEL',
    //                                     'hrm_employee_monthlyleave_balance.OpeningOL',
    //                                     'hrm_employee_monthlyleave_balance.AvailedOL',
    //                                     'hrm_employee_monthlyleave_balance.BalanceOL',
    //                                     'hrm_employee_monthlyleave_balance.EC',
    //                                     'hrm_employee.Fname',
    //                                     'hrm_employee.Sname',
    //                                     'hrm_employee.EmpCode'
    //                                 )
    //                                 ->get();
                            
    //                     $attendanceData[] = [
    //                     'attendance' => $attendance,
    //                     'attendanceSummary'=>$attendanceSummary,
    //                     'leaveApplications'=>$leaveApplications,
    //                     'leaveBalances'=>$leaveBalances,
    //                     'attendnacerequest'=>$requestsAttendnace,
    //                     'approved_attendnace_status'=>$requestsAttendnace_approved,
    //                     'approved_leave_request'=>$leaveApplications_approval,
    //                 ];
    //                 }
                                
    //                 return view('employee.teamleaveatt',compact('selectedMonth','attendanceData','empdataleaveattdata','daysInMonth','isReviewer','isHodView','dailyreports'));
    //         }

    //     $employeesReportingTo = \DB::table('hrm_employee_general')
    //         ->where('RepEmployeeID', $EmployeeID)
    //         ->get();  // Get all employees reporting to the RepEmployeeID
                
     
    //         foreach ($employeesReportingTo as $employee) {
    //             $attendance = \DB::table('hrm_employee_attendance')
    //             ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
    //             ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
    //             ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
    //             ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
    //             ->get(); // Get attendance records for the employee
                
    //             $currentYear = now()->year;  // Get the current year
    //             $currentMonth = now()->month;  // Get the current month

    //             // Fetch attendance data for all employees in the current month and year
    //             $attendanceSummary = \DB::table('hrm_employee_attendance')
    //                 ->leftJoin('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
    //                 ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
    //                 ->whereYear('hrm_employee_attendance.AttDate', $currentYear)  // Filter by current year
    //                 ->whereMonth('hrm_employee_attendance.AttDate', $currentMonth)  // Filter by current month
                    
    //                 ->select(
    //                     'hrm_employee_attendance.EmployeeID',
    //                     'hrm_employee.Fname',
    //                     'hrm_employee.Sname',
    //                     'hrm_employee.Lname',
    //                     'hrm_employee.EmpCode',
    //                     \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "P" THEN 1 END) as Present'),
    //                     \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "A" THEN 1 END) as Absent'),
    //                     \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue = "OD" THEN 1 END) as OD'),
    //                     \DB::raw('COUNT(CASE WHEN hrm_employee_attendance.AttValue NOT IN ("P", "A", "OD") THEN 1 END) as Other')
    //                 )  // Select the required fields and counts for each attendance value
    //                 ->groupBy(
    //                     'hrm_employee_attendance.EmployeeID',
    //                     'hrm_employee.Fname',
    //                     'hrm_employee.Sname',
    //                     'hrm_employee.Lname',
    //                     'hrm_employee.EmpCode'
    //                 )
    //                 ->get();  // Execute the query and get the results
    //                 $leaveApplications = \DB::table('hrm_employee_applyleave')
    //                 ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
    //                 ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                 ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
    //                 ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
    //                 // ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
    //                 // ->where('hrm_employee_applyleave.LeaveStatus', '=', '0')
    //                 ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
    //                 'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_Date',
    //                 'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define','hrm_employee_applyleave.Apply_DuringAddress',
    //                  'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname','hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
    //                 ->get();
                    
    //                 $leaveApplications = $leaveApplications->map(function($item) use ($employee) {
    //                     $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
    //                     return $item;
    //                 });
    //                 $year = $request->input('Y', date('Y'));
    //                 $month = $request->input('m', date('m'));
    //                 $tableName = "hrm_employee_moreve_report_" . $year;

    //                 $dailyreportsQuery = DB::table($tableName . ' as r')
    //                 ->leftJoin('hrm_employee as e', 'r.EmployeeID', '=', 'e.EmployeeID')
    //                 ->leftJoin('hrm_employee_general as g', 'r.EmployeeID', '=', 'g.EmployeeID')
    //                 ->leftJoin('hrm_employee_personal as p', 'r.EmployeeID', '=', 'p.EmployeeID')
    //                 ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id') // Join with Headquater table
    //                 ->where('g.RepEmployeeID',  Auth::user()->EmployeeID)
    //                 ->select([
    //                     'r.*',
    //                     'g.DepartmentId',
    //                     'g.DesigId',
    //                     'e.EmpCode',
    //                     'e.Fname',
    //                     'e.Sname',
    //                     'e.Lname',
    //                     'p.Married',
    //                     'p.Gender',
    //                     'hq.city_village_name',
    //                     'p.DR'
    //                 ]);
            
    //             // Apply month and employee filters if selected
    //             if ($request->month) {
    //                 $dailyreportsQuery->whereMonth('r.MorEveDate', $request->month);
    //             }
            
    //             if ($request->employee) {
    //                 $dailyreportsQuery->where('r.EmployeeID', $request->employee);
    //             }
            
    //             // Get daily reports
    //             $dailyreports = $dailyreportsQuery->get();

    //                 $leaveApplications_approval = \DB::table('hrm_employee_applyleave')
    //                     ->leftJoin('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
    //                     ->where('hrm_employee_applyleave.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                     ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
    //                     ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
    //                     // ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
    //                     // ->where('hrm_employee_applyleave.LeaveStatus', '=', '1')
    //                     ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
    //                     'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus','hrm_employee_applyleave.Apply_Date',
    //                     'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay','hrm_employee_applyleave.half_define',
    //                     'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
    //                     ->get();
    //                 $requestsAttendnace = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
    //                 ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
    //                 ->whereStatus('0')  // Assuming 0 means pending requests
    //                 ->whereYear('hrm_employee_attendance_req.AttDate', $currentYear)  // Filter by current year
    //                 // ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
    //                 ->select(
    //                     'hrm_employee.Fname',
    //                     'hrm_employee.Lname',
    //                     'hrm_employee.Sname',
    //                     'hrm_employee.EmpCode',
    //                     'hrm_employee.EmployeeID',
    //                     'hrm_employee_attendance_req.*'
    //                 )
    //                 ->orderBy('hrm_employee_attendance_req.AttDate', 'desc')  // Order by Attendance Date in descending order
    //                 ->get();
    //                 $requestsAttendnace = $requestsAttendnace->map(function($item) use ($employee) {
    //                     $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
    //                     return $item;
    //                 });

    //                 $requestsAttendnace_approved = AttendanceRequest::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance_req.EmployeeID')
    //                 ->where('hrm_employee_attendance_req.EmployeeID', $employee->EmployeeID)
    //                 // ->whereStatus('1')  // Assuming 0 means pending requests
    //                 // ->whereMonth('hrm_employee_attendance_req.AttDate', $currentMonth)  // Filter by current month
    //                 ->select(
    //                     'hrm_employee.Fname',
    //                     'hrm_employee.Lname',
    //                     'hrm_employee.Sname',
    //                     'hrm_employee.EmpCode',
    //                     'hrm_employee.EmployeeID',
    //                     'hrm_employee_attendance_req.*'
    //                 )
    //                 ->get();
    //                        // Build the query for attendance details and balances
    //     $emploid = $employee->EmployeeID;

      
    //     $query = DB::table('hrm_employee as e')  // Start from employee table now
    //         ->leftJoin($attendanceTable . ' as a', function($join) use ($selectedMonth, $currentYear) {
    //             $join->on('a.EmployeeID', '=', 'e.EmployeeID')
    //                 ->whereYear('a.AttDate', $currentYear)
    //                 ->whereMonth('a.AttDate', $selectedMonth);
    //         })
    //         ->leftJoin('hrm_employee_monthlyleave_balance as l', function($join) use ($selectedMonth, $currentYear) {
    //             $join->on('l.EmployeeID', '=', 'e.EmployeeID')
    //                 ->where('l.Month', '=', $selectedMonth)
    //                 ->where('l.Year', '=', $currentYear);
    //         })
    //         ->where('e.EmployeeID', $emploid)    // Filter employee ID from employee table
    //         ->where('e.EmpStatus', 'A')
    //         ->select(
    //             'e.EmployeeID',
    //             'e.Fname',
    //             'e.Lname',
    //             'e.Sname',
    //             'e.empcode',
    //             'l.OpeningCL',
    //             'l.OpeningPL',
    //             'l.OpeningEL',
    //             'l.OpeningOL',
    //             'l.OpeningSL',
    //             'l.BalanceCL',
    //             'l.BalancePL',
    //             'l.BalanceEL',
    //             'l.BalanceOL',
    //             'l.BalanceSL'
    //         );

    //     // Your loop for days — same as before
    //     for ($i = 1; $i <= $daysInMonth; $i++) {
    //         $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.AttValue END) AS day_$i"));
    //         $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Inn END) AS Inn_$i"));
    //         $query->addSelect(DB::raw("MAX(CASE WHEN DAY(a.AttDate) = $i THEN a.Outt END) AS Outt_$i"));
    //     }

    //     // Totals — unchanged
    //     $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "OD" THEN 1 ELSE 0 END) AS total_OD'));
    //     $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "A" THEN 1 ELSE 0 END) AS total_A'));
    //     $query->addSelect(DB::raw('SUM(CASE WHEN a.AttValue = "P" THEN 1 ELSE 0 END) AS total_P'));

    //     // Group by employee and leave balance fields — only change 'a.EmployeeID' to 'e.EmployeeID'
    //     $query->groupBy(
    //         'e.EmployeeID',
    //         'e.Fname',
    //         'e.Lname',
    //         'e.Sname',
    //         'e.empcode',
    //         'l.OpeningCL',
    //         'l.OpeningPL',
    //         'l.OpeningEL',
    //         'l.OpeningOL',
    //         'l.OpeningSL',
    //         'l.BalanceCL',
    //         'l.BalancePL',
    //         'l.BalanceEL',
    //         'l.BalanceOL',
    //         'l.BalanceSL'
    //     );


    //     // Execute the query
    //     $empdataleaveattdata[] = $query->get();
                    
    //                 $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
    //                         ->leftJoin('hrm_employee', 'hrm_employee_monthlyleave_balance.EmployeeID', '=', 'hrm_employee.EmployeeID')
    //                         ->where('hrm_employee_monthlyleave_balance.EmployeeID', $employee->EmployeeID)  // Filter by EmployeeID
    //                         ->where('hrm_employee_monthlyleave_balance.Year', $currentYear)  // Filter by current year
    //                         ->where('hrm_employee_monthlyleave_balance.Month', $currentMonth)  // Filter by current month
    //                         ->select(
    //                             'hrm_employee_monthlyleave_balance.EmployeeID',
    //                             'hrm_employee_monthlyleave_balance.OpeningCL',
    //                             'hrm_employee_monthlyleave_balance.AvailedCL',
    //                             'hrm_employee_monthlyleave_balance.BalanceCL',
    //                             'hrm_employee_monthlyleave_balance.OpeningSL',
    //                             'hrm_employee_monthlyleave_balance.AvailedSL',
    //                             'hrm_employee_monthlyleave_balance.BalanceSL',
    //                             'hrm_employee_monthlyleave_balance.OpeningPL',
    //                             'hrm_employee_monthlyleave_balance.AvailedPL',
    //                             'hrm_employee_monthlyleave_balance.BalancePL',
    //                             'hrm_employee_monthlyleave_balance.OpeningEL',
    //                             'hrm_employee_monthlyleave_balance.AvailedEL',
    //                             'hrm_employee_monthlyleave_balance.BalanceEL',
    //                             'hrm_employee_monthlyleave_balance.OpeningOL',
    //                             'hrm_employee_monthlyleave_balance.AvailedOL',
    //                             'hrm_employee_monthlyleave_balance.BalanceOL',
    //                             'hrm_employee_monthlyleave_balance.EC',
    //                             'hrm_employee.Fname',
    //                             'hrm_employee.Sname',
    //                             'hrm_employee.EmpCode'
    //                         )
    //                         ->get();
                           
    //             $attendanceData[] = [
    //                 'attendance' => $attendance,
    //                 'attendanceSummary'=>$attendanceSummary,
    //                 'leaveApplications'=>$leaveApplications,
    //                 'leaveBalances'=>$leaveBalances,
    //                 'attendnacerequest'=>$requestsAttendnace,
    //                 'approved_attendnace_status'=>$requestsAttendnace_approved,
    //                 'approved_leave_request'=>$leaveApplications_approval
    //             ];
    //         }
            
    //     return view('employee.teamleaveatt',compact('selectedMonth','attendanceData','empdataleaveattdata','daysInMonth','isReviewer','isHodView','dailyreports'));
    // }
 
    public function teamcost(Request $request)
    {
        $isHodView = $request->has('hod_view');  // This will be true if the checkbox is checked
        $EmployeeID = Auth::user()->EmployeeID;
        $isReviewer = \DB::table('hrm_employee_reporting')
            ->where('ReviewerId', Auth::user()->EmployeeID)
            ->exists();  // Returns true if the EmployeeID is found in ReviewerID

            // Get all employees (flat list)
            $allEmployees = DB::table('hrm_employee as e')
            ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
            ->leftJoin('hrm_employee_ctc as c', function ($join) {
                $join->on('c.EmployeeID', '=', 'e.EmployeeID')
                    ->where('c.Status', '=', 'A');
            })
            ->where('e.EmpStatus', 'A')
            ->where('e.CompanyId', 1)
            ->select(
                'e.EmployeeID',
                DB::raw("CONCAT(e.Fname, ' ', e.Sname, ' ', e.Lname) AS EmployeeName"),
                'c.TotCtc',
                'eg.RepEmployeeID'
            )
            ->get();

        // Get the requested employee and all subordinates recursively
        $myEmployees = collect([$allEmployees->firstWhere('EmployeeID', $EmployeeID)])
            ->merge($this->getSubordinatestree($allEmployees, $EmployeeID));

        // Convert to the expected array format for tree building
        $rawEmployees = $myEmployees->map(function ($e) {
            return [
                'id' => $e->EmployeeID,
                'name' => $e->EmployeeName,
                'ctc' => (float) $e->TotCtc,
                'image' => $this->getEmployeeImage($e->EmployeeID),
                'parent' => $e->RepEmployeeID,
            ];
        })->toArray();

        // Build the tree
        $tree = $this->buildTree($rawEmployees, $EmployeeID);

        // Format it for chart or visualization
        $formattedTree = $this->formatForOrgChart($tree);



        // Get the employee IDs under the same team (where RepEmployeeID matches current user)
        // $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        if ($isHodView) {
            $employeeChain = collect($this->getEmployeeReportingChain($EmployeeID)); // Convert to collection

            // Now you can use pluck to get the EmployeeID
            $employeeIds = $employeeChain->pluck('EmployeeID');

            $ctcttotal = \DB::table('hrm_employee as e')
                ->leftJoin('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table
                ->whereIn('e.EmployeeID', $employeeIds)  // Use whereIn to handle the collection of employee IDs
                ->where('e.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
                ->where('ctc.Status', '=', 'A')  // Filter CTC status = 'A'
                //->select('ctc.Tot_CTC as TotalCTC','e.EmployeeID')
                ->sum('ctc.Tot_CTC');  // Get the sum of Tot_CTC for all employees


            // Define the months mapping
            $months = [
                4 => 'APR',
                5 => 'MAY',
                6 => 'JUN',
                7 => 'JUL',
                8 => 'AUG',
                9 => 'SEP',
                10 => 'OCT',
                11 => 'NOV',
                12 => 'DEC',
                1 => 'JAN',
                2 => 'FEB',
                3 => 'MAR',
            ];

            // Define payment heads (the attribute names in your payslip data)
            $paymentHeads = [
                // 'Gross Earning' => 'Tot_Gross', 
                'Bonus' => 'Bonus_Month',
                'Basic' => 'Basic',
                'House Rent Allowance' => 'Hra',
                'PerformancePay' => 'PP_year',
                'Bonus/ Exgeatia' => 'Bonus',
                'Special Allowance' => 'Special',
                'DA' => 'DA',
                'Arrear' => 'Arreares',
                'Leave Encash' => 'LeaveEncash',
                'Car Allowance' => 'Car_Allowance',
                'Incentive' => 'Incentive',
                'Var Remburmnt' => 'VarRemburmnt',
                'Variable Adjustment' => "VariableAdjustment",
                'City Compensatory Allowance' => 'CCA',
                'Relocation Allownace' => 'RA',
                'Arrear Basic' => 'Arr_Basic',
                'Arrear Hra' => 'Arr_Hra',
                'Arrear Spl' => 'Arr_Spl',
                'Arrear Conv' => 'Arr_Conv',
                'CEA' => 'YCea',
                'MR' => 'YMr',
                'LTA' => 'YLta',
                'Arrear Car Allowance' => 'Car_Allowance_Arr',
                'Arrear Leave Encash' => 'Arr_LvEnCash',
                'Arrear Bonus' => 'Arr_Bonus',
                'Arrear LTA Remb.' => 'Arr_LTARemb',
                'Arrear RA' => 'Arr_RA',
                'Arrear PP' => 'Arr_PP',
                'Bonus Adjustment' => 'Bonus_Adjustment',
                'Performance Incentive' => 'PP_Inc',
                'National pension scheme' => 'NPS',
            ];

            $deductionHeads = [
                // 'Gross Deduction' => 'Tot_Deduct', 
                'TDS' => 'TDS',
                'Provident Fund' => 'Tot_Pf_Employee',
                'ESIC' => 'ESCI_Employee',
                'NPS Contribution' => 'NPS_Value',
                'Arrear Pf' => 'Arr_Pf',
                'Arrear Esic' => 'Arr_Esic',
                'Voluntary Contribution' => 'VolContrib',
                'Deduct Adjustment' => 'DeductAdjmt',
                'Recovery Spl. Allow' => 'RecSplAllow',
            ];
            if (\Carbon\Carbon::now()->month >= 4) {
                // If the current month is April or later, the financial year starts from the current year
                $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
                $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
            } else {
                // If the current month is before April, the financial year started the previous year
                $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
                $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
            }

            // Fetch the current financial year record
            $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
                ->whereDate('ToDate', '=', $financialYearEnd)
                ->first();

            // Determine the previous financial year
            $previousYearStart = \Carbon\Carbon::parse($financialYearStart)->subYear()->toDateString();
            $previousYearEnd = \Carbon\Carbon::parse($financialYearEnd)->subYear()->toDateString();

            // Fetch the previous financial year record
            $previousYearRecord = HrmYear::whereDate('FromDate', '=', $previousYearStart)
                ->whereDate('ToDate', '=', $previousYearEnd)
                ->first();
            $year_id_current = $currentYearRecord->YearId;
            // Get payslip data for the employee IDs for all months
            $payslipData = PaySlip::whereIn('EmployeeID', $employeeIds)->where('PaySlipYearId', $year_id_current)
                ->select(
                    'EmployeeID',
                    'Month',
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
            return view("employee.teamcost", compact('employeeData','groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads', 'ctcttotal', 'isReviewer'));
        }
        $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->where('RepEmployeeID', $EmployeeID)  // Filter by RepEmployeeID
            ->where('hrm_employee.EmpStatus', 'A') // Filter by EmpStatus = 'A'
            ->pluck('hrm_employee_general.EmployeeID'); // Pluck the EmployeeID from EmployeeGeneral


        $ctcttotal = \DB::table('hrm_employee as e')
            ->leftJoin('hrm_employee_ctc as ctc', 'ctc.EmployeeID', '=', 'e.EmployeeID') // Join with the CTC table
            ->whereIn('e.EmployeeID', $employeeIds)  // Use whereIn to handle the collection of employee IDs
            ->where('e.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
            ->where('ctc.Status', '=', 'A')  // Filter CTC status = 'A'
            //->select('ctc.Tot_CTC as TotalCTC','e.EmployeeID')
            ->sum('ctc.Tot_CTC');  // Get the sum of Tot_CTC for all employees


        // Define the months mapping
        $months = [
            4 => 'APR',
            5 => 'MAY',
            6 => 'JUN',
            7 => 'JUL',
            8 => 'AUG',
            9 => 'SEP',
            10 => 'OCT',
            11 => 'NOV',
            12 => 'DEC',
            1 => 'JAN',
            2 => 'FEB',
            3 => 'MAR',
        ];

        // Define payment heads (the attribute names in your payslip data)
        $paymentHeads = [
            // 'Gross Earning' => 'Tot_Gross', 
            'Bonus' => 'Bonus_Month',
            'Basic' => 'Basic',
            'House Rent Allowance' => 'Hra',
            'Bonus/ Exgeatia' => 'Bonus',
            'Special Allowance' => 'Special',
            'DA' => 'DA',
            'Arrear' => 'Arreares',
            'Leave Encash' => 'LeaveEncash',
            'Car Allowance' => 'Car_Allowance',
            'Incentive' => 'Incentive',
            'Var Remburmnt' => 'VarRemburmnt',
            'Variable Adjustment' => "VariableAdjustment",
            'City Compensatory Allowance' => 'CCA',
            'Relocation Allownace' => 'RA',
            'Arrear Basic' => 'Arr_Basic',
            'Arrear Hra' => 'Arr_Hra',
            'Arrear Spl' => 'Arr_Spl',
            'Arrear Conv' => 'Arr_Conv',
            'CEA' => 'YCea',
            'MR' => 'YMr',
            'LTA' => 'YLta',
            'Arrear Car Allowance' => 'Car_Allowance_Arr',
            'Arrear Leave Encash' => 'Arr_LvEnCash',
            'Arrear Bonus' => 'Arr_Bonus',
            'Arrear LTA Remb.' => 'Arr_LTARemb',
            'Arrear RA' => 'Arr_RA',
            'Arrear PP' => 'Arr_PP',
            'Bonus Adjustment' => 'Bonus_Adjustment',
            'Performance Incentive' => 'PP_Inc',
            'National pension scheme' => 'NPS',
            'PerformancePay' => 'PP_year',
        ];

        $deductionHeads = [
            // 'Gross Deduction' => 'Tot_Deduct', 
            'TDS' => 'TDS',
            'Provident Fund' => 'Tot_Pf_Employee',
            'ESIC' => 'ESCI_Employee',
            'NPS Contribution' => 'NPS_Value',
            'Arrear Pf' => 'Arr_Pf',
            'Arrear Esic' => 'Arr_Esic',
            'Voluntary Contribution' => 'VolContrib',
            'Deduct Adjustment' => 'DeductAdjmt',
            'Recovery Spl. Allow' => 'RecSplAllow',
        ];
        if (\Carbon\Carbon::now()->month >= 4) {
            // If the current month is April or later, the financial year starts from the current year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
        } else {
            // If the current month is before April, the financial year started the previous year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
        }

        // Fetch the current financial year record
        $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
            ->whereDate('ToDate', '=', $financialYearEnd)
            ->first();

        // Determine the previous financial year
        $previousYearStart = \Carbon\Carbon::parse($financialYearStart)->subYear()->toDateString();
        $previousYearEnd = \Carbon\Carbon::parse($financialYearEnd)->subYear()->toDateString();

        // Fetch the previous financial year record
        $previousYearRecord = HrmYear::whereDate('FromDate', '=', $previousYearStart)
            ->whereDate('ToDate', '=', $previousYearEnd)
            ->first();
        $year_id_current = $currentYearRecord->YearId;
        // Get payslip data for the employee IDs for all months
        $payslipData = PaySlip::whereIn('EmployeeID', $employeeIds)->where('PaySlipYearId', $year_id_current)
            ->select(
                'EmployeeID',
                'Month',
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
        return view("employee.teamcost", compact( 'formattedTree',
        'employeeData',
        'rawEmployees',
        'tree','employeeData','groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads', 'ctcttotal', 'isReviewer'));
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
                //$endDate = $currentDate->copy()->addDays(15);  // Add 15 days to today's date

                // Fetch all employee data (no changes to the original query)
                $employeeDataConfirmation = \DB::table('hrm_employee_general as eg')
                    ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
                    ->leftJoin('core_designation as ds', 'ds.id', '=', 'eg.DesigId')  // Designation table
                    ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
                    ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left join to get grade info
                    ->leftJoin('core_departments as d', 'd.id', '=', 'eg.DepartmentId')  // Department table
                    ->leftJoin('core_city_village_by_state as hq', 'eg.HqId', '=', 'hq.id')  // Join with Headquater table
                    ->where('e.EmpStatus','A')
                    ->whereIn('eg.EmployeeID', $employeeIds)  // Ensure we are filtering by employee IDs (as per the original code)
                    ->select(
                        'e.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode',
                        'eg.DateJoining', 'hq.city_village_name', 'ds.designation_name', 'g.grade_name',
                        'v.vertical_name', 'd.department_code', 'eg.DateConfirmation','eg.RepEmployeeID',
                        'eg.DateConfirmationYN'

                    )
                    ->get();
                    $employeeDataConfirmation->map(function ($employee) {
                        // Parse the DateConfirmation
                        $confirmationDate = Carbon::parse($employee->DateConfirmation);
                    
                        // Calculate the start of the range (15 days before DateConfirmation)
                        $rangeStart = $confirmationDate->copy()->subDays(15);
                    
                        // Get today's date
                        $currentDate = Carbon::now();
                    
                        // If current date is within the 15 days before DateConfirmation, set isRecentlyConfirmed to true
                        // OR if the current date is after the DateConfirmation, keep it true
                        if ($currentDate->greaterThanOrEqualTo($rangeStart) && $currentDate->lessThanOrEqualTo($confirmationDate)) {
                            $employee->isRecentlyConfirmed = true;
                        } elseif ($currentDate->greaterThan($confirmationDate)) {
                            // After DateConfirmation, keep isRecentlyConfirmed true
                            $employee->isRecentlyConfirmed = true;
                        } else {
                            $employee->isRecentlyConfirmed = false;
                        }
                    
                        // Set direct reporting flag
                        $employee->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID);
                    
                        return $employee;
                    });
                    


                // Pass the necessary data to the view
                return view("employee.teamconfirmation",compact('employeeDataConfirmation','isReviewer'));
            }     
        // Get the list of EmployeeIDs for the team members of the logged-in employee
        $employeeIds = EmployeeGeneral::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->where('RepEmployeeID', Auth::user()->EmployeeID)  // Filter by RepEmployeeID
            // ->where('hrm_employee.EmpStatus', 'A')  // Filter by EmpStatus = 'A'
            ->pluck('hrm_employee.EmployeeID');  // Get the list of EmployeeIDs
    
     // Get the current date and the date 15 days from now
     $currentDate = Carbon::now();  // Today's date
     $endDate = $currentDate->copy()->addDays(15);  // Add 15 days to today's date
 
     // Fetch all employee data (no changes to the original query)
     $employeeDataConfirmation = \DB::table('hrm_employee_general as eg')
         ->leftJoin('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
         ->leftJoin('core_designation as ds', 'ds.id', '=', 'eg.DesigId')  // Designation table
         ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
         ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left join to get grade info
         ->leftJoin('core_departments as d', 'd.id', '=', 'eg.DepartmentId')  // Department table
         ->leftJoin('core_city_village_by_state as hq', 'eg.HqId', '=', 'hq.id')  // Join with Headquater table
         ->where('e.EmpStatus','A')
         ->whereIn('eg.EmployeeID', $employeeIds)  // Ensure we are filtering by employee IDs (as per the original code)
         ->select(
             'e.EmployeeID', 'e.Fname', 'e.Sname', 'e.Lname', 'e.EmpCode',
             'eg.DateJoining', 'hq.city_village_name', 'ds.designation_name', 'g.grade_name',
             'v.vertical_name', 'd.department_code', 'eg.DateConfirmation','eg.RepEmployeeID',
             'eg.DateConfirmationYN'

         )
         ->get();
         $employeeDataConfirmation->map(function ($employee) {
            // Parse the DateConfirmation
            $confirmationDate = Carbon::parse($employee->DateConfirmation);
        
            // Calculate the start of the range (15 days before DateConfirmation)
            $rangeStart = $confirmationDate->copy()->subDays(15);
        
            // Get today's date
            $currentDate = Carbon::now();
        
            // If current date is within the 15 days before DateConfirmation, set isRecentlyConfirmed to true
            // OR if the current date is after the DateConfirmation, keep it true
            if ($currentDate->greaterThanOrEqualTo($rangeStart) && $currentDate->lessThanOrEqualTo($confirmationDate)) {
                $employee->isRecentlyConfirmed = true;
            } elseif ($currentDate->greaterThan($confirmationDate)) {
                // After DateConfirmation, keep isRecentlyConfirmed true
                $employee->isRecentlyConfirmed = true;
            } else {
                $employee->isRecentlyConfirmed = false;
            }
        
            // Set direct reporting flag
            $employee->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID);
        
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
            $employeeChain = $this->getEmployeeReportingChainseparation($EmployeeID);
            foreach ($employeeChain as $employee) {

                $seperation = \DB::table('hrm_employee_separation as es')
                ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
                ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
                ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
                ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch department name
                ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
                 ->where('es.Hod_EmployeeID',Auth::user()->EmployeeID)
                // ->where('e.EmpStatus','A')  // Filter by employee ID
    
                ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.department_name','eg.EmailId_Vnr','dg.designation_name')  // Select the required fields
                ->orderBy('es.Emp_ResignationDate', 'desc') // Correct ordering
                ->get();
                 // Add 'direct_reporting' field to each record in attendance
                 $seperation = $seperation->map(function($item) use ($employee) {
                    $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                    return $item;
                });
    
                if ($seperation->isNotEmpty()) {
                    $seperationData[] = [
                        'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                        'seperation' => $seperation
                    ];
                }
            }    
            // Step 1: Fetch department_id from hrm_department where department_code == 'HR'
            $department = Department::where('department_code', 'HR')->first();
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
    
            // Fetch EmployeeIDs and their respective department_codes for departments LOGISTICS and IT
            $employeeDepartmentDetails = DB::table('hrm_employee_separation_nocdept_emp')
                ->leftJoin('core_departments', 'core_departments.id', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
                ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
                ->whereIn('core_departments.department_code', ['MIS', 'IT','FIN','HR'])  // Filter departments LOGISTICS and IT
                ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'core_departments.department_code', 'core_departments.ID')  // Select relevant fields
                ->get();
                // Get the current month and year
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
    
                // Fetching approved employees with additional employee details
                    $approvedEmployees = DB::table('hrm_employee_separation as es')
                    ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                    ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                    ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
                    ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
                    ->where('es.Rep_Approved', 'Y') 
                    ->where('es.HR_Approved', 'Y') 
                    ->where(function($query) {
                        // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                        $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                            ->orWhere('es.Hod_EmployeeID', Auth::user()->EmployeeID);
                    })
                    // ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                    // ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                    ->select(
                        'es.*',
                        'e.Fname',  // First name
                        'e.Lname',  // Last name
                        'e.Sname',  // Surname
                        'e.EmpCode',  // Employee Code
                        'd.department_name',  // Department name
                        'eg.EmailId_Vnr',  // Email ID from the employee general table
                        'dg.designation_name'  // Designation name
                    )
                    ->orderBy('es.Emp_ResignationDate', 'desc')
                    ->get();
    
                    return view('employee.teamseprationclear',compact('seperationData','separationsforhr','employeeDepartmentDetails','approvedEmployees','isReviewer'));
    
        }

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
            ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
            ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
            ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch department name
            ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
             ->where('es.Rep_EmployeeID',Auth::user()->EmployeeID)
            // ->where('e.EmpStatus','A')  // Filter by employee ID

            ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.department_name','eg.EmailId_Vnr','dg.designation_name')  // Select the required fields
            ->orderBy('es.Emp_ResignationDate', 'desc') // Correct ordering
            ->get();
            $seperation = $seperation->map(function($item) use ($employee) {
                $item->direct_reporting = ($employee->RepEmployeeID == Auth::user()->EmployeeID) ? true : false;
                return $item;
            });

            if ($seperation->isNotEmpty()) {
                $seperationData[] = [
                    'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                    'seperation' => $seperation
                ];
            }
        }    
        // Step 1: Fetch department_id from hrm_department where department_code == 'HR'
        $department = Department::where('department_code', 'HR')->first();
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

        // Fetch EmployeeIDs and their respective department_codes for departments LOGISTICS and IT
        $employeeDepartmentDetails = DB::table('hrm_employee_separation_nocdept_emp')
            ->leftJoin('core_departments', 'core_departments.id', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
            ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
            ->whereIn('core_departments.department_code', ['MIS', 'IT','FIN','HR'])  // Filter departments LOGISTICS and IT
            ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'core_departments.department_code', 'core_departments.id')  // Select relevant fields
            ->get();
            // Get the current month and year
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetching approved employees with additional employee details
                $approvedEmployees = DB::table('hrm_employee_separation as es')
                ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
                ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
               // ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                ->where(function($query) {
                    // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                    $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                        ->orWhere('es.Hod_EmployeeID', Auth::user()->EmployeeID);
                })
                // ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                // ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                ->select(
                    'es.*',
                    'e.Fname',  // First name
                    'e.Lname',  // Last name
                    'e.Sname',  // Surname
                    'e.EmpCode',  // Employee Code
                    'd.department_name',  // Department name
                    'eg.EmailId_Vnr',  // Email ID from the employee general table
                    'dg.designation_name'  // Designation name
                )
                ->orderBy('es.Emp_ResignationDate', 'desc')
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

        // Get basic employee details
        $employeeDetails = $this->getEmployeeDetails($employeeId);

        // Get career progression data
        $careerProgression = $this->getCareerProgression($employeeId);
        // Get previous employers' data
        $previousEmployers = $this->getPreviousEmployers($employeeId);

        // Combine all the data into one response
        return response()->json([
            'employeeDetails' => $employeeDetails,
            'careerProgression' => $careerProgression,
            'previousEmployers' => $previousEmployers,
        ]);
    }
    public function getEmployeeDetails($employeeId)
    {
        // Fetching basic employee details from relevant tables
        $employee = \DB::table('hrm_employee as e')
            ->leftJoin('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
            ->leftJoin('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->leftJoin('core_designation as de', 'g.DesigId', '=', 'de.id')
            ->leftJoin('hrm_employee_personal as hp', 'e.EmployeeID', '=', 'hp.EmployeeID')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            ->leftJoin('hrm_employee_reporting as r', 'e.EmployeeID', '=', 'r.EmployeeID')
            ->leftJoin('hrm_employee as e2', 'r.ReviewerId', '=', 'e2.EmployeeID')
            ->select(
                'e.EmpCode',
                'e.Fname',
                'e.Lname',
                'e.Sname',
                'g.DateJoining',
                'e.DateOfSepration',
                'g.ReportingName',
                'e2.Fname as ReviewerFname',
                'e2.Lname as ReviewerLname',
                'e2.Sname as ReviewerSname',
                'de.designation_name',
                'd.department_name',
                'hq.city_village_name',
                'hp.Qualification',
                DB::raw('
                    FLOOR(DATEDIFF(CURDATE(), g.DateJoining) / 365.25) AS YearsSinceJoining,
                    FLOOR((DATEDIFF(CURDATE(), g.DateJoining) % 365.25) / 30) AS MonthsSinceJoining
                ')
            )
            ->where('e.EmployeeID', $employeeId)
            ->first();

        return $employee;
        }
    public function getCareerProgression($employeeId)
        {
            $progressions = DB::table('hrm_pms_appraisal_history')->where('EmployeeID', $employeeId)
                ->where('SalaryChange_Date', '>=', '2012-01-01')
                ->orderBy('SalaryChange_Date', 'DESC')
                ->get();
            $careerData = [];
            foreach ($progressions as $progression) {

                $ctc = DB::table('hrm_employee_ctc')->where('CtcCreatedDate', $progression->SalaryChange_Date)
                    ->where('EmployeeID', $employeeId)
                    ->orderBy('CtcId', 'DESC')
                    ->first();

                $totalCTC = $ctc ? $ctc->Tot_CTC : 0;

                // if (
                //     $progression->SalaryChange_Date == '2014-01-31' || $progression->Previous_GrossSalaryPM != $progression->TotalProp_GSPM ||
                //     $progression->Current_Designation != $progression->Proposed_Designation
                // ) {

                    $increment = $progression->TotalProp_PerInc_GSPM ?: (($progression->Previous_GrossSalaryPM && $progression->TotalProp_GSPM)
                        ? number_format((($progression->TotalProp_GSPM - $progression->Previous_GrossSalaryPM) / ($progression->Previous_GrossSalaryPM * 0.01)), 2)
                        : 0);

                    $careerData[] = [
                        'Date' => date('d-m-Y', strtotime($progression->SalaryChange_Date)),
                        'Designation' => strtoupper($progression->Proposed_Designation),
                        'Grade' => $progression->Proposed_Grade,
                        'Monthly_Gross' => floatval(max($progression->Proposed_GrossSalaryPM, $progression->TotalProp_GSPM, $progression->Previous_GrossSalaryPM)),
                        'CTC' => ($totalCTC == 0) ? '-' : floatval($totalCTC),
                        'Rating' => ($progression->Rating == 0) ? '-' : $progression->Rating,
                    ];
                //}
            }

            $old_progressions = DB::table('hrm_pms_appraisal_history')->where('EmployeeID', $employeeId)->where('SalaryChange_Date', '<', '2012-01-01')
                ->orderBy('SalaryChange_Date', 'DESC')
                ->get();
            foreach ($old_progressions as $old_progression) {
                $careerData[] = [
                    'Date' => date('d-m-Y', strtotime($old_progression->SalaryChange_Date)),
                    'Designation' => strtoupper($old_progression->Current_Designation),
                    'Grade' => $old_progression->Current_Grade,
                    'Monthly_Gross' => $old_progression->Previous_GrossSalaryPM,
                    'CTC' => '-',
                    'Rating' => ($old_progression->Rating == 0) ? '-' : $progression->Rating,

                ];
            }
            return $careerData;
        }
    public function getPreviousEmployers($employeeId)
    { 
            $previousEmployers = \DB::table('hrm_employee_experience as ee')
                ->select(
                    'ee.ExpComName',  // Company name
                    'ee.ExpDesignation',  // Designation in the company
                    'ee.ExpFromDate',  // From date of employment
                    'ee.ExpToDate',  // To date of employment
                    DB::raw('
                        CASE
                            WHEN ee.ExpToDate NOT IN ("0000-00-00", "1970-01-01") THEN TIMESTAMPDIFF(YEAR, ee.ExpFromDate, ee.ExpToDate)
                            ELSE 0
                        END AS DurationYears
                    ')  // Duration in years, excluding invalid dates
                )
                ->where('ee.EmployeeID', $employeeId)
                ->get();

            return $previousEmployers;
    }


    public function singleprofileemployee($id){
            // Fetch data from the tables hrm_employee, hrm_employee_general, hrm_employee_personal, and hrm_employee_contact
            $employee = \DB::table('hrm_employee as e')
            ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
            ->leftJoin('hrm_employee_personal as ep', 'e.EmployeeID', '=', 'ep.EmployeeID')
            // ->leftJoin('hrm_headquater as hq', 'eg.HqId', '=', 'hq.HqId') 
            ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id') 
            ->leftJoin('core_grades as g', 'eg.GradeId', '=', 'g.id')  // Left Join to fetch GradeValue
            ->leftJoin('core_designation as de', 'eg.DesigId', '=', 'de.id') 
            ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
            ->where('e.EmployeeID', $id)
            ->select(
                'e.*','eg.*','ep.*','d.*','g.*','de.*','v.*'
            )
            ->first();
                        $employeecontact = \DB::table('hrm_employee_contact')
                        ->leftJoin('hrm_city as curr_city', 'hrm_employee_contact.CurrAdd_City', '=', 'curr_city.CityId') // Current Address City
                        ->leftJoin('hrm_state as curr_state', 'hrm_employee_contact.CurrAdd_State', '=', 'curr_state.StateId') // Current Address State
                        ->leftJoin('hrm_city as par_city', 'hrm_employee_contact.ParAdd_City', '=', 'par_city.CityId') // Permanent Address City
                        ->leftJoin('hrm_state as par_state', 'hrm_employee_contact.ParAdd_State', '=', 'par_state.StateId') // Permanent Address State
                        ->where('hrm_employee_contact.EmployeeID', $id)
                        ->select(
                            'hrm_employee_contact.*',
                            'curr_city.CityName as CurrentCityName',
                            'curr_state.StateName as CurrentStateName',
                            'par_city.CityName as PermanentCityName',
                            'par_state.StateName as PermanentStateName'
                        )
                        ->first();

                        $familyData1 = \DB::table('hrm_employee_family')
                        ->where('EmployeeID', $id)
                        ->whereNotIn('FatherDOB', ['1970-01-01', '0000-00-00'])
                        ->select(
                            \DB::raw("'Father' as FamilyRelation"),
                            'Fa_SN as Prefix',
                            'FatherName as FamilyName',
                            'FatherDOB as FamilyDOB',
                            'FatherQuali as FamilyQualification',
                            'FatherOccupation as FamilyOccupation'
                        )
                        ->union(
                            \DB::table('hrm_employee_family')
                                ->where('EmployeeID', $id)
                                ->whereNotIn('MotherDOB', ['1970-01-01', '0000-00-00'])
                                ->select(
                                    \DB::raw("'Mother' as FamilyRelation"),
                                    'Mo_SN as Prefix',
                                    'MotherName as FamilyName',
                                    'MotherDOB as FamilyDOB',
                                    'MotherQuali as FamilyQualification',
                                    'MotherOccupation as FamilyOccupation'
                                )
                        )
                        ->union(
                            \DB::table('hrm_employee_family')
                                ->where('EmployeeID', $id)
                                ->whereNotIn('HusWifeDOB', ['1970-01-01', '0000-00-00'])
                                ->select(
                                    \DB::raw("'Spouse' as FamilyRelation"),
                                    'HW_SN as Prefix',
                                    'HusWifeName as FamilyName',
                                    'HusWifeDOB as FamilyDOB',
                                    'HusWifeQuali as FamilyQualification',
                                    'HusWifeOccupation as FamilyOccupation'
                                )
                        )
                        ->get();
                    
                        // Fetch data from `hrm_employee_family2` table
                        $familyData2 = \DB::table('hrm_employee_family2')
                        ->where('EmployeeID', $id)
                        ->whereNotIn('FamilyDOB', ['1970-01-01', '0000-00-00'])
                        ->select(
                            'FamilyRelation',
                            'Fa2_SN as Prefix',
                            'FamilyName',
                            'FamilyDOB',
                            'FamilyQualification',
                            'FamilyOccupation'
                        )
                        ->get();
                    
                        // Merge the results
                        $allFamilyData = $familyData1->merge($familyData2);
                        
                        $qualifications = \DB::table('hrm_employee_qualification')
                        ->where('EmployeeID',$id) // Assuming EmployeeID corresponds to Auth::id()
                        ->get();

                        $languageData = \DB::table('hrm_employee_langproficiency')
                        ->where('EmployeeID', $id) // Assuming EmployeeID matches Auth::id()
                        ->get();

                        // Fetch TrainingId from the participant table based on EmployeeID
                                    $trainingParticipants = \DB::table('hrm_company_training_participant')
                                    ->where('EmployeeID', $id) // Replace with relevant identifier
                                    ->get();

                                $trainingData = [];

                                // Fetch data from hrm_training table for each TrainingId
                                foreach ($trainingParticipants as $participant) {
                                    $training = \DB::table('hrm_company_training')
                                        ->where('TrainingId', $participant->TrainingId)
                                        ->first();

                                    if ($training) {
                                        $trainingData[] = $training;
                                    }
                                }
                                $employeeExperience = \DB::table('hrm_employee_experience')
                                ->where('EmployeeID', $id) // Assuming you're fetching by EmployeeID
                            
                                ->get();
                                if ($employee) {
                                    // Parse the DateJoining
                                    $dateJoined = \Carbon\Carbon::parse($employee->DateJoining);
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
                        $appraisalHistory = \DB::table('hrm_pms_appraisal_history')
                        ->where('EmployeeID', $id)
                        ->orderBy('SalaryChange_Date', 'desc') // Order by the salary change date
                        ->get();

                        // Group by grade, treating '0' as valid and part of its group
                        $groupedData = collect($appraisalHistory)->groupBy(function ($item) {
                        return $item->Proposed_Grade; // Include '0' in the normal grouping
                        });

                        $finalResult = [];

                        // Process each group of grades
                        foreach ($groupedData as $grade => $items) {
                        $startDate = null;
                        $endDate = null;

                        // Sort items by SalaryChange_Date in ascending order
                        $items = $items->sortBy('SalaryChange_Date');

                        foreach ($items as $index => $item) {
                            if ($startDate === null) {
                                // Set start date for the first record in the group
                                $startDate = $item->SalaryChange_Date;
                            }

                            // Continuously update the end date with the current item's SalaryChange_Date
                            $endDate = $item->SalaryChange_Date;
                        }

                        // Treat grade '0' like normal, setting it as the first data if it exists
                        $currentGrade = $items->first()->Proposed_Grade == 0 ? '0' : $items->first()->Proposed_Grade;

                        // Push the result for this group to $finalResult
                        $finalResult[] = [
                            'Current_Grade' => $currentGrade,
                            'Current_Designation' => $items->first()->Current_Designation,
                            'SalaryChange_Date' => \Carbon\Carbon::parse($startDate)->format('d-m-Y') // Format as dd-mm-yyyy
                        ];
                        }   
                    
                        $conferences = DB::table('hrm_company_conference_participant as cp')
                        ->join('hrm_company_conference as c', 'cp.ConferenceId', '=', 'c.ConferenceId')
                        ->where('cp.EmployeeID', $id)
                        ->orderBy('c.ConfFrom', 'DESC')
                        ->select('c.*')
                        ->get();


        return view('employee.singleprofile',compact('finalResult','employee','employeeExperience','employeecontact','allFamilyData','qualifications','languageData','trainingData'));

    }
    private function buildTree(array $elements, $parentId)
        {
        $branch = [];

        foreach ($elements as $element) {
        if ($element['id'] == $parentId) {
        $children = $this->getChildren($elements, $element['id']);

        $element['children'] = $children;
        // Calculate total CTC
        $element['total_ctc'] = $element['ctc'] + collect($children)->sum('total_ctc');

        return $element; // Only one root node
        }
        }

        return [];
    }


    private function getChildren(array $elements, $parentId)
    {
    $branch = [];

    foreach ($elements as $element) {
    if ($element['parent'] == $parentId) {
    $children = $this->getChildren($elements, $element['id']);
    $element['children'] = $children;

    // Calculate total CTC
    $element['total_ctc'] = $element['ctc'] + collect($children)->sum('total_ctc');

    $branch[] = $element;
    }
    }

    return $branch;
    }

private function formatForOrgChart($node)
{
$formatted = [
'id' => $node['id'],
'name' => $node['name'],
'image' => $node['image'],
'title' => 'Self CTC: ₹' . number_format($node['ctc']),
'desc' => 'Team CTC: ₹' . number_format($node['total_ctc']),
];

if (!empty($node['children'])) {
$formatted['children'] = array_map([$this, 'formatForOrgChart'], $node['children']);
}

return $formatted;
}
private function getSubordinatestree($employees, $managerId)
{
 $subordinates = [];

 foreach ($employees as $employee) {
     if ($employee->RepEmployeeID == $managerId) {
         $subordinates[] = $employee;
         $subordinates = array_merge($subordinates, $this->getSubordinatestree($employees, $employee->EmployeeID));
     }
 }

 return $subordinates;
}
public function getEmployeeImage($employeeId) {
    // Retrieve the employee data in a single query
    $employee = DB::table('hrm_employee')
        ->where('EmployeeID', $employeeId)
        ->select('CompanyId', 'EmpCode')
        ->first();

    // Return null if employee not found or data is missing
    if (!$employee || empty($employee->CompanyId) || empty($employee->EmpCode)) {
        return null;
    }
    $path = "Employee_Image/{$employee->CompanyId}/{$employee->EmpCode}.jpg";

    // Return the public URL from S3 disk
    return Storage::disk('s3')->url($path);

    // Build and return the employee image URL
    // return "https://vnrseeds.co.in/AdminUser/EmpImg{$employee->CompanyId}Emp/{$employee->EmpCode}.jpg";
}
    
}
