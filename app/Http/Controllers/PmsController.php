<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PmsController extends Controller
{
    public function pms(){
        return view("employee.pms");
    }
    public function appraisal(){
        return view("employee.appraisal");
    }
    public function reviewer(){
        return view("employee.reviewer");
    }
}
