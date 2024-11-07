<?php

namespace App\Http\Controllers\CronManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApplicationMail; // Make sure to import your mail class
use Dcblogdev\LaravelSentEmails\Models\SentEmail;

class CronLeaveController extends Controller
{
    public function checkBackdatedLeaves()
    {
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        // Fetch leave applications with back_date_flag = 1
        $leaveApplications = \DB::table('hrm_employee_applyleave')
            ->where('back_date_flag', 1)
            ->whereColumn('Apply_FromDate', '<=', 'Apply_Date')
            ->get();

        foreach ($leaveApplications as $application) {
            $applyFromDate = Carbon::parse($application->Apply_FromDate);
            $threeDaysLater = $applyFromDate->copy()->addDays(3);

            if ($applyFromDate->month == $currentMonth && $applyFromDate->year == $currentYear) {
                if ($application->LeaveStatus == 0 && $application->LeaveAppStatus == 0) {
                    if ($today->isAfter($threeDaysLater)) {
                        $HodId = \DB::table('hrm_employee_reporting')
                            ->where('EmployeeID', $application->EmployeeID)
                            ->value('HodId');

                        \DB::table('hrm_employee_applyleave')
                            ->where('EmployeeID', $application->EmployeeID)
                            ->where('back_date_flag', 1)
                            ->update(['Apply_SentToHOD' => $HodId]);

                        // Fetch HOD's email
                        $hoid = \DB::table('hrm_employee_general')
                            ->where('EmployeeID', $HodId)
                            ->value('EmailId_Vnr');
                           
                        // Send email if HOD email is found
                        if ($hoid) {
                            $leaveData = [
                    
                                'Reason'=>'Action was not performed', 
                            
                            ];
                            Mail::to($hoid)->send(new LeaveApplicationMail($leaveData));
                           
                            // Record the sent email
                            SentEmail::create([
                                'employee_id' => $application->EmployeeID,
                                'to' => $hoid,
                                'subject' => 'Leave Application Submitted',
                                'body' => json_encode($leaveData), // You can customize the body as needed
                                'sent_at' => now(),
                            ]);

                            Log::info('Email sent successfully to: ' . $hoid);
                        }
                    }
                }
            }
        }

        // Fetch leave applications with back_date_flag = 1 and Apply_FromDate > Apply_Date
        $leaveApplications_after = \DB::table('hrm_employee_applyleave')
            ->where('back_date_flag', 1)
            ->whereColumn('Apply_FromDate', '>', 'Apply_Date')
            ->get();

        foreach ($leaveApplications_after as $application) {
            $applyFromDate = Carbon::parse($application->Apply_FromDate);
            $lastDayOfMonth = $applyFromDate->copy()->endOfMonth();
            $lastTwoDays = [
                $lastDayOfMonth->copy()->subDays(1), // Last day minus one
                $lastDayOfMonth // Last day itself
            ];

            $updateDate = null;

            if (in_array($applyFromDate->toDateString(), array_map(fn($date) => $date->toDateString(), $lastTwoDays))) {
                if ($applyFromDate->isSameDay($lastDayOfMonth)) {
                    $updateDate = $applyFromDate->copy()->addDays(1);
                } elseif ($applyFromDate->isSameDay($lastDayOfMonth->copy()->subDays(1))) {
                    $updateDate = $applyFromDate->copy()->addDays(2);
                }
            }

            if ($updateDate) {

                $HodId = \DB::table('hrm_employee_reporting')
                    ->where('EmployeeID', $application->EmployeeID)
                    ->value('HodId');

                \DB::table('hrm_employee_applyleave')
                    ->where('EmployeeID', $application->EmployeeID)
                    ->update(['Apply_SentToHOD' => $HodId]);

                // Fetch HOD's email
                $hoid = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', $HodId)
                    ->value('EmailId_Vnr');
                 
                // Send email if HOD email is found
                if ($hoid) {
                    $leaveData = [
                    
                        'Reason'=>'Action was not performed', 
                    
                    ];
                    Mail::to($hoid)->send(new LeaveApplicationMail($leaveData));

                  
                    // Record the sent email
                    SentEmail::create([
                        'employee_id' => $application->EmployeeID,
                        'to' => $hoid,
                        'subject' => 'Leave Application Submitted',
                        'body' => json_encode($leaveData),
                        'sent_at' => now(),
                    ]);

                    Log::info('Email sent successfully to: ' . $hoid);
                }
            }
        }

        return 'Leave applications checked and statuses updated.';
    }
}
