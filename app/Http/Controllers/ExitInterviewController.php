<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExitInterviewController extends Controller
{
    public function exitinterviewform(){
        return view("employee.exitinterviewform");
    }
}
