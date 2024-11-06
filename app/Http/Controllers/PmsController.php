<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PmsController extends Controller
{
    public function pms(){
        return view("employee.pms");
    }
    public function appraiser(){
        return view("employee.appraiser");
    }
    public function reviewer(){
        return view("employee.reviewer");
    }
    public function hod(){
        return view("employee.hod");
    }
    public function management(){
        return view("employee.management");
    }
}
