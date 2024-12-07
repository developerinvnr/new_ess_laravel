<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExitInterviewController extends Controller
{
    public function exitinterviewform(){
        
        $separationRecord = \DB::table('hrm_employee_separation')->where('EmployeeID', Auth::user()->EmployeeID)->first();
        if ($separationRecord) {
            return view("seperation.exitinterviewform");
        }
        return view("employee.exitinterviewform");
    }
}
