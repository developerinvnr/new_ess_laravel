<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaySlip;
use App\Models\EmployeeEligibility;
use App\Models\EmployeeCTC;
use App\Models\HrmYear;
use App\Models\InvestmentDeclaration;
use App\Models\InvestmentSubmission;

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
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
            $payslipData = PaySlip::where('EmployeeID', $employeeID)
            ->where('Status', 'A')  // Correctly use whereIn for LeaveStatus
            ->where('Year', $currentYear)     // Filter by current year
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
                'Net Amount' => 'netPayAmount',
                'CONVEYANCE ALLOWANCE'=>'Convance',
                'TRANSPORT ALLOWANCE'=>'TA',
                'DA'=>'DA',
                'LEAVE ENCASH'=>'LeaveEncash',
                'ARREARS'=>'Arreares',
                'INCENTIVE'=>'Incentive',
                'VARIABLE ADJUSTMENT'=>'VariableAdjustment',
                'PERFORMANCE PAY'=>'PerformancePay',
                'NATIONAL PENSION SCHEME'=>'NPS',
                'NOTICE PAY'=>'NoticePay',
                'PERFORMANCE INCENTIVE'=>'PP_Inc',
                'CITY COMPENSATORY ALLOWANCE'=>'CCA',
                'RELOCATION ALLOWANCE'=>'RA',
                'VARIABLE REIMBURSEMENT'=>'VarRemburmnt',
                'CAR ALLOWANCE'=>'Car_Allowance',
                'ARREAR FOR CAR ALLOWANCE'=>'Car_Allowance_Arr',
                'ARREAR FOR BASIC'=>'Arr_Basic',
                'ARREAR FOR HOUSE RENT ALLOWANCE'=>'Arr_Hra',
                'ARREAR FOR SPECIAL ALLOWANCE'=>'Arr_Spl',
                'ARREAR FOR CONVEYANCE'=>'Arr_Conv',
                'ARREAR FOR BONUS'=>'Arr_Bonus',
                'BONUS ADJUSTMENT'=>'Bonus_Adjustment',
                'ARREAR FOR LTA REIMBU'=>'Arr_LTARemb',
                'ARREAR FOR RELOCATION ALLOWANCE'=>'Arr_RA',
                'ARREAR FOR PERFORMANCE PAY'=>'Arr_PP',
                'ARREAR FOR LV-ENCASH'=>'Arr_LvEnCash',
                'CHILD EDUCATION ALLOWANCE'=>'YCea',
                'MEDICAL REIMBURSEMENT'=>'YMr',
                'LEAVE TRAVEL ALLOWANCE'=>'YLta' ,
                
                'TDS'=>'TDS',
                'ESIC'=>'ESCI_Employee',
                'NPS Contribution'=>'NPS_Value',
                'ARREAR PF'=>'Arr_Pf',
                'ARREAR ESIC'=>'Arr_Esic',
                'VOLUNTARY CONTRIBUTION'=>'VolContrib',
                'DEDUCTION ADJUSTMENT'=>'DeductAdjmt',
                'RECOVERY CONVENYANCE ALLOWANCE'=>'RecConAllow',
                'RELOCATION ALLOWANCE RECOVERY'=>'RA_Recover',
                'RECOVERY SPECIAL ALLOWANCE'=>'RecSplAllow',
            ];
            
           
         

            // Fetch the payslip data for the current month, filtered by EmployeeID
            $payslipDataMonth = PaySlip::where('EmployeeID', $employeeID)
                ->where('Month', $currentMonth)  // Filter by current month
                ->where('Year', $currentYear)     // Filter by current year
                ->first();
        // Return the data to the view
        return view('employee.salary', compact('salaryData' ,'payslipData','payslipDataMonth','months', 'paymentHeads'));
    }
//     public function salary(Request $request)
//     // {
//     //     // If the password is not submitted, show the password verification form
//     //     if (!$request->has('password')) {
//     //         return view('employee.verify-password');
//     //     }

//     // Validate the password input
//     // $request->validate([
//     //     'password' => 'required|string',
//     // ]);

//     // Get the currently authenticated user
//     $employee = Auth::user();

//     // Decrypt the stored password (assuming it is encrypted in the database)
//     // If your password is not encrypted in the database, this can be replaced with direct comparison
//     if (decrypt($employee->EmpPass) !== $request->password) {
//         return redirect()->route('salary')->withErrors(['password' => 'Incorrect password. Please try again.']);
//     }

//     // Get the authenticated user's EmployeeID
//     $employeeID = $employee->EmployeeID;

//     // Fetch salary data by joining the necessary tables using EmployeeID
//     $salaryData = \DB::table('hrm_employee')
//         ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
//         ->join('hrm_employee_personal', 'hrm_employee.EmployeeID', '=', 'hrm_employee_personal.EmployeeID')
//         ->join('hrm_company_basic', 'hrm_employee.CompanyID', '=', 'hrm_company_basic.CompanyID')
//         ->join('hrm_costcenter', 'hrm_employee_general.CostCenter', '=', 'hrm_costcenter.CostCenterId')
//         ->join('hrm_state', 'hrm_costcenter.CostCenterId', '=', 'hrm_state.StateId')
//         ->join('hrm_designation', 'hrm_employee_general.DesigId', '=', 'hrm_designation.DesigId')
//         ->join('hrm_department', 'hrm_employee_general.DepartmentId', '=', 'hrm_department.DepartmentId')
//         ->join('hrm_grade', 'hrm_employee_general.GradeId', '=', 'hrm_grade.GradeId')
//         ->join('hrm_headquater', 'hrm_employee_general.HqId', '=', 'hrm_headquater.HqId')
//         ->where('hrm_employee.EmployeeID', $employeeID)
//         ->first();

//     // Fetch payslip data
//     $payslipData = PaySlip::where('EmployeeID', $employeeID)->get();

//     // Define month names
//     $months = [
//         1 => 'JAN', 2 => 'FEB', 3 => 'MAR', 4 => 'APR', 5 => 'MAY', 
//         6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
//         11 => 'NOV', 12 => 'DEC'
//     ];

//     // Define payment heads
//     $paymentHeads = [
//         'Basic' => 'Basic', 
//         'House Rent Allowance' => 'Hra', 
//         'Special Allowance' => 'Special', 
//         'Bonus' => 'Bonus', 
//         'Gross Earning' => 'Tot_Gross', 
//         'Provident Fund' => 'Tot_Pf', 
//         'Gross Deduction' => 'Tot_Deduct', 
//         'Net Amount' => 'netPayAmount'
//     ];

//     // Get current month and year
//     $currentMonth = Carbon::now()->month;
//     $currentYear = Carbon::now()->year;

//     // Fetch payslip data for the current month
//     $payslipDataMonth = PaySlip::where('EmployeeID', $employeeID)
//         ->where('Month', $currentMonth)
//         ->where('Year', $currentYear)
//         ->first();

//     // Return the salary view with data
//     return view('employee.salary', compact('salaryData', 'payslipData', 'payslipDataMonth', 'months', 'paymentHeads'));
// }

    
    public function eligibility()
    {
        $employeeID = Auth::user()->EmployeeID;
        $eligibility = EmployeeEligibility::where('EmployeeID', $employeeID)
        ->where('Status', 'A')
        ->first();
        return view('employee.eligibility', compact('eligibility'));
    }
    
    public function getEligibilityData($employeeID)
    {
        $eligibility = EmployeeEligibility::where('EmployeeID', $employeeID)
        ->where('Status', 'A')
        ->first();
      
        // Check if the data exists
        if (!$eligibility) {
            // Return an error response if no data is found
            return response()->json(['error' => 'Eligibility data not found'], 404);
        }

        // Return the eligibility data as JSON
        return response()->json($eligibility);    
    }
    public function getCtcData($employeeID)
    {
        // Fetch the data for the given CTC ID using Eloquent
        // $ctc = EmployeeCTC::where('EmployeeID', $employeeID)
        // ->where('Status', 'A')
        // ->first();
        // // Check if data exists
        // if (!$ctc) {
        //     return response()->json(['error' => 'CTC data not found'], 404);
        // }

        // // Return the CTC data as JSON
        // return response()->json($ctc);
        // Fetch the CTC data for the given EmployeeID
$ctc = EmployeeCTC::where('EmployeeID', $employeeID)
->where('Status', 'A')
->first();

// Check if CTC data exists
if (!$ctc) {
return response()->json(['error' => 'CTC data not found'], 404);
}

// Fetch the employee data (fname, sname, lname) from the hrm_employee table
$employee = \DB::table('hrm_employee')
->where('EmployeeID', $employeeID)
->select('Fname', 'Sname', 'Lname')
->first();

// Check if employee data exists
if (!$employee) {
return response()->json(['error' => 'Employee data not found'], 404);
}

// Merge the employee data with the CTC data
$ctc->Fname = $employee->Fname;
$ctc->Sname = $employee->Sname;
$ctc->Lname = $employee->Lname;

        return response()->json($ctc);

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
        $employeeID = Auth::user()->EmployeeID;
        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $employeeData = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->join('hrm_employee_personal', 'hrm_employee.EmployeeID', '=', 'hrm_employee_personal.EmployeeID')
            ->join('hrm_company_basic', 'hrm_employee.CompanyID', '=', 'hrm_company_basic.CompanyID')  // Join with company table
            ->join('hrm_investdecl_setting_submission', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting_submission.CompanyID')  // Join with investment declaration table
            ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
            ->where('hrm_employee.EmployeeID', $employeeID)
            ->first(); // Fetching the first record

            $currentYear = date('Y');
                $nextYear = $currentYear + 1;

                // Retrieve the year record from the hrm_year table
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();
                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                // Fetch existing investment declaration for the given employee and year_id
                $investmentDeclaration = \DB::table('hrm_employee_investment_declaration')
                ->where('EmployeeID', $employeeID)
                ->where('YearId', $year_id)
                ->where('Status', 'A')
                ->first();  // Get the first record (if any)
        return view("employee.investment",compact('employeeData','investmentDeclaration'));
    }
    public function investmentsub()
    {
        $employeeID = Auth::user()->EmployeeID;
        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $employeeData = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
            ->join('hrm_employee_personal', 'hrm_employee.EmployeeID', '=', 'hrm_employee_personal.EmployeeID')
            ->join('hrm_company_basic', 'hrm_employee.CompanyID', '=', 'hrm_company_basic.CompanyID')  // Join with company table
            ->join('hrm_investdecl_setting_submission', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting_submission.CompanyID')  // Join with investment declaration table
            ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
            ->where('hrm_employee.EmployeeID', $employeeID)
            ->first(); // Fetching the first record

            $currentYear = date('Y');
                $nextYear = $currentYear + 1;

                // Retrieve the year record from the hrm_year table
                $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                    ->where('ToDate', 'like', "$nextYear-%")
                    ->first();
                if (!$yearRecord) {
                    return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
                }
                $year_id = $yearRecord->YearId;
                // Fetch existing investment declaration for the given employee and year_id
                $investmentDeclaration = \DB::table('hrm_employee_investment_declaration')
                ->where('EmployeeID', $employeeID)
                ->where('YearId', $year_id)
                ->first();  // Get the first record (if any)

        return view("employee.investmentsubmission",compact('employeeData','investmentDeclaration'));
    }
    public function annualsalary()
    {
        $employeeID = Auth::user()->EmployeeID;

        $months = [
            4 => 'APR', 5 => 'MAY', 
            6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
            11 => 'NOV', 12 => 'DEC',1 => 'JAN', 2 => 'FEB', 3 => 'MAR',
        ];

        // Define payment heads (the attribute names in your payslip data)
        $paymentHeads = [
            'Basic' => 'Basic', 
            'House Rent Allowance' => 'Hra', 
            'Special Allowance' => 'Special', 
            'Bonus' => 'Bonus_Month', 
            'PP Year' => 'PP_year', 
            'Bonus Adjustment' => 'Bonus_Adjustment', 
            'Gross Earning' => 'Tot_Gross', 
            'Provident Fund' => 'Tot_Pf_Employee', 
            'Gross Deduction' => 'Tot_Deduct', 
            'Net Amount' => 'Tot_NetAmount'
        ];
        
            // Define payment heads (the attribute names in your payslip data)
            // $paymentHeads = [
            //     'Bonus' => 'Bonus', 
            //     'Basic' => 'Basic', 
            //     'House Rent Allowance' => 'Hra', 
            //     'Special Allowance' => 'Special', 
            //     'Convance Allowance'=>'Convance',
            //     'Transport Allowance'=>'TA',
            //     'DA'=>'DA',
            //     'Leave Encash'=>'LeaveEncash',
            //     'Arreares'=>'Arreares',
            //     'Incentive'=>'Incentive',
            //     'Variable Adjustment'=>'VariableAdjustment',
            //     'Performance pay'=>'PerformancePay',
            //     'National Pension Scheme'=>'NPS',
            //     'Notice Pay'=>'NoticePay',
            //     'Performance incentive'=>'PP_Inc',
            //     'City compensatory allowance'=>'CCA',
            //     'Relocation allowance'=>'RA',
            //     'Variable REIMBURSEMENT'=>'VarRemburmnt',
            //     'CAR ALLOWANCE'=>'Car_Allowance',
            //     'ARREAR FOR CAR ALLOWANCE'=>'Car_Allowance_Arr',
            //     'ARREAR FOR BASIC'=>'Arr_Basic',
            //     'ARREAR FOR HOUSE RENT ALLOWANCE'=>'Arr_Hra',
            //     'ARREAR FOR SPECIAL ALLOWANCE'=>'Arr_Spl',
            //     'ARREAR FOR CONVEYANCE'=>'Arr_Conv',
            //     'ARREAR FOR BONUS'=>'Arr_Bonus',
            //     'BONUS ADJUSTMENT'=>'Bonus_Adjustment',
            //     'ARREAR FOR LTA REIMBU'=>'Arr_LTARemb',
            //     'ARREAR FOR RELOCATION ALLOWANCE'=>'Arr_RA',
            //     'ARREAR FOR PERFORMANCE PAY'=>'Arr_PP',
            //     'ARREAR FOR LV-ENCASH'=>'Arr_LvEnCash',
            //     'CHILD EDUCATION ALLOWANCE'=>'YCea',
            //     'MEDICAL REIMBURSEMENT'=>'YMr',
            //     'LEAVE TRAVEL ALLOWANCE'=>'YLta' ,
            //     'Gross Earning' => 'Tot_Gross', 
           

            //     'TDS'=>'TDS',
            //     'Provident Fund' => 'Tot_Pf', 
            //     'ESIC'=>'ESCI_Employee',
            //     'NPS Contribution'=>'NPS_Value',
            //     'ARREAR PF'=>'Arr_Pf',
            //     'ARREAR ESIC'=>'Arr_Esic',
            //     'VOLUNTARY CONTRIBUTION'=>'VolContrib',
            //     'DEDUCTION ADJUSTMENT'=>'DeductAdjmt',
            //     'RECOVERY CONVENYANCE ALLOWANCE'=>'RecConAllow',
            //     'RELOCATION ALLOWANCE RECOVERY'=>'RA_Recover',
            //     'RECOVERY SPECIAL ALLOWANCE'=>'RecSplAllow',

            //     'Gross Deduction' => 'Tot_Deduct', 
            //     'Net Amount' => 'netPayAmount',
            // ];
        $currentYear = date('Y');
                $nextYear = $currentYear + 1;
            $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
            ->where('ToDate', 'like', "$nextYear-%")
            ->first();
        if (!$yearRecord) {
            return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
        }
        $year_id = $yearRecord->YearId;
        // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
        $payslipData = PaySlip::where('EmployeeID', $employeeID)
                        ->where('PaySlipYearId',$year_id)
                        ->get();
                        // Initialize an array to store only non-zero payment heads


        return view("employee.annualsalary",compact('payslipData','months','paymentHeads'));
    }

    public function saveInvestmentDeclaration(Request $request)
    {
        // Retrieving input values from the request
        $employeeId = Auth::user()->EmployeeID;
        $regime = $request->selected_regime;
        $period = $request->period;
        $month = $request->c_month;
        $yearId = $request->y_id; 

        $employeeDataSetting = \DB::table('hrm_employee')
            ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
            ->where('hrm_employee.EmployeeID', $employeeId)
            ->first(); // Fetching the first record

        // Check if an investment declaration already exists for the same EmployeeID, Month, and YearId
        $existingDeclaration = \DB::table('hrm_employee_investment_declaration')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $month)
            ->where('YearId', $yearId)
            ->first();

        // Prepare data to save or update
        $data = [
            'EmployeeID' => $employeeId,
            'EC' => $request->empcode, // Assuming EmpCode is part of the request
            'Regime' => $regime,
            'Period' => $period,
            'Month' => $month,
            'Status' => 'A', // Active
            'FormSubmit' => 'Y', // Assuming form submit is Yes
            'HRA' => $request->house_rent_declared_amount,
            'Curr_Medical' => $request->medical_insurance,
            'Curr_LTA' => $request->lta_declared_amount,
            'Curr_CEA' => $request->cea_declared_amount,
            'Medical' => $request->medical_insurance,
            'LTA' => $request->lta_declared_amount,
            'CEA' => $request->cea_declared_amount,
            'MIP' => $employeeDataSetting->MIP_Limit,
            'MTI' => $employeeDataSetting->MTI_Limit,
            'MTS' => $employeeDataSetting->MTS_Limit,
            'ROL' => $employeeDataSetting->ROL_Limit,
            'Handi' => $request->handicapped_deduction,
            '80G_Per' => $employeeDataSetting->{"80G_Per_Limit"},
            'DTC' => $employeeDataSetting->DTC_Limit_Limit,
            'RP' => $request->loan_repayment,
            'DFS' => $employeeDataSetting->DFS_Limit,
            'PenFun' => $request->pension_fund_contribution,
            'LIP' => $employeeDataSetting->LIP_Limit,
            'DA' => $employeeDataSetting->DA_Limit,
            'PPF' => $request->ppf,
            'PostOff' => $employeeDataSetting->PostOff_Limit,
            'ULIP' => $request->ulip,
            'HL' => $request->housing_loan_repayment,
            'MF' => $request->mutual_funds,
            'IB' => $request->infrastructure_bonds,
            'CTF' => $employeeDataSetting->CTF_Limit,
            'NHB' => $request->deposit_in_nhb,
            'NSC' => $request->deposit_in_nsc,
            'SukS' => $request->sukanya_samriddhi,
            'NPS' => $employeeDataSetting->NPS_Limit,
            'CorNPS' => $request->input('CorNPS') ?? '0.0',
            'EPF' => $employeeDataSetting->EPF_Limit,
            'Form16' => $employeeDataSetting->Form16_Limit,
            'SPE' => $employeeDataSetting->SPE_Limit,
            'PT' => $employeeDataSetting->PT_Limit,
            'PFD' => $employeeDataSetting->PFD_Limit,
            'IT' => $employeeDataSetting->IT_Limit,
            'IHL' => $employeeDataSetting->IHL_Limit,
            'IL' => $employeeDataSetting->IL_Limit,
            'Inv_Date' => Carbon::parse($request->Inv_Date)->format('Y-m-d'),
            'Place' => $request->place,
            'YearId' => $yearId,
            'SignType' => '',
            'Sign' => '',
            'SubmittedDate' => $request->date,
            'HRSubmittedDate' => $request->date,
        ];
        

        if ($existingDeclaration) {
            // Update the existing declaration record if found
            \DB::table('hrm_employee_investment_declaration')
                ->where('EmployeeID', $employeeId)
                ->where('Month', $month)
                ->where('YearId', $yearId)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Investment Declaration updated successfully.'
            ]);
        } else {
            // Insert a new declaration record if no existing record is found
            \DB::table('hrm_employee_investment_declaration')->insert($data);

            return response()->json([
                'success' => true,
                'message' => 'Investment Declaration saved successfully.'
            ]);
        }
    }

    public function saveInvestmentSubmission(Request $request)
    {
        // Retrieving input values from the request
        $employeeId = Auth::user()->EmployeeID;
        $regime = $request->selected_regime;
        $period = $request->period_sub;
        $month = $request->c_month;
        $yearId = $request->y_id; 

        $employeeDataSetting = \DB::table('hrm_employee')
            ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
            ->where('hrm_employee.EmployeeID', $employeeId)
            ->first(); // Fetching the first record

        // Check if an investment declaration already exists for the same EmployeeID, Month, and YearId
        $existingDeclaration = \DB::table('hrm_employee_investment_submissiona')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $month)
            ->where('YearId', $yearId)
            ->first();

        // Prepare data to save or update
        $data = [
            'EmployeeID' => $employeeId,
            'EC' => $request->empcode, // Assuming EmpCode is part of the request
            // 'Regime' => $regime,
            'Period' => $period,
            'Month' => $month,
            'Status' => 'A', // Active
            'FormSubmit' => 'YY', // Assuming form submit is Yes
            'HRA' => $request->house_rent_declared_amount,
            'Curr_Medical' => $request->medical_insurance,
            'Curr_LTA' => $request->lta_declared_amount,
            'Curr_CEA' => $request->cea_declared_amount,
            'Medical' => $request->medical_insurance,
            'LTA' => $request->lta_declared_amount,
            'CEA' => $request->cea_declared_amount,
            'MIP' => $employeeDataSetting->MIP_Limit,
            'MTI' => $employeeDataSetting->MTI_Limit,
            'MTS' => $employeeDataSetting->MTS_Limit,
            'ROL' => $employeeDataSetting->ROL_Limit,
            'Handi' => $request->handicapped_deduction,
            '80G_Per' => $employeeDataSetting->{"80G_Per_Limit"},
            'DTC' => $employeeDataSetting->DTC_Limit_Limit,
            'RP' => $request->loan_repayment,
            'DFS' => $employeeDataSetting->DFS_Limit,
            'PenFun' => $request->pension_fund_contribution,
            'LIP' => $employeeDataSetting->LIP_Limit,
            'DA' => $employeeDataSetting->DA_Limit,
            'PPF' => $request->ppf,
            'PostOff' => $employeeDataSetting->PostOff_Limit,
            'ULIP' => $request->ulip,
            'HL' => $request->housing_loan_repayment,
            'MF' => $request->mutual_funds,
            'IB' => $request->infrastructure_bonds,
            'CTF' => $employeeDataSetting->CTF_Limit,
            'NHB' => $request->deposit_in_nhb,
            'NSC' => $request->deposit_in_nsc,
            'SukS' => $request->sukanya_samriddhi,
            'NPS' => $employeeDataSetting->NPS_Limit,
            'CorNPS' => $request->input('CorNPS') ?? '0.0',
            'EPF' => $employeeDataSetting->EPF_Limit,
            'Form16' => $employeeDataSetting->Form16_Limit,
            'SPE' => $employeeDataSetting->SPE_Limit,
            'PT' => $employeeDataSetting->PT_Limit,
            'PFD' => $employeeDataSetting->PFD_Limit,
            'IT' => $employeeDataSetting->IT_Limit,
            'IHL' => $employeeDataSetting->IHL_Limit,
            'IL' => $employeeDataSetting->IL_Limit,
            'Inv_Date' => Carbon::parse($request->Inv_Date)->format('Y-m-d'),
            'Place' => $request->place,
            'YearId' => $yearId,
            'SignType' => '',
            'Sign' => '',
            'SubmittedDate' => $request->date,
            'HRSubmittedDate' => $request->date,
        ];

        if ($existingDeclaration) {
            // Update the existing declaration record if found
            \DB::table('hrm_employee_investment_submissiona')
                ->where('EmployeeID', $employeeId)
                ->where('Month', $month)
                ->where('YearId', $yearId)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Investment Declaration updated successfully.'
            ]);
        } else {
            // Insert a new declaration record if no existing record is found
            \DB::table('hrm_employee_investment_submissiona')->insert($data);

            return response()->json([
                'success' => true,
                'message' => 'Investment Declaration saved successfully.'
            ]);
        }
    }

    // public function saveInvestmentDeclaration(Request $request)
    // {
    //     // Retrieving input values from the request
    //     $employeeId = Auth::user()->EmployeeID;
    //     $regime = $request->selected_regime;
    //     $period = $request->period;
    //     $month = $request->c_month;
    //     $yearId = $request->y_id; 
    //     $employeeDataSetting = \DB::table('hrm_employee')
    //     ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
    //     ->where('hrm_employee.EmployeeID', $employeeId)
    //     ->first(); // Fetching the first record
        
    //     $existingDeclaration = \DB::table('hrm_employee_investment_declaration')
    //     ->where('EmployeeID', $employeeId)
    //     ->where('Month', $month)
    //     ->where('YearId', $yearId)
    //     ->first();

    //         if ($existingDeclaration) {
    //             // If a declaration already exists for the same month and year, throw an error
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Investment declaration already exists for this employee in ' . $month . '-' . $yearId . '. Please review your data.'
    //             ]);

    //         }
    //     // Other form data
    //     $houseRentDeclaredAmount = $request->house_rent_declared_amount;
    //     $ltaCheckbox = $request->lta_checkbox;
    //     $ltaDeclaredAmount = $request->lta_declared_amount;
    //     $child1Checkbox = $request->child1_checkbox;
    //     $ceaDeclaredAmount = $request->cea_declared_amount;
    //     $medicalInsurance = $request->medical_insurance;
    //     $loanRepayment = $request->loan_repayment;
    //     $handicappedDeduction = $request->handicapped_deduction;
    //     $pensionFundContribution = $request->pension_fund_contribution;
    //     $lifeInsurance = $request->life_insurance;
    //     $deferredAnnuity = $request->deferred_annuity;
    //     $ppf = $request->ppf;
    //     $timeDeposit = $request->time_deposit;
    //     $ulip = $request->ulip;
    //     $housingLoanRepayment = $request->housing_loan_repayment;
    //     $mutualFunds = $request->mutual_funds;
    //     $infrastructureBonds = $request->infrastructure_bonds;
    //     $tuitionFee = $request->tuition_fee;
    //     $depositInNHB = $request->deposit_in_nhb;
    //     $depositInNSC = $request->deposit_in_nsc;
    //     $sukanyaSamriddhi = $request->sukanya_samriddhi;
    //     $othersEmployeeProvidentFund = $request->others_employee_provident_fund;
        
    //     // Handling the form submission (optional, if you need to set a status)
    //     $status = 'A'; // Active
    //     $formSubmit = 'Y'; // Assuming form submit is Yes
    
    //     // Format the investment date (assuming you need to store this as a date)
    //     $invDate = Carbon::parse($request->Inv_Date)->format('Y-m-d');
    //     $place = $request->Place; // Assuming Place is passed
    //     // Now let's insert the data into the `hrm_employee_investment_declaration` table
    //     \DB::table('hrm_employee_investment_declaration')->insert([
    //         'EmployeeID' => $employeeId,
    //         'EC' => $request->empcode, // Assuming EmpCode is part of the request
    //         'Regime' => $regime,
    //         'Period' => $period,
    //         'Month' => $month,
    //         'Status' => $status,
    //         'FormSubmit' => $formSubmit,
    //         'HRA' => $houseRentDeclaredAmount,
    //         'Curr_Medical' => $medicalInsurance,
    //         'Curr_LTA' => $ltaDeclaredAmount,
    //         'Curr_CEA' => $ceaDeclaredAmount,
    //         'Medical' => $medicalInsurance,
    //         'LTA' => $ltaDeclaredAmount,
    //         'CEA' => $ceaDeclaredAmount,
    //         'MIP' => $employeeDataSetting->MIP_Limit,
    //         'MTI' => $employeeDataSetting->MTI_Limit,
    //         'MTS' => $employeeDataSetting->MTS_Limit,
    //         'ROL' => $employeeDataSetting->ROL_Limit,
    //         'Handi' => $handicappedDeduction,
    //         '80G_Per' => $employeeDataSetting->{"80G_Per_Limit"},
    //         'DTC' => $employeeDataSetting->DTC_Limit_Limit,
    //         'RP' => $loanRepayment,
    //         'DFS' => $employeeDataSetting->DFS_Limit,
    //         'PenFun' => $pensionFundContribution,
    //         'LIP' => $employeeDataSetting->LIP_Limit,
    //         'DA' => $employeeDataSetting->DA_Limit,
    //         'PPF' => $ppf,
    //         'PostOff' => $employeeDataSetting->PostOff_Limit,
    //         'ULIP' => $ulip,
    //         'HL' => $housingLoanRepayment,
    //         'MF' => $mutualFunds,
    //         'IB' => $infrastructureBonds,
    //         'CTF' => $employeeDataSetting->CTF_Limit,
    //         'NHB' => $depositInNHB,
    //         'NSC' => $depositInNSC,
    //         'SukS' => $sukanyaSamriddhi,
    //         'NPS' => $employeeDataSetting->NPS_Limit,
    //         'CorNPS' => $request->input('CorNPS')??'0.0',
    //         'EPF' => $employeeDataSetting->EPF_Limit,
    //         'Form16' => $employeeDataSetting->Form16_Limit,
    //         'SPE' => $employeeDataSetting->SPE_Limit,
    //         'PT' => $employeeDataSetting->PT_Limit,
    //         'PFD' => $employeeDataSetting->PFD_Limit,
    //         'IT' => $employeeDataSetting->IT_Limit,
    //         'IHL' => $employeeDataSetting->IHL_Limit,
    //         'IL' => $employeeDataSetting->IL_Limit,
    //         'Inv_Date' => $invDate,
    //         'Place' => $request->place,
    //         'YearId' => $yearId,
    //         'SignType'=>'',
    //         'Sign'=>'',
    //         'SubmittedDate'=>$request->date,
    //         'HRSubmittedDate'=>$request->date,



    //     ]);
    
    //     // Optionally return a response or redirect after saving
    //     return response()->json(['success' => true, 'message' => 'Investment Declaration Saved Successfully']);
    // }

}
