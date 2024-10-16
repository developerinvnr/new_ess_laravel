<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::where('Year', date("Y"))
            ->where('status', 'A')
            ->orderBy('HolidayDate', 'ASC')
            ->get();

        return view('employee.leave', compact('holidays'));
    }
}
