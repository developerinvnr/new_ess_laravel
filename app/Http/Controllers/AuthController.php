<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login & logout
    public function login(Request $request)
    {
        // Retrieve the employee data based on the employeeid
        $employee = Employee::where('EmployeeID', $request->employeeid)->first();

        // If the employee exists, dynamically set the min length
        $minEmployeeIdLength = ($employee && $employee->VCode == 'V') ? 4 : 3;

        // validation
        $request->validate([
            'employeeid' => 'required|min:' . $minEmployeeIdLength,
            'password' => 'required|min:6',
        ]);
        if ($employee && Hash::check($request->password, $employee->EmpPass)) {
            //Authentication by Employee ID
            Auth::loginUsingId($employee->EmployeeID);
        
            // Redirect to the dashboard after successful login
            return view('employee.dashboard');
        }
        //show error message if condition doesnot satisfy
        return back()->withErrors([
            'EmployeeID' => 'The provided credentials do not match our records.',
        ]);
    }

    
    public function logout(Request $request)
    {
            Auth::logout(); 
            // Session::flush();
            // Redirect::back();
            // Cache::flush();
            return redirect('/login'); 
    }
}
