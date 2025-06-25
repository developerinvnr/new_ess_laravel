<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use DB;

class AttAppController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('Y', date('Y'));
        $month = $request->input('m', date('m'));
        $day = $request->input('da', date('d'));
        $employeeId = $request->input('ee', 0);

        // Fetch employees
        $employees = Employee::where('EmpStatus', 'A')
                             ->where('RepEmployeeID', Auth::user()->EmployeeID)
                             ->get();

        // Query to get reports
        $t = date('t', strtotime("{$year}-{$month}-01"));
        $econd = ($employeeId == 0) ? '1=1' : "e.EmployeeID={$employeeId}";

        $reports = DB::table('hrm_employee_moreve_report_'.$year.' as r')
                     ->join('hrm_employee as e', 'r.EmployeeID', '=', 'e.EmployeeID')
                     ->join('hrm_employee_general as g', 'r.EmployeeID', '=', 'g.EmployeeID')
                     ->join('hrm_employee_personal as p', 'r.EmployeeID', '=', 'p.EmployeeID')
                     ->where('g.RepEmployeeID', Auth::user()->EmployeeID)
                     ->where('e.EmpStatus', 'A')
                     ->whereRaw($econd)
                     ->whereBetween('r.MorEveDate', ["{$year}-{$month}-01", "{$year}-{$month}-{$t}"])
                     ->orderBy('e.EmpCode')
                     ->get();

        // Pass data to view
        return view('teamdailyreports.index', compact('reports', 'employees', 'year', 'month', 'day', 'employeeId'));
    }
}
