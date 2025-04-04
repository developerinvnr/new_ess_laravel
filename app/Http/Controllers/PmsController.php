<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrmYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use App\Mail\Kra\ReviewerRevert;
use App\Mail\Kra\Reviewer;
use App\Mail\Kra\Appraisal;
use App\Mail\Kra\AppraisalRevert;
use App\Mail\Kra\EmployeeKRAfill;
use App\Mail\Kra\EmployeeKRAFillRepo;
use App\Mail\Kra\HOD;
use App\Mail\Kra\HODRevert;
use App\Models\Employee;
use App\Models\EmployeeGeneral;


class PmsController extends Controller
{

    public function pmsinfo()
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);

        // $KraYId = ($keys['emp']->Schedule == 'Y') 
        // ? (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY) 
        // : $year_kra->CurrY;
        $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
        if ($keys['emp']->Schedule == 'Y') {
            // If Schedule is 'Y', check if NewY_AllowEntry is 'Y'
            if ($year_kra->NewY_AllowEntry == 'Y') {
                $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
            } else {
                $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
            }
        } else {
            // If Schedule is not 'Y', set to CurrY
            $KraYId = $year_kra->CurrY;
        }
        $KraYId_view = $year_kra->CurrY;
        // Fetch year details
        $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
        $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();


        // Fetch the KRA schedule using Laravel's query builder
        $kra_schedule_data = DB::table('hrm_pms_kra_schedule')
            ->where('KRASheduleStatus', 'A')
            ->where('CompanyId', $CompanyId)
            ->where('YearId', $KraYId)
            ->orderBy('KRASche_DateFrom', 'ASC')
            ->get();



        // Fetch the schedules with status 'A' (Active) for the given company and year
        $appraisal_schedule_data = DB::table('hrm_pms_schedule')->where('SheduleStatus', 'A')
            ->where('CompanyId', $CompanyId)
            ->where('YearId', $PmsYId)
            ->orderBy('Sche_DateFrom', 'ASC')
            ->get();
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();

        // Reporting info
        $reporting = DB::table('hrm_employee_reporting as r')
            ->leftJoin('hrm_employee as a', 'r.AppraiserId', '=', 'a.EmployeeID')
            ->leftJoin('hrm_employee as rev', 'r.ReviewerId', '=', 'rev.EmployeeID')
            ->leftJoin('hrm_employee as h', 'r.HodId', '=', 'h.EmployeeID')
            ->where('r.EmployeeID', $EmployeeId)
            ->select(
                'a.Fname as appraiser_fname',
                'a.Sname as appraiser_sname',
                'a.Lname as appraiser_lname',
                'rev.Fname as rev_fname',
                'rev.Sname as rev_sname',
                'rev.Lname as rev_lname',
                'h.Fname as hod_fname',
                'h.Sname as hod_sname',
                'h.Lname as hod_lname'
            )
            ->first();


        // Calculate duration
        $dateJoining = Carbon::parse($employee->DateJoining);
        $now = Carbon::now();
        $totalMonths = $dateJoining->diffInMonths($now);
        $years = floor($totalMonths / 12);
        $months = $dateJoining->diffInMonths($now) % 12;
        $formattedDuration = $years . '.' . str_pad($months, 2, '0', STR_PAD_LEFT) . ' Years';

        // Fetching appraisal and KRA schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Checking existing appraisals
        $exists_appraisel = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId_view)
            ->exists();

        $exists_reviewer = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId_view)
            ->exists();

        $exists_hod = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId_view)
            ->exists();

        $exists_mngmt = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId_view)
            ->exists();

        $pmsLastDate = $appraisal_schedule->EmpToDate ?? null;
        $kraLastDate = $kra_schedule->EmpToDate ?? null;

        $currentYear = date('Y');  // Get the current year
        $currentMonth = date('m'); // Get the current month
        $currentDate = Carbon::today(); // Get today's date

        $pmsDaysRemaining = null;
        $kraDaysRemaining = null;

        // PMS Date Calculation (Only if it's in the current month and year)
        if ($pmsLastDate) {
            $pmsLastDateCarbon = Carbon::parse($pmsLastDate);
            if ($pmsLastDateCarbon->year == $currentYear && $pmsLastDateCarbon->month == $currentMonth) {
                $pmsDaysRemaining = $currentDate->diffInDays($pmsLastDateCarbon, false);
            }
        }

        // KRA Date Calculation (Only if it's in the current month and year)
        if ($kraLastDate) {
            $kraLastDateCarbon = Carbon::parse($kraLastDate);
            if ($kraLastDateCarbon->year == $currentYear && $kraLastDateCarbon->month == $currentMonth) {
                $kraDaysRemaining = $currentDate->diffInDays($kraLastDateCarbon, false);
            }
        }



        // Pass everything to the view
        return view("employee.pmsinfo", compact(
            'data',
            'PmsYId',
            'KraYId',
            'year_kra_details',
            'year_pms_details',
            'employee',
            'appraisal_schedule',
            'kra_schedule',
            'exists_appraisel',
            'exists_reviewer',
            'exists_hod',
            'exists_mngmt',
            'formattedDuration',
            'reporting',
            'kra_schedule_data',
            'appraisal_schedule_data',
            'kraDaysRemaining',
            'pmsDaysRemaining',
            'kraLastDate',
            'pmsLastDate'
        ));
    }
    
    public function pms(Request $request)
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;
        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];


        // Store extracted values in an array
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];
	
        // Fetch year settings
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
        $apra_allowdoj = $year_pms->AllowEmpDoj;

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
      
        $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
        if ($keys['emp']->Schedule == 'Y') {
            if ($year_kra->NewY_AllowEntry == 'Y') {
                $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
            } else {
                $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
            }
        } else {
            $KraYId = $year_kra->CurrY;
        }
        $toDateYear = DB::table('hrm_year')
                ->where('PmsYearId', $PmsYId) // Assuming 'id' is the primary key
                ->value('ToDate'); // Fetch only the 'todate' column

        $yearPms = date('Y', strtotime($toDateYear)); // Extract the year

        $KraYIdCurr = $year_kra->CurrY;
        $KraYIdNew = $year_kra->NewY;

        // Fetch year details
        $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
        $year_kra_details_new = DB::table('hrm_year')->where('YearId', $KraYIdNew)->first();

        $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

        // Calculate the years based on FromDate and ToDate for KRA
        $kf = Carbon::parse($year_kra_details->FromDate)->format('Y'); // Year from KRA FromDate
        $kt = Carbon::parse($year_kra_details->ToDate)->format('Y'); // Year from KRA ToDate

        $kfnew = Carbon::parse($year_kra_details_new->FromDate)->format('Y'); // Year from KRA FromDate
        $ktnew = Carbon::parse($year_kra_details_new->ToDate)->format('Y'); // Year from KRA ToDate

        $kt2 = $kf - 1; // Previous year of KRA

        // Calculate the years based on FromDate and ToDate for PMS
        $pf = Carbon::parse($year_pms_details->FromDate)->format('Y'); // Year from PMS FromDate
        $pt = Carbon::parse($year_pms_details->ToDate)->format('Y'); // Year from PMS ToDate
        $pt2 = $pf - 1; // Previous year of PMS


        if ($CompanyId == 1) {
            // For CompanyId 1, store the years without the range
            $KraYear = $kf . '-' . $kt;
            $PmsYear = $pf . '-' . $pt;
        } else {
            // For other CompanyIds, store the years as a range
            $KraYear = $kf . '-' . $kt;
            $PmsYear = $pf . '-' . $pt;
        }
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();

        $results = DB::table('core_departments as d')
            ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
            ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
            ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
            ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
            ->where('d.id', '=', $employee->DepartmentId)
            ->first();
        $functionName = $results->FunName ?? null;

        $reporting = DB::table('hrm_employee_pms as r')
            ->leftJoin('hrm_employee as a', 'r.Appraiser_EmployeeID', '=', 'a.EmployeeID')
            ->leftJoin('hrm_employee as rev', 'r.Reviewer_EmployeeID', '=', 'rev.EmployeeID')
            ->leftJoin('hrm_employee as h', 'r.Rev2_EmployeeID', '=', 'h.EmployeeID')
            ->leftJoin('hrm_employee as mang', 'r.HOD_EmployeeID', '=', 'mang.EmployeeID')
            ->where('r.EmployeeID', $EmployeeId)
            ->where('r.YearId',$KraYId)
            ->select(
                'a.Fname as appraiser_fname',
                'a.Sname as appraiser_sname',
                'a.Lname as appraiser_lname',
                'rev.Fname as rev_fname',
                'rev.Sname as rev_sname',
                'rev.Lname as rev_lname',
                'h.Fname as hod_fname',
                'h.Sname as hod_sname',
                'h.Lname as hod_lname',
                 'mang.Fname as mang_fname',
                'mang.Sname as mang_sname',
                'mang.Lname as mang_lname'
            )
            ->first();




        $dateJoining = Carbon::parse($employee->DateJoining);
        $now = Carbon::now();
        $totalMonths = $dateJoining->diffInMonths($now);

        // Calculate the number of full years (divide by 12)
        $years = floor($totalMonths / 12);
        // Calculate the remaining months
        $months = $dateJoining->diffInMonths($now) % 12;
        $formattedDuration = $years . '.' . str_pad($months, 2, '0', STR_PAD_LEFT) . ' Years';


        // Fetching assessment schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Fetching KRA schedule
        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $exists_appraisel = \DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_reviewer = \DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_hod = \DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        $exists_mngmt = \DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        if ($request->has('year_id')) {
            $selectedYearId = $request->has('year_id') ? Crypt::decryptString($request->query('year_id')) : now()->year;
        } else {
            $selectedYearId = $KraYId;
        }
        // Fetch the KRA schedule using Laravel's query builder
	$kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
	    ->where('KRASheduleStatus', 'A')
	    ->where('CompanyId', $CompanyId)
	    ->where('YearId', $KraYId)
	    ->where('KRAProcessOwner', 'Team Member')  // Only fetch team members
	    ->orderBy('KRASche_DateFrom', 'ASC')
	    ->first();


        // Fetch KRA data for the employee
        $kraData = DB::table('hrm_pms_kra')
            ->where('YearId', $selectedYearId)
            ->where('CompanyId', $CompanyId)
            ->where('EmployeeID', $EmployeeId)
            ->orderBy('KRAId', 'ASC') // Order by KRAId in ascending order
            ->get();
            
        $kraDatalastrevert = DB::table('hrm_pms_kra')
            ->where('YearId', $selectedYearId)
            ->where('CompanyId', $CompanyId)
            ->where('EmployeeID', $EmployeeId)
            ->orderBy('KRAId', 'DESC') // Order by KRAId in ascending order
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();

        $kraWithSubs = [];

        // Loop through the KRAs and get the corresponding Sub-KRAs using Query Builder
        foreach ($kraData as $kra) {
            $subKra = DB::table('hrm_pms_krasub')
                ->where('KRAId', $kra->KRAId)
                ->where('KSubStatus', ['A', 'R']) // Only active Sub-KRAs
                ->get();
            // Store the KRA and its related Sub-KRAs
            $kraWithSubs[] = [
                'kra' => $kra,
                'subKras' => $subKra,
            ];
        }
        $employeePms = DB::table('hrm_employee_pms_kraforma as k')
            ->leftJoin('hrm_employee_pms as p', 'k.EmpPmsId', '=', 'p.EmpPmsId')
            ->where('p.EmployeeID', $EmployeeId)
            ->where('YearId', $year_kra->OldY)
            ->first();

        $kraList = [];
        $kraListold = [];

        $year_pms_details_old = DB::table('hrm_year')->where('YearId', $year_kra->OldY)->first();
        $old_year = Carbon::parse($year_pms_details_old->FromDate)->format('Y'); // Year from KRA FromDate

        if ($request->has('old_year')) {
            $old_year = $request->has('old_year') ? Crypt::decryptString($request->query('old_year')) : now()->year;
        } else {
            $old_year = $year_kra->OldY;
        }
        $kraListold = DB::table('hrm_pms_kra')->where('YearId', $old_year)
            ->where('hrm_pms_kra.CompanyId', $CompanyId)
            ->where('hrm_pms_kra.EmployeeID', $EmployeeId)
            ->get();
        //achievement
        $pms_id= DB::table('hrm_employee_pms')
            ->where('hrm_employee_pms.EmployeeID', $EmployeeId)
            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
            ->where('hrm_employee_pms.CompanyId',$CompanyId)
            ->first();
        
        $pms_achievement_data = DB::table('hrm_employee_pms_achivement')
                                ->where('hrm_employee_pms_achivement.EmpPmsId',$pms_id->EmpPmsId)
                                ->get();

        $feedback_que = DB::table('hrm_pms_workenvironment')
            ->where('hrm_pms_workenvironment.CompanyId',$CompanyId)
            ->where('hrm_pms_workenvironment.WorkEnStatus','A')
            ->get();

        $feedbackAnswers = DB::table('hrm_employee_pms_workenvironment')
                                ->where('EmpPmsId', $pms_id->EmpPmsId) // Get answers for the specific PMS ID
                                ->pluck('Answer', 'WorkEnvironment'); // Retrieve Answer mapped to WorkEnvironment
                                
        $formattedDOJ = date('Y-m-d', strtotime($dateJoining));

        $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
            ->where('EmpPmsId', $pms_id->EmpPmsId)
            ->get();

         // Fetch related data from kra and submr tables
            foreach ($employeePmsKraforma as $kraforma) {
                $kraforma->kra = DB::table('hrm_pms_kra')
                    ->where('KRAId', $kraforma->KRAId)
                    ->get();


                $kraforma->submr = DB::table('hrm_pms_krasub')
                    ->where('KRAId', $kraforma->KRAId)
                    ->get();
            }
            $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
                                    ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
                                    ->where('fbf.EmpId', $EmployeeId)
                                    ->where('fbf.YearId', $PmsYId)
                                    ->orderBy('fbf.BehavioralFormBId', 'ASC')
                                    ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target')
                                    ->get();

            $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
                                    ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
                                    ->where('s.EmpId', $EmployeeId)
                                    ->where('s.YearId', $PmsYId)
                                    ->select('s.*', 'bb.*')
                                    ->get();
            $rowChe = DB::table('hrm_pms_allow')
                                    ->where('EmployeeID', $EmployeeId)
                                    ->where('CompanyId', $CompanyId)
                                    ->where('AssesmentYear',$PmsYId)
                                    ->count();
            $rowCh = DB::table('hrm_pms_allow')
                                    ->where('Appraiser_EmployeeID', $pms_id->Appraiser_EmployeeID)
                                    ->where('CompanyId', $CompanyId)
                                    ->where('AssesmentYear',$PmsYId)
                                    ->count();
            $CuDate = now()->format('Y-m-d');

        return view("employee.pms", compact(
            'data','ktnew','kfnew',
            'PmsYId',
            'KraYId',
            'year_pms',
            'year_kra_details',
            'year_pms_details',
            'employee',
            'appraisal_schedule',
            'kra_schedule',
            'exists_appraisel',
            'exists_reviewer',
            'exists_hod',
            'exists_mngmt',
            'formattedDuration',
            'reporting',
            'KraYear',
            'PmsYear',
            'functionName',
            'kraWithSubs',
            'kraListold',
            'old_year',
            'year_kra',
            'logicData',
            'kraData',
            'kraDatalastrevert',
            'kra_schedule_data_employee',
            'yearPms',
            'pms_id',
            'pms_achievement_data',
            'KraYIdCurr',
            'feedback_que','feedbackAnswers','formattedDOJ','rowChe','CuDate','rowCh',
            'apra_allowdoj','employeePmsKraforma','behavioralForms','behavioralFormssub'
        ));
    }
    
    public function fetchOldKRA(Request $request)
    {

        $decryptedYear = $request->old_year;

        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch the KRA list
        $kraListold = DB::table('hrm_pms_kra')
            ->where('YearId', $decryptedYear)
            ->where('CompanyId', $CompanyId)
            ->where('EmployeeID', $EmployeeId)
            ->get();
  
            $subKraList = DB::table('hrm_pms_krasub')
            ->whereIn('KRAId', $kraListold->pluck('KRAId'))
            ->get();
        return response()->json([
            'success' => true,
            'year' => $decryptedYear,
            'data' => $kraListold,
            'sub_kradata' => $subKraList,
        ]);
    }

    public function appraiser()
    {

        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        // Fetch year settings
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

      $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
      $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
      if ($keys['emp']->Schedule == 'Y') {
          if ($year_kra->NewY_AllowEntry == 'Y') {
              $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
          } else {
              $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
          }
      } else {
          $KraYId = $year_kra->CurrY;
      }
      $KraYIdCurr = $year_kra->CurrY;
      // Fetch year details
      $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
      $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

      $KraYIdNew = $year_kra->NewY;

      // Fetch year details
      $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
      $year_kra_details_new = DB::table('hrm_year')->where('YearId', $KraYIdNew)->first();

      $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

      // Calculate the years based on FromDate and ToDate for KRA
      $kf = Carbon::parse($year_kra_details->FromDate)->format('Y'); // Year from KRA FromDate
      $kt = Carbon::parse($year_kra_details->ToDate)->format('Y'); // Year from KRA ToDate

      $kfnew = Carbon::parse($year_kra_details_new->FromDate)->format('Y'); // Year from KRA FromDate
      $ktnew = Carbon::parse($year_kra_details_new->ToDate)->format('Y'); // Year from KRA ToDate

      $kt2 = $kf - 1; // Previous year of KRA

      // Calculate the years based on FromDate and ToDate for PMS
      $pf = Carbon::parse($year_pms_details->FromDate)->format('Y'); // Year from PMS FromDate
      $pt = Carbon::parse($year_pms_details->ToDate)->format('Y'); // Year from PMS ToDate
      $pt2 = $pf - 1; // Previous year of PMS


      if ($CompanyId == 1) {
          // For CompanyId 1, store the years without the range
          $KraYear = $kf . '-' . $kt;
          $PmsYear = $pf . '-' . $pt;
      } else {
          // For other CompanyIds, store the years as a range
          $KraYear = $kf . '-' . $kt;
          $PmsYear = $pf . '-' . $pt;
      }

        // Fetching appraisal and KRA schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Checking existing appraisals
        $exists_appraisel = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_reviewer = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_hod = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_mngmt = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        // Fetching all EmployeeIds where Appraiser_EmployeeID = EmployeeId
        $appraisedEmployees = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');  // This will return an array of Employee IDs
        // Fetch all Employee IDs where Appraiser_EmployeeID is the same as $EmployeeId
        $appraisedEmployees = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');

        $appraisedEmployeesPms = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $PmsYId)
            ->pluck('EmployeeID');

        // Now, use the Employee IDs to fetch the required employee details by joining the necessary tables
        $employeeDetails = DB::table('hrm_employee_general as emp')
            ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
            ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')  // Fixed the join on EmployeeID here
            ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
            ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
            ->whereIn('emp.EmployeeID', $appraisedEmployees)  // Using whereIn to handle multiple Employee IDs
            ->where('empp.EmpStatus', 'A')  // Using whereIn to handle multiple Employee IDs
            ->select(
                'empp.EmployeeID',
                'empp.EmpCode',
                'empp.Fname',
                'empp.Sname',
                'empp.Lname',
                'dept.department_name',
                'hq.city_village_name',
                'desig.designation_name'
            )
            ->get();
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();
            
            $employeedetailsforpms = DB::table('hrm_employee as e')
            ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
            ->join('hrm_employee_pms as p', 'e.EmployeeID', '=', 'p.EmployeeID')
            ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->join('core_designation as de', 'g.DesigId', '=', 'de.id')
            ->join('core_grades as gr', 'g.GradeId', '=', 'gr.id')
            ->join('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            ->join('core_states as st', 'hq.state_id', '=', 'st.id')
            ->where('e.EmpStatus', 'A')
            ->where('p.AssessmentYear', $PmsYId)
            ->where('p.Appraiser_EmployeeID', $EmployeeId)
            ->select([
                'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
                'd.department_name', 'de.designation_name', 'gr.grade_name', 
                'hq.city_village_name', 'st.state_name', 'p.EmpPmsId', 
                'p.CompanyId',
                'p.Kra_filename', 'p.Kra_ext', 'p.Emp_PmsStatus', 'p.Appraiser_PmsStatus','p.Emp_TotalFinalRating','p.Appraiser_TotalFinalRating',
            ])
            ->get();
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        
        $ratings = [1.00, 2.0, 2.5, 2.7, 2.9, 3.0, 3.2, 3.4, 3.5, 3.7, 3.9, 4.0, 4.2, 4.4, 4.5, 4.7, 4.9, 5.0];

        $ratingData = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee.EmpStatus', 'A')
            ->where('hrm_employee.CompanyId', $CompanyId)
            ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
            ->where('hrm_employee_pms.Appraiser_EmployeeID', $EmployeeId)
            ->whereIn('hrm_employee_pms.Appraiser_TotalFinalRating', $ratings) // Fetch only relevant ratings
            ->selectRaw('ROUND(hrm_employee_pms.Appraiser_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating');

        $ratingDataEmployee = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Emp_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Emp_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');
        
        $overallrating = DB::table('hrm_pms_normalrating_dis')
                        ->where('CompanyId', $CompanyId)
                        ->where('YearId', $PmsYId)
                        ->selectRaw('ROUND(Rating, 1) as rating, NormalDistri as count') // Format Rating & select NormalDistri
                        ->orderBy('rating') // Order by rating
                        ->pluck('count', 'rating'); // Convert into associative array
                    

        $totalemployee = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->where('hrm_employee.EmpStatus', 'A')
                ->where('hrm_employee.CompanyId', $CompanyId)
                ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                ->where('hrm_employee_pms.Appraiser_EmployeeID', $EmployeeId)
                ->count();
                
        // Pass everything to the view
        return view("employee.appraiser", compact('exists_appraisel','ratingData','totalemployee','ratings','data',
        'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 'ratingDataEmployee','overallrating',
        'KraYear','ktnew','kfnew',
        'KraYId', 'logicData', 'year_kra','employeedetailsforpms','PmsYId','KraYIdCurr'));
    }

    public function reviewer()
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

     // Fetch year settings
     $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
     $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

     $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
     $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
     if ($keys['emp']->Schedule == 'Y') {
         if ($year_kra->NewY_AllowEntry == 'Y') {
             $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
         } else {
             $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
         }
     } else {
         $KraYId = $year_kra->CurrY;
     }
     $KraYIdCurr = $year_kra->CurrY;
     // Fetch year details
     $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
     $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

     $KraYIdNew = $year_kra->NewY;

     // Fetch year details
     $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
     $year_kra_details_new = DB::table('hrm_year')->where('YearId', $KraYIdNew)->first();

     $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

     // Calculate the years based on FromDate and ToDate for KRA
     $kf = Carbon::parse($year_kra_details->FromDate)->format('Y'); // Year from KRA FromDate
     $kt = Carbon::parse($year_kra_details->ToDate)->format('Y'); // Year from KRA ToDate

     $kfnew = Carbon::parse($year_kra_details_new->FromDate)->format('Y'); // Year from KRA FromDate
     $ktnew = Carbon::parse($year_kra_details_new->ToDate)->format('Y'); // Year from KRA ToDate

     $kt2 = $kf - 1; // Previous year of KRA

     // Calculate the years based on FromDate and ToDate for PMS
     $pf = Carbon::parse($year_pms_details->FromDate)->format('Y'); // Year from PMS FromDate
     $pt = Carbon::parse($year_pms_details->ToDate)->format('Y'); // Year from PMS ToDate
     $pt2 = $pf - 1; // Previous year of PMS


     if ($CompanyId == 1) {
         // For CompanyId 1, store the years without the range
         $KraYear = $kf . '-' . $kt;
         $PmsYear = $pf . '-' . $pt;
     } else {
         // For other CompanyIds, store the years as a range
         $KraYear = $kf . '-' . $kt;
         $PmsYear = $pf . '-' . $pt;
     }

        // Fetching appraisal and KRA schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Checking existing appraisals
        $exists_appraisel = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_reviewer = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_hod = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_mngmt = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        // Fetching all EmployeeIds where Appraiser_EmployeeID = EmployeeId
        $appraisedEmployees = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');  // This will return an array of Employee IDs
        // Fetch all Employee IDs where Appraiser_EmployeeID is the same as $EmployeeId
        $Reviewer_EmployeeID = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');

        $appraisedEmployeesPms = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $PmsYId)
            ->pluck('EmployeeID');


        // Now, use the Employee IDs to fetch the required employee details by joining the necessary tables
        $employeeDetails = DB::table('hrm_employee_general as emp')
            ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
            ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')  // Fixed the join on EmployeeID here
            ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
            ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
            ->whereIn('emp.EmployeeID', $Reviewer_EmployeeID)  // Using whereIn to handle multiple Employee IDs
            ->where('empp.EmpStatus', 'A')  // Using whereIn to handle multiple Employee IDs
            ->select(
                'empp.EmployeeID',
                'empp.EmpCode',
                'empp.Fname',
                'empp.Sname',
                'empp.Lname',
                'dept.department_name',
                'hq.city_village_name',
                'desig.designation_name'
            )
            ->get();
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $employeedetailsforpms = DB::table('hrm_employee as e')
        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        ->join('hrm_employee_pms as p', 'e.EmployeeID', '=', 'p.EmployeeID')
        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
        ->join('core_designation as de', 'g.DesigId', '=', 'de.id')
        ->join('core_grades as gr', 'g.GradeId', '=', 'gr.id')
        ->join('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
        ->join('core_states as st', 'hq.state_id', '=', 'st.id')
        ->where('e.EmpStatus', 'A')
        ->where('p.AssessmentYear', $PmsYId)
        ->where('p.Reviewer_EmployeeID', $EmployeeId)
        ->select([
            'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
            'd.department_name', 'de.designation_name', 'gr.grade_name', 
            'hq.city_village_name', 'st.state_name', 'p.EmpPmsId', 
            'p.Kra_filename', 'p.Kra_ext', 'p.Emp_PmsStatus', 'p.Appraiser_PmsStatus','p.Emp_TotalFinalRating',
            'p.Reviewer_PmsStatus',
            'p.Reviewer_TotalFinalRating',
            'p.Appraiser_TotalFinalRating','p.Appraiser_TotalFinalRating',
        ])
        ->get();

        $ratings = [1.00, 2.0, 2.5, 2.7, 2.9, 3.0, 3.2, 3.4, 3.5, 3.7, 3.9, 4.0, 4.2, 4.4, 4.5, 4.7, 4.9, 5.0];

        $ratingData = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee.EmpStatus', 'A')
            ->where('hrm_employee.CompanyId', $CompanyId)
            ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
            ->where('hrm_employee_pms.Appraiser_EmployeeID', $EmployeeId)
            ->whereIn('hrm_employee_pms.Appraiser_TotalFinalRating', $ratings) // Fetch only relevant ratings
            ->selectRaw('ROUND(hrm_employee_pms.Appraiser_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating');

        $ratingDataEmployee = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Emp_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Emp_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');
        $ratingDataEmployeeReviewer = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Reviewer_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Reviewer_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Reviewer_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');

        $totalemployee = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->where('hrm_employee.EmpStatus', 'A')
                ->where('hrm_employee.CompanyId', $CompanyId)
                ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                ->where('hrm_employee_pms.Reviewer_EmployeeID', $EmployeeId)
                ->count();
                $overallrating = DB::table('hrm_pms_normalrating_dis')
                ->where('CompanyId', $CompanyId)
                ->where('YearId', $PmsYId)
                ->selectRaw('ROUND(Rating, 1) as rating, NormalDistri as count') // Format Rating & select NormalDistri
                ->orderBy('rating') // Order by rating
                ->pluck('count', 'rating'); // Convert into associative array
        return view("employee.reviewer", compact('exists_appraisel','ratingDataEmployeeReviewer','totalemployee',
        'ratingDataEmployee','ratingData','ratings','overallrating','KraYear','ktnew','kfnew',
        'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 
        'KraYId', 'logicData', 'year_kra','employeedetailsforpms','PmsYId','KraYIdCurr'));
    }
    
    public function getKraDetails(Request $request)
    {
        $employeeId = $request->employeeId;
        $kraYId = $request->kraYId;

        // Fetch all KRA for the employee
        $kras = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $employeeId)
            ->where('YearId', $kraYId)
            ->get();

        // Extract all KRA IDs
        $kraIds = $kras->pluck('KRAId')->toArray();

        // Fetch sub-KRAs related to these KRA IDs
        $subKras = DB::table('hrm_pms_krasub')
            ->whereIn('KRAId', $kraIds)
            ->get()
            ->groupBy('KRAId');

        return response()->json([
            'success' => true,
            'kras' => $kras,
            'subKras' => $subKras
        ]);
    }

    public function hod()
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        // Fetch year settings
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
        if ($keys['emp']->Schedule == 'Y') {
            if ($year_kra->NewY_AllowEntry == 'Y') {
                $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
            } else {
                $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
            }
        } else {
            $KraYId = $year_kra->CurrY;
        }
        $KraYIdCurr = $year_kra->CurrY;

        // Fetch year details
        $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
        $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();


        // Fetching appraisal and KRA schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Checking existing appraisals
        $exists_appraisel = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_reviewer = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_hod = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_mngmt = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        // Fetching all EmployeeIds where Appraiser_EmployeeID = EmployeeId
        $appraisedEmployees = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');  // This will return an array of Employee IDs
        // Fetch all Employee IDs where Appraiser_EmployeeID is the same as $EmployeeId
        $Reviewer_EmployeeID = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');


        // Now, use the Employee IDs to fetch the required employee details by joining the necessary tables
        $employeeDetails = DB::table('hrm_employee_general as emp')
            ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
            ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')  // Fixed the join on EmployeeID here
            ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
            ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
            ->whereIn('emp.EmployeeID', $Reviewer_EmployeeID)  // Using whereIn to handle multiple Employee IDs
            ->where('empp.EmpStatus', 'A')  // Using whereIn to handle multiple Employee IDs
            ->select(
                'empp.EmployeeID',
                'empp.EmpCode',
                'empp.Fname',
                'empp.Sname',
                'empp.Lname',
                'dept.department_name',
                'hq.city_village_name',
                'desig.designation_name'
            )
            ->get();
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $employeedetailsforpms = DB::table('hrm_employee as e')
        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        ->join('hrm_employee_pms as p', 'e.EmployeeID', '=', 'p.EmployeeID')
        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
        ->join('core_designation as de', 'g.DesigId', '=', 'de.id')
        ->join('core_grades as gr', 'g.GradeId', '=', 'gr.id')
        ->join('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
        ->join('core_states as st', 'hq.state_id', '=', 'st.id')
        ->where('e.EmpStatus', 'A')
        ->where('p.AssessmentYear', $PmsYId)
        ->where('p.Appraiser_EmployeeID', $EmployeeId)
        ->select([
            'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
            'd.department_name', 'de.designation_name', 'gr.grade_name', 
            'hq.city_village_name', 'st.state_name', 'p.EmpPmsId', 
            'p.Kra_filename', 'p.Kra_ext', 'p.Emp_PmsStatus', 'p.Appraiser_PmsStatus',
            'p.Emp_TotalFinalRating','p.Appraiser_TotalFinalRating','p.Reviewer_PmsStatus','p.Reviewer_TotalFinalRating','p.Reviewer_TotalFinalScore',
            'p.Rev2_PmsStatus','p.Hod_TotalFinalRating'
        ])
        ->get();
        $appraisedEmployeesPms = DB::table('hrm_employee_pms')
        ->where('Appraiser_EmployeeID', $EmployeeId)
        ->where('AssessmentYear', $PmsYId)
        ->pluck('EmployeeID');

        $ratings = [1.00, 2.0, 2.5, 2.7, 2.9, 3.0, 3.2, 3.4, 3.5, 3.7, 3.9, 4.0, 4.2, 4.4, 4.5, 4.7, 4.9, 5.0];

        $ratingData = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee.EmpStatus', 'A')
            ->where('hrm_employee.CompanyId', $CompanyId)
            ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
            ->where('hrm_employee_pms.Appraiser_EmployeeID', $EmployeeId)
            ->whereIn('hrm_employee_pms.Appraiser_TotalFinalRating', $ratings) // Fetch only relevant ratings
            ->selectRaw('ROUND(hrm_employee_pms.Appraiser_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('count', 'rating');

        $ratingDataEmployee = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Appraiser_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Emp_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Emp_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');
        $ratingDataEmployeeReviewer = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Reviewer_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Reviewer_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Reviewer_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');

        $ratingDataEmployeeHod = DB::table('hrm_employee_pms')
                        ->join('hrm_employee', 'hrm_employee_pms.Rev2_EmployeeID', '=', 'hrm_employee.EmployeeID')
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->where('hrm_employee.CompanyId', $CompanyId)
                        ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                        ->whereIn('hrm_employee_pms.EmployeeID', $appraisedEmployeesPms)
                        ->whereIn('hrm_employee_pms.Hod_TotalFinalRating', $ratings) // Fetch only relevant ratings
                        ->selectRaw('ROUND(hrm_employee_pms.Hod_TotalFinalRating, 1) as rating, COUNT(hrm_employee_pms.EmployeeID) as count')
                        ->groupBy('rating')
                        ->orderBy('rating')
                        ->pluck('count', 'rating');

        $totalemployee = DB::table('hrm_employee_pms')
                ->join('hrm_employee', 'hrm_employee_pms.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->where('hrm_employee.EmpStatus', 'A')
                ->where('hrm_employee.CompanyId', $CompanyId)
                ->where('hrm_employee_pms.AssessmentYear', $PmsYId)
                ->where('hrm_employee_pms.Rev2_EmployeeID', $EmployeeId)
                ->count();
                $overallrating = DB::table('hrm_pms_normalrating_dis')
                ->where('CompanyId', $CompanyId)
                ->where('YearId', $PmsYId)
                ->selectRaw('ROUND(Rating, 1) as rating, NormalDistri as count') // Format Rating & select NormalDistri
                ->orderBy('rating') // Order by rating
                ->pluck('count', 'rating'); // Convert into associative array
        // Pass everything to the view
        return view("employee.hod", compact('exists_appraisel', 'exists_reviewer','employeedetailsforpms','PmsYId','overallrating',
        'totalemployee','ratingDataEmployeeReviewer','ratingDataEmployee','ratingData','ratings','ratingDataEmployeeHod',
        'exists_hod', 'exists_mngmt', 'employeeDetails', 'KraYId', 'logicData', 'year_kra','KraYIdCurr'));
    }
    
    public function management()
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        // Fetch year settings
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        // $KraYId = ($keys['emp']->Schedule == 'Y') ? $year_kra->CurrY : (($year_kra->NewY_AllowEntry == 'Y') ? $year_kra->NewY : $year_kra->CurrY);
        // if ($keys['emp']->Schedule == 'Y') {
        //     // If Schedule is 'Y', check if NewY_AllowEntry is 'Y'
        //     if ($year_kra->NewY_AllowEntry == 'Y') {
        //         $KraYId = $year_kra->NewY;  // Set to NewY if NewY_AllowEntry is 'Y'
        //     } else {
        //         $KraYId = $year_kra->CurrY; // Otherwise, set to CurrY
        //     }
        // } else {
        //     // If Schedule is not 'Y', set to CurrY
        //     $KraYId = $year_kra->CurrY;
        // }

        $KraYId = $year_kra->CurrY;
        // Fetch year details
        $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
        $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();


        // Fetching appraisal and KRA schedule
        $appraisal_schedule = DB::table('hrm_pms_appdate')
            ->where('AssessmentYear', $PmsYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        $kra_schedule = DB::table('hrm_pms_kradate')
            ->where('AssessmentYear', $KraYId)
            ->where('CompanyId', $CompanyId)
            ->first();

        // Checking existing appraisals
        $exists_appraisel = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_reviewer = DB::table('hrm_employee_pms')
            ->where('Reviewer_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_hod = DB::table('hrm_employee_pms')
            ->where('Rev2_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();

        $exists_mngmt = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->exists();
        // Fetching all EmployeeIds where Appraiser_EmployeeID = EmployeeId
        $appraisedEmployees = DB::table('hrm_employee_pms')
            ->where('Appraiser_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');  // This will return an array of Employee IDs

        // Fetch all Employee IDs where Appraiser_EmployeeID is the same as $EmployeeId
        $Reviewer_EmployeeID = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $KraYId)
            ->pluck('EmployeeID');


        // Now, use the Employee IDs to fetch the required employee details by joining the necessary tables
        $employeeDetails = DB::table('hrm_employee_general as emp')
            ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
            ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')  // Fixed the join on EmployeeID here
            ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
            ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
            ->whereIn('emp.EmployeeID', $Reviewer_EmployeeID)  // Using whereIn to handle multiple Employee IDs
            ->where('empp.EmpStatus', 'A')  // Using whereIn to handle multiple Employee IDs
            ->select(
                'empp.EmployeeID',
                'empp.EmpCode',
                'empp.Fname',
                'empp.Sname',
                'empp.Lname',
                'dept.department_name',
                'hq.city_village_name',
                'desig.designation_name'
            )
            ->get();
        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $EmployeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();

        // Pass everything to the view
        return view("employee.management", compact('exists_appraisel', 'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 'KraYId', 'logicData', 'year_kra'));
    }
    public function managementAppraisal(){
        $EmployeeId = Auth::user()->EmployeeID;
        $CompanyId = Auth::user()->CompanyId;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        // Fetch year settings
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        $Mang_EmployeeID = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $PmsYId)
            ->pluck('EmployeeID');

            $apra_allowdoj = $year_pms->AllowEmpDoj; // Assuming this is a datetime string
            $DjY = date("Y", strtotime($apra_allowdoj)); // Convert to timestamp first

            $Djmd = date("m-d", strtotime($apra_allowdoj));

            $DjmY2 = $DjY - 1;

            $DojmY2 = date("Y-m-d", strtotime($apra_allowdoj));
            $DojY = $DjmY2 . "-" . $Djmd;

            
        $employeeDetails = DB::table('hrm_employee_general as emp')
        ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
        ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')
        ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
        ->leftJoin('core_grades as grade', 'emp.GradeId', '=', 'grade.id')
        ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
        ->leftJoin('core_regions as region', 'emp.TerrId', '=', 'region.id')
        ->leftJoin('hrm_employee_pms as pms', function ($join) use ($EmployeeId, $PmsYId) {
            $join->on('emp.EmployeeID', '=', 'pms.EmployeeID')
                ->where('pms.HOD_EmployeeID', '=', $EmployeeId)
                ->where('pms.AssessmentYear', '=', $PmsYId);
        })
        // Join with hrm_employee table again to get Appraiser Name
        ->leftJoin('hrm_employee as app', 'pms.Appraiser_EmployeeID', '=', 'app.EmployeeID')
        ->leftJoin('hrm_employee as rev', 'pms.Appraiser_EmployeeID', '=', 'rev.EmployeeID')
        ->leftJoin('hrm_employee as rev2', 'pms.Rev2_EmployeeID', '=', 'rev2.EmployeeID')
        ->whereIn('emp.EmployeeID', $Mang_EmployeeID)
        ->where('empp.EmpStatus', 'A')
        ->select(
            'empp.EmployeeID',
            'emp.DateJoining',
            'emp.DateConfirmationYN',
            'empp.CompanyId',
            'empp.EmpCode',
            'empp.Fname',
            'empp.Sname',
            'empp.Lname',
            'grade.grade_name',
            'dept.department_name',
            'hq.city_village_name',
            'hq.id',
            'region.region_name',
            'desig.designation_name',
            'pms.Emp_TotalFinalScore',
            'pms.Emp_TotalFinalRating',
            'pms.Appraiser_TotalFinalScore',
            'pms.Appraiser_TotalFinalRating',
            'pms.Reviewer_TotalFinalScore',
            'pms.Reviewer_TotalFinalRating',
            'pms.Hod_TotalFinalScore',
            'pms.Hod_TotalFinalRating',
            'pms.AssessmentYear',
            'pms.HodRemark',
            // Appraiser Name
            'app.Fname as Appraiser_Fname',
            'app.Sname as Appraiser_Sname',
            'app.Lname as Appraiser_Lname',
            // Reviewer Name
            'rev.Fname as Reviewer_Fname',
            'rev.Sname as Reviewer_Sname',
            'rev.Lname as Reviewer_Lname',
            // Rev2 Name
            'rev2.Fname as Rev2_Fname',
            'rev2.Sname as Rev2_Sname',
            'rev2.Lname as Rev2_Lname'
        )
        ->get();
            // Fetch FirstRating for each employee
        $employeeDetails->map(function ($employee) use ($DojY, $DojmY2) {
            $employee->FirstRating = '';

            if ($employee->DateConfirmationYN == 'Y' && $employee->DateJoining > $DojY && $employee->DateJoining <= $DojmY2) {
                $rating = DB::table('hrm_employee_confletter')
                    ->where('EmployeeID', $employee->EmployeeID)
                    ->where('Status', 'A')
                    ->orderBy('ConfLetterId', 'DESC')
                    ->value('Rating');

                $employee->FirstRating = $rating ?? '';
            }

            return $employee;
        });
 
        // In your Controller
        $ratings = DB::table('hrm_pms_rating')
        ->where('YearId', $PmsYId)
        ->where('RatingStatus', 'A')
        ->get(); 

        return view("employee.management-score",compact('employeeDetails','ratings','PmsYId'));
    }
    public function managementPromotion(){
        $EmployeeId = Auth::user()->EmployeeID;
        $CompanyId = Auth::user()->CompanyId;

        // Fetch key data for different persons
        $keys = [
            'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
            'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
            'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
            'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
        ];

        // Store extracted values in an array (as you already did)
        $data = [
            'emp' => [
                'Msg' => $keys['emp']->EmpMsg ?? '',
                'Details' => $keys['emp']->PersonalDetails ?? '',
                'Schedule' => $keys['emp']->Schedule ?? '',
                'Appform' => $keys['emp']->AppraisalForm ?? '',
                'Midform' => $keys['emp']->MidPmsForm ?? '',
                'Kraform' => $keys['emp']->KRAForm ?? '',
                'Helpfaq' => $keys['emp']->Help_Faq ?? '',
                'Viewprint' => $keys['emp']->View_Print ?? '',
            ],
            'app' => [
                'Home' => $keys['app']->Home ?? '',
                'Team' => $keys['app']->MyTeam ?? '',
                'Status' => $keys['app']->TeamStatus ?? '',
                'EKform' => $keys['app']->FKraForm ?? '',
                'EPform' => $keys['app']->FPmsForm ?? '',
                'EHform' => $keys['app']->FHistoryForm ?? '',
                'Rating' => $keys['app']->RatingGraph ?? '',
            ],
            'rev' => [
                'Home' => $keys['rev']->Home ?? '',
                'Team' => $keys['rev']->MyTeam ?? '',
                'Status' => $keys['rev']->TeamStatus ?? '',
                'EKform' => $keys['rev']->FKraForm ?? '',
                'EPform' => $keys['rev']->FPmsForm ?? '',
                'EHform' => $keys['rev']->FHistoryForm ?? '',
                'Rating' => $keys['rev']->RatingGraph ?? '',
            ],
            'hod' => [
                'Home' => $keys['hod']->Home ?? '',
                'Team' => $keys['hod']->MyTeam ?? '',
                'Status' => $keys['hod']->TeamStatus ?? '',
                'EKform' => $keys['hod']->FKraForm ?? '',
                'EPform' => $keys['hod']->FPmsForm ?? '',
                'EHform' => $keys['hod']->FHistoryForm ?? '',
                'Score' => $keys['hod']->Score ?? '',
                'Prom' => $keys['hod']->Promotion ?? '',
                'Inc' => $keys['hod']->Increment ?? '',
                'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
                'Increport' => $keys['hod']->IncrementReport ?? '',
                'Rating' => $keys['hod']->RatingGraph ?? '',
            ],
        ];

        // Fetch year settings
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();

        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        $Mang_EmployeeID = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $EmployeeId)
            ->where('AssessmentYear', $PmsYId)
            ->pluck('EmployeeID');

        $employeeDetails = DB::table('hrm_employee_general as emp')
        ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
        ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')
        ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
        ->leftJoin('core_grades as grade', 'emp.GradeId', '=', 'grade.id')
        ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
        ->leftJoin('core_regions as region', 'emp.TerrId', '=', 'region.id')
        ->leftJoin('hrm_employee_pms as pms', function ($join) use ($EmployeeId, $PmsYId) {
            $join->on('emp.EmployeeID', '=', 'pms.EmployeeID')
                ->where('pms.HOD_EmployeeID', '=', $EmployeeId)
                ->where('pms.AssessmentYear', '=', $PmsYId);
        })
        // Fetch Designation Names
        ->leftJoin('core_designation as app_desig', 'pms.Appraiser_EmpDesignation', '=', 'app_desig.id')
        ->leftJoin('core_designation as rev_desig', 'pms.Reviewer_EmpDesignation', '=', 'rev_desig.id')
        ->leftJoin('core_designation as hod_desig', 'pms.Hod_EmpDesignation', '=', 'hod_desig.id')

        // Fetch Grade Names
        ->leftJoin('core_grades as app_grade', 'pms.Appraiser_EmpGrade', '=', 'app_grade.id')
        ->leftJoin('core_grades as rev_grade', 'pms.Reviewer_EmpGrade', '=', 'rev_grade.id')
        ->leftJoin('core_grades as hod_grade', 'pms.Hod_EmpGrade', '=', 'hod_grade.id')

        //hr current grade & designation of employee)

        // Fetch Grade Names
        ->leftJoin('core_grades as hr_grade', 'pms.HR_CurrGradeId', '=', 'hr.id')
        ->leftJoin('core_designation as hr_desig', 'pms.HR_CurrDesigId', '=', 'hr.id')

        // Join with hrm_employee table again to get Appraiser Name
        ->leftJoin('hrm_employee as app', 'pms.Appraiser_EmployeeID', '=', 'app.EmployeeID')
        ->leftJoin('hrm_employee as rev', 'pms.Appraiser_EmployeeID', '=', 'rev.EmployeeID')
        ->leftJoin('hrm_employee as rev2', 'pms.Rev2_EmployeeID', '=', 'rev2.EmployeeID')
        ->whereIn('emp.EmployeeID', $Mang_EmployeeID)
        ->where('empp.EmpStatus', 'A')
        ->select(
            'empp.EmployeeID',
            'emp.DateJoining',
            'emp.DateConfirmationYN',
            'empp.CompanyId',
            'empp.EmpCode',
            'empp.Fname',
            'empp.Sname',
            'empp.Lname',
            'grade.grade_name',
            'dept.department_name',
            'hq.city_village_name',
            'hq.id',
            'region.region_name',
            'desig.designation_name',
            'pms.AssessmentYear',
            // Appraiser Name
            'app.Fname as Appraiser_Fname',
            'app.Sname as Appraiser_Sname',
            'app.Lname as Appraiser_Lname',
            // Reviewer Name
            'rev.Fname as Reviewer_Fname',
            'rev.Sname as Reviewer_Sname',
            'rev.Lname as Reviewer_Lname',
            // Rev2 Name
            'rev2.Fname as Rev2_Fname',
            'rev2.Sname as Rev2_Sname',
            'rev2.Lname as Rev2_Lname'
        )
        ->get();
        dd($employeeDetails);
 
        // In your Controller
        $ratings = DB::table('hrm_pms_rating')
        ->where('YearId', $PmsYId)
        ->where('RatingStatus', 'A')
        ->get(); 

        return view("employee. management-promotion",compact('employeeDetails','ratings','PmsYId'));
    }
    public function managementIncrement(){
        return view("employee.management-increment");
    }
    public function managementReport(){
        return view("employee.management-report");
    }
    public function managementGraph(){
        return view("employee.management-graph");
    }
    public function getDetails(Request $request)
    {
        $kraId = $request->get('kraId');
        $subKraId = $request->get('subKraId');
        $CompanyId = Auth::user()->CompanyId;
        $employeeId = Auth::user()->EmployeeID;
        $yearId = $request->get('year_id');
        $kraData = null;
        $subKraData = null;
        $subKraDatamain = null;
        if ($kraId) {
            // Fetch KRA data
            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                ->where('KRAId', $kraId)
                ->orderBy('NtgtN')
                ->get();
            $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();

            $subKraDatamain = DB::table('hrm_pms_kra')
                ->where('KRAId', $kraId)
                ->select('Logic', 'KRA', 'KRA_Description', 'Weightage', 'Period', 'Target')
                ->first();
        } elseif ($subKraId) {
            // Fetch SubKRA data
            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                ->where('KRASubId', $subKraId)
                ->orderBy('NtgtN')
                ->get();
                $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();
            $subKraData = DB::table('hrm_pms_krasub')
                ->where('KRASubId', $subKraId)
                ->select('Logic', 'KRA', 'KRA_Description', 'Weightage', 'Period', 'Target')
                ->first();
        }


        if ($kraData->isEmpty()) {

            // Fetch company settings
            $setting = DB::table('hrm_pms_setting')
                ->where('CompanyId', $CompanyId)
                ->where('Process', 'KRA')
                ->first();

            if (!$setting) {
                return response()->json(['success' => false, 'message' => 'Company settings not found.']);
            }

            // Fetch employee PMS data
            $employeePms = DB::table('hrm_employee_pms')
                ->where('EmployeeID', $employeeId)
                ->where('AssessmentYear', $setting->CurrY)
                ->first();

            $employeeGeneral = DB::table('hrm_employee_general')
                ->where('EmployeeID', $employeeId)
                ->select('DepartmentId', 'DateJoining')
                ->first();

            if (!$employeeGeneral) {
                return response()->json(['success' => false, 'message' => 'Employee data not found.']);
            }

            $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
            $joiningYear = $dateJoining->year;
            $joiningMonth = $dateJoining->month;

            // Determine Calendar Year or Financial Year
            if ($joiningYear < 2025 && $request->year_id <=13) {
                // Calendar Year (Jan - Dec)
                $startMonth = 1;
                $yearType = 'CY';
                $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
            } else {
                // Financial Year (Apr - Mar)
                $startMonth = 4;
                $yearType = 'FY';
                if ($joiningMonth >= 4) {
                    $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
                } else {
                    $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
                }
            }

            // Define Quarterly and Half-Yearly periods
            $quarters = [
                'Quarter 1' => [1, 2, 3],
                'Quarter 2' => [4, 5, 6],
                'Quarter 3' => [7, 8, 9],
                'Quarter 4' => [10, 11, 12]
            ];

            $halfYears = [
                'Half Year 1' => [1, 2, 3, 4, 5, 6],
                'Half Year 2' => [7, 8, 9, 10, 11, 12]
            ];

            if ($yearType === 'FY') {
                $quarters = [
                    'Q1' => [4, 5, 6],
                    'Q2' => [7, 8, 9],
                    'Q3' => [10, 11, 12],
                    'Q4' => [1, 2, 3]  // Spans to next year
                ];

                $halfYears = [
                    'H1' => [4, 5, 6, 7, 8, 9],
                    'H2' => [10, 11, 12, 1, 2, 3]
                ];
            }

            $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
                return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
            });

            $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
                return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
            });


            // Find the active quarters and half-years
            $joiningQuarter = '';
            $joiningHalfYear = '';

            foreach ($quarters as $q => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningQuarter = $q;
                    break;
                }
            }

            foreach ($halfYears as $h => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningHalfYear = $h;
                    break;
                }
            }


            if ($subKraDatamain) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024 && $request->year_id <=13) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024 &&  $request->year_id <=13) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = date('Y'); // Normal case
                }
                

                // MONTHLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months


                    }
                }


                // HALF-YEARLY DISTRIBUTION
                if ($subKraDatamain->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }
                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                    ->where('KRAId', $kraId)
                    ->orWhere('KRASubId', $subKraId)
                    ->orderBy('NtgtN')
                    ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }

            if ($subKraData) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024 &&  $request->year_id <=13) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024 &&  $request->year_id <=13) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = date('Y'); // Normal case
                }

                // MONTHLY DISTRIBUTION
                if ($subKraData->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraData->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // HALF-YEARLY DISTRIBUTION
                if ($subKraData->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'KRAId' => $kraId ?? 0,
                            'KRASubId' => $subKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }
                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                    ->where('KRAId', $kraId)
                    ->orWhere('KRASubId', $subKraId)
                    ->orderBy('NtgtN')
                    ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }
        }
        else {
            // Fetch company settings
            $setting = DB::table('hrm_pms_setting')
                ->where('CompanyId', $CompanyId)
                ->where('Process', 'KRA')
                ->first();

            if (!$setting) {
                return response()->json(['success' => false, 'message' => 'Company settings not found.']);
            }

            // Fetch employee PMS data
            $employeePms = DB::table('hrm_employee_pms')
                ->where('EmployeeID', $employeeId)
                ->where('AssessmentYear', $setting->CurrY)
                ->first();

            $employeeGeneral = DB::table('hrm_employee_general')
                ->where('EmployeeID', $employeeId)
                ->select('DepartmentId', 'DateJoining')
                ->first();

            if (!$employeeGeneral) {
                return response()->json(['success' => false, 'message' => 'Employee data not found.']);
            }

            $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
            $joiningYear = $dateJoining->year;
            $joiningMonth = $dateJoining->month;

            // Determine Calendar Year or Financial Year
            if ($joiningYear < 2025) {
                // Calendar Year (Jan - Dec)
                $startMonth = 1;
                $yearType = 'CY';
                $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
            } else {
                // Financial Year (Apr - Mar)
                $startMonth = 4;
                $yearType = 'FY';
                if ($joiningMonth >= 4) {
                    $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
                } else {
                    $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
                }
            }

            // Define Quarterly and Half-Yearly periods
            $quarters = [
                'Quarter 1' => [1, 2, 3],
                'Quarter 2' => [4, 5, 6],
                'Quarter 3' => [7, 8, 9],
                'Quarter 4' => [10, 11, 12]
            ];

            $halfYears = [
                'Half Year 1' => [1, 2, 3, 4, 5, 6],
                'Half Year 2' => [7, 8, 9, 10, 11, 12]
            ];

            if ($yearType === 'FY') {
                $quarters = [
                    'Q1' => [4, 5, 6],
                    'Q2' => [7, 8, 9],
                    'Q3' => [10, 11, 12],
                    'Q4' => [1, 2, 3]  // Spans to next year
                ];

                $halfYears = [
                    'H1' => [4, 5, 6, 7, 8, 9],
                    'H2' => [10, 11, 12, 1, 2, 3]
                ];
            }

            $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
                return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
            });

            $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
                return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
            });


            // Find the active quarters and half-years
            $joiningQuarter = '';
            $joiningHalfYear = '';

            foreach ($quarters as $q => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningQuarter = $q;
                    break;
                }
            }

            foreach ($halfYears as $h => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningHalfYear = $h;
                    break;
                }
            }
            if ($subKraDatamain) {
                // Check if period is "1/2 Annual"
                if ($subKraDatamain && in_array($subKraDatamain->Period, ['1/2 Annual'])) {
        
                    $expectedMonths = [
                        'January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];

                    $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];
            
                        // Fetch unique quarter names from Tital for the given KRAId
                        $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
                            ->where('KRAId', $kraId)
                            ->pluck('Tital')
                            ->unique()
                            ->sort()
                            ->values();
                
                    $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                    
                    // Fetch unique month names from Title for the given KRAId
                    $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();

                    $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();

                    if ($hasAllMonths || $hasAllQuarters)  {
                            // Delete all records for this KRAId
                        $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->delete();
                        if($deletemonthly === '12' || $deletemonthly === '4'){
                            $periods = [];

                            // If the joining year is before 2024, always use Calendar Year and start from January
                            if ($joiningYear < 2024) {
                                $yearType = 'CY';
                                $joiningMonth = 1;
                                $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                            } else {
                                $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                $effectiveYear = $joiningYear; // Normal case
                            }
            
                            // MONTHLY DISTRIBUTION
                            if ($subKraDatamain->Period == 'Monthly') {
                                $serialNumber = 1; // Start serial number for active months
 
                                $countRow = 12;
                                $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                                $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
                                $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);
            
                                for ($i = 0; $i < $countRow; $i++) {
                                    if ($yearType === 'CY') {
                                        $month = $i + 1;
                                    } else {
                                        $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                                    }
            
                                    // Always active for pre-2024 employees
                                    $isActive = ($joiningYear < 2024) ||
                                        ($yearType === 'CY' && $month >= $joiningMonth) ||
                                        ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));
            
                                    $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();
            
                                    $periods[] = [
                                        'KRAId' => $kraId ?? 0,
                                        'KRASubId' => $subKraId ?? 0,
                                        'EmployeeID' => $employeeId,
                                        'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                                        'Ldate' => $dueDate,
                                        'Wgt' => $isActive ? $weightagePerPeriod : 0,
                                        'Tgt' => $isActive ? $targetPerPeriod : 0,
                                        'NtgtN' => $serialNumber, // Assign incremental S.No.
                                        'Ach' => 0,
                                        'Remark' => $subKraDatamain->KRA ?? '',
                                        'Cmnt' => '',
                                        'LogScr' => 0,
                                        'Scor' => 0,
                                        'lockk' => 0,
                                        'AppLogScr' => 0,
                                        'AppScor' => 0,
                                        'AppAch' => 0,
                                        'AppCmnt' => '',
                                        'RevCmnt' => '',
                                    ];
                                    $serialNumber++; // Increment S.No. only for active months

                                }
                            }
            
                            // QUARTERLY DISTRIBUTION
                            if ($subKraDatamain->Period == 'Quarter') {
                                $serialNumber = 1; // Start serial number for active months
 
                                $isCalendarYear = ($joiningYear <= 2024);
                                $quarters = $isCalendarYear
                                    ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                                    : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];
            
                                $joiningQuarter = ($joiningYear < 2024) ? 1 : null;
            
                                if (!$joiningQuarter) {
                                    foreach ($quarters as $q => $months) {
                                        if (in_array($joiningMonth, $months)) {
                                            $joiningQuarter = $q;
                                            break;
                                        }
                                    }
                                }
            
                                // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                                foreach ([1, 2, 3, 4] as $q) {
                                    $months = $quarters[$q];
                                    $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                                    $lastMonth = max($months);
                                    $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
            
                                    $periods[] = [
                                        'KRAId' => $kraId ?? 0,
                                        'KRASubId' => $subKraId ?? 0,
                                        'EmployeeID' => $employeeId,
                                        'Tital' => "Quarter " . $q,
                                        'Ldate' => $dueDate,
                                        'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
                                        'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
                                        'NtgtN' => $serialNumber, // Assign incremental S.No.
                                        'Ach' => 0,
                                        'Remark' => $subKraDatamain->KRA ?? '',
                                        'Cmnt' => '',
                                        'LogScr' => 0,
                                        'Scor' => 0,
                                        'lockk' => 0,
                                        'AppLogScr' => 0,
                                        'AppScor' => 0,
                                        'AppAch' => 0,
                                        'AppCmnt' => '',
                                        'RevCmnt' => '',
                                    ];
                                    $serialNumber++; // Increment S.No. only for active months

                                }
                            }
            
                            DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                            // Fetch the newly inserted data
                            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->orWhere('KRASubId', $subKraId)
                                ->orderBy('NtgtN')
                                ->get();
                            return response()->json([
                                'success' => true,
                                'kraData' => $kraData,
                                'subKraData' => $subKraData,
                                'subKraDatamain' => $subKraDatamain,
                            ]);
                        }
                    }
                }
                if ($subKraDatamain && in_array($subKraDatamain->Period, ['Quarter'])) {    
                    
     
        
                        $expectedHalf = ['Half-Year 2','Half-Year 1'];
                        $expectedMonths = [
                                    'January', 'February', 'March', 'April', 'May', 'June', 
                                    'July', 'August', 'September', 'October', 'November', 'December'
                                ];
                        // Fetch unique quarter names from Tital for the given KRAId
                        $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
                            ->where('KRAId', $kraId)
                            ->pluck('Tital')
                            ->unique()
                            ->sort()
                            ->values();
                
                        $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
                    // Fetch unique month names from Title for the given KRAId
                            $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->pluck('Tital')
                                ->unique()
                                ->sort()
                                ->values();

                        $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();
                        if ($hasAllHalf || $hasAllMonths) {
                                // Delete all records for this KRAId
                            $deleteHalf = DB::table('hrm_pms_kra_tgtdefin')
                                    ->where('KRAId', $kraId)
                                    ->delete();
                        
                            if($deleteHalf === '2'|| $deleteHalf === '12'){
                                $periods = [];
                    
                                // If the joining year is before 2024, always use Calendar Year and start from January
                                if ($joiningYear < 2024) {
                                    $yearType = 'CY';
                                    $joiningMonth = 1;
                                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                                } else {
                                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                    $effectiveYear = $joiningYear; // Normal case
                                }
                    
                                // MONTHLY DISTRIBUTION
                                if ($subKraDatamain->Period == 'Monthly') {
                                    $serialNumber = 1; // Start serial number for active months
 
                                    $countRow = 12;
                                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                                    $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
                                    $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);
                    
                                    for ($i = 0; $i < $countRow; $i++) {
                                        if ($yearType === 'CY') {
                                            $month = $i + 1;
                                        } else {
                                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                                        }
                    
                                        // Always active for pre-2024 employees
                                        $isActive = ($joiningYear < 2024) ||
                                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));
                    
                                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();
                    
                                        $periods[] = [
                                            'KRAId' => $kraId ?? 0,
                                            'KRASubId' => $subKraId ?? 0,
                                            'EmployeeID' => $employeeId,
                                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                                            'Ldate' => $dueDate,
                                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                                            'Ach' => 0,
                                            'Remark' => $subKraDatamain->KRA ?? '',
                                            'Cmnt' => '',
                                            'LogScr' => 0,
                                            'Scor' => 0,
                                            'lockk' => 0,
                                            'AppLogScr' => 0,
                                            'AppScor' => 0,
                                            'AppAch' => 0,
                                            'AppCmnt' => '',
                                            'RevCmnt' => '',
                                        ];
                                        $serialNumber++; // Increment S.No. only for active months

                                    }
                                }
                    
                                // HALF-YEARLY DISTRIBUTION
                                if ($subKraDatamain->Period == '1/2 Annual') {
                                    $serialNumber = 1; // Start serial number for active months

                                    $isCalendarYear = ($joiningYear <= 2024);
                    
                                    // Always ensure Half-Year 1 appears before Half-Year 2
                                    if ($isCalendarYear) {
                                        $halfYears = [
                                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                                        ];
                                    } else {
                                        $halfYears = [
                                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                                        ];
                                    }
                    
                                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;
                    
                                    if (!$joiningHalfYear) {
                                        foreach ($halfYears as $h => $months) {
                                            if (in_array($joiningMonth, $months)) {
                                                $joiningHalfYear = $h;
                                                break;
                                            }
                                        }
                                    }
                    
                                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                                    foreach ([1, 2] as $h) {
                                        $months = $halfYears[$h];
                                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                                        $lastMonth = max($months);
                                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                    
                                        $periods[] = [
                                            'KRAId' => $kraId ?? 0,
                                            'KRASubId' => $subKraId ?? 0,
                                            'EmployeeID' => $employeeId,
                                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                                            'Ldate' => $dueDate,
                                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
                                            'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
                                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                                            'Ach' => 0,
                                            'Remark' => $subKraDatamain->KRA ?? '',
                                            'Cmnt' => '',
                                            'LogScr' => 0,
                                            'Scor' => 0,
                                            'lockk' => 0,
                                            'AppLogScr' => 0,
                                            'AppScor' => 0,
                                            'AppAch' => 0,
                                            'AppCmnt' => '',
                                            'RevCmnt' => '',
                                        ];
                                        $serialNumber++; // Increment S.No. only for active months

                                    }
                                }
                                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                                // Fetch the newly inserted data
                                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                    ->where('KRAId', $kraId)
                                    ->orderBy('NtgtN')
                                    ->get();
                                return response()->json([
                                    'success' => true,
                                    'kraData' => $kraData,
                                    'subKraData' => $subKraData,
                                    'subKraDatamain' => $subKraDatamain,
                                ]);
                            }
                        }
                }
                if ($subKraDatamain && in_array($subKraDatamain->Period, ['Monthly'])) {        
        
                    $expectedHalf = ['Half-Year 2','Half-Year 1'];
                    $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];

                    // Fetch unique quarter names from Tital for the given KRAId
                    $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();

                    // Fetch unique quarter names from Tital for the given KRAId
                    $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();
            
                    $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
                    $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                

                    if ($hasAllHalf || $hasAllQuarters) {
                            // Delete all records for this KRAId
                        $deleteHalf = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->delete();
                        if($deleteHalf === '2' || $deleteHalf === '4'){
                            $periods = [];
                
                            // If the joining year is before 2024, always use Calendar Year and start from January
                            if ($joiningYear < 2024) {
                                $yearType = 'CY';
                                $joiningMonth = 1;
                                $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                            } else {
                                $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                $effectiveYear = $joiningYear; // Normal case
                            }
                
                        
                            // QUARTERLY DISTRIBUTION
                            if ($subKraDatamain->Period == 'Quarter') {
                                $serialNumber = 1; // Start serial number for active months
 
                                $isCalendarYear = ($joiningYear <= 2024);
                                $quarters = $isCalendarYear
                                    ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                                    : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];
                
                                $joiningQuarter = ($joiningYear < 2024) ? 1 : null;
                
                                if (!$joiningQuarter) {
                                    foreach ($quarters as $q => $months) {
                                        if (in_array($joiningMonth, $months)) {
                                            $joiningQuarter = $q;
                                            break;
                                        }
                                    }
                                }
                
                                // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                                foreach ([1, 2, 3, 4] as $q) {
                                    $months = $quarters[$q];
                                    $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                                    $lastMonth = max($months);
                                    $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                
                                    $periods[] = [
                                        'KRAId' => $kraId ?? 0,
                                        'KRASubId' => $subKraId ?? 0,
                                        'EmployeeID' => $employeeId,
                                        'Tital' => "Quarter " . $q,
                                        'Ldate' => $dueDate,
                                        'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
                                        'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
                                        'NtgtN' => $serialNumber, // Assign incremental S.No.
                                        'Ach' => 0,
                                        'Remark' => $subKraDatamain->KRA ?? '',
                                        'Cmnt' => '',
                                        'LogScr' => 0,
                                        'Scor' => 0,
                                        'lockk' => 0,
                                        'AppLogScr' => 0,
                                        'AppScor' => 0,
                                        'AppAch' => 0,
                                        'AppCmnt' => '',
                                        'RevCmnt' => '',
                                    ];
                                    $serialNumber++; // Increment S.No. only for active months

                                }
                            }
                
                
                            // HALF-YEARLY DISTRIBUTION
                            if ($subKraDatamain->Period == '1/2 Annual') {
                                $serialNumber = 1; // Start serial number for active months
 
                                $isCalendarYear = ($joiningYear <= 2024);
                
                                // Always ensure Half-Year 1 appears before Half-Year 2
                                if ($isCalendarYear) {
                                    $halfYears = [
                                        1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                                        2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                                    ];
                                } else {
                                    $halfYears = [
                                        1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                                        2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                                    ];
                                }
                
                                $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;
                
                                if (!$joiningHalfYear) {
                                    foreach ($halfYears as $h => $months) {
                                        if (in_array($joiningMonth, $months)) {
                                            $joiningHalfYear = $h;
                                            break;
                                        }
                                    }
                                }
                
                                // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                                foreach ([1, 2] as $h) {
                                    $months = $halfYears[$h];
                                    $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                                    $lastMonth = max($months);
                                    $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                
                                    $periods[] = [
                                        'KRAId' => $kraId ?? 0,
                                        'KRASubId' => $subKraId ?? 0,
                                        'EmployeeID' => $employeeId,
                                        'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                                        'Ldate' => $dueDate,
                                        'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
                                        'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
                                        'NtgtN' => $serialNumber, // Assign incremental S.No.
                                        'Ach' => 0,
                                        'Remark' => $subKraDatamain->KRA ?? '',
                                        'Cmnt' => '',
                                        'LogScr' => 0,
                                        'Scor' => 0,
                                        'lockk' => 0,
                                        'AppLogScr' => 0,
                                        'AppScor' => 0,
                                        'AppAch' => 0,
                                        'AppCmnt' => '',
                                        'RevCmnt' => '',
                                    ];
                                    $serialNumber++; // Increment S.No. only for active months

                                }
                            }
                            DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                            // Fetch the newly inserted data
                            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->orderBy('NtgtN')
                                ->get();
                            return response()->json([
                                'success' => true,
                                'kraData' => $kraData,
                                'subKraData' => $subKraData,
                                'subKraDatamain' => $subKraDatamain,
                            ]);
                        }
                    }
                }
            
            }
            if ($subKraData) {
                // Check if period is "1/2 Annual"
                if ($subKraData && in_array($subKraData->Period, ['1/2 Annual'])) {
        
                    $expectedMonths = [
                        'January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];

                    $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];
            
                        // Fetch unique quarter names from Tital for the given KRAId
                        $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
                            ->where('KRAId', $kraId)
                            ->pluck('Tital')
                            ->unique()
                            ->sort()
                            ->values();
                
                    $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                    
                    // Fetch unique month names from Title for the given KRAId
                    $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();

                    $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();

                    if ($hasAllMonths || $hasAllQuarters)  {
                            // Delete all records for this KRAId
                                $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
                                        ->where('KRAId', $kraId)
                                        ->delete();
                                if($deletemonthly === '12' || $deletemonthly === '4'){
                                    $periods = [];

                                // If the joining year is before 2024, always use Calendar Year and start from January
                                if ($joiningYear < 2024) {
                                    $yearType = 'CY';
                                    $joiningMonth = 1;
                                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                                } else {
                                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                    $effectiveYear = $joiningYear; // Normal case
                                }

                                // MONTHLY DISTRIBUTION
                                if ($subKraData->Period == 'Monthly') {
                                    $serialNumber = 1; // Start serial number for active months
 
                                    $countRow = 12;
                                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                                    $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
                                    $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

                                    for ($i = 0; $i < $countRow; $i++) {
                                        if ($yearType === 'CY') {
                                            $month = $i + 1;
                                        } else {
                                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                                        }

                                        // Always active for pre-2024 employees
                                        $isActive = ($joiningYear < 2024) ||
                                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                                        $periods[] = [
                                            'KRAId' => $kraId ?? 0,
                                            'KRASubId' => $subKraId ?? 0,
                                            'EmployeeID' => $employeeId,
                                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                                            'Ldate' => $dueDate,
                                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                                            'Ach' => 0,
                                            'Remark' => $subKraData->KRA ?? '',
                                            'Cmnt' => '',
                                            'LogScr' => 0,
                                            'Scor' => 0,
                                            'lockk' => 0,
                                            'AppLogScr' => 0,
                                            'AppScor' => 0,
                                            'AppAch' => 0,
                                            'AppCmnt' => '',
                                            'RevCmnt' => '',
                                        ];
                                        $serialNumber++; // Increment S.No. only for active months

                                    }
                                }

                                // QUARTERLY DISTRIBUTION
                                if ($subKraData->Period == 'Quarter') {
                                    $serialNumber = 1; // Start serial number for active months
 
                                    $isCalendarYear = ($joiningYear <= 2024);
                                    $quarters = $isCalendarYear
                                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                                    if (!$joiningQuarter) {
                                        foreach ($quarters as $q => $months) {
                                            if (in_array($joiningMonth, $months)) {
                                                $joiningQuarter = $q;
                                                break;
                                            }
                                        }
                                    }

                                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                                    foreach ([1, 2, 3, 4] as $q) {
                                        $months = $quarters[$q];
                                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                                        $lastMonth = max($months);
                                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                                        $periods[] = [
                                            'KRAId' => $kraId ?? 0,
                                            'KRASubId' => $subKraId ?? 0,
                                            'EmployeeID' => $employeeId,
                                            'Tital' => "Quarter " . $q,
                                            'Ldate' => $dueDate,
                                            'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
                                            'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
                                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                                            'Ach' => 0,
                                            'Remark' => $subKraData->KRA ?? '',
                                            'Cmnt' => '',
                                            'LogScr' => 0,
                                            'Scor' => 0,
                                            'lockk' => 0,
                                            'AppLogScr' => 0,
                                            'AppScor' => 0,
                                            'AppAch' => 0,
                                            'AppCmnt' => '',
                                            'RevCmnt' => '',
                                        ];
                                        $serialNumber++; // Increment S.No. only for active months

                                    }
                                }

                                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                                // Fetch the newly inserted data
                                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                    ->where('KRAId', $kraId)
                                    ->orWhere('KRASubId', $subKraId)
                                    ->orderBy('NtgtN')
                                    ->get();
                                return response()->json([
                                    'success' => true,
                                    'kraData' => $kraData,
                                    'subKraData' => $subKraData,
                                    'subKraDatamain' => $subKraDatamain,
                                ]);
                                }
                    }
                }
                if ($subKraData && in_array($subKraData->Period, ['Quarter'])) {
        
                    $expectedHalf = ['Half-Year 2','Half-Year 1'];
                      $expectedMonths = [
                                  'January', 'February', 'March', 'April', 'May', 'June', 
                                  'July', 'August', 'September', 'October', 'November', 'December'
                              ];
                      // Fetch unique quarter names from Tital for the given KRAId
                      $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
                          ->where('KRAId', $kraId)
                          ->pluck('Tital')
                          ->unique()
                          ->sort()
                          ->values();
              
                      $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
                  // Fetch unique month names from Title for the given KRAId
                          $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
                              ->where('KRAId', $kraId)
                              ->pluck('Tital')
                              ->unique()
                              ->sort()
                              ->values();

                      $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();
                      if ($hasAllHalf || $hasAllMonths) {
                          // Delete all records for this KRAId
                              $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
                                      ->where('KRAId', $kraId)
                                      ->delete();
                              if($deletemonthly === '12' || $deletemonthly === '2'){
                                  $periods = [];

                              // If the joining year is before 2024, always use Calendar Year and start from January
                              if ($joiningYear < 2024) {
                                  $yearType = 'CY';
                                  $joiningMonth = 1;
                                  $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                              } else {
                                  $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                  $effectiveYear = $joiningYear; // Normal case
                              }

                              // MONTHLY DISTRIBUTION
                              if ($subKraData->Period == 'Monthly') {
                                $serialNumber = 1; // Start serial number for active months

                                  $countRow = 12;
                                  $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                                  $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
                                  $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

                                  for ($i = 0; $i < $countRow; $i++) {
                                      if ($yearType === 'CY') {
                                          $month = $i + 1;
                                      } else {
                                          $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                                      }

                                      // Always active for pre-2024 employees
                                      $isActive = ($joiningYear < 2024) ||
                                          ($yearType === 'CY' && $month >= $joiningMonth) ||
                                          ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                                      $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                                      $periods[] = [
                                          'KRAId' => $kraId ?? 0,
                                          'KRASubId' => $subKraId ?? 0,
                                          'EmployeeID' => $employeeId,
                                          'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                                          'Ldate' => $dueDate,
                                          'Wgt' => $isActive ? $weightagePerPeriod : 0,
                                          'Tgt' => $isActive ? $targetPerPeriod : 0,
                                          'NtgtN' => $serialNumber, // Assign incremental S.No.
                                          'Ach' => 0,
                                          'Remark' => $subKraData->KRA ?? '',
                                          'Cmnt' => '',
                                          'LogScr' => 0,
                                          'Scor' => 0,
                                          'lockk' => 0,
                                          'AppLogScr' => 0,
                                          'AppScor' => 0,
                                          'AppAch' => 0,
                                          'AppCmnt' => '',
                                          'RevCmnt' => '',
                                      ];
                                      $serialNumber++; // Increment S.No. only for active months

                                  }
                              }

                              // HALF-YEARLY DISTRIBUTION
                              if ($subKraData->Period == '1/2 Annual') {
                                  $isCalendarYear = ($joiningYear <= 2024);
                                  $serialNumber = 1; // Start serial number for active months
 
                                  // Always ensure Half-Year 1 appears before Half-Year 2
                                  if ($isCalendarYear) {
                                      $halfYears = [
                                          1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                                          2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                                      ];
                                  } else {
                                      $halfYears = [
                                          1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                                          2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                                      ];
                                  }

                                  $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                                  if (!$joiningHalfYear) {
                                      foreach ($halfYears as $h => $months) {
                                          if (in_array($joiningMonth, $months)) {
                                              $joiningHalfYear = $h;
                                              break;
                                          }
                                      }
                                  }

                                  // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                                  foreach ([1, 2] as $h) {
                                      $months = $halfYears[$h];
                                      $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                                      $lastMonth = max($months);
                                      $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                                      $periods[] = [
                                          'KRAId' => $kraId ?? 0,
                                          'KRASubId' => $subKraId ?? 0,
                                          'EmployeeID' => $employeeId,
                                          'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                                          'Ldate' => $dueDate,
                                          'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
                                          'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
                                          'NtgtN' => $serialNumber, // Assign incremental S.No.
                                          'Ach' => 0,
                                          'Remark' => $subKraData->KRA ?? '',
                                          'Cmnt' => '',
                                          'LogScr' => 0,
                                          'Scor' => 0,
                                          'lockk' => 0,
                                          'AppLogScr' => 0,
                                          'AppScor' => 0,
                                          'AppAch' => 0,
                                          'AppCmnt' => '',
                                          'RevCmnt' => '',
                                      ];
                                      $serialNumber++; // Increment S.No. only for active months

                                  }
                              }
                              DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                              // Fetch the newly inserted data
                              $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                  ->where('KRAId', $kraId)
                                  ->orWhere('KRASubId', $subKraId)
                                  ->orderBy('NtgtN')
                                  ->get();
                              return response()->json([
                                  'success' => true,
                                  'kraData' => $kraData,
                                  'subKraData' => $subKraData,
                                  'subKraDatamain' => $subKraDatamain,
                              ]);
                              }
                  }
                }
                if ($subKraData && in_array($subKraData->Period, ['Monthly'])) {
        
                   
                    $expectedHalf = ['Half-Year 2','Half-Year 1'];
                    $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];

                    // Fetch unique quarter names from Tital for the given KRAId
                    $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();

                    // Fetch unique quarter names from Tital for the given KRAId
                    $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('KRAId', $kraId)
                        ->pluck('Tital')
                        ->unique()
                        ->sort()
                        ->values();
            
                    $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
                    $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                

                    if ($hasAllHalf || $hasAllQuarters) {
                          // Delete all records for this KRAId
                              $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
                                      ->where('KRAId', $kraId)
                                      ->delete();
                              if($deletemonthly === '2' || $deletemonthly === '4'){
                                  $periods = [];

                              // If the joining year is before 2024, always use Calendar Year and start from January
                              if ($joiningYear < 2024) {
                                  $yearType = 'CY';
                                  $joiningMonth = 1;
                                  $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                              } else {
                                  $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                                  $effectiveYear = $joiningYear; // Normal case
                              }

                              // QUARTERLY DISTRIBUTION
                              if ($subKraData->Period == 'Quarter') {
                                $serialNumber = 1; // Start serial number for active months
 
                                  $isCalendarYear = ($joiningYear <= 2024);
                                  $quarters = $isCalendarYear
                                      ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                                      : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                                  $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                                  if (!$joiningQuarter) {
                                      foreach ($quarters as $q => $months) {
                                          if (in_array($joiningMonth, $months)) {
                                              $joiningQuarter = $q;
                                              break;
                                          }
                                      }
                                  }

                                  // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                                  foreach ([1, 2, 3, 4] as $q) {
                                      $months = $quarters[$q];
                                      $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                                      $lastMonth = max($months);
                                      $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                                      $periods[] = [
                                          'KRAId' => $kraId ?? 0,
                                          'KRASubId' => $subKraId ?? 0,
                                          'EmployeeID' => $employeeId,
                                          'Tital' => "Quarter " . $q,
                                          'Ldate' => $dueDate,
                                          'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
                                          'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
                                          'NtgtN' => $serialNumber, // Assign incremental S.No.
                                          'Ach' => 0,
                                          'Remark' => $subKraData->KRA ?? '',
                                          'Cmnt' => '',
                                          'LogScr' => 0,
                                          'Scor' => 0,
                                          'lockk' => 0,
                                          'AppLogScr' => 0,
                                          'AppScor' => 0,
                                          'AppAch' => 0,
                                          'AppCmnt' => '',
                                          'RevCmnt' => '',
                                      ];
                                      $serialNumber++; // Increment S.No. only for active months

                                  }
                              }


                              // HALF-YEARLY DISTRIBUTION
                              if ($subKraData->Period == '1/2 Annual') {
                                $serialNumber = 1; // Start serial number for active months
 
                                  $isCalendarYear = ($joiningYear <= 2024);

                                  // Always ensure Half-Year 1 appears before Half-Year 2
                                  if ($isCalendarYear) {
                                      $halfYears = [
                                          1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                                          2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                                      ];
                                  } else {
                                      $halfYears = [
                                          1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                                          2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                                      ];
                                  }

                                  $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                                  if (!$joiningHalfYear) {
                                      foreach ($halfYears as $h => $months) {
                                          if (in_array($joiningMonth, $months)) {
                                              $joiningHalfYear = $h;
                                              break;
                                          }
                                      }
                                  }

                                  // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                                  foreach ([1, 2] as $h) {
                                      $months = $halfYears[$h];
                                      $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                                      $lastMonth = max($months);
                                      $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                                      $periods[] = [
                                          'KRAId' => $kraId ?? 0,
                                          'KRASubId' => $subKraId ?? 0,
                                          'EmployeeID' => $employeeId,
                                          'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                                          'Ldate' => $dueDate,
                                          'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
                                          'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
                                          'NtgtN' => $serialNumber, // Assign incremental S.No.
                                          'Ach' => 0,
                                          'Remark' => $subKraData->KRA ?? '',
                                          'Cmnt' => '',
                                          'LogScr' => 0,
                                          'Scor' => 0,
                                          'lockk' => 0,
                                          'AppLogScr' => 0,
                                          'AppScor' => 0,
                                          'AppAch' => 0,
                                          'AppCmnt' => '',
                                          'RevCmnt' => '',
                                      ];
                                      $serialNumber++; // Increment S.No. only for active months

                                  }
                              }
                              DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                              // Fetch the newly inserted data
                              $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                  ->where('KRAId', $kraId)
                                  ->orWhere('KRASubId', $subKraId)
                                  ->orderBy('NtgtN')
                                  ->get();
                              return response()->json([
                                  'success' => true,
                                  'kraData' => $kraData,
                                  'subKraData' => $subKraData,
                                  'subKraDatamain' => $subKraDatamain,
                              ]);
                              }
                  }
                }
            }
        }
        
    
        return response()->json([
            'success' => true,  // Add success flag
            'kraData' => $kraData,
            'subKraData' => $subKraData,
            'pmsData' => $pmsData,
            'subKraDatamain' => $subKraDatamain,
        ], 200);
    }
    public function getDetailsformb(Request $request)
    {
        $FormBId = $request->get('kraId');
        $FormBsubKraId = $request->get('subKraId');
        // $employeeId = $request->get('Empid');

        $employeeId = $request->Empid;


        $CompanyId = Auth::user()->CompanyId;
        // $employeeId = Auth::user()->EmployeeID;
        $yearId = $request->get('year_id');
        $kraData = null;
        $subKraData = null;
        $subKraDatamain = null;
        if ($FormBId) {

            // Fetch KRA data
            $kraData = DB::table('hrm_pms_formb_tgtdefin')
                ->where('FormBId', $FormBId)
                ->where('EmployeeID', $employeeId)
                ->where('YearId', $yearId)
                ->orderBy('NtgtN')
                ->get();
            $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();

                $subKraDatamain = DB::table('hrm_pms_formb')->select('Skill', 'SkillComment','Period','Weightage','Target','Logic')
                ->join('hrm_employee_pms_behavioralformb as efb', 'efb.FormBId', '=', 'hrm_pms_formb.FormBId')
                ->where('efb.FormBId', $FormBId)
                ->first();
        } elseif ($FormBsubKraId) {
            // Fetch SubKRA data
            
                $kraData = DB::table('hrm_pms_formb_tgtdefin')
                ->where('FormBSubId', $FormBsubKraId)
                ->where('EmployeeID', $employeeId)
                ->where('YearId', $yearId)
                ->orderBy('NtgtN')
                ->get();
                $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();
            
                $subKraData = DB::table('hrm_employee_pms_behavioralformb_sub as efbs')
                                ->join('hrm_pms_formbsub as fbs', 'efbs.FormBSubId', '=', 'fbs.FormBSubId')
                                ->where('efbs.FormBSubId', $FormBsubKraId)
                                ->select('fbs.Skill', 'fbs.SkillComment','fbs.Period','fbs.Target','fbs.Weightage','fbs.Logic')
                                ->first();
        }

        if ($kraData->isEmpty()) {

            // Fetch company settings
            $setting = DB::table('hrm_pms_setting')
                ->where('CompanyId', $CompanyId)
                ->where('Process', 'KRA')
                ->first();

            if (!$setting) {
                return response()->json(['success' => false, 'message' => 'Company settings not found.']);
            }

            // Fetch employee PMS data
            $employeePms = DB::table('hrm_employee_pms')
                ->where('EmployeeID', $employeeId)
                ->where('AssessmentYear', $setting->CurrY)
                ->first();

            $employeeGeneral = DB::table('hrm_employee_general')
                ->where('EmployeeID', $employeeId)
                ->select('DepartmentId', 'DateJoining')
                ->first();

            if (!$employeeGeneral) {
                return response()->json(['success' => false, 'message' => 'Employee data not found.']);
            }

            $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
            $joiningYear = $dateJoining->year;
            $joiningMonth = $dateJoining->month;

            // Determine Calendar Year or Financial Year
            if ($joiningYear < 2025) {
                // Calendar Year (Jan - Dec)
                $startMonth = 1;
                $yearType = 'CY';
                $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
            } else {
                // Financial Year (Apr - Mar)
                $startMonth = 4;
                $yearType = 'FY';
                if ($joiningMonth >= 4) {
                    $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
                } else {
                    $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
                }
            }

            // Define Quarterly and Half-Yearly periods
            $quarters = [
                'Quarter 1' => [1, 2, 3],
                'Quarter 2' => [4, 5, 6],
                'Quarter 3' => [7, 8, 9],
                'Quarter 4' => [10, 11, 12]
            ];

            $halfYears = [
                'Half Year 1' => [1, 2, 3, 4, 5, 6],
                'Half Year 2' => [7, 8, 9, 10, 11, 12]
            ];

            if ($yearType === 'FY') {
                $quarters = [
                    'Q1' => [4, 5, 6],
                    'Q2' => [7, 8, 9],
                    'Q3' => [10, 11, 12],
                    'Q4' => [1, 2, 3]  // Spans to next year
                ];

                $halfYears = [
                    'H1' => [4, 5, 6, 7, 8, 9],
                    'H2' => [10, 11, 12, 1, 2, 3]
                ];
            }

            $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
                return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
            });

            $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
                return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
            });


            // Find the active quarters and half-years
            $joiningQuarter = '';
            $joiningHalfYear = '';

            foreach ($quarters as $q => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningQuarter = $q;
                    break;
                }
            }

            foreach ($halfYears as $h => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningHalfYear = $h;
                    break;
                }
            }


            if ($subKraDatamain) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = $joiningYear; // Normal case
                }

                // MONTHLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }


                // HALF-YEARLY DISTRIBUTION
                if ($subKraDatamain->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }
                DB::table('hrm_pms_formb_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_formb_tgtdefin')
                                            ->where('FormBId', $FormBId)
                                            ->where('EmployeeID', $employeeId)
                                            ->where('YearId', $yearId)
                                            ->orderBy('NtgtN')
                                            ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }

            if ($subKraData) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = $joiningYear; // Normal case
                }

                // MONTHLY DISTRIBUTION
                if ($subKraData->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraData->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // HALF-YEARLY DISTRIBUTION
                if ($subKraData->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }
                DB::table('hrm_pms_formb_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
          
                $kraData = DB::table('hrm_pms_formb_tgtdefin')->where('EmployeeID', $employeeId)
                        ->where('YearId', $yearId)
                        ->orderBy('NtgtN')
                        ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }
        }     
    
        return response()->json([
            'success' => true,  // Add success flag
            'kraData' => $kraData,
            'subKraData' => $subKraData,
            'pmsData' => $pmsData,
            'subKraDatamain' => $subKraDatamain,
        ], 200);
    }
    public function getDetailsformbemployee(Request $request)
    {
        $FormBId = $request->get('kraId');
        $FormBsubKraId = $request->get('subKraId');

        $CompanyId = Auth::user()->CompanyId;
        $employeeId = Auth::user()->EmployeeID;
        $yearId = $request->get('year_id');
        $kraData = null;
        $subKraData = null;
        $subKraDatamain = null;
        if ($FormBId) {

            // Fetch KRA data
            $kraData = DB::table('hrm_pms_formb_tgtdefin')
                ->where('FormBId', $FormBId)
                ->where('EmployeeID', $employeeId)
                ->where('YearId', $yearId)
                ->orderBy('NtgtN')
                ->get();
            $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();

                $subKraDatamain = DB::table('hrm_pms_formb')->select('Skill', 'SkillComment','Period','Weightage','Target','Logic')
                ->join('hrm_employee_pms_behavioralformb as efb', 'efb.FormBId', '=', 'hrm_pms_formb.FormBId')
                ->where('efb.FormBId', $FormBId)
                ->first();
        } elseif ($FormBsubKraId) {
            // Fetch SubKRA data
            
                $kraData = DB::table('hrm_pms_formb_tgtdefin')
                ->where('FormBSubId', $FormBsubKraId)
                ->where('EmployeeID', $employeeId)
                ->where('YearId', $yearId)
                ->orderBy('NtgtN')
                ->get();
                $pmsData = DB::table('hrm_employee_pms')
                ->where('AssessmentYear', $yearId)
                ->where('CompanyId',$CompanyId)
                ->where('EmployeeID',$employeeId)
                ->first();
            
                $subKraData = DB::table('hrm_employee_pms_behavioralformb_sub as efbs')
                                ->join('hrm_pms_formbsub as fbs', 'efbs.FormBSubId', '=', 'fbs.FormBSubId')
                                ->where('efbs.FormBSubId', $FormBsubKraId)
                                ->select('fbs.Skill', 'fbs.SkillComment','fbs.Period','fbs.Target','fbs.Weightage','fbs.Logic')
                                ->first();
        }

        if ($kraData->isEmpty()) {

            // Fetch company settings
            $setting = DB::table('hrm_pms_setting')
                ->where('CompanyId', $CompanyId)
                ->where('Process', 'KRA')
                ->first();

            if (!$setting) {
                return response()->json(['success' => false, 'message' => 'Company settings not found.']);
            }

            // Fetch employee PMS data
            $employeePms = DB::table('hrm_employee_pms')
                ->where('EmployeeID', $employeeId)
                ->where('AssessmentYear', $setting->CurrY)
                ->first();

            $employeeGeneral = DB::table('hrm_employee_general')
                ->where('EmployeeID', $employeeId)
                ->select('DepartmentId', 'DateJoining')
                ->first();

            if (!$employeeGeneral) {
                return response()->json(['success' => false, 'message' => 'Employee data not found.']);
            }

            $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
            $joiningYear = $dateJoining->year;
            $joiningMonth = $dateJoining->month;

            // Determine Calendar Year or Financial Year
            if ($joiningYear < 2025) {
                // Calendar Year (Jan - Dec)
                $startMonth = 1;
                $yearType = 'CY';
                $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
            } else {
                // Financial Year (Apr - Mar)
                $startMonth = 4;
                $yearType = 'FY';
                if ($joiningMonth >= 4) {
                    $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
                } else {
                    $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
                }
            }

            // Define Quarterly and Half-Yearly periods
            $quarters = [
                'Quarter 1' => [1, 2, 3],
                'Quarter 2' => [4, 5, 6],
                'Quarter 3' => [7, 8, 9],
                'Quarter 4' => [10, 11, 12]
            ];

            $halfYears = [
                'Half Year 1' => [1, 2, 3, 4, 5, 6],
                'Half Year 2' => [7, 8, 9, 10, 11, 12]
            ];

            if ($yearType === 'FY') {
                $quarters = [
                    'Q1' => [4, 5, 6],
                    'Q2' => [7, 8, 9],
                    'Q3' => [10, 11, 12],
                    'Q4' => [1, 2, 3]  // Spans to next year
                ];

                $halfYears = [
                    'H1' => [4, 5, 6, 7, 8, 9],
                    'H2' => [10, 11, 12, 1, 2, 3]
                ];
            }

            $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
                return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
            });

            $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
                return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
            });


            // Find the active quarters and half-years
            $joiningQuarter = '';
            $joiningHalfYear = '';

            foreach ($quarters as $q => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningQuarter = $q;
                    break;
                }
            }

            foreach ($halfYears as $h => $months) {
                if (in_array($joiningMonth, $months)) {
                    $joiningHalfYear = $h;
                    break;
                }
            }


            if ($subKraDatamain) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = $joiningYear; // Normal case
                }

                // MONTHLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }


                // HALF-YEARLY DISTRIBUTION
                if ($subKraDatamain->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraDatamain->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }
                DB::table('hrm_pms_formb_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_formb_tgtdefin')
                                            ->where('FormBId', $FormBId)
                                            ->where('EmployeeID', $employeeId)
                                            ->where('YearId', $yearId)
                                            ->orderBy('NtgtN')
                                            ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }

            if ($subKraData) {
                $periods = [];

                // If the joining year is before 2024, always use Calendar Year and start from January
                if ($joiningYear < 2024) {
                    $yearType = 'CY';
                    $joiningMonth = 1;
                    $effectiveYear = Carbon::now()->year; // Use the current year for due dates
                } else {
                    $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
                    $effectiveYear = $joiningYear; // Normal case
                }

                // MONTHLY DISTRIBUTION
                if ($subKraData->Period == 'Monthly') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $countRow = 12;
                    $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
                    $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
                    $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

                    for ($i = 0; $i < $countRow; $i++) {
                        if ($yearType === 'CY') {
                            $month = $i + 1;
                        } else {
                            $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
                        }

                        // Always active for pre-2024 employees
                        $isActive = ($joiningYear < 2024) ||
                            ($yearType === 'CY' && $month >= $joiningMonth) ||
                            ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

                        $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? $weightagePerPeriod : 0,
                            'Tgt' => $isActive ? $targetPerPeriod : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraData->Period == 'Quarter') {
                    $serialNumber = 1; // Start serial number for active months
 
                    $isCalendarYear = ($joiningYear <= 2024);
                    $quarters = $isCalendarYear
                        ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
                        : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

                    $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningQuarter) {
                        foreach ($quarters as $q => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningQuarter = $q;
                                break;
                            }
                        }
                    }

                    // Ensure quarters are in proper order (1 → 2 → 3 → 4)
                    foreach ([1, 2, 3, 4] as $q) {
                        $months = $quarters[$q];
                        $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Quarter " . $q,
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months

                    }
                }

                // HALF-YEARLY DISTRIBUTION
                if ($subKraData->Period == '1/2 Annual') {
                    $serialNumber = 1; // Start serial number for active months
                    $isCalendarYear = ($joiningYear <= 2024);

                    // Always ensure Half-Year 1 appears before Half-Year 2
                    if ($isCalendarYear) {
                        $halfYears = [
                            1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
                            2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
                        ];
                    } else {
                        $halfYears = [
                            1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
                            2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
                        ];
                    }

                    $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

                    if (!$joiningHalfYear) {
                        foreach ($halfYears as $h => $months) {
                            if (in_array($joiningMonth, $months)) {
                                $joiningHalfYear = $h;
                                break;
                            }
                        }
                    }

                    // Ensure correct order: Always process Half-Year 1 before Half-Year 2
                    foreach ([1, 2] as $h) {
                        $months = $halfYears[$h];
                        $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
                        $lastMonth = max($months);
                        $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

                        $periods[] = [
                            'FormBId' => $FormBId ?? 0,
                            'FormBSubId' => $FormBsubKraId ?? 0,
                            'EmployeeID' => $employeeId,
                            'YearId'=>$yearId,
                            'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
                            'Ldate' => $dueDate,
                            'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
                            'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
                            'NtgtN' => $serialNumber, // Assign incremental S.No.
                            'Ach' => 0,
                            'Remark' => $subKraData->KRA ?? '',
                            'Cmnt' => '',
                            'LogScr' => 0,
                            'Scor' => 0,
                            'lockk' => 0,
                            'AppLogScr' => 0,
                            'AppScor' => 0,
                            'AppAch' => 0,
                            'AppCmnt' => '',
                            'RevCmnt' => '',
                        ];
                        $serialNumber++; // Increment S.No. only for active months
                    }
                }
                DB::table('hrm_pms_formb_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
          
                $kraData = DB::table('hrm_pms_formb_tgtdefin')->where('EmployeeID', $employeeId)
                        ->where('YearId', $yearId)
                        ->orderBy('NtgtN')
                        ->get();
                return response()->json([
                    'success' => true,
                    'kraData' => $kraData,
                    'subKraData' => $subKraData,
                    'subKraDatamain' => $subKraDatamain,
                ]);
            }
        }     
    
        return response()->json([
            'success' => true,  // Add success flag
            'kraData' => $kraData,
            'subKraData' => $subKraData,
            'pmsData' => $pmsData,
            'subKraDatamain' => $subKraDatamain,
        ], 200);
    }

    // public function getDetails(Request $request)
    // {
    //     $kraId = $request->get('kraId');
    //     $subKraId = $request->get('subKraId');
    //     $CompanyId = Auth::user()->CompanyId;
    //     $employeeId = Auth::user()->EmployeeID;
    //     $yearId = $request->get('year_id'); // Pass the year_id to determine period type
    //     $kraData = null;
    //     $subKraData = null;
    //     $subKraDatamain = null;

    //     if ($kraId) {
    //         // Fetch KRA data
    //         $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //             ->where('KRAId', $kraId)
    //             ->orderBy('Ldate')
    //             ->get();

    //         $subKraDatamain = DB::table('hrm_pms_kra')
    //             ->where('KRAId', $kraId)
    //             ->select('Logic', 'KRA', 'KRA_Description', 'Weightage', 'Period', 'Target')
    //             ->first();
    //     } elseif ($subKraId) {
    //         // Fetch SubKRA data
    //         $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //             ->where('KRASubId', $subKraId)
    //             ->orderBy('Ldate')
    //             ->get();

    //         $subKraData = DB::table('hrm_pms_krasub')
    //             ->where('KRASubId', $subKraId)
    //             ->select('Logic', 'KRA', 'KRA_Description', 'Weightage', 'Period', 'Target')
    //             ->first();
    //     }


    //     if ($kraData->isEmpty()) {

    //         // Fetch company settings
    //         $setting = DB::table('hrm_pms_setting')
    //             ->where('CompanyId', $CompanyId)
    //             ->where('Process', 'KRA')
    //             ->first();

    //         if (!$setting) {
    //             return response()->json(['success' => false, 'message' => 'Company settings not found.']);
    //         }

    //         // Fetch employee PMS data
    //         $employeePms = DB::table('hrm_employee_pms')
    //             ->where('EmployeeID', $employeeId)
    //             ->where('AssessmentYear', $setting->CurrY)
    //             ->first();

    //         $employeeGeneral = DB::table('hrm_employee_general')
    //             ->where('EmployeeID', $employeeId)
    //             ->select('DepartmentId', 'DateJoining')
    //             ->first();

    //         if (!$employeeGeneral) {
    //             return response()->json(['success' => false, 'message' => 'Employee data not found.']);
    //         }

    //         $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
    //         $joiningYear = $dateJoining->year;
    //         $joiningMonth = $dateJoining->month;

    //         // Determine Calendar Year or Financial Year
    //         if ($joiningYear < 2025) {
    //             // Calendar Year (Jan - Dec)
    //             $startMonth = 1;
    //             $yearType = 'CY';
    //             $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
    //         } else {
    //             // Financial Year (Apr - Mar)
    //             $startMonth = 4;
    //             $yearType = 'FY';
    //             if ($joiningMonth >= 4) {
    //                 $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
    //             } else {
    //                 $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
    //             }
    //         }

    //         // Define Quarterly and Half-Yearly periods
    //         $quarters = [
    //             'Quarter 1' => [1, 2, 3],
    //             'Quarter 2' => [4, 5, 6],
    //             'Quarter 3' => [7, 8, 9],
    //             'Quarter 4' => [10, 11, 12]
    //         ];

    //         $halfYears = [
    //             'Half Year 1' => [1, 2, 3, 4, 5, 6],
    //             'Half Year 2' => [7, 8, 9, 10, 11, 12]
    //         ];

    //         if ($yearType === 'FY') {
    //             $quarters = [
    //                 'Q1' => [4, 5, 6],
    //                 'Q2' => [7, 8, 9],
    //                 'Q3' => [10, 11, 12],
    //                 'Q4' => [1, 2, 3]  // Spans to next year
    //             ];

    //             $halfYears = [
    //                 'H1' => [4, 5, 6, 7, 8, 9],
    //                 'H2' => [10, 11, 12, 1, 2, 3]
    //             ];
    //         }

    //         $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
    //             return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
    //         });

    //         $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
    //             return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
    //         });


    //         // Find the active quarters and half-years
    //         $joiningQuarter = '';
    //         $joiningHalfYear = '';

    //         foreach ($quarters as $q => $months) {
    //             if (in_array($joiningMonth, $months)) {
    //                 $joiningQuarter = $q;
    //                 break;
    //             }
    //         }

    //         foreach ($halfYears as $h => $months) {
    //             if (in_array($joiningMonth, $months)) {
    //                 $joiningHalfYear = $h;
    //                 break;
    //             }
    //         }


    //         if ($subKraDatamain) {
    //             $periods = [];

    //             // If the joining year is before 2024, always use Calendar Year and start from January
    //             if ($joiningYear < 2024) {
    //                 $yearType = 'CY';
    //                 $joiningMonth = 1;
    //                 $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //             } else {
    //                 $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                 $effectiveYear = $joiningYear; // Normal case
    //             }

    //             // MONTHLY DISTRIBUTION
    //             if ($subKraDatamain->Period == 'Monthly') {
    //                 $countRow = 12;
    //                 $serialNumber = 1;
    //                 $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                 $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
    //                 $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);

    //                 for ($i = 0; $i < $countRow; $i++) {
    //                     if ($yearType === 'CY') {
    //                         $month = $i + 1;
    //                     } else {
    //                         $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                     }

    //                     // Always active for pre-2024 employees
    //                     $isActive = ($joiningYear < 2024) ||
    //                         ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                         ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

    //                     $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                         'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                         'NtgtN' => $serialNumber,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraDatamain->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                     $serialNumber++; // Increment S.No. only for active months

    //                 }
    //             }

    //             // QUARTERLY DISTRIBUTION
    //             if ($subKraDatamain->Period == 'Quarter') {
    //                 $isCalendarYear = ($joiningYear <= 2024);
    //                 $quarters = $isCalendarYear
    //                     ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                     : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

    //                 $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

    //                 if (!$joiningQuarter) {
    //                     foreach ($quarters as $q => $months) {
    //                         if (in_array($joiningMonth, $months)) {
    //                             $joiningQuarter = $q;
    //                             break;
    //                         }
    //                     }
    //                 }

    //                 // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                 foreach ([1, 2, 3, 4] as $q) {
    //                     $months = $quarters[$q];
    //                     $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                     $lastMonth = max($months);
    //                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => "Quarter " . $q,
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                         'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
    //                         'NtgtN' => 1,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraDatamain->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                 }
    //             }


    //             // HALF-YEARLY DISTRIBUTION
    //             if ($subKraDatamain->Period == '1/2 Annual') {
    //                 $isCalendarYear = ($joiningYear <= 2024);

    //                 // Always ensure Half-Year 1 appears before Half-Year 2
    //                 if ($isCalendarYear) {
    //                     $halfYears = [
    //                         1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                         2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                     ];
    //                 } else {
    //                     $halfYears = [
    //                         1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                         2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                     ];
    //                 }

    //                 $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

    //                 if (!$joiningHalfYear) {
    //                     foreach ($halfYears as $h => $months) {
    //                         if (in_array($joiningMonth, $months)) {
    //                             $joiningHalfYear = $h;
    //                             break;
    //                         }
    //                     }
    //                 }

    //                 // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                 foreach ([1, 2] as $h) {
    //                     $months = $halfYears[$h];
    //                     $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                     $lastMonth = max($months);
    //                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                         'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
    //                         'NtgtN' => 1,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraDatamain->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                 }
    //             }
    //             DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //             // Fetch the newly inserted data
    //             $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                 ->where('KRAId', $kraId)
    //                 ->orWhere('KRASubId', $subKraId)
    //                 ->orderBy('NtgtN')
    //                 ->get();
    //             return response()->json([
    //                 'success' => true,
    //                 'kraData' => $kraData,
    //                 'subKraData' => $subKraData,
    //                 'subKraDatamain' => $subKraDatamain,
    //             ]);
    //         }

    //         if ($subKraData) {
    //             $periods = [];

    //             // If the joining year is before 2024, always use Calendar Year and start from January
    //             if ($joiningYear < 2024) {
    //                 $yearType = 'CY';
    //                 $joiningMonth = 1;
    //                 $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //             } else {
    //                 $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                 $effectiveYear = $joiningYear; // Normal case
    //             }

    //             // MONTHLY DISTRIBUTION
    //             if ($subKraData->Period == 'Monthly') {
    //                 $countRow = 12;
    //                 $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                 $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
    //                 $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

    //                 for ($i = 0; $i < $countRow; $i++) {
    //                     if ($yearType === 'CY') {
    //                         $month = $i + 1;
    //                     } else {
    //                         $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                     }

    //                     // Always active for pre-2024 employees
    //                     $isActive = ($joiningYear < 2024) ||
    //                         ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                         ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

    //                     $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                         'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                         'NtgtN' => 1,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraData->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                 }
    //             }

    //             // QUARTERLY DISTRIBUTION
    //             if ($subKraData->Period == 'Quarter') {
    //                 $isCalendarYear = ($joiningYear <= 2024);
    //                 $quarters = $isCalendarYear
    //                     ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                     : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

    //                 $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

    //                 if (!$joiningQuarter) {
    //                     foreach ($quarters as $q => $months) {
    //                         if (in_array($joiningMonth, $months)) {
    //                             $joiningQuarter = $q;
    //                             break;
    //                         }
    //                     }
    //                 }

    //                 // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                 foreach ([1, 2, 3, 4] as $q) {
    //                     $months = $quarters[$q];
    //                     $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                     $lastMonth = max($months);
    //                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => "Quarter " . $q,
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                         'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
    //                         'NtgtN' => 1,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraData->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                 }
    //             }


    //             // HALF-YEARLY DISTRIBUTION
    //             if ($subKraData->Period == '1/2 Annual') {
    //                 $isCalendarYear = ($joiningYear <= 2024);

    //                 // Always ensure Half-Year 1 appears before Half-Year 2
    //                 if ($isCalendarYear) {
    //                     $halfYears = [
    //                         1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                         2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                     ];
    //                 } else {
    //                     $halfYears = [
    //                         1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                         2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                     ];
    //                 }

    //                 $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

    //                 if (!$joiningHalfYear) {
    //                     foreach ($halfYears as $h => $months) {
    //                         if (in_array($joiningMonth, $months)) {
    //                             $joiningHalfYear = $h;
    //                             break;
    //                         }
    //                     }
    //                 }

    //                 // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                 foreach ([1, 2] as $h) {
    //                     $months = $halfYears[$h];
    //                     $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                     $lastMonth = max($months);
    //                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                     $periods[] = [
    //                         'KRAId' => $kraId ?? 0,
    //                         'KRASubId' => $subKraId ?? 0,
    //                         'EmployeeID' => $employeeId,
    //                         'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                         'Ldate' => $dueDate,
    //                         'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                         'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
    //                         'NtgtN' => 1,
    //                         'Ach' => 0,
    //                         'Remark' => $subKraData->KRA ?? '',
    //                         'Cmnt' => '',
    //                         'LogScr' => 0,
    //                         'Scor' => 0,
    //                         'lockk' => 0,
    //                         'AppLogScr' => 0,
    //                         'AppScor' => 0,
    //                         'AppAch' => 0,
    //                         'AppCmnt' => '',
    //                         'RevCmnt' => '',
    //                     ];
    //                 }
    //             }
    //             DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //             // Fetch the newly inserted data
    //             $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                 ->where('KRAId', $kraId)
    //                 ->orWhere('KRASubId', $subKraId)
    //                 ->orderBy('Ldate')
    //                 ->get();
    //             return response()->json([
    //                 'success' => true,
    //                 'kraData' => $kraData,
    //                 'subKraData' => $subKraData,
    //                 'subKraDatamain' => $subKraDatamain,
    //             ]);
    //         }
    //     }
    //     else {
    //         // Fetch company settings
    //         $setting = DB::table('hrm_pms_setting')
    //             ->where('CompanyId', $CompanyId)
    //             ->where('Process', 'KRA')
    //             ->first();

    //         if (!$setting) {
    //             return response()->json(['success' => false, 'message' => 'Company settings not found.']);
    //         }

    //         // Fetch employee PMS data
    //         $employeePms = DB::table('hrm_employee_pms')
    //             ->where('EmployeeID', $employeeId)
    //             ->where('AssessmentYear', $setting->CurrY)
    //             ->first();

    //         $employeeGeneral = DB::table('hrm_employee_general')
    //             ->where('EmployeeID', $employeeId)
    //             ->select('DepartmentId', 'DateJoining')
    //             ->first();

    //         if (!$employeeGeneral) {
    //             return response()->json(['success' => false, 'message' => 'Employee data not found.']);
    //         }

    //         $dateJoining = Carbon::parse($employeeGeneral->DateJoining);
    //         $joiningYear = $dateJoining->year;
    //         $joiningMonth = $dateJoining->month;

    //         // Determine Calendar Year or Financial Year
    //         if ($joiningYear < 2025) {
    //             // Calendar Year (Jan - Dec)
    //             $startMonth = 1;
    //             $yearType = 'CY';
    //             $totalMonths = 12 - ($joiningMonth - 1); // Months from joining month onward
    //         } else {
    //             // Financial Year (Apr - Mar)
    //             $startMonth = 4;
    //             $yearType = 'FY';
    //             if ($joiningMonth >= 4) {
    //                 $totalMonths = 12 - ($joiningMonth - 4); // Months from joining month onward
    //             } else {
    //                 $totalMonths = 12 - (12 - ($joiningMonth + 9)); // Adjusted for FY
    //             }
    //         }

    //         // Define Quarterly and Half-Yearly periods
    //         $quarters = [
    //             'Quarter 1' => [1, 2, 3],
    //             'Quarter 2' => [4, 5, 6],
    //             'Quarter 3' => [7, 8, 9],
    //             'Quarter 4' => [10, 11, 12]
    //         ];

    //         $halfYears = [
    //             'Half Year 1' => [1, 2, 3, 4, 5, 6],
    //             'Half Year 2' => [7, 8, 9, 10, 11, 12]
    //         ];

    //         if ($yearType === 'FY') {
    //             $quarters = [
    //                 'Q1' => [4, 5, 6],
    //                 'Q2' => [7, 8, 9],
    //                 'Q3' => [10, 11, 12],
    //                 'Q4' => [1, 2, 3]  // Spans to next year
    //             ];

    //             $halfYears = [
    //                 'H1' => [4, 5, 6, 7, 8, 9],
    //                 'H2' => [10, 11, 12, 1, 2, 3]
    //             ];
    //         }

    //         $activeQuarters = array_filter(array_keys($quarters), function ($q) use ($joiningMonth, $quarters) {
    //             return !empty(array_intersect($quarters[$q], range($joiningMonth, 12))) || ($joiningMonth < 4 && $q === 'Quarter 4');
    //         });

    //         $activeHalfYears = array_filter(array_keys($halfYears), function ($h) use ($joiningMonth, $halfYears) {
    //             return !empty(array_intersect($halfYears[$h], range($joiningMonth, 12))) || ($joiningMonth < 4 && $h === 'Half Year 2');
    //         });


    //         // Find the active quarters and half-years
    //         $joiningQuarter = '';
    //         $joiningHalfYear = '';

    //         foreach ($quarters as $q => $months) {
    //             if (in_array($joiningMonth, $months)) {
    //                 $joiningQuarter = $q;
    //                 break;
    //             }
    //         }

    //         foreach ($halfYears as $h => $months) {
    //             if (in_array($joiningMonth, $months)) {
    //                 $joiningHalfYear = $h;
    //                 break;
    //             }
    //         }
    //         if ($subKraDatamain) {
    //             // Check if period is "1/2 Annual"
    //             if ($subKraDatamain && in_array($subKraDatamain->Period, ['1/2 Annual'])) {
        
    //                 $expectedMonths = [
    //                     'January', 'February', 'March', 'April', 'May', 'June', 
    //                     'July', 'August', 'September', 'October', 'November', 'December'
    //                 ];

    //                 $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];
            
    //                     // Fetch unique quarter names from Tital for the given KRAId
    //                     $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
    //                         ->where('KRAId', $kraId)
    //                         ->pluck('Tital')
    //                         ->unique()
    //                         ->sort()
    //                         ->values();
                
    //                 $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                    
    //                 // Fetch unique month names from Title for the given KRAId
    //                 $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();

    //                 $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();

    //                 if ($hasAllMonths || $hasAllQuarters)  {
    //                         // Delete all records for this KRAId
    //                     $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
    //                             ->where('KRAId', $kraId)
    //                             ->delete();
    //                     if($deletemonthly){
    //                         $periods = [];

    //                         // If the joining year is before 2024, always use Calendar Year and start from January
    //                         if ($joiningYear < 2024) {
    //                             $yearType = 'CY';
    //                             $joiningMonth = 1;
    //                             $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                         } else {
    //                             $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                             $effectiveYear = $joiningYear; // Normal case
    //                         }
            
    //                         // MONTHLY DISTRIBUTION
    //                         if ($subKraDatamain->Period == 'Monthly') {
    //                             $countRow = 12;
    //                             $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                             $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
    //                             $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);
            
    //                             for ($i = 0; $i < $countRow; $i++) {
    //                                 if ($yearType === 'CY') {
    //                                     $month = $i + 1;
    //                                 } else {
    //                                     $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                                 }
            
    //                                 // Always active for pre-2024 employees
    //                                 $isActive = ($joiningYear < 2024) ||
    //                                     ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                                     ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));
            
    //                                 $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();
            
    //                                 $periods[] = [
    //                                     'KRAId' => $kraId ?? 0,
    //                                     'KRASubId' => $subKraId ?? 0,
    //                                     'EmployeeID' => $employeeId,
    //                                     'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                                     'Ldate' => $dueDate,
    //                                     'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                                     'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                                     'NtgtN' => 1,
    //                                     'Ach' => 0,
    //                                     'Remark' => $subKraDatamain->KRA ?? '',
    //                                     'Cmnt' => '',
    //                                     'LogScr' => 0,
    //                                     'Scor' => 0,
    //                                     'lockk' => 0,
    //                                     'AppLogScr' => 0,
    //                                     'AppScor' => 0,
    //                                     'AppAch' => 0,
    //                                     'AppCmnt' => '',
    //                                     'RevCmnt' => '',
    //                                 ];
    //                             }
    //                         }
            
    //                         // QUARTERLY DISTRIBUTION
    //                         if ($subKraDatamain->Period == 'Quarter') {
    //                             $isCalendarYear = ($joiningYear <= 2024);
    //                             $quarters = $isCalendarYear
    //                                 ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                                 : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];
            
    //                             $joiningQuarter = ($joiningYear < 2024) ? 1 : null;
            
    //                             if (!$joiningQuarter) {
    //                                 foreach ($quarters as $q => $months) {
    //                                     if (in_array($joiningMonth, $months)) {
    //                                         $joiningQuarter = $q;
    //                                         break;
    //                                     }
    //                                 }
    //                             }
            
    //                             // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                             foreach ([1, 2, 3, 4] as $q) {
    //                                 $months = $quarters[$q];
    //                                 $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                                 $lastMonth = max($months);
    //                                 $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
            
    //                                 $periods[] = [
    //                                     'KRAId' => $kraId ?? 0,
    //                                     'KRASubId' => $subKraId ?? 0,
    //                                     'EmployeeID' => $employeeId,
    //                                     'Tital' => "Quarter " . $q,
    //                                     'Ldate' => $dueDate,
    //                                     'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                                     'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
    //                                     'NtgtN' => 1,
    //                                     'Ach' => 0,
    //                                     'Remark' => $subKraDatamain->KRA ?? '',
    //                                     'Cmnt' => '',
    //                                     'LogScr' => 0,
    //                                     'Scor' => 0,
    //                                     'lockk' => 0,
    //                                     'AppLogScr' => 0,
    //                                     'AppScor' => 0,
    //                                     'AppAch' => 0,
    //                                     'AppCmnt' => '',
    //                                     'RevCmnt' => '',
    //                                 ];
    //                             }
    //                         }
            
    //                         DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                         // Fetch the newly inserted data
    //                         $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                             ->where('KRAId', $kraId)
    //                             ->orWhere('KRASubId', $subKraId)
    //                             ->orderBy('Ldate')
    //                             ->get();
    //                         return response()->json([
    //                             'success' => true,
    //                             'kraData' => $kraData,
    //                             'subKraData' => $subKraData,
    //                             'subKraDatamain' => $subKraDatamain,
    //                         ]);
    //                     }
    //                 }
    //             }
    //             if ($subKraDatamain && in_array($subKraDatamain->Period, ['Quarter'])) {        
        
    //                     $expectedHalf = ['Half-Year 2','Half-Year 1'];
    //                     $expectedMonths = [
    //                                 'January', 'February', 'March', 'April', 'May', 'June', 
    //                                 'July', 'August', 'September', 'October', 'November', 'December'
    //                             ];
    //                     // Fetch unique quarter names from Tital for the given KRAId
    //                     $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
    //                         ->where('KRAId', $kraId)
    //                         ->pluck('Tital')
    //                         ->unique()
    //                         ->sort()
    //                         ->values();
                
    //                     $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
    //                 // Fetch unique month names from Title for the given KRAId
    //                         $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
    //                             ->where('KRAId', $kraId)
    //                             ->pluck('Tital')
    //                             ->unique()
    //                             ->sort()
    //                             ->values();

    //                     $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();
    //                     if ($hasAllHalf || $hasAllMonths) {
    //                             // Delete all records for this KRAId
    //                         $deleteHalf = DB::table('hrm_pms_kra_tgtdefin')
    //                                 ->where('KRAId', $kraId)
    //                                 ->delete();
    //                         if($deleteHalf){
    //                             $periods = [];
                    
    //                             // If the joining year is before 2024, always use Calendar Year and start from January
    //                             if ($joiningYear < 2024) {
    //                                 $yearType = 'CY';
    //                                 $joiningMonth = 1;
    //                                 $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                             } else {
    //                                 $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                                 $effectiveYear = $joiningYear; // Normal case
    //                             }
                    
    //                             // MONTHLY DISTRIBUTION
    //                             if ($subKraDatamain->Period == 'Monthly') {
    //                                 $countRow = 12;
    //                                 $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                                 $targetPerPeriod = round($subKraDatamain->Target / $actualMonths, 2);
    //                                 $weightagePerPeriod = round($subKraDatamain->Weightage / $actualMonths, 2);
                    
    //                                 for ($i = 0; $i < $countRow; $i++) {
    //                                     if ($yearType === 'CY') {
    //                                         $month = $i + 1;
    //                                     } else {
    //                                         $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                                     }
                    
    //                                     // Always active for pre-2024 employees
    //                                     $isActive = ($joiningYear < 2024) ||
    //                                         ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                                         ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));
                    
    //                                     $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();
                    
    //                                     $periods[] = [
    //                                         'KRAId' => $kraId ?? 0,
    //                                         'KRASubId' => $subKraId ?? 0,
    //                                         'EmployeeID' => $employeeId,
    //                                         'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                                         'Ldate' => $dueDate,
    //                                         'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                                         'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                                         'NtgtN' => 1,
    //                                         'Ach' => 0,
    //                                         'Remark' => $subKraDatamain->KRA ?? '',
    //                                         'Cmnt' => '',
    //                                         'LogScr' => 0,
    //                                         'Scor' => 0,
    //                                         'lockk' => 0,
    //                                         'AppLogScr' => 0,
    //                                         'AppScor' => 0,
    //                                         'AppAch' => 0,
    //                                         'AppCmnt' => '',
    //                                         'RevCmnt' => '',
    //                                     ];
    //                                 }
    //                             }
                    
    //                             // HALF-YEARLY DISTRIBUTION
    //                             if ($subKraDatamain->Period == '1/2 Annual') {
    //                                 $isCalendarYear = ($joiningYear <= 2024);
                    
    //                                 // Always ensure Half-Year 1 appears before Half-Year 2
    //                                 if ($isCalendarYear) {
    //                                     $halfYears = [
    //                                         1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                                         2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                                     ];
    //                                 } else {
    //                                     $halfYears = [
    //                                         1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                                         2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                                     ];
    //                                 }
                    
    //                                 $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;
                    
    //                                 if (!$joiningHalfYear) {
    //                                     foreach ($halfYears as $h => $months) {
    //                                         if (in_array($joiningMonth, $months)) {
    //                                             $joiningHalfYear = $h;
    //                                             break;
    //                                         }
    //                                     }
    //                                 }
                    
    //                                 // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                                 foreach ([1, 2] as $h) {
    //                                     $months = $halfYears[$h];
    //                                     $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                                     $lastMonth = max($months);
    //                                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                    
    //                                     $periods[] = [
    //                                         'KRAId' => $kraId ?? 0,
    //                                         'KRASubId' => $subKraId ?? 0,
    //                                         'EmployeeID' => $employeeId,
    //                                         'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                                         'Ldate' => $dueDate,
    //                                         'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                                         'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
    //                                         'NtgtN' => 1,
    //                                         'Ach' => 0,
    //                                         'Remark' => $subKraDatamain->KRA ?? '',
    //                                         'Cmnt' => '',
    //                                         'LogScr' => 0,
    //                                         'Scor' => 0,
    //                                         'lockk' => 0,
    //                                         'AppLogScr' => 0,
    //                                         'AppScor' => 0,
    //                                         'AppAch' => 0,
    //                                         'AppCmnt' => '',
    //                                         'RevCmnt' => '',
    //                                     ];
    //                                 }
    //                             }
    //                             DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                             // Fetch the newly inserted data
    //                             $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                                 ->where('KRAId', $kraId)
    //                                 ->orWhere('KRASubId', $subKraId)
    //                                 ->orderBy('Ldate')
    //                                 ->get();
    //                             return response()->json([
    //                                 'success' => true,
    //                                 'kraData' => $kraData,
    //                                 'subKraData' => $subKraData,
    //                                 'subKraDatamain' => $subKraDatamain,
    //                             ]);
    //                         }
    //                     }
    //             }
    //             if ($subKraDatamain && in_array($subKraDatamain->Period, ['Monthly'])) {        
        
    //                 $expectedHalf = ['Half-Year 2','Half-Year 1'];
    //                 $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];

    //                 // Fetch unique quarter names from Tital for the given KRAId
    //                 $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();

    //                 // Fetch unique quarter names from Tital for the given KRAId
    //                 $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();
            
    //                 $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
    //                 $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                

    //                 if ($hasAllHalf || $hasAllQuarters) {
    //                         // Delete all records for this KRAId
    //                     $deleteHalf = DB::table('hrm_pms_kra_tgtdefin')
    //                             ->where('KRAId', $kraId)
    //                             ->delete();
    //                     if($deleteHalf){
    //                         $periods = [];
                
    //                         // If the joining year is before 2024, always use Calendar Year and start from January
    //                         if ($joiningYear < 2024) {
    //                             $yearType = 'CY';
    //                             $joiningMonth = 1;
    //                             $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                         } else {
    //                             $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                             $effectiveYear = $joiningYear; // Normal case
    //                         }
                
                        
    //                         // QUARTERLY DISTRIBUTION
    //                         if ($subKraDatamain->Period == 'Quarter') {
    //                             $isCalendarYear = ($joiningYear <= 2024);
    //                             $quarters = $isCalendarYear
    //                                 ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                                 : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];
                
    //                             $joiningQuarter = ($joiningYear < 2024) ? 1 : null;
                
    //                             if (!$joiningQuarter) {
    //                                 foreach ($quarters as $q => $months) {
    //                                     if (in_array($joiningMonth, $months)) {
    //                                         $joiningQuarter = $q;
    //                                         break;
    //                                     }
    //                                 }
    //                             }
                
    //                             // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                             foreach ([1, 2, 3, 4] as $q) {
    //                                 $months = $quarters[$q];
    //                                 $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                                 $lastMonth = max($months);
    //                                 $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                
    //                                 $periods[] = [
    //                                     'KRAId' => $kraId ?? 0,
    //                                     'KRASubId' => $subKraId ?? 0,
    //                                     'EmployeeID' => $employeeId,
    //                                     'Tital' => "Quarter " . $q,
    //                                     'Ldate' => $dueDate,
    //                                     'Wgt' => $isActive ? round($subKraDatamain->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                                     'Tgt' => $isActive ? round($subKraDatamain->Target / (5 - $joiningQuarter), 2) : 0,
    //                                     'NtgtN' => 1,
    //                                     'Ach' => 0,
    //                                     'Remark' => $subKraDatamain->KRA ?? '',
    //                                     'Cmnt' => '',
    //                                     'LogScr' => 0,
    //                                     'Scor' => 0,
    //                                     'lockk' => 0,
    //                                     'AppLogScr' => 0,
    //                                     'AppScor' => 0,
    //                                     'AppAch' => 0,
    //                                     'AppCmnt' => '',
    //                                     'RevCmnt' => '',
    //                                 ];
    //                             }
    //                         }
                
                
    //                         // HALF-YEARLY DISTRIBUTION
    //                         if ($subKraDatamain->Period == '1/2 Annual') {
    //                             $isCalendarYear = ($joiningYear <= 2024);
                
    //                             // Always ensure Half-Year 1 appears before Half-Year 2
    //                             if ($isCalendarYear) {
    //                                 $halfYears = [
    //                                     1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                                     2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                                 ];
    //                             } else {
    //                                 $halfYears = [
    //                                     1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                                     2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                                 ];
    //                             }
                
    //                             $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;
                
    //                             if (!$joiningHalfYear) {
    //                                 foreach ($halfYears as $h => $months) {
    //                                     if (in_array($joiningMonth, $months)) {
    //                                         $joiningHalfYear = $h;
    //                                         break;
    //                                     }
    //                                 }
    //                             }
                
    //                             // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                             foreach ([1, 2] as $h) {
    //                                 $months = $halfYears[$h];
    //                                 $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                                 $lastMonth = max($months);
    //                                 $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();
                
    //                                 $periods[] = [
    //                                     'KRAId' => $kraId ?? 0,
    //                                     'KRASubId' => $subKraId ?? 0,
    //                                     'EmployeeID' => $employeeId,
    //                                     'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                                     'Ldate' => $dueDate,
    //                                     'Wgt' => $isActive ? round($subKraDatamain->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                                     'Tgt' => $isActive ? round($subKraDatamain->Target / (3 - $joiningHalfYear), 2) : 0,
    //                                     'NtgtN' => 1,
    //                                     'Ach' => 0,
    //                                     'Remark' => $subKraDatamain->KRA ?? '',
    //                                     'Cmnt' => '',
    //                                     'LogScr' => 0,
    //                                     'Scor' => 0,
    //                                     'lockk' => 0,
    //                                     'AppLogScr' => 0,
    //                                     'AppScor' => 0,
    //                                     'AppAch' => 0,
    //                                     'AppCmnt' => '',
    //                                     'RevCmnt' => '',
    //                                 ];
    //                             }
    //                         }
    //                         DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                         // Fetch the newly inserted data
    //                         $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                             ->where('KRAId', $kraId)
    //                             ->orWhere('KRASubId', $subKraId)
    //                             ->orderBy('Ldate')
    //                             ->get();
    //                         return response()->json([
    //                             'success' => true,
    //                             'kraData' => $kraData,
    //                             'subKraData' => $subKraData,
    //                             'subKraDatamain' => $subKraDatamain,
    //                         ]);
    //                     }
    //                 }
    //             }
            
    //         }
    //         if ($subKraData) {
    //             // Check if period is "1/2 Annual"
    //             if ($subKraData && in_array($subKraData->Period, ['1/2 Annual'])) {
        
    //                 $expectedMonths = [
    //                     'January', 'February', 'March', 'April', 'May', 'June', 
    //                     'July', 'August', 'September', 'October', 'November', 'December'
    //                 ];

    //                 $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];
            
    //                     // Fetch unique quarter names from Tital for the given KRAId
    //                     $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
    //                         ->where('KRAId', $kraId)
    //                         ->pluck('Tital')
    //                         ->unique()
    //                         ->sort()
    //                         ->values();
                
    //                 $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                    
    //                 // Fetch unique month names from Title for the given KRAId
    //                 $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();

    //                 $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();

    //                 if ($hasAllMonths || $hasAllQuarters)  {
    //                         // Delete all records for this KRAId
    //                             $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
    //                                     ->where('KRAId', $kraId)
    //                                     ->delete();
    //                             if($deletemonthly){
    //                                 $periods = [];

    //                             // If the joining year is before 2024, always use Calendar Year and start from January
    //                             if ($joiningYear < 2024) {
    //                                 $yearType = 'CY';
    //                                 $joiningMonth = 1;
    //                                 $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                             } else {
    //                                 $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                                 $effectiveYear = $joiningYear; // Normal case
    //                             }

    //                             // MONTHLY DISTRIBUTION
    //                             if ($subKraData->Period == 'Monthly') {
    //                                 $countRow = 12;
    //                                 $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                                 $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
    //                                 $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

    //                                 for ($i = 0; $i < $countRow; $i++) {
    //                                     if ($yearType === 'CY') {
    //                                         $month = $i + 1;
    //                                     } else {
    //                                         $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                                     }

    //                                     // Always active for pre-2024 employees
    //                                     $isActive = ($joiningYear < 2024) ||
    //                                         ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                                         ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

    //                                     $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                     $periods[] = [
    //                                         'KRAId' => $kraId ?? 0,
    //                                         'KRASubId' => $subKraId ?? 0,
    //                                         'EmployeeID' => $employeeId,
    //                                         'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                                         'Ldate' => $dueDate,
    //                                         'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                                         'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                                         'NtgtN' => 1,
    //                                         'Ach' => 0,
    //                                         'Remark' => $subKraData->KRA ?? '',
    //                                         'Cmnt' => '',
    //                                         'LogScr' => 0,
    //                                         'Scor' => 0,
    //                                         'lockk' => 0,
    //                                         'AppLogScr' => 0,
    //                                         'AppScor' => 0,
    //                                         'AppAch' => 0,
    //                                         'AppCmnt' => '',
    //                                         'RevCmnt' => '',
    //                                     ];
    //                                 }
    //                             }

    //                             // QUARTERLY DISTRIBUTION
    //                             if ($subKraData->Period == 'Quarter') {
    //                                 $isCalendarYear = ($joiningYear <= 2024);
    //                                 $quarters = $isCalendarYear
    //                                     ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                                     : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

    //                                 $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

    //                                 if (!$joiningQuarter) {
    //                                     foreach ($quarters as $q => $months) {
    //                                         if (in_array($joiningMonth, $months)) {
    //                                             $joiningQuarter = $q;
    //                                             break;
    //                                         }
    //                                     }
    //                                 }

    //                                 // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                                 foreach ([1, 2, 3, 4] as $q) {
    //                                     $months = $quarters[$q];
    //                                     $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                                     $lastMonth = max($months);
    //                                     $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                     $periods[] = [
    //                                         'KRAId' => $kraId ?? 0,
    //                                         'KRASubId' => $subKraId ?? 0,
    //                                         'EmployeeID' => $employeeId,
    //                                         'Tital' => "Quarter " . $q,
    //                                         'Ldate' => $dueDate,
    //                                         'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                                         'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
    //                                         'NtgtN' => 1,
    //                                         'Ach' => 0,
    //                                         'Remark' => $subKraData->KRA ?? '',
    //                                         'Cmnt' => '',
    //                                         'LogScr' => 0,
    //                                         'Scor' => 0,
    //                                         'lockk' => 0,
    //                                         'AppLogScr' => 0,
    //                                         'AppScor' => 0,
    //                                         'AppAch' => 0,
    //                                         'AppCmnt' => '',
    //                                         'RevCmnt' => '',
    //                                     ];
    //                                 }
    //                             }

    //                             DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                             // Fetch the newly inserted data
    //                             $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                                 ->where('KRAId', $kraId)
    //                                 ->orWhere('KRASubId', $subKraId)
    //                                 ->orderBy('Ldate')
    //                                 ->get();
    //                             return response()->json([
    //                                 'success' => true,
    //                                 'kraData' => $kraData,
    //                                 'subKraData' => $subKraData,
    //                                 'subKraDatamain' => $subKraDatamain,
    //                             ]);
    //                             }
    //                 }
    //             }
    //             if ($subKraData && in_array($subKraData->Period, ['Quarter'])) {
        
    //                 $expectedHalf = ['Half-Year 2','Half-Year 1'];
    //                   $expectedMonths = [
    //                               'January', 'February', 'March', 'April', 'May', 'June', 
    //                               'July', 'August', 'September', 'October', 'November', 'December'
    //                           ];
    //                   // Fetch unique quarter names from Tital for the given KRAId
    //                   $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
    //                       ->where('KRAId', $kraId)
    //                       ->pluck('Tital')
    //                       ->unique()
    //                       ->sort()
    //                       ->values();
              
    //                   $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
    //               // Fetch unique month names from Title for the given KRAId
    //                       $monthsInData = DB::table('hrm_pms_kra_tgtdefin')
    //                           ->where('KRAId', $kraId)
    //                           ->pluck('Tital')
    //                           ->unique()
    //                           ->sort()
    //                           ->values();

    //                   $hasAllMonths = collect($expectedMonths)->diff($monthsInData)->isEmpty();
    //                   if ($hasAllHalf || $hasAllMonths) {
    //                       // Delete all records for this KRAId
    //                           $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
    //                                   ->where('KRAId', $kraId)
    //                                   ->delete();
    //                           if($deletemonthly){
    //                               $periods = [];

    //                           // If the joining year is before 2024, always use Calendar Year and start from January
    //                           if ($joiningYear < 2024) {
    //                               $yearType = 'CY';
    //                               $joiningMonth = 1;
    //                               $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                           } else {
    //                               $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                               $effectiveYear = $joiningYear; // Normal case
    //                           }

    //                           // MONTHLY DISTRIBUTION
    //                           if ($subKraData->Period == 'Monthly') {
    //                               $countRow = 12;
    //                               $actualMonths = 12 - max(0, $joiningMonth - ($yearType === 'FY' ? 4 : 1));
    //                               $targetPerPeriod = round($subKraData->Target / $actualMonths, 2);
    //                               $weightagePerPeriod = round($subKraData->Weightage / $actualMonths, 2);

    //                               for ($i = 0; $i < $countRow; $i++) {
    //                                   if ($yearType === 'CY') {
    //                                       $month = $i + 1;
    //                                   } else {
    //                                       $month = ($i + 4) > 12 ? ($i - 8) : ($i + 4);
    //                                   }

    //                                   // Always active for pre-2024 employees
    //                                   $isActive = ($joiningYear < 2024) ||
    //                                       ($yearType === 'CY' && $month >= $joiningMonth) ||
    //                                       ($yearType === 'FY' && ($month >= $joiningMonth || ($joiningMonth >= 4 && $month < 4)));

    //                                   $dueDate = Carbon::createFromDate($effectiveYear, $month, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                   $periods[] = [
    //                                       'KRAId' => $kraId ?? 0,
    //                                       'KRASubId' => $subKraId ?? 0,
    //                                       'EmployeeID' => $employeeId,
    //                                       'Tital' => Carbon::createFromDate($effectiveYear, $month, 1)->format('F'),
    //                                       'Ldate' => $dueDate,
    //                                       'Wgt' => $isActive ? $weightagePerPeriod : 0,
    //                                       'Tgt' => $isActive ? $targetPerPeriod : 0,
    //                                       'NtgtN' => 1,
    //                                       'Ach' => 0,
    //                                       'Remark' => $subKraData->KRA ?? '',
    //                                       'Cmnt' => '',
    //                                       'LogScr' => 0,
    //                                       'Scor' => 0,
    //                                       'lockk' => 0,
    //                                       'AppLogScr' => 0,
    //                                       'AppScor' => 0,
    //                                       'AppAch' => 0,
    //                                       'AppCmnt' => '',
    //                                       'RevCmnt' => '',
    //                                   ];
    //                               }
    //                           }

    //                           // HALF-YEARLY DISTRIBUTION
    //                           if ($subKraData->Period == '1/2 Annual') {
    //                               $isCalendarYear = ($joiningYear <= 2024);

    //                               // Always ensure Half-Year 1 appears before Half-Year 2
    //                               if ($isCalendarYear) {
    //                                   $halfYears = [
    //                                       1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                                       2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                                   ];
    //                               } else {
    //                                   $halfYears = [
    //                                       1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                                       2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                                   ];
    //                               }

    //                               $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

    //                               if (!$joiningHalfYear) {
    //                                   foreach ($halfYears as $h => $months) {
    //                                       if (in_array($joiningMonth, $months)) {
    //                                           $joiningHalfYear = $h;
    //                                           break;
    //                                       }
    //                                   }
    //                               }

    //                               // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                               foreach ([1, 2] as $h) {
    //                                   $months = $halfYears[$h];
    //                                   $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                                   $lastMonth = max($months);
    //                                   $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                   $periods[] = [
    //                                       'KRAId' => $kraId ?? 0,
    //                                       'KRASubId' => $subKraId ?? 0,
    //                                       'EmployeeID' => $employeeId,
    //                                       'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                                       'Ldate' => $dueDate,
    //                                       'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                                       'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
    //                                       'NtgtN' => 1,
    //                                       'Ach' => 0,
    //                                       'Remark' => $subKraData->KRA ?? '',
    //                                       'Cmnt' => '',
    //                                       'LogScr' => 0,
    //                                       'Scor' => 0,
    //                                       'lockk' => 0,
    //                                       'AppLogScr' => 0,
    //                                       'AppScor' => 0,
    //                                       'AppAch' => 0,
    //                                       'AppCmnt' => '',
    //                                       'RevCmnt' => '',
    //                                   ];
    //                               }
    //                           }
    //                           DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                           // Fetch the newly inserted data
    //                           $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                               ->where('KRAId', $kraId)
    //                               ->orWhere('KRASubId', $subKraId)
    //                               ->orderBy('Ldate')
    //                               ->get();
    //                           return response()->json([
    //                               'success' => true,
    //                               'kraData' => $kraData,
    //                               'subKraData' => $subKraData,
    //                               'subKraDatamain' => $subKraDatamain,
    //                           ]);
    //                           }
    //               }
    //             }
    //             if ($subKraData && in_array($subKraData->Period, ['Monthly'])) {
        
                   
    //                 $expectedHalf = ['Half-Year 2','Half-Year 1'];
    //                 $expectedQuarters = ['Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4'];

    //                 // Fetch unique quarter names from Tital for the given KRAId
    //                 $HalfInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();

    //                 // Fetch unique quarter names from Tital for the given KRAId
    //                 $quartersInData = DB::table('hrm_pms_kra_tgtdefin')
    //                     ->where('KRAId', $kraId)
    //                     ->pluck('Tital')
    //                     ->unique()
    //                     ->sort()
    //                     ->values();
            
    //                 $hasAllHalf = collect($expectedHalf)->diff($HalfInData)->isEmpty();
    //                 $hasAllQuarters = collect($expectedQuarters)->diff($quartersInData)->isEmpty();
                

    //                 if ($hasAllHalf || $hasAllQuarters) {
    //                       // Delete all records for this KRAId
    //                           $deletemonthly = DB::table('hrm_pms_kra_tgtdefin')
    //                                   ->where('KRAId', $kraId)
    //                                   ->delete();
    //                           if($deletemonthly){
    //                               $periods = [];

    //                           // If the joining year is before 2024, always use Calendar Year and start from January
    //                           if ($joiningYear < 2024) {
    //                               $yearType = 'CY';
    //                               $joiningMonth = 1;
    //                               $effectiveYear = Carbon::now()->year; // Use the current year for due dates
    //                           } else {
    //                               $yearType = ($joiningYear == 2024) ? 'CY' : 'FY'; // 2024 is CY, 2025+ is FY
    //                               $effectiveYear = $joiningYear; // Normal case
    //                           }

    //                           // QUARTERLY DISTRIBUTION
    //                           if ($subKraData->Period == 'Quarter') {
    //                               $isCalendarYear = ($joiningYear <= 2024);
    //                               $quarters = $isCalendarYear
    //                                   ? [1 => [1, 2, 3], 2 => [4, 5, 6], 3 => [7, 8, 9], 4 => [10, 11, 12]]
    //                                   : [1 => [4, 5, 6], 2 => [7, 8, 9], 3 => [10, 11, 12], 4 => [1, 2, 3]];

    //                               $joiningQuarter = ($joiningYear < 2024) ? 1 : null;

    //                               if (!$joiningQuarter) {
    //                                   foreach ($quarters as $q => $months) {
    //                                       if (in_array($joiningMonth, $months)) {
    //                                           $joiningQuarter = $q;
    //                                           break;
    //                                       }
    //                                   }
    //                               }

    //                               // Ensure quarters are in proper order (1 → 2 → 3 → 4)
    //                               foreach ([1, 2, 3, 4] as $q) {
    //                                   $months = $quarters[$q];
    //                                   $isActive = ($joiningYear < 2024) || $q >= $joiningQuarter;
    //                                   $lastMonth = max($months);
    //                                   $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                   $periods[] = [
    //                                       'KRAId' => $kraId ?? 0,
    //                                       'KRASubId' => $subKraId ?? 0,
    //                                       'EmployeeID' => $employeeId,
    //                                       'Tital' => "Quarter " . $q,
    //                                       'Ldate' => $dueDate,
    //                                       'Wgt' => $isActive ? round($subKraData->Weightage / (5 - $joiningQuarter), 2) : 0,
    //                                       'Tgt' => $isActive ? round($subKraData->Target / (5 - $joiningQuarter), 2) : 0,
    //                                       'NtgtN' => 1,
    //                                       'Ach' => 0,
    //                                       'Remark' => $subKraData->KRA ?? '',
    //                                       'Cmnt' => '',
    //                                       'LogScr' => 0,
    //                                       'Scor' => 0,
    //                                       'lockk' => 0,
    //                                       'AppLogScr' => 0,
    //                                       'AppScor' => 0,
    //                                       'AppAch' => 0,
    //                                       'AppCmnt' => '',
    //                                       'RevCmnt' => '',
    //                                   ];
    //                               }
    //                           }


    //                           // HALF-YEARLY DISTRIBUTION
    //                           if ($subKraData->Period == '1/2 Annual') {
    //                               $isCalendarYear = ($joiningYear <= 2024);

    //                               // Always ensure Half-Year 1 appears before Half-Year 2
    //                               if ($isCalendarYear) {
    //                                   $halfYears = [
    //                                       1 => [1, 2, 3, 4, 5, 6],  // CY: Jan - Jun
    //                                       2 => [7, 8, 9, 10, 11, 12] // CY: Jul - Dec
    //                                   ];
    //                               } else {
    //                                   $halfYears = [
    //                                       1 => [4, 5, 6, 7, 8, 9],   // FY: Apr - Sep
    //                                       2 => [10, 11, 12, 1, 2, 3] // FY: Oct - Mar
    //                                   ];
    //                               }

    //                               $joiningHalfYear = ($joiningYear < 2024) ? 1 : null;

    //                               if (!$joiningHalfYear) {
    //                                   foreach ($halfYears as $h => $months) {
    //                                       if (in_array($joiningMonth, $months)) {
    //                                           $joiningHalfYear = $h;
    //                                           break;
    //                                       }
    //                                   }
    //                               }

    //                               // Ensure correct order: Always process Half-Year 1 before Half-Year 2
    //                               foreach ([1, 2] as $h) {
    //                                   $months = $halfYears[$h];
    //                                   $isActive = ($joiningYear < 2024) || $h >= $joiningHalfYear;
    //                                   $lastMonth = max($months);
    //                                   $dueDate = Carbon::createFromDate($effectiveYear, $lastMonth, 1)->endOfMonth()->addDays(7)->toDateString();

    //                                   $periods[] = [
    //                                       'KRAId' => $kraId ?? 0,
    //                                       'KRASubId' => $subKraId ?? 0,
    //                                       'EmployeeID' => $employeeId,
    //                                       'Tital' => "Half-Year " . $h,  // Ensuring Half-Year 1 comes first
    //                                       'Ldate' => $dueDate,
    //                                       'Wgt' => $isActive ? round($subKraData->Weightage / (3 - $joiningHalfYear), 2) : 0,
    //                                       'Tgt' => $isActive ? round($subKraData->Target / (3 - $joiningHalfYear), 2) : 0,
    //                                       'NtgtN' => 1,
    //                                       'Ach' => 0,
    //                                       'Remark' => $subKraData->KRA ?? '',
    //                                       'Cmnt' => '',
    //                                       'LogScr' => 0,
    //                                       'Scor' => 0,
    //                                       'lockk' => 0,
    //                                       'AppLogScr' => 0,
    //                                       'AppScor' => 0,
    //                                       'AppAch' => 0,
    //                                       'AppCmnt' => '',
    //                                       'RevCmnt' => '',
    //                                   ];
    //                               }
    //                           }
    //                           DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
    //                           // Fetch the newly inserted data
    //                           $kraData = DB::table('hrm_pms_kra_tgtdefin')
    //                               ->where('KRAId', $kraId)
    //                               ->orWhere('KRASubId', $subKraId)
    //                               ->orderBy('Ldate')
    //                               ->get();
    //                           return response()->json([
    //                               'success' => true,
    //                               'kraData' => $kraData,
    //                               'subKraData' => $subKraData,
    //                               'subKraDatamain' => $subKraDatamain,
    //                           ]);
    //                           }
    //               }
    //             }
    //         }
    //     }
        
        

    //     return response()->json([
    //         'success' => true,  // Add success flag
    //         'kraData' => $kraData,
    //         'subKraData' => $subKraData,
    //         'subKraDatamain' => $subKraDatamain,
    //     ], 200);
    // }

    
    public function save(Request $request)
    {
        $CompanyId = Auth::user()->CompanyId;
        $EmployeeId = Auth::user()->EmployeeID;
        $totalWeightage = 0;
        // Get Employee's Department
        $employee = DB::table('hrm_employee_general')
            ->where('EmployeeID', $EmployeeId)
            ->select('DepartmentId')
            ->first();
        $departmentId = $employee->DepartmentId ?? null;

        $KraYId = $request->input('KraYId'); // Get year from request

        if ($request->has('kra') && is_array($request->kra)) {
            // Initialize total weightage
            $totalWeightage = 0;

            // Handle indexed weightage array (kra[] and weightage[] arrays)
            $kraWeightages = $request->has('weightage') ? $request->input('weightage') : [];

            // If weightage is a single value and not an array, convert it into an array for all kra
            if (count($kraWeightages) == 1) {
                $kraWeightages = array_fill(0, count($request->kra), $kraWeightages[0]);  // Fill all kra with the same weightage
            }

            // Loop through all request inputs to find and add non-indexed weightage (e.g., weightage43644, weightage12345, etc.)
            foreach ($request->all() as $key => $value) {
                // Check if the key matches the pattern "weightage" followed by numeric ID
                if (preg_match('/^weightage(\d+)$/', $key, $matches)) {
                    // Extract the weightage value and add it to the total weightage
                    $totalWeightage += (float)$value;
                }
            }

            // Now loop through the kra names and add their corresponding weightage to the total
            foreach ($request->kra as $index => $kraName) {
                // Get the weightage for the current KRA, or default to 0 if not set
                $kraWeightage = isset($kraWeightages[$index]) ? (float)$kraWeightages[$index] : 0;

                // Add to total weightage
                $totalWeightage += $kraWeightage;
            }

            // Before processing the KRAs, validate if the total weightage is 100
            if ($request->submit_type == 'final_submit') {
                if ($totalWeightage != 100) {
                    return response()->json([
                        'success' => false,
                        'message' => 'KRA weightage limit must be equal to 100.'
                    ], 400);
                }
            }

            // Proceed with processing the KRAs if the total weightage is valid
            foreach ($request->kra as $index => $kraName) {
                if (empty($kraName)) continue; // Skip empty KRAs
                
                if ($request->weightage < 2 && $request->Period !== 'Annual') {
                    return response()->json([
                        'success' => false,
                        'message' => "Weightage below 2 permits only 'Annual' period selection.",
                    ], 400);
                }

                // Check if "Monthly" is selected but weightage is less than 10
                if ($request->Period === 'Monthly' && $request->weightage < 10) {
                
                    return response()->json([
                        'success' => false,
                        'message' => "Selecting 'Monthly' requires weightage of at least 10.",
                    ], 400);
                } 
                
            }
        }
        // Initialize total weightage
        $totalWeightage = 0;

        // First, calculate the total weightage by iterating over the KRA data
        if (!$request->has('kra') || !is_array($request->kra)) {
        
        // Initialize total weightage
        $totalWeightage = 0;

        // Handle indexed weightage array (kra[] and weightage[] arrays)
        $kraWeightages = $request->has('weightage') ? $request->input('weightage') : [];

        // If weightage is a single value and not an array, convert it into an array for all kra
        if (count($kraWeightages) == 1) {
            $kraWeightages = array_fill(0, count($request->kra), $kraWeightages[0]);  // Fill all kra with the same weightage
        }


        // Loop through all request inputs to find and add non-indexed weightage (e.g., weightage43644, weightage12345, etc.)
        foreach ($request->all() as $key => $value) {
            // Check if the key matches the pattern "weightage" followed by numeric ID
            if (preg_match('/^weightage(\d+)$/', $key, $matches)) {
                // Extract the weightage value and add it to the total weightage
                $totalWeightage += (float)$value;
            }
        }


        // Now loop through the kra names and add their corresponding weightage to the total
        foreach ($request->kraId as $kraId) {

            // Get the weightage for the current KRA, or default to 0 if not set
            $kraWeightage = isset($kraWeightages[$kraId]) ? (float)$kraWeightages[$kraId] : 0;

            // Add to total weightage
            $totalWeightage += $kraWeightage;
        }

            // Before processing, validate if the total weightage is 100
            if ($request->submit_type == 'final_submit') {
                if ($totalWeightage != 100) {
                    return response()->json([
                        'success' => false,
                        'message' => 'KRA weightage limit must be equal to 100.'
                    ], 400);
                }
            }

            // Proceed with processing the KRAs if the total weightage is valid
            foreach ($request->kraId as $kraId) {
                $kraName = $request->input("kra$kraId");
                $kraDescription = $request->input("kra_description$kraId");
                $measure = $request->input("Measure_$kraId");
                $unit = $request->input("Unit_$kraId");
                $weightage = $request->input("weightage$kraId");
                $logic = $request->input("Logic_$kraId");
                $period = $request->input("Period_$kraId");
                $target = $request->input("Target_$kraId");

                if ($weightage < 2 && $period !== 'Annual') {
                    return response()->json([
                        'success' => false,
                        'message' => "Weightage below 2 permits only 'Annual' period selection.",
                    ], 400);
                }
    
                // Check if "Monthly" is selected but weightage is less than 10
                if ($period=== 'Monthly' && $weightage < 10) {
                
                    return response()->json([
                        'success' => false,
                        'message' => "Selecting 'Monthly' requires weightage of at least 10.",
                    ], 400);
                }   
            

            }
        }
        if ($request->has('Measure_subKRA') && is_array($request->Measure_subKRA)) {
           
            foreach ($request->Measure_subKRA as $kraIndex => $subKraMeasures) {
                // ✅ Find the correct existing KRA using the index (kraIndex)
                $existingKRA = DB::table('hrm_pms_kra')
                    ->where('EmployeeID', $EmployeeId)
                    ->where('YearId', $KraYId)
                    ->where('KRA', $request->input("kra{$kraIndex}")) // ✅ Ensure it's the correct KRA
                    ->first();
                    

                if ($existingKRA) {
                    $this->processSubKRA($request, $kraIndex, $existingKRA->KRAId, $EmployeeId);
                }
            }
        }
        if ($request->has('kra') && is_array($request->kra)) {
                // Initialize total weightage
                $totalWeightage = 0;

                // Handle indexed weightage array (kra[] and weightage[] arrays)
                $kraWeightages = $request->has('weightage') ? $request->input('weightage') : [];

                // If weightage is a single value and not an array, convert it into an array for all kra
                if (count($kraWeightages) == 1) {
                    $kraWeightages = array_fill(0, count($request->kra), $kraWeightages[0]);  // Fill all kra with the same weightage
                }

                // Loop through all request inputs to find and add non-indexed weightage (e.g., weightage43644, weightage12345, etc.)
                foreach ($request->all() as $key => $value) {
                    // Check if the key matches the pattern "weightage" followed by numeric ID
                    if (preg_match('/^weightage(\d+)$/', $key, $matches)) {
                        // Extract the weightage value and add it to the total weightage
                        $totalWeightage += (float)$value;
                    }
                }

                // Now loop through the kra names and add their corresponding weightage to the total
                foreach ($request->kra as $index => $kraName) {
                    // Get the weightage for the current KRA, or default to 0 if not set
                    $kraWeightage = isset($kraWeightages[$index]) ? (float)$kraWeightages[$index] : 0;

                    // Add to total weightage
                    $totalWeightage += $kraWeightage;
                }

            // Before processing the KRAs, validate if the total weightage is 100
            if ($request->submit_type == 'final_submit') {
                if ($totalWeightage != 100) {
                    return response()->json([
                        'success' => false,
                        'message' => 'KRA weightage limit must be equal to 100.'
                    ], 400);
                }
            }

            // Proceed with processing the KRAs if the total weightage is valid
            foreach ($request->kra as $index => $kraName) {
                if (empty($kraName)) continue; // Skip empty KRAs
                
                if ($request->weightage < 2 && $request->Period !== 'Annual') {
                    return response()->json([
                        'success' => false,
                        'message' => "Weightage below 2 permits only 'Annual' period selection.",
                    ], 400);
                }

                // Check if "Monthly" is selected but weightage is less than 10
                if ($request->Period === 'Monthly' && $request->weightage < 10) {
                 
                    return response()->json([
                        'success' => false,
                        'message' => "Selecting 'Monthly' requires weightage of at least 10.",
                    ], 400);
                } 
                // Prepare the KRA data
                $kraData = [
                    'YearId' => $KraYId,
                    'EmployeeID' => $EmployeeId,
                    'DepartmentId' => $departmentId,
                    'KRA' => $kraName,
                    'KRA_Description' => $request->kra_description[$index] ?? '',
                    'Measure' => $request->Measure[$index] ?? '',
                    'Unit' => $request->Unit[$index] ?? '',
                    'Weightage' => $request->weightage[$index] ?? 0,
                    'Logic' => $request->Logic[$index] ?? '',
                    'Period' => $request->Period[$index] ?? '',
                    'Target' => $request->Target[$index] ?? 0,
                    'CompanyId' => $CompanyId,
                            ];

                            // Handle existing KRA record update or new KRA insert
                            $existingKRA = DB::table('hrm_pms_kra')
                                ->where('EmployeeID', $EmployeeId)
                                ->where('KRA', $kraName)
                                ->where('YearId', $KraYId)
                                ->first();

                            if ($existingKRA) {
                                DB::table('hrm_pms_kra')
                                    ->where('KRAId', $existingKRA->KRAId)
                                    ->update([
                                        'EmpStatus' => 'P',
                                        'AppStatus' => 'P']
                                    );
                                $kraRecordId = $existingKRA->KRAId;
                            } 
                            
                            else {
                                if ($request->submit_type == 'final_submit') {

                                    $kraRecordId = DB::table('hrm_pms_kra')->insertGetId(array_merge($kraData, [
                                        'CreatedBy' => $EmployeeId,
                                        'CreatedDate' => now(),
                                        'KRAStatus' => 'A',
                                        'UseKRA' => 'A',
                                        'EmpStatus' => 'A',
                                        'AppStatus' => 'P',
                                        'RevStatus' => 'P',
                                        'HODStatus' => 'P',
                                    ]));
                                }
                                else{
				                $kraRecordId = DB::table('hrm_pms_kra')->insertGetId(array_merge($kraData, [
				                    'CreatedBy' => $EmployeeId,
				                    'CreatedDate' => now(),
				                    'KRAStatus' => 'A',
				                    'UseKRA' => 'A',
				                    'EmpStatus' => 'D',
				                    'AppStatus' => 'P',
				                    'RevStatus' => 'P',
				                    'HODStatus' => 'P',
				                ]));
                                }
                            }

                            // Process the sub-KRAs if any
                            // if ($request->has("Measure_subKRA.{$index}")) {
                            //     if ($request->has('Measure_subKRA') && is_array($request->Measure_subKRA)){
                            //     $this->processSubKRA($request, $index, $kraRecordId, $EmployeeId);
                            // }
            }
            

        }
        // Initialize total weightage
        $totalWeightage = 0;

        // First, calculate the total weightage by iterating over the KRA data
        if (!$request->has('kra') || !is_array($request->kra)) {
           
           // Initialize total weightage
           $totalWeightage = 0;

           // Handle indexed weightage array (kra[] and weightage[] arrays)
           $kraWeightages = $request->has('weightage') ? $request->input('weightage') : [];

           // If weightage is a single value and not an array, convert it into an array for all kra
           if (count($kraWeightages) == 1) {
               $kraWeightages = array_fill(0, count($request->kra), $kraWeightages[0]);  // Fill all kra with the same weightage
           }


           // Loop through all request inputs to find and add non-indexed weightage (e.g., weightage43644, weightage12345, etc.)
           foreach ($request->all() as $key => $value) {
               // Check if the key matches the pattern "weightage" followed by numeric ID
               if (preg_match('/^weightage(\d+)$/', $key, $matches)) {
                   // Extract the weightage value and add it to the total weightage
                   $totalWeightage += (float)$value;
               }
           }


           // Now loop through the kra names and add their corresponding weightage to the total
           foreach ($request->kraId as $kraId) {

               // Get the weightage for the current KRA, or default to 0 if not set
               $kraWeightage = isset($kraWeightages[$kraId]) ? (float)$kraWeightages[$kraId] : 0;

               // Add to total weightage
               $totalWeightage += $kraWeightage;
           }

            // Before processing, validate if the total weightage is 100
            if ($request->submit_type == 'final_submit') {
                if ($totalWeightage != 100) {
                    return response()->json([
                        'success' => false,
                        'message' => 'KRA weightage limit must be equal to 100.'
                    ], 400);
                }
            }

            // Proceed with processing the KRAs if the total weightage is valid
            foreach ($request->kraId as $kraId) {
                $kraName = $request->input("kra$kraId");
                $kraDescription = $request->input("kra_description$kraId");
                $measure = $request->input("Measure_$kraId");
                $unit = $request->input("Unit_$kraId");
                $weightage = $request->input("weightage$kraId");
                $logic = $request->input("Logic_$kraId");
                $period = $request->input("Period_$kraId");
                $target = $request->input("Target_$kraId");

                if ($weightage < 2 && $period !== 'Annual') {
                    return response()->json([
                        'success' => false,
                        'message' => "Weightage below 2 permits only 'Annual' period selection.",
                    ], 400);
                }
    
                // Check if "Monthly" is selected but weightage is less than 10
                if ($period=== 'Monthly' && $weightage < 10) {
                 
                    return response()->json([
                        'success' => false,
                        'message' => "Selecting 'Monthly' requires weightage of at least 10.",
                    ], 400);
                }   
                // Prepare the KRA data for updating or inserting
                $kraData = [
                    'YearId' => $KraYId,
                    'EmployeeID' => $EmployeeId,
                    'DepartmentId' => $departmentId,
                    'KRA' => $kraName ?? '',
                    'KRA_Description' => $kraDescription ?? '', // Handle null description
                    'Measure' => $measure ?? '',
                    'Unit' => $unit ?? '',
                    'Weightage' => $weightage ?? 0,  // Default to 0 if weightage is null
                    'Logic' => $logic ?? '',
                    'Period' => $period ?? '',
                    'Target' => $target ?? 0, // Default to 0 if target is null
                    'CompanyId' => $CompanyId,
                ];

                // Check if the KRA already exists
                $existingKRA = DB::table('hrm_pms_kra')
                    ->where('EmployeeID', $EmployeeId)
                    ->where('KRAId', $kraId) // Use KRAId to match the specific record
                    ->where('YearId', $KraYId)
                    ->first();

                if ($request->submit_type == 'final_submit') {
                    if ($existingKRA) {
                        DB::table('hrm_pms_kra')
                            ->where('KRAId', $existingKRA->KRAId)
                            ->update(['EmpStatus' => 'A',
                                        'UseKRA'=>'A',
                                      'AppStatus' => 'P']); 
                    }
                }

                if ($existingKRA) {
                    // Compare the existing values with the new ones and update only if there are changes
                    $updateData = [];

                    foreach ($kraData as $key => $newValue) {
                        if ($existingKRA->{$key} !== $newValue) {
                            $updateData[$key] = $newValue;
                        }
                    }

                    // Update the existing KRA if there are any changes
                    if (!empty($updateData)) {
                        DB::table('hrm_pms_kra')
                            ->where('KRAId', $existingKRA->KRAId)
                            ->update($updateData);
                    }
                } 
                
                
                else {
                                        if ($request->submit_type == 'final_submit') {

                                         DB::table('hrm_pms_kra')
							->insert(array_merge($kraData, [
							    'CreatedBy' => $EmployeeId,
							    'CreatedDate' => now(),
							    'KRAStatus' => 'A',
							    'UseKRA' => 'A',
							    'EmpStatus' => 'A',
							    'AppStatus' => 'P',
							    'RevStatus' => 'P',
							    'HODStatus' => 'P',
							]));
                                        }
                                        else{
				                DB::table('hrm_pms_kra')
							->insert(array_merge($kraData, [
							    'CreatedBy' => $EmployeeId,
							    'CreatedDate' => now(),
							    'KRAStatus' => 'A',
							    'UseKRA' => 'A',
							    'EmpStatus' => 'D',
							    'AppStatus' => 'P',
							    'RevStatus' => 'P',
							    'HODStatus' => 'P',
							]));
                                }
                            }
            }
        }

        // Before processing the KRAs, validate if the total weightage is 100
        if ($request->submit_type == 'final_submit') {
            $employeeAppraisal = \DB::table('hrm_employee_pms')
                ->where('EmployeeID', $EmployeeId)
                ->first();

                $Appraiser_EmployeeID = $employeeAppraisal->Appraiser_EmployeeID ?? null; // Use null coalescing operator for safety

                $employeeemailid = EmployeeGeneral::where('EmployeeID', $EmployeeId)->first();       
                $employeedetails_name= Employee::where('EmployeeID', $EmployeeId)->first();

                $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
                $EmpCode = $employeedetails_name->EmpCode;
                $EmpMailid = $employeeemailid->EmailId_Vnr ?? null;

                $appraisermailid = EmployeeGeneral::where('EmployeeID', $Appraiser_EmployeeID)->first();       
                $appraisar_name= Employee::where('EmployeeID', $Appraiser_EmployeeID)->first();

                $Appraisarname = ($appraisar_name->Fname ?? 'null').' ' . ($appraisar_name->Sname ?? 'null').' ' . ($appraisar_name->Lname ?? 'null');
                $Appraisaremail = $appraisermailid->EmailId_Vnr ?? null;


                $details = [
                    'RepoName' => $Appraisarname,
                    'subject'=>'KRA Submission Status.',
                    'EmpName'=> $Empname,
                    'EmpCode'=>$EmpCode,
                    'site_link' => "vnrseeds.co.in"             
                ];
        
                if (!empty($Appraisaremail)) {
                    // Mail::to($Appraisaremail)->send(new EmployeeKRAFillRepo($details));
                }
                
                // Check if Employee email exists before sending the mail
                if (!empty($EmpMailid)) {
                    // Mail::to($EmpMailid)->send(new EmployeeKRAFill($details));
                }
                $baseUrl = request()->getSchemeAndHttpHost(); 

                // Construct the link dynamically
                $notificationLink = $baseUrl . "/appraiser";
                \DB::table('notification')->insert([
                    'userid' => $Appraiser_EmployeeID,
                    'notification_read' => 0, // Unread notification
                    'title' => "KRA Submission KRA form from {$Empname}",
                    'description' => "KRA form from {$Empname} has been submitted.",
                    'notification_link'=>$notificationLink,
                    'created_at' => now()
                ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'KRA and Sub-KRA data successfully saved/updated.'
        ], 200);
    }

    
    function processSubKRA($request, $index, $kraRecordId, $EmployeeId) {
        $subKraIds = $request->input("subKraId.{$index}", []); 
        $subKraNames = $request->input("subKraName.{$index}", []);
        $subKraDescs = $request->input("subKraDesc.{$index}", []);
        $subKraMeasures = $request->input("Measure_subKRA.{$index}", []);
        $subKraUnits = $request->input("Unit_subKRA.{$index}", []);
        $subKraWeightages = $request->input("Weightage_subKRA.{$index}", []);
        $subKraLogics = $request->input("Logic_subKRA.{$index}", []);
        $subKraPeriods = $request->input("Period_subKRA.{$index}", []);
        $subKraTargets = $request->input("Target_subKRA.{$index}", []);
    
        // Get the main KRA weightage
        $mainKra = DB::table('hrm_pms_kra')
                    ->where('KRAId', $kraRecordId)
                    ->first();
    

                    $mainKraWeightage = $mainKra ? $mainKra->Weightage : 0;

                    // Check if request weightage is different from the database value
                    $requestedWeightage = $request->input("weightage{$index}", null);
                
                    // If the request has a weightage and it differs from the database value, take the request value
                    if ($requestedWeightage !== null && $requestedWeightage != $mainKraWeightage) {
                        $mainKraWeightage = $requestedWeightage; // Override the DB value with the request value
                    }   
        // Calculate the total weightage of all sub-KRAs
        $totalSubKraWeightage = 0;
        foreach ($subKraWeightages as $weightage) {
            $totalSubKraWeightage += $weightage;
        }
    
        // Check if the total weightage exceeds the main KRA's weightage
        if($request->submit_type == 'final_submit'){

            if ($totalSubKraWeightage != $mainKraWeightage) {
                // Return an error if the total weightage exceeds the main KRA weightage
                throw new \Exception("Total Sub-KRA weightage must be equal to the assigned KRA weightage.");
            }

                
            }
    
        // Continue with processing sub-KRAs
        foreach ($subKraMeasures as $subIndex => $measure) {
            if (empty(trim($measure))) continue; // Skip empty measures
    
            if (!isset($subKraNames[$subIndex]) || !isset($subKraDescs[$subIndex])) {
                continue; // Skip if name/description is missing
            }
    
            // Prepare Data
            $subKraData = [
                'KRA' => $subKraNames[$subIndex],
                'KRA_Description' => $subKraDescs[$subIndex],
                'Measure' => $measure,
                'Unit' => $subKraUnits[$subIndex] ?? '%',
                'Weightage' => $subKraWeightages[$subIndex] ?? 0,
                'Logic' => $subKraLogics[$subIndex] ?? '',
                'Period' => $subKraPeriods[$subIndex] ?? '',
                'Target' => $subKraTargets[$subIndex] ?? 0,
                'KSubStatus' => 'A',
                'CrUpDate' => now(),
                'SelfRating'=> 0,
                'AchivementRemark' => '',
                'Mid_AchivementRemark' => '',
            ];
    
            if (!empty($subKraIds[$subIndex])) {
                if($subKraIds[$subIndex] == 'newSubKraId'){
                     // Insert new sub-KRA if `subKraId` is empty
                $subKraData['KRAId'] = $kraRecordId;
                $subKraData['EmployeeID'] = $EmployeeId;
                DB::table('hrm_pms_krasub')->insert($subKraData);
                }
                else{
                // Update using `subKraId`
                DB::table('hrm_pms_krasub')
                    ->where('KRASubId', $subKraIds[$subIndex])
                    ->update($subKraData);
                }
            } else {
                // Insert new sub-KRA if `subKraId` is empty
                $subKraData['KRAId'] = $kraRecordId;
                $subKraData['EmployeeID'] = $EmployeeId;
                DB::table('hrm_pms_krasub')->insert($subKraData);
            }
        }
    }

    public function deleteSubKra(Request $request)
    {
        $subKraId = $request->input('subKraId');
        if (!$subKraId) {
            return response()->json(['success' => false, 'message' => 'Invalid Sub-KRA ID.'], 400);
        }
        // Check if Cmnt or Ach has meaningful data in the targetdefine table
        $targetCheck = DB::table('hrm_pms_kra_tgtdefin')
            ->where('KRASubId', $subKraId)
            ->where(function ($query) {
                $query->whereNotNull('Cmnt')
                    ->where('Cmnt', '!=', '')
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('Ach')
                            ->where('Ach', '!=', '0.00')
                            ->where('Ach', '!=', '0.0');
                    });
            })
            ->exists();



        if ($targetCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete Sub-KRA as it has existing achievements or comments.'
            ], 403);
        }

        // Delete from pms_krsub
        DB::table('hrm_pms_krasub')->where('KRASubId', $subKraId)->delete();

        // Delete from hrm_pms_kra_tgtdefin
        DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subKraId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sub-KRA successfully deleted.'
        ], 200);
    }


    public function deleteKra(Request $request)
    {
        $kraId = $request->kraId;
        if (!$kraId) {
            return response()->json(['success' => false, 'message' => 'Invalid KRA ID.'], 400);
        }
        // Check if Cmnt or Ach has meaningful data in the targetdefine table
        $subkraCheck = DB::table('hrm_pms_krasub')
            ->where('KRAId', $kraId)
            ->exists();

        if ($subkraCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete KRA as it has existing subkra.'
            ], 403);
        }

        // Delete from pms_krsub
        DB::table('hrm_pms_kra')->where('KRAId', $kraId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'KRA successfully deleted.'
        ], 200);
    }
    
    public function getLogicData()
    {
        $employeeId = Auth::user()->EmployeeID;

        // Employee general details
        $employee = DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('core_designation as d', 'g.DesigId', '=', 'd.id')
            ->leftJoin('core_grades as gd', 'g.GradeId', '=', 'gd.id')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            // ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
            ->where('g.EmployeeID', $employeeId)
            ->select(
                'e.EmpCode',
                'g.DateJoining',
                'g.HqId',
                'e.RetiStatus',
                'e.RetiDate',
                'd.designation_name',
                'g.DepartmentId',
                'hq.city_village_name',
                'g.DateJoining',
                'gd.grade_name'
            )
            ->first();
        $logicData = DB::table('hrm_pms_logic')
            ->where('logic_sts', 1)
            ->where(function ($query) use ($employee) {
                $query->where('logic_dept', 0)
                    ->orWhere('logic_dept',  $employee->DepartmentId)
                    ->orWhere('logic_dept1',  $employee->DepartmentId)
                    ->orWhere('logic_dept2',  $employee->DepartmentId)
                    ->orWhere('logic_dept3',  $employee->DepartmentId)
                    ->orWhere('logic_dept4',  $employee->DepartmentId)
                    ->orWhere('logic_dept5',  $employee->DepartmentId);
            })
            ->orderBy('logic_order', 'ASC')
            ->get();

        return response()->json([
            'success' => true,
            'logicData' => $logicData,  // Send logic data in the response
        ]);
    }
    
    public function saveappraiser(Request $request)
    {
        // Access the kraData from the request
        $kraData = $request->input('kraData');
        $EmployeeId = $request->input('employeeId');
        $KraYId = $request->input('kraYId');
        $CompanyId = Auth::user()->CompanyId;

        $employee = DB::table('hrm_employee_general')
            ->where('EmployeeID', $EmployeeId)
            ->select('DepartmentId')
            ->first();

        $departmentId = $employee->DepartmentId ?? null;
        $totalMainKraWeightage = 0;

        foreach ($kraData as $kra) {
            // Add the weightage of the current KRA to the total
            if ($request->buttonClass == "approval-btn") {
                $totalMainKraWeightage += $kra['Weightage'];

                // Check if the total weightage of the main KRA exceeds 100
                if ($totalMainKraWeightage > 100) {
                    return response()->json(['error' => 'The total weightage of the KRA must be exactly 100.']);
                }

                // Ensure the total weightage of the main KRA is not less than 100
                if ($totalMainKraWeightage != 100 && $kra === end($kraData)) {
                    return response()->json(['error' => 'The total weightage of the KRA must be exactly 100.']);
                }
            }

            // Check if the KRAId is 'new' (i.e., inserting a new record)
            if ($kra['KRAId'] === 'new') {
                // Set status for appraiser
                $statusapp = $request->buttonClass == "approval-btn" ? 'A' : 'D'; // both conditions set 'D' for now
                $statusemp = $request->buttonClass == "approval-btn" ? 'A' : 'A'; // both conditions set 'D' for now

                // Insert new KRA into KRA table
                $kraId = DB::table('hrm_pms_kra')->insertGetId([
                    'YearId' => $KraYId,
                    'EmployeeID' => $EmployeeId,
                    'DepartmentId' => $departmentId,
                    'KRA' => $kra['KRA'],
                    'KRA_Description' => $kra['KRA_Description'],
                    'Measure' => $kra['Measure'],
                    'Unit' => $kra['Unit'],
                    'Weightage' => $kra['Weightage'],
                    'Logic' => $kra['Logic'],
                    'Period' => $kra['Period'],
                    'Target' => $kra['Target'],
                    'AppStatus' => $statusapp,
                    'EmpStatus' => $statusemp,
                    'CompanyId' => $CompanyId,
                    'UseKRA' => 'A',
                    'CreatedBy' => Auth::user()->EmployeeID,
                    'CreatedDate' => now(),
                ]);
            } else {
                $statusapp = $request->buttonClass == "approval-btn" ? 'A' : 'D'; // both conditions set 'D' for now
                $statusemp = $request->buttonClass == "approval-btn" ? 'A' : 'A'; // both conditions set 'D' for now

                // Update existing KRA
                $kraId = $kra['KRAId'];
                DB::table('hrm_pms_kra')
                    ->where('KRAId', $kraId)
                    ->update([
                        'KRA' => $kra['KRA'],
                        'KRA_Description' => $kra['KRA_Description'],
                        'Measure' => $kra['Measure'] ?? '',
                        'Unit' => $kra['Unit'] ?? '',
                        'Weightage' => $kra['Weightage'] ?? '',
                        'Logic' => $kra['Logic'] ?? '',
                        'Period' => $kra['Period'] ?? '',
                        'Target' => $kra['Target'] ?? '0.00',
                        'AppStatus' => $statusapp,
                        'EmpStatus' => $statusemp,
						'RevStatus' => 'P',
                        'UseKRA' => 'R',

                    ]);
            }

            // Handle Sub-KRAs if they exist
            if (isset($kra['subKraData']) && is_array($kra['subKraData'])) {
                $totalSubKraWeightage = 0;
                if ($request->buttonClass == "approval-btn") {
                    foreach ($kra['subKraData'] as $subKra) {
                        // Add the sub-KRA weightage to the total
                        $totalSubKraWeightage += $subKra['Weightage'];
                    }

                    // Ensure the sum of the sub-KRA weightages is exactly equal to the main KRA weightage
                    if ($totalSubKraWeightage != $kra['Weightage']) {

                        return response()->json(['error' => 'The sum of the sub-KRA weightages must exactly equal the main KRA weightage.']);
                    }
                }

                // Handle sub-KRAs insertion or update
                foreach ($kra['subKraData'] as $subKra) {
                    if (isset($subKra['SubKRAId']) && $subKra['SubKRAId'] !== 'new') {
                        // Update existing sub-KRA
                        DB::table('hrm_pms_krasub')
                            ->where('KRASubId', $subKra['SubKRAId'])
                            ->update([
                                'KRAId' => $kraId,
                                'KRA' => $subKra['KRA'],
                                'KRA_Description' => $subKra['KRA_Description'],
                                'Measure' => $subKra['Measure'],
                                'Unit' => $subKra['Unit'],
                                'Weightage' => $subKra['Weightage'],
                                'Logic' => $subKra['Logic'],
                                'Period' => $subKra['Period'],
                                'Target' => $subKra['Target'],
                                'KSubStatus' => 'A',
                                'CrUpDate' => now(),
                                'SelfRating' => '0.0',
                                'AchivementRemark' => '',
                                'Mid_AchivementRemark' => '',
                            ]);
                    } else {
                        // Insert new sub-KRA
                        DB::table('hrm_pms_krasub')->insert([
                            'KRAId' => $kraId,
                            'KRA' => $subKra['KRA'],
                            'KRA_Description' => $subKra['KRA_Description'],
                            'Measure' => $subKra['Measure'],
                            'Unit' => $subKra['Unit'],
                            'Weightage' => $subKra['Weightage'],
                            'Logic' => $subKra['Logic'],
                            'Period' => $subKra['Period'],
                            'Target' => $subKra['Target'],
                            'KSubStatus' => 'A',
                            'CrUpDate' => now(),
                            'SelfRating' => '0.0',
                            'AchivementRemark' => '',
                            'Mid_AchivementRemark' => '',
                        ]);
                    }
                }
            }
        }
       
        if($request->buttonClass == "approval-btn"){
        $employeeemailid = EmployeeGeneral::where('EmployeeID', $EmployeeId)->first();       
        $employeedetails_name= Employee::where('EmployeeID', $EmployeeId)->first();

        $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
        $EmpCode = $employeedetails_name->EmpCode;
        $EmpMailid = $employeeemailid->EmailId_Vnr;
        $employeeAppraisal = \DB::table('hrm_employee_pms')
                ->where('EmployeeID', $EmployeeId)
                ->first();

        $Reviewer_EmployeeID = $employeeAppraisal->Reviewer_EmployeeID ?? null; // Use null coalescing operator for safety


        $details = [
            'subject'=>'KRA Submission Status.',
            'EmpName'=> $Empname,
            'site_link' => "vnrseeds.co.in"             
        ];
        // Mail::to($EmpMailid)->send(new Appraisal($details));

        $baseUrl = request()->getSchemeAndHttpHost(); // Example: https://esslive.vnrseeds.co.in

                // Construct the link dynamically
                $notificationLink_employee = $baseUrl . "/pms";
                $notificationLink_reviewer = $baseUrl . "/reviewer";

                \DB::table('notification')->insert([
                    'userid' => $EmployeeId,
                    'notification_read' => 0, // Unread notification
                    'title' => "KRA Status Updated by Manager",
                    'description' => "Your KRA status has been updated by your reporting manager.",
                    'notification_link' => $notificationLink_employee,
                    'created_at' => now()
                ]);
                
                \DB::table('notification')->insert([
                    'userid' => $Reviewer_EmployeeID,
                    'notification_read' => 0, // Unread notification
                    'title' => "KRA Submission Status Updated",
                    'description' => "The KRA form submission of {$Empname} ({$EmpCode}) has been updated by the reporting manager.",
                    'notification_link' => $notificationLink_reviewer,
                    'created_at' => now()
                ]);
                
               
        }



        return response()->json(['success' => 'KRA and sub-KRA data saved successfully.']);
    }
    
    public function savereviewer(Request $request)
    {
        $EmployeeId = $request->input('employeeId');
        $KraYId = $request->input('kraYId');

        $kraRecords = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $EmployeeId)  // Ensure column name matches exactly
            ->where('YearId', $KraYId)
            ->get();
        // Check if there are any KRA records found
        if ($kraRecords->isNotEmpty()) {
            foreach ($kraRecords as $kra) {
                DB::table('hrm_pms_kra')
                    ->where('EmployeeId', $kra->EmployeeID)
                    ->where('YearId', $kra->YearId)
                    ->update([
                        'RevStatus' => 'A',
                        'UseKRA' => 'H',
                        'HODStatus' => 'P',

                    ]);
            }
            
            $employeeAppraisal = \DB::table('hrm_employee_pms')
        ->where('EmployeeID', $EmployeeId)
        ->first();

        $Appraiser_EmployeeID = $employeeAppraisal->Appraiser_EmployeeID ?? null; // Use null coalescing operator for safety

        $employeeemailid = EmployeeGeneral::where('EmployeeID', $EmployeeId)->first();       
        $employeedetails_name= Employee::where('EmployeeID', $EmployeeId)->first();

        $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
        $EmpCode = $employeedetails_name->EmpCode;
        $EmpMailid = $employeeemailid->EmailId_Vnr;

        $appraisermailid = EmployeeGeneral::where('EmployeeID', $Appraiser_EmployeeID)->first();       
        $appraisar_name= Employee::where('EmployeeID', $Appraiser_EmployeeID)->first();

        $Appraisarname = ($appraisar_name->Fname ?? 'null').' ' . ($appraisar_name->Sname ?? 'null').' ' . ($appraisar_name->Lname ?? 'null');
        $Appraisaremail = $appraisermailid->EmailId_Vnr;


        $details = [
            'RepoName' => $Appraisarname,
            'subject'=>'KRA Submission Status.',
            'EmpName'=> $Empname,
            'EmpCode'=>$EmpCode,
            'site_link' => "vnrseeds.co.in"             
        ];
    

        $Hod_EmployeeID = $employeeAppraisal->Rev2_EmployeeID ?? null; // Use null coalescing operator for safety

        $details = [
            'subject'=>'KRA Submission Status.',
            'EmpName'=> $Empname,
            'site_link' => "vnrseeds.co.in"             
        ];
        // Mail::to($EmpMailid)->send(new Appraisal($details));

        $baseUrl = request()->getSchemeAndHttpHost(); // Example: https://esslive.vnrseeds.co.in

        // Construct the link dynamically
        $notificationLink_hod = $baseUrl . "/hod";
        $notificationLink_appraiser = $baseUrl . "/appraiser";

        \DB::table('notification')->insert([
            'userid' => $Appraiser_EmployeeID,
            'notification_read' => 0, // Unread notification
            'title' => "Team member KRA Status Updated by Manager",
            'description' => "Your Team member {$Empname} ({$EmpCode}) KRA status has been updated by your reporting manager.",
            'notification_link' => $notificationLink_appraiser,
            'created_at' => now()
        ]);
        
        \DB::table('notification')->insert([
            'userid' => $Hod_EmployeeID,
            'notification_read' => 0, // Unread notification
            'title' => "KRA Submission Status Updated",
            'description' => "The KRA form submission of {$Empname} ({$EmpCode}) has been updated by Reviewer",
            'notification_link' => $notificationLink_hod,
            'created_at' => now()
        ]);
        

            // You can add additional logic to handle success or failure if needed
            return response()->json(['message' => 'KRA records updated successfully.']);
        } else {
            return response()->json(['message' => 'No KRA records found for the given Employee and Year.']);
        }
    }
    
    public function savehod(Request $request)
    {
        $EmployeeId = $request->input('employeeId');
        $KraYId = $request->input('kraYId');

        $kraRecords = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $EmployeeId)  // Ensure column name matches exactly
            ->where('YearId', $KraYId)
            ->get();
        // Check if there are any KRA records found
        if ($kraRecords->isNotEmpty()) {
            foreach ($kraRecords as $kra) {
                DB::table('hrm_pms_kra')
                    ->where('EmployeeId', $kra->EmployeeID)
                    ->where('YearId', $kra->YearId)
                    ->update([
                        'HODStatus' => 'A',
                        'UseKRA' => 'M',
                    ]);
            }
            $employeeAppraisal = \DB::table('hrm_employee_pms')
        ->where('EmployeeID', $EmployeeId)
        ->first();

        $Reviewer_EmployeeID = $employeeAppraisal->Reviewer_EmployeeID ?? null; // Use null coalescing operator for safety

        $employeeemailid = EmployeeGeneral::where('EmployeeID', $EmployeeId)->first();       
        $employeedetails_name= Employee::where('EmployeeID', $EmployeeId)->first();

        $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
        $EmpCode = $employeedetails_name->EmpCode;
        $EmpMailid = $employeeemailid->EmailId_Vnr;

        $Reviewer_EmployeeID_NAME = EmployeeGeneral::where('EmployeeID', $Reviewer_EmployeeID)->first();       
        $Reviewer_EmployeeID_name= Employee::where('EmployeeID', $Reviewer_EmployeeID)->first();

        $Areviewername = ($Reviewer_EmployeeID_name->Fname ?? 'null').' ' . ($Reviewer_EmployeeID_name->Sname ?? 'null').' ' . ($Reviewer_EmployeeID_name->Lname ?? 'null');
        $Arevieweremail = $Reviewer_EmployeeID_NAME->EmailId_Vnr;


        $details = [
            'RepoName' => $Areviewername,
            'subject'=>'KRA Submission Status.',
            'EmpName'=> $Empname,
            'EmpCode'=>$EmpCode,
            'site_link' => "vnrseeds.co.in"             
        ];
        // Mail::to($Arevieweremail)->send(new HOD($details));

        $baseUrl = request()->getSchemeAndHttpHost(); // Example: https://esslive.vnrseeds.co.in

        // Construct the link dynamically
        $notificationLink_reviewer = $baseUrl . "/reviewer";

        \DB::table('notification')->insert([
            'userid' => $Reviewer_EmployeeID,
            'notification_read' => 0, // Unread notification
            'title' => "Team member KRA Status Updated by Manager",
            'description' => "Your Team member {$Empname} ({$EmpCode}) KRA status has been updated by your reporting manager.",
            'notification_link' => $notificationLink_reviewer,
            'created_at' => now()
        ]);
        
            return response()->json(['message' => 'KRA records updated successfully.']);
        } else {
            return response()->json(['message' => 'No KRA records found for the given Employee and Year.']);
        }
    }
    
    public function revert(Request $request)
    {
        // Find the KRA record(s) for the given employee and year
        $kraRecords = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $request->employeeId)  // Ensure column name matches exactly
            ->where('YearId', $request->yearId)
            ->get();

        // Check if there are any KRA records found
        if ($kraRecords->isNotEmpty()) {
            foreach ($kraRecords as $kra) {
                DB::table('hrm_pms_kra')
                    ->where('EmployeeId', $kra->EmployeeID)
                    ->where('YearId', $kra->YearId)
                    ->update([
                        'EmpStatus' => 'P',
                        'AppStatus' => 'R',
                        'AppRevertNote' => $request->input('revertNote') // Assuming revertNote is passed in the request
                    ]);
            }

    
            $employeeemailid = EmployeeGeneral::where('EmployeeID', $request->employeeId)->first();       
            $employeedetails_name= Employee::where('EmployeeID', $request->employeeId)->first();
    
            $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
            $EmpMailid = $employeeemailid->EmailId_Vnr;
    
    
            $details = [
                'subject'=>'KRA Submission Status.',
                'EmpName'=> $Empname,
                'Reason'=>$request->input('revertNote'),
                'site_link' => "vnrseeds.co.in"             
            ];
            // Mail::to($EmpMailid)->send(new AppraisalRevert($details));


        $baseUrl = request()->getSchemeAndHttpHost();

        // Construct the link dynamically
        $notificationLink_employee= $baseUrl . "/pms";

        \DB::table('notification')->insert([
            'userid' => $request->employeeId,
            'notification_read' => 0, // Unread notification
            'title' => "Your KRA form data has been reverted by your reporting manager",
            'description' => "Your KRA form data has been reverted by your reporting manager",
            'notification_link' => $notificationLink_employee,
            'created_at' => now()
        ]);
        
        // You can add additional logic to handle success or failure if needed
            return response()->json(['message' => 'KRA records updated successfully.']);
        } else {
            return response()->json(['message' => 'No KRA records found for the given Employee and Year.']);
        }
    }
    
    public function revertreviewer(Request $request)
    {
        // Find the KRA record(s) for the given employee and year
        $kraRecords = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $request->employeeId)  // Ensure column name matches exactly
            ->where('YearId', $request->yearId)
            ->get();

        // Check if there are any KRA records found
        if ($kraRecords->isNotEmpty()) {
            foreach ($kraRecords as $kra) {
                DB::table('hrm_pms_kra')
                    ->where('EmployeeId', $kra->EmployeeID)
                    ->where('YearId', $kra->YearId)
                    ->update([
                        'AppStatus' => 'P',
                        'RevStatus' => 'R',
                        'RevRevertNote' => $request->input('revertNote') // Assuming revertNote is passed in the request
                    ]);
            }

            $employeeAppraisal = \DB::table('hrm_employee_pms')
            ->where('EmployeeID', $request->employeeId)
            ->first();
    
            $Appraiser_EmployeeID = $employeeAppraisal->Appraiser_EmployeeID ?? null; // Use null coalescing operator for safety
    
            $employeeemailid = EmployeeGeneral::where('EmployeeID', $request->employeeId)->first();       
            $employeedetails_name= Employee::where('EmployeeID', $request->employeeId)->first();
    
            $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
            $EmpCode = $employeedetails_name->EmpCode;
            $EmpMailid = $employeeemailid->EmailId_Vnr;
    
            $Appraiser_EmployeeID_email= EmployeeGeneral::where('EmployeeID', $Appraiser_EmployeeID)->first();       
            $Appraiser_EmployeeID_name= Employee::where('EmployeeID', $Appraiser_EmployeeID)->first();
    
            $Areviewername = ($Appraiser_EmployeeID_name->Fname ?? 'null').' ' . ($Appraiser_EmployeeID_name->Sname ?? 'null').' ' . ($Appraiser_EmployeeID_name->Lname ?? 'null');
            $Arevieweremail = $Appraiser_EmployeeID_email->EmailId_Vnr;
    
    
            $details = [
                'RepoName' => $Areviewername,
                'subject'=>'KRA Submission Status.',
                'EmpName'=> $Empname,
                'EmpCode'=>$EmpCode,
                'Reason'=>$request->input('revertNote'),
                'site_link' => "vnrseeds.co.in"             
            ];
            // Mail::to($Arevieweremail)->send(new ReviewerRevert($details));

    
            $baseUrl = request()->getSchemeAndHttpHost();

            // Construct the link dynamically
            $notificationLink_appraiser= $baseUrl . "/appraiser";
    
            \DB::table('notification')->insert([
                'userid' => $Appraiser_EmployeeID,
                'notification_read' => 0, // Unread notification
                'title' => "Your KRA form data has been reverted by your reporting manager",
                'description' => "our KRA form data of your team member {{$Empname}} ({{$EmpCode}})has been reverted by your reporting manager",
                'notification_link' => $notificationLink_appraiser,
                'created_at' => now()
            ]);
            // You can add additional logic to handle success or failure if needed
            return response()->json(['message' => 'KRA records updated successfully.']);
        } else {
            return response()->json(['message' => 'No KRA records found for the given Employee and Year.']);
        }
    }
    
    public function reverthod(Request $request)
    {
        // Find the KRA record(s) for the given employee and year
        $kraRecords = DB::table('hrm_pms_kra')
            ->where('EmployeeID', $request->employeeId)  // Ensure column name matches exactly
            ->where('YearId', $request->yearId)
            ->get();

        // Check if there are any KRA records found
        if ($kraRecords->isNotEmpty()) {
            foreach ($kraRecords as $kra) {
                DB::table('hrm_pms_kra')
                    ->where('EmployeeId', $kra->EmployeeID)
                    ->where('YearId', $kra->YearId)
                    ->update([
                        'RevStatus' => 'P',
                        'HODStatus' => 'R',
                        'HODRevertNote' => $request->input('revertNote') // Assuming revertNote is passed in the request
                    ]);
            }

            $employeeAppraisal = \DB::table('hrm_employee_pms')
            ->where('EmployeeID', $request->employeeId)
            ->first();
    
            $Reviewer_EmployeeID = $employeeAppraisal->Reviewer_EmployeeID ?? null; // Use null coalescing operator for safety
    
            $employeeemailid = EmployeeGeneral::where('EmployeeID', $request->employeeId)->first();       
            $employeedetails_name= Employee::where('EmployeeID', $request->employeeId)->first();
    
            $Empname = ($employeedetails_name->Fname ?? 'null').' ' . ($employeedetails_name->Sname ?? 'null').' ' . ($employeedetails_name->Lname ?? 'null');
            $EmpCode = $employeedetails_name->EmpCode;
            $EmpMailid = $employeeemailid->EmailId_Vnr;
    
            $Reviewer_EmployeeIDNAME = EmployeeGeneral::where('EmployeeID', $Reviewer_EmployeeID)->first();       
            $Reviewer_EmployeeID_name= Employee::where('EmployeeID', $Reviewer_EmployeeID)->first();
    
            $Areviewername = ($Reviewer_EmployeeID_name->Fname ?? 'null').' ' . ($Reviewer_EmployeeID_name->Sname ?? 'null').' ' . ($Reviewer_EmployeeID_name->Lname ?? 'null');
            $Arevieweremail = $Reviewer_EmployeeIDNAME->EmailId_Vnr;
    
    
            $details = [
                'ReviewerName' => $Areviewername,
                'subject'=>'KRA Submission Status.',
                'EmpName'=> $Empname,
                'EmpCode'=>$EmpCode,
                'Reason'=>$request->input('revertNote'),
                'site_link' => "vnrseeds.co.in"             
            ];
            // Mail::to($Arevieweremail)->send(new HODRevert($details));
            // You can add additional logic to handle success or failure if needed
            
            $baseUrl = request()->getSchemeAndHttpHost();

            // Construct the link dynamically
            $notificationLink_reviewer= $baseUrl . "/reviewer";
    
            \DB::table('notification')->insert([
                'userid' => $Reviewer_EmployeeID,
                'notification_read' => 0, // Unread notification
                'title' => "Your KRA form data has been reverted by your reporting manager",
                'description' => "our KRA form data of your team member {{$Empname}} ({{$EmpCode}})has been reverted by your reporting manager",
                'notification_link' => $notificationLink_reviewer,
                'created_at' => now()
            ]);
            return response()->json(['message' => 'KRA records updated successfully.']);
        } else {
            return response()->json(['message' => 'No KRA records found for the given Employee and Year.']);
        }
    }
    public function saveRow(Request $request)
    {
            if($request->saveType == 'save'){
                $save_status =  1;
                $save_date =  now();

                $submit_status =  0;
                $submit_date =  now();
            }
            if($request->saveType == 'submit'){
                $save_status =  0;
                $save_date =  now();

                $submit_status =  1;
                $submit_date =  now();
            }
            
                $kra = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('TgtDefId', $request->tgtDefId)
                        ->first();

                if ($kra) {
                    DB::table('hrm_pms_kra_tgtdefin')
                    ->where('TgtDefId', $request->tgtDefId)
                    ->update([
                        'Ach' => $request->selfRating,
                        'Cmnt' => $request->selfRemark,
                        'Scor' => $request->score,
                        'LogScr' => $request->logscore,
                        'save_status' => $save_status,
                        'save_date' => $save_date,
                        'submit_status' => $submit_status,
                        'submit_date' =>$submit_date,

                    ]);
                    return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
                } else {
                    return response()->json(['success' => false, 'message' => 'KRA not found.'], 404);
                }
        
    }
    public function saveRowPms(Request $request)
        {
            if($request->saveType == 'save'){
                $save_status =  1;
                $save_date =  now();

                $submit_status =  0;
                $submit_date =  now();
            }
            if($request->saveType == 'submit'){
                $save_status =  0;
                $save_date =  now();

                $submit_status =  1;
                $submit_date =  now();
            }
            
                $kra = DB::table('hrm_pms_kra_tgtdefin')
                        ->where('TgtDefId', $request->tgtDefId)
                        ->first();

                if ($kra) {
                    DB::table('hrm_pms_kra_tgtdefin')
                    ->where('TgtDefId', $request->tgtDefId)
                    ->update([
                        'AppAch' => $request->selfRating,
                        'AppCmnt' => $request->selfRemark,
                        'AppScor' => $request->score,
                        'AppLogScr' => $request->logscore,
                        'app_savestatus' => $save_status,
                        'app_savedate' => $save_date,
                        'app_submitstatus' => $submit_status,
                        'app_submitdate' =>$submit_date,

                    ]);
                    return response()->json(['success' => true, 'message' => 'Reporting Data saved successfully!']);
                } else {
                    return response()->json(['success' => false, 'message' => 'KRA not found.'], 404);
                }
        
        }
        public function saveRowFormb(Request $request)
        {

            if($request->saveType == 'save'){
                $save_status =  1;
                $save_date =  now();

                $submit_status =  0;
                $submit_date =  now();
            }
            if($request->saveType == 'submit'){
                $save_status =  0;
                $save_date =  now();

                $submit_status =  1;
                $submit_date =  now();
            }
            
                $kra = DB::table('hrm_pms_formb_tgtdefin')
                        ->where('TgtFbDefId', $request->tgtDefId)
                        ->first();

                if ($kra) {
                    DB::table('hrm_pms_formb_tgtdefin')
                    ->where('TgtFbDefId', $request->tgtDefId)
                    ->update([
                        'Ach' => $request->selfRating,
                        'Cmnt' => $request->selfRemark,
                        'Scor' => $request->score,
                        'LogScr' => $request->logscore,
                        'save_status' => $save_status,
                        'save_date' => $save_date,
                        'submit_status' => $submit_status,
                        'submit_date' =>$submit_date,

                    ]);
                    return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
                } else {
                    return response()->json(['success' => false, 'message' => 'KRA not found.'], 404);
                }
        
        }
        public function saveRowFormbapp(Request $request)
        {

            if($request->saveType == 'save'){
                $save_status =  1;
                $save_date =  now();

                $submit_status =  0;
                $submit_date =  now();
            }
            if($request->saveType == 'submit'){
                $save_status =  0;
                $save_date =  now();

                $submit_status =  1;
                $submit_date =  now();
            }
            
                $kra = DB::table('hrm_pms_formb_tgtdefin')
                        ->where('TgtFbDefId', $request->tgtDefId)
                        ->first();

                if ($kra) {
                    DB::table('hrm_pms_formb_tgtdefin')
                    ->where('TgtFbDefId', $request->tgtDefId)
                    ->update([
                        'AppAch' => $request->selfRating,
                        'AppCmnt' => $request->selfRemark,
                        'AppScor' => $request->score,
                        'AppLogScr' => $request->logscore,
                        'appsave_status' => $save_status,
                        'appsave_date' => $save_date,
                        'appsubmit_status' => $submit_status,
                        'appsubmit_date' =>$submit_date,

                    ]);
                    return response()->json(['success' => true, 'message' => 'Data saved successfully!']);
                } else {
                    return response()->json(['success' => false, 'message' => 'KRA not found.'], 404);
                }
        
        }

        public function saveAchievements(Request $request)
        {
         
            // Remove existing records for the PMS ID
            DB::table('hrm_employee_pms_achivement')->where('EmpPmsId', $request->pms_id)->delete();
            $validated = $request->validate([
                'achievements' => ['required', 'array', function ($attribute, $value, $fail) {
                    // Remove empty values
                    $nonEmptyAchievements = array_filter($value, function ($achievement) {
                        return !empty(trim($achievement));
                    });
            
                    // If no valid achievements exist, throw an error
                    if (count($nonEmptyAchievements) < 1) {
                        $fail('At least one achievement is required.');
                    }
                }],
                'achievements.*' => 'nullable|string|max:1000', // All achievements can be empty
            ], [
                'achievements.*.max' => 'Each achievement must not exceed 1000 characters.',
            ]);
            
            
            
            // Insert new records
            foreach ($request->achievements as $achievement) {
                if (!empty($achievement)) {
                    DB::table('hrm_employee_pms_achivement')->insert([
                        'EmpPmsId' => $request->pms_id,
                        'Achivement' => $achievement,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            DB::table('hrm_employee_pms')
                ->where('EmpPmsId', $request->pms_id)
                ->update(['Emp_AchivementSave' => 'Y']);

            return response()->json(['success' => true, 'message' => 'Achievements saved successfully!']);
        }
        public function deleteAchievement($id)
        {
            $achievement = DB::table('hrm_employee_pms_achivement')->where('AchivementId', $id)->first();
        
            if ($achievement) {
                DB::table('hrm_employee_pms_achivement')->where('AchivementId', $id)->delete();
                return response()->json(['success' => true, 'message' => 'Achievement deleted successfully.']);
            }
        
            return response()->json(['success' => false, 'message' => 'Achievement not found.']);
        }
        public function saveFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'pmsId' => 'required|integer',
            'feedback' => 'required|array',
            'feedback.*.question' => 'required|string',
            'feedback.*.answer' => 'required|string|min:1|max:2000', // Fixed duplicate rules
        ], [
            'feedback.*.answer.required' => 'Each feedback answer is required. Please provide an answer.',
            'feedback.*.answer.max' => 'Each feedback answer must not exceed 2000 characters.',
        ]);

        $pmsId = $validatedData['pmsId'];
        $feedbackItems = $validatedData['feedback'];

        // Filter out empty answers (trimmed to avoid spaces-only answers)
        $filteredFeedback = array_filter($feedbackItems, function ($item) {
            return isset($item['answer']) && trim($item['answer']) !== '';
        });

        if (empty($filteredFeedback)) {
            return response()->json(['success' => false, 'message' => 'No valid feedback to save.']);
        }

        // Retrieve existing records for this EmpPmsId
        $existingRecords = DB::table('hrm_employee_pms_workenvironment')
            ->where('EmpPmsId', $pmsId)
            ->get()
            ->keyBy('WorkEnvironment');

        foreach ($filteredFeedback as $item) {
            $workEnvironment = $item['question'];

            if (isset($existingRecords[$workEnvironment])) {
                // Update existing record
                DB::table('hrm_employee_pms_workenvironment')
                    ->where('EmpPmsId', $pmsId)
                    ->where('WorkEnvironment', $workEnvironment)
                    ->update([
                        'Answer' => $item['answer'],
                    ]);
            } else {
                // Insert new record
                DB::table('hrm_employee_pms_workenvironment')->insert([
                    'EmpPmsId' => $pmsId,
                    'WorkEnvironment' => $workEnvironment,
                    'Answer' => $item['answer'],
                    'FunctionalTraning' => '',
                    'SoftSkillTraning' => '',
                ]);
            }
        }

        // Update feedback status
        DB::table('hrm_employee_pms')
            ->where('EmpPmsId', $pmsId)
            ->update(['Emp_FeedBackSave' => 'Y']);

        return response()->json(['success' => true, 'message' => 'Feedback form saved successfully']);
    }
   

    public function saveKraForm(Request $request)
    {

        $data = $request->json()->all();  
        // Process KRA data
        foreach ($data['kra'] as $kra) {
            // Attempt to find the existing KRA record by its ID
            $existingKra = DB::table('hrm_employee_pms_kraforma')->where('KRAId', $kra['id'])->first();
        //     if($kra['remark'] == null){
        //         return response()->json(['success' => false, 'message' => 'Remark is mandatory'],400);
    
        //    }
            if (empty($kra['rating']) || $kra['rating'] <= 0) {
                return response()->json(['success' => false, 'message' => 'Fill valid rating'], 400);
            }
            if ($existingKra) {
                // Update the existing KRA record
                DB::table('hrm_employee_pms_kraforma')
                    ->where('KRAId', $kra['id'])
                    ->update([
                        'SelfRating' => $kra['rating'],
                        'SelfKRALogic' => $kra['KralogScore'],
                        'Weightage' => $kra['weight'],
                        'Logic' => $kra['logic'],
                        'Target' => $kra['target'],
                        'SelfKRAScore' => $kra['score'],
                        'AchivementRemark' => $kra['remark'],
                    ]);
                   
            } 
            else {
                return response()->json(['success' => false, 'message' => 'No KRA data found'],400);

            }
        }
    
        // Process SubKRA data
        foreach ($data['subkra'] as $subkra) {
            // Attempt to find the existing SubKRA record by its ID
            $existingSubKra = DB::table('hrm_pms_krasub')->where('KRASubId', $subkra['id'])->first();
            if($subkra['remark'] == null){
                return response()->json(['success' => false, 'message' => 'Remark is mandatory'],400);
    
           }
           if (empty($subkra['rating']) || $subkra['rating'] <= 0) {
            return response()->json(['success' => false, 'message' => 'Fill valid rating'], 400);
        }
            if ($existingSubKra) {
                // Update the existing SubKRA record
                DB::table('hrm_pms_krasub')
                    ->where('KRASubId', $subkra['id'])
                    ->update([
                        'SelfRating' => $subkra['rating'],
                        'SelfKRALogic' => $subkra['subkralog'],
                        'Weightage' => $subkra['weight'],
                        'Logic' => $subkra['logic'],
                        'Target' => $subkra['target'],
                        'SelfKRAScore' => $subkra['score'],
                        'AchivementRemark' => $subkra['remark'],
                    ]);
            } else {
                // Insert a new SubKRA record
                return response()->json(['success' => false, 'message' => 'No SubKRA data found'],400);

            }
        }
             // Initialize weights
             $KraWeight = 0;
     
        $RD = DB::table('hrm_employee_general')
            ->select('DepartmentId', 'GradeId', 'DesigId')
            ->where('EmployeeID', $request->employeeid)
            ->first();

        $sqlPer = DB::table('hrm_pms_percentage')
            ->where('CompanyId', $request->CompanyId)
            ->where('YearId', $request->year_id)
            ->get();
        foreach ($sqlPer as $resPer) {
                if ($RD->GradeId >= $resPer->GradeFrom && $RD->GradeId <= $resPer->GradeTo) {
                    $KraWeight = $resPer->PerOfFormAKra_WeighScore;
                    break;
                }
            }  
        // Update the grand total score in the relevant table
        DB::table('hrm_employee_pms')
            ->where('EmpPmsId', $data['pms_id'])
            ->update(['EmpFormAScore' => $data['grandTotal'],'Emp_KRASave' => 'Y','Emp_PmsStatus' => '1',
                'FormAKraAllow_PerOfWeightage' => $KraWeight]);

        return response()->json(['message' => 'Data processed successfully!'], 200);
    }
    public function saveKraFormb(Request $request)
    {
        // Decode JSON data
        $data = $request->json()->all(); 
        // Process KRA data
        foreach ($data['kra'] as $kra) {
            // Attempt to find the existing KRA record by its ID
            $existingKra = DB::table('hrm_employee_pms_behavioralformb')->where('BehavioralFormBId', $kra['id'])->first();
        //     if($kra['remark'] == null){
        //         return response()->json(['success' => false, 'message' => 'Remark is mandatory'],400);
    
        //    }
            if (empty($kra['rating']) || $kra['rating'] <= 0) {
                return response()->json(['success' => false, 'message' => 'Fill valid rating'], 400);
            }
            if ($existingKra) {
                // Update the existing KRA record
                DB::table('hrm_employee_pms_behavioralformb')
                    ->where('BehavioralFormBId', $kra['id'])
                    ->update([
                        'SelfRating' => $kra['rating'],
                        'SelfFormBLogic' => $kra['logicscore'],
                        'SelfFormBScore' => $kra['score'],
                        'Comments_Example' => $kra['remark'],
                    ]);
                   
            } 
            else {
                return response()->json(['success' => false, 'message' => 'No KRA data found'],400);

            }
        }
    
        // Process SubKRA data
        foreach ($data['subkra'] as $subkra) {
            // Attempt to find the existing SubKRA record by its ID
            $existingSubKra = DB::table('hrm_employee_pms_behavioralformb_sub')->where('FormBSubId', $subkra['id'])->first();
            if($subkra['remark'] == null){
                return response()->json(['success' => false, 'message' => 'Remark is mandatory'],400);
    
           }
           if (empty($subkra['rating']) || $subkra['rating'] <= 0) {
            return response()->json(['success' => false, 'message' => 'Fill valid rating'], 400);
        }
            if ($existingSubKra) {
                // Update the existing SubKRA record
                DB::table('hrm_employee_pms_behavioralformb_sub')
                    ->where('FormBSubId', $subkra['id'])
                    ->where('EmpId', $request->employeeid)
                    ->update([
                        'SelfRating' => $subkra['rating'],
                        'SelfFormBLogic' => $subkra['logicscore'],
                        'SelfFormBScore' => $subkra['score'],
                        'AchivementRemark' => $subkra['remark'],
                    ]);
            } else {
                // Insert a new SubKRA record
                return response()->json(['success' => false, 'message' => 'No SubKRA data found'],400);

            }
        }
        $FormBWeight = 0;

            $RD = DB::table('hrm_employee_general')
                ->select('DepartmentId', 'GradeId', 'DesigId')
                ->where('EmployeeID', $request->employeeid)
                ->first();

            $sqlPer = DB::table('hrm_pms_percentage')
                ->where('CompanyId', $request->CompanyId)
                ->where('YearId', $request->year_id)
                ->get();
            foreach ($sqlPer as $resPer) {
                    if ($RD->GradeId >= $resPer->GradeFrom && $RD->GradeId <= $resPer->GradeTo) {
                        $FormBWeight = $resPer->PerOfFormBBehavi_WeighScore;
                        break;
                    }
                }  
        
    
        // Update the grand total score in the relevant table
        DB::table('hrm_employee_pms')
            ->where('EmpPmsId', $data['pms_id'])
            ->update(['EmpFormBScore' => $data['grandTotal'],'Emp_SkillSave' => 'Y','Emp_PmsStatus'=>'1','FormBBehaviAllow_PerOfWeightage'=>$FormBWeight]);

        return response()->json(['message' => 'Data processed successfully!'], 200);
    }

    public function store(Request $request)
    {
       $employee_code= Auth::user()->EmpCode;
       $employee_ID= Auth::user()->EmployeeID;

       $employeeName = Auth::user()->Fname . '_' . Auth::user()->Sname . '_' . Auth::user()->Lname;
        $file = $request->file('uploadfile');
        $fileSize = $file->getSize();

        // Define the maximum file size in bytes (2MB)
        $maxSize = 2 * 1024 * 1024; // 2 MB in bytes

        // Check if the file size exceeds the maximum limit
        if ($fileSize > $maxSize) {
            return response()->json(['success' => false, 'message' => 'The file size must not exceed 2 MB.'],400);
        }

        $extension = $file->getClientOriginalExtension();
        $date = date('Y_m_d'); // Format: YYYYMMDD
        $filename = "{$request->uploadfilename}_{$employee_code}_{$employeeName}_{$date}.{$extension}";
        $path = base_path('Employee/AppUploadFile/');

        // Ensure directory exists
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Move file
        $dd = $file->move($path, $filename);
        // Store in database using query builder
        DB::table('hrm_employee_pms_uploadfile')->insert([
            'EmpPmsId' =>$request->pmsid,
            'Ext' => $extension,
            'FileName'=>$filename,
            'EmployeeID'=>$employee_ID,
            'YearId'=>$request->pmsyrid
        ]);

        return response()->json(['success' => true, 'filename' => $filename]);
    }

    public function list(Request $request)
    {
        // Get the passed parameters
        $pmsyrid = $request->input('pmsyrid');
        $pmsid = $request->input('pmsid');  
        $employee_ID= Auth::user()->EmployeeID;


        $files = DB::table('hrm_employee_pms_uploadfile')
                        ->where('EmpPmsId',$pmsid)
                        ->where('YearId',$pmsyrid)
                        ->where('EmployeeID',$employee_ID)
                        ->get();

        return response()->json(['FileName' => $files]);
    }

    public function delete($id)
    {
        $file = DB::table('hrm_employee_pms_uploadfile')->where('FileId', $id)->first();
        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $filePath = base_path("Employee/AppUploadFile/{$file->FileName}");

        // Delete file if exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        DB::table('hrm_employee_pms_uploadfile')->where('FileId', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Deleted Successfully']);

    }

    public function download($filename)
    {
        $path = storage_path("Employee/AppUploadFile/{$filename}");

        if (file_exists($path)) {
            return response()->download($path);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    public function finalSubmit(Request $request)
{
    $employeeId = $request->employeeId;
    $pmsId = $request->pmsId;
    $CompanyId = $request->CompanyId;
    $year_id = $request->year_id;

    // Fetch necessary data
    $pmsData = DB::table('hrm_employee_pms')
        ->select('EmpFormAScore', 'EmpFormBScore', 'FormAKraAllow_PerOfWeightage', 'FormBBehaviAllow_PerOfWeightage')
        ->where('EmpPmsId', $pmsId)
        ->where('EmployeeID', $employeeId)
        ->first();

    if (!$pmsData) {
        return response()->json(['error' => 'PMS data not found.'], 404);
    }

    // Calculate weighted scores
    $Aweight = $pmsData->FormAKraAllow_PerOfWeightage;
    $Bweight = $pmsData->FormBBehaviAllow_PerOfWeightage;
    $EmpFinallyFormAScore = ($pmsData->EmpFormAScore * $Aweight) / 100;
    $EmpFinallyFormBScore = ($pmsData->EmpFormBScore * $Bweight) / 100;
    $Emp_TotalFinalScore = $EmpFinallyFormAScore + $EmpFinallyFormBScore;


    // Fetch current compensation details
    $compensation = DB::table('hrm_employee_ctc')
        ->select('INCENTIVE_Value', 'Tot_GrossMonth', 'Tot_CTC')
        ->where('EmployeeID', $employeeId)
        ->where('Status', 'A')
        ->first();

    if (!$compensation) {
        return response()->json(['error' => 'Compensation data not found.'], 404);
    }

    // Determine final rating
    if ($Emp_TotalFinalScore > 150) {
        $Emp_TotalFinalRating = 5;
    } else {
        $rating = DB::table('hrm_pms_rating')
            ->select('Rating')
            ->where('RatingStatus', 'A')
            ->where('YearId', $year_id)
            ->where('CompanyId', $CompanyId)
            ->where('ScoreFrom', '<=', $Emp_TotalFinalScore)
            ->where('ScoreTo', '>=', $Emp_TotalFinalScore)
            ->first();

        $Emp_TotalFinalRating = $rating ? $rating->Rating : null;
    }

    // Update PMS record
    DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $pmsId)
        ->update([
            'Emp_PmsStatus' => 2,
            'Emp_SubmitedDate' => now(),
            'EmpFinallyFormA_Score' => $EmpFinallyFormAScore,
            'EmpFinallyFormB_Score' => $EmpFinallyFormBScore,
            'Emp_TotalFinalScore' => $Emp_TotalFinalScore,
            'Emp_TotalFinalRating' => $Emp_TotalFinalRating,
            'Dummy_EmpRating' => $Emp_TotalFinalRating,
        ]);

    return response()->json(['success' => 'Submission finalized successfully.']);
}
public function edit($encryptedEmpPmsId)
{
    // Decrypt the passed ID
    $EmpPmsId = decrypt($encryptedEmpPmsId);
    $CompanyId = Auth::user()->CompanyId;
// Fetch key data for different persons
$keys = [
    'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
    'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
    'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
    'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
];


// Store extracted values in an array
$data = [
    'emp' => [
        'Msg' => $keys['emp']->EmpMsg ?? '',
        'Details' => $keys['emp']->PersonalDetails ?? '',
        'Schedule' => $keys['emp']->Schedule ?? '',
        'Appform' => $keys['emp']->AppraisalForm ?? '',
        'Midform' => $keys['emp']->MidPmsForm ?? '',
        'Kraform' => $keys['emp']->KRAForm ?? '',
        'Helpfaq' => $keys['emp']->Help_Faq ?? '',
        'Viewprint' => $keys['emp']->View_Print ?? '',
    ],
    'app' => [
        'Home' => $keys['app']->Home ?? '',
        'Team' => $keys['app']->MyTeam ?? '',
        'Status' => $keys['app']->TeamStatus ?? '',
        'EKform' => $keys['app']->FKraForm ?? '',
        'EPform' => $keys['app']->FPmsForm ?? '',
        'EHform' => $keys['app']->FHistoryForm ?? '',
        'Rating' => $keys['app']->RatingGraph ?? '',
    ],
    'rev' => [
        'Home' => $keys['rev']->Home ?? '',
        'Team' => $keys['rev']->MyTeam ?? '',
        'Status' => $keys['rev']->TeamStatus ?? '',
        'EKform' => $keys['rev']->FKraForm ?? '',
        'EPform' => $keys['rev']->FPmsForm ?? '',
        'EHform' => $keys['rev']->FHistoryForm ?? '',
        'Rating' => $keys['rev']->RatingGraph ?? '',
    ],
    'hod' => [
        'Home' => $keys['hod']->Home ?? '',
        'Team' => $keys['hod']->MyTeam ?? '',
        'Status' => $keys['hod']->TeamStatus ?? '',
        'EKform' => $keys['hod']->FKraForm ?? '',
        'EPform' => $keys['hod']->FPmsForm ?? '',
        'EHform' => $keys['hod']->FHistoryForm ?? '',
        'Score' => $keys['hod']->Score ?? '',
        'Prom' => $keys['hod']->Promotion ?? '',
        'Inc' => $keys['hod']->Increment ?? '',
        'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
        'Increport' => $keys['hod']->IncrementReport ?? '',
        'Rating' => $keys['hod']->RatingGraph ?? '',
    ],
];
    $employeedetailsforpms = DB::table('hrm_employee_pms')
    ->where('EmpPmsId', $EmpPmsId)
    ->select('EmployeeID')
    ->first();

    $employeealldetailsforpms = DB::table('hrm_employee_pms')
    ->where('EmpPmsId', $EmpPmsId)
    ->first();

    $employeedetailspms = DB::table('hrm_employee as e')
    ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
    ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
    ->where('e.EmpStatus', 'A')
    ->where('e.EmployeeID', $employeedetailsforpms->EmployeeID)
    ->select([
        'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
        'd.department_name'
    ])
    ->first();
    $employeeid = $employeedetailsforpms->EmployeeID;

    $achievement = DB::table('hrm_employee_pms_achivement')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->orderBy('created_at','ASC')
                    ->get();

    $feedback = DB::table('hrm_employee_pms_workenvironment')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->get();

    $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->get();
        
    // Fetch related data from kra and submr tables
    foreach ($employeePmsKraforma as $kraforma) {
        $kraforma->kra = DB::table('hrm_pms_kra')
                        ->where('KRAId', $kraforma->KRAId)
                        ->get();
        
        
        $kraforma->submr = DB::table('hrm_pms_krasub')
                        ->where('KRAId', $kraforma->KRAId)
                        ->get();
    }
    $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
    
    $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
    
    $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
    ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
    ->where('fbf.EmpId', $employeedetailsforpms->EmployeeID)
    ->where('fbf.YearId', $PmsYId)
    ->orderBy('fbf.BehavioralFormBId', 'ASC')
    ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target','fbf.AppraiserRemark')
    ->get();

    $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
    ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
    ->where('s.EmpId', $employeedetailsforpms->EmployeeID)
    ->where('s.YearId', $PmsYId)
    ->select('s.*', 'bb.*')
    ->get();


    // Example query to fetch data from the `hrm_employee_general` table
    $employeeDetails = DB::table('hrm_employee_general')
        ->where('EmployeeID', $employeedetailsforpms->EmployeeID)
        ->first();
// Fetch the current grade value
$gradeValue = DB::table('core_grades')
    ->where('id', $employeeDetails->GradeId)
    ->select('id', 'grade_name')  // Select both the id and grade_name
    ->first(); // Use first() to get the result as a single object

// Logic to get the next grade based on the current grade
if ($gradeValue->grade_name!= 'MG') {
    // Get the next grade ID (incrementing the current GradeId by 1)
    $nextGradeId = $employeeDetails->GradeId + 1;
   
    $nextGrade = DB::table('core_grades')
                    ->where('id',$nextGradeId)
                    ->select('id', 'grade_name')  // Select both the id and grade_name
                    ->first(); // Use first() to get the result as a single object

} else {
    // If the grade is 'MG', the next grade stays the same
    $nextGrade = $gradeValue;
}

// Fetch available designations based on the next grade
$availableDesignations = DB::table('hrm_deptgradedesig')
    ->join('core_designation', 'hrm_deptgradedesig.DesigId', '=', 'core_designation.id')
    ->where('hrm_deptgradedesig.DepartmentId', $employeeDetails->DepartmentId)
     ->where(function($query) use ($nextGradeId) {
        $query->where('hrm_deptgradedesig.GradeId', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_2', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_3', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_4', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_5', $nextGradeId);
    })
    ->where('core_designation.is_active', '1')
    ->orderBy('core_designation.designation_name')
    ->get();
    // Fetch designation
    $designation = DB::table('core_designation')
    ->where('id', $employeeDetails->DesigId)
    ->value('designation_name');

    $department = DB::table('core_departments')
    ->where('id', $employeeDetails->DepartmentId)
    ->value('department_name');
    $category = $department ?: 'Other';

    $trainings = DB::table('hrm_pms_training')
    ->where('type','Functional Skills')
    ->whereRaw('LOWER(Category) = ?', [strtolower($category)]) // Case-insensitive comparison
    ->get();

    // If no data found for the requested category, fallback to 'Other'
    if ($trainings->isEmpty()) {
        $trainings = DB::table('hrm_pms_training')
            ->whereRaw('LOWER(Category) = ?', ['other']) 
            ->where('type', 'Functional Skills')
            ->get();
    }

    $softSkills =  DB::table('hrm_pms_training')->where('type', 'Soft Skill')
                            ->get()
                            ->groupBy('Category');
    $pms_id= DB::table('hrm_employee_pms')
                            ->where('hrm_employee_pms.EmployeeID', $employeedetailsforpms->EmployeeID)
                            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
                            ->where('hrm_employee_pms.CompanyId',$CompanyId)
                            ->first();
    $softSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_Oth)
                            ->get();
    $functionalSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_Oth)
                            ->get();
    return view('employee.appraisalpms',compact('employeedetailspms','achievement','feedback','gradeValue',
    'employeeDetails','nextGrade','availableDesignations','designation','softSkills','trainings','pms_id','softSkillsAppraisal','functionalSkillsAppraisal',
    'employeePmsKraforma','year_pms','CompanyId','behavioralForms','behavioralFormssub','PmsYId','employeeid','employeealldetailsforpms','data'));
}

public function editreviewer($encryptedEmpPmsId)
{
    // Decrypt the passed ID
    $EmpPmsId = decrypt($encryptedEmpPmsId);
    $CompanyId = Auth::user()->CompanyId;
// Fetch key data for different persons
$keys = [
    'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
    'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
    'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
    'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
];


// Store extracted values in an array
$data = [
    'emp' => [
        'Msg' => $keys['emp']->EmpMsg ?? '',
        'Details' => $keys['emp']->PersonalDetails ?? '',
        'Schedule' => $keys['emp']->Schedule ?? '',
        'Appform' => $keys['emp']->AppraisalForm ?? '',
        'Midform' => $keys['emp']->MidPmsForm ?? '',
        'Kraform' => $keys['emp']->KRAForm ?? '',
        'Helpfaq' => $keys['emp']->Help_Faq ?? '',
        'Viewprint' => $keys['emp']->View_Print ?? '',
    ],
    'app' => [
        'Home' => $keys['app']->Home ?? '',
        'Team' => $keys['app']->MyTeam ?? '',
        'Status' => $keys['app']->TeamStatus ?? '',
        'EKform' => $keys['app']->FKraForm ?? '',
        'EPform' => $keys['app']->FPmsForm ?? '',
        'EHform' => $keys['app']->FHistoryForm ?? '',
        'Rating' => $keys['app']->RatingGraph ?? '',
    ],
    'rev' => [
        'Home' => $keys['rev']->Home ?? '',
        'Team' => $keys['rev']->MyTeam ?? '',
        'Status' => $keys['rev']->TeamStatus ?? '',
        'EKform' => $keys['rev']->FKraForm ?? '',
        'EPform' => $keys['rev']->FPmsForm ?? '',
        'EHform' => $keys['rev']->FHistoryForm ?? '',
        'Rating' => $keys['rev']->RatingGraph ?? '',
    ],
    'hod' => [
        'Home' => $keys['hod']->Home ?? '',
        'Team' => $keys['hod']->MyTeam ?? '',
        'Status' => $keys['hod']->TeamStatus ?? '',
        'EKform' => $keys['hod']->FKraForm ?? '',
        'EPform' => $keys['hod']->FPmsForm ?? '',
        'EHform' => $keys['hod']->FHistoryForm ?? '',
        'Score' => $keys['hod']->Score ?? '',
        'Prom' => $keys['hod']->Promotion ?? '',
        'Inc' => $keys['hod']->Increment ?? '',
        'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
        'Increport' => $keys['hod']->IncrementReport ?? '',
        'Rating' => $keys['hod']->RatingGraph ?? '',
    ],
];
    $employeedetailsforpms = DB::table('hrm_employee_pms')
    ->where('EmpPmsId', $EmpPmsId)
    ->select('EmployeeID')
    ->first();

    $employeealldetailsforpms = DB::table('hrm_employee_pms')
    ->where('EmpPmsId', $EmpPmsId)
    ->first();

    $employeedetailspms = DB::table('hrm_employee as e')
    ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
    ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
    ->where('e.EmpStatus', 'A')
    ->where('e.EmployeeID', $employeedetailsforpms->EmployeeID)
    ->select([
        'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
        'd.department_name'
    ])
    ->first();
    $employeeid = $employeedetailsforpms->EmployeeID;

    $achievement = DB::table('hrm_employee_pms_achivement')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->orderBy('created_at','ASC')
                    ->get();

    $feedback = DB::table('hrm_employee_pms_workenvironment')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->get();

    $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
                    ->where('EmpPmsId', $EmpPmsId)
                    ->get();
        
    // Fetch related data from kra and submr tables
    foreach ($employeePmsKraforma as $kraforma) {
        $kraforma->kra = DB::table('hrm_pms_kra')
                        ->where('KRAId', $kraforma->KRAId)
                        ->get();
        
        
        $kraforma->submr = DB::table('hrm_pms_krasub')
                        ->where('KRAId', $kraforma->KRAId)
                        ->get();
    }
    $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
    
    $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
    
    $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
    ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
    ->where('fbf.EmpId', $employeedetailsforpms->EmployeeID)
    ->where('fbf.YearId', $PmsYId)
    ->orderBy('fbf.BehavioralFormBId', 'ASC')
    ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target')
    ->get();

    $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
    ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
    ->where('s.EmpId', $employeedetailsforpms->EmployeeID)
    ->where('s.YearId', $PmsYId)
    ->select('s.*', 'bb.*')
    ->get();


    // Example query to fetch data from the `hrm_employee_general` table
    $employeeDetails = DB::table('hrm_employee_general')
        ->where('EmployeeID', $employeedetailsforpms->EmployeeID)
        ->first();
// Fetch the current grade value
$gradeValue = DB::table('core_grades')
    ->where('id', $employeeDetails->GradeId)
    ->select('id', 'grade_name')  // Select both the id and grade_name
    ->first(); // Use first() to get the result as a single object

// Logic to get the next grade based on the current grade
if ($gradeValue->grade_name!= 'MG') {
    // Get the next grade ID (incrementing the current GradeId by 1)
    $nextGradeId = $employeeDetails->GradeId + 1;
   
    $nextGrade = DB::table('core_grades')
                    ->where('id',$nextGradeId)
                    ->select('id', 'grade_name')  // Select both the id and grade_name
                    ->first(); // Use first() to get the result as a single object

} else {
    // If the grade is 'MG', the next grade stays the same
    $nextGrade = $gradeValue;
}

// Fetch available designations based on the next grade
$availableDesignations = DB::table('hrm_deptgradedesig')
    ->join('core_designation', 'hrm_deptgradedesig.DesigId', '=', 'core_designation.id')
    ->where('hrm_deptgradedesig.DepartmentId', $employeeDetails->DepartmentId)
     ->where(function($query) use ($nextGradeId) {
        $query->where('hrm_deptgradedesig.GradeId', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_2', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_3', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_4', $nextGradeId)
              ->orWhere('hrm_deptgradedesig.GradeId_5', $nextGradeId);
    })
    ->where('core_designation.is_active', '1')
    ->orderBy('core_designation.designation_name')
    ->get();
    // Fetch designation
    $designation = DB::table('core_designation')
    ->where('id', $employeeDetails->DesigId)
    ->value('designation_name');

    $designationappraiser = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpDesignation)
    ->value('designation_name');   

    $gradeappraiser = DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpGrade)
    ->value('grade_name');

    $department = DB::table('core_departments')
    ->where('id', $employeeDetails->DepartmentId)
    ->value('department_name');
    $category = $department ?: 'Other';

    $trainings = DB::table('hrm_pms_training')
    ->where('type','Functional Skills')
    ->whereRaw('LOWER(Category) = ?', [strtolower($category)]) // Case-insensitive comparison
    ->get();

    // If no data found for the requested category, fallback to 'Other'
    if ($trainings->isEmpty()) {
        $trainings = DB::table('hrm_pms_training')
            ->whereRaw('LOWER(Category) = ?', ['other']) 
            ->where('type', 'Functional Skills')
            ->get();
    }

    $softSkills =  DB::table('hrm_pms_training')->where('type', 'Soft Skill')
                            ->get()
                            ->groupBy('Category');
    $pms_id= DB::table('hrm_employee_pms')
                            ->where('hrm_employee_pms.EmployeeID', $employeedetailsforpms->EmployeeID)
                            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
                            ->where('hrm_employee_pms.CompanyId',$CompanyId)
                            ->first();
                            
    $softSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_Oth)
                            ->get();
    $functionalSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_Oth)
                            ->get();
    $softSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_Oth)
                            ->get();
    $functionalSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_Oth)
                            ->get();
    return view('employee.reviewerpms',compact('employeedetailspms','achievement','feedback','gradeValue',
    'designationappraiser','gradeappraiser','softSkillsAppraisal','functionalSkillsAppraisal',
    'employeeDetails','nextGrade','availableDesignations','designation','softSkills','trainings','pms_id','functionalSkillsReviewer','softSkillsReviewer',
    'employeePmsKraforma','year_pms','CompanyId','behavioralForms','behavioralFormssub','PmsYId','employeeid','employeealldetailsforpms','data'));
}

public function viewhod($encryptedEmpPmsId)
{
    // Decrypt the passed ID
    $EmpPmsId = decrypt($encryptedEmpPmsId);
    $CompanyId = Auth::user()->CompanyId;
    // Fetch key data for different persons
    $keys = [
        'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
        'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
        'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
        'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
    ];


    // Store extracted values in an array
    $data = [
        'emp' => [
            'Msg' => $keys['emp']->EmpMsg ?? '',
            'Details' => $keys['emp']->PersonalDetails ?? '',
            'Schedule' => $keys['emp']->Schedule ?? '',
            'Appform' => $keys['emp']->AppraisalForm ?? '',
            'Midform' => $keys['emp']->MidPmsForm ?? '',
            'Kraform' => $keys['emp']->KRAForm ?? '',
            'Helpfaq' => $keys['emp']->Help_Faq ?? '',
            'Viewprint' => $keys['emp']->View_Print ?? '',
        ],
        'app' => [
            'Home' => $keys['app']->Home ?? '',
            'Team' => $keys['app']->MyTeam ?? '',
            'Status' => $keys['app']->TeamStatus ?? '',
            'EKform' => $keys['app']->FKraForm ?? '',
            'EPform' => $keys['app']->FPmsForm ?? '',
            'EHform' => $keys['app']->FHistoryForm ?? '',
            'Rating' => $keys['app']->RatingGraph ?? '',
        ],
        'rev' => [
            'Home' => $keys['rev']->Home ?? '',
            'Team' => $keys['rev']->MyTeam ?? '',
            'Status' => $keys['rev']->TeamStatus ?? '',
            'EKform' => $keys['rev']->FKraForm ?? '',
            'EPform' => $keys['rev']->FPmsForm ?? '',
            'EHform' => $keys['rev']->FHistoryForm ?? '',
            'Rating' => $keys['rev']->RatingGraph ?? '',
        ],
        'hod' => [
            'Home' => $keys['hod']->Home ?? '',
            'Team' => $keys['hod']->MyTeam ?? '',
            'Status' => $keys['hod']->TeamStatus ?? '',
            'EKform' => $keys['hod']->FKraForm ?? '',
            'EPform' => $keys['hod']->FPmsForm ?? '',
            'EHform' => $keys['hod']->FHistoryForm ?? '',
            'Score' => $keys['hod']->Score ?? '',
            'Prom' => $keys['hod']->Promotion ?? '',
            'Inc' => $keys['hod']->Increment ?? '',
            'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
            'Increport' => $keys['hod']->IncrementReport ?? '',
            'Rating' => $keys['hod']->RatingGraph ?? '',
        ],
    ];
        $employeedetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->select('EmployeeID')
        ->first();

        $employeealldetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->first();

        $employeedetailspms = DB::table('hrm_employee as e')
        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
        ->where('e.EmpStatus', 'A')
        ->where('e.EmployeeID', $employeedetailsforpms->EmployeeID)
        ->select([
            'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
            'd.department_name'
        ])
        ->first();
        $employeeid = $employeedetailsforpms->EmployeeID;

        $achievement = DB::table('hrm_employee_pms_achivement')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->orderBy('created_at','ASC')
                        ->get();

        $feedback = DB::table('hrm_employee_pms_workenvironment')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();

        $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();
            
        // Fetch related data from kra and submr tables
        foreach ($employeePmsKraforma as $kraforma) {
            $kraforma->kra = DB::table('hrm_pms_kra')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
            
            
            $kraforma->submr = DB::table('hrm_pms_krasub')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
        }
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
        
        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        
        $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
        ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
        ->where('fbf.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('fbf.YearId', $PmsYId)
        ->orderBy('fbf.BehavioralFormBId', 'ASC')
        ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target')
        ->get();

        $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
        ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
        ->where('s.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('s.YearId', $PmsYId)
        ->select('s.*', 'bb.*')
        ->get();


        // Example query to fetch data from the `hrm_employee_general` table
        $employeeDetails = DB::table('hrm_employee_general')
            ->where('EmployeeID', $employeedetailsforpms->EmployeeID)
            ->first();
    // Fetch the current grade value
    $gradeValue = DB::table('core_grades')
        ->where('id', $employeeDetails->GradeId)
        ->select('id', 'grade_name')  // Select both the id and grade_name
        ->first(); // Use first() to get the result as a single object

    // Logic to get the next grade based on the current grade
    if ($gradeValue->grade_name!= 'MG') {
        // Get the next grade ID (incrementing the current GradeId by 1)
        $nextGradeId = $employeeDetails->GradeId + 1;
    
        $nextGrade = DB::table('core_grades')
                        ->where('id',$nextGradeId)
                        ->select('id', 'grade_name')  // Select both the id and grade_name
                        ->first(); // Use first() to get the result as a single object

    } else {
        // If the grade is 'MG', the next grade stays the same
        $nextGrade = $gradeValue;
    }

    // Fetch available designations based on the next grade
    $availableDesignations = DB::table('hrm_deptgradedesig')
        ->join('core_designation', 'hrm_deptgradedesig.DesigId', '=', 'core_designation.id')
        ->where('hrm_deptgradedesig.DepartmentId', $employeeDetails->DepartmentId)
        ->where(function($query) use ($nextGradeId) {
            $query->where('hrm_deptgradedesig.GradeId', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_2', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_3', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_4', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_5', $nextGradeId);
        })
    ->where('core_designation.is_active', '1')
    ->orderBy('core_designation.designation_name')
    ->get();
    // Fetch designation
    $designation = DB::table('core_designation')
    ->where('id', $employeeDetails->DesigId)
    ->value('designation_name');

    $designationappraiser = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpDesignation)
    ->value('designation_name');   

    $gradeappraiser = DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpGrade)
    ->value('grade_name');

    $designationreviewer = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpDesignation)
    ->value('designation_name');   

    $gradereviewer= DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpGrade)
    ->value('grade_name');

    $department = DB::table('core_departments')
    ->where('id', $employeeDetails->DepartmentId)
    ->value('department_name');
    $category = $department ?: 'Other';

    $trainings = DB::table('hrm_pms_training')
    ->where('type','Functional Skills')
    ->whereRaw('LOWER(Category) = ?', [strtolower($category)]) // Case-insensitive comparison
    ->get();

    // If no data found for the requested category, fallback to 'Other'
    if ($trainings->isEmpty()) {
        $trainings = DB::table('hrm_pms_training')
            ->whereRaw('LOWER(Category) = ?', ['other']) 
            ->where('type', 'Functional Skills')
            ->get();
    }

    $softSkills =  DB::table('hrm_pms_training')->where('type', 'Soft Skill')
                            ->get()
                            ->groupBy('Category');
    $pms_id= DB::table('hrm_employee_pms')
                            ->where('hrm_employee_pms.EmployeeID', $employeedetailsforpms->EmployeeID)
                            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
                            ->where('hrm_employee_pms.CompanyId',$CompanyId)
                            ->first();
                            
    $softSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_Oth)
                            ->get();
    $functionalSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_Oth)
                            ->get();
    $softSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_Oth)
                            ->get();
    $functionalSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_Oth)
                            ->get();
    return view('employee.hodpms',compact('employeedetailspms','achievement','feedback','gradeValue',
    'designationappraiser','gradeappraiser','softSkillsAppraisal','functionalSkillsAppraisal','gradereviewer','designationreviewer',
    'employeeDetails','nextGrade','availableDesignations','designation','softSkills','trainings','pms_id','functionalSkillsReviewer','softSkillsReviewer',
    'employeePmsKraforma','year_pms','CompanyId','behavioralForms','behavioralFormssub','PmsYId','employeeid','employeealldetailsforpms','data'));
}

public function viewreviewer($encryptedEmpPmsId)
{
    // Decrypt the passed ID
    $EmpPmsId = decrypt($encryptedEmpPmsId);
    $CompanyId = Auth::user()->CompanyId;
    // Fetch key data for different persons
    $keys = [
        'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
        'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
        'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
        'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
    ];


    // Store extracted values in an array
    $data = [
        'emp' => [
            'Msg' => $keys['emp']->EmpMsg ?? '',
            'Details' => $keys['emp']->PersonalDetails ?? '',
            'Schedule' => $keys['emp']->Schedule ?? '',
            'Appform' => $keys['emp']->AppraisalForm ?? '',
            'Midform' => $keys['emp']->MidPmsForm ?? '',
            'Kraform' => $keys['emp']->KRAForm ?? '',
            'Helpfaq' => $keys['emp']->Help_Faq ?? '',
            'Viewprint' => $keys['emp']->View_Print ?? '',
        ],
        'app' => [
            'Home' => $keys['app']->Home ?? '',
            'Team' => $keys['app']->MyTeam ?? '',
            'Status' => $keys['app']->TeamStatus ?? '',
            'EKform' => $keys['app']->FKraForm ?? '',
            'EPform' => $keys['app']->FPmsForm ?? '',
            'EHform' => $keys['app']->FHistoryForm ?? '',
            'Rating' => $keys['app']->RatingGraph ?? '',
        ],
        'rev' => [
            'Home' => $keys['rev']->Home ?? '',
            'Team' => $keys['rev']->MyTeam ?? '',
            'Status' => $keys['rev']->TeamStatus ?? '',
            'EKform' => $keys['rev']->FKraForm ?? '',
            'EPform' => $keys['rev']->FPmsForm ?? '',
            'EHform' => $keys['rev']->FHistoryForm ?? '',
            'Rating' => $keys['rev']->RatingGraph ?? '',
        ],
        'hod' => [
            'Home' => $keys['hod']->Home ?? '',
            'Team' => $keys['hod']->MyTeam ?? '',
            'Status' => $keys['hod']->TeamStatus ?? '',
            'EKform' => $keys['hod']->FKraForm ?? '',
            'EPform' => $keys['hod']->FPmsForm ?? '',
            'EHform' => $keys['hod']->FHistoryForm ?? '',
            'Score' => $keys['hod']->Score ?? '',
            'Prom' => $keys['hod']->Promotion ?? '',
            'Inc' => $keys['hod']->Increment ?? '',
            'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
            'Increport' => $keys['hod']->IncrementReport ?? '',
            'Rating' => $keys['hod']->RatingGraph ?? '',
        ],
    ];
        $employeedetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->select('EmployeeID')
        ->first();

        $employeealldetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->first();

        $employeedetailspms = DB::table('hrm_employee as e')
        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
        ->where('e.EmpStatus', 'A')
        ->where('e.EmployeeID', $employeedetailsforpms->EmployeeID)
        ->select([
            'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
            'd.department_name'
        ])
        ->first();
        $employeeid = $employeedetailsforpms->EmployeeID;

        $achievement = DB::table('hrm_employee_pms_achivement')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->orderBy('created_at','ASC')
                        ->get();

        $feedback = DB::table('hrm_employee_pms_workenvironment')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();

        $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();
            
        // Fetch related data from kra and submr tables
        foreach ($employeePmsKraforma as $kraforma) {
            $kraforma->kra = DB::table('hrm_pms_kra')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
            
            
            $kraforma->submr = DB::table('hrm_pms_krasub')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
        }
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
        
        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        
        $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
        ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
        ->where('fbf.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('fbf.YearId', $PmsYId)
        ->orderBy('fbf.BehavioralFormBId', 'ASC')
        ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target')
        ->get();

        $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
        ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
        ->where('s.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('s.YearId', $PmsYId)
        ->select('s.*', 'bb.*')
        ->get();


        // Example query to fetch data from the `hrm_employee_general` table
        $employeeDetails = DB::table('hrm_employee_general')
            ->where('EmployeeID', $employeedetailsforpms->EmployeeID)
            ->first();
    // Fetch the current grade value
    $gradeValue = DB::table('core_grades')
        ->where('id', $employeeDetails->GradeId)
        ->select('id', 'grade_name')  // Select both the id and grade_name
        ->first(); // Use first() to get the result as a single object

    // Logic to get the next grade based on the current grade
    if ($gradeValue->grade_name!= 'MG') {
        // Get the next grade ID (incrementing the current GradeId by 1)
        $nextGradeId = $employeeDetails->GradeId + 1;
    
        $nextGrade = DB::table('core_grades')
                        ->where('id',$nextGradeId)
                        ->select('id', 'grade_name')  // Select both the id and grade_name
                        ->first(); // Use first() to get the result as a single object

    } else {
        // If the grade is 'MG', the next grade stays the same
        $nextGrade = $gradeValue;
    }

    // Fetch available designations based on the next grade
    $availableDesignations = DB::table('hrm_deptgradedesig')
        ->join('core_designation', 'hrm_deptgradedesig.DesigId', '=', 'core_designation.id')
        ->where('hrm_deptgradedesig.DepartmentId', $employeeDetails->DepartmentId)
        ->where(function($query) use ($nextGradeId) {
            $query->where('hrm_deptgradedesig.GradeId', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_2', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_3', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_4', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_5', $nextGradeId);
        })
    ->where('core_designation.is_active', '1')
    ->orderBy('core_designation.designation_name')
    ->get();
    // Fetch designation
    $designation = DB::table('core_designation')
    ->where('id', $employeeDetails->DesigId)
    ->value('designation_name');

    $designationappraiser = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpDesignation)
    ->value('designation_name');   

    $gradeappraiser = DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpGrade)
    ->value('grade_name');

    $designationreviewer = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpDesignation)
    ->value('designation_name');   

    $gradereviewer= DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpGrade)
    ->value('grade_name');

    $department = DB::table('core_departments')
    ->where('id', $employeeDetails->DepartmentId)
    ->value('department_name');
    $category = $department ?: 'Other';

    $trainings = DB::table('hrm_pms_training')
    ->where('type','Functional Skills')
    ->whereRaw('LOWER(Category) = ?', [strtolower($category)]) // Case-insensitive comparison
    ->get();

    // If no data found for the requested category, fallback to 'Other'
    if ($trainings->isEmpty()) {
        $trainings = DB::table('hrm_pms_training')
            ->whereRaw('LOWER(Category) = ?', ['other']) 
            ->where('type', 'Functional Skills')
            ->get();
    }

    $softSkills =  DB::table('hrm_pms_training')->where('type', 'Soft Skill')
                            ->get()
                            ->groupBy('Category');
    $pms_id= DB::table('hrm_employee_pms')
                            ->where('hrm_employee_pms.EmployeeID', $employeedetailsforpms->EmployeeID)
                            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
                            ->where('hrm_employee_pms.CompanyId',$CompanyId)
                            ->first();
                            
    $softSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_Oth)
                            ->get();
    $functionalSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_Oth)
                            ->get();
    $softSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_Oth)
                            ->get();
    $functionalSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_Oth)
                            ->get();
    return view('employee.reviewerviewpms',compact('employeedetailspms','achievement','feedback','gradeValue',
    'designationappraiser','gradeappraiser','softSkillsAppraisal','functionalSkillsAppraisal','gradereviewer','designationreviewer',
    'employeeDetails','nextGrade','availableDesignations','designation','softSkills','trainings','pms_id','functionalSkillsReviewer','softSkillsReviewer',
    'employeePmsKraforma','year_pms','CompanyId','behavioralForms','behavioralFormssub','PmsYId','employeeid','employeealldetailsforpms','data'));
}
public function viewappraiser($encryptedEmpPmsId)
{
    // Decrypt the passed ID
    $EmpPmsId = decrypt($encryptedEmpPmsId);
    $CompanyId = Auth::user()->CompanyId;
    // Fetch key data for different persons
    $keys = [
        'emp' => DB::table('hrm_pms_key')->where('Person', 'emp')->where('CompanyId', $CompanyId)->first(),
        'app' => DB::table('hrm_pms_key')->where('Person', 'app')->where('CompanyId', $CompanyId)->first(),
        'rev' => DB::table('hrm_pms_key')->where('Person', 'rev')->where('CompanyId', $CompanyId)->first(),
        'hod' => DB::table('hrm_pms_key')->where('Person', 'hod')->where('CompanyId', $CompanyId)->first(),
    ];


    // Store extracted values in an array
    $data = [
        'emp' => [
            'Msg' => $keys['emp']->EmpMsg ?? '',
            'Details' => $keys['emp']->PersonalDetails ?? '',
            'Schedule' => $keys['emp']->Schedule ?? '',
            'Appform' => $keys['emp']->AppraisalForm ?? '',
            'Midform' => $keys['emp']->MidPmsForm ?? '',
            'Kraform' => $keys['emp']->KRAForm ?? '',
            'Helpfaq' => $keys['emp']->Help_Faq ?? '',
            'Viewprint' => $keys['emp']->View_Print ?? '',
        ],
        'app' => [
            'Home' => $keys['app']->Home ?? '',
            'Team' => $keys['app']->MyTeam ?? '',
            'Status' => $keys['app']->TeamStatus ?? '',
            'EKform' => $keys['app']->FKraForm ?? '',
            'EPform' => $keys['app']->FPmsForm ?? '',
            'EHform' => $keys['app']->FHistoryForm ?? '',
            'Rating' => $keys['app']->RatingGraph ?? '',
        ],
        'rev' => [
            'Home' => $keys['rev']->Home ?? '',
            'Team' => $keys['rev']->MyTeam ?? '',
            'Status' => $keys['rev']->TeamStatus ?? '',
            'EKform' => $keys['rev']->FKraForm ?? '',
            'EPform' => $keys['rev']->FPmsForm ?? '',
            'EHform' => $keys['rev']->FHistoryForm ?? '',
            'Rating' => $keys['rev']->RatingGraph ?? '',
        ],
        'hod' => [
            'Home' => $keys['hod']->Home ?? '',
            'Team' => $keys['hod']->MyTeam ?? '',
            'Status' => $keys['hod']->TeamStatus ?? '',
            'EKform' => $keys['hod']->FKraForm ?? '',
            'EPform' => $keys['hod']->FPmsForm ?? '',
            'EHform' => $keys['hod']->FHistoryForm ?? '',
            'Score' => $keys['hod']->Score ?? '',
            'Prom' => $keys['hod']->Promotion ?? '',
            'Inc' => $keys['hod']->Increment ?? '',
            'Pmsreport' => $keys['hod']->MyPmsReport ?? '',
            'Increport' => $keys['hod']->IncrementReport ?? '',
            'Rating' => $keys['hod']->RatingGraph ?? '',
        ],
    ];
        $employeedetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->select('EmployeeID')
        ->first();

        $employeealldetailsforpms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $EmpPmsId)
        ->first();

        $employeedetailspms = DB::table('hrm_employee as e')
        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
        ->where('e.EmpStatus', 'A')
        ->where('e.EmployeeID', $employeedetailsforpms->EmployeeID)
        ->select([
            'e.EmployeeID', 'e.EmpCode', 'e.Fname', 'e.Sname', 'e.Lname', 
            'd.department_name'
        ])
        ->first();
        $employeeid = $employeedetailsforpms->EmployeeID;

        $achievement = DB::table('hrm_employee_pms_achivement')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->orderBy('created_at','ASC')
                        ->get();

        $feedback = DB::table('hrm_employee_pms_workenvironment')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();

        $employeePmsKraforma = DB::table('hrm_employee_pms_kraforma')
                        ->where('EmpPmsId', $EmpPmsId)
                        ->get();
            
        // Fetch related data from kra and submr tables
        foreach ($employeePmsKraforma as $kraforma) {
            $kraforma->kra = DB::table('hrm_pms_kra')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
            
            
            $kraforma->submr = DB::table('hrm_pms_krasub')
                            ->where('KRAId', $kraforma->KRAId)
                            ->get();
        }
        $year_pms = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'PMS')->first();
        
        $PmsYId = ($keys['emp']->AppraisalForm == 'Y') ? $year_pms->CurrY : (($year_pms->NewY_AllowEntry == 'Y') ? $year_pms->NewY : $year_pms->CurrY);
        
        $behavioralForms = DB::table('hrm_employee_pms_behavioralformb as fbf')
        ->join('hrm_pms_formb as fb', 'fbf.FormBId', '=', 'fb.FormBId')
        ->where('fbf.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('fbf.YearId', $PmsYId)
        ->orderBy('fbf.BehavioralFormBId', 'ASC')
        ->select('fbf.*', 'fb.Skill', 'fb.SkillComment', 'fb.Weightage', 'fb.Logic', 'fb.Period', 'fb.Target')
        ->get();

        $behavioralFormssub= DB::table('hrm_employee_pms_behavioralformb_sub as s')
        ->join('hrm_pms_formbsub as bb', 's.FormBSubId', '=', 'bb.FormBSubId')
        ->where('s.EmpId', $employeedetailsforpms->EmployeeID)
        ->where('s.YearId', $PmsYId)
        ->select('s.*', 'bb.*')
        ->get();


        // Example query to fetch data from the `hrm_employee_general` table
        $employeeDetails = DB::table('hrm_employee_general')
            ->where('EmployeeID', $employeedetailsforpms->EmployeeID)
            ->first();
    // Fetch the current grade value
    $gradeValue = DB::table('core_grades')
        ->where('id', $employeeDetails->GradeId)
        ->select('id', 'grade_name')  // Select both the id and grade_name
        ->first(); // Use first() to get the result as a single object

    if ($gradeValue->grade_name!= 'MG') {
        $nextGradeId = $employeeDetails->GradeId + 1;
    
        $nextGrade = DB::table('core_grades')
                        ->where('id',$nextGradeId)
                        ->select('id', 'grade_name')
                        ->first();
    } else {
        // If the grade is 'MG', the next grade stays the same
        $nextGrade = $gradeValue;
    }

    // Fetch available designations based on the next grade
    $availableDesignations = DB::table('hrm_deptgradedesig')
        ->join('core_designation', 'hrm_deptgradedesig.DesigId', '=', 'core_designation.id')
        ->where('hrm_deptgradedesig.DepartmentId', $employeeDetails->DepartmentId)
        ->where(function($query) use ($nextGradeId) {
            $query->where('hrm_deptgradedesig.GradeId', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_2', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_3', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_4', $nextGradeId)
                ->orWhere('hrm_deptgradedesig.GradeId_5', $nextGradeId);
        })
    ->where('core_designation.is_active', '1')
    ->orderBy('core_designation.designation_name')
    ->get();
    // Fetch designation
    $designation = DB::table('core_designation')
    ->where('id', $employeeDetails->DesigId)
    ->value('designation_name');

    $designationappraiser = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpDesignation)
    ->value('designation_name');   

    $gradeappraiser = DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Appraiser_EmpGrade)
    ->value('grade_name');

    $designationreviewer = DB::table('core_designation')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpDesignation)
    ->value('designation_name');   

    $gradereviewer= DB::table('core_grades')
    ->where('id', $employeealldetailsforpms->Reviewer_EmpGrade)
    ->value('grade_name');

    $department = DB::table('core_departments')
    ->where('id', $employeeDetails->DepartmentId)
    ->value('department_name');
    $category = $department ?: 'Other';

    $trainings = DB::table('hrm_pms_training')
    ->where('type','Functional Skills')
    ->whereRaw('LOWER(Category) = ?', [strtolower($category)]) // Case-insensitive comparison
    ->get();

    // If no data found for the requested category, fallback to 'Other'
    if ($trainings->isEmpty()) {
        $trainings = DB::table('hrm_pms_training')
            ->whereRaw('LOWER(Category) = ?', ['other']) 
            ->where('type', 'Functional Skills')
            ->get();
    }

    $softSkills =  DB::table('hrm_pms_training')->where('type', 'Soft Skill')
                            ->get()
                            ->groupBy('Category');
    $pms_id= DB::table('hrm_employee_pms')
                            ->where('hrm_employee_pms.EmployeeID', $employeedetailsforpms->EmployeeID)
                            ->where('hrm_employee_pms.AssessmentYear',$PmsYId)
                            ->where('hrm_employee_pms.CompanyId',$CompanyId)
                            ->first();
                            
    $softSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_SoftSkill_Oth)
                            ->get();
    $functionalSkillsReviewer = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Reviewer_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Reviewer_TechSkill_Oth)
                            ->get();
    $softSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_SoftSkill_Oth)
                            ->get();
    $functionalSkillsAppraisal = DB::table('hrm_pms_training')
                            ->where('Tid', $employeealldetailsforpms->Appraiser_TechSkill_1)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_2)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_3)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_4)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_5)
                            ->orWhere('Tid', $employeealldetailsforpms->Appraiser_TechSkill_Oth)
                            ->get();
    return view('employee.appraiserviewpms',compact('employeedetailspms','achievement','feedback','gradeValue',
    'designationappraiser','gradeappraiser','softSkillsAppraisal','functionalSkillsAppraisal','gradereviewer','designationreviewer',
    'employeeDetails','nextGrade','availableDesignations','designation','softSkills','trainings','pms_id','functionalSkillsReviewer','softSkillsReviewer',
    'employeePmsKraforma','year_pms','CompanyId','behavioralForms','behavioralFormssub','PmsYId','employeeid','employeealldetailsforpms','data'));
}
public function saveKraData(Request $request)
{
        $kraData = $request->input('kraData');
        $year_id = $request->input('year_id');
        $CompanyId = $request->input('CompanyId');
        $employeeid = $request->input('employeeid');


        // Filter out the data where all scores are null (except kraId)
        $filteredKraData = collect($kraData)->filter(function ($kra) {
            return !is_null($kra['KralogScore'] ?? null) || 
                   !is_null($kra['subKralogScore'] ?? null) || 
                   !is_null($kra['subKraScore'] ?? null) || 
                   !is_null($kra['KraScore'] ?? null);
        })->values();


        foreach ($filteredKraData as $kra) {

            // If both kraId and subKraId are present, update in kraSub table
            if (!is_null($kra['kraId']) && !is_null($kra['subKraId'])) {
                // Update query for kraSub table
                        DB::table('hrm_pms_krasub')
                        ->where('KRASubId', $kra['subKraId'])
                    ->update([
                        'AppraiserRating' => $kra['rating'],
                        'AppraiserRemark' => $kra['remarks'],
                        'AppraiserLogic' => $kra['subKralogScore'], // If applicable, adjust field names
                        'AppraiserScore' => $kra['subKraScore'],
                    ]);
            }
            // If only kraId is present, update in forma table
            elseif (!is_null($kra['kraId']) && is_null($kra['subKraId'])) {
            DB::table('hrm_employee_pms_kraforma')
                    ->where('KRAId', $kra['kraId']) // Assuming kraId is the unique identifier
                    ->update([
                        'AppraiserRating' => $kra['krarating'],
                        'AppraiserRemark' => $kra['kraremarks'],
                        'AppraiserLogic' => $kra['KralogScore'], // If applicable, adjust field names
                        'AppraiserScore' => $kra['KraScore'],
                    ]);
            }
        }
        $formBData = $request->input('kraDataformb');
        $filteredKraDataformb = collect($formBData)->filter(function ($kraDataformb) {
            // Check if at least one of the following fields is not null
            return !is_null($kraDataformb['subFormKraId']) || 
                !is_null($kraDataformb['rating']) || 
                !is_null($kraDataformb['krarating']) || 
                !is_null($kraDataformb['logScore']) || 
                !is_null($kraDataformb['subKraScore']) || 
                !is_null($kraDataformb['kraScore']);
        })->values();

        // Loop through the filtered Form B data
    foreach ($filteredKraDataformb as $kraDataformb) {
        if (!empty($kraDataformb['subFormKraId'])) {
            // Update the sub-form B record (hrm_employee_pms_behavioralformb_sub)
            DB::table('hrm_employee_pms_behavioralformb_sub')
            ->where('FormBSubId', $kraDataformb['subFormKraId'])
            ->where('EmpId', $employeeid)
            ->update([
                'AppraiserRating' => $kraDataformb['rating'],
                'AppraiserLogic'  => $kraDataformb['subLogScore'],
                'AppraiserScore'  => $kraDataformb['subKraScore'],
                'AppraiserRemark' => $kraDataformb['subFormRemarks'], // Update subFormRemarks if present
            ]);
            } else {
                // Update the main Form B record (hrm_employee_pms_behavioralformb)
                DB::table('hrm_employee_pms_behavioralformb')
                    ->where('BehavioralFormBId', $kraDataformb['formKraId'])
                    ->update([
                        'AppraiserRating' => $kraDataformb['krarating'],
                        'AppraiserLogic'  => $kraDataformb['logScore'],
                        'AppraiserScore'  => $kraDataformb['kraScore'],
                        'AppraiserRemark' => $kraDataformb['remarks'], // Update remarks if present
                    ]);
            }
        }

        $appraiserdata = $request->input('appraiserpmsdata');
            
        // Access TotalFinalScore from the nested array
        $Emp_TotalFinalScore = round($appraiserdata['Appraiser']['TotalFinalScore'], 2);
        $gradedeg = $request->input('gatherpromotiondata');
            
        // Access TotalFinalScore from the nested array
        $gradeprom = $gradedeg['grade'];
        $degn = $gradedeg['designation'];
        $appjust = $gradedeg['promotionDescription'];

        if ($Emp_TotalFinalScore > 150) {
            $Emp_TotalFinalRating = 5;
        } else {
            $rating = DB::table('hrm_pms_rating')
                ->select('Rating')
                ->where('RatingStatus', 'A')
                ->where('YearId', $year_id)
                ->where('CompanyId', $CompanyId)
                ->where('ScoreFrom', '<=', $Emp_TotalFinalScore)
                ->where('ScoreTo', '>=', $Emp_TotalFinalScore)
                ->first();

            $Emp_TotalFinalRating = $rating ? $rating->Rating : null;
        }

       // Extract SoftSkills and Functional Skills data
       $softSkills = $request->input('trainingData.SoftSkillsTraining');
       $functionalSkills = $request->input('trainingData.FunctionalSkillsTraining');
   
       // Initialize arrays for updating SoftSkills and TechSkills
       $softSkillsUpdate = [];
       $techSkillsUpdate = [];
       $softSkillsOther = [];
       $techSkillsOther = [];
   
       // Process SoftSkillsTraining
       if ($softSkills) {
           $index = 1;  // Start from 1 for SoftSkill_1
           foreach ($softSkills as $skill) {
               if ($skill['topic'] === "Other") {
                   // If topic is "Other", store in the respective field based on category
                   if ($skill['category'] === 'Technological Skills') {
                       $techSkillsOther[] = $skill['Tid']; // Handle tech skills under "Other"
                   } elseif ($skill['category'] === 'SoftSkills') {
                       $softSkillsOther[] = $skill['Tid']; // Handle soft skills under "Other"
                   }
               } else {
                   // If the topic is not "Other", update the corresponding Appraiser_SoftSkill_* field
                   $softSkillsUpdate["Appraiser_SoftSkill_$index"] = $skill['Tid'];
                   $index++;
               }
           }
       }
   
       // Process FunctionalSkillsTraining
       if ($functionalSkills) {
           $index = 1;  // Start from 1 for TechSkill_1
           foreach ($functionalSkills as $skill) {

               if ($skill['topic'] === "Other") {
                       $techSkillsOther[] = $skill['Tid']; // Handle tech skills under "Other"
                       $techSkillsOtherdesc[] = $skill['description']; // Handle tech skills under "Other"

                   }
               else {
                   // If the topic is not "Other", update the corresponding Appraiser_TechSkill_* field
                   $techSkillsUpdate["Appraiser_TechSkill_$index"] = $skill['Tid'];
                   $index++;
               }
           }
       }
       if($request->action == 'save'){
        $status = '1';
       }
       if($request->action == 'submit'){
        $status = '2';
       }
    //     // Check if a record with the same EmployeeID and EmpPmsId already exists
    //     $existingRecord = DB::table('hrm_employee_pms')
    //                         ->where('EmpPmsId', $request->pms_id)
    //                         ->where('EmployeeID', $employeeid)
    //                         ->first();

    //     // If a record exists, check for duplicate skills
    //     if ($existingRecord) {
    //     // Convert existing skills to an array for easy comparison
    //     $existingSoftSkills = [
    //         $existingRecord->Appraiser_SoftSkill_1,
    //         $existingRecord->Appraiser_SoftSkill_2,
    //         $existingRecord->Appraiser_SoftSkill_3,
    //         $existingRecord->Appraiser_SoftSkill_4,
    //         $existingRecord->Appraiser_SoftSkill_5
    //     ];

    //     $existingTechSkills = [
    //         $existingRecord->Appraiser_TechSkill_1,
    //         $existingRecord->Appraiser_TechSkill_2,
    //         $existingRecord->Appraiser_TechSkill_3,
    //         $existingRecord->Appraiser_TechSkill_4,
    //         $existingRecord->Appraiser_TechSkill_5
    //     ];

    //     // Convert new skills to an array
    //     $newSoftSkills = [
    //         $softSkillsUpdate['Appraiser_SoftSkill_1'] ?? ' ',
    //         $softSkillsUpdate['Appraiser_SoftSkill_2'] ?? ' ',
    //         $softSkillsUpdate['Appraiser_SoftSkill_3'] ?? ' ',
    //         $softSkillsUpdate['Appraiser_SoftSkill_4'] ?? ' ',
    //         $softSkillsUpdate['Appraiser_SoftSkill_5'] ?? ' '
    //     ];

    //     $newTechSkills = [
    //         $techSkillsUpdate['Appraiser_TechSkill_1'] ?? ' ',
    //         $techSkillsUpdate['Appraiser_TechSkill_2'] ?? ' ',
    //         $techSkillsUpdate['Appraiser_TechSkill_3'] ?? ' ',
    //         $techSkillsUpdate['Appraiser_TechSkill_4'] ?? ' ',
    //         $techSkillsUpdate['Appraiser_TechSkill_5'] ?? ' '
    //     ];

    // // Check if there is any duplicate skill
    // $duplicateSoftSkill = array_intersect($existingSoftSkills, $newSoftSkills);
    // $duplicateTechSkill = array_intersect($existingTechSkills, $newTechSkills);

    // if (!empty($duplicateSoftSkill) || !empty($duplicateTechSkill)) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Duplicate skills found. Please modify and try again.'
    //     ]);
    // }
    // }
    $data = [
        'Appraiser_Remark' => $request->appreamrk,
        'Appraiser_PmsStatus' => $status,
        'Appraiser_SubmitedDate' => now(),
        'AppraiserFormAScore' => $appraiserdata['Appraiser']['AppraiserFormAScore'],
        'AppraiserFormBScore' => $appraiserdata['Appraiser']['AppraiserFormBScore'],
        'AppraiserFinallyFormA_Score' => $appraiserdata['Appraiser']['FormAScorePerWeightage'],
        'AppraiserFinallyFormB_Score' => $appraiserdata['Appraiser']['AppraiserFinalScore'],
        'Appraiser_TotalFinalScore' => round($appraiserdata['Appraiser']['TotalFinalScore'],2),
        'Appraiser_TotalFinalRating' => $Emp_TotalFinalRating,
        'Dummy_AppRating' => $Emp_TotalFinalRating, 
        'Appraiser_EmpDesignation' => $degn,
        'Appraiser_EmpGrade' => $gradeprom,
        'Appraiser_SoftSkill_1' => $softSkillsUpdate['Appraiser_SoftSkill_1'] ?? ' ',
        'Appraiser_SoftSkill_2' => $softSkillsUpdate['Appraiser_SoftSkill_2'] ?? ' ',
        'Appraiser_SoftSkill_3' => $softSkillsUpdate['Appraiser_SoftSkill_3'] ?? ' ',
        'Appraiser_SoftSkill_4' => $softSkillsUpdate['Appraiser_SoftSkill_4'] ?? ' ',
        'Appraiser_SoftSkill_5' => $softSkillsUpdate['Appraiser_SoftSkill_5'] ?? ' ',
        'Appraiser_TechSkill_1' => $techSkillsUpdate['Appraiser_TechSkill_1'] ?? ' ',
        'Appraiser_TechSkill_2' => $techSkillsUpdate['Appraiser_TechSkill_2'] ?? ' ',
        'Appraiser_TechSkill_3' => $techSkillsUpdate['Appraiser_TechSkill_3'] ?? ' ',
        'Appraiser_TechSkill_4' => $techSkillsUpdate['Appraiser_TechSkill_4'] ?? ' ',
        'Appraiser_TechSkill_5' => $techSkillsUpdate['Appraiser_TechSkill_5'] ?? ' ',
        'Appraiser_SoftSkill_Oth' => implode(', ', $softSkillsOther),
        'Appraiser_TechSkill_Oth' => implode(', ', $techSkillsOther),
        'Appraiser_Justification' => $appjust,
    ];
       // Perform the update on the hrm_employee_pms table
       $updated = DB::table('hrm_employee_pms')
       ->where('EmpPmsId', $request->pms_id)
       ->where('EmployeeID', $employeeid)
       ->update($data);


    // Return a response indicating success
    return response()->json(['success' => true, 'message' => 'Data saved Successfully']);

}
public function saveKraDataRev(Request $request)
{
        $kraData = $request->input('kraData');
        $year_id = $request->input('year_id');
        $CompanyId = $request->input('CompanyId');
        $employeeid = $request->input('employeeid');

        
        $reviewerpmsdata = $request->input('reviewerpmsdata');
            
        // Access TotalFinalScore from the nested array
        $Emp_TotalFinalScore = round($reviewerpmsdata['Appraiser']['TotalFinalScore'], 2);
        $gradedeg = $request->input('gatherpromotiondata');
            
        // Access TotalFinalScore from the nested array
        $gradeprom = $gradedeg['grade'];
        $degn = $gradedeg['designation'];
        $appjust = $gradedeg['promotionDescription'];

        if ($Emp_TotalFinalScore > 150) {
            $Emp_TotalFinalRating = 5;
        } else {
            $rating = DB::table('hrm_pms_rating')
                ->select('Rating')
                ->where('RatingStatus', 'A')
                ->where('YearId', $year_id)
                ->where('CompanyId', $CompanyId)
                ->where('ScoreFrom', '<=', $Emp_TotalFinalScore)
                ->where('ScoreTo', '>=', $Emp_TotalFinalScore)
                ->first();

            $Emp_TotalFinalRating = $rating ? $rating->Rating : null;
        }

       // Extract SoftSkills and Functional Skills data
       $softSkills = $request->input('trainingData.SoftSkillsTraining');
       $functionalSkills = $request->input('trainingData.FunctionalSkillsTraining');
   
       // Initialize arrays for updating SoftSkills and TechSkills
       $softSkillsUpdate = [];
       $techSkillsUpdate = [];
       $softSkillsOther = [];
       $techSkillsOther = [];
   
       // Process SoftSkillsTraining
       if ($softSkills) {
           $index = 1;  // Start from 1 for SoftSkill_1
           foreach ($softSkills as $skill) {
               if ($skill['topic'] === "Other") {

                   // If topic is "Other", store in the respective field based on category
                   if ($skill['category'] === 'Technological Skills') {
                       $techSkillsOther[] = $skill['Tid']; // Handle tech skills under "Other"
                   } elseif ($skill['category'] === 'SoftSkills') {
                       $softSkillsOther[] = $skill['Tid']; // Handle soft skills under "Other"
                   }
               } else {
                   // If the topic is not "Other", update the corresponding Appraiser_SoftSkill_* field
                   $softSkillsUpdate["Reviewer_SoftSkill_$index"] = $skill['Tid'];
                   $index++;
               }
           }
       }
   
       // Process FunctionalSkillsTraining
       if ($functionalSkills) {
           $index = 1;  // Start from 1 for TechSkill_1
           foreach ($functionalSkills as $skill) {

               if ($skill['topic'] === "Other") {
                        $techSkillsUpdate["Reviewer_TechSkill_$index"] = $skill['Tid'];
                        $techSkillsOtherdesc[] = $skill['description']; // Handle tech skills under "Other"

                   }
               else {
                   // If the topic is not "Other", update the corresponding Reviewer_TechSkill_* field
                   $techSkillsUpdate["Reviewer_TechSkill_$index"] = $skill['Tid'];
                   $index++;
               }
           }
       }
       if($request->action == 'save'){
        $status = '1';
       }
       if($request->action == 'submit'){
        $status = '2';
       }
       // Check if a record with the same EmployeeID and EmpPmsId already exists
        $existingRecord = DB::table('hrm_employee_pms')
                            ->where('EmpPmsId', $request->pms_id)
                            ->where('EmployeeID', $employeeid)
                            ->first();

        // If a record exists, check for duplicate skills
        if ($existingRecord) {
        // Convert existing skills to an array for easy comparison
        $existingSoftSkills = [
            $existingRecord->Reviewer_SoftSkill_1,
            $existingRecord->Reviewer_SoftSkill_2,
            $existingRecord->Reviewer_SoftSkill_3,
            $existingRecord->Reviewer_SoftSkill_4,
            $existingRecord->Reviewer_SoftSkill_5
        ];

        $existingTechSkills = [
            $existingRecord->Reviewer_TechSkill_1,
            $existingRecord->Reviewer_TechSkill_2,
            $existingRecord->Reviewer_TechSkill_3,
            $existingRecord->Reviewer_TechSkill_4,
            $existingRecord->Reviewer_TechSkill_5
        ];

        // Convert new skills to an array
        $newSoftSkills = [
            $softSkillsUpdate['Reviewer_SoftSkill_1'] ?? ' ',
            $softSkillsUpdate['Reviewer_SoftSkill_2'] ?? ' ',
            $softSkillsUpdate['Reviewer_SoftSkill_3'] ?? ' ',
            $softSkillsUpdate['Reviewer_SoftSkill_4'] ?? ' ',
            $softSkillsUpdate['Reviewer_SoftSkill_5'] ?? ' '
        ];

        $newTechSkills = [
            $techSkillsUpdate['Reviewer_TechSkill_1'] ?? ' ',
            $techSkillsUpdate['Reviewer_TechSkill_2'] ?? ' ',
            $techSkillsUpdate['Reviewer_TechSkill_3'] ?? ' ',
            $techSkillsUpdate['Reviewer_TechSkill_4'] ?? ' ',
            $techSkillsUpdate['Reviewer_TechSkill_5'] ?? ' '
        ];

    // Check if there is any duplicate skill
    $duplicateSoftSkill = array_intersect($existingSoftSkills, $newSoftSkills);
    $duplicateTechSkill = array_intersect($existingTechSkills, $newTechSkills);

    if (!empty($duplicateSoftSkill) || !empty($duplicateTechSkill)) {
        return response()->json([
            'success' => false,
            'message' => 'Duplicate skills found. Please modify and try again.'
        ]);
    }
    }


    $data = [
        'Reviewer_Remark' => $request->revreamrks,
        'Reviewer_PmsStatus' => $status,
        'Reviewer_SubmitedDate' => now(),
        'ReviewerFormAScore' => $reviewerpmsdata['Appraiser']['AppraiserFormAScore'],
        'ReviewerFormBScore' => $reviewerpmsdata['Appraiser']['AppraiserFormBScore'],
        'ReviewerFinallyFormA_Score' => $reviewerpmsdata['Appraiser']['FormAScorePerWeightage'],
        'ReviewerFinallyFormB_Score' => $reviewerpmsdata['Appraiser']['AppraiserFinalScore'],
        'Reviewer_TotalFinalScore' => round($reviewerpmsdata['Appraiser']['TotalFinalScore'],2),
        'Reviewer_TotalFinalRating' => $Emp_TotalFinalRating,
        'Dummy_RevRating' => $Emp_TotalFinalRating, 
        'Reviewer_EmpDesignation' => $degn,
        'Reviewer_EmpGrade' => $gradeprom,
        'Reviewer_SoftSkill_1' => $softSkillsUpdate['Reviewer_SoftSkill_1'] ?? ' ',
        'Reviewer_SoftSkill_2' => $softSkillsUpdate['Reviewer_SoftSkill_2'] ?? ' ',
        'Reviewer_SoftSkill_3' => $softSkillsUpdate['Reviewer_SoftSkill_3'] ?? ' ',
        'Reviewer_SoftSkill_4' => $softSkillsUpdate['Reviewer_SoftSkill_4'] ?? ' ',
        'Reviewer_SoftSkill_5' => $softSkillsUpdate['Reviewer_SoftSkill_5'] ?? ' ',
        'Reviewer_TechSkill_1' => $techSkillsUpdate['Reviewer_TechSkill_1'] ?? ' ',
        'Reviewer_TechSkill_2' => $techSkillsUpdate['Reviewer_TechSkill_2'] ?? ' ',
        'Reviewer_TechSkill_3' => $techSkillsUpdate['Reviewer_TechSkill_3'] ?? ' ',
        'Reviewer_TechSkill_4' => $techSkillsUpdate['Reviewer_TechSkill_4'] ?? ' ',
        'Reviewer_TechSkill_5' => $techSkillsUpdate['Reviewer_TechSkill_5'] ?? ' ',
        'Reviewer_SoftSkill_Oth' => implode(', ', $softSkillsOther),
        'Reviewer_TechSkill_Oth' => implode(', ', $techSkillsOtherdesc),
        'Reviewer_Justification' => $appjust,
    ];
       // Perform the update on the hrm_employee_pms table
       $updated = DB::table('hrm_employee_pms')
       ->where('EmpPmsId', $request->pms_id)
       ->where('EmployeeID', $employeeid)
       ->update($data);

    // Return a response indicating success
    return response()->json(['success' => true, 'message' => 'Data saved Successfully']);

}
public function approvePms(Request $request)
{
   
        $pms = DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $request->empPmsId)
        ->get();
        DB::table('hrm_employee_pms')
        ->where('EmpPmsId', $request->empPmsId)
        ->update([
            'Rev2_Remark' => $request->approvedNote,
            'Rev2_PmsStatus' => '2',
            'Rev2_SubmitedDate' => Carbon::now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Approval updated successfully!']);
    
}
public function revertPms(Request $request)
    {
       

            // Extract data from request
            $empPmsId = $request->empPmsId;
            $revertNote = $request->revertNote;

            // Update the PMS table using Query Builder
            DB::table('hrm_employee_pms')
                ->where('EmpPmsId', $empPmsId)
                ->update([
                    'Reviewer_PmsStatus' => '3',
                    'Rev2_PmsStatus' => '1',
                ]);

            // Return success response
            return response()->json([
                'message' => 'PMS Reverted Successfully!',
            ], 200);
    
}
public function revertPmsRev(Request $request)
    {
       

            // Extract data from request
            $empPmsId = $request->empPmsId;
            $revertNote = $request->revertNote;

            // Update the PMS table using Query Builder
            DB::table('hrm_employee_pms')
                ->where('EmpPmsId', $empPmsId)
                ->update([
                    'Appraiser_PmsStatus' => '3',
                    'Reviewer_PmsStatus' => '1',
                ]);

            // Return success response
            return response()->json([
                'message' => 'PMS Reverted Successfully!',
            ], 200);
    
}
public function revertPmsApp(Request $request)
    {
       

            // Extract data from request
            $empPmsId = $request->empPmsId;
            $revertNote = $request->revertNote;

            // Update the PMS table using Query Builder
            DB::table('hrm_employee_pms')
                ->where('EmpPmsId', $empPmsId)
                ->update([
                    'Emp_PmsStatus' => '1',
                    'Appraiser_PmsStatus' => '3',
                ]);

            // Return success response
            return response()->json([
                'message' => 'PMS Reverted Successfully!',
            ], 200);
    
}
public function getUploadedFiles(Request $request)
{
    $files = DB::table('hrm_employee_pms_uploadfile')
        ->where('EmpPmsId', $request->EmpPmsId)
        ->get(['FileName']);

    return response()->json(['files' => $files]);
}
public function updateEmployeeScore(Request $request)
{
   DB::table('hrm_employee_pms')
            ->where('EmployeeID', $request->employeeId)
            ->where('CompanyId', $request->companyid)
            ->where('AssessmentYear', $request->pmsid)
            ->update([
                'Hod_TotalFinalScore' => $request->score,
                'Hod_TotalFinalRating' => $request->rating,
                'HodRemark' => $request->remarks,
                'HodSubmit_ScoreDate' => now(),
                'HodSubmit_ScoreStatus' => 1

            ]);

        return response()->json(['success' => true, 'message' => 'Updated successfully!']);
}

}
