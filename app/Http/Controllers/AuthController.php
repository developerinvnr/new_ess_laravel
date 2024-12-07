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
            'employeeleave',
            'employeePaySlip',
            'employeeAttendanceRequest',
            'employeeAssetReq',
            'employeeAssetOffice',
            'employeeAssetvehcileReq',
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
            $separationRecord = \DB::table('hrm_employee_separation')->where('EmployeeID', $employee->EmployeeID)->first();
            if ($separationRecord) {
                return redirect('/seperation');  // Redirect to the separation page
            }
            $hierarchy = $employee->getReportingHierarchy($employee->EmployeeID);
            session(['employee_hierarchy' => $hierarchy]);
            return redirect('/dashboard');
        }
        // if ($employee && Hash::check($request->password, $employee->EmpPass)) {
        //     // Log the user in
        //     Auth::login($employee, $request->has('remember'));
    
        //     // // Set session variables, e.g., for reporting hierarchy
        //     // $hierarchy = $employee->getReportingHierarchy($employee->EmployeeID);
        //     // session(['employee_hierarchy' => $hierarchy]);
    
        //     // Check the value of ProfileCertify and hrm_opinion data
        //     if (Auth::user()->ProfileCertify == 'N') {
        //         // Redirect to a specific view for ProfileCertify = 'N'
        //         return redirect()->route('another.view');  // Replace with the actual route for this view
        //     }
        //     if (Auth::user()->ChangePwd == 'N') {
        //         // Redirect to a specific view for ProfileCertify = 'N'
        //         return view('auth.changepasswordview');  // Replace with the actual route for this view
        //     }
    
        //     // Check if ProfileCertify is 'Y' and if there is data in hrm_opinion
        //     $hasHrmOpinionData = \DB::table('hrm_opinion')->where('employee_id', Auth::user()->EmployeeID)->exists();
    
        //     if (Auth::user()->ProfileCertify == 'Y') {
        //         if ($hasHrmOpinionData) {
        //             // Redirect to the dashboard if ProfileCertify = 'Y' and there is data in hrm_opinion
        //             return redirect('/dashboard');
        //         } else {
        //             // Redirect to another view if ProfileCertify = 'Y' but no data in hrm_opinion
        //             return redirect()->route('another.view');  // Replace with the actual route for this view
        //         }
        //     }
        // }

        // Show error message if condition does not satisfy
        return back()->withErrors([
            'EmployeeID' => 'The provided credentials do not match our records.',
        ]);
    }
    public function dashboard()
    {
        
        return view('employee.dashboard'); // Adjust the view name as needed
    }
    public function seperation()
    {
        
        return view('seperation.dashboard'); // Adjust the view name as needed
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

            $employee = Employee::findOrFail(Auth::user()->EmployeeID);

            // Update the password and change password flag
            $employee->update([
                'EmpPass' => Hash::make($request->password), // Hashing the password before saving
                //'ChangePwd' => 'Y' // Mark as password changed
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
