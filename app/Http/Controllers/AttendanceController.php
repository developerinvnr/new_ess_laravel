<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;


class AttendanceController extends Controller
{
    public function attendanceView()
    {
        return view('employee.leave');
    }
    public function getAttendance($year, $month, $employeeId)
{
    // Retrieve the employee data along with their attendance records
    $attendanceData = Employee::with('employeeAttendance')
        ->where('EmployeeID', $employeeId)
        ->first(); // Use first() to get a single record

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
                $formattedAttendance[] = $attendance;
            }
        }
    }
   
    return response()->json($formattedAttendance);
}


}
