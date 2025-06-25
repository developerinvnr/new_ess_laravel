<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class AssetRequestAllExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $acctStatus;
    protected $fromdate;
    protected $todate;
    protected $empcode;

    public function __construct($acctStatus = null, $fromdate = null, $todate = null, $empcode = null)
    {
        $this->acctStatus = $acctStatus;
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $this->empcode = $empcode;
    }

    public function view(): View
    {

        $assets = \DB::table('hrm_asset_employee_request')
            ->leftJoin('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')
            ->leftJoin('hrm_employee', 'hrm_asset_employee_request.EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee.EmpStatus', 'A')
            ->select(
                'hrm_asset_employee_request.*',
                'hrm_asset_name.AssetName',
                'hrm_employee.Fname',
                'hrm_employee.Sname',
                'hrm_employee.Lname',
                'hrm_employee.EmpCode'
            )
            ->when($this->acctStatus !== null && $this->acctStatus !== '', function ($query) {
                $query->where('hrm_asset_employee_request.AccPayStatus', $this->acctStatus);
            })
            ->when(!empty($this->fromdate), function ($query) {
                $query->where('hrm_asset_employee_request.ReqDate', '>=', $this->fromdate);
            })
            ->when(!empty($this->todate), function ($query) {
                $query->where('hrm_asset_employee_request.ReqDate', '<=', $this->todate);
            })
            ->when($this->empcode !== null && $this->empcode !== '', function ($query) {
                $query->where('hrm_employee.EmpCode', $this->empcode);
            })
            ->orderBy('hrm_asset_employee_request.ReqDate', 'desc')
            ->get();

        return view('exports.asset_requests_excel', ['records' => $assets]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge headers (Row 1)
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');
                $sheet->mergeCells('H1:J1'); // Approval Status
                $sheet->mergeCells('K1:K2');
                $sheet->mergeCells('L1:L2');
                $sheet->mergeCells('M1:M2');
                $sheet->mergeCells('N1:N2');
                $sheet->mergeCells('O1:O2');

                // Header styles
                $sheet->getStyle('A1:O2')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => Color::COLOR_YELLOW],
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(25);
            },
        ];
    }
}
