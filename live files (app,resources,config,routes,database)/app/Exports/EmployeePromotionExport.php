<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;

class EmployeePromotionExport implements FromView, WithStyles, WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    protected $employeeId, $pmsYId, $department, $grade, $state, $region, $zone, $bu;

    public function __construct($employeeId, $pmsYId, $department = null, $grade = null, $state = null, $region = null, $zone = null, $bu = null)
    {
        $this->employeeId = $employeeId;
        $this->pmsYId = $pmsYId;
        $this->department = $department;
        $this->grade = $grade;
        $this->state = $state;
        $this->region = $region;
        $this->zone = $zone;
        $this->bu = $bu;
    }
    public function view(): View
    {
        $Mang_EmployeeID = DB::table('hrm_employee_pms')
            ->where('HOD_EmployeeID', $this->employeeId)
            ->where('AssessmentYear', $this->pmsYId)
            ->pluck('EmployeeID');


        $query = DB::table('hrm_employee_general as emp')
            ->leftJoin('core_departments as dept', 'emp.DepartmentId', '=', 'dept.id')
            ->leftJoin('hrm_employee as empp', 'emp.EmployeeID', '=', 'empp.EmployeeID')
            ->leftJoin('core_city_village_by_state as hq', 'emp.HqId', '=', 'hq.id')
            ->leftJoin('core_grades as grade', 'emp.GradeId', '=', 'grade.id')
            ->leftJoin('core_designation as desig', 'emp.DesigId', '=', 'desig.id')
            ->leftJoin('core_regions as region', 'emp.RegionId', '=', 'region.id')
            ->leftJoin('hrm_employee_pms as pms', function ($join) {
                $join->on('emp.EmployeeID', '=', 'pms.EmployeeID')
                    ->where('pms.HOD_EmployeeID', '=', $this->employeeId)
                    ->where('pms.AssessmentYear', '=', $this->pmsYId);
            })
            ->leftJoin('core_designation as app_desig', 'pms.Appraiser_EmpDesignation', '=', 'app_desig.id')
            ->leftJoin('core_designation as rev_desig', 'pms.Reviewer_EmpDesignation', '=', 'rev_desig.id')
            ->leftJoin('core_designation as hod_desig', 'pms.Hod_EmpDesignation', '=', 'hod_desig.id')
            ->leftJoin('core_grades as app_grade', 'pms.Appraiser_EmpGrade', '=', 'app_grade.id')
            ->leftJoin('core_grades as rev_grade', 'pms.Reviewer_EmpGrade', '=', 'rev_grade.id')
            ->leftJoin('core_grades as hod_grade', 'pms.Hod_EmpGrade', '=', 'hod_grade.id')
            ->leftJoin('core_grades as hr_grade', 'pms.HR_CurrGradeId', '=', 'hr_grade.id')
            ->leftJoin('core_zones as zones', 'emp.ZoneId', '=', 'zones.id')
            ->leftJoin('core_business_unit as bu', 'emp.BUId', '=', 'bu.id')
            ->leftJoin('core_designation as hr_desig', 'pms.HR_CurrDesigId', '=', 'hr_desig.id')
            ->leftJoin('hrm_employee as app', 'pms.Appraiser_EmployeeID', '=', 'app.EmployeeID')
            ->leftJoin('hrm_employee as rev', 'pms.Appraiser_EmployeeID', '=', 'rev.EmployeeID')
            ->leftJoin('hrm_employee as rev2', 'pms.Rev2_EmployeeID', '=', 'rev2.EmployeeID')
            ->whereIn('emp.EmployeeID', $Mang_EmployeeID)
            ->where('empp.EmpStatus', 'A');
        $detailss = $query->select(
            'empp.EmployeeID',
            'empp.EmpCode',
            'empp.Fname',
            'empp.Sname',
            'empp.Lname',
            'dept.department_name',
            'grade.grade_name',
            'region.region_name',
            'zones.id as zone_id',
            'bu.id as bu_id',
            'desig.designation_name',
            'app_desig.designation_name as Appraiser_Designation',
            'app_grade.grade_name as Appraiser_Grade',
            'rev_desig.designation_name as Reviewer_Designation',
            'rev_grade.grade_name as Reviewer_Grade',
            'hr_desig.designation_name as HR_Designation',
            'hr_grade.grade_name as HR_Grade',
            'hod_grade.grade_name as Hod_Grade',
            'hod_desig.designation_name as Hod_Designation',
        )
            ->get();

        // 🔍 Optional filters by department and grade name
        $details = $detailss->filter(function ($item) {
            $match = true;

            if (!empty($this->department)) {
                $match = $match && (strcasecmp(trim($item->department_name), trim($this->department)) === 0);
            }

            if (!empty($this->grade)) {
                $match = $match && (strcasecmp(trim($item->grade_name), trim($this->grade)) === 0);
            }
           
            if (!empty($this->region)) {
                $match = $match && (strcasecmp(trim($item->region_name), trim($this->region)) === 0);
            }

            // ZONE
            if (!empty($this->zone) && strtolower($this->zone) !== 'undefined' && strtolower($this->zone) !== 'null') {
                $match = $match && (trim((string)$item->zone_id) === trim((string)$this->zone));
            }

            // BU
            if (!empty($this->bu) && strtolower($this->bu) !== 'undefined' && strtolower($this->bu) !== 'null') {
                $match = $match && (trim((string)$item->bu_id) === trim((string)$this->bu));
            }

            return $match;
        })->values(); // Reset keys

        return view('exports.employeepromotionmanagement', compact('details'));
    }

    // Apply styles to specific columns
    public function styles($sheet)
    {
        return [
            // Applying styles to header row
            1    => ['font' => ['bold' => true]],
        ];
    }
    public function startCell(): string
    {
        return 'A3'; // Start data from row 3, because headings take row 1 and 2
    }

    // Define headings for the Excel export
    public function headings(): array
    {
        return [
            // Row 1
            [
                'SN.',
                'Employee',
                '',
                '',
                '',
                'Appraiser [Proposed]',
                '',
                'Reviewer [Proposed]',
                '',
                'Management [Proposed]',
                '',
                '',
                'Action',
            ],
            // Row 2
            [
                '',
                'EC',
                'Name',
                'Department',
                'Grade',
                'Designation',
                'Grade',
                'Designation',
                'Grade',
                'Designation',
                'Grade',
                'Remarks',
                '',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge header cells
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:E1');
                $sheet->mergeCells('F1:G1');
                $sheet->mergeCells('H1:I1');
                $sheet->mergeCells('J1:L1');
                $sheet->mergeCells('M1:M2');

                // Define header range
                $headerRange = 'A1:M2';

                // Apply header styles
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFont()->setSize(12);
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($headerRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // ✅ Apply background color to the header
                $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle($headerRange)->getFill()->getStartColor()->setARGB(Color::COLOR_YELLOW); // Change color if needed

                // ✅ Fix "SN." column
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(25);
            },
        ];
    }


    // Column formatting (e.g., date, number formatting)
    public function columnFormats(): array
    {
        return [
            'F' => 'yyyy-mm-dd', // Assuming column F contains dates, adjust according to your column structure
            'G' => '#,##0.00',    // Format column G as currency, adjust as needed
        ];
    }
}
