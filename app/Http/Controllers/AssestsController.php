<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssestsController extends Controller
{
    public function assests(){
        return view("employee.assests");
    }
}
