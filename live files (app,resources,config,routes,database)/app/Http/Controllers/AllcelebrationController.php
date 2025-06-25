<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllcelebrationController extends Controller
{
    public function allcelebration(){
        return view("employee.allcelebration");
    }
}
