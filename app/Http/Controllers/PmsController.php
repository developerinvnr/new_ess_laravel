<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrmYear;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class PmsController extends Controller
{
    public function pmsinfo(){
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
        $employee_company = Employee::where('EmployeeID', Auth::user()->EmployeeID)->first();

                        if (!$employee_company) {
                            return response()->json(['error' => 'Employee details not found'], 404);
                        }
                    $emp_company_id = $employee_company->CompanyId;
        $exists_appraisel = \DB::table('hrm_employee_pms')
                ->where('Appraiser_EmployeeID', Auth::user()->EmployeeID)
                ->where('AssessmentYear', $year_id)
                ->exists();

                $exists_reviewer = \DB::table('hrm_employee_pms')
                ->where('Reviewer_EmployeeID', Auth::user()->EmployeeID)
                ->where('AssessmentYear', $year_id)
                ->exists();
                $exists_hod = \DB::table('hrm_employee_pms')
                ->where('Rev2_EmployeeID', Auth::user()->EmployeeID)
                ->where('AssessmentYear', $year_id)
                ->exists();
                $exists_mngmt = \DB::table('hrm_employee_pms')
                ->where('HOD_EmployeeID', Auth::user()->EmployeeID)
                ->where('AssessmentYear', $year_id)
                ->exists();
                $kra_schedule = \DB::table('hrm_pms_kra_schedule')  // Start with the `hrm_pms_kra_schedule` table
    ->where('KRASheduleStatus', 'A')          // Apply the first condition for status
    ->where('CompanyId', $emp_company_id)         // Apply the condition for CompanyId
    ->where('YearId', $year_id)               // Apply the condition for YearId
    ->orderBy('KRASche_DateFrom', 'ASC')      // Order by KRASche_DateFrom in ascending order
    ->get(); 
    DD($kra_schedule);
        
        return view("employee.pmsinfo",compact('exists_appraisel','exists_reviewer','exists_hod','exists_mngmt','kra_schedule'));
    }
    public function pms(){
        return view("employee.pms");
    }
    public function appraiser(){
        return view("employee.appraiser");
    }
    public function reviewer(){
        return view("employee.reviewer");
    }
    public function hod(){
        return view("employee.hod");
    }
    public function management(){
        return view("employee.management");
    }
}
