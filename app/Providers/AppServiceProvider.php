<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\MailSentListener;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */ protected $listen = [
        MessageSent::class => [
            MailSentListener::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    // Share the $exists and $assets_request variables to all views except the root route (/)
    View::composer('*', function ($view) {
        // Exclude the root route ("/") by checking the current route's URI
        if (request()->is('/')) {
            return; // Don't share variables for the root route (login page)
        }

        // Fetch the employee ID from the authenticated user
        $employeeId = Auth::user()->EmployeeID;

        // Check if the employee exists and is active
        $exists = DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID')
            ->where('hrm_employee.EmployeeID', $employeeId)
            ->where('hrm_employee.EmpStatus', 'A')
            ->whereNotNull('hrm_employee_general.RepEmployeeID')
            ->exists();

        // Fetch asset requests based on the employee's role (Reporting, Hod, IT, Acc)
        $assets_request = DB::table('hrm_asset_employee_request')
            ->where(function ($query) use ($employeeId) {
                $query->where('ReportingId', $employeeId)
                    ->orWhere('HodId', $employeeId);
            })
            ->when(true, function ($query) use ($employeeId) {
                $query->orWhere(function ($subQuery) use ($employeeId) {
                    $subQuery->where('ITId', $employeeId)
                        ->where('HODApprovalStatus', 1); // Include ITId only when HODApprovalStatus = 1
                });
            })
            ->when(true, function ($query) use ($employeeId) {
                $query->orWhere(function ($subQuery) use ($employeeId) {
                    $subQuery->where('AccId', $employeeId)
                        ->where('HODApprovalStatus', 1)
                        ->where('ITApprovalStatus', 1); // Include AccId only when HODApprovalStatus = 1 and ITApprovalStatus = 1
                });
            })
            ->get();

        // Loop through the asset requests to fetch the associated employee name based on EmployeeID
        foreach ($assets_request as $request) {
            $employee = DB::table('hrm_employee')->where('EmployeeID', $request->EmployeeID)->first();
            $employeeName = $employee ? $employee->Fname . ' ' . $employee->Sname . ' ' . $employee->Lname : 'N/A';
            $request->employee_name = $employeeName;
        }

        // Share the $exists and $assets_request variables with all views except the root route
        $view->with([
            'exists' => $exists,
            'assets_request' => $assets_request,
        ]);
    });
}



    
}
