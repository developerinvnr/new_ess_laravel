<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function salary(){
        return view("employee.salary");
    }
    public function eligibility(){
        return view("employee.eligibility");
    }
    public function ctc(){
        return view("employee.ctc");
    }
    public function investment(){
        return view("employee.investment");
    }
}
