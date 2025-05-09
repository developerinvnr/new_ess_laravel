<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImpactController extends Controller
{
    public function impact(){
        return view("employee.allimpact");
    }
}
