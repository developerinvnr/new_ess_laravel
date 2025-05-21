<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IncrementExport implements FromView
{
    protected $type,$employeeId, $pmsYId, $department, $grade,$region, $hod , $rev;

    public function __construct($type, $employeeId, $pmsYId, $department = null, $grade = null, $region = null, $hod = null, $rev = null)
        {
            $this->employeeId = $employeeId;
            $this->pmsYId = $pmsYId;
            $this->department = $department;
            $this->grade = $grade;
            $this->region = $region;
            $this->hod = $hod;
            $this->rev = $rev;
            $this->type = $type;
        }


    public function view(): View
    {
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
            $effDate = $year_pms->EffectedDate2; // e.g., 2021-01-01
            $allowDoj = $year_pms->AllowEmpDoj;
          
            $prevFromEffDate = date('Y-m-d', strtotime('-1 day', strtotime($effDate)));
            $effDM = date('m-d', strtotime($effDate));
            $minMD = date('m-d', strtotime($prevFromEffDate));
            $extraOneD = date('Y-m-d', strtotime('+1 day', strtotime($allowDoj)));
            $extraOneMD = date('m-d', strtotime($extraOneD));
            $prvY = date('Y', strtotime($allowDoj));
            $prvMD = date('m-d', strtotime($allowDoj));
            $cY = $prvY;
            $pY = $prvY - 1;
            $employeesnewfilter = DB::table('hrm_employee_pms as p')
            ->join('hrm_employee as e', 'p.EmployeeID', '=', 'e.EmployeeID')
            ->join('hrm_employee_general as g', 'p.EmployeeID', '=', 'g.EmployeeID')
            ->leftJoin('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->leftJoin('core_designation as de', 'g.DesigId', '=', 'de.id')
            ->leftJoin('core_grades as gr', 'g.GradeId', '=', 'gr.id')
            ->join('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id')
            ->leftJoin('core_regions as region', 'g.RegionId', '=', 'region.id')
            ->leftJoin('hrm_employee as hod', 'p.Rev2_EmployeeID', '=', 'hod.EmployeeID')
            ->leftJoin('hrm_employee as rev', 'p.Reviewer_EmployeeID', '=', 'rev.EmployeeID')
            ->where('e.EmpStatus', 'A')
            ->where('g.DateJoining', '<=', $allowDoj)
            ->where('p.AssessmentYear', $PmsYId)
            ->where('p.HOD_EmployeeID', $this->employeeId)
            ->select([
                'e.EmployeeID',
                'e.CompanyId',
                'e.EmpCode',
                DB::raw("CONCAT(e.Fname, ' ',e.Sname, ' ',e.Lname) as FullName"),
                'DateJoining',
                'g.EmpVertical',
                'g.EmpSection',
                'department_name',
                'designation_name',
                'designation_code',
                'd.department_code',
                'grade_name',
                'EmpCurrGrossPM',
                'EmpCurrCtc',
                'EmpCurrAnnualBasic',
                'Hod_TotalFinalScore',
                'Hod_TotalFinalRating',
                'EmpPmsId',
                'Hod_EmpDesignation',
                'Hod_EmpGrade',
                'HodSubmit_IncStatus',
                'HR_CurrGradeId',
                'EmpCurrCommunicationAlw',
                'EmpCurrCarAlw',
                'variablepayest',
                'totactctcwithcarpayest',
                'totgrosswithaddingest',
                'HR_Curr_DepartmentId',
                'region.region_name',
                'gr.id',
                'hod.EmployeeID as HodID',
                DB::raw("TRIM(CONCAT(hod.Fname, ' ', IFNULL(hod.Sname, ''), ' ', hod.Lname)) as HodName"),
                DB::raw("TRIM(CONCAT(rev.Fname, ' ', IFNULL(rev.Sname, ''), ' ', rev.Lname)) as RevName")
            ])
            ->orderBy('e.ECode', 'asc')
            ->get();
         $employees = $employeesnewfilter->filter(function ($item) {
                $match = true;

                if (!empty($this->department) && strtolower($this->department) !== 'undefined' && strtolower($this->department) !== 'null' && !empty($item->department_code)) {
                    $match = $match && (strcasecmp(trim($item->department_code), trim($this->department)) === 0);
                }

                if (!empty($this->grade) && strtolower($this->grade) !== 'undefined' && strtolower($this->grade) !== 'null' && !empty($item->grade_name)) {
                    $match = $match && (strcasecmp(trim($item->grade_name), trim($this->grade)) === 0);
                }

                if (!empty($this->region) && strtolower($this->region) !== 'undefined' && strtolower($this->region) !== 'null' && !empty($item->region_name)) {
                    $match = $match && (strcasecmp(trim($item->region_name), trim($this->region)) === 0);
                }

                if (!empty($this->hod) && strtolower($this->hod) !== 'undefined' && strtolower($this->hod) !== 'null') {
                    if (empty($item->HodName)) {
                        $match = false; // exclude if item has no HodName
                    } else {
                        $cleanHodName = preg_replace('/\s+/', ' ', trim($item->HodName));
                        $cleanFilterHod = preg_replace('/\s+/', ' ', trim($this->hod));
                        $match = $match && (strcasecmp($cleanHodName, $cleanFilterHod) === 0);
                    }
                }

                if (!empty($this->rev) && strtolower($this->rev) !== 'undefined' && strtolower($this->rev) !== 'null') {
                    if (empty($item->RevName)) {
                        $match = false; // exclude if item has no RevName
                    } else {
                        $cleanRevName = preg_replace('/\s+/', ' ', trim($item->RevName));
                        $cleanFilterRev = preg_replace('/\s+/', ' ', trim($this->rev));
                        $match = $match && (strcasecmp($cleanRevName, $cleanFilterRev) === 0);
                    }
                }

                return $match;
            })->values();


            $baseQueryMain = collect(); // ← Initialize here
            foreach ($employees as $res) {
                  $datanew = null;
         
                  $qsub = [];
          

                // Base query
                $baseQuery = DB::table('hrm_employee_pms')
                    ->where([
                        ['HOD_EmployeeID', '=', $this->employeeId],
                        ['AssessmentYear', '=', $PmsYId],
                        ['EmployeeID', '=', $res->EmployeeID],
                        ['CompanyId', '=', $res->CompanyId],

                    ])
                    ->where($qsub);

                $entries = $baseQuery->get();

                if ($entries->count() === 1) {
                    $datanew = $entries->first();
                } elseif ($entries->count() >= 2) {
                    $datanew = DB::table('hrm_employee_pms')
                        ->where([
                            ['HOD_EmployeeID', '=', $this->employeeId],
                            ['AssessmentYear', '=', $PmsYId],
                            ['EmployeeID', '=', $res->EmployeeID],
                            ['CompanyId', '=', $res->CompanyId],

                        ])
                        ->first();

                    if (!$datanew) {
                        $datanew = DB::table('hrm_employee_pms')
                            ->where([
                                ['HOD_EmployeeID', '=', $this->employeeId],
                                ['AssessmentYear', '=', $PmsYId],
                                ['empid', '=', $res->EmployeeID],
                                ['CompanyId', '=', $res->CompanyId],

                            ])
                            ->first();
                    }
                }
                $Eprodata = $Eactual = $Ectc = $Ecorr = $Ecorr_per = $Einc = $Etotctc = $Etotctc_per = 0;
                if (!empty($datanew)) {
                    $Eprodata = $datanew->Hod_ProRataInc_Per;
                    $Eactual = $datanew->Hod_ActualInc_Per;
                    $Ectc = $datanew->Hod_ProIncCTC;
                    $Ecorr = $datanew->Hod_ProCorrCTC;
                    $Ecorr_per = $datanew->Hod_Percent_ProCorrCTC;
                    $Einc = $datanew->Hod_IncNetCTC;
                    $Etotctc = $datanew->Hod_Proposed_ActualCTC;
                    $Etotctc_per = $datanew->Hod_Percent_IncNetCTC;
                }

                $MxCrDate = '';
                $MxCrPer = '';
                $MxGrDate = '';
                $GrChangeBg = '';
                
                // --- 1. Grade Change Date ---
                $gradeChange = DB::table('hrm_pms_appraisal_history')
                    ->select('SalaryChange_Date')
                    ->where('EmpCode', $res->EmpCode)
                    ->where('CompanyId', $CompanyId)
                    ->where('Current_Grade', '!=', $res->grade_name)
                    ->orderByDesc('AppHistoryId')
                    ->first();

                if ($gradeChange) {
                    $MxGrDate = Carbon::parse($gradeChange->SalaryChange_Date)->format('M-y');
                    $gradeYear = Carbon::parse($gradeChange->SalaryChange_Date)->format('Y');
                    if ($gradeYear >= date('Y') - 1) {
                        $GrChangeBg = '#ede1ed';
                    }
                }

                // --- 2. Proportional Correction Percentage ---
                $correction = DB::table('hrm_pms_appraisal_history')
                    ->select('SalaryChange_Date', 'ProCorrCTC', 'Percent_ProCorrCTC')
                    ->where('EmpCode', $res->EmpCode)
                    ->where('CompanyId', $CompanyId)
                    ->where('Percent_ProCorrCTC', '>', 0)
                    ->orderByDesc('AppHistoryId')
                    ->first();

                if ($correction) {
                    $MxCrDate = Carbon::parse($correction->SalaryChange_Date)->format('M-y');
                    $MxCrPer = $correction->Percent_ProCorrCTC;
                } else {
                    $correctionAlt = DB::table('hrm_pms_appraisal_history')
                        ->select('SalaryChange_Date', 'PropSalary_Correction', 'Previous_GrossSalaryPM')
                        ->where('EmpCode', $res->EmpCode)
                        ->where('CompanyId', $CompanyId)
                        ->where('PropSalary_Correction', '>', 0)
                        ->orderByDesc('AppHistoryId')
                        ->first();

                    if ($correctionAlt) {
                        $MxCrDate = Carbon::parse($correctionAlt->SalaryChange_Date)->format('M-y');

                        $prevGross = (float)$correctionAlt->Previous_GrossSalaryPM ?: 1;
                        $MxCrPer = round(($correctionAlt->PropSalary_Correction / ($prevGross / 100)), 2);
                    }
                }         
                
         
                if($this->type == 'data'){

                    $employeeTableData[] = [
                        'EmployeeID' => $res->EmployeeID,
                        'EmpCode' => $res->EmpCode,
                        'CompanyID' => $res->CompanyId,
                        'FullName' => $res->FullName,
                        'DateJoining' => $res->DateJoining,
                        'Department' => $res->department_name,
                        'Designation' => $res->designation_name,
                        'Grade' => $res->grade_name,
                        'GradeChangeYear' => '', // Set this if available
                        'LastCorrectionPer' => 0, // Placeholder if not computed
                        'LastCorrectionYear' => '', // Placeholder
                        'PrevFixed' => $res->EmpCurrCtc,
                        'Rating' => $res->Hod_TotalFinalRating,
                        'ProDesignation' => $designation->designation_name ?? '',
                        'ProGrade' => $grade->grade_name ?? '',
                        'ProRata' => $Eprodata,
                        'Actual' => $Eactual,
                        'CTC' => $Ectc,
                        'Corr' => $Ecorr,
                        'CorrPer' => $Ecorr_per,
                        'Inc' => $Einc,
                        'TotalCTC' => $Etotctc,
                        'TotalCTCPer' => $Etotctc_per,
                        'MxCrDate' => $MxCrDate,
                        'MxCrPer' => $MxCrPer,
                        'MxGrDate' => $MxGrDate,
                        'GrChangeBg' => $GrChangeBg,
                        'depid'=>$res->HR_Curr_DepartmentId,
                        'variablepayest'=>$res->variablepayest,
                        'totactctcwithcarpayest'=>$res->totactctcwithcarpayest,
                        'EmpCurrCarAlw'=>$res->EmpCurrCarAlw,
                        'EmpCurrCommunicationAlw'=>$res->EmpCurrCommunicationAlw,
                        'totgrosswithaddingest'=>$res->totgrosswithaddingest,
                    ];
                    $department = DB::table('core_departments')
                            ->where('department_code', $this->department)
                            ->first();

                        if ($department) {
                            $baseQueryMain = DB::table('hrm_pms_workingsheet')
                                ->where([
                                    ['hodid', '=', $this->employeeId],
                                    ['yearid', '=', $this->pmsYId],
                                    ['deptid', '=', $department->id],
                                    ['typeid', '=', 'main'],
                                ])
                                ->get();
                        } else {
                            // return an empty collection to avoid errors
                            $baseQueryMain = collect();
                        }

                }
                if($this->type == 'blank'){

                    $employeeTableData[] = [
                        'EmployeeID' => $res->EmployeeID,
                        'EmpCode' => $res->EmpCode,
                        'CompanyID' => $res->CompanyId,
                        'FullName' => $res->FullName,
                        'DateJoining' => $res->DateJoining,
                        'Department' => $res->department_name,
                        'Designation' => $res->designation_name,
                        'Grade' => $res->grade_name,
                        'GradeChangeYear' => '', // Set this if available
                        'LastCorrectionPer' => 0, // Placeholder if not computed
                        'LastCorrectionYear' => '', // Placeholder
                        'PrevFixed' => $res->EmpCurrCtc,
                        'Rating' => $res->Hod_TotalFinalRating,
                        'ProDesignation' => $designation->designation_name ?? '',
                        'ProGrade' => $grade->grade_name ?? '',
                        'ProRata' => '0',
                        'Actual' => '0',
                        'CTC' => '0',
                        'Corr' => '0',
                        'CorrPer' => '0',
                        'Inc' => '0',
                        'TotalCTC' => '0',
                        'TotalCTCPer' => '0',
                        'MxCrDate' => $MxCrDate,
                        'MxCrPer' => $MxCrPer,
                        'MxGrDate' => $MxGrDate,
                        'GrChangeBg' => $GrChangeBg,
                        'depid'=>$res->HR_Curr_DepartmentId,
                        'variablepayest'=>$res->variablepayest,
                        'totactctcwithcarpayest'=>$res->totactctcwithcarpayest,
                        'EmpCurrCarAlw'=>$res->EmpCurrCarAlw,
                        'EmpCurrCommunicationAlw'=>$res->EmpCurrCommunicationAlw,
                        'totgrosswithaddingest'=>$res->totgrosswithaddingest,
                    ];
                    $department = DB::table('core_departments')
                            ->where('department_code', $this->department)
                            ->first();

                    if ($department) {
                        // return an empty collection to avoid errors
                        $baseQueryMain = collect();
                    
                    }
                }
            }

                return view('exports.increment', [
                    'employeeTableData' => $employeeTableData,
                    'baseQueryMain'=>$baseQueryMain
                ]);
        }
}

