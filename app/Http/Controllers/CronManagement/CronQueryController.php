<?php

namespace App\Http\Controllers\CronManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CronQueryController extends Controller
{
    public function queryforwardtolevels()
{
    // Fetch the queries that need to be forwarded (i.e., where it's past the 3-day or 6-day limit)
    $currentYear = Carbon::now()->year;

    // Fetch the queries that need to be forwarded, from the current year
    $queries = DB::table('hrm_employee_queryemp')
        ->whereNotNull('QueryDT') // Ensure 'QueryDT' is not null
        ->where('QStatus', '=', 0) // Ensure QStatus is 0
        ->whereYear('QueryDT', $currentYear) // Filter by the current year
        ->get(); 
    foreach ($queries as $query) {
        $createdAt = Carbon::parse($query->QueryDT);

        // Add 3 days and check for any Sundays in between
        $threeDaysLater = $this->addDaysSkippingSundays($createdAt, 3);

        $sixDaysLater = $this->addDaysSkippingSundays($createdAt, 6);

        // Get the current date
        $now = Carbon::now();

        // Fetch the AssignEmpId (who is the person assigned to handle this query)
        $assignEmpId = $query->AssignEmpId;

        // Find ReviewerId and HodId from hrm_employee_reporting based on AssignEmpId (EmployeeID)
        $employeeReporting = DB::table('hrm_employee_reporting')
            ->where('EmployeeID', $assignEmpId)
            ->first();

        if ($employeeReporting) {
            $reviewerId = $employeeReporting->ReviewerId;
            $hodId = $employeeReporting->HodId;

            // If 3 days passed, update the query to forward it to ReviewerId
            if ($now->greaterThanOrEqualTo($threeDaysLater)) {
                DB::table('hrm_employee_queryemp')
                    ->where('QueryId', $query->QueryId)
                    ->update([
                        'AssignEmpId' => $reviewerId,
                        'Level_2ID' => $reviewerId,
                        'Level_2QToDT' => $now,
                    ]);

                // Log action or other necessary operations
                \Log::info('Query forwarded to ReviewerId ' . $reviewerId);
            }

            // If 6 days passed (from created_at), update the query to forward it to HodId
            if ($now->greaterThanOrEqualTo($sixDaysLater)) {
                DB::table('hrm_employee_queryemp')
                    ->where('QueryId', $query->QueryId)
                    ->update([
                        'AssignEmpId' => $hodId,
                        'Level_3ID' => $hodId,
                        'Level_3QToDT' => $now,
                    ]);

                // Log action or other necessary operations
                \Log::info('Query forwarded to HodId ' . $hodId);
            }
        }
    }

    return 'Query forward check completed.';
}

// Helper function to add days while skipping Sundays
private function addDaysSkippingSundays(Carbon $startDate, $daysToAdd)
{
    $date = $startDate;
    while ($daysToAdd > 0) {
        $date->addDay(); // Increment by 1 day
        // If it's not a Sunday, count the day
        if ($date->dayOfWeek !== Carbon::SUNDAY) {
            $daysToAdd--;
        }
    }
    return $date;
}
}
