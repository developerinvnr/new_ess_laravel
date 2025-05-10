<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeApplyLeave;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Personaldetails;
use App\Models\EmployeeGeneral;
use Carbon\Carbon;
use App\Mail\Leave\LeaveAuthMail;
use App\Mail\Leave\LeaveDeleteMail;
use App\Mail\Leave\LeaveApplyCancellationMail;
use App\Mail\Leave\LeaveCancelStatusMail;
use App\Mail\Leave\LeaveActionMail;
use App\Models\EmployeeReporting;
use Illuminate\Support\Facades\Mail;
use DB\DB;
use App\Mail\LeaveApplicationMail;
use App\Mail\BestWishesMail;
use Dcblogdev\LaravelSentEmails\Models\SentEmail;

use App\Models\HrmYear;
use Illuminate\Support\Facades\Auth;


class LeaveController extends Controller
{
    public function applyLeave(Request $request)
    {
        // Validate the contact number
        if (strlen($request->contactNo) != 10 || !is_numeric($request->contactNo)) {
            return response()->json(['success' => false, 'message' => 'Contact Number should be 10 digits.']);
        }
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

        $leaves = EmployeeApplyLeave::where('EmployeeID', $employeeId)
            ->orderBy('Apply_FromDate', 'desc')  // Sorting by Apply_FromDate in descending order
            ->paginate(5);  // Paginate to show 5 records per page

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
                    <p>' . $leave->LeaveRevReason . '</p>
                </td>
                <td>
                    <p>' . $leave->Apply_Reason . '</p>
                </td>
                <td style="text-align:right;">';

            // Leave Status
            if ($leave->LeaveStatus == 0) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Draft">Draft</label>';
            } elseif ($leave->LeaveStatus == 1) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline warning-outline" title="" data-original-title="Approved">Approved</label>';
            } elseif ($leave->LeaveStatus == 2) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="" data-original-title="Approved">Approved</label>';
            } elseif ($leave->LeaveStatus == 3) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Reject">Reject</label>';
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
                if ($totaldays == 0.5) {
                    // Handle the case where the total days is 0.5
                    $leave_type = "SH"; // Set status to "CH"
                } else {
                    // Handle other cases
                    $leave_type = "SL"; // Or any other logic for full day
                }
                $back_date_flag = $check[1];
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
                $year_id_current = $currentYearRecord->YearId;

                $employee = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $request->employee_id)
                    ->first();
                $ReportingEmailId = $employee->ReportingEmailId ?? null; // Use null coalescing operator for safety
                $reportingID = $employee->RepEmployeeID ?? null; // Use null coalescing operator for safety
                $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $leave_type,
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
                    'ApplyLeave_UpdatedYearId' => $year_id_current,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,
                    'back_date_flag' => $back_date_flag,
                    'Apply_SentToRev' => $reportingDetails->ReviewerId ?? 0,
                    'Apply_SentToApp' => $employee->RepEmployeeID ?? 0,
                    'Apply_SentToHOD' => $reportingDetails->HodId ?? 0,
                    'LeaveStatus' => '0',

                ];
                if (EmployeeApplyLeave::create($leaveData)) {
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

                    $ReportingName = $reportinggeneral->ReportingName;
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;

                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'ReportingManager' => $ReportingName,
                        'subject' => 'Leave Request',
                        'EmpName' => $Empname,
                        'leavetype' => $request->leaveType,
                        'TotalDays' =>  $totaldays,
                        'FromDate' => $request->fromDate,
                        'ToDate' => $request->toDate,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];
                  
                            Mail::to($ReportingEmailId)->send(new LeaveAuthMail($details));
                     
                }
            }
        }
        // Validation rules
        if (($leaveType == 'CL' || $leaveType == 'CH')) {
            // Check combined leave conditions
            $check = $this->checkCombinedLeaveConditionsCL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {
                $totaldays = $check[0];
                // Check if $totaldays is 0.5
                if ($totaldays == 0.5) {
                    // Handle the case where the total days is 0.5
                    $leave_type = "CH"; // Set status to "CH"
                } else {
                    // Handle other cases
                    $leave_type = "CL"; // Or any other logic for full day
                }
                $back_date_flag = $check[1];

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
                $year_id_current = $currentYearRecord->YearId;
                $employee = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $request->employee_id)
                    ->first();
                $ReportingEmailId = $employee->ReportingEmailId ?? null; // Use null coalescing operator for safety
                $reportingID = $employee->RepEmployeeID ?? null; // Use null coalescing operator for safety
                $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();
                $leaveData = [
                    'EmployeeID' => $request->employee_id,
                    'Apply_Date' => now(),
                    'Leave_Type' => $leave_type,
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
                    'ApplyLeave_UpdatedYearId' => $year_id_current,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,
                    'back_date_flag' => $back_date_flag,
                    'Apply_SentToApp' => $employee->RepEmployeeID ?? '0',
                    'Apply_SentToRev' => $reportingDetails->ReviewerId ?? '0',
                    'Apply_SentToHOD' => $reportingDetails->HodId ?? '0',
                    'LeaveStatus' => '0',

                ];
                if (EmployeeApplyLeave::create($leaveData)) {
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

                    $ReportingName = $reportinggeneral->ReportingName;
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;

                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'ReportingManager' => $ReportingName,
                        'subject' => 'Leave Request',
                        'EmpName' => $Empname,
                        'leavetype' => $request->leaveType,
                        'FromDate' => $request->fromDate,
                        'ToDate' => $request->toDate,
                        'TotalDays' =>  $totaldays,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details

                    ];
                
                            Mail::to($ReportingEmailId)->send(new LeaveAuthMail($details));
                       
                }
            }
        }
        if (($leaveType == 'EL')) {
            $check = $this->checkCombinedLeaveConditionsEL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {

                // Check combined leave conditions
                $totaldays = $check[0];
                $back_date_flag = $check[1];
                if (\Carbon\Carbon::now()->month >= 4) {
                    // If the current month is April or later, the financial year starts from the current year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
                } else {
                    // If the current month is before April, the financial year started the previous year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
                }
                $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

                // Fetch the current financial year record
                $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
                    ->whereDate('ToDate', '=', $financialYearEnd)
                    ->first();
                $year_id_current = $currentYearRecord->YearId;
                $employee = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $request->employee_id)
                    ->first();
                $ReportingEmailId = $employee->ReportingEmailId ?? null; // Use null coalescing operator for safety
                $reportingID = $employee->RepEmployeeID ?? null; // Use null coalescing operator for safety

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
                    'ApplyLeave_UpdatedYearId' => $year_id_current,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,
                    'back_date_flag' => $back_date_flag,
                    'Apply_SentToApp' => $employee->RepEmployeeID ?? 0,
                    'Apply_SentToRev' => $reportingDetails->ReviewerId ?? 0,
                    'Apply_SentToHOD' => $reportingDetails->HodId ?? 0,
                    'LeaveStatus' => '0',

                ];

                if (EmployeeApplyLeave::create($leaveData)) {
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

                    $ReportingName = $reportinggeneral->ReportingName;
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;

                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'ReportingManager' => $ReportingName,
                        'subject' => 'Leave Request',
                        'EmpName' => $Empname,
                        'leavetype' => $request->leaveType,
                        'FromDate' => $request->fromDate,
                        'ToDate' => $request->toDate,
                        'TotalDays' =>  $totaldays,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details

                    ];
                   
                            Mail::to($ReportingEmailId)->send(new LeaveAuthMail($details));
                      
                }
            }
        }
        if (($leaveType == 'PL')) {
            // Check combined leave conditions

            $check = $this->checkCombinedLeaveConditionsPL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);
            if ($check) {
                // Check combined leave conditions
                $totaldays = $check[0];
                $back_date_flag = $check[1];
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
                $year_id_current = $currentYearRecord->YearId;
                $employee = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $request->employee_id)
                    ->first();
                $ReportingEmailId = $employee->ReportingEmailId ?? null; // Use null coalescing operator for safety
                $reportingID = $employee->RepEmployeeID ?? null; // Use null coalescing operator for safety
                $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

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
                    'ApplyLeave_UpdatedYearId' => $year_id_current,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,
                    'back_date_flag' => $back_date_flag,
                    'Apply_SentToApp' => $employee->RepEmployeeID ?? 0,
                    'Apply_SentToRev' => $reportingDetails->ReviewerId ?? 0,
                    'Apply_SentToHOD' => $reportingDetails->HodId ?? 0,
                    'LeaveStatus' => '0',
                ];

                if (EmployeeApplyLeave::create($leaveData)) {
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

                    $ReportingName = $reportinggeneral->ReportingName;
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;

                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'ReportingManager' => $ReportingName,
                        'subject' => 'Leave Request',
                        'EmpName' => $Empname,
                        'leavetype' => $request->leaveType,
                        'FromDate' => $request->fromDate,
                        'ToDate' => $request->toDate,
                        'TotalDays' =>  $totaldays,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details

                    ];
                    
                            Mail::to($ReportingEmailId)->send(new LeaveAuthMail($details));
                       
                }
            }
        }
        if (($leaveType == 'FL')) {
            // Check combined leave conditions
            $check = $this->checkCombinedLeaveConditionsFL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, $msg);

            if ($check) {

                // Check combined leave conditions
                $totaldays = $check[0];
                $back_date_flag = $check[1];

                if (\Carbon\Carbon::now()->month >= 4) {
                    // If the current month is April or later, the financial year starts from the current year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
                } else {
                    // If the current month is before April, the financial year started the previous year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
                }
                $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

                // Fetch the current financial year record
                $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
                    ->whereDate('ToDate', '=', $financialYearEnd)
                    ->first();
                $year_id_current = $currentYearRecord->YearId;
                $employee = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $request->employee_id)
                    ->first();
                $ReportingEmailId = $employee->ReportingEmailId ?? null; // Use null coalescing operator for safety
                $reportingID = $employee->RepEmployeeID ?? null; // Use null coalescing operator for safety

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
                    'ApplyLeave_UpdatedYearId' => $year_id_current,
                    'LeaveEmpCancelDate' => now(),
                    'LeaveEmpCancelReason' => '',
                    'PartialComment' => '',
                    'AdminComment' => '',
                    'half_define' => $request->option,
                    'Apply_SentToRev' => $reportingDetails->ReviewerId ?? 0,
                    'Apply_SentToApp' => $employee->RepEmployeeID ?? 0,
                    'Apply_SentToHOD' => $reportingDetails->HodId ?? 0,
                    'LeaveStatus' => '0',

                ];

                if (EmployeeApplyLeave::create($leaveData)) {
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

                    $ReportingName = $reportinggeneral->ReportingName;
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;

                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'ReportingManager' => $ReportingName,
                        'subject' => 'Leave Request',
                        'EmpName' => $Empname,
                        'leavetype' => $request->leaveType,
                        'FromDate' => $request->fromDate,
                        'ToDate' => $request->toDate,
                        'TotalDays' =>  $totaldays,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details

                    ];
                   
                            Mail::to($ReportingEmailId)->send(new LeaveAuthMail($details));
                      
                }
            }
        }
        return $msg; // Return the message, which will be empty if no validation errors


    }


    public function checkCombinedLeaveConditionsCL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {

        // Parse the application dates

        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // $currentDate = new \DateTime();
        $fromDate = Carbon::parse($fromDate);
        $currentDate = Carbon::now(); // This gets the current date and time

        // Extract only the date part
        $fromDateOnly = $fromDate->toDateString();
        $currentDateOnly = $currentDate->toDateString();
        $currentMonth = date('m', strtotime($fromDate));
        $currentYear = date('Y', strtotime($fromDate));

        // Check if the toDate is earlier than the fromDate
        if ($toDate < $fromDate) {
            $msg = "The end date cannot be earlier than the start date.";
            return false; // Return error if toDate is less than fromDate
        }

        if ($fromDateOnly < $currentDateOnly) {
            $back_date_flag = 1;
        } elseif ($fromDateOnly == $currentDateOnly) {
            $back_date_flag = 0;
        } else {
            $back_date_flag = 0;
        }

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
        $holidays = $this->getPublicHolidays();

        foreach ($holidays as $holiday) {
            // Extract the holiday date as a string (YYYY-MM-DD)
            $holidayDate = $holiday->AttDate;
            $fromDateHol = $request->fromDate;
            $toDateHol = $request->toDate;
            if ($fromDateHol === $toDateHol) {
                // Compare the 'fromDate' and 'toDate' with the holiday date (as strings)
                if (
                    $fromDateHol === $holidayDate ||  // From date falls on holiday
                    $toDateHol === $holidayDate    // To date falls on holiday|
                ) {
                    // Return error if the leave period overlaps with a holiday
                    $msg = "Your leave period is in a holiday (on " . $holidayDate . "). Please choose a different date.";
                    return false; // Return error message if overlap is found
                }
            }
        }

        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            // Check if any of the specified leave types have a value of 1
            if ($attendance['EL'] === 1 || $attendance['PL'] === 1 || $attendance['FL'] === 1) {
                $msg = "Leave cannot be applied as you have taken EL, PL, or FL on {$checkDate->format('d-m-Y')}.";
                return false; // Return error
            }
            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0) {
                // // Initialize variables
                // $totalDays = 0;  // This will store the total leave days
                // $previousDate = $fromDate->subDay()->format('Y-m-d');  // Start by checking the day before the fromdate
                // $leaveTypeFound = null;  // To store the leave type if found
                // $consecutiveLeaveDays = 0;  // To count consecutive days of the same leave type

                // // Fetch public holidays
                // $holidays = $this->getPublicHolidays();
                // $holidaysDates = array_map(function($holiday) {
                //     return $holiday->HolidayDate;  // Assuming the holiday date is in the 'HolidayDate' field
                // }, $holidays->toArray());

                // // Start checking previous dates until we find a leave_type or stop at a normal day
                // while (true) {
                //     $previousDateCarbon = Carbon::parse($previousDate);

                //     // Check if the previous date is Sunday or a Holiday
                //     if ($previousDateCarbon->isSunday() || in_array($previousDate, $holidaysDates)) {
                //         // Query the ApplyLeave model to check if there's any leave on this date
                //         $leaveData = EmployeeApplyLeave::whereDate('fromdate', '=', $previousDate)
                //                             ->orWhereDate('todate', '=', $previousDate)
                //                             ->whereNull('delete_at')
                //                             ->first();  // Get the first matching leave record
                //         // If we found a leave record on this day
                //         if ($leaveData) {
                //             // If this is the first leave record or it matches the previous leave_type
                //             if ($leaveTypeFound === null) {
                //                 // Store the leave_type and start counting consecutive leave days
                //                 $leaveTypeFound = $leaveData->leave_type;
                //                 $consecutiveLeaveDays = 1;
                //             } else {
                //                 // If the leave type is the same as the previous one, increment the count
                //                 if ($leaveData->leave_type == $leaveTypeFound) {
                //                     $consecutiveLeaveDays++;
                //                 } else {
                //                     // If the leave type changes, stop and calculate total days
                //                     break;
                //                 }
                //             }
                //         } else {
                //             // No leave record found on this date, stop checking
                //             break;
                //         }
                //     } else {
                //         // If it's neither a Sunday nor a Holiday, stop checking
                //         break;
                //     }

                //     // Go back one more day for the next iteration
                //     $previousDate = $previousDateCarbon->subDay()->format('Y-m-d');
                // }

                // // If leave type was found, add to the total days
                // if ($leaveTypeFound !== null) {
                //     $totalDays = $consecutiveLeaveDays;
                // }

                // (cl pl cl - cant take query)
                // $backDate = Carbon::parse($request->fromDate)->subDay()->format('Y-m-d');
                $forwardDate = Carbon::parse($request->fromDate)->addDay()->format('Y-m-d');

                // Query the ApplyLeave model to check if there is any leave record on the back date
                // $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                //     ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                //     ->where('LeaveStatus', '!=', '1')
                //     ->where('cancellation_status', '!=', '1')
                //     ->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the back date as fromdate
                //     ->orWhereDate('Apply_ToDate', '=', $forwardDate)  // Or if the todate is the back date
                //     ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate') // Select the specific fields
                //     ->get();  // Get all matching leave records
                $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                    ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                    ->where('LeaveStatus', '!=', '1')  // Exclude approved leave (LeaveStatus != 1)
                    ->where('cancellation_status', '!=', '1')  // Exclude canceled leave (cancellation_status != 1)
                    ->where(function ($query) use ($forwardDate) {  // Group the date conditions
                        $query->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the Apply_FromDate
                            ->orWhereDate('Apply_ToDate', '=', $forwardDate);  // Or match the Apply_ToDate
                    })
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate')  // Select the specific fields
                    ->get();  // Get all matching leave records
                // Check if leave records exist for the previous date and if any leave_type is 'PL'
                if ($leaveDataback->isNotEmpty()) {
                    foreach ($leaveDataback as $leave) {
                        if ($leave->leave_type == 'PL' || $leave->leave_type == 'EL' || $leave->leave_type == 'FL') {
                            // If the leave_type is 'PL', throw an error
                            // $msg="Leave type $leave->leave_type cannot be clubbed with CL.";
                            $msg = "Cannot Apply On this Date Range";

                            return false;
                        }
                    }
                }
                // 1-(8-cl, 7 sunday,6-holiday,5holiday, then have 4 cl and 3- nothing then only tak etotal days of 4 )
                // 2 case (8-cl, 7 sunday,6-holiday,5holiday, then have 4 cl and 3- cl then take total days of 4 and 3 if ahve same leave type)                    
                $holidaysDates = array_map(function ($holiday) {
                    return $holiday->AttDate;  // Assuming 'HolidayDate' field
                }, $holidays->toArray());

                // Initialize the current date (start from the previous date)
                $currentDate = Carbon::parse($request->fromDate)->subDay();  // Start by checking the date 1 day before fromDate
                $totalDays = 0;  // Variable to store the total days of leave
                $leaveTypeFound = null;  // Variable to store the leave type once found

                // Loop to check previous dates
                while (true) {
                    // Check if the current date is a Sunday or a Holiday
                    if ($currentDate->isSunday() || in_array($currentDate->format('Y-m-d'), $holidaysDates)) {
                        // If it's Sunday or a Holiday, move to the previous date
                        $currentDate = $currentDate->subDay();  // Move to the previous day
                    } else {
                        // If it's neither a Sunday nor a Holiday, stop checking
                        break;
                    }
                }

                // Once we find a normal day (not Sunday or Holiday), check if there is any leave data for that date
                //    1cl+sunday+2$holiday+cl+cl combination 
                $totalDays = 0;
                $leaveTypeFound = null;
                $leaveapplytotal = 0;  // Total leave days for the current leave


                $leaveData = EmployeeApplyLeave::whereDate('Apply_FromDate', '=', $currentDate)
                    ->where('EmployeeID', $request->employee_id)
                    ->orWhere(function ($query) use ($currentDate, $request) {
                        $query->whereDate('Apply_ToDate', '=', $currentDate)
                            ->where('EmployeeID', $request->employee_id);  // Ensure EmployeeID is checked here too
                    })
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->first();  // Get the first matching leave record

                // If leave data is found for the current date (9th Dec)
                if ($leaveData) {
                    // Check if the leave type is PL, EL, or FL, which can't be applied
                    if ($leaveData->Leave_Type == "PL" || $leaveData->Leave_Type == "EL" || $leaveData->Leave_Type == "FL") {
                        $msg = "Leave cannot be applied as {$leaveData->Leave_Type} has been applied. Please check your Leave Application.";
                        return false; // Return error
                    } else {
                        // If this is the first leave data or it matches the previous leave_type
                        if ($leaveTypeFound === null) {
                            // Store the leave_type and start counting total days
                            $leaveTypeFound = $leaveData->Leave_Type;
                            $leaveapplytotal = $leaveData->Apply_TotalDay;

                            $totalDays = $leaveapplytotal;  // Start with the current day's leave total (9th)
                        } else {
                            // If the leave type is the same as the previous one, add it to the total days
                            if ($leaveData->Leave_Type == $leaveTypeFound) {
                                $totalDays += $leaveData->Apply_TotalDay;  // Add the total days for the current leave record (9th)
                            } else {
                                // If the leave type is different, return an error message
                                $msg = "Leave type mismatch, total days: " . $totalDays;
                                return false;  // Return error
                            }
                        }
                    }

                    // Now, check the previous dates (backward loop) to see if there are consecutive leave days
                    $previousDate = $currentDate->copy();  // Make a copy to start checking the previous date
                    $previousDate = $previousDate->subDay();  // Move one day back

                    // Loop backward through previous dates until we find a matching leave type or a non-valid leave record
                    while (true) {
                        // Check if the previous date is a Sunday or a holiday
                        if ($previousDate->isSunday() || in_array($previousDate->toDateString(), $holidaysDates)) {
                            // Skip this date if it's a Sunday or holiday
                            $previousDate = $previousDate->subDay();  // Move to the previous day
                            continue;
                        }

                        // Query leave data for the valid previous date (normal day, not holiday or Sunday)
                        $previousLeaveData = EmployeeApplyLeave::where('EmployeeID', $request->employee_id)  // Filter by Employee ID first
                            ->whereNull('deleted_at')
                            ->where('LeaveStatus', '!=', '1')
                            ->where('cancellation_status', '!=', '1')
                            ->where(function ($query) use ($previousDate) {
                                $query->whereDate('Apply_FromDate', '=', $previousDate)  // Apply date condition on FromDate
                                    ->orWhereDate('Apply_ToDate', '=', $previousDate); // Apply date condition on ToDate
                            })
                            ->get();  // Get all matching leave records for the previous date
                        // If leave data exists for the previous date and the leave type matches, add to the total days
                        if ($previousLeaveData->isNotEmpty()) {
                            foreach ($previousLeaveData as $leave) {
                                if ($leave->Leave_Type == $leaveTypeFound) {
                                    $totalDays += $leave->Apply_TotalDay;  // Add the total leave days for the previous leave record
                                }
                            }
                        }

                        // Move to the next previous date (keep looping backward until you find non-consecutive dates)
                        $previousDate = $previousDate->subDay();

                        // Exit the loop if no more matching leave records are found or we’ve checked enough days
                        if (empty($previousLeaveData) || $previousDate->isBefore($fromDate)) {
                            break;
                        }
                    }

                    // If the total leave days exceed the limit (e.g., 2 days), return error
                    if ($totalDays >= 2) {
                        $msg = "Leave cannot be applied as the total leave days exceed the allowed limit of 2 days.";
                        return false;  // Return error response
                    }
                }


                $applyDate = Carbon::parse($fromDate); // Example: 2024-11-27

                // Calculate the exact previous day (i.e., the day before fromDate)
                $previousDay = $applyDate->subDay()->format('Y-m-d');  // For 2024-11-27, this becomes 2024-11-26
                $existingLeaveTypePre = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($previousDay) {
                        $query->whereDate('Apply_FromDate', '=', $previousDay)
                            ->orWhereDate('Apply_ToDate', '=', $previousDay);
                    })  // Group the conditions with OR for Apply_FromDate or Apply_ToDate
                    ->first();  // Get the first matching record (if any)

                if ($existingLeaveTypePre) {
                    if ($existingLeaveTypePre->Leave_Type == 'EL' || $existingLeaveTypePre->Leave_Type == 'PL' || $existingLeaveTypePre->Leave_Type == 'FL') {
                        $msg = "Leave cannot be applied as {$existingLeaveTypePre->Leave_Type} has been applied check Your Leave Application ";
                        return false; // Return error
                    }
                }


                $od_is_present = Attendance::where('EmployeeID', $request->employee_id)
                    ->where('AttValue', 'OD')
                    ->whereBetween('AttDate', [$fromDate, $toDate])
                    ->pluck('AttDate')
                    ->toArray(); // Convert to array

                // Check if there are any "OD" dates
                if (count($od_is_present) >= 1) {
                    // Convert the array of dates to a comma-separated string
                    $dates = implode(', ', $od_is_present);

                    // Create the message
                    $msg = "Leave cannot be applied as OD (Outdoor Duties) is already applied on the following dates: " . $dates;
                    return false;  // Return error response

                }

                // The current leave's fromDate (e.g., 2024-11-20)
                $currentFromDatecl = Carbon::parse($request->fromDate);

                // Get the previous 3 days from the current fromDate (e.g., 2024-11-19, 2024-11-18, 2024-11-17)
                $previousDates = [
                    $currentFromDatecl->copy()->subDays(1)->toDateString(), // 2024-11-19
                    $currentFromDatecl->copy()->subDays(2)->toDateString(), // 2024-11-18
                    $currentFromDatecl->copy()->subDays(3)->toDateString(), // 2024-11-17
                ];

                // Initialize variables for continuity check
                $lastLeaveDate = null;
                $isContinuous = true;
                $totalLeaveDays = 0;  // Variable to hold the sum of leave days

                // Check for continuity by looping through the previous dates
                foreach ($previousDates as $date) {
                    // Get the leave records for this date
                    // $leaveRecords = \DB::table('hrm_employee_applyleave')
                    //     ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    //     ->where('deleted_at', '=', NULL)
                    //     ->where('Leave_Type', 'CL')  // Only filter by 'CL' type (Casual Leave)
                    //     ->whereDate('Apply_FromDate', $date)  // Filter by Apply_FromDate for the current date
                    //     ->orWhereDate('Apply_ToDate', $date)  // Also check Apply_ToDate for the same date
                    //     ->first();  // Get the leave record (if any) for that date
                    $leaveRecords = \DB::table('hrm_employee_applyleave')
                        ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                        ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                        ->where('LeaveStatus', '!=', '1')
                        ->where('cancellation_status', '!=', '1')
                        ->where('Leave_Type', 'CL')  // Only filter by 'CL' type (Casual Leave)
                        ->where(function ($query) use ($date) {
                            // Use a closure to group the 'Apply_FromDate' and 'Apply_ToDate' conditions
                            $query->whereDate('Apply_FromDate', $date)  // Filter by Apply_FromDate for the current date
                                ->orWhereDate('Apply_ToDate', $date);  // Or check Apply_ToDate for the same date
                        })
                        ->first();  // Get the leave record (if any) for that date

                    // If there's no leave for the date, break the continuity and exit the loop
                    if (!$leaveRecords) {
                        $isContinuous = false;
                        break;
                    }

                    // If leave is found for this date, accumulate the leave days
                    $totalLeaveDays += $leaveRecords->Apply_TotalDay;

                    // Update the lastLeaveDate for continuity check
                    if ($lastLeaveDate) {
                        $diffInDays = $lastLeaveDate->diffInDays(Carbon::parse($date));
                        if ($diffInDays > 1) {
                            // Continuity is broken if the difference is more than 1 day
                            $isContinuous = false;
                            break;
                        }
                    }

                    // Update the lastLeaveDate to the current date
                    $lastLeaveDate = Carbon::parse($date);
                }


                // Adding 1 day for the current leave application
                $totalLeaveDays += 1;

                // If total leave days exceed 2, throw an error and skip processing
                if ($totalLeaveDays > 2) {
                    $msg = "Leave cannot be applied as the total leave days exceed the allowed limit of 2 days.";
                    return false;  // Return error response
                }


                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                    //->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                    ->where('Leave_Type', '=', $request->leaveType) // Half-day or full-day option from the request
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($fromDate, $toDate) {
                        // Check if there is any existing leave that overlaps with the provided date range
                        $query->whereBetween('Apply_FromDate', [$fromDate, $toDate])
                            ->orWhereBetween('Apply_ToDate', [$fromDate, $toDate])
                            ->orWhere(function ($subQuery) use ($fromDate, $toDate) {
                                // Check if the leave request is fully contained within an existing range
                                $subQuery->where('Apply_FromDate', '<=', $toDate)
                                    ->where('Apply_ToDate', '>=', $fromDate);
                            });
                    })
                    ->first();

                // Check if an overlapping leave was found
                if ($existingLeave) {
                    // Check the 'half_define' of the existing leave
                    if ($existingLeave->half_define == 'fullday' && $request->option != 'fullday') {
                        $msg = "Leave already exists for a full day. Cannot apply for half-day leave.";
                        return false; // Return error
                    } elseif (($existingLeave->half_define == '1st half' || $existingLeave->half_define == '2nd half') && $request->option != $existingLeave->half_define) {
                        $msg = "'Leave already exists for the ' . $existingLeave->half_define . '. Cannot apply for a different half-day option.";
                        return false; // Return error
                    } else {
                        $msg = "Leave already exists cannot apply for leave.";
                        return false; // Return error
                    }
                }

                // if ($existingLeave) {
                //     // If a leave record already exists, display the applied date range in the message
                //     $appliedFromDate = Carbon::parse($existingLeave->Apply_FromDate)->format('d-m-Y');
                //     $appliedToDate = Carbon::parse($existingLeave->Apply_ToDate)->format('d-m-Y');

                //     $msg = "Leave has already been applied for the date range: $appliedFromDate to $appliedToDate.";
                //     return false; // Return error
                // }

                $existingLeaves_other = \DB::table('hrm_employee_applyleave')
                    ->select('Leave_Type', 'Apply_FromDate', 'Apply_ToDate') // Select the leave types and date fields
                    ->where('EmployeeID', $request->employee_id)
                    ->where('Apply_FromDate', $fromDate)
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where('Leave_Type', '!=', $request->leaveType) // Exclude the current leave type
                    ->whereMonth('Apply_FromDate', $currentMonth)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->get();

                if ($existingLeaves_other->isNotEmpty()) {
                    // Collect the existing leave types and their corresponding dates
                    $leaveMessages = $existingLeaves_other->map(function ($leave) {
                        return $leave->Leave_Type . " from " . $leave->Apply_FromDate . " to " . $leave->Apply_ToDate;
                    });

                    $leaveTypes = $leaveMessages->implode('; '); // Join them as a string

                    $msg = "The following leave types are already applied for this date: " . $leaveTypes . ". Cannot apply for this same date.";
                    return false; // Return error
                }
                // Calculate total leave days excluding Sundays and holidays
                // $totalDays = 0;
                // $currentDate = clone $fromDate;

                // // Assuming you have an array of holidays
                // $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays
                // while ($currentDate <= $toDate) {
                //     // Check if the current date is a Sunday or a holiday
                //     if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('d-m-Y'), $holidays)) {
                //         $totalDays++; // Increment total days only if it's not a Sunday or holiday
                //     }
                //     // else{
                //     //     $msg = "Leave cannot be applied as Its Sunday or Holiday check for the Date";
                //     //     return false; // Return error
                //     // }
                //     $currentDate->modify('+1 day');
                // }
                // $holidays = $this->getPublicHolidays(); 

                // // Initialize total days counter
                // $totalDays = 0;

                // // Convert fromDate and toDate to Carbon instances (if they aren't already)
                // $fromDate = Carbon::parse($fromDate);
                // $toDate = Carbon::parse($toDate);

                // // Start with the fromDate
                // $currentDate = clone $fromDate;

                // // Loop through each date between fromDate and toDate
                // while ($currentDate <= $toDate) {
                //     // Check if the current date is not a Sunday (N = 7 means Sunday) and not a holiday
                //     if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays->HolidayDate)) {
                //         $totalDays++; // Increment total days if it's not a Sunday or holiday
                //     }

                //     // Move to the next day
                //     $currentDate->modify('+1 day');
                // }

                // If it's a half-day request, adjust the count
                // if ($isHalfDay) {
                //     $halfDayCount = $totalDays / 2; // Halve the total days for half-day requests
                // } else {
                //     $halfDayCount = $totalDays; // Use total days for full-day requests
                // }

                // Get the holidays as an array of dates (Y-m-d format)
                $holidays = $this->getPublicHolidays(); // Assuming this returns a collection

                // Convert the collection of holiday objects into an array of holiday dates (in Y-m-d format)
                $holidaysArray = $holidays->pluck('AttDate')->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d'); // Format each holiday date to Y-m-d
                })->toArray();

                // Initialize total days counter
                $totalDays = 0;

                // Convert fromDate and toDate to Carbon instances
                $fromDate = Carbon::parse($fromDate);
                $toDate = Carbon::parse($toDate);

                // Start with the fromDate
                $currentDate = clone $fromDate;

                // Loop through each date between fromDate and toDate
                while ($currentDate <= $toDate) {
                    // Format the current date to match the holiday date format (Y-m-d)
                    $currentFormattedDate = $currentDate->format('Y-m-d');

                    // Check if the current date is not a Sunday (N = 7 means Sunday) and not a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentFormattedDate, $holidaysArray)) {
                        $totalDays++; // Increment total days if it's not a Sunday or holiday
                    }

                    // Move to the next day
                    $currentDate->modify('+1 day');
                }

                if ($isHalfDay) {

                    if ($request->option === '1sthalf' || $request->option === '2ndhalf') {
                        $totalDays -= 0.5;
                        $halfDayCount = $totalDays;
                    }
                } else {
                    $halfDayCount = $totalDays; // Use total days for full-day requests
                }

                if ($halfDayCount < 0.5 || $halfDayCount > 2) {
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
                    ->where('deleted_at', '=', null)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($month, $year, $request) {
                        $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                            ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                    })
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('LeaveAppStatus', '=', '0')
                    ->where('LeaveStatus', '=', '3')
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
                            "Total leave days this month: $totalLeaveDays and your updated balance is: {$currentLeaveBalance}.Already applied leave this month";
                        return false; // Return error
                    }
                }


                $month = $fromDate->format(format: 'm'); // This will give you the month as a two-digit number (01 to 12)
                $year = $fromDate->format(format: 'Y'); // This will give you the month as a two-digit number (01 to 12)

                $currentMonthnow = date('m'); // Current month as two digits
                if ($fromDate->format('m') == $currentMonthnow || $toDate->format('m') == $currentMonthnow) {
                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employee_id)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->first(); // Use first() to get a single record
                    if ($leaveBalance->BalanceCL < $halfDayCount) {
                        $msg = "You Don't have sufficient leave balance";
                        return false; // Return error
                    }
                }

                return [$halfDayCount, $back_date_flag, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays

            }
        }
    }

    public function checkCombinedLeaveConditionsSL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // $currentDate = new \DateTime();
        $fromDate = Carbon::parse($fromDate);
        $currentDate = Carbon::now(); // This gets the current date and time

        // Extract only the date part
        $fromDateOnly = $fromDate->toDateString();
        $currentDateOnly = $currentDate->toDateString();

        $currentMonth = date('m', strtotime($fromDate));
        $currentYear = date('Y', strtotime($fromDate));

        // Check if the toDate is earlier than the fromDate
        if ($toDate < $fromDate) {
            $msg = "The end date cannot be earlier than the start date.";
            return false; // Return error if toDate is less than fromDate
        }

        if ($fromDateOnly < $currentDateOnly) {
            $back_date_flag = 1;
        } elseif ($fromDateOnly == $currentDateOnly) {
            $back_date_flag = 0;
        } else {
            $back_date_flag = 0;
        }


        if ($fromDate > $currentDate || $toDate > $currentDate) {
            $msg = "Leave cannot be applied for a future date.Can be on same day or 3 days earlier current date";
            return false; // Return error
        }
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior


        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior


        if ($fromDate->format('N') === '7' && $toDate->format('N') === '7') { // 7 means Sunday in PHP
            $msg = "The From and To Date cannot be a Sunday.You Can't apply to this";
            return false;
        }
        $holidays = $this->getPublicHolidays();

        foreach ($holidays as $holiday) {
            // Extract the holiday date as a string (YYYY-MM-DD)
            $holidayDate = $holiday->AttDate;
            $fromDateHol = $request->fromDate;
            $toDateHol = $request->toDate;

            // Compare the 'fromDate' and 'toDate' with the holiday date (as strings)
            if (
                $fromDateHol === $holidayDate ||  // From date falls on holiday
                $toDateHol === $holidayDate    // To date falls on holiday
            ) {
                // Return error if the leave period overlaps with a holiday
                $msg = "Your leave period is in a holiday (on " . $holidayDate . "). Please choose a different date.";
                return false; // Return error message if overlap is found
            }
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 || $attendance['CL'] === 0 || $attendance['CH'] === 0 || $attendance['SH'] === 0) {

                // Check if the leave already exists in the apply_leave table
                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                    //->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                    ->where('Leave_Type', '=', $request->leaveType) // Half-day or full-day option from the request
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($fromDate, $toDate) {
                        // Check if there is any existing leave that overlaps with the provided date range
                        $query->whereBetween('Apply_FromDate', [$fromDate, $toDate])
                            ->orWhereBetween('Apply_ToDate', [$fromDate, $toDate])
                            ->orWhere(function ($subQuery) use ($fromDate, $toDate) {
                                // Check if the leave request is fully contained within an existing range
                                $subQuery->where('Apply_FromDate', '<=', $toDate)
                                    ->where('Apply_ToDate', '>=', $fromDate);
                            });
                    })
                    ->first();
                // Check if an overlapping leave was found
                if ($existingLeave) {
                    // Check the 'half_define' of the existing leave
                    if ($existingLeave->half_define == 'fullday' && $request->option != 'fullday') {
                        $msg = "Leave already exists for a full day. Cannot apply for half-day leave.";
                        return false; // Return error
                    } elseif (($existingLeave->half_define == '1st half' || $existingLeave->half_define == '2nd half') && $request->option != $existingLeave->half_define) {
                        $msg = "'Leave already exists for the ' . $existingLeave->half_define . '. Cannot apply for a different half-day option.";
                        return false; // Return error
                    } else {
                        $msg = "Leave already exists cannot apply for leave.";
                        return false; // Return error
                    }
                }

                // if ($existingLeave) {
                //     // If a leave record already exists, display the applied date range in the message
                //     $appliedFromDate = Carbon::parse($existingLeave->Apply_FromDate)->format('d-m-Y');
                //     $appliedToDate = Carbon::parse($existingLeave->Apply_ToDate)->format('d-m-Y');

                //     $msg = "Leave has already been applied for the date range: $appliedFromDate to $appliedToDate.";
                //     return false; // Return error
                // }
                $od_is_present = Attendance::where('EmployeeID', $request->employee_id)
                    ->where('AttValue', 'OD')
                    ->whereBetween('AttDate', [$fromDate, $toDate])
                    ->pluck('AttDate')
                    ->toArray(); // Convert to array

                // Check if there are any "OD" dates
                if (count($od_is_present) >= 1) {
                    // Convert the array of dates to a comma-separated string
                    $dates = implode(', ', $od_is_present);

                    // Create the message
                    $msg = "Leave cannot be applied as OD (Outdoor Duties) is already applied on the following dates: " . $dates;
                    return false;  // Return error response

                }
                $existingLeaves_other = \DB::table('hrm_employee_applyleave')
                    ->select('Leave_Type', 'Apply_FromDate', 'Apply_ToDate') // Select the leave types and date fields
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where('Apply_FromDate', $fromDate)
                    ->where('Leave_Type', '!=', $request->leaveType) // Exclude the current leave type
                    ->whereMonth('Apply_FromDate', $currentMonth)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->get();

                if ($existingLeaves_other->isNotEmpty()) {
                    // Collect the existing leave types and their corresponding dates
                    $leaveMessages = $existingLeaves_other->map(function ($leave) {
                        return $leave->Leave_Type . " from " . $leave->Apply_FromDate . " to " . $leave->Apply_ToDate;
                    });

                    $leaveTypes = $leaveMessages->implode('; '); // Join them as a string

                    $msg = "The following leave types are already applied for this date: " . $leaveTypes . ". Cannot apply for this same date.";
                    return false; // Return error
                }
                // Calculate total leave days excluding Sundays and holidays
                // $totalDays = 0;
                // $currentDate = clone $fromDate;

                // // Assuming you have an array of holidays
                // $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays    
                // while ($currentDate <= $toDate) {
                //     // Check if the current date is a Sunday or a holiday
                //     if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('d-m-Y'), $holidays)) {
                //         $totalDays++; // Increment total days only if it's not a Sunday or holiday
                //     }
                //     // else{
                //     //     $msg = "Leave cannot be applied as Its Sunday or Holiday check for the Date";
                //     //     return false; // Return error
                //     // }
                //     $currentDate->modify('+1 day');
                // }
                //NEW CODE

                // Get the holidays as an array of dates (Y-m-d format)
                $holidays = $this->getPublicHolidays(); // Assuming this returns a collection

                // Convert the collection of holiday objects into an array of holiday dates (in Y-m-d format)
                $holidaysArray = $holidays->pluck('AttDate')->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d'); // Format each holiday date to Y-m-d
                })->toArray();

                // Initialize total days counter
                $totalDays = 0;

                // Convert fromDate and toDate to Carbon instances
                $fromDate = Carbon::parse($fromDate);
                $toDate = Carbon::parse($toDate);

                // Start with the fromDate
                $currentDate = clone $fromDate;

                // Loop through each date between fromDate and toDate
                while ($currentDate <= $toDate) {
                    // Format the current date to match the holiday date format (Y-m-d)
                    $currentFormattedDate = $currentDate->format('Y-m-d');

                    // Check if the current date is not a Sunday (N = 7 means Sunday) and not a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentFormattedDate, $holidaysArray)) {
                        $totalDays++; // Increment total days if it's not a Sunday or holiday
                    }

                    // Move to the next day
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

                if ($halfDayCount < 0.5 || $halfDayCount > 6) {
                    $msg = "Leave cannot be applied as Min- 0.5 day , Max-6 days";
                    // return false; // Return error
                }
                if ($halfDayCount > 2) {
                    $msg = "You have exceeded the SL balance of 10 as per policy. You can avail further SL only for critical sickness. Special approval is required for using further SL balance.";
                    // return false; // Return error as special approval is required
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', null)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($month, $year, $request) {
                        $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                            ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                    })
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('LeaveAppStatus', '=', '0')
                    ->where('LeaveStatus', '=', '3')
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
                $currentMonthnow = date('m'); // Current month as two digits
                if ($fromDate->format('m') == $currentMonthnow || $toDate->format('m') == $currentMonthnow) {
                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employee_id)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->first(); // Use first() to get a single record
                    if ($leaveBalance->BalanceCL < $halfDayCount) {
                        $msg = "You Don't have sufficient leave balance";
                        return false; // Return error
                    }
                }
                return [$halfDayCount, $back_date_flag, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays

            }
        }
    }
    public function checkCombinedLeaveConditionsEL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // $currentDate = new \DateTime();
        $fromDate = Carbon::parse($fromDate);
        $currentDate = Carbon::now(); // This gets the current date and time

        // Extract only the date part
        $fromDateOnly = $fromDate->toDateString();
        $currentDateOnly = $currentDate->toDateString();
        $currentMonth = date('m', strtotime($fromDate));
        $currentYear = date('Y', strtotime($fromDate));

        // Check if the toDate is earlier than the fromDate
        if ($toDate < $fromDate) {
            $msg = "The end date cannot be earlier than the start date.";
            return false; // Return error if toDate is less than fromDate
        }
        if ($fromDateOnly < $currentDateOnly) {
            $back_date_flag = 1;
        } elseif ($fromDateOnly == $currentDateOnly) {
            $back_date_flag = 0;
        } else {
            $back_date_flag = 0;
        }
        // Determine if the request is for half-day
        $isHalfDay = ($request->option === '1sthalf' || $request->option === '2ndhalf');
        $halfDayCount = $isHalfDay ? 0.5 : 1; // Initialize half day count based on request

        // Check for previous leave within 5 days prior to the requested leave
        $checkFromDate = clone $fromDate;
        $checkFromDate->modify('-5 days'); // Get the date 5 days prior

        $currentDate = clone $checkFromDate;

        $checkDate = clone $fromDate;
        $checkDate->modify('-1 day'); // Get the date one day prior
        $holidays = $this->getPublicHolidays();

        // foreach ($holidays as $holiday) {
        //     // Extract the holiday date as a string (YYYY-MM-DD)
        //     $holidayDate = $holiday->HolidayDate;
        //     $fromDateHol = $request->fromDate;
        //     $toDateHol = $request->toDate;

        //     // Compare the 'fromDate' and 'toDate' with the holiday date (as strings)
        //     if (
        //         $fromDateHol === $holidayDate ||  // From date falls on holiday
        //         $toDateHol === $holidayDate    // To date falls on holiday
        //     ) {
        //         // Return error if the leave period overlaps with a holiday
        //         $msg = "Your leave period is in a holiday (on " . $holidayDate . "). Please choose a different date.";
        //         return false; // Return error message if overlap is found
        //     }
        // }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL on {$checkDate->format('d-m-Y')}.";
                return false; // Return error
            }

            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 || $attendance['SH'] === 0) {
                $currentYear = date("Y");

                $totalPlApplications = EmployeeApplyLeave::where('Leave_Type', 'EL')
                    ->where('EmployeeID', $request->employee_id)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->where('LeaveStatus', '!=', 4)
                    ->count();


                // Ensure PL can only be applied a maximum of three times in a year
                if ($totalPlApplications >= 3) {
                    $msg = "Error: You can apply for EL only 3 times in a year.";
                    return false; // Indicates that the combined leave conditions are violated
                }
                $forwardDate = Carbon::parse($request->toDate)->addDay()->format('Y-m-d');
                // Query the ApplyLeave model to check if there is any leave record on the back date
                // $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                //     ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                //     ->where('LeaveStatus', '!=', '1')
                //     ->where('cancellation_status', '!=', '1')
                //     ->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the back date as fromdate
                //     ->orWhereDate('Apply_ToDate', '=', $forwardDate)  // Or if the todate is the back date
                //     ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate') // Select the specific fields
                //     ->get();  // Get all matching leave records
                $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                    ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->where('LeaveStatus', '!=', '1')  // Exclude approved leave (LeaveStatus != 1)
                    ->where('cancellation_status', '!=', '1')  // Exclude canceled leave (cancellation_status != 1)
                    ->where(function ($query) use ($forwardDate) {  // Group the date conditions
                        $query->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the Apply_FromDate
                            ->orWhereDate('Apply_ToDate', '=', $forwardDate);  // Or match the Apply_ToDate
                    })
                    ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate')  // Select the specific fields
                    ->get();  // Get all matching leave records




                // Check if leave records exist for the previous date and if any leave_type is 'PL'
                if ($leaveDataback->isNotEmpty()) {
                    foreach ($leaveDataback as $leave) {
                        if ($leave->leave_type == 'CL') {
                            // If the leave_type is 'PL', throw an error
                            $msg = "Leave type $leave->leave_type cannot be clubbed with EL.";
                            return false;
                        }
                    }
                }
                $holidaysDates = array_map(function ($holiday) {
                    return $holiday->AttDate;  // Assuming 'HolidayDate' field
                }, $holidays->toArray());

                // Initialize the current date (start from the previous date)
                $currentDate = Carbon::parse($request->fromDate)->subDay();  // Start by checking the date 1 day before fromDate
                $totalDays = 0;  // Variable to store the total days of leave
                $leaveTypeFound = null;  // Variable to store the leave type once found

                // Loop to check previous dates
                // while (true) {
                //     // Check if the current date is a Sunday or a Holiday
                //     if ($currentDate->isSunday() || in_array($currentDate->format('Y-m-d'), $holidaysDates)) {
                //         // If it's Sunday or a Holiday, move to the previous date
                //         $currentDate = $currentDate->subDay();  // Move to the previous day
                //     } else {
                //         // If it's neither a Sunday nor a Holiday, stop checking
                //         break;
                //     }
                // }

                // Once we find a normal day (not Sunday or Holiday), check if there is any leave data for that date
                //    1cl+sunday+2$holiday+cl+cl combination 
                $totalDays = 0;
                $leaveTypeFound = null;
                $leaveapplytotal = 0;  // Total leave days for the current leave


                $leaveData = EmployeeApplyLeave::whereDate('Apply_FromDate', '=', $currentDate)
                    ->where('EmployeeID', $request->employee_id)
                    ->orWhere(function ($query) use ($currentDate, $request) {
                        $query->whereDate('Apply_ToDate', '=', $currentDate)
                            ->where('EmployeeID', $request->employee_id);  // Ensure EmployeeID is checked here too
                    })
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->first();  // Get the first matching leave record

                if ($leaveData) {
                    // Check if the leave type is PL, EL, or FL, which can't be applied
                    if ($leaveData->Leave_Type == "CL") {
                        $msg = "Leave cannot be applied as {$leaveData->Leave_Type} has been applied. Please check your Leave Application.";
                        return false; // Return error
                    }
                }
                $od_is_present = Attendance::where('EmployeeID', $request->employee_id)
                    ->where('AttValue', 'OD')
                    ->whereBetween('AttDate', [$fromDate, $toDate])
                    ->pluck('AttDate')
                    ->toArray(); // Convert to array
                // Check if there are any "OD" dates
                if ($od_is_present) {

                    if (count($od_is_present) >= 1) {

                        // Convert the array of dates to a comma-separated string
                        $dates = implode(', ', $od_is_present);

                        // Create the message
                        $msg = "Leave cannot be applied as OD (Outdoor Duties) is already applied on the following dates: " . $dates;
                        return false;  // Return error response
                    }
                }

                $applyDate = Carbon::parse($fromDate); // Example: 2024-11-27

                // Calculate the exact previous day (i.e., the day before fromDate)
                $previousDay = $applyDate->subDay()->format('Y-m-d');  // For 2024-11-27, this becomes 2024-11-26
                $existingLeaveTypePre = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where('LeaveStatus', '!=', '4')
                    ->where(function ($query) use ($previousDay) {
                        $query->whereDate('Apply_FromDate', '=', $previousDay)
                            ->orWhereDate('Apply_ToDate', '=', $previousDay);
                    })  // Group the conditions with OR for Apply_FromDate or Apply_ToDate
                    ->first();  // Get the first matching record (if any)

                if ($existingLeaveTypePre) {
                    if ($existingLeaveTypePre->Leave_Type == 'CL' || $existingLeaveTypePre->Leave_Type == 'CH') {
                        $msg = "Leave cannot be applied as {$existingLeaveTypePre->Leave_Type} has been applied check Your Leave Application ";
                        return false; // Return error
                    }
                }

                // Check if the leave already exists in the apply_leave table
                // $existingLeave = \DB::table('hrm_employee_applyleave')
                //     ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                //     // ->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                //     ->where('deleted_at', '=', NULL)
                //     ->whereNotIn('LeaveStatus','!=', '3')
                //     ->where('cancellation_status', '!=', '1')
                //     ->where(function ($query) use ($fromDate, $toDate) {
                //         // Check if there is any existing leave that overlaps with the provided date range
                //         $query->whereBetween('Apply_FromDate', [$fromDate, $toDate])
                //             ->orWhereBetween('Apply_ToDate', [$fromDate, $toDate])
                //             ->orWhere(function ($subQuery) use ($fromDate, $toDate) {
                //             // Check if the leave request is fully contained within an existing range
                //             $subQuery->where('Apply_FromDate', '<=', $toDate)
                //                 ->where('Apply_ToDate', '>=', $fromDate);
                //         });
                //     })
                //     ->first();

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                    //->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                    ->where('Leave_Type', '=', $request->leaveType) // Half-day or full-day option from the request
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($fromDate, $toDate) {
                        // Check if there is any existing leave that overlaps with the provided date range
                        $query->whereBetween('Apply_FromDate', [$fromDate, $toDate])
                            ->orWhereBetween('Apply_ToDate', [$fromDate, $toDate])
                            ->orWhere(function ($subQuery) use ($fromDate, $toDate) {
                                // Check if the leave request is fully contained within an existing range
                                $subQuery->where('Apply_FromDate', '<=', $toDate)
                                    ->where('Apply_ToDate', '>=', $fromDate);
                            });
                    })
                    ->first();



                if ($existingLeave) {
                    // If a leave record already exists, display the applied date range in the message
                    $appliedFromDate = Carbon::parse($existingLeave->Apply_FromDate)->format('d-m-Y');
                    $appliedToDate = Carbon::parse($existingLeave->Apply_ToDate)->format('d-m-Y');

                    $msg = "Leave has already been applied for the date range: $appliedFromDate to $appliedToDate.";
                    return false; // Return error
                }

                $existingLeaves_other = \DB::table('hrm_employee_applyleave')
                    ->select('Leave_Type', 'Apply_FromDate', 'Apply_ToDate') // Select the leave types and date fields
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where('Apply_FromDate', $fromDate)
                    ->where('Leave_Type', '!=', $request->leaveType) // Exclude the current leave type
                    ->whereMonth('Apply_FromDate', $currentMonth)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->get();

                if ($existingLeaves_other->isNotEmpty()) {
                    // Collect the existing leave types and their corresponding dates
                    $leaveMessages = $existingLeaves_other->map(function ($leave) {
                        return $leave->Leave_Type . " from " . $leave->Apply_FromDate . " to " . $leave->Apply_ToDate;
                    });

                    $leaveTypes = $leaveMessages->implode('; '); // Join them as a string

                    $msg = "The following leave types are already applied for this date: " . $leaveTypes . ". Cannot apply for this same date.";
                    return false; // Return error
                }


                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;

                // Assuming you have an array of holidays
                $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 
                while ($currentDate <= $toDate) {
                    // Check if the current date is a Sunday or a holiday
                    // if ($currentDate->format('N') == '7' && in_array($currentDate->format('Y-m-d'), $holidays)) {
                    $totalDays++; // Increment total days only if it's not a Sunday or holiday
                    // }
                    // else{
                    //     $msg = "Leave cannot be applied as Its Sunday or Holiday check for the Date";
                    //     return false; // Return error
                    // }
                    $currentDate->modify('+1 day');
                }

                if ($totalDays < 3) {
                    $msg = "Leave cannot be applied as need Max-3days";
                    return false; // Return error
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', null)
                    ->where('LeaveStatus', '!=', '4')
                    ->where(function ($query) use ($month, $year, $request) {
                        $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                            ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                    })
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('LeaveAppStatus', '=', '0')
                    ->where('LeaveStatus', '=', '3')
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
                // dd('today');

                if ($totalDays < 3) {
                    $msg = "Leave cannot be applied as need Max-3days";
                    return false; // Return error
                }

                $currentMonthnow = date('m'); // Current month as two digits
                if ($fromDate->format('m') == $currentMonthnow || $toDate->format('m') == $currentMonthnow) {
                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employee_id)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->first(); // Use first() to get a single record
                    if ($leaveBalance->BalanceCL < $halfDayCount) {
                        $msg = "You Don't have sufficient leave balance";
                        return false; // Return error
                    }
                }
                return [$totalDays, $back_date_flag, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays

            }
        }
    }

    public function checkCombinedLeaveConditionsPL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // $currentDate = new \DateTime();
        $fromDate = Carbon::parse($fromDate);

        $currentDate = Carbon::now(); // This gets the current date and time

        $currentMonth = date('m', strtotime($fromDate));
        $currentYear = date('Y', strtotime($fromDate));


        // Extract only the date part
        $fromDateOnly = $fromDate->toDateString();
        $currentDateOnly = $currentDate->toDateString();
        // Check if the toDate is earlier than the fromDate
        if ($toDate < $fromDate) {
            $msg = "The end date cannot be earlier than the start date.";
            return false; // Return error if toDate is less than fromDate
        }

        if ($fromDateOnly < $currentDateOnly) {
            $back_date_flag = 1;
        } elseif ($fromDateOnly == $currentDateOnly) {
            $back_date_flag = 0;
        } else {
            $back_date_flag = 0;
        }
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
        $holidays = $this->getPublicHolidays();

        foreach ($holidays as $holiday) {
            // Extract the holiday date as a string (YYYY-MM-DD)
            $holidayDate = $holiday->AttDate;
            $fromDateHol = $request->fromDate;
            $toDateHol = $request->toDate;

            // Compare the 'fromDate' and 'toDate' with the holiday date (as strings)
            if (
                $fromDateHol === $holidayDate ||  // From date falls on holiday
                $toDateHol === $holidayDate    // To date falls on holiday
            ) {
                // Return error if the leave period overlaps with a holiday
                $msg = "Your leave period is in a holiday (on " . $holidayDate . "). Please choose a different date.";
                return false; // Return error message if overlap is found
            }
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL on {$checkDate->format('d-m-Y')}.";
                return false; // Return error
            }

            if ($attendance['EL'] === 0 || $attendance['PL'] === 0 || $attendance['FL'] === 0 || $attendance['SH'] === 0) {
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
                $forwardDate = Carbon::parse($request->toDate)->addDay()->format('Y-m-d');
                // Query the ApplyLeave model to check if there is any leave record on the back date
                // $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                //     ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                //     ->where('LeaveStatus', '!=', '1')
                //     ->where('cancellation_status', '!=', '1')
                //     ->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the back date as fromdate
                //     ->orWhereDate('Apply_ToDate', '=', $forwardDate)  // Or if the todate is the back date
                //     ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate') // Select the specific fields
                //     ->get();  // Get all matching leave records
                $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                    ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->where('LeaveStatus', '!=', '1')  // Exclude approved leave (LeaveStatus != 1)
                    ->where('cancellation_status', '!=', '1')  // Exclude canceled leave (cancellation_status != 1)
                    ->where(function ($query) use ($forwardDate) {  // Group the date conditions
                        $query->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the Apply_FromDate
                            ->orWhereDate('Apply_ToDate', '=', $forwardDate);  // Or match the Apply_ToDate
                    })
                    ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate')  // Select the specific fields
                    ->get();  // Get all matching leave records


                // Check if leave records exist for the previous date and if any leave_type is 'PL'
                if ($leaveDataback->isNotEmpty()) {
                    foreach ($leaveDataback as $leave) {
                        if ($leave->leave_type == 'CL') {
                            // If the leave_type is 'PL', throw an error
                            $msg = "Leave type $leave->leave_type cannot be clubbed with PL.";
                            return false;
                        }
                    }
                }
                $holidaysDates = array_map(function ($holiday) {
                    return $holiday->AttDate;  // Assuming 'HolidayDate' field
                }, $holidays->toArray());

                // Initialize the current date (start from the previous date)
                $currentDate = Carbon::parse($request->fromDate)->subDay();  // Start by checking the date 1 day before fromDate
                $totalDays = 0;  // Variable to store the total days of leave
                $leaveTypeFound = null;  // Variable to store the leave type once found

                // Loop to check previous dates
                while (true) {
                    // Check if the current date is a Sunday or a Holiday
                    if ($currentDate->isSunday() || in_array($currentDate->format('Y-m-d'), $holidaysDates)) {
                        // If it's Sunday or a Holiday, move to the previous date
                        $currentDate = $currentDate->subDay();  // Move to the previous day
                    } else {
                        // If it's neither a Sunday nor a Holiday, stop checking
                        break;
                    }
                }

                // Once we find a normal day (not Sunday or Holiday), check if there is any leave data for that date
                //    1cl+sunday+2$holiday+cl+cl combination 
                $totalDays = 0;
                $leaveTypeFound = null;
                $leaveapplytotal = 0;  // Total leave days for the current leave


                $leaveData = EmployeeApplyLeave::whereDate('Apply_FromDate', '=', $currentDate)
                    ->where('EmployeeID', $request->employee_id)
                    ->orWhere(function ($query) use ($currentDate, $request) {
                        $query->whereDate('Apply_ToDate', '=', $currentDate)
                            ->where('EmployeeID', $request->employee_id);  // Ensure EmployeeID is checked here too
                    })
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->first();  // Get the first matching leave record

                if ($leaveData) {
                    // Check if the leave type is PL, EL, or FL, which can't be applied
                    if ($leaveData->Leave_Type == "CL") {
                        $msg = "Leave cannot be applied as {$leaveData->Leave_Type} has been applied. Please check your Leave Application.";
                        return false; // Return error
                    }
                }


                $od_is_present = Attendance::where('EmployeeID', $request->employee_id)
                    ->where('AttValue', 'OD')
                    ->whereBetween('AttDate', [$fromDate, $toDate])
                    ->pluck('AttDate')
                    ->toArray(); // Convert to array

                // Check if there are any "OD" dates
                if (count($od_is_present) >= 1) {
                    // Convert the array of dates to a comma-separated string
                    $dates = implode(', ', $od_is_present);

                    // Create the message
                    $msg = "Leave cannot be applied as OD (Outdoor Duties) is already applied on the following dates: " . $dates;
                    return false;  // Return error response

                }

                $applyDate = Carbon::parse($fromDate); // Example: 2024-11-27

                // Calculate the exact previous day (i.e., the day before fromDate)
                $previousDay = $applyDate->subDay()->format('Y-m-d');  // For 2024-11-27, this becomes 2024-11-26
                $existingLeaveTypePre = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($previousDay) {
                        $query->whereDate('Apply_FromDate', '=', $previousDay)
                            ->orWhereDate('Apply_ToDate', '=', $previousDay);
                    })  // Group the conditions with OR for Apply_FromDate or Apply_ToDate
                    ->first();  // Get the first matching record (if any)

                if ($existingLeaveTypePre) {
                    if ($existingLeaveTypePre->Leave_Type == 'CL' || $existingLeaveTypePre->Leave_Type == 'CH') {
                        $msg = "Leave cannot be applied as {$existingLeaveTypePre->Leave_Type} has been applied check Your Leave Application ";
                        return false; // Return error
                    }
                }

                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                    //
                    ->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '3')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($fromDate, $toDate) {
                        // Check if there is any existing leave that overlaps or "touches" with the provided date range
                        $query->where(function ($subQuery) use ($fromDate, $toDate) {
                            // Check if the requested leave overlaps with an existing leave range
                            $subQuery->where('Apply_FromDate', '<=', $toDate)  // Existing leave starts before or on the new end date
                                ->where('Apply_ToDate', '>=', $fromDate); // Existing leave ends after or on the new start date
                        });
                    })
                    ->first();


                if ($existingLeave) {
                    // If a leave record already exists, display the applied date range in the message
                    $appliedFromDate = Carbon::parse($existingLeave->Apply_FromDate)->format('d-m-Y');
                    $appliedToDate = Carbon::parse($existingLeave->Apply_ToDate)->format('d-m-Y');

                    $msg = "Leave has already been applied for the date range: $appliedFromDate to $appliedToDate.";
                    return false; // Return error
                }

                $existingLeaves_other = \DB::table('hrm_employee_applyleave')
                    ->select('Leave_Type', 'Apply_FromDate', 'Apply_ToDate') // Select the leave types and date fields
                    ->where('EmployeeID', $request->employee_id)
                    ->where('Apply_FromDate', $fromDate)
                    ->where('deleted_at', '=', NULL)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where('Leave_Type', '!=', $request->leaveType) // Exclude the current leave type
                    ->whereMonth('Apply_FromDate', $currentMonth)
                    ->whereYear('Apply_FromDate', $currentYear)
                    ->get();

                if ($existingLeaves_other->isNotEmpty()) {
                    // Collect the existing leave types and their corresponding dates
                    $leaveMessages = $existingLeaves_other->map(function ($leave) {
                        return $leave->Leave_Type . " from " . $leave->Apply_FromDate . " to " . $leave->Apply_ToDate;
                    });

                    $leaveTypes = $leaveMessages->implode('; '); // Join them as a string

                    $msg = "The following leave types are already applied for this date: " . $leaveTypes . ". Cannot apply for this same date.";
                    return false; // Return error
                }


                // Calculate total leave days excluding Sundays and holidays
                // $totalDays = 0;
                // $currentDate = clone $fromDate;

                // // Assuming you have an array of holidays
                // $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 


                // while ($currentDate <= $toDate) {
                //     // Check if the current date is a Sunday or a holiday
                //     if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                //         $totalDays++; // Increment total days only if it's not a Sunday or holiday
                //     }
                //     // else{
                //     //     $msg = "Leave cannot be applied as Its Sunday or Holiday check for the Date";
                //     //     return false; // Return error
                //     // }
                //     $currentDate->modify('+1 day');
                // }
                $holidays = $this->getPublicHolidays(); // Assuming this returns a collection

                // Convert the collection of holiday objects into an array of holiday dates (in Y-m-d format)
                $holidaysArray = $holidays->pluck('AttDate')->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d'); // Format each holiday date to Y-m-d
                })->toArray();

                // Initialize total days counter
                $totalDays = 0;

                // Convert fromDate and toDate to Carbon instances
                $fromDate = Carbon::parse($fromDate);
                $toDate = Carbon::parse($toDate);

                // Start with the fromDate
                $currentDate = clone $fromDate;

                // Loop through each date between fromDate and toDate
                while ($currentDate <= $toDate) {
                    // Format the current date to match the holiday date format (Y-m-d)
                    $currentFormattedDate = $currentDate->format('Y-m-d');

                    // Check if the current date is not a Sunday (N = 7 means Sunday) and not a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentFormattedDate, $holidaysArray)) {
                        $totalDays++; // Increment total days if it's not a Sunday or holiday
                    }

                    // Move to the next day
                    $currentDate->modify('+1 day');
                }
                if ($totalDays < 1 || $totalDays > 6) {
                    $msg = "Leave cannot be applied as Min- 1 day , Max-6 days";
                    return false; // Return error
                }
                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', null)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($month, $year, $request) {
                        $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                            ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                    })
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('LeaveAppStatus', '=', '0')
                    ->where('LeaveStatus', '=', '3')
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
                if ($totalDays < 1 || $totalDays > 6) {
                    $msg = "Leave cannot be applied as Min- 1 day , Max-6 days";
                    return false; // Return error
                }

                $currentMonthnow = date('m'); // Current month as two digits
                if ($fromDate->format('m') == $currentMonthnow || $toDate->format('m') == $currentMonthnow) {
                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employee_id)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->first(); // Use first() to get a single record
                    if ($leaveBalance->BalanceCL < $halfDayCount) {
                        $msg = "You Don't have sufficient leave balance";
                        return false; // Return error
                    }
                }
                return [$totalDays, $back_date_flag, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays

            }
        }
    }
    public function checkCombinedLeaveConditionsFL($request, $leaveResults, $attendanceResults, $appFromDate, $appToDate, &$msg)
    {
        // Parse the application dates
        // Parse the application dates
        $fromDate = new \DateTime($appFromDate);
        $toDate = new \DateTime($appToDate);
        // $currentDate = new \DateTime();
        $fromDate = Carbon::parse($fromDate);
        $currentDate = Carbon::now(); // This gets the current date and time

        // Extract only the date part
        $fromDateOnly = $fromDate->toDateString();
        $currentDateOnly = $currentDate->toDateString();
        // Check if the toDate is earlier than the fromDate
        if ($toDate < $fromDate) {
            $msg = "The end date cannot be earlier than the start date.";
            return false; // Return error if toDate is less than fromDate
        }

        if ($fromDateOnly < $currentDateOnly) {
            $back_date_flag = 1;
        } elseif ($fromDateOnly == $currentDateOnly) {
            $back_date_flag = 0;
        } else {
            $back_date_flag = 0;
        }

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
        $currentYearoptional = Carbon::now()->year;  // Get the current year

        $optionalholidays = \DB::table('hrm_holiday_optional')
            ->where('Year', '=', $currentYearoptional)  // Check only this year's holidays
            ->whereBetween('HoOpDate', [$fromDate->toDateString(), $toDate])  // Check the date range
            ->get();

        $holidays = $this->getPublicHolidays();

        foreach ($holidays as $holiday) {
            // Extract the holiday date as a string (YYYY-MM-DD)
            // $holidayDate = $holiday->HolidayDate;
            $holidayDate = $holiday->AttDate;

            $fromDateHol = $request->fromDate;
            $toDateHol = $request->toDate;

            // Compare the 'fromDate' and 'toDate' with the holiday date (as strings)
            if (
                $fromDateHol === $holidayDate ||  // From date falls on holiday
                $toDateHol === $holidayDate    // To date falls on holiday
            ) {
                // Return error if the leave period overlaps with a holiday
                $msg = "Your leave period is in a holiday (on " . $holidayDate . "). Please choose a different date.";
                return false; // Return error message if overlap is found
            }
        }
        if (isset($attendanceResults[$checkDate->format('Y-m-d')])) {
            $attendance = $attendanceResults[$checkDate->format('Y-m-d')];

            if ($attendance['CL'] === 1 || $attendance['EL'] === 1 || $attendance['SL'] === 1 || $attendance['SH'] === 1 || $attendance['CH'] === 1) {
                $msg = "Leave cannot be applied as you have taken CL or EL or SL on {$checkDate->format('d-m-Y')}.";
                return false; // Return error
            }
            if ($attendance['PL'] === 0) {


                $applyDate = Carbon::parse($fromDate); // Example: 2024-11-27

                // Calculate the exact previous day (i.e., the day before fromDate)
                $previousDay = $applyDate->subDay()->format('Y-m-d');  // For 2024-11-27, this becomes 2024-11-26
                $existingLeaveTypePre = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($previousDay) {
                        $query->whereDate('Apply_FromDate', '=', $previousDay)
                            ->orWhereDate('Apply_ToDate', '=', $previousDay);
                    })  // Group the conditions with OR for Apply_FromDate or Apply_ToDate
                    ->first();  // Get the first matching record (if any)

                if ($existingLeaveTypePre) {
                    if ($existingLeaveTypePre->Leave_Type == 'CL' || $existingLeaveTypePre->Leave_Type == 'CH' || $existingLeaveTypePre->Leave_Type == 'EL' || $existingLeaveTypePre->Leave_Type == 'SH' || $existingLeaveTypePre->Leave_Type == 'SL') {
                        $msg = "Leave cannot be applied as {$existingLeaveTypePre->Leave_Type} has been applied check Your Leave Application ";
                        return false; // Return error
                    }
                }
                if ($existingLeaveTypePre == NULL || $existingLeaveTypePre == "") {
                    $forwardDate = Carbon::parse($request->fromDate)->addDay()->format('Y-m-d');
                    // Query the ApplyLeave model to check if there is any leave record on the back date
                    // $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                    //     ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                    //     ->where('LeaveStatus', '!=', '1')
                    //     ->where('cancellation_status', '!=', '1')
                    //     ->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the back date as fromdate
                    //     ->orWhereDate('Apply_ToDate', '=', $forwardDate)  // Or if the todate is the back date
                    //     ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate') // Select the specific fields
                    //     ->get();  // Get all matching leave records
                    $leaveDataback = EmployeeApplyLeave::where('leave_type', '!=', null) // Make sure leave_type is not null
                        ->whereNull('deleted_at')  // Make sure the record is not soft deleted
                        ->where('EmployeeID', $request->employee_id)  // Filter by Employee ID
                        ->where('LeaveStatus', '!=', '1')  // Exclude approved leave (LeaveStatus != 1)
                        ->where('cancellation_status', '!=', '1')  // Exclude canceled leave (cancellation_status != 1)
                        ->where(function ($query) use ($forwardDate) {  // Group the date conditions
                            $query->whereDate('Apply_FromDate', '=', $forwardDate)  // Match the Apply_FromDate
                                ->orWhereDate('Apply_ToDate', '=', $forwardDate);  // Or match the Apply_ToDate
                        })
                        ->select('leave_type', 'Apply_FromDate', 'Apply_ToDate')  // Select the specific fields
                        ->get();  // Get all matching leave records


                    // Check if leave records exist for the previous date and if any leave_type is 'PL'
                    if ($leaveDataback->isNotEmpty()) {
                        foreach ($leaveDataback as $leave) {
                            if ($leave->leave_type == 'PL') {
                                continue;  // Early return to skip the rest of the process if 'PL' leave is found
                                // Skip the rest of the code and continue with the next iteration (or next logic)
                            }
                            if ($leave->leave_type != 'PL') {
                                $currentYearoptional = Carbon::now()->year;  // Get the current year

                                $optionalholidays = \DB::table('hrm_holiday_optional')
                                    ->where('Year', '=', $currentYearoptional)  // Check only this year's holidays
                                    ->whereBetween('HoOpDate', [$fromDate->toDateString(), $toDate])  // Check the date range
                                    ->get();

                                // If there are any holidays in the range, return an error
                                if ($optionalholidays->isEmpty()) {
                                    $msg = "There is no festival  within the specified date range. Can take Leave in continous to PL";
                                    return false; // Return false if any holiday is found in the range
                                }
                            }
                        }
                    }
                }
                $holidaysDates = array_map(function ($holiday) {
                    return $holiday->AttDate;  // Assuming 'HolidayDate' field
                }, $holidays->toArray());

                // Initialize the current date (start from the previous date)
                $currentDate = Carbon::parse($request->fromDate)->subDay();  // Start by checking the date 1 day before fromDate
                $totalDays = 0;  // Variable to store the total days of leave
                $leaveTypeFound = null;  // Variable to store the leave type once found

                // Loop to check previous dates
                while (true) {
                    // Check if the current date is a Sunday or a Holiday
                    if ($currentDate->isSunday() || in_array($currentDate->format('Y-m-d'), $holidaysDates)) {
                        // If it's Sunday or a Holiday, move to the previous date
                        $currentDate = $currentDate->subDay();  // Move to the previous day
                    } else {
                        // If it's neither a Sunday nor a Holiday, stop checking
                        break;
                    }
                }

                // Once we find a normal day (not Sunday or Holiday), check if there is any leave data for that date
                //    1cl+sunday+2$holiday+cl+cl combination 
                $totalDays = 0;
                $leaveTypeFound = null;
                $leaveapplytotal = 0;  // Total leave days for the current leave


                $leaveData = EmployeeApplyLeave::whereDate('Apply_FromDate', '=', $currentDate)
                    ->where('EmployeeID', $request->employee_id)
                    ->orWhere(function ($query) use ($currentDate, $request) {
                        $query->whereDate('Apply_ToDate', '=', $currentDate)
                            ->where('EmployeeID', $request->employee_id);  // Ensure EmployeeID is checked here too
                    })
                    ->whereNull('deleted_at')
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->first();  // Get the first matching leave record

                if ($leaveData) {
                    // Check if the leave type is PL, EL, or FL, which can't be applied
                    if ($leaveData->Leave_Type == "CL") {
                        $msg = "Leave cannot be applied as {$leaveData->Leave_Type} has been applied. Please check your Leave Application.";
                        return false; // Return error
                    }
                }
                $od_is_present = Attendance::where('EmployeeID', $request->employee_id)
                    ->where('AttValue', 'OD')
                    ->whereBetween('AttDate', [$fromDate, $toDate])
                    ->pluck('AttDate')
                    ->toArray(); // Convert to array

                // Check if there are any "OD" dates
                if (count($od_is_present) >= 1) {
                    // Convert the array of dates to a comma-separated string
                    $dates = implode(', ', $od_is_present);

                    // Create the message
                    $msg = "Leave cannot be applied as OD (Outdoor Duties) is already applied on the following dates: " . $dates;
                    return false;  // Return error response

                }
                // Check if the leave already exists in the apply_leave table
                $existingLeave = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id) // Employee ID from the request
                    ->where('half_define', '=', $request->option) // Half-day or full-day option from the request
                    ->where(function ($query) use ($fromDate, $toDate) {
                        // Check if there is any existing leave that overlaps with the provided date range
                        $query->whereBetween('Apply_FromDate', [$fromDate, $toDate])
                            ->orWhereBetween('Apply_ToDate', [$fromDate, $toDate])
                            ->orWhere(function ($subQuery) use ($fromDate, $toDate) {
                                // Check if the leave request is fully contained within an existing range
                                $subQuery->where('Apply_FromDate', '<=', $toDate)
                                    ->where('Apply_ToDate', '>=', $fromDate);
                            });
                    })
                    ->first();

                if ($existingLeave) {
                    // If a leave record already exists, display the applied date range in the message
                    $appliedFromDate = Carbon::parse($existingLeave->Apply_FromDate)->format('d-m-Y');
                    $appliedToDate = Carbon::parse($existingLeave->Apply_ToDate)->format('d-m-Y');

                    $msg = "Leave $existingLeave->Leave_Type has already been applied for the date range: $appliedFromDate to $appliedToDate.";
                    return false; // Return error
                }

                // Calculate total leave days excluding Sundays and holidays
                $totalDays = 0;
                $currentDate = clone $fromDate;

                // Assuming you have an array of holidays
                // $holidays = $this->getPublicHolidays(); // Implement this function to fetch holidays 
                // while ($currentDate <= $toDate) {
                //     // Check if the current date is a Sunday or a holiday
                //     if ($currentDate->format('N') !== '7' && !in_array($currentDate->format('Y-m-d'), $holidays)) {
                //         $totalDays++; // Increment total days only if it's not a Sunday or holiday
                //     }
                //     $currentDate->modify('+1 day');
                // }
                // if ($totalDays > 1) {
                //     $msg = "You can apply festival leave for 1 days maximum";
                //     return false; // Return error
                // }
                $holidays = $this->getPublicHolidays(); // Assuming this returns a collection

                // Convert the collection of holiday objects into an array of holiday dates (in Y-m-d format)
                $holidaysArray = $holidays->pluck('AttDate')->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d'); // Format each holiday date to Y-m-d
                })->toArray();

                // Initialize total days counter
                $totalDays = 0;

                // Convert fromDate and toDate to Carbon instances
                $fromDate = Carbon::parse($fromDate);
                $toDate = Carbon::parse($toDate);

                // Start with the fromDate
                $currentDate = clone $fromDate;

                // Loop through each date between fromDate and toDate
                while ($currentDate <= $toDate) {
                    // Format the current date to match the holiday date format (Y-m-d)
                    $currentFormattedDate = $currentDate->format('Y-m-d');

                    // Check if the current date is not a Sunday (N = 7 means Sunday) and not a holiday
                    if ($currentDate->format('N') !== '7' && !in_array($currentFormattedDate, $holidaysArray)) {
                        $totalDays++; // Increment total days if it's not a Sunday or holiday
                    }

                    // Move to the next day
                    $currentDate->modify('+1 day');
                }
                if ($totalDays > 1) {
                    $msg = "You can apply festival leave for 1 days maximum";
                    return false; // Return error
                }

                $month = $fromDate->format('m');
                $year = $fromDate->format('Y');

                // Fetch existing leave records for the same month
                $existingLeaveRecords = \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $request->employee_id)
                    ->where('deleted_at', '=', null)
                    ->where('LeaveStatus', '!=', '1')
                    ->where('cancellation_status', '!=', '1')
                    ->where(function ($query) use ($month, $year, $request) {
                        $query->whereRaw('MONTH(Apply_FromDate) = ? AND YEAR(Apply_FromDate) = ?', [$month, $year])
                            ->orWhereRaw('MONTH(Apply_ToDate) = ? AND YEAR(Apply_ToDate) = ?', [$month, $year]);
                    })
                    ->where('Leave_Type', '=', $request->leaveType)
                    ->where('LeaveAppStatus', '=', '0')
                    ->where('LeaveStatus', '=', '3')
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


                $currentMonthnow = date('m'); // Current month as two digits
                if ($fromDate->format('m') == $currentMonthnow || $toDate->format('m') == $currentMonthnow) {
                    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employee_id)
                        ->where('Month', $month)
                        ->where('Year', $year)
                        ->first(); // Use first() to get a single record
                    if ($leaveBalance->BalanceCL < $halfDayCount) {
                        $msg = "You Don't have sufficient leave balance";
                        return false; // Return error
                    }
                }
                return [$totalDays, true]; // Indicates that the combined leave conditions are satisfied, passing validLeaveDays

            }
        }
    }

    public function getPublicHolidays()
    {
        $holidays = [];
        $year = date("Y");
        $m = now()->month;

        $employee_id = Auth::user()->EmployeeID;

        //     $holidays = \DB::table('hrm_holiday as h')
        // ->join('hrm_employee_contact as ec', 'ec.EmployeeID', '=', \DB::raw($employee_id))
        // ->join('hrm_state as s', 'ec.CurrAdd_State', '=', 's.StateId')
        // ->where('h.Year', $year)
        // ->where('h.status', 'A')
        // // Get the first and last date of the current month
        // ->whereBetween('h.HolidayDate', [
        //     now()->startOfMonth()->format('Y-m-d'), // Start of the current month
        //     now()->endOfMonth()->format('Y-m-d')   // End of the current month
        // ])
        // // Add another condition for the previous month
        // ->orWhereBetween('h.HolidayDate', [
        //     now()->subMonth()->startOfMonth()->format('Y-m-d'), // Start of the previous month
        //     now()->subMonth()->endOfMonth()->format('Y-m-d')    // End of the previous month
        // ])
        // ->where(function ($query) {
        //     $query->where(function ($subQuery) {
        //         $subQuery->whereIn('s.StateName', ['Andhra Pradesh', 'Kerala', 'Tamil Nadu', 'Karnataka', 'Telangana'])
        //             ->where('h.State_2', 1);
        //     })
        //         ->orWhere(function ($subQuery) {
        //             $subQuery->where('h.State_1', 1);
        //         })
        //         ->orWhere(function ($subQuery) {
        //             $subQuery->where('h.State_3', 1)
        //                 ->orWhere('h.State_4', 1);
        //         });
        // })
        // ->orderBy('h.HolidayDate', 'ASC')
        // ->get();
        // dd('vbn');

        //        // Query the attendance table to fetch public holidays
        $holidays = \DB::table('hrm_employee_attendance') // Assuming your attendance table is named 'attendance'
            ->where('EmployeeID', $employee_id) // Filter by employee ID
            ->where('AttValue', 'HO') // Filter by attendance value 'HO' (public holiday)
            ->whereYear('AttDate', $year) // Filter by current year
            ->whereMonth('AttDate', $m) // Filter by current month
            ->get(); // Get the results as a collection
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
        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $employeeId)->pluck('EmployeeID');
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $currentYear = now()->year;  // Get the current year
        $currentMonth = now()->month;  // Get the current month

        // Step 2: Fetch leave requests for those employees
        // $leaveRequests = EmployeeApplyLeave::whereIn('EmployeeID', $employeeIds)  // Filter by multiple Employee IDs
        //     ->whereIn('LeaveStatus', ['0', '4'])  // Where LeaveStatus is either '0' or '3'
        //     // ->where('LeaveStatus','=','0')  // Where LeaveStatus is either '0' or '3'
        //     ->where('Apply_SentToApp', $employeeId)  // Ensure Apply_SentToRev matches the employee ID
        //     ->whereBetween('Apply_Date', [$startOfMonth, $endOfMonth])  // Filter by Apply_Date within the given range
        //     ->get();  // Get the results
        $leaveRequests = \DB::table('hrm_employee_applyleave')
            ->join('hrm_employee', 'hrm_employee_applyleave.EmployeeID', '=', 'hrm_employee.EmployeeID')  // Join the Employee table
            ->whereIn('hrm_employee_applyleave.EmployeeID', $employeeIds)  // Filter by EmployeeID
            ->where('hrm_employee_applyleave.deleted_at', '=', NULL)
            ->whereYear('hrm_employee_applyleave.Apply_Date', $currentYear)  // Filter by current year
            // ->whereMonth('hrm_employee_applyleave.Apply_Date', $currentMonth)  // Filter by current month
            ->where('hrm_employee_applyleave.LeaveStatus', '=', '0')
            ->select(
                'hrm_employee_applyleave.Leave_Type',
                'hrm_employee_applyleave.Apply_FromDate',
                'hrm_employee_applyleave.Apply_ToDate',
                'hrm_employee_applyleave.LeaveStatus',
                'hrm_employee_applyleave.Apply_DuringAddress',
                'hrm_employee_applyleave.Apply_Reason',
                'hrm_employee_applyleave.Apply_TotalDay',
                'hrm_employee_applyleave.half_define',
                'hrm_employee_applyleave.Apply_ContactNo',
                'hrm_employee.Fname',
                'hrm_employee.Sname',
                'hrm_employee.Lname',
                'hrm_employee.EmpCode',
                'hrm_employee.EmployeeID'
            )  // Select the relevant fields
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
        return response()->json(['message' => 'No leave requests found for this employee.'], 200);
    }
    // public function fetchLeaveRequestsAll(Request $request)
    // {
    //     $employeeId = $request->employee_id;

    //     // Step 2: Fetch leave requests for those employees
    //     // $leaveRequests = EmployeeApplyLeave::where('EmployeeID', $employeeId)
    //     //     ->get();

    //     $currentYearMonth = Carbon::now()->format('Y-m');  // e.g., "2024-12"

    //     // Fetch leave requests where Apply_Date matches the current year and month
    //     $leaveRequests = EmployeeApplyLeave::where('EmployeeID', $employeeId)
    //         ->where('Apply_Date', 'LIKE', $currentYearMonth . '%')  // Match "YYYY-MM%" pattern in Apply_Date
    //         ->get();


    //         $AttRequests = \DB::table('hrm_employee_attendance_req')
    //         ->where('EmployeeID', $employeeId)
    //         ->where('ReqDate', 'LIKE', $currentYearMonth . '%') // Match "YYYY-MM%" pattern in Apply_Date
    //         ->get();

    //     // Initialize an array to hold combined data
    //     $combinedData = [];

    //     // Step 3: Fetch employee details and combine with leave requests
    //     if ($leaveRequests->isNotEmpty()) {
    //         foreach ($leaveRequests as $leaveRequest) {
    //             $employeeDetails = Employee::find($leaveRequest->EmployeeID);

    //             $combinedData[] = [
    //                 'leaveRequest' => $leaveRequest,
    //                 'employeeDetails' => $employeeDetails,
    //             ];
    //         }

    //         // Return the combined data as JSON
    //         return response()->json($combinedData);
    //     }

    //     // If no leave requests are found, return a message
    //     return response()->json(['message' => 'No leave requests found for this employee.'], 200);
    // }

    public function fetchLeaveRequestsAll(Request $request)
    {
        // Step 1: Get the EmployeeID from the request
        $employeeId = $request->employee_id;

        // Step 2: Get the current year and month for the query
        $currentYearMonth = Carbon::now()->format('Y-m');  // e.g., "2024-12"

        // Step 3: Fetch leave requests for the given employee within the current year and month
        $leaveRequests = EmployeeApplyLeave::where('EmployeeID', $employeeId)
            ->where('Apply_Date', 'LIKE', $currentYearMonth . '%')  // Match "YYYY-MM%" pattern in Apply_Date
            ->whereIn('LeaveStatus', [0, 4, 3])  // Correctly use whereIn for LeaveStatus
            ->get();

        $employeeQueryData = \DB::table('hrm_employee_queryemp')
            ->where('EmployeeID', $employeeId)
            ->where('QueryDT', 'LIKE', $currentYearMonth . '%')  // Match "YYYY-MM%" pattern in Apply_Date
            ->get(); // Assuming you want the first result for a single employee


        // Step 4: Fetch attendance requests for the given employee within the current year and month
        $attRequests = \DB::table('hrm_employee_attendance_req')
            ->where('EmployeeID', $employeeId)
            ->where('ReqDate', 'LIKE', $currentYearMonth . '%') // Match "YYYY-MM%" pattern in ReqDate
            ->get();

        // Step 5: Initialize an array to hold the combined data
        $combinedData = [];

        // Step 6: Combine the leave requests and attendance requests
        foreach ($leaveRequests as $leaveRequest) {
            // Fetch employee details (you can optimize this by joining with the employee table directly if needed)
            $employeeDetails = Employee::find($leaveRequest->EmployeeID);

            // Find related attendance requests for the same employee and month
            $relatedAttRequests = $attRequests->filter(function ($attRequest) use ($leaveRequest) {
                return Carbon::parse($attRequest->ReqDate)->format('Y-m') == Carbon::parse($leaveRequest->Apply_Date)->format('Y-m');
            });

            // Add leave request, employee details, and related attendance requests to the combined array
            $combinedData[] = [
                'leaveRequest' => $leaveRequest,
                'employeeDetails' => $employeeDetails,
                'employeeQueryData' => $employeeQueryData, // Add the data from hrm_employee_queryemp
                'attendanceRequests' => $relatedAttRequests,
            ];
        }

        // Step 7: Return the combined data as a JSON response
        if (count($combinedData) > 0) {
            return response()->json($combinedData);
        }

        // Step 8: If no leave or attendance requests are found, return a message
        return response()->json(['message' => 'No data'], 200);
    }

    public function leaveauthorize(Request $request)
    {
        // Get the 'from_date' and 'to_date' from the request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Format the dates using Carbon (assuming they are in dd/mm/yyyy format)
        $formattedFromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
        $formattedToDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');

        // Extract validated data
        $employeeId = $request->employeeId;
        $leaveType = $request->leavetype;
        $vStatus = $request->Status;

        $yearId = date('Y');
        if ($vStatus == "approved") {
            $vStatus = '2';
        }
        if ($vStatus == "rejected") {
            $vStatus = '3';
        }

        // Check if remarks are required (i.e., when vStatus is 0)
        if ($vStatus == '3' && (!$request->has('remarks') || empty($request->remarks))) {
            return response()->json(['success' => false, 'message' => 'Remark is required.']);
        }
        if ($vStatus == '2' && (!$request->has('remarks') || empty($request->remarks))) {
            return response()->json(['success' => false, 'message' => 'Remark is required.']);
        }
        $total_days = $request->total_days;
        // Only process if the status is approved
        if ($vStatus == 2) {

            // Parse from and to dates
            $fromDate = Carbon::parse($formattedFromDate);
            $toDate = Carbon::parse($formattedToDate);

            $Fmonth = $fromDate->month;
            $Fday = $fromDate->day;
            $Tmonth = $toDate->month;

            $Tday = $toDate->day;
            $Fyear = $fromDate->year;
            $Tyear = $toDate->year;
            $leaveRequest = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $employeeId)
                ->where('deleted_at', '=', NULL)
                // ->where('LeaveStatus', '!=', '1')
                // ->where('cancellation_status', '!=', '1')
                // ->where('LeaveStatus', '!=', '4')
                ->where('Apply_FromDate', '=', $formattedFromDate)
                ->where('Apply_ToDate', '=', $formattedToDate)
                ->first();


            if ($leaveRequest->LeaveStatus == '4') {
                $reverse = $this->reverseLeaveAcceptance($leaveRequest->ApplyLeaveId, $vStatus);
                if ($reverse) {
                    return response()->json(['success' => true, 'message' => 'Leave cancellation successfully.']);
                }
                return;
            } else {
                if ($Fmonth == $Tmonth) {
                    // Single month leave
                    for ($i = $Fday; $i <= $Tday; $i++) {
                        $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days, $leaveRequest->ApplyLeaveId, $vStatus);
                        if ($check) {
                            return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                        } else if ($check == NULL || $check == "null" || $check == '') {
                            return response()->json(['success' => true, 'message' => 'Leave authorized already made.']);
                        }
                    }
                } elseif ($Fmonth != $Tmonth && $Fyear == $Tyear) {
                    // Different months, same year
                    $FlastDayOfFromMonth = $fromDate->endOfMonth()->day;

                    // First month
                    for ($i = $Fday; $i <= $FlastDayOfFromMonth; $i++) {
                        $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days, $leaveRequest->ApplyLeaveId, $vStatus);
                        if ($check) {
                            return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                        } else if ($check == NULL || $check == "null" || $check == '') {
                            return response()->json(['success' => true, 'message' => 'Leave authorized already made.']);
                        }
                    }
                    // Second month
                    for ($i = 1; $i <= $Tday; $i++) {
                        $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days, $leaveRequest->ApplyLeaveId, $vStatus);
                        if ($check) {
                            return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                        } else if ($check == NULL || $check == "null" || $check == '') {
                            return response()->json(['success' => true, 'message' => 'Leave authorized already made.']);
                        }
                    }
                } elseif ($Fmonth != $Tmonth && $Fyear != $Tyear) {
                    // Different months and years
                    $FlastDayOfFromMonth = $fromDate->endOfMonth()->day;

                    // Process leave for the first month
                    for ($i = $Fday; $i <= $FlastDayOfFromMonth; $i++) {
                        $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days, $leaveRequest->ApplyLeaveId, $vStatus);
                        if ($check) {
                            return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                        } else if ($check == NULL || $check == "null" || $check == '') {
                            return response()->json(['success' => true, 'message' => 'Leave authorized already made.']);
                        }
                    }

                    // Process leave for the second month
                    for ($i = 1; $i <= $Tday; $i++) {
                        $check = $this->processLeave($request, $employeeId, $leaveType, $fromDate, $toDate, $yearId, $total_days, $leaveRequest->ApplyLeaveId, $vStatus);
                        if ($check) {
                            return response()->json(['success' => true, 'message' => 'Leave authorized successfully.']);
                        } else if ($check == NULL || $check == "null" || $check == '') {
                            return response()->json(['success' => true, 'message' => 'Leave authorized already made.']);
                        }
                    }
                }
            }
            // If no leave was authorized successfully
            return response()->json(['success' => false, 'message' => 'No leave was authorized.']);
        }
        if ($vStatus == 3) {
            // $fd = $request->from_date;
            // $td = $request->to_date;
            // // Check if the leave request exists with the same EmployeeID, Apply_FromDate, and Apply_ToDate
            // $leaveRequest = \DB::table('hrm_employee_applyleave')
            //     ->where('EmployeeID', $employeeId)
            //     ->where('deleted_at', '=', NULL)
            //     ->where('LeaveStatus', '!=', '1')
            //     ->where('cancellation_status', '!=', '1')
            //     ->where('Apply_FromDate', $fd)
            //     ->where('Apply_ToDate', $td)
            //     ->first();
            $leaveRequest = \DB::table('hrm_employee_applyleave')
                ->where('EmployeeID', $employeeId)
                ->where('deleted_at', '=', NULL)
                // ->where('LeaveStatus', '!=', '1')
                // ->where('cancellation_status', '!=', '1')
                // ->where('LeaveStatus', '!=', '4')
                ->where('Apply_FromDate', '=', $formattedFromDate)
                ->where('Apply_ToDate', '=', $formattedToDate)
                ->first();
            if ($leaveRequest) {
                // Check if the LeaveStatus and LeaveAppStatus are already '0'
                if ($leaveRequest->LeaveStatus == '3' && $leaveRequest->LeaveAppStatus == '3') {
                    \DB::table('hrm_employee_applyleave')
                        ->where('EmployeeID', $leaveRequest->EmployeeID)
                        ->where('Apply_FromDate', $leaveRequest->Apply_FromDate)
                        ->where('Apply_ToDate', $leaveRequest->Apply_ToDate)
                        ->where('half_define', $request->leavetype_day)
                        ->where('ApplyLeaveId', $leaveRequest->ApplyLeaveId)
                        ->update([
                            'LeaveRevReason' => $request->remarks,
                            'LeaveStatus' => $vStatus,
                            'LeaveAppStatus' => $vStatus,

                        ]);

                    return response()->json(['success' => true, 'message' => 'Leave rejected.']);
                } else if ($leaveRequest->LeaveStatus == '4') {

                    $reverse = $this->reverseLeaveAcceptance($leaveRequest->ApplyLeaveId, $vStatus);
                } else {

                    // Update the leave status to rejected
                    $reject = \DB::table('hrm_employee_applyleave')
                        ->where('EmployeeID', $employeeId)
                        ->where('Apply_FromDate', $formattedFromDate)
                        ->where('Apply_ToDate', $formattedToDate)
                        ->where('ApplyLeaveId', $leaveRequest->ApplyLeaveId)
                        ->update([
                            'LeaveStatus' => '3',
                            'LeaveAppStatus' => '3',
                            'LeaveRevReason' => $request->remarks,
                            'LeaveRevStatus' => $vStatus,
                        ]);

                    if ($reject) {
                        return response()->json(['success' => true, 'message' => 'Leave Rejected successfully.']);
                    }
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Leave request not found.']);
            }
        }
    }

    
    protected function processLeave($request, $employeeId, $leaveType, Carbon $fromDate, Carbon $toDate, $yearId, $total_days, $leaveRequestid,$vStatus)
    {


        // Get the appropriate attendance table
        $attTable = $this->getAttendanceTable($fromDate->year, $fromDate->month);
        // Check if it's a Sunday
        if($vStatus == '2'){
            $s = "Approved";
        }if($vStatus == '3'){
            $s = "Rejected";
        }
        // Check for holiday
        $isHoliday = Attendance::where('EmployeeID', $employeeId)
        ->where('AttDate', $fromDate->format('Y-m-d'))
        ->where('AttValue', 'HO')
        ->exists();
        if ($fromDate->dayOfWeek != Carbon::SUNDAY || $toDate->dayOfWeek != Carbon::SUNDAY ) { // Non-Sunday

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


                $currentYear = date('Y');
                $nextYear = $currentYear + 1;

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
                $year_id = $currentYearRecord->YearId;
                // Ensure $fromDate and $toDate are Carbon instances
                $fromDateloop = Carbon::parse($fromDate)->startOfDay(); // Normalize to start of the day
                $toDateloop = Carbon::parse($toDate)->startOfDay();     // Normalize to start of the day

                // Loop through each day between $fromDate and $toDate, inclusive
                for ($date = $fromDateloop->copy(); $date->lte($toDateloop); $date->addDay()) {
                // Insert new attendance record
                // for ($date = $fromDate->copy(); $date->lte($toDate); $date->addDay()) {
                    if ($date->isSunday() && $leaveType !== 'EL') {
                        continue;
                       
                    }
                    // Check if the attendance already exists with AttValue 'HO' for this date
                        $existingAttendance = Attendance::where('EmployeeID', $employeeId)
                        ->where('AttDate', $date->format('Y-m-d'))
                        ->where('AttValue', 'HO')
                        ->exists();

                    if ($existingAttendance) {
                        continue; // Skip if record with 'HO' exists
                    }
                    if($leaveType !== 'EL'){
                        $checksunday = 'N';
                    }
                    if($leaveType == 'EL'){
                        $checksunday = 'Y';
                    }

                    // Create an attendance record for each date in the range
                    $created_attendance = Attendance::create([
                        'EmployeeID' => $employeeId,
                        'AttValue' => $leaveType,
                        'AttDate' => $date->format('Y-m-d'), // Use the current date in the loop
                        'Year' => $date->year, // Year of the current date
                        'YearId' => $year_id, // Your year_id (assuming this is set earlier in your code)
                        'CheckSunday'=>$checksunday,
                        'II' => '00:00:00',
                        'OO' => '00:00:00',
                        'Inn' => '00:00:00',
                        'Outt' => '00:00:00',
                    ]);
                }
               

                if ($created_attendance && !$isHoliday) {
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
                    if ($update === 0) { //already present and no changes
                        $update = 1;
                    }

                    if ($update) {
                        // Define start and end dates
                        $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                        $endDate = $fromDate->endOfMonth()->format('Y-m-d');

                        $attTable = 'hrm_employee_attendance'; // Define attendance table name
                       
                        // Count various attendance values
                        // $attendanceCounts = [
                        //     'CL' => \DB::table($attTable)->where('AttValue', 'CL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'CH' => \DB::table($attTable)->where('AttValue', 'CH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'SL' => \DB::table($attTable)->where('AttValue', 'SL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'SH' => \DB::table($attTable)->where('AttValue', 'SH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'PL' => \DB::table($attTable)->where('AttValue', 'PL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'EL' => \DB::table($attTable)->where('AttValue', 'EL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'FL' => \DB::table($attTable)->where('AttValue', 'FL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'TL' => \DB::table($attTable)->where('AttValue', 'TL')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'Hf' => \DB::table($attTable)->where('AttValue', 'CH')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'Present' => \DB::table($attTable)->where('AttValue', 'P')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'Absent' => \DB::table($attTable)->where('AttValue', 'A')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'OnDuties' => \DB::table($attTable)->where('AttValue', 'OD')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'Holiday' => \DB::table($attTable)->where('AttValue', 'HO')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        //     'ELSun' => \DB::table($attTable)->where('CheckSunday', 'Y')->where('EmployeeID', $employeeId)->whereBetween('AttDate', [$startDate, $endDate])->count(),
                        // ];
                        $attendanceCounts = [
                            'CL' => \DB::table($attTable)
                                ->where('AttValue', 'CL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'CH' => \DB::table($attTable)
                                ->where('AttValue', 'CH')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'SL' => \DB::table($attTable)
                                ->where('AttValue', 'SL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'SH' => \DB::table($attTable)
                                ->where('AttValue', 'SH')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'PL' => \DB::table($attTable)
                                ->where('AttValue', 'PL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'EL' => \DB::table($attTable)
                                ->where('AttValue', 'EL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->count(),
                       
                            'FL' => \DB::table($attTable)
                                ->where('AttValue', 'FL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'TL' => \DB::table($attTable)
                                ->where('AttValue', 'TL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'Hf' => \DB::table($attTable)
                                ->where('AttValue', 'CH')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'Present' => \DB::table($attTable)
                                ->where('AttValue', 'P')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'Absent' => \DB::table($attTable)
                                ->where('AttValue', 'A')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'OnDuties' => \DB::table($attTable)
                                ->where('AttValue', 'OD')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'Holiday' => \DB::table($attTable)
                                ->where('AttValue', 'HO')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
                       
                            'ELSun' => \DB::table($attTable)
                                ->where('CheckSunday', 'Y')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                                ->count(),
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

                            if ($leaveBalance->isEmpty()) {
                                $fd = $request->from_date;
                                $td = $request->to_date;
                                // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                                $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                                $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                                //dd($leaveRequestid);
                                \DB::table('hrm_employee_applyleave')
                                    ->where('EmployeeID', $employeeId)
                                    // ->where('half_define', $request->leavetype_day)
                                    // ->where('Apply_FromDate', $fromDate)
                                    ->where('ApplyLeaveId', $leaveRequestid)
                                    // ->where('Apply_ToDate', $toDate)
                                    ->update([
                                        'LeaveStatus' => '2',
                                        'LeaveAppStatus' => '2',
                                        'LeaveRevReason' => $request->remarks,
                                    ]);
       
                                                                                 // Other existing logic to retrieve employee data and prepare for insertion
                                                                                 $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                                 $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                                     
                                                                                 $ReportingName = $reportinggeneral->ReportingName;
                                                                                 $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                                     
                                                                                 $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                                     
                                                                                 $details = [
                                                                                     'ReportingManager' => $ReportingName,
                                                                                     'subject'=>'Leave Approval Status',
                                                                                     'EmpName'=> $Empname,
                                                                                     'TotalDays'=>  $total_days,
                                                                                     'leavetype'=> $leaveType,
                                                                                     'FromDate'=> $fromDate,
                                                                                     'ToDate'=> $toDate,
                                                                                     'Status'=>$s,
                                                                                     'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                                     ];
                                                                                    
                                                                                            Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                                     
                                                                                     return 1; // Successfully updated record
                            }
                            else {
                                // Calculate totals based on whether it's the first month or not
                                if ($month != 1) {
                                    $totalBalCL = $leaveBalance[0]->BalanceCL ?? 0;
                                    $totalBalSL = $leaveBalance[0]->BalanceSL ?? 0;
                                    $totalBalPL = $leaveBalance[0]->BalancePL ?? 0;
                                    $totalBalEL = $leaveBalance[0]->BalanceEL ?? 0;
                                    $totalBalFL = $leaveBalance[0]->BalanceOL ?? 0;
                           
                                    $total_days = $request->total_days;
                           
                                    // Update the total balance based on the leave type
                                    switch ($request->leavetype) {
                                        case "CL":
                                            $totalBalCL = max(0, $totalBalCL - $total_days);
                                            break;
                                        case "CH":
                                                $totalBalCL = max(0, $totalBalCL - $total_days);
                                                break;
                                        case "SL":
                                            $totalBalSL = max(0, $totalBalSL - $total_days);
                                            break;
                                        case "SH":
                                                $totalBalSL = max(0, $totalBalSL - $total_days);
                                                break;
                                        case "PL":
                                            $totalBalPL = max(0, $totalBalPL - $total_days);
                                            break;
                                        case "EL":
                                            $totalBalEL = max(0, $totalBalEL - $total_days);
                                            break;
                                        case "FL":
                                            $totalBalFL = max(0, $totalBalFL - $total_days);
                                            break;
                                    }
                                } else {
                                    $totalBalCL = ($leaveBalance[0]->TotCL ?? 0) - ($totalCL ?? 0);
                                    $totalBalSL = ($leaveBalance[0]->TotSL ?? 0) - ($totalSL ?? 0);
                                    $totalBalPL = ($leaveBalance[0]->TotPL ?? 0) - ($attendanceCounts['PL'] ?? 0);
                                    $totalBalEL = ($leaveBalance[0]->TotEL ?? 0) - ($attendanceCounts['EL'] ?? 0);
                                    $totalBalFL = ($leaveBalance[0]->TotOL ?? 0) - ($attendanceCounts['FL'] ?? 0);
                                }
                           
                                // Update the leave balance
                                \DB::table($leaveTable)
                                    ->where('EmployeeID', $employeeId)
                                    ->where('Month', $month)
                                    ->where('Year', $year)
                                    ->update([
                                        'AvailedCL' => $totalCL ?? 0,
                                        'AvailedSL' => $totalSL ?? 0,
                                        'AvailedPL' => $attendanceCounts['PL'] ?? 0,
                                        'AvailedEL' => $attendanceCounts['EL'] ?? 0,
                                        'AvailedOL' => $attendanceCounts['FL'] ?? 0,
                                        'AvailedTL' => $attendanceCounts['TL'] ?? 0,
                                        'BalanceCL' => $totalBalCL,
                                        'BalanceSL' => $totalBalSL,
                                        'BalancePL' => $totalBalPL,
                                        'BalanceEL' => $totalBalEL,
                                        'BalanceOL' => $totalBalFL,
                                    ]);
                           
                                // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                                $fd = $request->from_date;
                                $td = $request->to_date;
                                $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                                $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                           
                                // Update the leave application
                                \DB::table('hrm_employee_applyleave')
                                    ->where('EmployeeID', $employeeId)
                                    ->where('ApplyLeaveId', $leaveRequestid)
                                    ->update([
                                        'LeaveStatus' => '2',
                                        'LeaveAppStatus' => '2',
                                        'LeaveRevReason' => $request->remarks,
                                    ]);
                           
                                return 1; // Successfully updated record
                            }
                    }
                }
            }
            elseif ($attendanceRecord && !$isHoliday) {

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
                if ($update === 0) { //already present and no changes
                    $update = 1;
                }

                if ($update) {

                    // Define start and end dates
                    // $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                    // $endDate = $toDate->endOfMonth()->format('Y-m-d');
                    $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                    $endDate = $fromDate->endOfMonth()->format('Y-m-d');
                    $attTable = 'hrm_employee_attendance'; // Define attendance table name

                    // Count various attendance values
                    $attendanceCounts = [
                        'CL' => \DB::table($attTable)
                            ->where('AttValue', 'CL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'CH' => \DB::table($attTable)
                            ->where('AttValue', 'CH')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'SL' => \DB::table($attTable)
                            ->where('AttValue', 'SL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'SH' => \DB::table($attTable)
                            ->where('AttValue', 'SH')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'PL' => \DB::table($attTable)
                            ->where('AttValue', 'PL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'EL' => \DB::table($attTable)
                            ->where('AttValue', 'EL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->count(),
                   
                        'FL' => \DB::table($attTable)
                            ->where('AttValue', 'FL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'TL' => \DB::table($attTable)
                            ->where('AttValue', 'TL')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'Hf' => \DB::table($attTable)
                            ->where('AttValue', 'CH')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'Present' => \DB::table($attTable)
                            ->where('AttValue', 'P')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'Absent' => \DB::table($attTable)
                            ->where('AttValue', 'A')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'OnDuties' => \DB::table($attTable)
                            ->where('AttValue', 'OD')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'Holiday' => \DB::table($attTable)
                            ->where('AttValue', 'HO')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
                   
                        'ELSun' => \DB::table($attTable)
                            ->where('CheckSunday', 'Y')
                            ->where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$startDate, $endDate])
                            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                            ->count(),
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

                    if ($leaveBalance->isEmpty()) {
                            $fd = $request->from_date;
                        $td = $request->to_date;
                        // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                        $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                        $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                        //dd($leaveRequestid);
                        \DB::table('hrm_employee_applyleave')
                            ->where('EmployeeID', $employeeId)
                            // ->where('half_define', $request->leavetype_day)
                            // ->where('Apply_FromDate', $fromDate)
                            ->where('ApplyLeaveId', $leaveRequestid)
                            // ->where('Apply_ToDate', $toDate)
                            ->update([
                                'LeaveStatus' => '2',
                                'LeaveAppStatus' => '2',
                                'LeaveRevReason' => $request->remarks,
                            ]);

                                                                         // Other existing logic to retrieve employee data and prepare for insertion
                                                                         $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                         $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                             
                                                                         $ReportingName = $reportinggeneral->ReportingName;
                                                                         $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                             
                                                                         $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                             
                                                                         $details = [
                                                                             'ReportingManager' => $ReportingName,
                                                                             'subject'=>'Leave Approval Status',
                                                                             'EmpName'=> $Empname,
                                                                             'TotalDays'=>  $total_days,
                                                                             'leavetype'=> $leaveType,
                                                                             'FromDate'=> $fromDate,
                                                                             'ToDate'=> $toDate,
                                                                             'Status'=>$s,
                                                                             'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                             ];
                                                                           
                                                                                    Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                            
                                                                             return 1; // Successfully updated record
                    }
                    else {

                        // Calculate totals based on whether it's the first month or not
                        if ($month != 1) {
                            $totalBalCL = $leaveBalance[0]->BalanceCL;
                            $totalBalSL = $leaveBalance[0]->BalanceSL;
                            $totalBalPL = $leaveBalance[0]->BalancePL;
                            $totalBalEL = $leaveBalance[0]->BalanceEL;
                            $totalBalFL = $leaveBalance[0]->BalanceOL;

                            $total_days = $request->total_days;

                            // Update the total balance based on the leave type
                            if ($request->leavetype == "CL") {
                                $totalBalCL = max(0, $totalBalCL - $total_days); // Deduct totalCL from OpeningCL, ensure non-negative
                            } elseif ($request->leavetype == "SL") {
                                $totalBalSL = max(0, $totalBalSL - $total_days); // Deduct totalSL from OpeningSL, ensure non-negative
                            } elseif ($request->leavetype == "PL") {
                                $totalBalPL = max(0, $totalBalPL - $total_days); // Deduct PL from OpeningPL, ensure non-negative
                            } elseif ($request->leavetype == "EL") {
                                $totalBalEL = max(0, $totalBalEL - $total_days); // Deduct EL from OpeningEL, ensure non-negative
                            } elseif ($request->leavetype == "FL") {
                                $totalBalFL = max(0, $totalBalFL - $total_days); // Deduct FL from OpeningOL, ensure non-negative
                            }

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
                        // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                        $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                        $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                        //dd($leaveRequestid);
                        \DB::table('hrm_employee_applyleave')
                            ->where('EmployeeID', $employeeId)
                            // ->where('half_define', $request->leavetype_day)
                            // ->where('Apply_FromDate', $fromDate)
                            ->where('ApplyLeaveId', $leaveRequestid)
                            // ->where('Apply_ToDate', $toDate)
                            ->update([
                                'LeaveStatus' => '2',
                                'LeaveAppStatus' => '2',
                                'LeaveRevReason' => $request->remarks,
                            ]);

                                                                         // Other existing logic to retrieve employee data and prepare for insertion
                                                                         $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                         $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                             
                                                                         $ReportingName = $reportinggeneral->ReportingName;
                                                                         $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                             
                                                                         $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                             
                                                                         $details = [
                                                                             'ReportingManager' => $ReportingName,
                                                                             'subject'=>'Leave Approval Status',
                                                                             'EmpName'=> $Empname,
                                                                             'TotalDays'=>  $total_days,
                                                                             'leavetype'=> $leaveType,
                                                                             'FromDate'=> $fromDate,
                                                                             'ToDate'=> $toDate,
                                                                             'Status'=>$s,
                                                                            'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                             ];
                                                                            
                                                                                    Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                              
                                                                             return 1; // Successfully updated record
                       

                    }
                }
            }

        }
        //For EL

        elseif ($leaveType == 'EL' && ($fromDate->dayOfWeek == Carbon::SUNDAY || $toDate->dayOfWeek == Carbon::SUNDAY) || $isHoliday) { // Handle Sundays with leave type 'EL'
            $attendanceRecord = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->first();

            $isHoliday = Attendance::where('EmployeeID', $employeeId)
                ->where('AttDate', $fromDate->format('Y-m-d'))
                ->where('AttValue', 'HO')
                ->exists();

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
                $year_id = $currentYearRecord->YearId;
                if (!$attendanceRecord) {


                    $currentYear = date('Y');
                    $nextYear = $currentYear + 1;
   
   
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
                    $year_id = $currentYearRecord->YearId;
                    // Ensure $fromDate and $toDate are Carbon instances
                    $fromDateloop = Carbon::parse($fromDate)->startOfDay(); // Normalize to start of the day
                    $toDateloop = Carbon::parse($toDate)->startOfDay();     // Normalize to start of the day
   
                    // Loop through each day between $fromDate and $toDate, inclusive
                    for ($date = $fromDateloop->copy(); $date->lte($toDateloop); $date->addDay()) {
                   
                           
                        // Create an attendance record for each date in the range
                        $created_attendance = Attendance::create([
                            'EmployeeID' => $employeeId,
                            'AttValue' => $leaveType,
                            'CheckSunday'=>'Y',
                            'AttDate' => $date->format('Y-m-d'), // Use the current date in the loop
                            'Year' => $date->year, // Year of the current date
                            'YearId' => $year_id, // Your year_id (assuming this is set earlier in your code)
                            'II' => '00:00:00',
                            'OO' => '00:00:00',
                            'Inn' => '00:00:00',
                            'Outt' => '00:00:00',
                        ]);
                    }
                   
   
                    if ($created_attendance) {

                        // Update existing attendance record
                        $update = \DB::table($attTable)
                            ->where('EmployeeID', $employeeId)
                            ->where('AttDate', $fromDate->format('Y-m-d'))
                            ->update(['AttValue' => $leaveType]);
                        if ($update === 0) { //already present and no changes
                            $update = 1;
                        }
   
                        if ($update) {
                            // Define start and end dates
                            $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                            $endDate = $fromDate->endOfMonth()->format('Y-m-d');
   
                            $attTable = 'hrm_employee_attendance'; // Define attendance table name
                           
                           
                            $attendanceCounts = [
                               
                                'EL' => \DB::table($attTable)
                                    ->where('AttValue', 'EL')
                                    ->where('EmployeeID', $employeeId)
                                    ->whereBetween('AttDate', [$startDate, $endDate])
                                    ->count(),
                           
                            ];
                     
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
   
                                if ($leaveBalance->isEmpty()) {
                                    $fd = $request->from_date;
                                    $td = $request->to_date;
                                    // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                                    $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                                    $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                                    //dd($leaveRequestid);
                                    \DB::table('hrm_employee_applyleave')
                                        ->where('EmployeeID', $employeeId)
                                        // ->where('half_define', $request->leavetype_day)
                                        // ->where('Apply_FromDate', $fromDate)
                                        ->where('ApplyLeaveId', $leaveRequestid)
                                        // ->where('Apply_ToDate', $toDate)
                                        ->update([
                                            'LeaveStatus' => '2',
                                            'LeaveAppStatus' => '2',
                                            'LeaveRevReason' => $request->remarks,
                                        ]);
           
                                                                                     // Other existing logic to retrieve employee data and prepare for insertion
                                                                                     $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                                     $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                                         
                                                                                     $ReportingName = $reportinggeneral->ReportingName;
                                                                                     $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                                         
                                                                                     $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                                         
                                                                                     $details = [
                                                                                         'ReportingManager' => $ReportingName,
                                                                                         'subject'=>'Leave Approval Status',
                                                                                         'EmpName'=> $Empname,
                                                                                         'TotalDays'=>  $total_days,
                                                                                         'leavetype'=> $leaveType,
                                                                                         'FromDate'=> $fromDate,
                                                                                         'ToDate'=> $toDate,
                                                                                         'Status'=>$s,
                                                                                         'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                                         ];
                                                                                        
                                                                                                Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                                         
                                                                                         return 1; // Successfully updated record
                                }
                                else {
                                    // Calculate totals based on whether it's the first month or not
                                    if ($month != 1) {
                                     
                                        $totalBalEL = $leaveBalance[0]->BalanceEL ?? 0;
                                       
                               
                                        $total_days = $request->total_days;
                               
                                        // Update the total balance based on the leave type
                                        switch ($request->leavetype) {
                                     
                                            case "EL":
                                                $totalBalEL = max(0, $totalBalEL - $total_days);
                                                break;
                                           
                                        }
                                    } else {
                                       
                                        $totalBalEL = ($leaveBalance[0]->TotEL ?? 0) - ($attendanceCounts['EL'] ?? 0);
                                       
                                    }
                               
                                    // Update the leave balance
                                    \DB::table($leaveTable)
                                        ->where('EmployeeID', $employeeId)
                                        ->where('Month', $month)
                                        ->where('Year', $year)
                                        ->update([
                                            'AvailedEL' => $attendanceCounts['EL'] ?? 0,
                                            'BalanceEL' => $totalBalEL,
                                        ]);
                               
                                    // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                                    $fd = $request->from_date;
                                    $td = $request->to_date;
                                    $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                                    $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                               
                                    // Update the leave application
                                    \DB::table('hrm_employee_applyleave')
                                        ->where('EmployeeID', $employeeId)
                                        ->where('ApplyLeaveId', $leaveRequestid)
                                        ->update([
                                            'LeaveStatus' => '2',
                                            'LeaveAppStatus' => '2',
                                            'LeaveRevReason' => $request->remarks,
                                        ]);
                               
                                    return 1; // Successfully updated record
                                }
                        }
                    }
                    else {    
                        $year = $fromDate->year;
                        $month = $fromDate->month;
                        $previousYear = $year - 1;
                                    // Calculate totals based on whether it's the first month or not
                                    if ($month != 1) {
                               
                                        $totalBalEL = $leaveBalance[0]->BalanceEL ?? 0;
                                        $totalBalFL = $leaveBalance[0]->BalanceOL ?? 0;
                               
                                        $total_days = $request->total_days;
                               
                                        // Update the total balance based on the leave type
                                        switch ($request->leavetype) {
                                           
                                            case "EL":
                                                $totalBalEL = max(0, $totalBalEL - $total_days);
                                                break;
                                           
                                        }
                                    } else {
                                       
                                        $totalBalEL = ($leaveBalance[0]->TotEL ?? 0) - ($attendanceCounts['EL'] ?? 0);
                                     
                                    }
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
                                    // Update the leave balance
                                    \DB::table($leaveTable)
                                        ->where('EmployeeID', $employeeId)
                                        ->where('Month', $month)
                                        ->where('Year', $year)
                                        ->update([
                                            'AvailedEL' => $attendanceCounts['EL'] ?? 0,
                                            'BalanceEL' => $totalBalEL,
                                         
                                        ]);
                               
                                    // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                                    $fd = $request->from_date;
                                    $td = $request->to_date;
                                    $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                                    $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                               
                                    // Update the leave application
                                    \DB::table('hrm_employee_applyleave')
                                        ->where('EmployeeID', $employeeId)
                                        ->where('ApplyLeaveId', $leaveRequestid)
                                        ->update([
                                            'LeaveStatus' => '2',
                                            'LeaveAppStatus' => '2',
                                            'LeaveRevReason' => $request->remarks,
                                        ]);
                               
                                    return 1; // Successfully updated record
                        }
                }
               
                elseif ($attendanceRecord) {
                        // Update existing attendance record
                    $update = \DB::table($attTable)
                        ->where('EmployeeID', $employeeId)
                        ->where('AttDate', $fromDate->format('Y-m-d'))
                        ->update(['AttValue' => $leaveType]);
                    if ($update === 0) { //already present and no changes
                        $update = 1;
                    }
   
                    if ($update) {
   
                        // Define start and end dates
                        // $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                        // $endDate = $toDate->endOfMonth()->format('Y-m-d');
                        $startDate = $fromDate->startOfMonth()->format('Y-m-d');
                        $endDate = $fromDate->endOfMonth()->format('Y-m-d');
                        $attTable = 'hrm_employee_attendance'; // Define attendance table name
   
                        // Count various attendance values
                        $attendanceCounts = [
                           
                            'EL' => \DB::table($attTable)
                                ->where('AttValue', 'EL')
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('AttDate', [$startDate, $endDate])
                                ->count(),
                       
                        ];
                       

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
   
                        if ($leaveBalance->isEmpty()) {
                                $fd = $request->from_date;
                            $td = $request->to_date;
                            // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                            $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                            $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                            //dd($leaveRequestid);
                            \DB::table('hrm_employee_applyleave')
                                ->where('EmployeeID', $employeeId)
                                // ->where('half_define', $request->leavetype_day)
                                // ->where('Apply_FromDate', $fromDate)
                                ->where('ApplyLeaveId', $leaveRequestid)
                                // ->where('Apply_ToDate', $toDate)
                                ->update([
                                    'LeaveStatus' => '2',
                                    'LeaveAppStatus' => '2',
                                    'LeaveRevReason' => $request->remarks,
                                ]);
   
                                                                             // Other existing logic to retrieve employee data and prepare for insertion
                                                                             $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                             $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                                 
                                                                             $ReportingName = $reportinggeneral->ReportingName;
                                                                             $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                                 
                                                                             $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                                 
                                                                             $details = [
                                                                                 'ReportingManager' => $ReportingName,
                                                                                 'subject'=>'Leave Approval Status',
                                                                                 'EmpName'=> $Empname,
                                                                                 'TotalDays'=>  $total_days,
                                                                                 'leavetype'=> $leaveType,
                                                                                 'FromDate'=> $fromDate,
                                                                                 'ToDate'=> $toDate,
                                                                                 'Status'=>$s,
                                                                                 'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                                 ];
                                                                                
                                                                                        Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                                  
                                                                                 return 1; // Successfully updated record
                        }
                        else {
   
                            // Calculate totals based on whether it's the first month or not
                            if ($month != 1) {
                               
                                $totalBalEL = $leaveBalance[0]->BalanceEL;
   
                                $total_days = $request->total_days;
   
                                $totalBalEL = max(0, $totalBalEL - $total_days); // Deduct EL from OpeningEL, ensure non-negative
                               
   
                            } else {
   
                                $totalBalEL = $leaveBalance[0]->TotEL - $attendanceCounts['EL'];
                             
                            }
   
                            // Update the leave balance
                            \DB::table($leaveTable)->where('EmployeeID', $employeeId)
                                ->where('Month', $month)
                                ->where('Year', $year)
                                ->update([
                                   
                                    'AvailedEL' => $attendanceCounts['EL'],
                                    'BalanceEL' => $totalBalEL,
                                ]);
                            $fd = $request->from_date;
                            $td = $request->to_date;
                            // Convert from dd/mm/yyyy to yyyy-mm-dd using Carbon
                            $fromDate = Carbon::createFromFormat('d/m/Y', $fd)->format('Y-m-d');
                            $toDate = Carbon::createFromFormat('d/m/Y', $td)->format('Y-m-d');
                            //dd($leaveRequestid);
                            \DB::table('hrm_employee_applyleave')
                                ->where('EmployeeID', $employeeId)
                                // ->where('half_define', $request->leavetype_day)
                                // ->where('Apply_FromDate', $fromDate)
                                ->where('ApplyLeaveId', $leaveRequestid)
                                // ->where('Apply_ToDate', $toDate)
                                ->update([
                                    'LeaveStatus' => '2',
                                    'LeaveAppStatus' => '2',
                                    'LeaveRevReason' => $request->remarks,
                                ]);
   
                                                                             // Other existing logic to retrieve employee data and prepare for insertion
                                                                             $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                                                                             $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
                                                 
                                                                             $ReportingName = $reportinggeneral->ReportingName;
                                                                             $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;
                                                 
                                                                             $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                                                 
                                                                             $details = [
                                                                                 'ReportingManager' => $ReportingName,
                                                                                 'subject'=>'Leave Approval Status',
                                                                                 'EmpName'=> $Empname,
                                                                                 'TotalDays'=>  $total_days,
                                                                                 'leavetype'=> $leaveType,
                                                                                 'FromDate'=> $fromDate,
                                                                                 'ToDate'=> $toDate,
                                                                                 'Status'=>$s,
                                                                                'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                                                                                 ];
                                                                                 
                                                                                        Mail::to($EmailId_Vnr)->send(new LeaveActionMail($details));
                                                                                 
                                                                                 return 1; // Successfully updated record
                           
   
                        }
                    }
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
    public function reverseLeaveAcceptance($applyLeaveId,$vStatus)
    {
        // $employeeId = $request->employeeId;
        // $fd = $request->from_date;
        // $td = $request->to_date;

        // Check if the leave request exists with the same EmployeeID, Apply_FromDate, and Apply_ToDate
        $leaveRequest = \DB::table('hrm_employee_applyleave')
            ->where('ApplyLeaveId', $applyLeaveId)
            ->first();

        // Check if leave request is already rejected
        if ($leaveRequest && $leaveRequest->LeaveStatus == '4') {
            // Fetch attendance data and update AttValue to 'P'

            \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $leaveRequest->EmployeeID)
                ->whereBetween('AttDate', [$leaveRequest->Apply_FromDate, $leaveRequest->Apply_ToDate])
                ->update(['AttValue' => 'P']);


            // Determine month and year
            $fromDate = \Carbon\Carbon::parse($leaveRequest->Apply_FromDate);
            $month = $fromDate->month;
            $year = $fromDate->year;

            // Fetch the leave balance for the specified employee, month, and year
            $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
                ->where('EmployeeID', $leaveRequest->EmployeeID)
                ->where('Month', $month)
                ->where('Year', $year)
                ->first();

            if ($leaveBalance) {
                // Add the total days to the appropriate leave balances based on leave types
                $totalDays = $leaveRequest->Apply_TotalDay;

                if ($leaveRequest->Leave_Type == 'CL' || $leaveRequest->Leave_Type == 'CH') {
                    $leaveBalance->BalanceCL += $totalDays;
                    $leaveBalance->AvailedCL -= $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'SL' || $leaveRequest->Leave_Type == 'SH') {
                    $leaveBalance->BalanceSL += $totalDays;
                    $leaveBalance->AvailedSL -= $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'EL') {
                    $leaveBalance->BalanceEL += $totalDays;
                    $leaveBalance->AvailedEL -= $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'PL') {
                    $leaveBalance->BalancePL += $totalDays;
                    $leaveBalance->AvailedPL -= $totalDays;
                } elseif ($leaveRequest->Leave_Type == 'FL') {
                    $leaveBalance->BalanceOL += $totalDays;
                    $leaveBalance->AvailedOL -= $totalDays; // Assuming this is for "On Leave"
                }
                
                // Update the leave balance in the database
                \DB::table('hrm_employee_monthlyleave_balance')
                    ->where('EmployeeID', $leaveRequest->EmployeeID)
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
                    ->where('EmployeeID', $leaveRequest->EmployeeID)
                    ->where('Apply_FromDate', $leaveRequest->Apply_FromDate)
                    ->where('Apply_ToDate', $leaveRequest->Apply_ToDate)
                    ->update([
                        'LeaveStatus' => $vStatus,
                        'cancellation_status' => $vStatus,

                    ]);
            }
                    // Other existing logic to retrieve employee data and prepare for insertion
                $reportinggeneral = EmployeeGeneral::where('EmployeeID', $leaveRequest->EmployeeID)->first();
                $employeedetails = Employee::where('EmployeeID', $leaveRequest->EmployeeID)->first();

                $ReportingName = $reportinggeneral->ReportingName;
                $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;

                $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                if($vStatus == '2'){
                    $s = "Approved";
                }
                if($vStatus == '3'){
                    $s = "Rejected";
                }
                $details = [
                    'ReportingManager' => $ReportingName,
                    'subject'=>'Leave Cancellation Status',
                    'EmpName'=> $Empname,
                    'TotalDays'=>  $leaveRequest->Apply_TotalDay,
                    'leavetype'=> $leaveRequest->Leave_Type,
                    'FromDate'=> $leaveRequest->Apply_FromDate,
                    'ToDate'=> $leaveRequest->Apply_ToDate,
                    'Status'=> $s,
                    'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                    ];
                    // Mail::to($EmailId_Vnr)->send(new LeaveCancelStatusMail($details));

            return response()->json(['success' => true, 'message' => 'Leave request processed successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Leave request cannot be processed.']);
    }
    // public function reverseLeaveAcceptance($applyLeaveId,$vStatus)
    // {
    //     // $employeeId = $request->employeeId;
    //     // $fd = $request->from_date;
    //     // $td = $request->to_date;

    //     // Check if the leave request exists with the same EmployeeID, Apply_FromDate, and Apply_ToDate
    //     $leaveRequest = \DB::table('hrm_employee_applyleave')
    //         ->where('ApplyLeaveId', $applyLeaveId)
    //         ->first();

    //     // Check if leave request is already rejected
    //     if ($leaveRequest && $leaveRequest->LeaveStatus == '4') {
    //         // Fetch attendance data and update AttValue to 'P'

    //         \DB::table('hrm_employee_attendance')
    //             ->where('EmployeeID', $leaveRequest->EmployeeID)
    //             ->whereBetween('AttDate', [$leaveRequest->Apply_FromDate, $leaveRequest->Apply_ToDate])
    //             ->update(['AttValue' => 'P']);


    //         // Determine month and year
    //         $fromDate = \Carbon\Carbon::parse($leaveRequest->Apply_FromDate);
    //         $month = $fromDate->month;
    //         $year = $fromDate->year;

    //         // Fetch the leave balance for the specified employee, month, and year
    //         $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
    //             ->where('EmployeeID', $leaveRequest->EmployeeID)
    //             ->where('Month', $month)
    //             ->where('Year', $year)
    //             ->first();

    //         if ($leaveBalance) {
    //             // Add the total days to the appropriate leave balances based on leave types
    //             $totalDays = $leaveRequest->Apply_TotalDay;

    //             if ($leaveRequest->Leave_Type == 'CL' || $leaveRequest->Leave_Type == 'CH') {
    //                 $leaveBalance->BalanceCL += $totalDays;
    //                 $leaveBalance->AvailedCL -= $totalDays;
    //             } elseif ($leaveRequest->Leave_Type == 'SL' || $leaveRequest->Leave_Type == 'SH') {
    //                 $leaveBalance->BalanceSL += $totalDays;
    //                 $leaveBalance->AvailedSL -= $totalDays;
    //             } elseif ($leaveRequest->Leave_Type == 'EL') {
    //                 $leaveBalance->BalanceEL += $totalDays;
    //                 $leaveBalance->AvailedEL -= $totalDays;
    //             } elseif ($leaveRequest->Leave_Type == 'PL') {
    //                 $leaveBalance->BalancePL += $totalDays;
    //                 $leaveBalance->AvailedPL -= $totalDays;
    //             } elseif ($leaveRequest->Leave_Type == 'FL') {
    //                 $leaveBalance->BalanceOL += $totalDays;
    //                 $leaveBalance->AvailedOL -= $totalDays; // Assuming this is for "On Leave"
    //             }
                
    //             // Update the leave balance in the database
    //             \DB::table('hrm_employee_monthlyleave_balance')
    //                 ->where('EmployeeID', $leaveRequest->EmployeeID)
    //                 ->where('Month', $month)
    //                 ->where('Year', $year)
    //                 ->update([
    //                     'BalanceCL' => $leaveBalance->BalanceCL,
    //                     'BalanceSL' => $leaveBalance->BalanceSL,
    //                     'BalanceEL' => $leaveBalance->BalanceEL,
    //                     'BalancePL' => $leaveBalance->BalancePL,
    //                     'BalanceOL' => $leaveBalance->BalanceOL,
    //                     'AvailedCL' => $leaveBalance->AvailedCL,
    //                     'AvailedSL' => $leaveBalance->AvailedSL,
    //                     'AvailedEL' => $leaveBalance->AvailedEL,
    //                     'AvailedPL' => $leaveBalance->AvailedPL,
    //                     'AvailedOL' => $leaveBalance->AvailedOL,
    //                 ]);

    //                 \DB::table('hrm_employee_applyleave')
    //                 ->where('EmployeeID', $leaveRequest->EmployeeID)
    //                 ->where('Apply_FromDate', $leaveRequest->Apply_FromDate)
    //                 ->where('Apply_ToDate', $leaveRequest->Apply_ToDate)
    //                 ->update([
    //                     'LeaveStatus' => $vStatus,
    //                     'cancellation_status' => $vStatus,

    //                 ]);
    //         }
    //                 // Other existing logic to retrieve employee data and prepare for insertion
    //             $reportinggeneral = EmployeeGeneral::where('EmployeeID', $leaveRequest->EmployeeID)->first();
    //             $employeedetails = Employee::where('EmployeeID', $leaveRequest->EmployeeID)->first();

    //             $ReportingName = $reportinggeneral->ReportingName;
    //             $EmailId_Vnr = $reportinggeneral->EmailId_Vnr;

    //             $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
    //             if($vStatus == '2'){
    //                 $s = "Approved";
    //             }
    //             if($vStatus == '3'){
    //                 $s = "Rejected";
    //             }
    //             $details = [
    //                 'ReportingManager' => $ReportingName,
    //                 'subject'=>'Leave Cancellation Status',
    //                 'EmpName'=> $Empname,
    //                 'TotalDays'=>  $leaveRequest->Apply_TotalDay,
    //                 'leavetype'=> $leaveRequest->Leave_Type,
    //                 'FromDate'=> $leaveRequest->Apply_FromDate,
    //                 'ToDate'=> $leaveRequest->Apply_ToDate,
    //                 'Status'=> $s,
    //                 'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
    //                 ];
    //                 // Mail::to($EmailId_Vnr)->send(new LeaveCancelStatusMail($details));

    //         return response()->json(['success' => true, 'message' => 'Leave request processed successfully.']);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Leave request cannot be processed.']);
    // }
    public function reverseLeaveAcceptancerequest(Request $request)
    {
        \DB::table('hrm_employee_applyleave')
            ->where('ApplyLeaveId', $request->leaveId)
            ->update([
                'LeaveStatus' => '4',
                'LeaveEmpCancelStatus' => 'Y',
                'LeaveCancelStatus' => 'Y',
                'LeaveEmpCancelReason' => $request->remark

            ]);
        $leave =  \DB::table('hrm_employee_applyleave')
            ->where('ApplyLeaveId', $request->leaveId)->first();

        // Other existing logic to retrieve employee data and prepare for insertion
        $reportinggeneral = EmployeeGeneral::where('EmployeeID', $leave->EmployeeID)->first();
        $employeedetails = Employee::where('EmployeeID', $leave->EmployeeID)->first();

        $ReportingName = $reportinggeneral->ReportingName;
        $ReportingEmailId = $reportinggeneral->ReportingEmailId;

        $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

        $details = [
            'ReportingManager' => $ReportingName,
            'subject' => 'Leave Deleted',
            'EmpName' => $Empname,
            'TotalDays' =>  $leave->Apply_TotalDay,
            'leavetype' => $leave->Leave_Type,
            'FromDate' => $leave->Apply_FromDate,
            'ToDate' => $leave->Apply_ToDate,
            'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
        ];
        
        Mail::to($ReportingEmailId)->send(new LeaveApplyCancellationMail($details));
           
    }
    public function getBirthdays(Request $request)
    {
        $currentDate = Carbon::now();
        $company_id = $request->company_id;

        $birthdays = EmployeeGeneral::select(
            'hrm_employee_general.DOB as date',
            'hrm_employee.Fname',
            'hrm_employee.Sname',
            'hrm_employee.Lname',
            'hrm_employee.EmpCode',
            'hrm_employee_general.EmployeeID',
            \DB::raw("'birthday' as type"),
            'hrm_employee_general.DepartmentId',
            'hrm_employee_general.DesigId',
            'hrm_employee_general.HqId',
            'core_departments.department_code',        // Fetch DepartmentCode
            'core_designation.designation_name',      // Fetch Designation Name
            'core_city_village_by_state.city_village_name'                 // Fetch Headquarter Name
        )
            ->join('hrm_employee', function ($join) use ($company_id) {
                $join->on('hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                    ->where('hrm_employee.CompanyID', $company_id);
            })
            ->where('hrm_employee.EmpStatus', 'A')
            ->join('core_departments', 'hrm_employee_general.DepartmentId', '=', 'core_departments.id')  // Join with Department
            ->join('core_designation', 'hrm_employee_general.DesigId', '=', 'core_designation.id')  // Join with Designation
            ->join('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')  // Join with Headquater
            ->whereMonth('hrm_employee_general.DOB', $currentDate->month)
            ->orderByRaw('DAY(hrm_employee_general.DOB), hrm_employee_general.DOB') // Order first by the day part, then by full DOB (to handle duplicates)
            ->get()
            ->map(function ($item) {
                // Convert the 'date' string to a Carbon instance
                $item->date = Carbon::parse($item->date);
                return $item;
            })
            ->groupBy(function ($item) {
                // Group by the day of the month (ignores year and month)
                return $item->date->day;
            })
            ->map(function ($group) {
                // Sort each group by the full date (in case there are multiple employees with the same day)
                return $group->sortBy('date');
            });

        // Fetch Marriage Dates
        $marriageDates = Personaldetails::select(
            'hrm_employee_personal.MarriageDate as date',
            'hrm_employee.Fname',
            'hrm_employee.Sname',
            'hrm_employee.Lname',
            'hrm_employee.EmpCode',
            'hrm_employee_personal.EmployeeID',
            \DB::raw("'marriage' as type"),
            'hrm_employee_general.DepartmentId',
            'hrm_employee_general.DesigId',
            'hrm_employee_general.HqId',
            'core_departments.department_code',       // Fetch DepartmentCode
            'core_designation.designation_name',     // Fetch Designation Name
            'core_city_village_by_state.city_village_name'                // Fetch Headquarter Name
        )
            ->join('hrm_employee', function ($join) use ($company_id) {
                $join->on('hrm_employee_personal.EmployeeID', '=', 'hrm_employee.EmployeeID')
                    ->where('hrm_employee.CompanyID', $company_id);
            })
            ->where('hrm_employee.EmpStatus', 'A')
            ->join('hrm_employee_general', 'hrm_employee_personal.EmployeeID', '=', 'hrm_employee_general.EmployeeID')  // Join with General Employee Data
            ->join('core_departments', 'hrm_employee_general.DepartmentId', '=', 'core_departments.id')  // Join with Department
            ->join('core_designation', 'hrm_employee_general.DesigId', '=', 'core_designation.id')  // Join with Designation
            ->join('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')  // Join with Headquarter
            ->whereMonth('hrm_employee_personal.MarriageDate', $currentDate->month) // Filter by the current month
            ->orderByRaw('DAY(hrm_employee_personal.MarriageDate), hrm_employee_personal.MarriageDate') // Order by the day first, then by full date
            ->get()
            ->map(function ($item) {
                // Convert the 'date' string to a Carbon instance for each marriage date
                $item->date = Carbon::parse($item->date);
                return $item;
            })
            ->groupBy(function ($item) {
                // Group by the day of the month
                return $item->date->day;
            })
            ->map(function ($group) {
                // Sort each group by the full date (to ensure chronological order)
                return $group->sortBy('date');
            });

        $joiningDates = EmployeeGeneral::select(
            'hrm_employee_general.DateJoining as date',
            'hrm_employee.Fname',
            'hrm_employee.Sname',
            'hrm_employee.Lname',
            'hrm_employee.EmpCode',
            'hrm_employee_general.EmployeeID',
            \DB::raw("'joining' as type"),
            'hrm_employee_general.DepartmentId',
            'hrm_employee_general.DesigId',
            'hrm_employee_general.HqId',
            'core_departments.department_code',
            'core_designation.designation_name',
            'core_city_village_by_state.city_village_name',
            \DB::raw('YEAR(CURDATE()) - YEAR(hrm_employee_general.DateJoining) as years_with_company') // Calculate difference in years
        )
            ->join('hrm_employee', function ($join) use ($company_id) {
                $join->on('hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
                    ->where('hrm_employee.CompanyID', $company_id);
            })
            ->where('hrm_employee.EmpStatus', 'A')  // Only active employees
            ->join('core_departments', 'hrm_employee_general.DepartmentId', '=', 'core_departments.id')
            ->join('core_designation', 'hrm_employee_general.DesigId', '=', 'core_designation.id')
            ->join('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')
            ->whereMonth('hrm_employee_general.DateJoining', $currentDate->month) // Filter by the current month
            ->whereIn(
                \DB::raw('YEAR(CURDATE()) - YEAR(hrm_employee_general.DateJoining)'),
                [1, 3, 5, 7, 15]  // Only these years are valid
            )
            ->orderByRaw('YEAR(CURDATE()) - YEAR(hrm_employee_general.DateJoining) DESC')  // Sort by years in descending order
            ->orderBy('hrm_employee_general.DateJoining', 'desc')
            ->get();



        // Combine all results
        $combinedResults = [
            'birthdays' => $birthdays,
            'marriages' => $marriageDates,
            'joinings' => $joiningDates,
        ];
        return response()->json($combinedResults);
    }
    public function sendWishes(Request $request)
    {
        $employeeId = $request->employee_id; // Employee ID
        $employeeFromId = $request->employeeFromID; // Employee ID
        $type = $request->type; // Employee ID
        $message = $request->message;
        if (str_word_count($message) > 250) {
            // If the message exceeds 250 words, return an error
            return response()->json(['success' => false, 'message' => 'The message cannot be more than 250 words.']);
        }
        if ($message == '' || empty($message)) {
            // If the message exceeds 250 words, return an error
            return response()->json(['success' => false, 'message' => 'Message is mandatory']);
        }

        // Use Query Builder to fetch employee details from the hrm_employee table
        $employee = \DB::table('hrm_employee')  // Replace 'hrm_employee' with your actual table name if needed
            ->select('Fname', 'Lname', 'Sname') // Select the required fields
            ->where('EmployeeID', $employeeFromId) // Assuming 'employee_id' is the column in the table
            ->first(); // Get the first matching record

        // Combine the employee's name fields into a full name (optional)
        $employeeFullName = $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname;

        // Prepare the data to be inserted into the notification_wishes table
        $wishData = [
            'from_wishes_name' => $employeeFullName, // Name of the person sending the wish
            'wishes_type' => $request->type, // Type of the wish (e.g., Birthday, Anniversary)
            'wishes_message' => $request->message, // Message content of the wish
            'wishes_to' => $employeeId, // The recipient's employee ID
            'created_at' => Carbon::now(), // Current timestamp
            'updated_at' => Carbon::now(), // Current timestamp
        ];

        // Check if the wish already exists in the notifications_wishes table
        $existingWish = \DB::table('notifications_wishes')
            ->where('wishes_to', $employeeId) // Check for the recipient
            ->where('wishes_type', $request->type) // Check for the wish type (e.g., "Birthday")
            ->first();

        if ($existingWish) {
            // If the wish exists, update the record
            \DB::table('notifications_wishes')
                ->where('wishes_to', $employeeId) // Target the specific wish
                ->update($wishData);

            $message = 'Wish updated successfully!';
        } else {
            // If no existing wish, insert a new one
            $wishData['from_wishes_name'] = $employeeFullName;
            $wishData['created_at'] = Carbon::now(); // Timestamp for creation

            \DB::table('notifications_wishes')->insert($wishData);

            $message = 'Wish sent successfully!';
        }
        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Wish sent successfully!',
            'employee_name' => $employeeFullName, // Return the full name of the employee in the response
        ]);
    }
    public function softDelete($ApplyLeaveId)
    {
        // Find the leave request by ApplyLeaveId
        $leaveRequest = EmployeeApplyLeave::where('ApplyLeaveId', $ApplyLeaveId)->first();

        // Check if the leave request exists
        if (!$leaveRequest) {
            return response()->json(['message' => 'Leave request not found.'], 404);
        }
        // Other existing logic to retrieve employee data and prepare for insertion
        $reportinggeneral = EmployeeGeneral::where('EmployeeID', $leaveRequest->EmployeeID)->first();
        $employeedetails = Employee::where('EmployeeID', $leaveRequest->EmployeeID)->first();

        $ReportingName = $reportinggeneral->ReportingName;
        $ReportingEmailId = $reportinggeneral->ReportingEmailId;

        $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

        $details = [
            'ReportingManager' => $ReportingName,
            'subject' => 'Leave Deleted',
            'EmpName' => $Empname,
            'leavetype' => $leaveRequest->Leave_Type,
            'TotalDays' =>  $leaveRequest->Apply_TotalDay,
            'FromDate' => $leaveRequest->Apply_FromDate,
            'ToDate' => $leaveRequest->Apply_ToDate,
            'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
        ];
        
                Mail::to($ReportingEmailId)->send(new LeaveDeleteMail($details));
       
        // Soft delete the leave request
        $leaveRequest->delete();

        // Return a success response
        return response()->json(['message' => 'Leave request deleted successfully.']);
    }
    // Controller method for AJAX request
    public function attendanceViewleave(Request $request)
    {
        $employeeId = Auth::user()->EmployeeID;

        $currentYear = Carbon::now()->year;
        $selectedMonth = $request->input('month', Carbon::now()->month); // Default to current month

        // Fetch leave balances for the selected month
        $leaveBalances = \DB::table('hrm_employee_monthlyleave_balance')
            ->where('Year', $currentYear)
            ->where('Month', $selectedMonth)
            ->where('EmployeeID', $employeeId)
            ->first();
        // Calculate future leave balances for the next month
        $futureLeaves = $this->calculateFutureLeaves($employeeId);

        // Return the leave balance data as JSON response
        return response()->json([
            'leaveBalances' => $leaveBalances,
            'futureLeaves' => $futureLeaves
        ]);
    }

    // Method to calculate future leave balances
    private function calculateFutureLeaves($employeeID)
    {
        $nextMonth = Carbon::now()->addMonth()->format('m');
        $year = Carbon::now()->year;

        // Get total count of CL (including CH as 0.5 per record, excluding Sundays and HO)
        $cl = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'CL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays (1 = Sunday in MySQL DAYOFWEEK)
            ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
            ->count()
            +
            (\DB::table('hrm_employee_attendance') // Add 0.5 for each CH
                ->where('EmployeeID', $employeeID)
                ->where('AttValue', 'CH')
                ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
                ->count() * 0.5);

        $sl = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'SL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays (1 = Sunday in MySQL DAYOFWEEK)
            ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
            ->count()
            +
            (\DB::table('hrm_employee_attendance') // Add 0.5 for each CH
                ->where('EmployeeID', $employeeID)
                ->where('AttValue', 'SH')
                ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
                ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays
                ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
                ->count() * 0.5);


        $sl = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'SL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->count() + (\DB::table('hrm_employee_attendance')  // Add 0.5 for each SH
                ->where('EmployeeID', $employeeID)
                ->where('AttValue', 'SH')
                ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
                ->count() * 0.5);


        $pl = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'PL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays (1 = Sunday in MySQL DAYOFWEEK)
            ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
            ->count();

        $el = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'EL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays (1 = Sunday in MySQL DAYOFWEEK)
            ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
            ->count();

        $fl = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeID)
            ->where('AttValue', 'FL')
            ->where('AttDate', '>=', Carbon::parse("{$year}-{$nextMonth}-01"))
            ->whereRaw('DAYOFWEEK(AttDate) != 1') // Exclude Sundays (1 = Sunday in MySQL DAYOFWEEK)
            ->whereNotIn('AttValue', ['HO']) // Exclude records with AttValue = HO
            ->count();

        // Return all future leave balances
        return [
            'CL' => $cl,
            'SL' => $sl,
            'PL' => $pl,
            'EL' => $el,
            'FL' => $fl,
        ];
    }
}
