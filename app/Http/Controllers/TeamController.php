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
    public function team(){
        $EmployeeID = Auth::user()->EmployeeID;
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
            foreach ($employeesReportingTo as $employee) {
                $attendance = \DB::table('hrm_employee_attendance')
                ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')  // Join with hrm_employee table
                ->where('hrm_employee_attendance.EmployeeID', $employee->EmployeeID)
                ->whereDate('hrm_employee_attendance.AttDate', now()->toDateString()) // Get today's attendance data
                ->select('hrm_employee_attendance.Inn','hrm_employee_attendance.Outt', 'hrm_employee.Fname', 'hrm_employee.Sname','hrm_employee.Lname')  // Select desired fields
                ->get(); // Get attendance records for the employee


                $employeeData = \DB::table('hrm_employee as e')
                        ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                        ->join('hrm_designation as d', 'eg.DesigId', '=', 'd.DesigId')  // Join to fetch DesigName
                        ->leftJoin('hrm_department_vertical as v', 'eg.EmpVertical', '=', 'v.VerticalId')  // Left Join to fetch VerticalName, ignore if 0 or no match
                        ->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')  // Left Join to fetch GradeValue
                        ->leftJoin('hrm_department as dp', 'eg.DepartmentId', '=', 'dp.DepartmentId')  // Left Join to fetch DepartmentName
                        ->where('e.EmployeeID', $employee->EmployeeID)
                        ->select(
                            'e.*', 
                            'eg.*', 
                            'd.DesigName', 
                            'v.VerticalName', 
                            'g.GradeValue', 
                            'dp.DepartmentName'  // Select DepartmentName from hrm_department
                        )  // Select all columns from e, eg, and the additional columns
                        ->get();  // Fetch the results (array of objects)
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
                     'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
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
            $employee = Employee::find($EmployeeID);

            // Step 3: Ensure that the employee exists before calling the method
            if ($employee) {
                // Step 4: Call the getReportsHierarchy() method to get the employee hierarchy
            $employeeChain = $employee->getReportingHierarchy($EmployeeID);

            } else {
                // Handle the case where the employee does not exist
                dd('Employee not found!');
            }

        return view("employee.team",compact('employeeData','employeeChain','exists','assets_request','attendanceData'));
    }
    public function teamtrainingsep(){
        $EmployeeID =Auth::user()->EmployeeID;

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $trainingData = \DB::table('hrm_company_training_participant as ctp')
        ->join('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId') // Join with hrm_company_training based on training_id
        ->join('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee to get employee details
        ->whereIn('ctp.EmployeeID', $employeeIds) // Filter by EmployeeID(s)
        ->select('ct.*','e.Fname', 'e.Lname', 'e.Sname') // Select relevant fields
        ->get();
        $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get(); 
        $seperationData = [];

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
            ->where('es.EmployeeID', $employee->EmployeeID)
            ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname')  // Select separation data and employee name
            ->get();
            if ($seperation->isNotEmpty()) {
                $seperationData[] = [
                    'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                    'seperation' => $seperation
                ];
            }
        }    

        return view('employee.teamtrainingsep',compact('trainingData','seperationData'));

    }
    public function teameligibility(){
        $EmployeeID =Auth::user()->EmployeeID;

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        
        // Fetch the eligibility data for all employee IDs in one query
        $eligibility = \DB::table('hrm_employee_eligibility as ee')
        ->join('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
        ->join('hrm_employee_general as eg', 'eg.EmployeeID', '=', 'e.EmployeeID') // Join with employee general table
        ->join('hrm_designation as d', 'd.DesigId', '=', 'eg.DesigId') // Join with the designation table
        ->whereIn('ee.EmployeeID', $employeeIds)
        ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
        ->select(
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.empcode',
            'eg.DesigId', // Include designation ID
            'd.DesigName', // Fetch the designation name from the designation table
            'ee.*',
   
        ) // Select all necessary data
        ->get();
    

        return view('employee.teameligibility',compact('eligibility'));


    }
    public function teamassetsquery(){
        return view('employee.teamassetsquery');


    }
    public function teamleaveatt(){
        $EmployeeID = Auth::user()->EmployeeID;

        $employeesReportingTo = \DB::table('hrm_employee_general')
            ->where('RepEmployeeID', $EmployeeID)
            ->get();  // Get all employees reporting to the RepEmployeeID
            $attendanceData = [];
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
                     'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.EmpCode','hrm_employee.EmployeeID')  // Select the relevant fields
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
                    
                    // Get current month and year
                    $currentMonth = now()->month;
                    $currentYear = now()->year;
                    $emploid = $employee->EmployeeID;
                    
                    // Calculate the number of days in the current month
                    $daysInMonth = Carbon::createFromDate($currentYear, $currentMonth)->daysInMonth;
                    
                    // Start building the query
                    $query = DB::table('hrm_employee_attendance as a')
                        ->join('hrm_employee_monthlyleave_balance as l', function($join) use ($currentMonth, $currentYear, $emploid) {
                            $join->on('a.EmployeeID', '=', 'l.EmployeeID')
                                ->where('l.Month', '=', $currentMonth)
                                ->where('l.Year', '=', $currentYear);
                        })
                        ->join('hrm_employee as e', 'a.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee
                        ->where('a.EmployeeID', $emploid)
                        ->whereYear('a.AttDate', $currentYear)
                        ->whereMonth('a.AttDate', $currentMonth)
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
                    $empdataleaveattdata = $query->get();
                    
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
                    'attendnacerequest'=>$requestsAttendnace
                ];
            }
            
        return view('employee.teamleaveatt',compact('attendanceData','empdataleaveattdata','daysInMonth'));
    }
    public function teamcost() {
        $EmployeeID = Auth::user()->EmployeeID;
        
        // Get the employee IDs under the same team (where RepEmployeeID matches current user)
        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        
        // Define the months mapping
        $months = [
            1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR', 5 => 'MAY', 
            6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
            11 => 'NOV', 12 => 'DEC'
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
        $payslipData = PaySlip::whereIn('EmployeeID', $employeeIds)
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
        return view("employee.teamcost", compact('employeeData', 'groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads'));
    }
    public function teamconfirmation() {
        
        return view("employee.teamconfirmation");
    }

    public function teamseprationclear(){
        $EmployeeID =Auth::user()->EmployeeID;

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $trainingData = \DB::table('hrm_company_training_participant as ctp')
        ->join('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId') // Join with hrm_company_training based on training_id
        ->join('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee to get employee details
        ->whereIn('ctp.EmployeeID', $employeeIds) // Filter by EmployeeID(s)
        ->select('ct.*','e.Fname', 'e.Lname', 'e.Sname','e.EmpCode') // Select relevant fields
        ->get();
        $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get(); 
        $seperationData = [];

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
            ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
            ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
            ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch department name
            ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
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


                return view('employee.teamseprationclear',compact('trainingData','seperationData','separationsforhr','employeeDepartmentDetails','approvedEmployees'));

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
}
