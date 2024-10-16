<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\EmployeeReporting;
use DateTime;
use App\Models\Holiday;
use App\Models\Contact;
use App\Models\State;
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
                    'leave.OpeningCL', 'leave.CreditedCL', 'leave.AvailedCL', 'leave.BalanceCL',
                    'leave.OpeningSL', 'leave.CreditedSL', 'leave.AvailedSL', 'leave.BalanceSL',
                    'leave.OpeningPL', 'leave.CreditedPL', 'leave.AvailedPL', 'leave.BalancePL',
                    'leave.OpeningEL', 'leave.CreditedEL', 'leave.AvailedEL', 'leave.BalanceEL',
                    'leave.OpeningOL', 'leave.CreditedOL', 'leave.AvailedOL', 'leave.BalanceOL'
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

    
            return view('employee.leave', compact('currentYear', 'all_holidays', 'holidays', 'optionalHolidays', 
            'TotalLeaveCount', 'TotalHoliday', 'TotalOnDuties', 'TotalPR', 'TotalAbsent','leaveBalance'));  
      }
    
    public function getAttendance($year, $month, $employeeId)
    {
    // Retrieve the employee data along with their attendance records
    $attendanceData = Employee::with('employeeAttendance')
        ->where('EmployeeID', $employeeId)
        ->first();
    // Initialize an array to hold formatted attendance records
    $formattedAttendance = [];

    // Check if the employee was found
    if ($attendanceData) {
        // Loop through the employee's attendance records
        foreach ($attendanceData->employeeAttendance as $attendance) {
            $attDate = \Carbon\Carbon::parse($attendance->AttDate);
            $attYear = $attDate->format('Y'); // Get the year
            $attMonth = $attDate->format('m'); // Get the month
            // Match year and month
            if ($attYear == $year && $attMonth == str_pad($month, 2, '0', STR_PAD_LEFT)) {
                // Add to formatted attendance if it matches the year and month
                // $formattedAttendance[] = $attendance;

                $formattedAttendance[] = [
                    'AttDate' => $attendance->AttDate,
                    'AttValue' => $attendance->AttValue,
                    'II' => \Carbon\Carbon::parse($attendance->II)->format('H:i'), // Format 'II'
                    'OO' => \Carbon\Carbon::parse($attendance->OO)->format('H:i'), // Format 'OO'
                    'Inn' => \Carbon\Carbon::parse($attendance->Inn)->format('H:i'), // Format 'Inn'
                    'Outt' => \Carbon\Carbon::parse($attendance->Outt)->format('H:i'), // Format 'Outt'
                ];
            }
        }
    }
   
    return response()->json($formattedAttendance);
    }
    public function authorize(Request $request)
    {
        $searchChars = '!"#$%/\':_';
        $search = str_split($searchChars);

        if ($request->Atct == 1) {
            $RemarkI = str_replace($search, "", $request->remarkI);
            $RemarkO = '';
            $Remark = '';
            $InR = 'Y';
            $OutR = 'N';
            $AllRemark = $RemarkI;
        } elseif ($request->Atct == 2) {
            $RemarkO = str_replace($search, "", $request->remarkO);
            $RemarkI = '';
            $Remark = '';
            $InR = 'N';
            $OutR = 'Y';
            $AllRemark = $RemarkO;
        } elseif ($request->Atct == 12) {
            $RemarkI = str_replace($search, "", $request->remarkI);
            $RemarkO = str_replace($search, "", $request->remarkO);
            $Remark = '';
            $InR = 'Y';
            $OutR = 'Y';
            $AllRemark = $RemarkI . ' & ' . $RemarkO;
        } elseif ($request->Atct == 3) {
            $Remark = str_replace($search, "", $request->reason);
            $RemarkI = '';
            $RemarkO = '';
            $InR = 'N';
            $OutR = 'N';
            $AllRemark = $Remark;
        }
        $employeeReporting = EmployeeReporting::where('EmployeeID', $request->employeeid)->first();

        if (!$employeeReporting) {
        return response()->json(['error' => 'Employee reporting details not found'], 404);
        }

        $RId = $employeeReporting->AppraiserId ?? 0;
        $HId = $employeeReporting->HodId ?? 0;
        $HtId = $employeeReporting->HodId ?? 0;

        $ReqTime = date("H:i:00");
        $CrTime = date("H:i:s");

        // Get current day's in-time setting from database
        $dv = intval(date("d"));
        $inTimeQuery = \DB::table('hrm_employee_attendance_settime')
            ->where('EmployeeID', $request->employeeid)
            ->first(['I'.$dv]);

        $InTime = $inTimeQuery ? date("H:i:00", strtotime($inTimeQuery->{'I'.$dv})) : '00:00:00';
        $date = new DateTime($request->requestDate);
        $formattedDate = $date->format('Y-m-d');
    
        // Insert request into database
        \DB::table('hrm_employee_attendance_req')->insert([
            'EmployeeID' => $request->employeeid,
            'AttDate' => $formattedDate,
            'InReason' => $request->reasonI,
            'InRemark' => $request->remarkI,
            'OutReason' => $request->reasonO ??'',
            'OutRemark' => $request->remarkO ??'',
            'Reason' => $request->reason ?? '',
            'Remark' => $Remark ??'',
            'RId' => $RId,
            'HId' => $HId,
            'HtId' => $HtId,
            'InR' => $InR,
            'OutR' => $OutR,
            'ReqDate' => now()->format('Y-m-d'),
            'ReqTime' => $ReqTime,
            'CrDate' => now()->format('Y-m-d'),
            'CrTime' => $CrTime,
        ]);
        exit;

        return redirect()->back()->with('success', 'Attendance request submitted successfully.');
    }

}
