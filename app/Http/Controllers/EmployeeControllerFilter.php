<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeControllerFilter extends Controller
{
    public function index()
    {
        return view('employee-eligibilityfilte');
    }

    public function checkEligibility(Request $request)
    {
        $request->validate([
            'joining_date' => 'required|date',
            'fixed_salary' => 'required|numeric|min:0',
            'variable_pay' => 'required|numeric|min:0',
        ]);

        $joiningDate = strtotime($request->input('joining_date'));
        $startOfYear = strtotime(date('Y') . '-01-01');
        $startOfFinancialYear = strtotime(date('Y') . '-04-01');

        // Determine Salary Structure (Calendar Year or Financial Year)
        if ($joiningDate < strtotime('2025-01-01')) {
            $salaryStructure = 'Calendar Year';
        } else {
            $salaryStructure = 'Financial Year';
        }

        // Calculate eligibility
        $fixedSalary = $request->input('fixed_salary');
        $variablePay = $request->input('variable_pay');
        $totalSalary = $fixedSalary + $variablePay;

        $eligible = $totalSalary >= 50000; // Example eligibility condition

        return view('employee-eligibilityfilte', compact('salaryStructure', 'eligible', 'totalSalary', 'fixedSalary', 'variablePay'));
    }
}
