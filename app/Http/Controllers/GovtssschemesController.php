<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class GovtssschemesController extends Controller
{
    public function govtssschemes(){
        $employee = Employee::findOrFail(Auth::user()->EmployeeID);
        if($employee->ChangePwd == 'N'){
         
            // Encrypt the new password using the provided encryption method
            $encryptedPassword = $this->encrypt($request->password, $this->strcode);

            // Use query builder to update the password in the database
            DB::table('hrm_employee')
                ->where('EmployeeID', Auth::user()->EmployeeID)
                ->update([
                    'EmpPass' => $encryptedPassword,
                    'ChangePwd'=>'Y'

                ]);
                return redirect('/dashboard')->with('success', 'Password Changed Successfully');

            }
        return view("employee.govtssschemes");
    }
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'Cast' => 'required',
            'CastOther' => 'nullable|string|max:255',
            'Scheme1' => 'nullable|string',
            'Scheme2' => 'nullable|string',
            'Scheme3' => 'nullable|string',
            'Scheme4' => 'nullable|string',
        ]);

        // Insert data into the hrm_opinion table
        \DB::table('hrm_opinion')->insert([
            'EmployeeID' => Auth::user()->EmployeeID, // Current employee ID
            'OpenionName' => 'jsy', // Replace with a specific opinion value if needed
            'OpenionDate' => now()->format('Y-m-d'), // Current date
            'CrDate' => now()->format('Y-m-d'), // Creation date
            'Cast' => $request->Cast,
            'CastOther' => $request->CastOther,
            'Scheme1' => $request->Scheme1 ?? null,
            'Scheme2' => $request->Scheme2 ?? null,
            'Scheme3' => $request->Scheme3 ?? null,
            'Scheme4' => $request->Scheme4 ?? null,
        ]);


        return redirect('/dashboard')->with('success', 'Gov Scheme saved Successfully');

        // Redirect back with a success message
    }
    public function investmentdeclaration(){
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
         return view('employee.investmentdeclaration',compact('ctc','PrdCurr','employeeData','investmentDeclaration','LTA','HRA','investmentDeclarationlimit','setting','investmentDeclarationsubb','investmentDeclarationsetting'));

    }
}
