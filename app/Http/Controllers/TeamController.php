<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeApplyLeave;
use App\Models\EmployeeGeneral;
use App\Models\CompanyTraining;


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
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay',
                     'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.EmpCode')  // Select the relevant fields
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
                    'leaveBalances'=>$leaveBalances
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

        // Recursive query to get the reporting chain for the given EmployeeID
        $employeeChain = \DB::select("
        WITH RECURSIVE EmployeeChain AS (
            -- Base case: Start with the given EmployeeID
            SELECT 
                eg.EmployeeID, 
                eg.RepEmployeeID,
                e.Fname,
                e.Lname,
                e.Sname,
                eg.DesigId,
                eg.DepartmentId,
                1 AS level
            FROM 
                hrm_employee_general as eg
            JOIN 
                hrm_employee as e ON eg.EmployeeID = e.EmployeeID -- Join to fetch employee details
            WHERE 
                eg.EmployeeID = :employeeId  -- Start with the given EmployeeID

            UNION ALL

            -- Recursive case: Fetch employees who report to the employees found in the previous step
            SELECT 
                eg.EmployeeID, 
                eg.RepEmployeeID,
                e.Fname,
                e.Lname,
                e.Sname,
                eg.DesigId,
                eg.DepartmentId,
                ec.level + 1 AS level
            FROM 
                hrm_employee_general as eg
            INNER JOIN 
                hrm_employee as e ON eg.EmployeeID = e.EmployeeID -- Join to fetch employee details
            INNER JOIN 
                EmployeeChain as ec ON eg.RepEmployeeID = ec.EmployeeID  -- Match RepEmployeeID with the EmployeeID from the previous level
        )
        -- Final result: Select all employees in the chain
        SELECT * 
        FROM EmployeeChain
        -- Join to get designation and department names
        LEFT JOIN hrm_designation as d ON EmployeeChain.DesigId = d.DesigId
        LEFT JOIN hrm_department as dept ON EmployeeChain.DepartmentId = dept.DepartmentId
    ", ['employeeId' => $EmployeeID]);
        return view("employee.team",compact('employeeChain','exists','assets_request'));
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

        return view('employee.teamtrainingsep',compact('trainingData'));

    }
    public function teameligibility(){
        $EmployeeID =Auth::user()->EmployeeID;

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        
        // Fetch the eligibility data for all employee IDs in one query
        $eligibility = \DB::table('hrm_employee_eligibility as ee')
        ->join('hrm_employee as e', 'e.EmployeeID', '=', 'ee.EmployeeID')
        ->whereIn('ee.EmployeeID', $employeeIds)
        ->where('ee.Status', 'A') // Ensure only active eligibility is fetched
        ->select('e.Fname', 'e.Lname', 'e.Sname', 'ee.*') // Select employee names and all eligibility data
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
                    ->select('hrm_employee_applyleave.Leave_Type','hrm_employee_applyleave.Apply_FromDate',
                    'hrm_employee_applyleave.Apply_ToDate','hrm_employee_applyleave.LeaveStatus',
                    'hrm_employee_applyleave.Apply_Reason','hrm_employee_applyleave.Apply_TotalDay',
                     'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.EmpCode')  // Select the relevant fields
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
                    'leaveBalances'=>$leaveBalances
                ];
            }
        return view('employee.teamleaveatt',compact('attendanceData'));


    }
}
