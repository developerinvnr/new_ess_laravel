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
            'employeephoto'
        )->where(
                'EmployeeID',
                $request->employeeid
            )->first();
        $minEmployeeIdLength = ($employee && $employee->VCode == 'V') ? 4 : 3;
        $request->validate([
            'employeeid' => 'required|min:' . $minEmployeeIdLength,
            'password' => 'required|min:6',
        ]);

        if ($employee && Hash::check( $request->password, $employee->EmpPass)) {
            // Authentication by Employee ID
            // $remember = $request->has('remember'); 
            // Auth::loginUsingId($employee->EmployeeID, $remember);
            Auth::login($employee, $request->has('remember'));
            // Set a session variable for the first login
            // if (!$request->session()->has('first_login')) {
            //     $request->session()->put('first_login', true);
            // }
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
        return redirect('/login');
    }
    public function showforgotpasscode()
    {
        return view('auth.forgotpassword');
    }

}
