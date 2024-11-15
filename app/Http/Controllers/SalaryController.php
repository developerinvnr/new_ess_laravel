<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaySlip;
use App\Models\EmployeeEligibility;
use App\Models\EmployeeCTC;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function salary()
    {
        // Get the authenticated user's EmployeeID
        $employeeID = Auth::user()->EmployeeID;

        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $salaryData = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->join('hrm_employee_personal', 'hrm_employee.EmployeeID', '=', 'hrm_employee_personal.EmployeeID')
            ->join('hrm_company_basic', 'hrm_employee.CompanyID', '=', 'hrm_company_basic.CompanyID')  // Join with company table
            ->join('hrm_costcenter', 'hrm_employee_general.CostCenter', '=', 'hrm_costcenter.CostCenterId') // Join with costcenter table
            ->join('hrm_state', 'hrm_costcenter.CostCenterId', '=', 'hrm_state.StateId') // Join with state table
            ->join('hrm_designation', 'hrm_employee_general.DesigId', '=', 'hrm_designation.DesigId') // Join with costcenter table
            ->join('hrm_department', 'hrm_employee_general.DepartmentId', '=', 'hrm_department.DepartmentId') // Join with state table
            ->join('hrm_grade', 'hrm_employee_general.GradeId', '=', 'hrm_grade.GradeId') // Join with state table
            ->join('hrm_headquater', 'hrm_employee_general.HqId', '=', 'hrm_headquater.HqId') // Join with state table
            ->where('hrm_employee.EmployeeID', $employeeID)
            ->first(); // Fetching the first record

        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $payslipData = PaySlip::where('EmployeeID', $employeeID)
            ->get();
             // Define month names
            $months = [
                1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR', 5 => 'MAY', 
                6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
                11 => 'NOV', 12 => 'DEC'
            ];

            // Define payment heads (the attribute names in your payslip data)
            $paymentHeads = [
                'Basic' => 'Basic', 
                'House Rent Allowance' => 'Hra', 
                'Special Allowance' => 'Special', 
                'Bonus' => 'Bonus', 
                'Gross Earning' => 'Tot_Gross', 
                'Provident Fund' => 'Tot_Pf', 
                'Gross Deduction' => 'Tot_Deduct', 
                'Net Amount' => 'netPayAmount'
            ];
           
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetch the payslip data for the current month, filtered by EmployeeID
            $payslipDataMonth = PaySlip::where('EmployeeID', $employeeID)
                ->where('Month', $currentMonth)  // Filter by current month
                ->where('Year', $currentYear)     // Filter by current year
                ->first();
        // Return the data to the view
        return view('employee.salary', compact('salaryData' ,'payslipData','payslipDataMonth','months', 'paymentHeads'));
    }
    public function eligibility()
    {
        $employeeID = Auth::user()->EmployeeID;
        $eligibility = EmployeeEligibility::where('EmployeeID', $employeeID)
        ->where('Status', 'A')
        ->first();
        return view('employee.eligibility', compact('eligibility'));
    }
    public function ctc()
    { 
        $employeeID = Auth::user()->EmployeeID;
        $ctc = EmployeeCTC::where('EmployeeID', $employeeID)
        ->where('Status', 'A')
        ->first();
        return view("employee.ctc",compact('ctc'));
    }
    public function investment()
    {
        return view("employee.investment");
    }
    public function annualsalary()
    {
        $employeeID = Auth::user()->EmployeeID;

        $months = [
            1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR', 5 => 'MAY', 
            6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
            11 => 'NOV', 12 => 'DEC'
        ];

        // Define payment heads (the attribute names in your payslip data)
        $paymentHeads = [
            'Basic' => 'Basic', 
            'House Rent Allowance' => 'Hra', 
            'Special Allowance' => 'Special', 
            'Bonus' => 'Bonus_Month', 
            'Gross Earning' => 'Tot_Gross', 
            'Provident Fund' => 'Tot_Pf', 
            'Gross Deduction' => 'Tot_Deduct', 
            'Net Amount' => 'Tot_NetAmount'
        ];
        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $payslipData = PaySlip::where('EmployeeID', $employeeID)
            ->get();
        return view("employee.annualsalary",compact('payslipData','months','paymentHeads'));
    }
}
