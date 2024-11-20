<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeApplyLeave;
use App\Models\EmployeeGeneral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\EmployeeReporting;
use App\Models\LeaveBalance;
use DateTime;
use Carbon\Carbon;
use App\Models\AttendanceRequest;
use App\Models\Contact;
use App\Models\Attendance;
use App\Models\ReasonMaster;
use App\Models\HrmYear;
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

    // Retrieve all attendance requests for the employee
    $requestStatuses = AttendanceRequest::where('EmployeeID', $employeeId)->get();

    // Map the request statuses by date
    $statusMap = [];
    $draftStatusMap = []; // Initialize the draft status map
    $requestDetailsMap = []; // Initialize to hold all request details

    foreach ($requestStatuses as $request) {
        $requestDate = Carbon::parse($request->AttDate)->format('Y-m-d'); // Assuming AttDate is a Carbon instance
        $statusMap[$requestDate] = $request->Status; // Map status by request date
        $draftStatusMap[$requestDate] = $request->draft_status; // Map draft status by request date
        $requestDetailsMap[$requestDate] = $request; // Store the entire request for later use
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

            // Match year and month (No limit on future dates)
            if ($attYear == $year && $attMonth == str_pad($month, 2, '0', STR_PAD_LEFT)) {
                // Get the status for the attendance date
                $attendanceDate = $attDate->format('Y-m-d');
                $statusExists = isset($statusMap[$attendanceDate]); // Flag to check if status exists

                // Get request details, status, and draft status
                $requestStatus = $statusMap[$attendanceDate] ?? 0; // Default to 0 if no request found
                $draftStatus = $draftStatusMap[$attendanceDate] ?? null; // Get the corresponding draft status
                $requestDetails = $requestDetailsMap[$attendanceDate] ?? null; // Get full request details

                // Add to formatted attendance
                $formattedAttendance[] = [
                    'Status' => $requestStatus,
                    'DraftStatus' => $draftStatus,
                    'RequestDetails' => $requestDetails, // Include all request details
                    'AttDate' => $attendance->AttDate,
                    'AttValue' => $attendance->AttValue,
                    'InnLate' => $attendance->InnLate,
                    'OuttLate' => $attendance->OuttLate,
                    'II' => Carbon::parse($attendance->II)->format('H:i'), // Format 'II'
                    'OO' => Carbon::parse($attendance->OO)->format('H:i'), // Format 'OO'
                    'Inn' => Carbon::parse($attendance->Inn)->format('H:i'), // Format 'Inn'
                    'Outt' => Carbon::parse($attendance->Outt)->format('H:i'), // Format 'Outt'
                    'DataExist' => $statusExists, // Flag indicating if status is present
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
 
    // Get the data from the request
    $data = $request->all();
    if (is_null($data['reasonIn']) && is_null($data['reasonOut']) && is_null($data['otherReason'])) {
        return response()->json(['success' => false, 'message' => 'At least one of Reason or Remark must have a value.'], 400);
    }
    // // List of fields to check for null values
    // $fields = [
    //     'reasonIn',
    //     'reasonOut',
    //     'otherReason',
    // ];

    // // // Flag to check if all relevant fields are null
    // $allNull = true;

    // // Check if any of the mandatory reason fields are null
    // // if (is_null($data['reasonIn']) && is_null($data['reasonOut']) && is_null($data['otherReason'])) {
    // //     return response()->json(['success' => false, 'message' => 'Atleast Reason or Remark to be selected.'], 400);
    // // }

    // // Now check the other fields
    // foreach ($fields as $field) {
    //     if (!is_null($data[$field])) {
    //         $allNull = false;
    //         break; // Exit the loop as we found a non-null value
    //     }
    // }



    //     // // If all fields are null, return an error
    //     if ($allNull) {
    //         return response()->json(['success' => false, 'message' => 'At least one of Reason or Remark must have a value.'], 400);

    //     }
   
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
  

    // Format the attendance date
    $attDate = Carbon::createFromFormat('d-F-Y', $request->requestDate)->format('Y-m-d');

    // Check if an attendance request already exists for the same date and employee ID
    $existingRequest = \DB::table('hrm_employee_attendance_req')
        ->where('EmployeeID', $request->employeeid)
        ->where('AttDate', $attDate)
        ->first();

    if ($existingRequest) {
        return response()->json(['success' => false, 'message' => 'Attendance request for this date already exists.'], 400);
    }

    // Other existing logic to retrieve employee data and prepare for insertion
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

    // Prepare reasons
    $reasonIname = $request->reasonIn ? ReasonMaster::find($request->reasonIn)->reason_name : '';
    $reasonOname = $request->reasonOut ? ReasonMaster::find($request->reasonOut)->reason_name : '';
    $reasonOthername = $request->otherReason ? ReasonMaster::find($request->otherReason)->reason_name : '';

    // Insert attendance request
    \DB::table('hrm_employee_attendance_req')->insert([
        'EmployeeID' => $request->employeeid,
        'AttDate' => $attDate,
        'InReason' => $reasonIname ?? '',
        'InRemark' => $request->remarkIn ?? '',
        'OutReason' => $reasonOname ?? '',
        'OutRemark' =>  $request->remarkOut ?? '',
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
        $requests = AttendanceRequest::where('RId', $employeeId)->whereStatus('0')->whereMonth('AttDate', Carbon::now()->month)->get();

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
                    'II' => $attendance ? $attendance->II : null,
                    'OO' => $attendance ? $attendance->OO : null,
                    'employeeDetails' => $employeeDetails,
                ];

            }

            return response()->json($combinedData);
        }



        // If no requests are found, return a message
        return response()->json(['message' => 'No attendance requests found for this employee.'], 200);
    }

    public function authorizeRequestUpdateStatus(Request $request)
    {
        $monthNames = [
            'January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06',
            'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12'
        ];
        $dateParts = explode('-', $request->requestDate);
        // if (count($dateParts) === 3) {
        //     // Reorder the parts to YYYY-MM-DD
        //     $formattedDate = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
        // }
        // Check if the date is valid (has day, month name, year)
        if (count($dateParts) === 3) {
            $day = str_pad($dateParts[0], 2, '0', STR_PAD_LEFT); // Ensure day is two digits
            $monthName = trim($dateParts[1]); // The month name, e.g. "November"
            $year = $dateParts[2]; // The year

            // Convert the month name to the numeric format
            $month = isset($monthNames[$monthName]) ? $monthNames[$monthName] : '01'; // Default to '01' if month is not found

            // Rebuild the date in the format "yyyy-mm-dd"
            $formattedDate = "{$year}-{$month}-{$day}";
        }
        

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
            'approved' => 1,
            'rejected' => 0,
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
            $InCnt = ($Instatus == 1) ? 'N' : (($Instatus == 0) ? 'Y' : 'Y');
            $OutCnt = ($Outstatus == 1) ? 'N' : (($Outstatus == 0) ? 'Y' : 'Y');
        } elseif ($Inchk == 1 && $Outchk == 0 && $chk == 0) {
            $InCnt = ($Instatus == 1) ? 'N' : (($Instatus == 0) ? 'Y' : 'Y');
            $OutCnt = 'Y';
        } elseif ($Inchk == 0 && $Outchk == 1 && $chk == 0) {
            $OutCnt = ($Outstatus == 1) ? 'N' : (($Outstatus == 0) ? 'Y' : 'Y');
            $InCnt = 'Y';
        } elseif ($chk == 1) {

            $attValue = \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $request->employeeid)
                ->where('AttDate', $formattedDate)
                ->value('AttValue');

            if ($OtherStatus == 1) {
                $chkAtt = match ($request->otherReason) {
                    'WFH' => 'WFH',
                    'OD' => 'OD',
                    'Other', 'Tour', 'Official' => 'P',
                    default => 'P',
                };
            } elseif ($OtherStatus == 0) {
                $chkAtt='A';
                // if (!in_array($attValue, ['P', 'A', '', 'OD', 'WFH'])) {
                //     $chkAtt = $attValue;
                // } 
                
                // else {
                //     // Check Total CL Availed in month
                //     // $monthStart = date("Y-m-01", strtotime($formattedDate));
                //     // $monthEnd = date("Y-m-31", strtotime($formattedDate));

                //     // $tCL = \DB::table('hrm_employee_applyleave')
                //     //     ->where('LeaveStatus', '<>', 4)
                //     //     ->where('LeaveStatus', '<>', 3)
                //     //     ->where('LeaveStatus', '<>', 2)
                //     //     ->where('EmployeeID', $request->employeeid)
                //     //     ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                //     //     ->whereIn('Leave_Type', ['CL', 'CH'])
                //     //     ->sum('Apply_TotalDay');

                //     // $tPL = \DB::table('hrm_employee_applyleave')
                //     //     ->where('LeaveStatus', '<>', 4)
                //     //     ->where('LeaveStatus', '<>', 3)
                //     //     ->where('LeaveStatus', '<>', 2)
                //     //     ->where('EmployeeID', $request->employeeid)
                //     //     ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
                //     //     ->whereIn('Leave_Type', ['PL', 'PH'])
                //     //     ->sum('Apply_TotalDay');


                //     // Check Balance CL & PL in month
                //     // $balance = \DB::table('hrm_employee_monthlyleave_balance')
                //     //     ->where('EmployeeID', $request->employeeid)
                //     //     ->where('Month', date("m", strtotime($formattedDate)))
                //     //     ->where('Year', date("Y", strtotime($formattedDate)))
                //     //     ->first();

                //     // if ($balance) {
                //     //     $balCL = ($balance->OpeningCL + $balance->CreditedCL) - $tCL;
                //     //     $balPL = ($balance->OpeningPL + $balance->CreditedPL) - $tPL;

                //     // } else {
                //     //     //not have enough data- hence need more data for testing

                //     //     $prevMonth = date('m', strtotime("-1 month", strtotime($formattedDate)));
                //     //     $prevYear = date('Y', strtotime("-1 month", strtotime($formattedDate)));
                //     //     $prevBalance = \DB::table('hrm_employee_monthlyleave_balance')
                //     //         ->where('EmployeeID', $request->employeeid)
                //     //         ->where('Month', $prevMonth)
                //     //         ->where('Year', $prevYear)
                //     //         ->first();

                //     //     $balCL = $prevBalance->BalanceCL - $tCL;
                //     //     $balPL = $prevBalance->BalancePL - $tPL;
                //     // }

                //     // if($balCL>0){$chkAtt='CL';}
                //     // elseif($balPL>0){$chkAtt='PL';}
                //     // else{
                //     $chkAtt='A';
                // // }
                // }
            }
        }

        $status = 0; // Default value
      
  
        // Determine the status based on conditions
        if (
            ($Instatus == 1 && ($Outstatus === 1 || empty($Outstatus))) ||
            ($Outstatus == 1 && ($Instatus === 1 || empty($Instatus))) ||
            ($OtherStatus == 1 && (empty($Outstatus) || empty($Instatus)))
        ) {
            $status = 1;
        } elseif (
            ($Instatus == 0 && ($Outstatus === 1 || empty($Outstatus))) ||
            ($Outstatus == 0 && ($Instatus === 1 || empty($Instatus))) ||
            ($Instatus == 0 && $Outstatus == 0)||
            ($OtherStatus == 0 && (empty($Outstatus) || empty($Instatus)))

        ) {
            $status = 0;
        } elseif (!empty($Instatus) || !empty($Outstatus || !empty($OtherStatus))) {
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
                    'draft_status'=>'0',
                ]);
          

        if ($updateResult && $chk == 0) {
            // Extract date components
            $formattedDateTimestamp = strtotime($formattedDate);
            $dd = intval(date("d", $formattedDateTimestamp));
            $mm = date("m", $formattedDateTimestamp);
            $yy = date("Y", $formattedDateTimestamp);

            // Calculate the number of days in the month
            $mkdate = mktime(0, 0, 0, $mm, 1, $yy);
            $nodinm = date('t', $mkdate);

            // Calculate late entries
            $Late = $this->calculateLateEntries($request, $InCnt, $OutCnt);
            if ($Late == 0 || $Late == 1) {
                $monthStart = date("Y-m-01", $formattedDateTimestamp);
                $monthEnd = date("Y-m-t", $formattedDateTimestamp); // Get last day of the month

                $tCL = $this->calculateLeaveDays($request->employeeid, $monthStart, $monthEnd, ['CL', 'CH']);
                $tPL = $this->calculateLeaveDays($request->employeeid, $monthStart, $monthEnd, ['PL', 'PH']);


                // Check Balance CL & PL in month
                $balance = $this->getLeaveBalance($request->employeeid, $monthStart, $monthEnd);

                // Determine leave type
                $Lv = $this->determineLeaveType($request->employeeid, $formattedDate, $balance);

                // Calculate total late
                $tLate = $this->calculateTotalLate($request->employeeid, $monthStart, $monthEnd, $Late, $formattedDate);

                // Determine attendance status
                $attendanceStatus = $this->determineAttendanceStatus($Late, $employee_report_att_employee, $tLate, $Lv, $dd, $nodinm, $InCnt, $OutCnt, $aIn, $nI15, $In, $aOut, $nO15, $Out);
                // Update attendance
                $this->updateAttendance($employee_report_att_employee->AttId, $request->employeeid, $attendanceStatus, $formattedDate);
                // Handle next dates
                $this->handleNextDates($request->employeeid, $formattedDate, $monthStart, $monthEnd, $nodinm);
                $this->updateLeaveBalances($request->employeeid, $formattedDate);
               
                return response()->json(['message' => 'Data Update Successfully'], 200);

            }
        } else if ($updateResult && $chk == 1) {

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
                $currentYear = date('Y');
                $nextYear = $currentYear + 1;

                // Retrieve the year record from the hrm_year table
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();
                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                $year = Carbon::parse($formattedDate)->year;
                $sUp = \DB::table('hrm_employee_attendance')->insert([
                    'EmployeeID' => $request->employeeid,
                    'AttValue' => $chkAtt,
                    'AttDate' => $formattedDate,
                    'Year' => $year,
                    'YearId' => $year_id,
                    'II' => '00:00:00',
                    'OO' => '00:00:00',
                    'Inn' => '00:00:00',
                    'Outt' => '00:00:00',
                ]);
            }
            $this->updateLeaveBalances($request->employeeid, $formattedDate);

            // print_R($update_leave);exit;

            return response()->json(['message' => 'Data Update Successfully'], 200);


        }
    }
    // Function to calculate late entries
    public function calculateLateEntries($request, $InCnt, $OutCnt)
    {
        $InL = ($request->InLate > 0 && $InCnt !== 'N') ? 1 : 0;
        $OutL = ($request->OutLate > 0 && $OutCnt !== 'N') ? 1 : 0;
        return $InL + $OutL;
    }
    // Function to get leave balance
    function getLeaveBalance($employeeId, $monthStart, $monthEnd)
    {
        return \DB::table('hrm_employee_monthlyleave_balance')
            ->where('EmployeeID', $employeeId)
            ->where('Month', date("m", strtotime($monthStart)))
            ->where('Year', date("Y", strtotime($monthStart)))
            ->first();
    }
    // Function to calculate leave days
    public function calculateLeaveDays($employeeId, $startDate, $endDate, $leaveTypes)
    {
        $leaveDays = \DB::table('hrm_employee_applyleave')
            ->where('LeaveStatus', '<>', 4)
            ->where('LeaveStatus', '<>', 3)
            ->where('LeaveStatus', '<>', 2)
            ->where('EmployeeID', $employeeId)
            ->whereBetween('Apply_FromDate', [$startDate, $endDate])
            ->whereIn('Leave_Type', $leaveTypes)
            ->sum('Apply_TotalDay');

        // Additional calculations for attendance records
        foreach ($leaveTypes as $type) {
            $aa = \DB::table('hrm_employee_attendance')
                ->where('EmployeeID', $employeeId)
                ->whereBetween('AttDate', [$startDate, $endDate])
                ->where('AttValue', $type)
                ->count();
            $leaveDays += $aa / ($type === 'CH' ? 2 : 1);
        }

        return $leaveDays;
    }
    // Function to determine leave type
    public function determineLeaveType($employeeId, $formattedDate, $balance)
    {
        $schk = \DB::table('hrm_employee_applyleave')
            ->where('LeaveStatus', '<>', 4)
            ->where('LeaveStatus', '<>', 3)
            ->where('EmployeeID', $employeeId)
            ->where('Apply_FromDate', $formattedDate)
            ->where('Apply_ToDate', $formattedDate)
            ->whereIn('Leave_Type', ['SH', 'CH', 'PH'])
            ->first();

        if ($schk) {
            return $schk->Leave_Type;
        } elseif ($balance->BalanceCL > 0) {
            return 'CH';
        } elseif ($balance->BalancePL > 0) {
            return 'PH';
        } else {
            return 'HF';
        }
    }

    // Function to calculate total late
    public function calculateTotalLate($employeeId, $monthStart, $monthEnd, $Late, $formattedDate)
    {
        $sIn = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeId)
            ->where('AttDate', '>=', $monthStart)
            ->where('AttDate', '<', $formattedDate)
            ->where('InnCnt', 'Y')
            ->where('Af15', 0)
            ->sum('InnLate');

        $sOut = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', $employeeId)
            ->where('AttDate', '>=', $monthStart)
            ->where('AttDate', '<', $formattedDate)
            ->where('OuttCnt', 'Y')
            ->where('Af15', 0)
            ->sum('OuttLate');

        return $sIn + $sOut + $Late;
    }
    // Function to determine attendance status
    public function determineAttendanceStatus($Late, $employee_report_att_employee, $tLate, $Lv, $dd, $nodinm, $InCnt, $OutCnt, $aIn, $nI15, $In, $aOut, $nO15, $Out)
    {
        // Attendance status logic
        if ($Late == 0) {
            $Att = 'P';
            $Relax = 'N';
            $Allow = 'N';
            $Af15 = 0;
        } elseif ($Late == 2) {
            // Need to discuss
            $Att = $employee_report_att_employee->AttValue;
            $Relax = $employee_report_att_employee->Relax;
            $Allow = $employee_report_att_employee->Allow;
            $Af15 = $employee_report_att_employee->Af15;
        } elseif ($Late == 1 && $employee_report_att_employee->InLate == 1 && $employee_report_att_employee->OutLate == 1) {
            // A open
            if ($InCnt == 'Y' && $OutCnt == 'N') {
                // 1 Open

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
        } elseif ($Late == 1 && (($employee_report_att_employee->InLate == 1 && $employee_report_att_employee->OutLate == 0) || ($employee_report_att_employee->InLate == 0 && $employee_report_att_employee->OutLate == 1))) {
            // B open
            $Att = $employee_report_att_employee->AttValue;
            $Relax = $employee_report_att_employee->Relax;
            $Allow = $employee_report_att_employee->Allow;
            $Af15 = $employee_report_att_employee->Af15;
        }

        return [
            'AttValue' => $Att,
            'Relax' => $Relax,
            'Allow' => $Allow,
            'Af15' => $Af15
        ];
    }
    // Function to update attendance
    public function updateAttendance($attId, $employeeId, $attendanceStatus, $formattedDate)
    {
        // Fetch the existing record
        $existingRecord = \DB::table('hrm_employee_attendance')
            ->where('AttId', $attId)
            ->where('EmployeeID', $employeeId)
            ->where('AttDate', $formattedDate)
            ->first();

        if ($existingRecord) {
            // Check if the values are already the same
            if (
                $existingRecord->AttValue === $attendanceStatus['AttValue'] &&
                $existingRecord->Relax === $attendanceStatus['Relax'] &&
                $existingRecord->Allow === $attendanceStatus['Allow'] &&
                $existingRecord->Af15 === $attendanceStatus['Af15']
            ) {
                // Values match, return 1
                return 1;
            }
        }

        // Perform the update
        $updatedRows = \DB::table('hrm_employee_attendance')
            ->where('AttId', $attId)
            ->where('EmployeeID', $employeeId)
            ->where('AttDate', $formattedDate)
            ->update([
                'AttValue' => $attendanceStatus['AttValue'],
                'Relax' => $attendanceStatus['Relax'],
                'Allow' => $attendanceStatus['Allow'],
                'Af15' => $attendanceStatus['Af15']
            ]);

        // Check if the update was successful
        if ($updatedRows > 0) {
            return 1; // Return 1 if the update was successful
        }

        // If no rows were updated and they weren't matching, you could return 0 or another value
        return 0; // Indicate no action was taken
    }


    public function updateLeaveBalances($employeeId, $date)
    {
        $yy = substr($date, 0, 4); // Get the first 4 characters for the year
        $mm = substr($date, 5, 2); // Get the characters at positions 5 and 6 for the month

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
        $TotalCL = (float) ($leaveCounts['CL'] + ($leaveCounts['CH'] / 2));
        $TotalSL = (float) ($leaveCounts['SL'] + ($leaveCounts['SH'] / 2));
        $TotalPL = (float) ($leaveCounts['PL'] + ($leaveCounts['PH'] / 2));
        $TotalLeaveCount = (float) ($TotalCL + $TotalSL + $TotalPL + $leaveCounts['EL'] + $leaveCounts['FL'] + $leaveCounts['TL']);
        $TotalPR = (float) ($leaveCounts['P'] + $leaveCounts['WFH'] + ($leaveCounts['CH'] / 2) + ($leaveCounts['SH'] / 2) + ($leaveCounts['PH'] / 2) + ($leaveCounts['HF'] / 2));
        $TotalAbsent = (float) ($leaveCounts['A'] + $leaveCounts['HF'] + ($leaveCounts['ACH'] / 2) + ($leaveCounts['ASH'] / 2) + ($leaveCounts['APH'] / 2));

        // Fetch monthly leave balance
        $monthlyLeave = \DB::table('hrm_employee_monthlyleave_balance')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $mm)
            ->where('Year', $yy)
            ->first();

        if ($monthlyLeave) {

            // Update leave balances
            $TotBalCL = (float) ($monthlyLeave->OpeningCL) - $TotalCL;
            $TotBalSL = (float) ($monthlyLeave->OpeningSL) - $TotalSL;
            $TotBalPL = (float) ($monthlyLeave->OpeningPL) - $TotalPL;
            $TotBalEL = (float) ($monthlyLeave->OpeningEL) - $leaveCounts['EL'];
            $TotBalFL = (float) ($monthlyLeave->OpeningOL) - $leaveCounts['FL'];


          // Fetch the existing record
            $existingLeaveBalance = \DB::table('hrm_employee_monthlyleave_balance')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $mm)
            ->where('Year', $yy)
            ->first();

            if ($existingLeaveBalance) {
            // Check if the current values are the same as the new values
            if (
                $existingLeaveBalance->AvailedCL === (float) ($TotalCL ?? 0) &&
                $existingLeaveBalance->AvailedSL === (float) ($TotalSL ?? 0) &&
                $existingLeaveBalance->AvailedPL === (float) ($TotalPL ?? 0) &&
                $existingLeaveBalance->AvailedOL === (float) ($leaveCounts['FL'] ?? 0) &&
                $existingLeaveBalance->BalanceCL === (float) ($TotBalCL ?? 0) &&
                $existingLeaveBalance->BalanceSL === (float) ($TotBalSL ?? 0) &&
                $existingLeaveBalance->BalancePL === (float) ($TotBalPL ?? 0) &&
                $existingLeaveBalance->BalanceOL === (float) ($TotBalFL ?? 0)
            ) {
                // Values match, return 1
                return 1;
            }
            }

            // Perform the update
            $updatedRows = \DB::table('hrm_employee_monthlyleave_balance')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $mm)
            ->where('Year', $yy)
            ->update([
                'AvailedCL' => (float) ($TotalCL ?? 0),
                'AvailedSL' => (float) ($TotalSL ?? 0),
                'AvailedPL' => (float) ($TotalPL ?? 0),
                'AvailedOL' => (float) ($leaveCounts['FL'] ?? 0),
                'BalanceCL' => (float) ($TotBalCL ?? 0),
                'BalanceSL' => (float) ($TotBalSL ?? 0),
                'BalancePL' => (float) ($TotBalPL ?? 0),
                'BalanceOL' => (float) ($TotBalFL ?? 0),
            ]);

            // Check if the update was successful
            if ($updatedRows > 0) {
            return 1; // Return 1 if the update was successful
            }

            // Return 0 if no action was taken
            return 0;
           }
        }
        public function handleNextDates($employeeId, $formattedDate, $monthStart, $monthEnd, $nodinm)
        {
            $nextDate = Carbon::parse($formattedDate)->addDay();
            $lastDayOfMonth = $nextDate->copy()->endOfMonth();

    while ($nextDate->lte($lastDayOfMonth)) {
        $attendanceRecord = $this->getAttendanceRecord($employeeId, $nextDate);

        if ($attendanceRecord && $this->isLate($attendanceRecord)) {

            $attendanceData = $this->calculateAttendanceData($attendanceRecord, $employeeId, $monthStart, $monthEnd, $nodinm);
            if ($attendanceData) {

                $existingRecord = $this->getExistingRecord($employeeId, $formattedDate);

                // if (!$this->shouldUpdate($existingRecord, $attendanceData)) {
                // print_r('asdds');exit;

                //     return 1; // No update needed
                // }


                $updatedRows = $this->updateAttendanceRecord($employeeId, $formattedDate, $attendanceData);
                if ($updatedRows > 0) {
                    return 1; // Update successful
                }
            }
        }
        $nextDate->addDay();
    }
    return 0; // No updates made
}

public function getAttendanceRecord($employeeId, $nextDate)
{
    return \DB::table('hrm_employee_attendance')
        ->where('EmployeeID', $employeeId)
        ->where('AttDate', $nextDate->toDateString())
        ->first();
}

public function isLate($attendanceRecord)
{
    return $attendanceRecord->Late > 0 && $attendanceRecord->Af15 == 0;
}

public function calculateAttendanceData($attendanceRecord, $employeeId, $monthStart, $monthEnd, $nodinm)
{
    $InnLate = $attendanceRecord->InnCnt == 'Y' && $attendanceRecord->InnLate ? 1 : 0;
    $OuttLate = $attendanceRecord->OuttCnt == 'Y' && $attendanceRecord->OuttLate ? 1 : 0;

    $tLate = $this->calculateTotalLate_data($employeeId, $monthStart, $monthEnd, $InnLate, $OuttLate);
    $Lv = $this->determineLeaveType_data($employeeId, $monthStart, $monthEnd, $attendanceRecord->AttValue);

    return $this->determineAttendanceStatus_data($tLate, $Lv, $nodinm, $attendanceRecord);
}

public function calculateTotalLate_data($employeeId, $monthStart, $monthEnd, $InnLate, $OuttLate)
{
    return Attendance::where('EmployeeID', $employeeId)
        ->whereBetween('AttDate', [$monthStart, $monthEnd])
        ->where('InnCnt', 'Y')
        ->where('Af15', 0)
        ->sum('InnLate') +
        Attendance::where('EmployeeID', $employeeId)
            ->whereBetween('AttDate', [$monthStart, $monthEnd])
            ->where('OuttCnt', 'Y')
            ->where('Af15', 0)
            ->sum('OuttLate') +
        ($InnLate + $OuttLate);
}

public function determineLeaveType_data($employeeId, $monthStart, $monthEnd, $attValue)
{
    // Total leave days applied in the given month
    $tCL = EmployeeApplyLeave::where('LeaveStatus', '!=', 4)
        ->where('EmployeeID', $employeeId)
        ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
        ->whereBetween('Apply_ToDate', [$monthStart, $monthEnd])
        ->whereIn('Leave_Type', ['CL', 'CH'])
        ->sum('Apply_TotalDay');

    $tPL = EmployeeApplyLeave::where('LeaveStatus', '!=', 4)
        ->where('EmployeeID', $employeeId)
        ->whereBetween('Apply_FromDate', [$monthStart, $monthEnd])
        ->whereBetween('Apply_ToDate', [$monthStart, $monthEnd])
        ->whereIn('Leave_Type', ['PL', 'PH'])
        ->sum('Apply_TotalDay');

    // Fetch leave balances for CL and PL
    $year = substr($monthStart, 0, 4);
    $month = substr($monthStart, 5, 2);

    $leaveBalance = LeaveBalance::where('EmployeeID', $employeeId)
        ->where('Month', $month)
        ->where('Year', $year)
        ->first();

    if ($leaveBalance) {
        $balCL = ($leaveBalance->OpeningCL + $leaveBalance->CreditedCL) - $tCL;
        $balPL = ($leaveBalance->OpeningPL + $leaveBalance->CreditedPL) - $tPL;
    } else {
        // If there's no leave balance record, fetch from the previous month
        $previousMonthTimestamp = strtotime("$year-$month-01 -1 month");
        $previousMonth = date('m', $previousMonthTimestamp);
        $previousYear = date('Y', $previousMonthTimestamp);
        
        $prevLeaveBalance = LeaveBalance::where('EmployeeID', $employeeId)
            ->where('Month', $previousMonth)
            ->where('Year', $previousYear)
            ->first();

        $balCL = $prevLeaveBalance ? $prevLeaveBalance->BalanceCL - $tCL : 0;
        $balPL = $prevLeaveBalance ? $prevLeaveBalance->BalancePL - $tPL : 0;
    }

    // Determine the leave type based on balances
    if ($balCL > 0 && !in_array($attValue, ['CL', 'PL', 'SL', 'EL', 'OD', 'A'])) {
        return 'CH'; // Compensatory Leave
    } elseif ($balPL > 0 && !in_array($attValue, ['CL', 'PL', 'SL', 'EL', 'OD', 'A'])) {
        return 'PH'; // Paid Leave
    } else {
        return 'HF'; // Half Day or any other status you want to assign
    }
}

public function determineAttendanceStatus_data($tLate, $Lv, $nodinm, $attendanceRecord)
{
    $Att = $Relax = $Allow = null; // Initialize variables

    // Logic to determine Att, Relax, and Allow based on conditions
    if ($nodinm) {
        // Logic for non-duty days
        if ($tLate <= 2) {
            $Att = 'P'; // Present
            $Relax = 'Y'; // Relaxed attendance
            $Allow = 'N'; // Not allowed for further leniency
        } else {
            $Att = $Lv; // Set based on leave type
            $Relax = 'N'; // Not relaxed
            $Allow = 'Y'; // Allowed for further leniency
        }
    } else {
        // Logic for duty days
        if ($tLate <= 2) {
            $Att = 'P'; // Present
            $Relax = 'Y'; // Relaxed attendance
            $Allow = 'N'; // Not allowed for further leniency
        } elseif ($tLate > 2 && $tLate <= 5) {
            if ($attendanceRecord->InnLate || $attendanceRecord->OuttLate) {
                // If the employee was late for either Inn or Out
                $Att = $Lv; // Set based on leave type
                $Relax = 'N'; // Not relaxed
                $Allow = 'Y'; // Allowed for further leniency
            } else {
                $Att = 'L'; // Late
                $Relax = 'N'; // Not relaxed
                $Allow = 'N'; // Not allowed for further leniency
            }
        } else {
            // More than 5 late occurrences
            $Att = 'A'; // Absent
            $Relax = 'N'; // Not relaxed
            $Allow = 'N'; // Not allowed for further leniency
        }
    }

    return [
        'Att' => $Att,
        'Relax' => $Relax,
        'Allow' => $Allow
    ];
}


public function getExistingRecord($employeeId, $formattedDate)
{
    return \DB::table('hrm_employee_attendance')
        ->where('EmployeeID', $employeeId)
        ->where('AttDate', $formattedDate)
        ->first();
}

public function shouldUpdate($existingRecord, $attendanceData)
{
     // If there's no existing record, an update is necessary
     if (!$existingRecord) {
        return true; // Update needed if record doesn't exist
    }

    // Check for differences in the values
    return !(
        $existingRecord->AttValue === $attendanceData['Att'] &&
        $existingRecord->Relax === $attendanceData['Relax'] &&
        $existingRecord->Allow === $attendanceData['Allow']
    );
}

public function updateAttendanceRecord($employeeId, $formattedDate, $attendanceData)
{
    // Fetch the existing record to compare values
    $existingRecord = \DB::table('hrm_employee_attendance')
        ->where('EmployeeID', $employeeId)
        ->where('AttDate', $formattedDate)
        ->first();

    // If no record exists, create one
    if (!$existingRecord) {
        // Insert logic can go here if needed, returning 1
        return 1; // No existing record to update
    }

    // Check if the values are the same
    if (
        $existingRecord->AttValue === $attendanceData['Att'] &&
        $existingRecord->Relax === $attendanceData['Relax'] &&
        $existingRecord->Allow === $attendanceData['Allow']
    ) {
        return 1; // No update needed, values are the same
    }

    // Perform the update
    \DB::table('hrm_employee_attendance')
        ->where('EmployeeID', $employeeId)
        ->where('AttDate', $formattedDate)
        ->update([
            'AttValue' => $attendanceData['Att'],
            'Relax' => $attendanceData['Relax'],
            'Allow' => $attendanceData['Allow']
        ]);

    return 1; // Update was made
}
public function getAttendanceData(Request $request)
{
    $employeeId = $request->employeeId;
    $date = $request->date;
    $formattedDate = Carbon::parse($date)->format('Y-m-d'); // Ensure the date is in the correct format
    // Query the HRM attendance data
    $attendance = AttendanceRequest::where('EmployeeID', $employeeId)
        ->where('AttDate', $formattedDate)
        ->first();

    return response()->json([
        'attendance' => $attendance
    ]);
}


}

