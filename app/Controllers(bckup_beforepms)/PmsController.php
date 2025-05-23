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
        $KraYIdNew = $year_kra->NewY;

        // Fetch year details
        $year_kra_details = DB::table('hrm_year')->where('YearId', $KraYId)->first();
        $year_kra_details_new = DB::table('hrm_year')->where('YearId', $KraYIdNew)->first();

        $year_pms_details = DB::table('hrm_year')->where('YearId', $PmsYId)->first();

        // Calculate the years based on FromDate and ToDate for KRA
        $kf = Carbon::parse($year_kra_details->FromDate)->format('Y'); // Year from KRA FromDate
        $kt = Carbon::parse($year_kra_details->ToDate)->format('Y'); // Year from KRA ToDate
        $kt2 = $kf - 1; // Previous year of KRA

        $kfnew = Carbon::parse($year_kra_details_new->FromDate)->format('Y'); // Year from KRA FromDate
        $ktnew = Carbon::parse($year_kra_details_new->ToDate)->format('Y'); // Year from KRA ToDate

        // Calculate the years based on FromDate and ToDate for PMS
        $pf = Carbon::parse($year_pms_details->FromDate)->format('Y'); // Year from PMS FromDate
        $pt = Carbon::parse($year_pms_details->ToDate)->format('Y'); // Year from PMS ToDate
        $pt2 = $pf - 1; // Previous year of PMS


        if ($CompanyId == 1) {
            // For CompanyId 1, store the years without the range
            $KraYear = $kf . '-' . $kt;
            $PmsYear = $pf;
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

        // Fetch Logic Data
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
        $CuDate = now()->format('Y-m-d');

        $formattedDOJ = date('Y-m-d', strtotime($dateJoining));

        return view("employee.pms", compact(
            'data','ktnew','kfnew',
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
            'KraYear',
            'PmsYear',
            'functionName',
            'kraWithSubs',
            'kraListold',
            'old_year',
            'year_kra',
            'logicData',
            'kraData','formattedDOJ','CuDate',
            'kraDatalastrevert','KraYIdCurr',
            'kra_schedule_data_employee'
        ));

        // return view("employee.pms");
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
        $year_kra = DB::table('hrm_pms_setting')->where('CompanyId', $CompanyId)->where('Process', 'KRA')->first();

        // Pass everything to the view
        return view("employee.appraiser", compact('exists_appraisel','KraYear','ktnew','kfnew',
        'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 'KraYId', 'logicData', 'year_kra','KraYIdCurr'));
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
        return view("employee.reviewer", compact('exists_appraisel','KraYear','ktnew','kfnew',
        'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 'KraYId', 'logicData', 'year_kra','KraYIdCurr'));
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

        // Pass everything to the view
        return view("employee.hod", compact('exists_appraisel', 
        'exists_reviewer', 'exists_hod', 'exists_mngmt', 'employeeDetails', 'KraYId', 'logicData', 'year_kra','KraYIdCurr'));
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

    public function getDetails(Request $request)
    {
        $kraId = $request->get('kraId');
        $subKraId = $request->get('subKraId');
        $CompanyId = Auth::user()->CompanyId;
        $employeeId = Auth::user()->EmployeeID;
        $yearId = $request->get('year_id'); // Pass the year_id to determine period type
        $kraData = null;
        $subKraData = null;
        $subKraDatamain = null;

        if ($kraId) {
            // Fetch KRA data
            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                ->where('KRAId', $kraId)
                ->orderBy('Ldate')
                ->get();

            $subKraDatamain = DB::table('hrm_pms_kra')
                ->where('KRAId', $kraId)
                ->select('Logic', 'KRA', 'KRA_Description', 'Weightage', 'Period', 'Target')
                ->first();
        } elseif ($subKraId) {
            // Fetch SubKRA data
            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                ->where('KRASubId', $subKraId)
                ->orderBy('Ldate')
                ->get();

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
                            'NtgtN' => 1,
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
                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraDatamain->Period == 'Quarter') {
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
                            'NtgtN' => 1,
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
                    }
                }


                // HALF-YEARLY DISTRIBUTION
                if ($subKraDatamain->Period == '1/2 Annual') {
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
                            'NtgtN' => 1,
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
                    }
                }
                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                    ->where('KRAId', $kraId)
                    ->orWhere('KRASubId', $subKraId)
                    ->orderBy('Ldate')
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
                            'NtgtN' => 1,
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
                    }
                }

                // QUARTERLY DISTRIBUTION
                if ($subKraData->Period == 'Quarter') {
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
                            'NtgtN' => 1,
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
                    }
                }


                // HALF-YEARLY DISTRIBUTION
                if ($subKraData->Period == '1/2 Annual') {
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
                            'NtgtN' => 1,
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
                    }
                }
                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                // Fetch the newly inserted data
                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                    ->where('KRAId', $kraId)
                    ->orWhere('KRASubId', $subKraId)
                    ->orderBy('Ldate')
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
                        if($deletemonthly){
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
                                        'NtgtN' => 1,
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
                                }
                            }
            
                            // QUARTERLY DISTRIBUTION
                            if ($subKraDatamain->Period == 'Quarter') {
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
                                        'NtgtN' => 1,
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
                                }
                            }
            
                            DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                            // Fetch the newly inserted data
                            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->orWhere('KRASubId', $subKraId)
                                ->orderBy('Ldate')
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
                            if($deleteHalf){
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
                                            'NtgtN' => 1,
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
                                    }
                                }
                    
                                // HALF-YEARLY DISTRIBUTION
                                if ($subKraDatamain->Period == '1/2 Annual') {
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
                                            'NtgtN' => 1,
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
                                    }
                                }
                                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                                // Fetch the newly inserted data
                                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                    ->where('KRAId', $kraId)
                                    ->orWhere('KRASubId', $subKraId)
                                    ->orderBy('Ldate')
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
                        if($deleteHalf){
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
                                        'NtgtN' => 1,
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
                                }
                            }
                
                
                            // HALF-YEARLY DISTRIBUTION
                            if ($subKraDatamain->Period == '1/2 Annual') {
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
                                        'NtgtN' => 1,
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
                                }
                            }
                            DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                            // Fetch the newly inserted data
                            $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                ->where('KRAId', $kraId)
                                ->orWhere('KRASubId', $subKraId)
                                ->orderBy('Ldate')
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
                                if($deletemonthly){
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
                                            'NtgtN' => 1,
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
                                    }
                                }

                                // QUARTERLY DISTRIBUTION
                                if ($subKraData->Period == 'Quarter') {
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
                                            'NtgtN' => 1,
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
                                    }
                                }

                                DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                                // Fetch the newly inserted data
                                $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                    ->where('KRAId', $kraId)
                                    ->orWhere('KRASubId', $subKraId)
                                    ->orderBy('Ldate')
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
                              if($deletemonthly){
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
                                          'NtgtN' => 1,
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
                                  }
                              }

                              // HALF-YEARLY DISTRIBUTION
                              if ($subKraData->Period == '1/2 Annual') {
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
                                          'NtgtN' => 1,
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
                                  }
                              }
                              DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                              // Fetch the newly inserted data
                              $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                  ->where('KRAId', $kraId)
                                  ->orWhere('KRASubId', $subKraId)
                                  ->orderBy('Ldate')
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
                              if($deletemonthly){
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
                                          'NtgtN' => 1,
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
                                  }
                              }


                              // HALF-YEARLY DISTRIBUTION
                              if ($subKraData->Period == '1/2 Annual') {
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
                                          'NtgtN' => 1,
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
                                  }
                              }
                              DB::table('hrm_pms_kra_tgtdefin')->insert($periods);
                              // Fetch the newly inserted data
                              $kraData = DB::table('hrm_pms_kra_tgtdefin')
                                  ->where('KRAId', $kraId)
                                  ->orWhere('KRASubId', $subKraId)
                                  ->orderBy('Ldate')
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
            'subKraDatamain' => $subKraDatamain,
        ], 200);
    }
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
                ->where('AssessmentYear', $KraYId)
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
                   
                            Mail::to($Appraisaremail)->send(new EmployeeKRAFillRepo($details));
                      
                }
                
                // Check if Employee email exists before sending the mail
                if (!empty($EmpMailid)) {
                  
                            Mail::to($EmpMailid)->send(new EmployeeKRAFill($details));
                      
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
                    'UseKRA' => 'R',
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
                ->where('AssessmentYear', $KraYId)
                ->where('CompanyId', $CompanyId)
                ->first();

        $Reviewer_EmployeeID = $employeeAppraisal->Reviewer_EmployeeID ?? null; // Use null coalescing operator for safety


        $details = [
            'subject'=>'KRA Submission Status.',
            'EmpName'=> $Empname,
            'site_link' => "vnrseeds.co.in"             
        ];
       
                Mail::to($EmpMailid)->send(new Appraisal($details));
          

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
               ->where('AssessmentYear', $KraYId)
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
        
                Mail::to($EmpMailid)->send(new Appraisal($details));
          

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
               ->where('AssessmentYear', $KraYId)
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
        
                Mail::to($Arevieweremail)->send(new HOD($details));
         

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
            
                    Mail::to($EmpMailid)->send(new AppraisalRevert($details));
              


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
             ->where('AssessmentYear', $request->yearId)
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
           
                    Mail::to($Arevieweremail)->send(new ReviewerRevert($details));
               

    
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
            ->where('AssessmentYear', $request->yearId)

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
            
                    Mail::to($Arevieweremail)->send(new HODRevert($details));
             
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

}
