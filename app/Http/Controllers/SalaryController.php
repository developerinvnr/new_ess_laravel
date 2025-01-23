<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaySlip;
use App\Models\EmployeeEligibility;
use App\Models\EmployeeCTC;
use App\Models\HrmYear;

use Illuminate\Support\Facades\Crypt;
use App\Mail\Investment\InvSubMail;
use App\Mail\Investment\InvSubHrMail;
use Illuminate\Support\Facades\Mail;

use App\Models\InvestmentDeclaration;
use App\Models\InvestmentSubmission;
use App\Models\EmployeeGeneral;
use App\Models\Employee;
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
            ->join('core_designation', 'hrm_employee_general.DesigId', '=', 'core_designation.id') // Join with costcenter table
            ->join('core_departments', 'hrm_employee_general.DepartmentId', '=', 'core_departments.id') // Join with state table
            ->join('core_grades', 'hrm_employee_general.GradeId', '=', 'core_grades.id') // Join with state table
            ->join('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id') // Join with state table
            ->where('hrm_employee.EmployeeID', $employeeID)
            ->first(); // Fetching the first record

            $results = \DB::table('core_departments as d')
            ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
            ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
            ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
            ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
            ->where('d.id', '=', $salaryData->DepartmentId)
            ->first();
            $functionName = $results->FunName;
            // Get the current year and month
            $currentMonth = Carbon::now()->month; // Current month (e.g., 1 for January)
            $currentYear = Carbon::now()->year;  // Current year (e.g., 2025)

            // Get the previous year
            $previousYear = $currentYear - 1;

            // Fetch the payslip data for the previous year up until the current month
            $payslipData = PaySlip::where('EmployeeID', $employeeID)
                            ->where('Status', 'A')  // Assuming 'A' means Active status
                            ->where(function ($query) use ($previousYear, $currentMonth, $currentYear) {
                                // Include the previous year and current year data up until the current month
                                $query->where('Year', $previousYear)
                                    ->orWhere(function ($query) use ($currentYear, $currentMonth) {
                                        // Filter for the current year only up to the current month
                                        $query->where('Year', $currentYear)
                                            ->where('Month', '<=', $currentMonth);
                                    });
                            })
                            ->get()
                        ->map(function ($payslip) {
                            // Add a new field for total days in the month
                            $year = $payslip->Year;
                            $month = $payslip->Month;

                            $payslip->TotalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                            // Return the modified payslip object
                            return $payslip;
                        });

        
           
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
                'Provident Fund' => 'Tot_Pf_Employee', 
                'Gross Deduction' => 'Tot_Deduct', 
                'Net Amount' => 'netPayAmount',
                'CONVEYANCE ALLOWANCE'=>'Convance',
                'TRANSPORT ALLOWANCE'=>'TA',
                'DA'=>'DA',
                'LEAVE ENCASH'=>'LeaveEncash',
                'ARREARS'=>'Arreares',
                'INCENTIVE'=>'Incentive',
                'VARIABLE ADJUSTMENT'=>'VariableAdjustment',
                'PERFORMANCE PAY'=>'PP_year',
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
        return view('employee.salary', compact('functionName','salaryData' ,'payslipData','payslipDataMonth','months', 'paymentHeads'));
        
    }
    public function verifyPassword(Request $request)
    {
        $user = Auth::user();
        $decryptedPassword = $this->decrypt($user->EmpPass);
        
        // Check if the password is correct
        if ($request->password == $decryptedPassword) {
            return response()->json(['success' => true, 'message' => 'Password match'], 200);

        } else {
            return response()->json(['success' => false, 'message' => 'Wrong Password'], 200);

        }
    }
    public function showPasswordModal()
    {
        // Check if user needs to verify password (logic can be added here)
        return view('employee.verify-password');
    }

    /**
     * Decrypts the given encrypted password using the custom logic.
     *
     * @param string $encryptedText
     * @return string
     */
    private function decrypt($encryptedText)
    {
        $strcode = [
            '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'A', 'b', 'B',
            'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',
            'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R',
            's', 'S', 't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z',
            '#', '@', '$', '%', '^', '&', '*', '_', '!', '?', ' '
        ];

        // Split the encrypted text into chunks of 3 characters each
        $chunks = str_split($encryptedText, 3);
        $output = '';

        // Derandomize each chunk and rebuild the password
        foreach ($chunks as $chunk) {
            $output .= $this->derandomized($chunk, $strcode);
        }

        return $output;
    }

    /**
     * Derandomizes a chunk of encrypted text and retrieves the original value.
     *
     * @param string $chunk
     * @param array $strcode
     * @return string
     */
    private function derandomized($chunk, $strcode)
    {
        $arr = $this->strsplt($chunk, strlen($chunk) - 1);
        $output = '';

        // Decrypt each part of the chunk
        for ($x = 0; $x < strlen($chunk) - 1; $x++) {
            $s = $this->key_locator(substr($arr[0], $x, 1), $strcode);
            $t = $this->key_locator($arr[1], $strcode);
            $newcode = $s - $t;

            // Handle wrap-around for negative values
            if ($newcode < 0) {
                $newcode += count($strcode) - 1;
            }

            // If no match and not zero, use the last character in the strcode
            if ($newcode == 0 && $s != 0) {
                $newcode = count($strcode) - 1;
            }

            $output .= $strcode[$newcode];
        }

        return $output;
    }

    /**
     * Splits a string into chunks of the specified size.
     *
     * @param string $text
     * @param int $size
     * @return array
     */
    private function strsplt($text, $size = 1)
    {
        $chunks = [];
        $length = strlen($text);

        for ($i = 0; $i < $length; $i += $size) {
            $chunks[] = substr($text, $i, $size);
        }

        return $chunks;
    }

    /**
     * Locates the key of a value in the strcode array.
     *
     * @param string $code
     * @param array $strcode
     * @return int
     */
    private function key_locator($code, $strcode)
    {
        foreach ($strcode as $key => $val) {
            if ($val === $code) {
                return $key;
            }
        }

        return 0;
    }

    
public function eligibility()
{
    $employeeIDeli = Auth::user()->EmployeeID;  // Cast to integer
    $employeegen = \DB::table('hrm_employee_general') // Use the actual table name
                    ->where('EmployeeID', $employeeIDeli)
                    ->first();
                    $policyDetails = null;
                                    
                    
    $gradeid = $employeegen->GradeId;
    if (\Carbon\Carbon::now()->month >= 4) {
        // If the current month is April or later, the financial year starts from the current year
        $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
        $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
    } else {
        // If the current month is before April, the financial year started the previous year
        $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
        $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
    }

    // Fetch the current financial year record
    $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
        ->whereDate('ToDate', '=', $financialYearEnd)
        ->first();
    $year_id_current = $currentYearRecord->YearId;
    $policyDetails = null;  // or use an empty array: $policyDetails = [];

    $eligibility = \DB::table('hrm_employee_eligibility')
    ->where('EmployeeID',$employeeIDeli) // make sure EmployeeID is an integer
    ->where('Status','A')
    // ->where('EligYearId', $year_id_current) // make sure EligYearId is an integer
    ->first();

        if($eligibility &&  $eligibility->VehiclePolicy != null && $eligibility->VehicleType != null){
                // Get the vehicle policy ID from the eligibility data
                $vp_id = $eligibility->VehiclePolicy ?? null ; 
                $vehicle_type = $eligibility->VehicleType ?? null; // Assuming this is available in the eligibility data

                // Get the additional eligibility policy details
                $policyDetails = $this->getPolicyDetails($vp_id, $vehicle_type,$gradeid);
        }

    return view('employee.eligibility', compact('eligibility','policyDetails'));
}
public function getPolicyDetails($vp_id, $vehicle_type,$gradeid)
{
    // Define the field IDs based on vehicle type and VP ID criteria
    $check_vp_ids = [1, 2, 5, 7]; // List of valid VP IDs
    $field_ids = [];

    if (in_array($vp_id, $check_vp_ids)) {
        // Assign field IDs based on vehicle type
        if (strtolower($vehicle_type) === 'new') {
            $field_ids = [1, 3, 4, 2, 5, 15, 23, 16, 24, 17, 25, 18, 26, 8];
        } elseif (strtolower($vehicle_type) === 'old') {
            $field_ids = [1, 3, 4, 2, 5, 19, 27, 20, 28, 21, 29, 22, 30, 8];
        } else {
            $field_ids = [0];
        }
    }

    // Build the query for policy details
    $query = \DB::table('hrm_master_eligibility_mapping_tblfield as m')
        ->join('hrm_master_eligibility_field as f', 'm.FieldId', '=', 'f.FieldId')
        ->select('m.MappId', 'm.PolicyId', 'm.FieldId', 'm.FOrder', 'm.Sts', 'f.FiledName')
        ->where('m.PolicyId', $vp_id)
        ->where('m.Sts', 1);

    // Add field ID condition if applicable
    if (!empty($field_ids)) {
        $query->whereIn('m.FieldId', $field_ids);
    }

    // Order by FOrder and get the results
    $policyDetails = $query->orderBy('m.FOrder', 'ASC')->get();

    // Now, fetch dynamic policy data based on GradeId and FieldId
    $tableName = "hrm_master_eligibility_policy_tbl" . $vp_id;
    $sdata = \DB::table($tableName)
        ->where('GradeId', $gradeid)  // Ensure this is passed correctly
        ->first();

    // Collect results and check if dynamic Fn<FieldId> exists
    $fieldsData = [];
    foreach ($policyDetails as $field) {
        $fieldName = "Fn" . $field->FieldId;
        
        if (isset($sdata->$fieldName) && $sdata->$fieldName != '') {
            // Add to fields data if value exists
            $fieldsData[] = [
                'FiledName' => $field->FiledName,
                'Value' => $sdata->$fieldName
            ];
        }
    }

    return $fieldsData;  // Returning the data to be used in the view
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
        if (\Carbon\Carbon::now()->month >= 4) {
            // If the current month is April or later, the financial year starts from the current year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
        } else {
            // If the current month is before April, the financial year started the previous year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
        }

        // Fetch the current financial year record
        $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
            ->whereDate('ToDate', '=', $financialYearEnd)
            ->first();

        // Determine the previous financial year
        $previousYearStart = \Carbon\Carbon::parse($financialYearStart)->subYear()->toDateString();
        $previousYearEnd = \Carbon\Carbon::parse($financialYearEnd)->subYear()->toDateString();

        // Fetch the previous financial year record
        $previousYearRecord = HrmYear::whereDate('FromDate', '=', $previousYearStart)
            ->whereDate('ToDate', '=', $previousYearEnd)
            ->first();
        $year_id_current = $currentYearRecord->YearId;
        $ctc = EmployeeCTC::where('EmployeeID', $employeeID)
        ->where('Status', 'A')
        // ->where('CtcYearId',$year_id_current)
        ->first();
        return view("employee.ctc",compact('ctc'));
    }
    // public function investment()
    // {
    //     $employeeID = Auth::user()->EmployeeID;
    //     // Join the tables (hrm_employee, hrm_employee_general, hrm_personal) using the EmployeeID
    //     $employeeData = \DB::table('hrm_employee')
    //         ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
    //         ->join('hrm_employee_personal', 'hrm_employee.EmployeeID', '=', 'hrm_employee_personal.EmployeeID')
    //         ->join('hrm_company_basic', 'hrm_employee.CompanyID', '=', 'hrm_company_basic.CompanyID')  // Join with company table
    //         ->join('hrm_investdecl_setting_submission', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting_submission.CompanyID')  // Join with investment declaration table
    //         ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
    //         ->where('hrm_employee.EmployeeID', $employeeID)
    //         ->first(); // Fetching the first record

    //         if (\Carbon\Carbon::now()->month >= 4) {
    //             // If the current month is April or later, the financial year starts from the current year
    //             $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
    //             $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
    //         } else {
    //             // If the current month is before April, the financial year started the previous year
    //             $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
    //             $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
    //         }
    //             // Determine the previous financial year
    //         $previousYearStart = \Carbon\Carbon::parse($financialYearStart)->subYear()->toDateString();
    //         $previousYearEnd = \Carbon\Carbon::parse($financialYearEnd)->subYear()->toDateString();

    //         // Fetch the previous financial year record
    //         $previousYearRecord = HrmYear::whereDate('FromDate', '=', $previousYearStart)
    //             ->whereDate('ToDate', '=', $previousYearEnd)
    //             ->first();

    //         $year_id_current = $previousYearRecord->YearId;
    //             // Fetch existing investment declaration for the given employee and year_id
    //             $investmentDeclaration = \DB::table('hrm_employee_investment_declaration')
    //             ->where('EmployeeID', $employeeID)
    //             ->where('YearId', $year_id_current)
    //             ->where('Status', 'A')
    //             ->first();  // Get the first record (if any)
    //     return view("employee.investment",compact('employeeData','investmentDeclaration'));
    // }
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
            
            ->first(); // Fetching the first record\


            // Fetch data from hrm_investdecl_setting
            $setting = \DB::table('hrm_investdecl_setting')
                ->where('CompanyId', $employeeData->CompanyId)
                ->where('Status', 'A')
                ->first(); // Fetch the first matching record

            // Fetch year details for B_YearId
            $yearB = \DB::table('hrm_year')
                ->where('YearId', $setting->B_YearId)
                ->first(); // Fetch the first matching record

            // Fetch year details for C_YearId
            $yearC = \DB::table('hrm_year')
                ->where('YearId', $setting->C_YearId)
                ->first(); // Fetch the first matching record

            // Parse dates using Carbon for B_YearId (FromDate and ToDate)
            $fb = \Carbon\Carbon::parse($yearB->FromDate)->format('Y');
            $tb = \Carbon\Carbon::parse($yearB->ToDate)->format('Y');

            // Parse dates using \Carbon for C_YearId (FromDate and ToDate)
            $fc = \Carbon\Carbon::parse($yearC->FromDate)->format('Y');
            $tc = \Carbon\Carbon::parse($yearC->ToDate)->format('Y');

            // Create the period strings
            $PrdBack = $fb . '-' . $tb;
            $PrdCurr = $fc . '-' . $tc;
            $investmentDeclaration = \DB::table('hrm_employee_investment_declaration')
                        ->where('EmployeeID', $employeeID)
                        ->where('Period', $PrdCurr)
                        ->where('Month', $setting->C_Month)
                        ->first(); // Retrieve the first matching record

            $investmentDeclarationsubb = \DB::table('hrm_employee_investment_submission')
                        ->where('EmployeeID', $employeeID)
                        ->where('Period', $PrdCurr)
                        ->where('Month', $setting->C_Month)
                        ->first(); // Retrieve the first matching record

                $investmentDeclarationlimit = \DB::table('hrm_investdecl_setting')
                ->where('CompanyId', $employeeData->CompanyId)
                ->where('Status', 'A')
                ->first();  // Get the first record (if any)

                $investmentDeclarationsetting = \DB::table('hrm_employee_key')
                ->where('CompanyId', $employeeData->CompanyId)
                ->first();  // Get the first record (if any)

                $ctc = \DB::table('hrm_employee_ctc')
                    ->where('EmployeeID', $employeeID)
                    ->where('Status', 'A')
                    ->select('HRA_Value', 'BAS_Value')
                    ->first();  // Get the first record (if any)
                    $LTA=$ctc->BAS_Value*1;
                    $HRA=$ctc->HRA_Value*12;
             
        return view("employee.investment",compact('PrdCurr','employeeData','investmentDeclaration','LTA','HRA','investmentDeclarationlimit','setting','investmentDeclarationsubb','investmentDeclarationsetting'));
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
    public function annualsalary(Request $request)
    {
        $employeeID = Auth::user()->EmployeeID;

         // Define the months mapping
         $months = [
            4 => 'APR', 5 => 'MAY', 
            6 => 'JUN', 7 => 'JUL', 8 => 'AUG', 9 => 'SEP', 10 => 'OCT', 
            11 => 'NOV', 12 => 'DEC',1 => 'JAN', 2 => 'FEB', 3 => 'MAR',
        ];
       
        // Define payment heads (the attribute names in your payslip data)
        $paymentHeads = [
            // 'Gross Earning' => 'Tot_Gross', 
            'Basic' => 'Basic',
            'Bonus' => 'Bonus_Month',
            'House Rent Allowance' => 'Hra', 
            'PerformancePay' => 'PP_year',
            'Bonus/ Exgeatia' => 'Bonus', 
            'Special Allowance' => 'Special',
            'DA'=>'DA',
            'Arrear'=>'Arreares',
            'Leave Encash'=>'LeaveEncash',
            'Car Allowance'=>'Car_Allowance',
            'Incentive'=>'Incentive',
            'Var Remburmnt'=>'VarRemburmnt',
            'Variable Adjustment'=>"VariableAdjustment",
            'City Compensatory Allowance'=>'CCA',
            'Relocation Allownace'=>'RA',
            'Arrear Basic'=>'Arr_Basic',
            'Arrear Hra'=>'Arr_Hra',
            'Arrear Spl'=>'Arr_Spl',
            'Arrear Conv'=>'Arr_Conv',
            'CEA'=>'YCea',
            'MR'=>'YMr',
            'LTA'=>'YLta',
            'Arrear Car Allowance'=>'Car_Allowance_Arr',
            'Arrear Leave Encash'=>'Arr_LvEnCash',
            'Arrear Bonus'=>'Arr_Bonus',
            'Arrear LTA Remb.'=>'Arr_LTARemb',
            'Arrear RA'=>'Arr_RA',
            'Arrear PP'=>'Arr_PP',
            'Bonus Adjustment'=>'Bonus_Adjustment',
            'Performance Incentive'=>'PP_Inc',
            'National pension scheme'=>'NPS',
        ];
        
        $deductionHeads = [
            // 'Gross Deduction' => 'Tot_Deduct', 
            'TDS' => 'TDS', 
            'Provident Fund' => 'Tot_Pf_Employee', 
            'ESIC'=>'ESCI_Employee',
            'NPS Contribution'=>'NPS_Value',
            'Arrear Pf'=>'Arr_Pf',
            'Arrear Esic'=>'Arr_Esic',
            'Voluntary Contribution'=>'VolContrib',
            'Deduct Adjustment'=>'DeductAdjmt',
            'Recovery Spl. Allow'=>'RecSplAllow',
        ];
       
            // $year = $request->input('year', date('Y')); // Default to the current year if no year is selected
              // Get the encrypted year from the request and decrypt it
    $encryptedYear = $request->input('year');
    if ($encryptedYear) {
        try {
            // Decrypt the year
            $year = Crypt::decryptString($encryptedYear);
        } catch (\Exception $e) {
            // Handle the decryption failure (e.g., return a default value or error)
            $year = date('Y');
        }
    } else {
        $year = date('Y'); // Default to the current year if no year is passed
    }

    $prevYear = date('Y') - 1;
            
            $prevYear = date('Y') - 1;
            if($year == $prevYear){
                if (\Carbon\Carbon::now()->month >= 4) {
                    // If the current month is April or later, the financial year starts from the current year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
                } else {
                    // If the current month is before April, the financial year started the previous year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
                }
                    // Determine the previous financial year
                $previousYearStart = \Carbon\Carbon::parse($financialYearStart)->subYear()->toDateString();
                $previousYearEnd = \Carbon\Carbon::parse($financialYearEnd)->subYear()->toDateString();

                // Fetch the previous financial year record
                $previousYearRecord = HrmYear::whereDate('FromDate', '=', $previousYearStart)
                    ->whereDate('ToDate', '=', $previousYearEnd)
                    ->first();

                $year_id_current = $previousYearRecord->YearId;

            }
            if($year != $prevYear){
                 
                if (\Carbon\Carbon::now()->month >= 4) {
                    // If the current month is April or later, the financial year starts from the current year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
                } else {
                    // If the current month is before April, the financial year started the previous year
                    $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
                    $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
                }
        
                // Fetch the current financial year record
                $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
                    ->whereDate('ToDate', '=', $financialYearEnd)
                    ->first();
                $year_id_current = $currentYearRecord->YearId;


        }
       
        // Get payslip data for the employee IDs for all months
        $payslipData = PaySlip::where('EmployeeID', $employeeID)->where('PaySlipYearId',$year_id_current)
                              ->select('EmployeeID', 'Month', 
                                ...array_values($paymentHeads), // select all payment heads columns
                                ...array_values($deductionHeads) // select all deduction heads columns
                              )
                              ->get();
        
        // Flatten the data into a simple structure: [EmployeeID, Month, Payment Heads, Deduction Heads]
        $flattenedPayslips = $payslipData->map(function ($payslip) use ($months, $paymentHeads, $deductionHeads) {
            $payslipData = [
                'EmployeeID' => $payslip->EmployeeID,
                'Month' => $months[$payslip->Month], // Month name
            ];
            
            // Add payment head data only if it's non-zero
            foreach ($paymentHeads as $label => $column) {
                $value = $payslip->$column ?? 0;
                if ($value != 0) {
                    $payslipData[$label] = $value;  // Only add if the value is non-zero
                }
            }
            
            // Add deduction head data only if it's non-zero
            foreach ($deductionHeads as $label => $column) {
                $value = $payslip->$column ?? 0;
                if ($value != 0) {
                    $payslipData[$label] = $value;  // Only add if the value is non-zero
                }
            }
            
            return $payslipData;
        });
    
        // Filter out heads that have no data across all months for any employee
        $filteredPaymentHeads = $paymentHeads;
        $filteredDeductionHeads = $deductionHeads;
    
        foreach ($paymentHeads as $label => $column) {
            $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
            if (!$hasData) {
                unset($filteredPaymentHeads[$label]);
            }
        }
    
        foreach ($deductionHeads as $label => $column) {
            $hasData = $flattenedPayslips->pluck($label)->contains(fn($value) => $value != 0);
            if (!$hasData) {
                unset($filteredDeductionHeads[$label]);
            }
        }
    
        // Group the payslip data by EmployeeID for easier display in the view
        $groupedPayslips = $flattenedPayslips->groupBy('EmployeeID');
                                return view("employee.annualsalary", compact('groupedPayslips', 'months', 'filteredPaymentHeads', 'filteredDeductionHeads'));
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
        if($request->place == null|| $request->place == ''){
            return response()->json(['success' => false, 'message' => 'Place fields is mandatory']);

        }
        if($request->date == null|| $request->date == ''){
            return response()->json(['success' => false, 'message' => 'Date fields is mandatory']);

        }

        $employeeDataSetting = \DB::table('hrm_employee')
            ->join('hrm_investdecl_setting', 'hrm_employee.CompanyID', '=', 'hrm_investdecl_setting.CompanyID')  // Join with investment declaration table
            ->where('hrm_employee.EmployeeID', $employeeId)
            ->first(); // Fetching the first record

            $investmentDeclarationlimit = \DB::table('hrm_investdecl_setting')
            ->where('CompanyId', $employeeDataSetting->CompanyId)
            ->where('Status', 'A')
            ->first();  // Get the first record (if any)
            $ctc = \DB::table('hrm_employee_ctc')
                ->where('EmployeeID', $employeeId)
                ->where('Status', 'A')
                ->select('hrm_employee_ctc.*')
                ->first();  // Get the first record (if any)
       
        // Check if an investment declaration already exists for the same EmployeeID, Month, and YearId
        $existingDeclaration = \DB::table('hrm_employee_investment_submission')
            ->where('EmployeeID', $employeeId)
            ->where('Month', $month)
            ->where('YearId', $yearId)
            ->first();
            if($request->save == "0"){
                $FormSubmit = 'Y';
            }
            if($request->submit == "1"){
                $FormSubmit = 'YY';
            }

        // Prepare data to save or update
        $data = [
            'EmployeeID' => $employeeId,
            'EC' => $request->empcode, // Assuming EmpCode is part of the request
            // 'Regime' => $regime,
            'Period' => $period,
            'Month' => $month,
            'Status' => 'A', // Active
            'FormSubmit' => $FormSubmit, // Assuming form submit is Yes
            'HRA' => $request->house_rent_declared_amount ?? '0.00',
            'Curr_Medical' => $request->medical_insurance?? '0.00',
            'Curr_LTA' => $ctc->LTA_Value?? '0.00',
            'Curr_CEA' => $ctc->CHILD_EDU_ALL_Value?? '0.00',
            'Medical' => $request->medical_insurance?? '0.00',
            'LTA' => $request->lta_declared_amount?? '0.00',
            'CEA' => $request->cea_declared_amount?? '0.00',
            'MIP' => $employeeDataSetting->MIP_Limit?? '0.00',
            'MTI' => $employeeDataSetting->MTI_Limit?? '0.00',
            'MTS' => $employeeDataSetting->MTS_Limit?? '0.00',
            'ROL' => $employeeDataSetting->ROL_Limit?? '0.00',
            'Handi' => $request->handicapped_deduction?? '0.00',
            '80G_Per' => $employeeDataSetting->{"80G_Per_Limit"}?? '0.00',
            'DTC' => $employeeDataSetting->DTC_Limit_Limit?? '0.00',
            'RP' => $request->loan_repayment?? '0.00',
            'DFS' => $employeeDataSetting->DFS_Limit?? '0.00',
            'PenFun' => $request->pension_fund_contribution?? '0.00',
            'LIP' => $employeeDataSetting->LIP_Limit?? '0.00',
            'DA' => $employeeDataSetting->DA_Limit?? '0.00',
            'PPF' => $request->ppf?? '0.00',
            'PostOff' => $employeeDataSetting->PostOff_Limit?? '0.00',
            'ULIP' => $request->PostOff?? '0.00',
            'HL' => $request->housing_loan_repayment?? '0.00',
            'MF' => $request->mutual_funds?? '0.00',
            'IB' => $request->infrastructure_bonds?? '0.00',
            'CTF' => $employeeDataSetting->CTF_Limit?? '0.00',
            'NHB' => $request->deposit_in_nhb?? '0.00',
            'NSC' => $request->deposit_in_nsc?? '0.00',
            'SukS' => $request->sukanya_samriddhi?? '0.00',
            'NPS' => $employeeDataSetting->NPS_Limit?? '0.00',
            'CorNPS' => $request->cornps ??'0.00',
            'EPF' => $employeeDataSetting->EPF_Limit?? '0.00',
            'Form16' => $employeeDataSetting->Form16_Limit?? '0.00',
            'SPE' => $employeeDataSetting->SPE_Limit?? '0.00',
            'PT' => $employeeDataSetting->PT_Limit?? '0.00',
            'PFD' => $employeeDataSetting->PFD_Limit?? '0.00',
            'IT' => $employeeDataSetting->IT_Limit?? '0.00',
            'IHL' => $employeeDataSetting->IHL_Limit?? '0.00',
            'IL' => $employeeDataSetting->IL_Limit?? '0.00',
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
            \DB::table('hrm_employee_investment_submission')
                ->where('EmployeeID', $employeeId)
                ->where('Month', $month)
                ->where('YearId', $yearId)
                ->update($data);
                if($FormSubmit == 'YY'){
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                    $employeedetails = Employee::where('EmployeeID', $employeeId)->first();
           
                    $ReportingName = $reportinggeneral->ReportingName;
                    $employeeEmailId = $reportinggeneral->EmailId_Vnr;
           
                    $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'subject'=>'Investment Submission',
                        'EmpName'=> $Empname,
                        'Period'=>$period,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                      ];
                    //   Mail::to('vspl.hr@vnrseeds.com')->send(new InvSubHrMail($details));
                    //   Mail::to($employeeEmailId)->send(new InvSubMail($details));
           
                }
                return response()->json(['success' => true, 'message' => 'Investment Declaration updated successfully.']);

        } else {
            // Insert a new declaration record if no existing record is found
            \DB::table('hrm_employee_investment_submission')->insert($data);
            if($FormSubmit == 'YY'){
         $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
         $employeedetails = Employee::where('EmployeeID', $employeeId)->first();

         $ReportingName = $reportinggeneral->ReportingName;
         $employeeEmailId = $reportinggeneral->EmailId_Vnr;

         $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
         $details = [
             'subject'=>'Investment Submission',
             'EmpName'=> $Empname,
             'Period'=>$period,
             'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
           ];

        //    Mail::to('vspl.hr@vnrseeds.com')->send(new InvSubHrMail($details));
        //    Mail::to($employeeEmailId)->send(new InvSubMail($details));


            }

            return response()->json(['success' => true, 'message' => 'Investment Declaration saved successfully.']);

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
