<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Qualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    // Handle Authentication 
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
       
        // Retrieve the employee data based on the employeeid with designation name
        $employee = Employee::with(
            'stateDetails',
            'designation',
            'employeeGeneral',
            'department',
            'departments',
            'departmentsWithQueries',
            'grade',
            'personaldetails',
            'reportingdesignation',
            'contactDetails',
            'cityDetails',
            'parcityDetails',
            'parstateDetails',
            'familydata',
            'qualificationsdata',
            'languageData',
            'companyTrainingTitles',
            'employeeExperience',
            'employeephoto',
            'attendancedata',
            'queryMap',
            'employeeAttendance',
            'employeeleave'
        )->where(
                'EmployeeID',
                $request->employeeid
            )->first();
        $minEmployeeIdLength = ($employee && $employee->VCode == 'V') ? 4 : 2;
        $request->validate([
            'employeeid' => 'required|min:' . $minEmployeeIdLength,
            'password' => 'required|min:6',
        ]);

        if ($employee && Hash::check( $request->password, $employee->EmpPass)) {
        
            Auth::login($employee, $request->has('remember'));
            // Set a session variable for the first login
            // if (!$request->session()->has('first_login')) {
            //     $request->session()->put('first_login', true);
            // }
            $hierarchy = $employee->getReportingHierarchy($employee->EmployeeID);
            session(['employee_hierarchy' => $hierarchy]);
            return redirect('/dashboard');
        }

        // Show error message if condition does not satisfy
        return back()->withErrors([
            'EmployeeID' => 'The provided credentials do not match our records.',
        ]);
    }
    public function dashboard()
    {
        return view('employee.dashboard'); // Adjust the view name as needed
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        Cache::flush();
        return redirect('/');
    }
    public function showforgotpasscode()
    {
        return view('auth.forgotpassword');
    }

    public function change_password_view()
    {
        return view('auth.changepasswordview');
    }
    public function changePassword(Request $request)
    {
        $request->validate(rules: [
            'current_password' => ['required','string','min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->EmpPass);
        if($currentPasswordStatus){

            Employee::findOrFail(Auth::user()->EmployeeID)->update([
                'EmpPass' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('message','Password Updated Successfully');

        }else{

            return redirect()->back()->with('message','Current Password does not match with Old Password');
        }
    }
    public function leaveBalance($employeeId)
{
    $monthName = now()->format('F');

    $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance as leave')
    ->join('hrm_month as month', 'leave.Month', '=', 'month.MonthId')
    ->select('leave.*', 'month.*') // Select all columns from both tables
    ->where('leave.EmployeeID', $employeeId)
    ->where('month.MonthName', $monthName) // Match with the month name
    ->where('leave.Year', now()->year) // Current year
    ->first();


    // Check if leaveBalance exists
    if ($leaveBalance) {
        return response()->json([
            'casualLeave' => [
                'used' => $leaveBalance->AvailedCL,
                'balance' => $leaveBalance->BalanceCL,
                'percentage' => $leaveBalance->CreditedCL > 0 ? ($leaveBalance->AvailedCL / $leaveBalance->CreditedCL) * 100 : 0,
            ],
            'sickLeave' => [
                'used' => $leaveBalance->AvailedSL,
                'balance' => $leaveBalance->BalanceSL,
                'percentage' => $leaveBalance->CreditedSL > 0 ? ($leaveBalance->AvailedSL / $leaveBalance->CreditedSL) * 100 : 0,
            ],
            'privilegeLeave' => [
                'used' => $leaveBalance->AvailedPL,
                'balance' => $leaveBalance->BalancePL,
                'percentage' => $leaveBalance->CreditedPL > 0 ? ($leaveBalance->AvailedPL / $leaveBalance->CreditedPL) * 100 : 0,
            ],
            'earnedLeave' => [
                'used' => $leaveBalance->AvailedEL,
                'balance' => $leaveBalance->BalanceEL,
                'percentage' => $leaveBalance->CreditedEL > 0 ? ($leaveBalance->AvailedEL / $leaveBalance->CreditedEL) * 100 : 0,
            ],
            'festivalLeave' => [
                'used' => $leaveBalance->AvailedOL, // Assuming OpeningOL is used for festival leave
                'balance' => $leaveBalance->BalanceOL,
                'percentage' => $leaveBalance->CreditedOL > 0 ? ($leaveBalance->AvailedOL / $leaveBalance->CreditedOL) * 100 : 0,
            ],
        ]);
    } else {
        // Handle case where no leave balance data is found
        return response()->json(['error' => 'No leave balance data found'], 404);
    }
}



}
