<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeApplyLeave;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveBalance;
use App\Models\EmployeeGeneral;
use Carbon\Carbon;
use DB\DB;


use App\Models\HrmYear;
use Illuminate\Support\Facades\Auth;


class LeaveController extends Controller
{
    public function applyLeave(Request $request)
    {

        $fromDate = new \DateTime($request->fromDate);


        $employeeId = $request->employee_id;
        $toDate = new \DateTime($request->toDate);
        $interval = $fromDate->diff($toDate);
        // Current time and today's date
        $Ctime = date("H:i:s");
        $FFDate = date("Y-m-d H:i:s", strtotime($request->FromDate) + strtotime($Ctime));
        $TodayDate = date("Y-m-d 09:30:00");

        if ($request->leaveType === "OL") {
            $request->leaveType = "FL";
        }

        // Prepare date ranges
        $previousDates = $this->getPreviousDates($fromDate, 5);
        $nextDates = $this->getNextDates($toDate, 5);
        // Initialize results
        $attendanceResults = [];
        $leaveResults = [];

        // Fetch attendance and leave records for all relevant dates
        $allDates = array_merge($previousDates, $nextDates);
        foreach ($allDates as $date) {
            $attendanceResults[$date] = $this->fetchAttendance($employeeId, $date);
            $leaveResults[$date] = $this->fetchLeave($employeeId, $date);
        }

        // Process EL Combination logic
        $elResults = $this->processELCombinations($employeeId, $previousDates, $nextDates);

        $plCombinationResults = $this->processPLFLCombinationCheck($employeeId, $previousDates, $nextDates);


        // Initialize error message
        $msg = $this->validateLeaveApplication($request, $fromDate, $toDate, $FFDate, $TodayDate, $request->leaveType, $previousDates, $attendanceResults, $leaveResults, $elResults, $plCombinationResults);

        if ($msg) {
            return response()->json(['success' => false, 'message' => $msg]);
        }
        
        // Proceed with saving the leave application and return a success response
        return response()->json(['success' => true]);
    }
    public function fetchLeaveList(Request $request)
    {
        $employeeId = $request->employee_id;

        $leaves = EmployeeApplyLeave::where('EmployeeID', $employeeId)->get(); // Fetch leaves for the specified employee

        $leaveHtml = '';
        foreach ($leaves as $index => $leave) {
            $leaveHtml .= '<tr>
                <td>' . ($index + 1) . '.</td>
                <td style="width:80px;">' . $leave->Apply_Date . '</td>
                <td style="width:80px;">' . $leave->Apply_FromDate . '</td>
                <td style="width:80px;">' . $leave->Apply_ToDate . '</td>
                <td style="width:70px;">' . $leave->Apply_TotalDay . ' ' . ($leave->Apply_TotalDay == 1 ? 'Day' : 'Days') . '</td>
                <td style="width:80px;">
                    <label class="mb-0 badge badge-secondary" title="" data-original-title="' . $leave->Leave_Type . '">' . $leave->Leave_Type . '</label>
                </td>
                <td>
                    <p>' . $leave->Apply_Reason . '</p>
                </td>
                <td style="text-align:right;">';

            // Leave Status
            if ($leave->LeaveStatus == 0) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Draft">Draft</label>';
            } elseif ($leave->LeaveStatus == 1) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline warning-outline" title="" data-original-title="Pending">Pending</label>';
            } elseif ($leave->LeaveStatus == 2) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="" data-original-title="Approved">Approved</label>';
            } elseif ($leave->LeaveStatus == 3) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Disapproved">Disapproved</label>';
            }

            $leaveHtml .= '</td></tr>';
        }

        return response()->json(['html' => $leaveHtml]);
    }
    // Function to fetch leave records
    public function fetchLeave($employeeId, $date)
    {
        $leaveTypes = ['HO', 'CL', 'CH', 'PL', 'APH', 'EL', 'FL', 'TL', 'SL', 'SH', 'ASH'];
        $results = [];
        foreach ($leaveTypes as $type) {
            $results[$type] = EmployeeApplyLeave::where('EmployeeID', $employeeId)
                ->where('Leave_Type', $type)
                ->where('LeaveStatus', '!=', 4)
                ->where('LeaveStatus', '!=', 3)
                ->where('Apply_ToDate', $date)
                ->count();
        }
        return $results;
    }
    public function fetchAttendance($employeeId, $date)
    {
        $attendanceValues = ['HO', 'CL', 'CH', 'PL', 'APH', 'EL', 'FL', 'TL', 'SL', 'SH', 'ASH'];
        $results = [];
        foreach ($attendanceValues as $value) {
            $results[$value] = Attendance::where('EmployeeID', $employeeId)
                ->where('AttValue', $value)
                ->where('AttDate', $date)
                ->count();
        }
        return $results;
    }
    public function getPreviousDates(\DateTime $date, int $count)
    {
        $previousDates = [];
        $currentDate = clone $date; // Clone the original date to avoid modification
        for ($i = 1; $i <= $count; $i++) {
            $currentDate->modify('-1 day'); // Modify the cloned date
            $previousDates[] = $currentDate->format('Y-m-d');
        }
        return $previousDates;
    }

    public function getNextDates(\DateTime $date, int $count)
    {
        $nextDates = [];
        $currentDate = clone $date; // Clone the original date to avoid modification
        for ($i = 1; $i <= $count; $i++) {
            $currentDate->modify('+1 day'); // Modify the cloned date
            $nextDates[] = $currentDate->format('Y-m-d');
        }
        return $nextDates;
    }

    public function processELCombinations($employeeId, $previousDates, $nextDates)
    {
        $elResults = [];

        // Combine previous and next dates into one array for processing
        $datesToCheck = array_merge($previousDates, $nextDates);

        // Check EL attendance and leave counts for all dates
        foreach ($datesToCheck as $date) {
            // Count EL attendance
            $elAttendanceCount = Attendance::where('AttValue', 'EL')
                ->where('EmployeeID', $employeeId)
                ->where('AttDate', $date)
                ->count();

            // Count EL leave
            $elLeaveCount = EmployeeApplyLeave::where('Leave_Type', 'EL')
                ->where('LeaveStatus', '!=', 4)
                ->where('LeaveStatus', '!=', 3)
                ->where('EmployeeID', $employeeId)
                ->where('Apply_ToDate', $date)  // Use Apply_ToDate for end date
                ->count();

            // Store the results for the current date
            $elResults[$date] = [
                'elAttendanceCount' => $elAttendanceCount,
                'elLeaveCount' => $elLeaveCount,
            ];
        }

        return $elResults;
    }

    public function processPLFLCombinationCheck($employeeId, $previousDates, $nextDates)
    {
        $plCombinationResults = [];

        // Check for previous dates (P1 to P4)
        foreach ($previousDates as $index => $date) {
            if ($index < 4) { // Limit to P1 to P4
                $plAttendanceCount = Attendance::whereIn('AttValue', ['PL', 'FL'])
                    ->where('EmployeeID', $employeeId)
                    ->where('AttDate', $date)
                    ->count();

                $plLeaveCount = EmployeeApplyLeave::whereIn('Leave_Type', ['PL', 'FL'])
                    ->where('LeaveStatus', '!=', 4)
                    ->where('LeaveStatus', '!=', 3)
                    ->where('EmployeeID', $employeeId)
                    ->where('Apply_FromDate', '<=', $date)
                    ->where('Apply_ToDate', '>=', $date)
                    ->count();

                $plCombinationResults[$date] = [
                    'plAttendanceCount' => $plAttendanceCount,
                    'plLeaveCount' => $plLeaveCount,
                ];
            }
        }

        // Check for next dates (N1 to N4)
        foreach ($nextDates as $index => $date) {
            if ($index < 4) { // Limit to N1 to N4
                $plAttendanceCount = Attendance::whereIn('AttValue', ['PL', 'FL'])
                    ->where('EmployeeID', $employeeId)
                    ->where('AttDate', $date)
                    ->count();

                $plLeaveCount = EmployeeApplyLeave::whereIn('Leave_Type', ['PL', 'FL'])
                    ->where('LeaveStatus', '!=', 4)
                    ->where('LeaveStatus', '!=', 3)
                    ->where('EmployeeID', $employeeId)
                    ->where('Apply_FromDate', '<=', $date)
                    ->where('Apply_ToDate', '>=', $date)
                    ->count();

                $plCombinationResults[$date] = [
                    'plAttendanceCount' => $plAttendanceCount,
                    'plLeaveCount' => $plLeaveCount,
                ];
            }
        }

        return $plCombinationResults;
    }
    public function validateLeaveApplication(
        $request,
        \DateTime $fromDate,
        \DateTime $toDate,
        $FFDate,
        $TodayDate,
        $leaveType,
        $previousDates,
        $attendanceResults,
        $leaveResults,
        $elResults,
        $plCombinationResults
    ) {
        $today = date("Y-m-d");
        $appFromDate = $fromDate->format("Y-m-d");
        $appToDate = $toDate->format("Y-m-d");
        $appFromMonth = $fromDate->format("m");
        // Initialize message variable
        $msg = '';


        if (($leaveType == 'SL' || $leaveType == 'SH')) {
            // Validate leave application conditions
            $check = $this->checkCombinedLeaveConditionsSL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {
                $totaldays = $check[0];
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();

                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $request->leaveType,
                    'Apply_FromDate' => $request->fromDate,
                    'Apply_ToDate' => $request->toDate,
                    'Apply_TotalDay' => $totaldays,
                    'Apply_Reason' => $request->reason,
                    'Apply_ContactNo' => $request->contactNo,
                    'Apply_DuringAddress' => $request->address,
                    'LeaveAppReason' => '',
                    'LeaveAppUpDate' => now(),
                    'LeaveRevReason' => '',
                    'LeaveRevUpDate' => now(),
                    'LeaveHodReason' => '',
                    'LeaveHodUpDate' => now(),
                    'ApplyLeave_UpdatedDate' => now(),
                    'ApplyLeave_UpdatedYearId' => $year_id,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,

                ];

                // Insert the data into hrm_employee_queryemp
                EmployeeApplyLeave::create($leaveData);
            }
        }
        // Validation rules
        if (($leaveType == 'CL' || $leaveType == 'CH')) {
            // Check combined leave conditions
            $check = $this->checkCombinedLeaveConditionsCL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {
                $totaldays = $check[0];
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();

                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;

                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $request->leaveType,
                    'Apply_FromDate' => $request->fromDate,
                    'Apply_ToDate' => $request->toDate,
                    'Apply_TotalDay' => $totaldays,
                    'Apply_Reason' => $request->reason,
                    'Apply_ContactNo' => $request->contactNo,
                    'Apply_DuringAddress' => $request->address,
                    'LeaveAppReason' => '',
                    'LeaveAppUpDate' => now(),
                    'LeaveRevReason' => '',
                    'LeaveRevUpDate' => now(),
                    'LeaveHodReason' => '',
                    'LeaveHodUpDate' => now(),
                    'ApplyLeave_UpdatedDate' => now(),
                    'ApplyLeave_UpdatedYearId' => $year_id,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,

                ];

                // Insert the data into hrm_employee_queryemp
                EmployeeApplyLeave::create($leaveData);
            }
        }
        if (($leaveType == 'EL')) {
            $check = $this->checkCombinedLeaveConditionsEL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {

                // Check combined leave conditions
                $totaldays = $check[0];
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();

                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $request->leaveType,
                    'Apply_FromDate' => $request->fromDate,
                    'Apply_ToDate' => $request->toDate,
                    'Apply_TotalDay' => $totaldays,
                    'Apply_Reason' => $request->reason,
                    'Apply_ContactNo' => $request->contactNo,
                    'Apply_DuringAddress' => $request->address,
                    'LeaveAppReason' => '',
                    'LeaveAppUpDate' => now(),
                    'LeaveRevReason' => '',
                    'LeaveRevUpDate' => now(),
                    'LeaveHodReason' => '',
                    'LeaveHodUpDate' => now(),
                    'ApplyLeave_UpdatedDate' => now(),
                    'ApplyLeave_UpdatedYearId' => $year_id,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,

                ];

                // Insert the data into hrm_employee_queryemp
                EmployeeApplyLeave::create($leaveData);
            }
        }
        if (($leaveType == 'PL')) {
            // Check combined leave conditions

            $check = $this->checkCombinedLeaveConditionsPL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {
                // Check combined leave conditions
                $totaldays = $check[0];
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();

                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $request->leaveType,
                    'Apply_FromDate' => $request->fromDate,
                    'Apply_ToDate' => $request->toDate,
                    'Apply_TotalDay' => $totaldays,
                    'Apply_Reason' => $request->reason,
                    'Apply_ContactNo' => $request->contactNo,
                    'Apply_DuringAddress' => $request->address,
                    'LeaveAppReason' => '',
                    'LeaveAppUpDate' => now(),
                    'LeaveRevReason' => '',
                    'LeaveRevUpDate' => now(),
                    'LeaveHodReason' => '',
                    'LeaveHodUpDate' => now(),
                    'ApplyLeave_UpdatedDate' => now(),
                    'ApplyLeave_UpdatedYearId' => $year_id,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,

                ];

                // Insert the data into hrm_employee_queryemp
                EmployeeApplyLeave::create($leaveData);
            }
        }
        if (($leaveType == 'FL')) {
            // Check combined leave conditions
            $check = $this->checkCombinedLeaveConditionsFL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);

            if ($check) {

                // Check combined leave conditions
                $totaldays = $check[0];
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();

                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $request->leaveType,
                    'Apply_FromDate' => $request->fromDate,
                    'Apply_ToDate' => $request->toDate,
                    'Apply_TotalDay' => $totaldays,
                    'Apply_Reason' => $request->reason,
                    'Apply_ContactNo' => $request->contactNo,
                    'Apply_DuringAddress' => $request->address,
                    'LeaveAppReason' => '',
                    'LeaveAppUpDate' => now(),
                    'LeaveRevReason' => '',
                    'LeaveRevUpDate' => now(),
                    'LeaveHodReason' => '',
                    'LeaveHodUpDate' => now(),
                    'ApplyLeave_UpdatedDate' => now(),
                    'ApplyLeave_UpdatedYearId' => $year_id,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,

                ];

                // Insert the data into hrm_employee_queryemp
                EmployeeApplyLeave::create($leaveData);
            }
        }
        return $msg; // Return the message, which will be empty if no validation errors
    }

    public function checkCombinedLeaveConditionsCL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // Initialize variables
        $clCount = 0; // Count for Casual Leave
        $chCount = 0; // Count for Comp-Off Leave
        $hoCount = 0; // Count of Holidays (HO)
        $validLeaveDays = $request->total_days; // Count of valid leave days (excluding Sundays)
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior
        
        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior


        if ($fromDate->format('N') === '7' && $toDate->format('N') === '7') { // 7 means Sunday in PHP
            $msg = "The From and To Date cannot be a Sunday.You Can't apply to this";
            return false;
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];
        
            // Check if any of the specified leave types have a value of 1
            if ($attendance['EL'] === 1 || $attendance['PL'] === 1 || $attendance['FL'] === 1) {
                $msg = "Leave cannot be applied as you have taken EL, PL, or FL on {$checkDate->format('Y-m-d')}.";
                return false; // Return error
            }
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0) {

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Assuming you have user ID in the request
                    ->where('Apply_FromDate', '=', $fromDate)
                    ->where('Apply_ToDate', '=', $toDate)
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('half_define', '=', $request->option)
                    ->first();

        
                if ($existingLeave) {
                    $msg = "Leave already exists for the requested dates.";
                    return false; // Return error
                }
                
                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;
        
                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays    
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                        $totalDays++; // Increment total days only if it's not a Sunday or holiday
                    }
                    $currentDate->modify('+1 day');
                }

                // If it's a half-day request, adjust the count
                // if ($isHalfDay) {
                //     $halfDayCount = $totalDays / 2; // Halve the total days for half-day requests
                // } else {
                //     $halfDayCount = $totalDays; // Use total days for full-day requests
                // }
                if ($isHalfDay) {

                    if ($request->option === '1sthalf' || $request->option === '2ndhalf') {
                        $totalDays -= 0.5;
                        $halfDayCount = $totalDays;
                    }
                } else {
                    $halfDayCount = $totalDays; // Use total days for full-day requests
                }
                
                if($halfDayCount < 0.5 || $halfDayCount > 2){
                    $msg = "Leave cannot be applied as Min- 0.5 day , Max-2 days";
                        return false; // Return error
                }

                $totalCL = 0;
                $totalSL = 0;
            
                for ($i = 0; $i < 5; $i++) {
                    $pastDate = (clone $fromDate)->modify("-$i days");
                    $attendanceDay = $attendanceResults[$pastDate->format('Y-m-d')] ?? ['CL' => 0, 'SL' => 0];
                    $totalCL += $attendanceDay['CL'];
                    $totalSL += $attendanceDay['SL'];
                }
            
                // Check if CL exceeds the limit
                if ($totalCL > 2) {
                    $msg = "You cannot apply for CL because you have more than 2 CL in the past 5 days.";
                    return false; // Return error
                }

                
                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $request->employee_id)
                ->where(function($query) use ($month, $year, $request) {
                    $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                          ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                })
                ->where('Leave_Type', '=', $request->leaveType)
                ->get();
                if ($existingLeaveRecords->isNotEmpty()) {

                    
                    // Initialize total existing leave days
                    $totalExistingLeaveDays = 0;

                    // Calculate total existing leave days
                    foreach ($existingLeaveRecords as $leave) {
                        if ($leave->half_define === '1sthalf' || $leave->half_define === '2ndhalf') {
                            $totalExistingLeaveDays += 0.5;
                        }
                        if ($leave->half_define === 'fullday') {
                            $totalExistingLeaveDays += 1;
                        }
                    }

                    // Calculate total days requested
                    $totalDaysRequested = ($request->option === '1sthalf' || $request->option === '2ndhalf') ? 0.5 : 1;

                    // Total leave days including the current request
                    $totalLeaveDays = $totalExistingLeaveDays + $totalDaysRequested;

                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                                                ->where('EmployeeID', $request->employee_id)
                                                                ->where('Month', $month)
                                                                ->where('Year', $year)
                                                                ->first();
                    // Fetch current leave balance
                    $currentLeaveBalance = $leaveBalance->BalanceCL; // Assuming you have this value from the leave balance query

                    // Check if the total leave days exceed the balance
                    if ($totalLeaveDays > $currentLeaveBalance) {
                        $msg = "You don't have sufficient leave balance. " .
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.";
                        return false; // Return error
                    }
                }
 
                $month = $fromDate->format(format: 'm'); // This will give you the month as a two-digit number (01 to 12)
                $year = $fromDate->format(format: 'Y'); // This will give you the month as a two-digit number (01 to 12)

                
                $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                ->where('EmployeeID', $request->employee_id)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->first(); // Use first() to get a single record
                if($leaveBalance->BalanceCL < $halfDayCount){
                    $msg = "You Don't have sufficient leave balance";
                    return false; // Return error
                }
                return [$halfDayCount, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
                
            }
        }    
    
    }
    
    public function checkCombinedLeaveConditionsSL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // Initialize variables
        $clCount = 0; // Count for Casual Leave
        $chCount = 0; // Count for Comp-Off Leave
        $hoCount = 0; // Count of Holidays (HO)
        $validLeaveDays = $request->total_days; // Count of valid leave days (excluding Sundays)
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior
        
        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior


        if ($fromDate->format('N') === '7' && $toDate->format('N') === '7') { // 7 means Sunday in PHP
            $msg = "The From and To Date cannot be a Sunday.You Can't apply to this";
            return false;
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];
        
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 || $attendance['CL'] ===0||$attendance['CH'] ===0||$attendance['SH'] ===0) {

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Assuming you have user ID in the request
                    ->where('Apply_FromDate', '=', $fromDate)
                    ->where('Apply_ToDate', '=', $toDate)
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('half_define', '=', $request->option)
                    ->first();

        
                if ($existingLeave) {
                    $msg = "Leave already exists for the requested dates.";
                    return false; // Return error
                }
                
                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;
        
                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays    
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                        $totalDays++; // Increment total days only if it's not a Sunday or holiday
                    }
                    $currentDate->modify('+1 day');
                }

                // If it's a half-day request, adjust the count
                if ($isHalfDay) {

                    if ($request->option === '1sthalf' || $request->option === '2ndhalf') {
                        $totalDays -= 0.5;
                        $halfDayCount = $totalDays;
                    }
                } else {
                    $halfDayCount = $totalDays; // Use total days for full-day requests
                }
                if($halfDayCount < 0.5 || $halfDayCount > 2){
                    $msg = "Leave cannot be applied as Min- 0.5 day , Max-2 days";
                        return false; // Return error
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $request->employee_id)
                ->where(function($query) use ($month, $year, $request) {
                    $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                          ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                })
                ->where('Leave_Type', '=', $request->leaveType)
                ->get();
                if ($existingLeaveRecords->isNotEmpty()) {
                    // Initialize total existing leave days
                    $totalExistingLeaveDays = 0;

                    // Calculate total existing leave days
                    foreach ($existingLeaveRecords as $leave) {
                        // if ($leave->half_define === '1sthalf' || $leave->half_define === '2ndhalf') {
                        //     // $totalExistingLeaveDays += 0.5;
                        // }
                        // if ($leave->half_define === 'fullday') {
                        //     // $totalExistingLeaveDays += 1;
                        // }
                        
                            $totalExistingLeaveDays += $leave->Apply_TotalDay; // Sum total days
                        
                    }
                    

                    // Calculate total days requested
                    $totalDaysRequested = ($request->option === '1sthalf' || $request->option === '2ndhalf') ? 0.5 : 1;

                    // Total leave days including the current request
                    $totalLeaveDays = $totalExistingLeaveDays + $totalDaysRequested;

                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                                                ->where('EmployeeID', $request->employee_id)
                                                                ->where('Month', $month)
                                                                ->where('Year', $year)
                                                                ->first();
                    // Fetch current leave balance
                    $currentLeaveBalance = $leaveBalance->BalanceSL; // Assuming you have this value from the leave balance query

                    // Check if the total leave days exceed the balance
                    if ($totalLeaveDays > $currentLeaveBalance) {
                        $msg = "You don't have sufficient leave balance. " .
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.You have already applied in this month";
                        return false; // Return error
                    }
                }
                $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                ->where('EmployeeID', $request->employee_id)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->first(); // Use first() to get a single record
                if($leaveBalance->BalanceSL < $halfDayCount){
                    $msg = "You Don't have sufficient leave balance";
                    return false; // Return error
                }
                return [$halfDayCount, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
                
            }
        }    
    
    }
    public function checkCombinedLeaveConditionsEL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // Initialize variables
        $clCount = 0; // Count for Casual Leave
        $chCount = 0; // Count for Comp-Off Leave
        $hoCount = 0; // Count of Holidays (HO)
        $validLeaveDays = $request->total_days; // Count of valid leave days (excluding Sundays)
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior
        
        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior

        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL on {$checkDate->format('Y-m-d')}.";
                return false; // Return error
            }
        
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 ||$attendance['SH'] ===0) {

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Assuming you have user ID in the request
                    ->where('Apply_FromDate', '=', $fromDate)
                    ->where('Apply_ToDate', '=', $toDate)
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('half_define', '=', $request->option)
                    ->first();

        
                if ($existingLeave) {
                    $msg = "Leave already exists for the requested dates.";
                    return false; // Return error
                }
                
                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;
        
                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    if ($currentDate->format('N') == '7' ||  $holidays) {
                        $totalDays++; // Increment total days only for Sundays or holidays
                    }                    
                    $currentDate->modify('+1 day'); // Move to the next day
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $request->employee_id)
                ->where(function($query) use ($month, $year, $request) {
                    $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                          ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                })
                ->where('Leave_Type', '=', $request->leaveType)
                ->get();
                if ($existingLeaveRecords->isNotEmpty()) {
                    // Initialize total existing leave days
                    $totalExistingLeaveDays = 0;
                    // Calculate total existing leave days
                    foreach ($existingLeaveRecords as $leave) {
                            $totalExistingLeaveDays += $leave->Apply_TotalDay; // Sum total days
                        
                    }
                

                    // Total leave days including the current request
                    $totalLeaveDays = $totalExistingLeaveDays + $totalDays;

                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                                                ->where('EmployeeID', $request->employee_id)
                                                                ->where('Month', $month)
                                                                ->where('Year', $year)
                                                                ->first();
                    // Fetch current leave balance
                    $currentLeaveBalance = $leaveBalance->BalanceEL; // Assuming you have this value from the leave balance query

                    // Check if the total leave days exceed the balance
                    if ($totalLeaveDays > $currentLeaveBalance) {
                        $msg = "You don't have sufficient leave balance. " .
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.You have already applied in this month";
                        return false; // Return error
                    }
                }
                $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                ->where('EmployeeID', $request->employee_id)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->first(); // Use first() to get a single record
                if($leaveBalance->BalanceEL < $totalDays){
                    $msg = "You Don't have sufficient leave balance";
                    return false; // Return error
                }
                return [$totalDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
                
            }
        }    
    
    }

    public function checkCombinedLeaveConditionsPL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // Initialize variables
        $clCount = 0; // Count for Casual Leave
        $chCount = 0; // Count for Comp-Off Leave
        $hoCount = 0; // Count of Holidays (HO)
        $validLeaveDays = $request->total_days; // Count of valid leave days (excluding Sundays)
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior
        
        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior

        if ($fromDate->format('N') === '7' && $toDate->format('N') === '7') { // 7 means Sunday in PHP
            $msg = "The From and To Date cannot be a Sunday.You Can't apply to this";
            return false;
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL on {$checkDate->format('Y-m-d')}.";
                return false; // Return error
            }
        
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 ||$attendance['SH'] ===0) {
                // Check the number of PL applications this year
                $currentYear = date("Y");
                $totalPlApplications = EmployeeApplyLeave::where('Leave_Type', 'PL')
                    ->where('EmployeeID', $request->employee_id)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->where('LeaveStatus', '!=', 4)
                    ->count();

                // Ensure PL can only be applied a maximum of three times in a year
                if ($totalPlApplications >= 3) {
                    $msg = "Error: You can apply for PL only 3 times in a year.";
                    return false; // Indicates that the combined leave conditions are violated
                }


                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Assuming you have user ID in the request
                    ->where('Apply_FromDate', '=', $fromDate)
                    ->where('Apply_ToDate', '=', $toDate)
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('half_define', '=', $request->option)
                    ->first();

        
                if ($existingLeave) {
                    $msg = "Leave already exists for the requested dates.";
                    return false; // Return error
                }
                
                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;
        
                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                        $totalDays++; // Increment total days only if it's not a Sunday or holiday
                    }
                    $currentDate->modify('+1 day');
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $request->employee_id)
                ->where(function($query) use ($month, $year, $request) {
                    $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                          ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                })
                ->where('Leave_Type', '=', $request->leaveType)
                ->get();
                if ($existingLeaveRecords->isNotEmpty()) {
                    // Initialize total existing leave days
                    $totalExistingLeaveDays = 0;
                    // Calculate total existing leave days
                    foreach ($existingLeaveRecords as $leave) {
                            $totalExistingLeaveDays += $leave->Apply_TotalDay; // Sum total days
                    }
                

                    // Total leave days including the current request
                    $totalLeaveDays = $totalExistingLeaveDays + $totalDays;

                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                                                ->where('EmployeeID', $request->employee_id)
                                                                ->where('Month', $month)
                                                                ->where('Year', $year)
                                                                ->first();
                    // Fetch current leave balance
                    $currentLeaveBalance = $leaveBalance->BalancePL; // Assuming you have this value from the leave balance query

                    // Check if the total leave days exceed the balance
                    if ($totalLeaveDays > $currentLeaveBalance) {
                        $msg = "You don't have sufficient leave balance. " .
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.You have already applied in this month";
                        return false; // Return error
                    }
                }


                $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                ->where('EmployeeID', $request->employee_id)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->first(); // Use first() to get a single record
                if($leaveBalance->BalancePL < $totalDays){
                    $msg = "You Don't have sufficient leave balance";
                    return false; // Return error
                }
                return [$totalDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
                
            }
        }    
    
    }
    public function checkCombinedLeaveConditionsFL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // Initialize variables
        $clCount = 0; // Count for Casual Leave
        $chCount = 0; // Count for Comp-Off Leave
        $hoCount = 0; // Count of Holidays (HO)
        $validLeaveDays = $request->total_days; // Count of valid leave days (excluding Sundays)
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior
        
        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior

        if ($fromDate->format('N') === '7' && $toDate->format('N') === '7') { // 7 means Sunday in PHP
            $msg = "The From and To Date cannot be a Sunday.You Can't apply to this";
            return false;
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL on {$checkDate->format('Y-m-d')}.";
                return false; // Return error
            }
        
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 ||$attendance['SH'] ===0) {

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Assuming you have user ID in the request
                    ->where('Apply_FromDate', '=', $fromDate)
                    ->where('Apply_ToDate', '=', $toDate)
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('half_define', '=', $request->option)
                    ->first();
        
                if ($existingLeave) {
                    $msg = "Leave already exists for the requested dates.";
                    return false; // Return error
                }
                
                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;
        
                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                        $totalDays++; // Increment total days only if it's not a Sunday or holiday
                    }
                    $currentDate->modify('+1 day');
                }
                if($totalDays > 1 ){
                    $msg = "You can apply festival laeve for 1 days maximum";
                        return false; // Return error
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $request->employee_id)
                ->where(function($query) use ($month, $year, $request) {
                    $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                          ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                })
                ->where('Leave_Type', '=', $request->leaveType)
                ->get();

                if ($existingLeaveRecords->isNotEmpty()) {
                    // Initialize total existing leave days
                    $totalExistingLeaveDays = 0;
                    // Calculate total existing leave days
                    foreach ($existingLeaveRecords as $leave) {
                            $totalExistingLeaveDays += $leave->Apply_TotalDay; // Sum total days
                    }
                

                    // Total leave days including the current request
                    $totalLeaveDays = $totalExistingLeaveDays + $totalDays;

                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                                                ->where('EmployeeID', $request->employee_id)
                                                                ->where('Month', $month)
                                                                ->where('Year', $year)
                                                                ->first();
                    // Fetch current leave balance
                    $currentLeaveBalance = $leaveBalance->BalanceOL; // Assuming you have this value from the leave balance query

                    // Check if the total leave days exceed the balance
                    if ($totalLeaveDays > $currentLeaveBalance) {
                        $msg = "You don't have sufficient leave balance. " .
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.You have already applied in this month";
                        return false; // Return error
                    }
                }


                $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                                ->where('EmployeeID', $request->employee_id)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->first(); // Use first() to get a single record
                if($leaveBalance ==NULL){
                    $msg = "You Don't have leave data in database";
                    return false; // Return error
                }
                if($leaveBalance->BalanceOL < $totalDays){
                    $msg = "You Don't have sufficient leave balance";
                    return false; // Return error
                }
                return [$totalDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
                
            }
        }    
    
    }
    // public function checkCombinedLeaveConditionsEL($request, $elResults, $appFromDate, $appToDate, &$msg)
    // {
    //     // Fetch public holidays from the attendance table
    //     $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays

    //     // Convert string dates to DateTime objects for easy manipulation
    //     $startDate = new \DateTime($appFromDate);
    //     $endDate = new \DateTime($appToDate);
    //     $endDate->modify('+1 day'); // Include the end date in the range

    //     // Prepare variables for calculations
    //     $totalDays = 0;
    //     $countedDates = [];

    //     // Create an array of all dates in the range
    //     $dateRange = [];
    //     while ($startDate < $endDate) {
    //         $currentDate = $startDate->format('Y-m-d');
    //         $dateRange[] = $currentDate; // Store all dates in the range
    //         $startDate->modify('+1 day'); // Move to the next day
    //     }

    //     // Check each date in the range
    //     foreach ($dateRange as $currentDate) {
    //         // Count the total days, including Sundays and public holidays
    //         if ($this->isSunday($currentDate) || in_array($currentDate, $holidays)) {
    //             // Treat as leave day
    //             if (!in_array($currentDate, $countedDates)) {
    //                 $totalDays++;
    //                 $countedDates[] = $currentDate; // Count the date
    //             }
    //         } elseif (isset($elResults[$currentDate])) {
    //             // Count EL days
    //             if ($elResults[$currentDate]['elLeaveCount'] > 0 || $elResults[$currentDate]['elAttendanceCount'] > 0) {
    //                 if (!in_array($currentDate, $countedDates)) {
    //                     $totalDays++;
    //                     $countedDates[] = $currentDate; // Count the date
    //                 }
    //             }
    //         } else {
    //             // Count normal working days
    //             $totalDays++; // Increment for normal working days that are not Sundays or holidays
    //         }
    //     }
    //     // Check if total days is not exactly 3
    //     if ($totalDays !== 3) {
    //         $msg = "You must apply for exactly 3 days of leave";
    //         return false; // Condition not met
    //     }

    //     // Check for SL and PL on adjacent dates
    //     $prevDate = (new \DateTime($appFromDate))->modify('-1 day')->format('Y-m-d');
    //     $nextDate = (new \DateTime($appToDate))->modify('+1 day')->format('Y-m-d');

    //     // Check previous day for SL/PL
    //     if (isset($elResults[$prevDate]) && ($elResults[$prevDate]['elLeaveCount'] > 0 || $elResults[$prevDate]['elAttendanceCount'] > 0)) {
    //         // If the previous day is a Sunday or holiday, merge it
    //         if ($this->isSunday($prevDate) || in_array($prevDate, $holidays)) {
    //             if (!in_array($prevDate, $countedDates)) {
    //                 $totalDays++;
    //                 $countedDates[] = $prevDate; // Count the date
    //             }
    //         }
    //     }

    //     // Check next day for SL/PL
    //     if (isset($elResults[$nextDate]) && ($elResults[$nextDate]['elLeaveCount'] > 0 || $elResults[$nextDate]['elAttendanceCount'] > 0)) {
    //         // If the next day is a Sunday or holiday, merge it
    //         if ($this->isSunday($nextDate) || in_array($nextDate, $holidays)) {
    //             if (!in_array($nextDate, $countedDates)) {
    //                 $totalDays++;
    //                 $countedDates[] = $nextDate; // Count the date
    //             }
    //         }
    //     }
    //     $fromMonth = $appFromDate->format('m'); // Get the month (01-12)

    //     // Get the current year
    //     $currentYear = date('Y'); // Current year

    //     // Fetch the balance from hrm_employee_monthlyleave_balance table
    //     $balanceEL = LeaveBalance::where('EmployeeID', $request->employee_id)
    //         ->where('Month', $fromMonth) // Use the month from fromDate
    //         ->where('Year', $currentYear)
    //         ->value('BalanceEL'); // Assuming BalanceEL is the field storing Casual Leave balance
    //     // Check if valid leave days exceed the balance
    //     if ($totalDays > $balanceEL) {
    //         $msg = "You do not have enough Casual Leave balance.";
    //         return false; // Indicates that the combined leave conditions are violated
    //     }

    //     // Final validation after merging
    //     if ($totalDays !== 3) {
    //         $msg = "After considering adjacent leaves, you must still apply for exactly 3 days of leave.";
    //         return false; // Condition not met
    //     }

    //     // If all conditions are satisfied
    //     return [$totalDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
    // }
    // public function checkCombinedLeaveConditionsPL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    // {
    //     // Parse the application dates
    //     $fromDate = new \DateTime($appFromDate);
    //     $toDate = new \DateTime($appToDate);

    //     // Initialize counts
    //     $validLeaveDays = 0; // Count of valid leave days (excluding weekends and holidays)

    //     // Check for leave within 5 days prior to the requested leave
    //     $checkFromDate = clone $fromDate;
    //     $checkFromDate->modify('-5 days'); // Get the date 5 days prior
    //     $currentDate = clone $checkFromDate;

    //     while ($currentDate < $fromDate) { // Loop until the day before the fromDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0
    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0 // Check for PL
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the previous 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Check for leave within 5 days after the requested leave
    //     $checkToDate = clone $toDate;
    //     $checkToDate->modify('+5 days'); // Get the date 5 days after
    //     $currentDate = clone $toDate;
    //     while ($currentDate < $checkToDate) { // Loop until the day after the toDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine after date
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0

    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the next 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Loop through the date range for valid leave days
    //     $currentDate = clone $fromDate;
    //     while ($currentDate <= $toDate) {
    //         $validLeaveDays++;

    //         // Check if the current date is a Sunday or a holiday
    //         if ($this->isSunday($currentDate->format('Y-m-d')) || in_array($currentDate->format('Y-m-d'), $this->getPublicHolidays())) {
    //             // Skip counting this day as a leave day
    //             $currentDate->modify('+1 day'); // Move to the next day
    //             continue; // Move to the next iteration
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }
    //     $fromMonth = $fromDate->format('m'); // Get the month (01-12)

    //     // Get the current year
    //     $currentYear = date('Y'); // Current year

    //     // Fetch the balance from hrm_employee_monthlyleave_balance table
    //     $balancePL = LeaveBalance::where('EmployeeID', $request->employee_id)
    //         ->where('Month', $fromMonth) // Use the month from fromDate
    //         ->where('Year', $currentYear)
    //         ->value('BalancePL'); // Assuming BalancePL is the field storing Casual Leave balance

    //     // Check if valid leave days exceed the balance
    //     if ($validLeaveDays > $balancePL) {
    //         $msg = "You do not have enough Casual Leave balance.";
    //         return false; // Indicates that the combined leave conditions are violated
    //     }
    //     // Validate leave duration
    //     if ($validLeaveDays < 1 || $validLeaveDays > 6) {
    //         $msg = "Leave duration must be between 1 and 6 valid working days.";
    //         return false; // Indicates that leave duration is invalid
    //     }

    //     // Check the number of PL applications this year
    //     $currentYear = date("Y");
    //     $totalPlApplications = EmployeeApplyLeave::where('Leave_Type', 'PL')
    //         ->where('EmployeeID', $request->employee_id)
    //         ->whereYear('Apply_FromDate', $currentYear)
    //         ->where('LeaveStatus', '!=', 4)
    //         ->count();

    //     // Ensure PL can only be applied a maximum of three times in a year
    //     if ($totalPlApplications >= 3) {
    //         $msg = "Error: You can apply for PL only 3 times in a year.";
    //         return false; // Indicates that the combined leave conditions are violated
    //     }

    //     // If all conditions are satisfied
    //     return [$validLeaveDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
    // }
    // public function checkCombinedLeaveConditionsSL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    // {
    //     // Parse the application dates
    //     $fromDate = new \DateTime($appFromDate);
    //     $toDate = new \DateTime($appToDate);
    //     $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
    //     $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

    //     // Initialize counts
    //     $validLeaveDays = 0; // Count of valid leave days (excluding weekends and holidays)

    //     // Check for leave within 5 days prior to the requested leave
    //     $checkFromDate = clone $fromDate;
    //     $checkFromDate->modify('-5 days'); // Get the date 5 days prior
    //     $currentDate = clone $checkFromDate;
    //     $currentDatecheck = new \DateTime(); // Set to today's date


    //     if ($fromDate > $currentDatecheck || $toDate > $currentDatecheck) {
    //         $msg = "Leave cannot be taken for future dates.";
    //         return false; // Indicates that the leave cannot be processed
    //     }

    //     while ($currentDate < $fromDate) { // Loop until the day before the fromDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0
    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0 // Check for PL
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the previous 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Check for leave within 5 days after the requested leave
    //     $checkToDate = clone $toDate;
    //     $checkToDate->modify('+5 days'); // Get the date 5 days after
    //     $currentDate = clone $toDate;
    //     while ($currentDate < $checkToDate) { // Loop until the day after the toDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine after date
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0

    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the next 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Loop through the date range for valid leave days
    //     $currentDate = clone $fromDate;
    //     while ($currentDate <= $toDate) {
    //         $validLeaveDays++;

    //         // Check if the current date is a Sunday or a holiday
    //         if ($this->isSunday($currentDate->format('Y-m-d')) || in_array($currentDate->format('Y-m-d'), $this->getPublicHolidays())) {
    //             // Skip counting this day as a leave day
    //             $currentDate->modify('+1 day'); // Move to the next day
    //             continue; // Move to the next iteration
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }
    //     if ($isHalfDay) {
    //         $validLeaveDays -= 0.5; // Deduct 0.5 day for half-day requests
    //     }
    //     $fromMonth = $fromDate->format('m'); // Get the month (01-12)

    //     // Get the current year
    //     $currentYear = date('Y'); // Current year
    //     // Fetch the balance from hrm_employee_monthlyleave_balance table
    //     $balanceSL = LeaveBalance::where('EmployeeID', $request->employee_id)
    //         ->where('Month', $fromMonth) // Use the month from fromDate
    //         ->where('Year', $currentYear)
    //         ->value('BalanceSL'); // Assuming BalanceSL is the field storing Casual Leave balance

    //     // Check if valid leave days exceed the balance
    //     if ($validLeaveDays > $balanceSL) {
    //         $msg = "You do not have enough Sick Leave balance.";
    //         return false; // Indicates that the combined leave conditions are violated
    //     }
    //     // Validate leave duration
    //     if ($validLeaveDays < 0.5) {
    //         $msg = "Chcek Your Leave Dates";
    //         return false; // Indicates that leave duration is invalid
    //     }


    //     // If all conditions are satisfied
    //     return [$validLeaveDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
    // }

    // public function checkCombinedLeaveConditionsFL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    // {
    //     // Parse the application dates
    //     $fromDate = new \DateTime($appFromDate);
    //     $toDate = new \DateTime($appToDate);

    //     // Initialize counts
    //     $validLeaveDays = 0; // Count of valid leave days (excluding weekends and holidays)

    //     // Check for leave within 5 days prior to the requested leave
    //     $checkFromDate = clone $fromDate;
    //     $checkFromDate->modify('-5 days'); // Get the date 5 days prior
    //     $currentDate = clone $checkFromDate;

    //     while ($currentDate < $fromDate) { // Loop until the day before the fromDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0
    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the previous 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Check for leave within 5 days after the requested leave
    //     $checkToDate = clone $toDate;
    //     $checkToDate->modify('+5 days'); // Get the date 5 days after
    //     $currentDate = clone $toDate;
    //     while ($currentDate < $checkToDate) { // Loop until the day after the toDate
    //         $dateString = $currentDate->format('Y-m-d');

    //         // Check for leave results () and attendance results cannot combine after date
    //         if (
    //             (isset($leaveResults[$dateString]) && (
    //                 $leaveResults[$dateString]['CL'] > 0 ||
    //                 $leaveResults[$dateString]['FL'] > 0 ||
    //                 $leaveResults[$dateString]['CH'] > 0

    //             )) ||
    //             (isset($attendanceResults[$dateString]) && (
    //                 $attendanceResults[$dateString]['CL'] > 0 ||
    //                 $attendanceResults[$dateString]['FL'] > 0 ||
    //                 $attendanceResults[$dateString]['CH'] > 0
    //             ))
    //         ) {
    //             $msg = "Leave cannot be taken due to existing leave or attendance records in the next 5 days.";
    //             return false; // Indicates that the combined leave conditions are violated
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }

    //     // Loop through the date range for valid leave days
    //     $currentDate = clone $fromDate;
    //     while ($currentDate <= $toDate) {
    //         $validLeaveDays++;

    //         // Check if the current date is a Sunday or a holiday
    //         if ($this->isSunday($currentDate->format('Y-m-d')) || in_array($currentDate->format('Y-m-d'), $this->getPublicHolidays())) {
    //             // Skip counting this day as a leave day
    //             $currentDate->modify('+1 day'); // Move to the next day
    //             continue; // Move to the next iteration
    //         }

    //         // Move to the next day
    //         $currentDate->modify('+1 day');
    //     }
    //     $fromMonth = $fromDate->format('m'); // Get the month (01-12)

    //     // Get the current year
    //     $currentYear = date('Y'); // Current year

    //     // Fetch the balance from hrm_employee_monthlyleave_balance table
    //     $balanceFL = LeaveBalance::where('EmployeeID', $request->employee_id)
    //         ->where('Month', $fromMonth) // Use the month from fromDate
    //         ->where('Year', $currentYear)
    //         ->value('BalanceOL'); // Assuming BalanceCL is the field storing Casual Leave balance
    //     if ($validLeaveDays > $balanceFL) {
    //         $msg = "You do not have enough Festival Leave balance.";
    //         return false; // Indicates that the combined leave conditions are violated
    //     }

    //     // Validate leave duration
    //     if ($validLeaveDays < 1) {
    //         $msg = "Leave duration must be between 1 valid Festival Leave.";
    //         return false; // Indicates that leave duration is invalid
    //     }


    //     // If all conditions are satisfied
    //     return [$validLeaveDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays
    // }

    public function getPublicHolidays()
    {
        $holidays = [];
        $year = date("Y");
        // Fetch from the attendance table where attValue is "HO"
        $holidays = \DB::table('hrm_holiday')->where('Year', $year)->pluck('HolidayDate')->toArray();
        return $holidays;
    }
    public function isSunday($date)
    {
        return (new \DateTime($date))->format('N') == 7; // 7 represents Sunday in ISO-8601
    }
    public function fetchLeaveRequests(Request $request)
    {
        $employeeId = $request->employee_id;

        // Step 1: Get all employees represented by the given employeeId
        $Employees_ids = EmployeeGeneral::where('RepEmployeeID', $employeeId)->pluck('EmployeeID');

        $employeeId = $request->employee_id;

        // Step 1: Get all employees represented by the given employeeId
        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $employeeId)->pluck('EmployeeID');

        // Step 2: Fetch leave requests for those employees
        $leaveRequests = EmployeeApplyLeave::whereIn('EmployeeID', $employeeIds)
            ->where('LeaveStatus', '0') // Assuming '0' means pending or active
            ->get();

        // Initialize an array to hold combined data
        $combinedData = [];

        // Step 3: Fetch employee details and combine with leave requests
        if ($leaveRequests->isNotEmpty()) {
            foreach ($leaveRequests as $leaveRequest) {
                $employeeDetails = Employee::find($leaveRequest->EmployeeID);

                $combinedData[] = [
                    'leaveRequest' => $leaveRequest,
                    'employeeDetails' => $employeeDetails,
                ];
            }

            // Return the combined data as JSON
            return response()->json($combinedData);
        }

        // If no leave requests are found, return a message
        return response()->json(['message' => 'No leave requests found for this employee.'], 404);
    }
    public function leaveauthorize(Request $request)
    {

        // Extract validated data
        $employeeId = $request->employeeId;
        $leaveType = $request->leavetype;
        $vStatus = $request->Status;
        $yearId = date('Y');

        if ($vStatus == "approved") {
            $vStatus = '1';
        }
        if ($vStatus == "rejected") {
            $vStatus = '0';
        }
        $total_days = $request->total_days;


        // Only process if the status is approved
        if ($vStatus == 1) {
            // Parse from and to dates
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date);

            $Fmonth = $fromDate->month;
            $Fday = $fromDate->day;
            $Tmonth = $toDate->month;

            $Tday = $toDate->day;
            $Fyear = $fromDate->year;
            $Tyear = $toDate->year;

            if ($Fmonth == $Tmonth) {
                // Single month leave
                for ($i = $Fday; $i <= $Tday; $i++) {
                    $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days);                    
                    if ($check) {
                        return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                    }
                    else if ($check ==NULL || $check=="null"||$check=='') {
                        return response()->json(['success' => true, 'message' => 'Leave authorized alreday made.']);
                    }
                }
            } elseif ($Fmonth != $Tmonth && $Fyear == $Tyear) {
                // Different months, same year
                $FlastDayOfFromMonth = $fromDate->endOfMonth()->day;
            
                // First month
                for ($i = $Fday; $i <= $FlastDayOfFromMonth; $i++) {
                    $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days);
                    if ($check) {
                        return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                    }
                    else if ($check ==NULL || $check=="null"||$check=='') {
                        return response()->json(['success' => true, 'message' => 'Leave authorized alreday made.']);
                    }
                }
                // Second month
                for ($i = 1; $i <= $Tday; $i++) {
                    $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days);
                    if ($check) {
                        return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                    }
                    else if ($check ==NULL || $check=="null"||$check=='') {
                        return response()->json(['success' => true, 'message' => 'Leave authorized alreday made.']);
                    }
                }
            } elseif ($Fmonth != $Tmonth && $Fyear != $Tyear) {
                // Different months and years
                $FlastDayOfFromMonth = $fromDate->endOfMonth()->day;
            
                // Process leave for the first month
                for ($i = $Fday; $i <= $FlastDayOfFromMonth; $i++) {
                    $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days);
                    if ($check) {
                        return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                    }
                    else if ($check ==NULL || $check=="null"||$check=='') {
                        return response()->json(['success' => true, 'message' => 'Leave authorized alreday made.']);
                    }
                }
            
                // Process leave for the second month
                for ($i = 1; $i <= $Tday; $i++) {
                    $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days);
                    if ($check) {
                        return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                    }
                    else if ($check ==NULL || $check=="null"||$check=='') {
                        return response()->json(['success' => true, 'message' => 'Leave authorized alreday made.']);
                    }
                }
            }
            // If no leave was authorized successfully
            return response()->json(['success' => false, 'message' => 'No leave was authorized.']);
            
        }
        if ($vStatus == 0) {
            $fd = $request->from_date;
            $td = $request->to_date;
            // Check if the leave request exists with the same EmployeeID, Apply_FromDate, and Apply_ToDate
                $leaveRequest = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $employeeId)
                ->where('Apply_FromDate', $fd)
                ->where('Apply_ToDate', $td)
                ->first();

                if ($leaveRequest) {
                // Check if the LeaveStatus and LeaveAppStatus are already '0'
                if ($leaveRequest->LeaveStatus == '0' && $leaveRequest->LeaveAppStatus == '0') {
                    return response()->json(['success' => true, 'message' => 'Leave already rejected.']);
                } 
                else if ($leaveRequest->LeaveStatus == '1' && $leaveRequest->LeaveAppStatus == '1') {
                     $check=$this->reverseLeaveAcceptance($request);
                }
                
                else {
                    // Update the leave status to rejected
                    $reject = \DB::table('hrm_employee_applyleave')
                        ->where('EmployeeID', $employeeId)
                        ->where('Apply_FromDate', $fd)
                        ->where('Apply_ToDate', $td)
                        ->update([
                            'LeaveStatus' => '0',
                            'LeaveAppStatus' => '0',
                        ]);

                    if ($reject) {
                        return response()->json(['success' => true, 'message' => 'Leave Rejected successfully.']);
                    }
                }
                } 
                else {
                return response()->json(['success' => false, 'message' => 'Leave request not found.']);
                }



        }

    }

    protected function processLeave($request, $employeeId, $leaveType, Carbon $fromDate, Carbon $toDate, $yearId, $total_days)
    {
        // Get the appropriate attendance table
        $attTable = $this->getAttendanceTable($fromDate->year, $fromDate->month);

        // Check if it's a Sunday
        if ($fromDate->dayOfWeek != Carbon::SUNDAY) { // Non-Sunday
            // Check if attendance record exists
            $attendanceRecord = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->first();

            // Check for holiday
            $isHoliday = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->where('AttValue', 'HO')
                ->exists();

            if (!$attendanceRecord) {
                // Insert new attendance record
                Attendance::create([
                    'EmployeeID' => $employeeId,
                    'AttValue' => $leaveType,
                    'AttDate' => $fromDate->format('Y-m-d'),
                    'Year' => $fromDate->year,
                    'YearId' => $yearId,
                ]);
            } elseif ($attendanceRecord && !$isHoliday) {
                if ($request->leavetype_day == "1sthalf" || $request->leavetype_day == "2ndhalf") {
                    if ($leaveType == "CL") {
                        $leaveType = "CH";
                    }
                    if ($leaveType == "SL") {
                        $leaveType = "SH";
                    }
                }

                // Update existing attendance record
                $update = \DB::table($attTable)
                    ->where('EmployeeID', $employeeId)
                    ->where('AttDate', $fromDate->format('Y-m-d'))
                    ->update(['AttValue' => $leaveType]);

                if ($update) {
                    // Define start and end dates
                    $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                    $endDate = $toDate->endOfMonth()->format('Y-m-d');

                    $attTable = 'hrm_employee_attendance'; // Define attendance table name

                    // Count various attendance values
                    $attendanceCounts = [
                        'CL' => \DB::table($attTable)->where('AttValue', 'CL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'CH' => \DB::table($attTable)->where('AttValue', 'CH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'SL' => \DB::table($attTable)->where('AttValue', 'SL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'SH' => \DB::table($attTable)->where('AttValue', 'SH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'PL' => \DB::table($attTable)->where('AttValue', 'PL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'EL' => \DB::table($attTable)->where('AttValue', 'EL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'FL' => \DB::table($attTable)->where('AttValue', 'FL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'TL' => \DB::table($attTable)->where('AttValue', 'TL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'Hf' => \DB::table($attTable)->where('AttValue', 'CH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'Present' => \DB::table($attTable)->where('AttValue', 'P')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'Absent' => \DB::table($attTable)->where('AttValue', 'A')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'OnDuties' => \DB::table($attTable)->where('AttValue', 'OD')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'Holiday' => \DB::table($attTable)->where('AttValue', 'HO')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        'ELSun' => \DB::table($attTable)->where('CheckSunday', 'Y')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                    ];

                    // Calculating totals
                    $totalCL = $attendanceCounts['CL'] + ($attendanceCounts['CH'] / 2);
                    $totalSL = $attendanceCounts['SL'] + ($attendanceCounts['SH'] / 2);
                    $totalLeaveCount = $totalCL + $totalSL + $attendanceCounts['PL'] + $attendanceCounts['EL'] + $attendanceCounts['FL'] + $attendanceCounts['TL'];

                    $totalPR = $attendanceCounts['Present'] + ($attendanceCounts['CH'] / 2) + ($attendanceCounts['SH'] / 2) + ($attendanceCounts['Hf'] / 2);
                    $totalAbsent = $attendanceCounts['Absent'] + ($attendanceCounts['Hf'] / 2);
                    $totalOnDuties = $attendanceCounts['OnDuties'];
                    $totalHoliday = $attendanceCounts['Holiday'];

                    $totalDaysWithSunEL = $totalPR + $totalLeaveCount + $totalOnDuties + $totalHoliday;
                    // minus OP
                    // (REAL TIME)
                    // Define total working days


                    // Determine year and month
                    $year = $fromDate->year;
                    $month = $fromDate->month;
                    $previousYear = $year - 1;

                    // Determine table names based on the given logic
                    if ($year >= date('Y')) {
                        $leaveTable = 'hrm_employee_monthlyleave_balance';
                        $appLeaveTable = 'hrm_employee_applyleave';
                    } elseif ($year == $previousYear && $month == 1 && $toDate->month == 12) {
                        $leaveTable = 'hrm_employee_monthlyleave_balance';
                        $appLeaveTable = 'hrm_employee_applyleave';
                    } elseif ($year == $previousYear && $month < 12) {
                        $leaveTable = 'hrm_employee_monthlyleave_balance_' . $year;
                        $appLeaveTable = 'hrm_employee_applyleave_' . $year;
                    } else {
                        $leaveTable = 'hrm_employee_monthlyleave_balance_' . $year;
                        $appLeaveTable = 'hrm_employee_applyleave_' . $year;
                    }

                    // Get the leave balance for the specified employee, month, and year
                    $leaveBalance = \DB::table($leaveTable)
                        ->where('EmployeeID', $employeeId)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->get();
                    if ($leaveBalance) {

                        // Calculate totals based on whether it's the first month or not
                        if ($month != 1) {
                            $totalBalCL = $leaveBalance[0]->OpeningCL - $totalCL;
                            $totalBalSL = $leaveBalance[0]->OpeningSL - $totalSL;
                            $totalBalPL = $leaveBalance[0]->OpeningPL - $attendanceCounts['PL'];
                            $totalBalEL = $leaveBalance[0]->OpeningEL - $attendanceCounts['EL'];
                            $totalBalFL = $leaveBalance[0]->OpeningOL - $attendanceCounts['FL'];
                        } else {
                            $totalBalCL = $leaveBalance[0]->TotCL - $totalCL;
                            $totalBalSL = $leaveBalance[0]->TotSL - $totalSL;
                            $totalBalPL = $leaveBalance[0]->TotPL - $attendanceCounts['PL'];
                            $totalBalEL = $leaveBalance[0]->TotEL - $attendanceCounts['EL'];
                            $totalBalFL = $leaveBalance[0]->TotOL - $attendanceCounts['FL'];
                        }

                        // Update the leave balance
                        \DB::table($leaveTable)->where('EmployeeID', $employeeId)
                            ->where('Month', $month)
                            ->where('Year', $year)
                            ->update([
                                'AvailedCL' => $totalCL,
                                'AvailedSL' => $totalSL,
                                'AvailedPL' => $attendanceCounts['PL'],
                                'AvailedEL' => $attendanceCounts['EL'],
                                'AvailedOL' => $attendanceCounts['FL'],
                                'AvailedTL' => $attendanceCounts['TL'],
                                'BalanceCL' => $totalBalCL,
                                'BalanceSL' => $totalBalSL,
                                'BalancePL' => $totalBalPL,
                                'BalanceEL' => $totalBalEL,
                                'BalanceOL' => $totalBalFL,
                            ]);
                        $fd = $request->from_date;
                        $td = $request->to_date;


                        \DB::table('hrm_employee_applyleave')
                            ->where('EmployeeID', $employeeId)
                            ->where('Apply_FromDate', $fd)
                            ->where('Apply_ToDate', $td)
                            ->update([
                                'LeaveStatus' => '1',
                                'LeaveAppStatus' => '1',
                            ]);
                            return 1; // Successfully updated record

                    }
                }
            }

        } elseif ($leaveType == 'EL' && $fromDate->dayOfWeek == Carbon::SUNDAY) { // Handle Sundays with leave type 'EL'
            $attendanceRecord = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->first();

            $isHoliday = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->where('AttValue', 'HO')
                ->exists();

            if (!$attendanceRecord) {
                // Insert new attendance record for Sunday
                Attendance::create([
                    'EmployeeID' => $employeeId,
                    'AttValue' => $leaveType,
                    'AttDate' => $fromDate->format('Y-m-d'),
                    'CheckSunday' => 'Y',
                    'Year' => $fromDate->year,
                    'YearId' => $yearId,
                ]);
                return 1; // Successfully updated record

            } elseif ($attendanceRecord && !$isHoliday) {
                // Update existing attendance record for Sunday
                \DB::table($attTable)
                    ->where('EmployeeID', $employeeId)
                    ->where('AttDate', $fromDate->format('Y-m-d'))
                    ->update(['AttValue' => $leaveType, 'CheckSunday' => 'Y']);

                    return 1; // Successfully updated record

            }
        }

    }

    protected function getAttendanceTable($year, $month)
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        if ($year >= $currentYear) {
            return 'hrm_employee_attendance';
        } elseif ($year == $previousYear && date('m') == '01' && $month == 12) {
            return 'hrm_employee_attendance';
        } elseif ($year == $previousYear && $month < 12) {
            return "hrm_employee_attendance_{$year}";
        } else {
            return "hrm_employee_attendance_{$year}";
        }
    }
        public function reverseLeaveAcceptance($request)
    {
        $employeeId = $request->employeeId;
        $fd = $request->from_date;
        $td = $request->to_date;

        // Check if the leave request exists with the same EmployeeID, Apply_FromDate, and Apply_ToDate
        $leaveRequest = \DB::table('hrm_employee_applyleave')
            ->where('EmployeeID', $employeeId)
            ->where('Apply_FromDate', $fd)
            ->where('Apply_ToDate', $td)
            ->first();

        // Check if leave request is already rejected
        if ($leaveRequest && $leaveRequest->LeaveStatus == '1' && $leaveRequest->LeaveAppStatus == '1') {
            // Fetch attendance data and update AttValue to 'P'
            \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $employeeId)
                ->where('AttDate', $fd)
                ->update(['AttValue' => 'P']);

            // Determine month and year
            $fromDate = \Carbon\Carbon::parse($fd);
            $month = $fromDate->month;
            $year = $fromDate->year;

            // Fetch the leave balance for the specified employee, month, and year
            $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                ->where('EmployeeID', $employeeId)
                ->where('Month', $month)
                ->where('Year', $year)
                ->first();

            if ($leaveBalance) {
                // Add the total days to the appropriate leave balances based on leave types
                $totalDays = $request->total_days;

                if ($leaveRequest->Leave_Type == 'CL') {
                    $leaveBalance->BalanceCL += $totalDays;
                    $leaveBalance->AvailedCL += $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'SL') {
                    $leaveBalance->BalanceSL += $totalDays;
                    $leaveBalance->AvailedSL += $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'EL') {
                    $leaveBalance->BalanceEL += $totalDays;
                    $leaveBalance->AvailedEL += $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'PL') {
                    $leaveBalance->BalancePL += $totalDays;
                    $leaveBalance->AvailedPL += $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'FL') {
                    $leaveBalance->BalanceOL += $totalDays;
                    $leaveBalance->AvailedOL += $totalDays; // Assuming this is for "On Leave"
                }

                // Update the leave balance in the database
                $update=\DB::table('hrm_employee_monthlyleave_balance')
                    ->where('EmployeeID', $employeeId)
                    ->where('Month', $month)
                    ->where('Year', $year)
                    ->update([
                        'BalanceCL' => $leaveBalance->BalanceCL,
                        'BalanceSL' => $leaveBalance->BalanceSL,
                        'BalanceEL' => $leaveBalance->BalanceEL,
                        'BalancePL' => $leaveBalance->BalancePL,
                        'BalanceOL' => $leaveBalance->BalanceOL,
                        'AvailedCL' => $leaveBalance->AvailedCL,
                        'AvailedSL' => $leaveBalance->AvailedSL,
                        'AvailedEL' => $leaveBalance->AvailedEL,
                        'AvailedPL' => $leaveBalance->AvailedPL,
                        'AvailedOL' => $leaveBalance->AvailedOL,
                    ]);
                    \DB::table('hrm_employee_applyleave')
                        ->where('EmployeeID', $employeeId)
                        ->where('Apply_FromDate', $fd)
                        ->where('Apply_ToDate', $td)
                        ->update([
                            'LeaveStatus' => '0',
                            'LeaveAppStatus' => '0',
                        ]);
            }

            return response()->json(['success' => true, 'message' => 'Leave request processed successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Leave request cannot be processed.']);
    }

}


