<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeGeneral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\EmployeeReporting;
use DateTime;
use Carbon\Carbon;
use App\Models\AttendanceRequest;
use App\Models\Contact;
use App\Models\Attendance;
use App\Models\ReasonMaster;
use Illuminate\Foundation\Auth\DB;

class AttendanceController extends Controller
{
    public function attendanceView(Request $request)
    {
        $employeeId = $request->employeeId;
        // Fetch employee
        $employee = Employee::find($employeeId);
        if (!$employee) {
            // Handle employee not found
            return view('employee.leave')->with('holidays', []); // No holidays to show
        }

        // Get the current state ID from the employee_contact table
        $contact = Contact::where('EmployeeID', $employeeId)->first();
        if (!$contact) {
            // Handle contact not found
            return view('employee.leave')->with('holidays', []); // No holidays to show
        }
        $currStateId = $contact->CurrAdd_State;

        $currentYear = date("Y");
        $currentMonth = now()->month; // Get the current month
        $daysInMonth = now()->daysInMonth; // Get the number of days in the current month

        // Define the date range for attendance
        $startDate = date("{$currentYear}-{$currentMonth}-01");
        $endDate = date("{$currentYear}-{$currentMonth}-{$daysInMonth}");


        // Fetch attendance counts
        $attendanceCounts = \DB::table('hrm_employee_attendance')
            ->selectRaw('
                SUM(CASE WHEN AttValue IN ("CL", "SL", "PL", "EL", "FL", "TL", "ML", "COV") THEN 1 ELSE 0 END) as FullDayLeave,
                SUM(CASE WHEN AttValue IN ("CH", "SH", "PH") THEN 1 ELSE 0 END) as HalfDayLeave,
                SUM(CASE WHEN AttValue = "HF" THEN 1 ELSE 0 END) as HalfDayCount,
                SUM(CASE WHEN AttValue = "ACH" THEN 1 ELSE 0 END) as ACH,
                SUM(CASE WHEN AttValue = "ASH" THEN 1 ELSE 0 END) as ASH,
                SUM(CASE WHEN AttValue = "APH" THEN 1 ELSE 0 END) as APH,
                SUM(CASE WHEN AttValue IN ("P", "WFH") THEN 1 ELSE 0 END) as Present,
                SUM(CASE WHEN AttValue = "A" THEN 1 ELSE 0 END) as Absent,
                SUM(CASE WHEN AttValue = "OD" THEN 1 ELSE 0 END) as OnDuties,
                SUM(CASE WHEN AttValue = "HO" THEN 1 ELSE 0 END) as Holiday,
                COUNT(DISTINCT CASE WHEN AttValue = "LWP" THEN AttDate END) as LWP
            ')
            ->where('EmployeeID', $employeeId)
            ->whereBetween('AttDate', [$startDate, $endDate])
            ->first();

        // Calculate derived values
        $CountAch = $attendanceCounts->ACH / 2;
        $CountAsh = $attendanceCounts->ASH / 2;
        $CountAph = $attendanceCounts->APH / 2;
        $CountHf = $attendanceCounts->HalfDayCount / 2;

        $TotalAbsent = $attendanceCounts->Absent + $CountHf + $CountAch + $CountAsh + $CountAph + $attendanceCounts->LWP;
        $TotalLeaveFull = $attendanceCounts->FullDayLeave;
        $TotalLeaveHalf = $attendanceCounts->HalfDayLeave / 2;
        $TotalPR = $attendanceCounts->Present + $CountHf + $TotalLeaveHalf;
        $TotalLeaveCount = $TotalLeaveFull + $TotalLeaveHalf + $CountAch + $CountAsh + $CountAph;
        $TotalOnDuties = $attendanceCounts->OnDuties;
        $TotalHoliday = $attendanceCounts->Holiday;
        $TotalPaidDay = $TotalPR + $TotalLeaveCount + $TotalOnDuties + $TotalHoliday;

        // Fetch holidays
        $holidays = \DB::table('hrm_holiday as h')
            ->join('hrm_employee_contact as ec', 'ec.EmployeeID', '=', \DB::raw($employeeId))
            ->join('hrm_state as s', 'ec.CurrAdd_State', '=', 's.StateId')
            ->where('h.Year', $currentYear)
            ->where('h.status', 'A')
            ->where('h.HolidayDate', '>=', now()->format('Y-m-d')) // Filter for today and future dates
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereIn('s.StateName', ['Andhra Pradesh', 'Kerala', 'Tamil Nadu', 'Karnataka', 'Telangana'])
                        ->where('h.State_2', 1);
                })
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('h.State_1', 1);
                    })
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('h.State_3', 1)
                            ->orWhere('h.State_4', 1);
                    });
            })
            ->orderBy('h.HolidayDate', 'ASC')
            ->get();

        $monthName = now()->format('F');

        // Fetch leave balance
        $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance as leave')
            ->join('hrm_month as month', 'leave.Month', '=', 'month.MonthId')
            ->select(
                'leave.OpeningCL',
                'leave.CreditedCL',
                'leave.AvailedCL',
                'leave.BalanceCL',
                'leave.OpeningSL',
                'leave.CreditedSL',
                'leave.AvailedSL',
                'leave.BalanceSL',
                'leave.OpeningPL',
                'leave.CreditedPL',
                'leave.AvailedPL',
                'leave.BalancePL',
                'leave.OpeningEL',
                'leave.CreditedEL',
                'leave.AvailedEL',
                'leave.BalanceEL',
                'leave.OpeningOL',
                'leave.CreditedOL',
                'leave.AvailedOL',
                'leave.BalanceOL'
            )
            ->where('leave.EmployeeID', $employeeId)
            ->where('month.MonthName', $monthName) // Match with the month name
            ->where('leave.Year', now()->year) // Current year
            ->first();

        // Fetch all holidays
        $all_holidays = \DB::table('hrm_holiday as h')
            ->join('hrm_employee_contact as ec', 'ec.EmployeeID', '=', \DB::raw($employeeId))
            ->join('hrm_state as s', 'ec.CurrAdd_State', '=', 's.StateId')
            ->where('h.Year', $currentYear)
            ->where('h.status', 'A')
            ->orderBy('h.HolidayDate', 'ASC')
            ->get();

        // Fetch optional holidays
        $optionalHolidays = \DB::table('hrm_holiday_optional as ho')
            ->where('ho.Year', $currentYear)
            ->where('ho.HoOpDate', '>=', now()->format('Y-m-d')) // Filter for today and future dates
            ->orderBy('ho.HoOpDate', 'ASC')
            ->get();


        return view('employee.leave', compact(
            'currentYear',
            'all_holidays',
            'holidays',
            'optionalHolidays',
            'TotalLeaveCount',
            'TotalHoliday',
            'TotalOnDuties',
            'TotalPR',
            'TotalAbsent',
            'leaveBalance'
        ));
    }

    public function getAttendance($year, $month, $employeeId)
    {
        // Retrieve the employee data along with their attendance records
        $attendanceData = Employee::with('employeeAttendance')
            ->where('EmployeeID', $employeeId)
            ->first();
        $requestStatus = AttendanceRequest::where('EmployeeID', $employeeId)->first();

        if ($requestStatus === null) {  // Check if no record was found
            $requestData = 0;     // Set Status to 0
        }

        if ($requestStatus != null) {
            // If you want to set Status based on $requestStatus, you can do that here
            $requestData = $requestStatus->Status; // or whatever logic you need
        }

        // Initialize an array to hold formatted attendance records
        $formattedAttendance = [];
        // Check if the employee was found
        if ($attendanceData) {
            // Loop through the employee's attendance records
            foreach ($attendanceData->employeeAttendance as $attendance) {
                $attDate = Carbon::parse($attendance->AttDate);
                $attYear = $attDate->format('Y'); // Get the year
                $attMonth = $attDate->format('m'); // Get the month
                // Match year and month
                if ($attYear == $year && $attMonth == str_pad($month, 2, '0', STR_PAD_LEFT)) {
                    // Add to formatted attendance if it matches the year and month
                    // $formattedAttendance[] = $attendance;

                    $formattedAttendance[] = [
                        'Status' => $requestData,
                        'AttDate' => $attendance->AttDate,
                        'AttValue' => $attendance->AttValue,
                        'InnLate' => $attendance->InnLate,
                        'OuttLate' => $attendance->OuttLate,
                        'II' => Carbon::parse($attendance->II)->format('H:i'), // Format 'II'
                        'OO' => Carbon::parse($attendance->OO)->format('H:i'), // Format 'OO'
                        'Inn' => Carbon::parse($attendance->Inn)->format('H:i'), // Format 'Inn'
                        'Outt' => Carbon::parse($attendance->Outt)->format('H:i'), // Format 'Outt'
                    ];
                }
            }
        }

        return response()->json($formattedAttendance);
    }
    public function authorize(Request $request)
    {

        // Define characters to be removed
        $searchChars = '!"#$%/\':_';
        $search = str_split($searchChars);
        // Initialize variables
        $RemarkI = $RemarkO = $Remark = $InR = $OutR = '';
        // Process based on the type of request
        switch ($request->Atct) {
            case 1:
                $RemarkI = str_replace($search, "", $request->remarkIn);
                $InR = 'Y';
                $OutR = 'N';
                break;

            case 2:
                $RemarkO = str_replace($search, "", $request->remarkOut);
                $InR = 'N';
                $OutR = 'Y';
                break;

            case 12:
                $RemarkI = str_replace($search, "", $request->remarkIn);
                $RemarkO = str_replace($search, "", $request->remarkOut);
                $InR = 'Y';
                $OutR = 'Y';
                break;

            case 3:
                $Reason = str_replace($search, "", $request->reason);
                $Remark = str_replace($search, "", $request->remark);
                break;
        }

        $reportinggeneral = EmployeeGeneral::where('EmployeeID', $request->employeeid)->first();

        $reportingDetails = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

        // Default values for optional fields
        $RId = $reportinggeneral->RepEmployeeID ?? 0;
        $HtId = $reportingDetails->ReviewerId ?? 0;

        $ReqTime = now()->format('H:i:s');
        $CrTime = now()->format('H:i:s');

        // Get attendance settings
        $dv = intval(date($request->requestDate));
        $attendanceSetting = \DB::table('hrm_employee_attendance_settime')
            ->where('EmployeeID', $request->employeeid)
            ->select('I' . $dv)
            ->first();

        $InTime = '00:00:00';
        if ($attendanceSetting) {
            $InTime = Carbon::createFromFormat('H:i:s', $attendanceSetting->{'I' . $dv})->format('H:i:s');
        }
        if ($request->reasonIn) {
            $reasonI = ReasonMaster::find($request->reasonIn);
            $reasonIname = $reasonI->reason_name;
        }
        if ($request->reasonOut) {
            $reasonO = ReasonMaster::find($request->reasonOut);
            $reasonOname = $reasonO->reason_name; // Assuming 'reason_name' is the column name for the reason's name

        }
        if ($request->otherReason) {
            $reasonOther = ReasonMaster::find($request->otherReason);
            $reasonOthername = $reasonOther->reason_name; // Assuming 'reason_name' is the column name for the reason's name


        }

        // Assuming 'reason_name' is the column name for the reason's name

        $attDate = Carbon::createFromFormat('d-F-Y', $request->requestDate)->format('Y-m-d');
        // Insert attendance request
        \DB::table('hrm_employee_attendance_req')->insert([
            'EmployeeID' => $request->employeeid,
            'AttDate' => $attDate,
            'InReason' => $reasonIname ?? '',
            'InRemark' => $RemarkI ?? '',
            'OutReason' => $reasonOname ?? '',
            'OutRemark' => $RemarkO ?? '',
            'Reason' => $reasonOthername ?? '',
            'Remark' => $request->otherRemark ?? '',
            'RId' => $RId,
            'HId' => $HtId,
            'InR' => $InR,
            'OutR' => $OutR,
            'ReqDate' => now()->format('Y-m-d'),
            'ReqTime' => $ReqTime,
            'CrDate' => now()->format('Y-m-d'),
            'CrTime' => $CrTime,
        ]);


        return response()->json(['success' => true, 'message' => 'Attendance request submitted successfully.']);

    }

    public function fetchAttendanceRequests(Request $request)
    {
        $employeeId = $request->employee_id;

        // Fetch attendance requests where the employeeId matches the Rid
        $requests = AttendanceRequest::where('RId', $employeeId)->get();

        // Initialize an array to hold combined data
        $combinedData = [];

        // If there are requests, fetch attendance records and employee details
        if ($requests->isNotEmpty()) {
            foreach ($requests as $requestItem) {
                $rep_employee_id = $requestItem->EmployeeID;
                // Fetch Inn and Outt based on employeeID and AttDate
                $attendance = Attendance::where('EmployeeID', $rep_employee_id)
                    ->where('AttDate', $requestItem->AttDate)
                    ->first();

                // Fetch employee details
                $employeeDetails = Employee::find($rep_employee_id);

                // Combine data
                $combinedData[] = [
                    'request' => $requestItem,
                    'InTime' => $attendance ? $attendance->Inn : null,
                    'OutTime' => $attendance ? $attendance->Outt : null,
                    'employeeDetails' => $employeeDetails,
                ];

            }

            return response()->json($combinedData);
        }



        // If no requests are found, return a message
        return response()->json(['message' => 'No attendance requests found for this employee.'], 404);
    }

    public function authorizeRequestUpdateStatus(Request $request)
    {

        $dateParts = explode('/', $request->requestDate);
        if (count($dateParts) === 3) {
            // Reorder the parts to YYYY-MM-DD
            $formattedDate = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
        }
        // $repo_employee_report = AttendanceRequest::where('RId', $request->employeeid)
        //     ->where('EmployeeID', $request->repo_employeeId)
        //     ->where('AttDate', $formattedDate)
        //     ->first();

        // $employee_report_att = Attendance::where('EmployeeID', $request->repo_employeeId)
        //     ->where('AttDate', $formattedDate)
        //     ->first();

        $dv = intval(date('n', strtotime($request->requestDate))); // Get the month number (1-12)

        $actual_settime = \DB::table('hrm_employee_attendance_settime')
            ->where('EmployeeID', $request->employeeid)
            ->select(['I' . $dv, 'O' . $dv])
            ->first();

        if ($actual_settime) {
            $I = $actual_settime->{'I' . $dv}; // Shift in time
            $O = $actual_settime->{'O' . $dv}; // Shift out time

            $aIn = date("H:i", strtotime($request->inn_time)); // Actual in
            $aOut = date("H:i", strtotime($request->out_time)); // Actual out
            $In = date("H:i", strtotime($I)); // Set shift in time
            $In_15 = strtotime($In) + (15 * 60); // Shift in time + 15 mins
            $nI15 = date('H:i', $In_15); // New shift in time after adding 15 mins
            $Out = date("H:i", strtotime($O)); // Set shift out time
            $Out_15 = strtotime($Out) - (15 * 60); // Shift out time - 15 mins
            $nO15 = date('H:i', $Out_15); // New shift out time after subtracting 15 mins
        } else {
            // Handle the case where actual_settime is null
            // For example, you might want to set default values or return an error
            $I = null;
            $O = null;
            // Handle error as necessary
        }
        $employee_report_att_employee = Attendance::where('EmployeeID', $request->employeeid)
            ->where('AttDate', $formattedDate)
            ->first();


        // Assuming these values are defined somewhere in your code
        $in = $request->inReason; // Assign the value for II
        $out = $request->outReason;// Assign the value for OO
        $other = $request->otherReason; // Assign the value for Outt

        // Initialize variables
        $Inchk = 0; // Default value for Inchk
        $Outchk = 0; // Default value for Outchk
        $chk = 0; // Default value for chk

        // Compare values and assign accordingly
        if ($in) {
            $Inchk = 1; // Assign 1 to Inchk if condition is met
        }

        if ($out) {
            $Outchk = 1; // Assign 1 to Outchk if condition is met
        }

        if ($other) {
            $chk = 1; // Assign 1 to chk if condition is met
        }
        $statusMapping = [
            'approved' => 2,
            'rejected' => 3,
        ];

        // Get the statuses from the request
        $Instatus = $request->input('inStatus');
        $Outstatus = $request->input('outStatus');
        $OtherStatus = $request->input('otherStatus');


        // Use the mapping to set numeric values or keep the original if not found
        $Instatus = $statusMapping[$Instatus] ?? $Instatus; // Use the original if not found
        $Outstatus = $statusMapping[$Outstatus] ?? $Outstatus; // Use the original if not found
        $OtherStatus = $statusMapping[$OtherStatus] ?? $OtherStatus; // Use the original if not found


        // Initialize counts
        $InCnt = 'Y';
        $OutCnt = 'Y';

        // Logic to determine InCnt and OutCnt based on Inchk, Outchk, and chk
        if ($Inchk == 1 && $Outchk == 1 && $chk == 0) {
            $InCnt = ($Instatus == 2) ? 'N' : (($Instatus == 3) ? 'Y' : 'Y');
            $OutCnt = ($Outstatus == 2) ? 'N' : (($Outstatus == 3) ? 'Y' : 'Y');
        } elseif ($Inchk == 1 && $Outchk == 0 && $chk == 0) {
            $InCnt = ($Instatus == 2) ? 'N' : (($Instatus == 3) ? 'Y' : 'Y');
            $OutCnt = 'Y';
        } elseif ($Inchk == 0 && $Outchk == 1 && $chk == 0) {
            $OutCnt = ($Outstatus == 2) ? 'N' : (($Outstatus == 3) ? 'Y' : 'Y');
            $InCnt = 'Y';
        } elseif ($chk == 1) {

            $attValue = \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $request->employeeid)
                ->where('AttDate', $formattedDate)
                ->value('AttValue');

            if ($OtherStatus == 2) {
                $chkAtt = match ($request->otherReason) {
                    'WFH' => 'WFH',
                    'OD' => 'OD',
                    'Other', 'Tour', 'Official' => 'P',
                    default => 'P',
                };
            } elseif ($OtherStatus == 3) {
                if (!in_array($attValue, ['P', 'A', '', 'OD', 'WFH'])) {
                    $chkAtt = $attValue;
                } else {
                    // Check Total CL Availed in month
                    $monthStart = date("Y-m-01", strtotime($formattedDate));
                    $monthEnd = date("Y-m-31", strtotime($formattedDate));

                    $tCL = \DB::table('hrm_employee_applyleave')
                        ->where('LeaveStatus', '<>', 4)
                        ->where('LeaveStatus', '<>', 3)
                        ->where('LeaveStatus', '<>', 2)
                        ->where('EmployeeID', $request->employeeid)
                        ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                        ->whereIn('Leave_Type', ['CL', 'CH'])
                        ->sum('Apply_TotalDay');

                    $tPL = \DB::table('hrm_employee_applyleave')
                        ->where('LeaveStatus', '<>', 4)
                        ->where('LeaveStatus', '<>', 3)
                        ->where('LeaveStatus', '<>', 2)
                        ->where('EmployeeID', $request->employeeid)
                        ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                        ->whereIn('Leave_Type', ['PL', 'PH'])
                        ->sum('Apply_TotalDay');


                    // Check Balance CL & PL in month
                    $balance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employeeid)
                        ->where('Month', date("m", strtotime($formattedDate)))
                        ->where('Year', date("Y", strtotime($formattedDate)))
                        ->first();

                    if ($balance) {
                        $balCL = ($balance->OpeningCL + $balance->CreditedCL) - $tCL;
                        $balPL = ($balance->OpeningPL + $balance->CreditedPL) - $tPL;

                    } else {
                        //not have enough data- hence need more data for testing

                        $prevMonth = date('m', strtotime("-1 month", strtotime($formattedDate)));
                        $prevYear = date('Y', strtotime("-1 month", strtotime($formattedDate)));
                        $prevBalance = \DB::table('hrm_employee_monthlyleave_balance')
                            ->where('EmployeeID', $request->employeeid)
                            ->where('Month', $prevMonth)
                            ->where('Year', $prevYear)
                            ->first();

                        $balCL = $prevBalance->BalanceCL - $tCL;
                        $balPL = $prevBalance->BalancePL - $tPL;
                    }

                    $chkAtt = ($balCL > 0) ? 'CL' : (($balPL > 0) ? 'PL' : 'A');
                }
            }
        }
        $status = 0; // Default value

        // Determine the status based on conditions
        if (
            ($Instatus == 2 && $Outstatus === 2) ||
            ($Instatus == 1 && empty($Outstatus)) ||
            ($Outstatus == 1 && empty($Instatus)) ||
            (empty($Instatus) && empty($Outstatus))
        ) {
            $status = 1;
        }
        // Get remarks from the request
        $remarks = [
            $request->reportRemarkIn,
            $request->reportRemarkOut,
            $request->reportRemarkOther,
        ];

        // Initialize the repository remark variable
        $repoRemark = null;

        // Loop through the remarks to find the first non-empty one
        foreach ($remarks as $remark) {
            if (!empty($remark)) {
                $repoRemark = $remark;
                break; // Exit the loop once a non-empty remark is found
            }
        }

        // Optionally handle the case where no remarks are found
        if (is_null($repoRemark)) {
            $repoRemark = "No remarks provided"; // or any default value
        }

        // Update attendance request without using Eloquent models
        $updateResult = \DB::table('hrm_employee_attendance_req')
            ->where('EmployeeID', $request->employeeid)
            ->where('AttDate', $formattedDate)
            ->update([
                'InStatus' => $Instatus ?? '0',
                'OutStatus' => $Outstatus ?? '0',
                'SStatus' => '0',
                'R_Remark' => $repoRemark,
                'Status' => $status,
            ]);


        if ($updateResult && $chk == 0) {

            // Calculation logic
            $dd = intval(date("d", strtotime($formattedDate)));
            $mm = date("m", strtotime($formattedDate));
            $yy = date("Y", strtotime($formattedDate));
            $mkdate = mktime(0, 0, 0, $mm, 1, $yy);
            $nodinm = date('t', $mkdate);  // Number of days in the month

            // Calculate late entries
            $InL = ($request->InLate > 0 && $InCnt !== 'N') ? 1 : 0;
            $OutL = ($request->OutLate > 0 && $OutCnt !== 'N') ? 1 : 0;
            $Late = $InL + $OutL;

            if ($Late == 0 || $Late == 1) {


                $monthStart = date("Y-m-01", strtotime($formattedDate));
                $monthEnd = date("Y-m-31", strtotime($formattedDate));

                $tCL = \DB::table('hrm_employee_applyleave')
                    ->where('LeaveStatus', '<>', 4)
                    ->where('LeaveStatus', '<>', 3)
                    ->where('LeaveStatus', '<>', 2)
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                    ->whereIn('Leave_Type', ['CL', 'CH'])
                    ->sum('Apply_TotalDay');

                $aaCL = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('AttDate', [date("Y-m-01", strtotime($formattedDate)), date("Y-m-31", strtotime($formattedDate))])
                    ->where('AttDate', '<>', $formattedDate)
                    ->where('AttValue', 'CL')
                    ->count();


                $aaCH = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('AttDate', [date("Y-m-01", strtotime($formattedDate)), date("Y-m-31", strtotime($formattedDate))])
                    ->where('AttDate', '<>', $formattedDate)
                    ->where('AttValue', 'CH')
                    ->count();


                $CountCH = $aaCH / 2;
                $tCL += $aaCL + $CountCH;

                // Check Total PL Availed in month
                $tPL = \DB::table('hrm_employee_applyleave')
                    ->where('LeaveStatus', '<>', 4)
                    ->where('LeaveStatus', '<>', 3)
                    ->where('LeaveStatus', '<>', 2)
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('Apply_FromDate', [date("Y-m-01", strtotime($formattedDate)), date("Y-m-31", strtotime($formattedDate))])
                    ->whereIn('Leave_Type', ['PL', 'PH'])
                    ->sum('Apply_TotalDay');

                $aaPL = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('AttDate', [date("Y-m-01", strtotime($formattedDate)), date("Y-m-31", strtotime($formattedDate))])
                    ->where('AttDate', '<>', $formattedDate)
                    ->where('AttValue', 'PL')
                    ->count();

                $aaPH = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->whereBetween('AttDate', [date("Y-m-01", strtotime($formattedDate)), date("Y-m-31", strtotime($formattedDate))])
                    ->where('AttDate', '<>', $formattedDate)
                    ->where('AttValue', 'PH')
                    ->count();

                $CountPH = $aaPH / 2;
                $tPL += $aaPL + $CountPH;

                // Check Balance CL & PL in month
                $balance = \DB::table('hrm_employee_monthlyleave_balance')
                    ->where('EmployeeID', $request->employeeid)
                    ->where('Month', date("m", strtotime($formattedDate)))
                    ->where('Year', date("Y", strtotime($formattedDate)))
                    ->first();

                if ($balance) {
                    $balCL = ($balance->OpeningCL + $balance->CreditedCL) - $tCL;
                    $balPL = ($balance->OpeningPL + $balance->CreditedPL) - $tPL;
                } else {
                    $prevMonth = date('m', strtotime("-1 month", strtotime($formattedDate)));
                    $prevYear = date('Y', strtotime("-1 month", strtotime($formattedDate)));
                    $prevBalance = \DB::table('hrm_employee_monthlyleave_balance')
                        ->where('EmployeeID', $request->employeeid)
                        ->where('Month', $prevMonth)
                        ->where('Year', $prevYear)
                        ->first();

                    $balCL = $prevBalance->BalanceCL - $tCL;
                    $balPL = $prevBalance->BalancePL - $tPL;
                }

                $schk = \DB::table('hrm_employee_applyleave')
                    ->where('LeaveStatus', '<>', 4)
                    ->where('LeaveStatus', '<>', 3)
                    ->where('EmployeeID', $request->employeeid)
                    ->where('Apply_FromDate', $formattedDate)
                    ->where('Apply_ToDate', $formattedDate)
                    ->whereIn('Leave_Type', ['SH', 'CH', 'PH'])
                    ->first();

                if ($schk) {
                    $Lv = $schk->Leave_Type;
                } elseif ($balCL > 0) {
                    $Lv = 'CH';
                } elseif ($balPL > 0) {
                    $Lv = 'PH';
                } else {
                    $Lv = 'HF';
                }

                // Calculate total late
                $sIn = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->where('AttDate', '>=', date("Y-m-01", strtotime($formattedDate)))
                    ->where('AttDate', '<', $formattedDate)
                    ->where('InnCnt', 'Y')
                    ->where('Af15', 0)
                    ->sum('InnLate');

                $sOut = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->where('AttDate', '>=', date("Y-m-01", strtotime($formattedDate)))
                    ->where('AttDate', '<', $formattedDate)
                    ->where('OuttCnt', 'Y')
                    ->where('Af15', 0)
                    ->sum('OuttLate');

                $tLate = $sIn + $sOut + $Late;
            }
            // Determine attendance status
            if ($Late == 0) {
                $Att = 'P';
                $Relax = 'N';
                $Allow = 'N';
                $Af15 = 0;
            } 
            elseif ($Late == 2) {
                //need to duscuss
                $Att = $employee_report_att_employee->AttValue;
                $Relax = $employee_report_att_employee->Relax;
                $Allow = $employee_report_att_employee->Allow;
                $Af15 = $employee_report_att_employee->Af15;
            } 
            elseif ($Late == 1 && $employee_report_att_employee->InLate == 1 && $employee_report_att_employee->OutLate == 1) { // A open
                if ($InCnt == 'Y' && $OutCnt == 'N') { // 1 Open

                    if ($aIn > $nI15 || $aIn == '' || $aIn == '00:00:00') {
                        $Att = $Lv;
                        $Relax = 'N';
                        $Allow = 'Y';
                        $Af15 = 1;
                    } elseif ($aIn <= $In) {
                        $Att = 'P';
                        $Relax = 'N';
                        $Allow = 'N';
                        $Af15 = 0;
                    } elseif ($aIn > $In && $aIn <= $nI15) {
                        if ($dd != $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                                $Af15 = 0;
                            } else {
                                if (in_array($tLate, [3, 4, 6, 7, 9, 10, 12, 13, 15, 16, 18, 19, 21, 22, 24, 25, 27, 28, 30, 31, 33, 34, 36, 37, 39, 40, 42, 43, 45, 46, 48, 49, 51, 52])) {
                                    $Att = 'P';
                                    $Relax = 'N';
                                    $Allow = 'N';
                                    $Af15 = 0;
                                } elseif (in_array($tLate, [5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50])) {
                                    $Att = $Lv;
                                    $Relax = 'N';
                                    $Allow = 'Y';
                                    $Af15 = 0;
                                }
                            }
                        } elseif ($dd == $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                                $Af15 = 0;
                            } elseif ($tLate > 2) {
                                $Att = $Lv;
                                $Relax = 'N';
                                $Allow = 'Y';
                                $Af15 = 0;
                            }
                        }
                    }
                } elseif ($InCnt == 'N' && $OutCnt == 'Y') { // 2 Open


                    if ($aOut < $nO15 || $aOut == '' || $aOut == '00:00:00') {
                        $Att = $Lv;
                        $Relax = 'N';
                        $Allow = 'Y';
                        $Af15 = 1;
                    } elseif ($aOut >= $Out) {
                        $Att = 'P';
                        $Relax = 'N';
                        $Allow = 'N';
                        $Af15 = 0;
                    } elseif ($aOut >= $nO15 && $aOut < $Out) {
                        if ($dd != $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                                $Af15 = 0;
                            } else {
                                if (in_array($tLate, [3, 4, 6, 7, 9, 10, 12, 13, 15, 16, 18, 19, 21, 22, 24, 25, 27, 28, 30, 31, 33, 34, 36, 37, 39, 40, 42, 43, 45, 46, 48, 49, 51, 52])) {
                                    $Att = 'P';
                                    $Relax = 'N';
                                    $Allow = 'N';
                                    $Af15 = 0;
                                } elseif (in_array($tLate, [5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50])) {
                                    $Att = $Lv;
                                    $Relax = 'N';
                                    $Allow = 'Y';
                                    $Af15 = 0;
                                }
                            }
                        } elseif ($dd == $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                                $Af15 = 0;
                            } elseif ($tLate > 2) {
                                $Att = $Lv;
                                $Relax = 'N';
                                $Allow = 'Y';
                                $Af15 = 0;
                            }
                        }
                    }
                } // 1 Close
            } 
            elseif ($Late == 1 && (($employee_report_att_employee->InLate == 1 && $employee_report_att_employee->OutLate == 0) || ($employee_report_att_employee->InLate == 0 && $employee_report_att_employee->OutLate == 1))) {
                // B open
                $Att = $employee_report_att_employee->AttValue;
                $Relax = $employee_report_att_employee->Relax;
                $Allow = $employee_report_att_employee->Allow;
                $Af15 = $employee_report_att_employee->Af15;
            } 
            $sUp = \DB::table('hrm_employee_attendance')
                ->where('AttId', $employee_report_att_employee->AttId)
                ->where('EmployeeID', $request->employeeid)
                ->update([
                        'AttValue' => $Att,
                        'II' => $In . ":00",
                        'OO' => $Out . ":00",
                        'InnCnt' => $InCnt,
                        'OuttCnt' => $OutCnt,
                        'Relax' => $Relax,
                        'Allow' => $Allow,
                        'Af15' => $Af15
                    ]);
           

                    // Get the last day of the month from the NextDate
            $NextDate = Carbon::parse($formattedDate)->addDay(); // Move to the next day
            $lastDayOfMonth = $NextDate->copy()->endOfMonth(); // Get the last day of the month
                    

            while ($NextDate->lte($lastDayOfMonth)) {

                $attendanceRecord = \DB::table('hrm_employee_attendance')
                    ->where('EmployeeID', $request->employeeid)
                    ->where('AttDate', $NextDate->toDateString())
                    ->first();

                if ($attendanceRecord && $attendanceRecord->Late > 0 && $attendanceRecord->Af15 == 0) {
                    // Logic to determine InnLate and OuttLate
                    $InnLate = $attendanceRecord->InnCnt == 'Y' && $attendanceRecord->InnLate ? 1 : 0;
                    $OuttLate = $attendanceRecord->OuttCnt == 'Y' && $attendanceRecord->OuttLate ? 1 : 0;
                    $LateStatus = $InnLate + $OuttLate;
                if (($attendanceRecord->InnCnt == 'Y' && $attendanceRecord->InnLate == 1) || ($attendanceRecord->OuttCnt == 'Y' && $attendanceRecord->OuttLate == 1)) {
                        $c5 = $attendanceRecord->Inn;
                        $c7 = $attendanceRecord->Outt;
                    
                        $Innlate = ($attendanceRecord->InnCnt == 'Y' && $attendanceRecord->InnLate == 1) ? 1 : 0;
                        $Outtlate = ($attendanceRecord->OuttCnt == 'Y' && $attendanceRecord->OuttLate == 1) ? 1 : 0;
                        $tt = $Innlate + $Outtlate;
                        $Late = ($tt == 1) ? 1 : (($tt == 2) ? 2 : 0);
                    
                        // Check late attendance
                        $tLate = EmployeeAttendance::where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$monthStart, $i])
                            ->where('InnCnt', 'Y')
                            ->where('Af15', 0)
                            ->sum('InnLate') + 
                            EmployeeAttendance::where('EmployeeID', $employeeId)
                            ->whereBetween('AttDate', [$monthStart, $i])
                            ->where('OuttCnt', 'Y')
                            ->where('Af15', 0)
                            ->sum('OuttLate') + 
                            $tt;
                    
                        if (!in_array($attendanceRecord->AttValue, ['CL', 'PL', 'SL', 'EL', 'OD', 'A'])) {
                            // Check total CL & PL availed in month
                            $tCL = LeaveApplication::where('LeaveStatus', '!=', 4)
                                ->where('LeaveStatus', '!=', 3)
                                ->where('LeaveStatus', '!=', 2)
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                                ->whereBetween('Apply_ToDate', [$monthStart, $monthEnd])
                                ->whereIn('Leave_Type', ['CL', 'CH'])
                                ->sum('Apply_TotalDay');
                    
                            $tPL = LeaveApplication::where('LeaveStatus', '!=', 4)
                                ->where('LeaveStatus', '!=', 3)
                                ->where('LeaveStatus', '!=', 2)
                                ->where('EmployeeID', $employeeId)
                                ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                                ->whereBetween('Apply_ToDate', [$monthStart, $monthEnd])
                                ->whereIn('Leave_Type', ['PL', 'PH'])
                                ->sum('Apply_TotalDay');
                    
                            // Fetch balance for CL & PL
                            $leaveBalance = LeaveBalance::where('EmployeeID', $employeeId)
                                ->where('Month', $rDate->month)
                                ->where('Year', $rDate->year)
                                ->first();
                    
                            if ($leaveBalance) {
                                $balCL = ($leaveBalance->OpeningCL + $leaveBalance->CreditedCL) - $tCL;
                                $balPL = ($leaveBalance->OpeningPL + $leaveBalance->CreditedPL) - $tPL;
                            } else {
                                $previousMonth = $rDate->subMonth();
                                $prevLeaveBalance = LeaveBalance::where('EmployeeID', $employeeId)
                                    ->where('Month', $previousMonth->month)
                                    ->where('Year', $previousMonth->year)
                                    ->first();
                                $balCL = $prevLeaveBalance->BalanceCL - $tCL;
                                $balPL = $prevLeaveBalance->BalancePL - $tPL;
                            }
                    
                            $leaveTypeQuery = LeaveApplication::where('LeaveStatus', '!=', 4)
                                ->where('LeaveStatus', '!=', 3)
                                ->where('EmployeeID', $employeeId)
                                ->where('Apply_FromDate', $i)
                                ->where('Apply_ToDate', $i)
                                ->whereIn('Leave_Type', ['SH', 'CH', 'PH'])
                                ->first();
                    
                            if ($leaveTypeQuery) {
                                $Lv = $leaveTypeQuery->Leave_Type;
                            } elseif ($balCL > 0) {
                                $Lv = 'CH';
                            } elseif ($balPL > 0) {
                                $Lv = 'PH';
                            } else {
                                $Lv = 'HF';
                            }
                        }
                    
                        // Attendance status logic
                        if ($d2d != $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                            } elseif ($tLate > 2 && $tt == 1) {
                                if (in_array($tLate, [3, 4, 6, 7, 9, 10, 12, 13, 15, 16, 18, 19, 21, 22, 24, 25, 27, 28, 30, 31, 33, 34, 36, 37, 39, 40, 42, 43, 45, 46, 48, 49, 51, 52])) {
                                    $Att = 'P';
                                    $Relax = 'N';
                                    $Allow = 'N';
                                } elseif (in_array($tLate, [5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50])) {
                                    $Att = $Lv;
                                    $Relax = 'N';
                                    $Allow = 'Y';
                                }
                            } elseif ($tLate > 2 && $tt == 2) {
                                if (in_array($tLate, [3, 4, 7, 10, 13, 16, 19, 22, 25, 28, 31, 34, 37, 40, 43, 46, 49, 52])) {
                                    $Att = 'P';
                                    $Relax = 'N';
                                    $Allow = 'N';
                                } elseif (in_array($tLate, [5, 6, 8, 9, 11, 12, 14, 15, 17, 18, 20, 21, 23, 24, 26, 27, 29, 30, 32, 33, 35, 36, 38, 39, 41, 42, 44, 45, 47, 48, 50, 51])) {
                                    $Att = $Lv;
                                    $Relax = 'N';
                                    $Allow = 'Y';
                                }
                            }
                        } elseif ($d2d == $nodinm) {
                            if ($tLate <= 2) {
                                $Att = 'P';
                                $Relax = 'Y';
                                $Allow = 'N';
                            } elseif ($tLate > 2) {
                                $Att = $Lv;
                                $Relax = 'N';
                                $Allow = 'Y';
                            }
                        }                    
            }

            // Move to the next date
            $NextDate->addDay();


        }
        
        exit;

        return response()->json(['success' => true, 'message' => 'Attendance updated successfully.']);
            }
            // if($updateResult){
            //     //mailling
            // }

        }

        else if ($updateResult && $chk == 1) {
            // Fetch attendance record
            $attendanceRecord = \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $request->employeeid)
                ->where('AttDate', $formattedDate)
                ->first();
        
            if ($attendanceRecord) {
                // Update the existing record
                $sUp = \DB::table('hrm_employee_attendance')
                    ->where('AttId', $employee_report_att_employee->AttId)
                    ->where('EmployeeID', $request->employeeid)
                    ->update(['AttValue' => $chkAtt]);
            } else {
                // Insert a new record
                $sUp = \DB::table('hrm_employee_attendance')->insert([
                    'EmployeeID' => $request->employeeid,
                    'AttValue' => $chkAtt,
                    'AttDate' => $formattedDate
                ]);
            }
        
            // Notify success
            echo '<script>alert("Data submitted successfully.."); window.close();</script>';
        }
        $this->updateLeaveBalances($request->employeeid, $formattedDate);

        
    }


    public  function updateLeaveBalances($employeeId, $date)
    {
        $mm = date("m", strtotime($date));
        $yy = date("Y", strtotime($date));

        // Leave types array
        $leaveTypes = ['CL', 'CH', 'SL', 'SH', 'PL', 'PH', 'EL', 'FL', 'TL', 'HF', 'ACH', 'ASH', 'APH', 'P', 'WFH', 'A', 'OD', 'HO'];

        // Initialize counts
        $leaveCounts = [];

        // Fetch leave counts
        foreach ($leaveTypes as $leaveType) {
            $leaveCounts[$leaveType] = \DB::table('hrm_employee_attendance')
                ->where('AttValue', $leaveType)
                ->where('EmployeeID', $employeeId)
                ->whereBetween('AttDate', ["{$yy}-{$mm}-01", "{$yy}-{$mm}-31"])
                ->count();
        }

        // Calculate totals
        $TotalCL = $leaveCounts['CL'] + ($leaveCounts['CH'] / 2);
        $TotalSL = $leaveCounts['SL'] + ($leaveCounts['SH'] / 2);
        $TotalPL = $leaveCounts['PL'] + ($leaveCounts['PH'] / 2);
        $TotalLeaveCount = $TotalCL + $TotalSL + $TotalPL + $leaveCounts['EL'] + $leaveCounts['FL'] + $leaveCounts['TL'];
        $TotalPR = ($leaveCounts['P'] + $leaveCounts['WFH'] + ($leaveCounts['CH'] / 2) + ($leaveCounts['SH'] / 2) + ($leaveCounts['PH'] / 2) + ($leaveCounts['HF'] / 2));
        $TotalAbsent = $leaveCounts['A'] + $leaveCounts['HF'] + $leaveCounts['ACH'] / 2 + $leaveCounts['ASH'] / 2 + $leaveCounts['APH'] / 2;

        // Fetch monthly leave balance
        $monthlyLeave = \DB::table('hrm_employee_monthlyleave_balance')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $mm)
            ->where('Year', $yy)
            ->first();

        if ($monthlyLeave) {
            // Update leave balances
            $TotBalCL = $monthlyLeave->OpeningCL - $TotalCL;
            $TotBalSL = $monthlyLeave->OpeningSL - $TotalSL;
            $TotBalPL = $monthlyLeave->OpeningPL - $TotalPL;
            $TotBalEL = $monthlyLeave->OpeningEL - $leaveCounts['EL'];
            $TotBalFL = $monthlyLeave->OpeningOL - $leaveCounts['FL'];

            \DB::table('hrm_employee_monthlyleave_balance')
                ->where('EmployeeID', $employeeId)
                ->where('Month', $mm)
                ->where('Year', $yy)
                ->update([
                    'AvailedCL' => $TotalCL,
                    'AvailedSL' => $TotalSL,
                    'AvailedPL' => $TotalPL,
                    'AvailedOL' => $leaveCounts['FL'],
                    'BalanceCL' => $TotBalCL,
                    'BalanceSL' => $TotBalSL,
                    'BalancePL' => $TotBalPL,
                    'BalanceOL' => $TotBalFL
                ]);
        }
    }
}
