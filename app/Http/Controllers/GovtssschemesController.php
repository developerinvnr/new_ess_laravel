<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GovtssschemesController extends Controller
{
    public function govtssschemes(){
        return view("employee.govtssschemes");
    }
}
