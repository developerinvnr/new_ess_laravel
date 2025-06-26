<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;

class LedgerConfirmationController extends Controller
{
    public function show($id)
    {
        $employee = DB::table('hrm_employee_ledger_confirmation as c')
            ->join('hrm_employee as e', 'e.EmployeeID', '=', 'c.EmployeeId')
            ->join('hrm_employee_general as g', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->where('e.EmployeeID', $id)
            ->select(
                'e.EmployeeID',
                DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
                'e.EmpCode as emp_code',
                'd.department_name',
                'c.Year',
                DB::raw("DATE_FORMAT(c.created_at, '%d-%b-%Y, %h:%i %p') as confirmed_at"),
                'c.ip_address',
                'c.ip_details'
            )
            ->orderByDesc('c.created_at')
            ->first();
        if (!$employee) {
            return response()->json(['error' => 'No confirmation found.'], 404);
        }

        $employee->generated_at = Carbon::now()->format('d-M-Y');

        return response()->json($employee);
    }
  
    public function printConfirmation($id)
    {
        // Fetch employee ledger confirmation data (unchanged)
        $employee = DB::table('hrm_employee_ledger_confirmation as c')
            ->join('hrm_employee as e', 'e.EmployeeID', '=', 'c.EmployeeId')
            ->join('hrm_employee_general as g', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->where('e.EmployeeID', $id)
            ->select(
                'e.EmployeeID',
                'e.EmpCode',
                'e.VCode',
                'e.CompanyId as company_id',
                DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
                'd.department_name',
                'c.Year',
                DB::raw("DATE_FORMAT(c.created_at, '%d-%b-%Y, %h:%i %p') as confirmed_at"),
                'c.ip_address'
            )
            ->orderByDesc('c.created_at')
            ->first();

        if (!$employee) {
            abort(404, 'No confirmation found.');
        }

        $employee->generated_at = now()->format('d-M-Y');

        // Define ledger file path on S3
        $prefix = $employee->VCode === 'V' ? '' : 'E';
        $ledgerFile = "{$prefix}{$employee->EmpCode}.pdf";
        // $ledgerRelativePath = "Employee/Emp{$employee->company_id}Lgr/{$employee->Year}/{$ledgerFile}";
        $ledgerRelativePath = 'Employee_Ledger/' . $employee->company_id . '/2024-25' . '/' . $ledgerFile;

        // Check if file exists on S3
        if (!Storage::disk('s3')->exists($ledgerRelativePath)) {
            abort(404, 'Ledger PDF not found.');
        }

        // Get the file as a stream resource
        $stream = Storage::disk('s3')->readStream($ledgerRelativePath);

        $fpdi = new Fpdi();

        try {
            $pageCount = $fpdi->setSourceFile($stream);
        } catch (\Exception $e) {
            abort(500, 'Error loading PDF from S3: ' . $e->getMessage());
        }

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($tplIdx);

            $orientation = isset($size['orientation']) && in_array($size['orientation'], ['P', 'L']) ? $size['orientation'] : 'P';
            $width = $size['width'] ?? 595;
            $height = $size['height'] ?? 842;

            $fpdi->AddPage($orientation, [$width, $height]);
            $fpdi->useTemplate($tplIdx);
        }

        // Current Y position
        $currentY = $fpdi->GetY();

        $safeBottomMargin = 30;
        $estimatedDeclHeight = 180;

        if (($currentY + $estimatedDeclHeight + $safeBottomMargin) < $height) {
            $fpdi->SetXY(20, $currentY + $safeBottomMargin);
        } else {
            $fpdi->AddPage($orientation, [$width, $height]);
            $fpdi->SetXY(20, 20);
        }

        // Declaration content (same as your original code)
        $fpdi->SetFont('Helvetica', 'B', 16);
        $fpdi->Cell(0, 10, "EMPLOYEE LEDGER CONFIRMATION OF FY {$employee->Year}", 0, 1);
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Ln(5);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Employee Name:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->full_name, 0, 1);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Employee Code:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->EmpCode, 0, 1);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Department:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->department_name, 0, 1);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Ledger Period:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, "01-Apr-2024 to 31-Mar-2025", 0, 1);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Confirmation Date:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->confirmed_at, 0, 1);

        $fpdi->Ln(8);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(0, 8, "Declaration:", 0, 1);

        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->MultiCell(0, 8, "I, {$employee->full_name}, have reviewed the attached ledger and confirm that it reflects the correct record of my payroll, claims, advances, and settlements. I confirm the same electronically via the Peepal(ESS) portal.");

        $fpdi->Ln(5);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(0, 8, "Confirmed electronically", 0, 1);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "IP Address/Device:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->ip_address, 0, 1);

        $fpdi->Ln(10);
        $fpdi->SetFont('Helvetica', 'I', 10);
        $fpdi->Cell(0, 6, "Generated by Peepal on {$employee->generated_at}", 0, 1);
        $fpdi->Cell(0, 6, "This document is system-generated and does not require a physical signature.", 0, 1);

        // Output the PDF in browser
        return response($fpdi->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="ledger_confirmation_' . $employee->EmployeeID . '.pdf"');
    }

    // public function printConfirmation($id)
    // {
    //     // Fetch employee ledger confirmation data
    //     $employee = DB::table('hrm_employee_ledger_confirmation as c')
    //         ->join('hrm_employee as e', 'e.EmployeeID', '=', 'c.EmployeeId')
    //         ->join('hrm_employee_general as g', 'g.EmployeeID', '=', 'e.EmployeeID')
    //         ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
    //         ->where('e.EmployeeID', $id)
    //         ->select(
    //             'e.EmployeeID',
    //             'e.EmpCode',
    //             'e.VCode',
    //             'e.CompanyId as company_id',
    //             DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
    //             'd.department_name',
    //             'c.Year',
    //             DB::raw("DATE_FORMAT(c.created_at, '%d-%b-%Y, %h:%i %p') as confirmed_at"),
    //             'c.ip_address'
    //         )
    //         ->orderByDesc('c.created_at')
    //         ->first();

    //     if (!$employee) {
    //         abort(404, 'No confirmation found.');
    //     }

    //     $employee->generated_at = now()->format('d-M-Y');

    //     // Define ledger file path
    //     $prefix = $employee->VCode === 'V' ? '' : 'E';
    //     $ledgerFile = "{$prefix}{$employee->EmpCode}.pdf";
    //     $ledgerRelativePath = "Employee/Emp{$employee->company_id}Lgr/{$employee->Year}/{$ledgerFile}";
    //     $ledgerFilePath = base_path($ledgerRelativePath);

    //     if (!file_exists($ledgerFilePath)) {
    //         abort(404, 'Ledger PDF not found.');
    //     }

    //     $fpdi = new Fpdi();

    //     // Load and render ledger pages
    //     $pageCount = $fpdi->setSourceFile($ledgerFilePath);
    //     for ($i = 1; $i <= $pageCount; $i++) {
    //         $tplIdx = $fpdi->importPage($i);
    //         $size = $fpdi->getTemplateSize($tplIdx);

    //         $orientation = isset($size['orientation']) && in_array($size['orientation'], ['P', 'L']) ? $size['orientation'] : 'P';
    //         $width = $size['width'] ?? 595;
    //         $height = $size['height'] ?? 842;

    //         $fpdi->AddPage($orientation, [$width, $height]);
    //         $fpdi->useTemplate($tplIdx);
    //     }
    //     // Get the current Y position (where last ledger content ended)
    //     $currentY = $fpdi->GetY();

    //     // Define margin from bottom and declaration estimated height
    //     $safeBottomMargin = 30;
    //     $estimatedDeclHeight = 180; // Adjust if you know your declaration height more precisely

    //     // Check if declaration fits on current page
    //     if (($currentY + $estimatedDeclHeight + $safeBottomMargin) < $height) {
    //         // Print declaration just below last content, with margin
    //         $fpdi->SetXY(20, $currentY + $safeBottomMargin);
    //     } else {
    //         // Not enough space, add new page for declaration
    //         $fpdi->AddPage($orientation, [$width, $height]);
    //         $fpdi->SetXY(20, 20); // Reset position for new page
    //     }

    //     // Now print your declaration content here, e.g.:
    //     $fpdi->SetFont('Helvetica', 'B', 16);
    //     $fpdi->Cell(0, 10, "EMPLOYEE LEDGER CONFIRMATION OF FY {$employee->Year}", 0, 1);

    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Ln(5);

    //     // Row-wise data
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Employee Name:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->full_name, 0, 1);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Employee Code:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->EmpCode, 0, 1);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Department:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->department_name, 0, 1);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Ledger Period:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, "01-Apr-2024 to 31-Mar-2025", 0, 1);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Confirmation Date:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->confirmed_at, 0, 1);

    //     $fpdi->Ln(8);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(0, 8, "Declaration:", 0, 1);

    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->MultiCell(0, 8, "I, {$employee->full_name}, have reviewed the attached ledger and confirm that it reflects the correct record of my payroll, claims, advances, and settlements. I confirm the same electronically via the Peepal(ESS) portal.");

    //     $fpdi->Ln(5);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(0, 8, "Confirmed electronically", 0, 1);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "IP Address/Device:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->ip_address, 0, 1);

    //     $fpdi->Ln(10);
    //     $fpdi->SetFont('Helvetica', 'I', 10);
    //     $fpdi->Cell(0, 6, "Generated by Peepal on {$employee->generated_at}", 0, 1);
    //     $fpdi->Cell(0, 6, "This document is system-generated and does not require a physical signature.", 0, 1);

    //     // Output the PDF in browser
    //     return response($fpdi->Output('S'), 200)
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'inline; filename="ledger_confirmation_' . $employee->EmployeeID . '.pdf"');
    // }
    // public function viewConfirmation($id)
    // {
    //     // Same data fetch logic as printConfirmation
    //     $employee = DB::table('hrm_employee_ledger_confirmation as c')
    //         ->join('hrm_employee as e', 'e.EmployeeID', '=', 'c.EmployeeId')
    //         ->join('hrm_employee_general as g', 'g.EmployeeID', '=', 'e.EmployeeID')
    //         ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
    //         ->where('e.EmployeeID', $id)
    //         ->select(
    //             'e.EmployeeID',
    //             'e.EmpCode',
    //             'e.VCode',
    //             'e.CompanyId as company_id',
    //             DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
    //             'd.department_name',
    //             'c.Year',
    //             DB::raw("DATE_FORMAT(c.created_at, '%d-%b-%Y, %h:%i %p') as confirmed_at"),
    //             'c.ip_address'
    //         )
    //         ->orderByDesc('c.created_at')
    //         ->first();

    //     if (!$employee) {
    //         abort(404, 'No confirmation found.');
    //     }

    //     $employee->generated_at = now()->format('d-M-Y');

    //     $prefix = $employee->VCode === 'V' ? '' : 'E';
    //     $ledgerFile = "{$prefix}{$employee->EmpCode}.pdf";
    //     $ledgerRelativePath = "Employee/Emp{$employee->company_id}Lgr/{$employee->Year}/{$ledgerFile}";
    //     $ledgerFilePath = base_path($ledgerRelativePath);

    //     if (!file_exists($ledgerFilePath)) {
    //         abort(404, 'Ledger PDF not found.');
    //     }

    //     $fpdi = new \setasign\Fpdi\Fpdi();
    //     $pageCount = $fpdi->setSourceFile($ledgerFilePath);
    //     for ($i = 1; $i <= $pageCount; $i++) {
    //         $tplIdx = $fpdi->importPage($i);
    //         $size = $fpdi->getTemplateSize($tplIdx);
    //         $orientation = $size['orientation'] ?? 'P';
    //         $width = $size['width'] ?? 595;
    //         $height = $size['height'] ?? 842;

    //         $fpdi->AddPage($orientation, [$width, $height]);
    //         $fpdi->useTemplate($tplIdx);
    //     }

    //     // Add declaration same as before
    //     $currentY = $fpdi->GetY();
    //     $safeBottomMargin = 30;
    //     $estimatedDeclHeight = 180;
    //     if (($currentY + $estimatedDeclHeight + $safeBottomMargin) < $height) {
    //         $fpdi->SetXY(20, $currentY + $safeBottomMargin);
    //     } else {
    //         $fpdi->AddPage($orientation, [$width, $height]);
    //         $fpdi->SetXY(20, 20);
    //     }

    //     $fpdi->SetFont('Helvetica', 'B', 16);
    //     $fpdi->Cell(0, 10, "EMPLOYEE LEDGER CONFIRMATION OF FY {$employee->Year}", 0, 1);
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Ln(5);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Employee Name:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->full_name, 0, 1);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Employee Code:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->EmpCode, 0, 1);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Department:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->department_name, 0, 1);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Ledger Period:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, "01-Apr-2024 to 31-Mar-2025", 0, 1);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "Confirmation Date:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->confirmed_at, 0, 1);
    //     $fpdi->Ln(8);

    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(0, 8, "Declaration:", 0, 1);
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->MultiCell(0, 8, "I, {$employee->full_name}, have reviewed the attached ledger and confirm that it reflects the correct record of my payroll, claims, advances, and settlements. I confirm the same electronically via the Peepal(ESS) portal.");
    //     $fpdi->Ln(5);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(0, 8, "Confirmed electronically", 0, 1);
    //     $fpdi->SetFont('Helvetica', 'B', 12);
    //     $fpdi->Cell(50, 8, "IP Address/Device:");
    //     $fpdi->SetFont('Helvetica', '', 12);
    //     $fpdi->Cell(0, 8, $employee->ip_address, 0, 1);
    //     $fpdi->Ln(10);
    //     $fpdi->SetFont('Helvetica', 'I', 10);
    //     $fpdi->Cell(0, 6, "Generated by Peepal on {$employee->generated_at}", 0, 1);
    //     $fpdi->Cell(0, 6, "This document is system-generated and does not require a physical signature.", 0, 1);

    //     // View (inline) response
    //     return response($fpdi->Output('S'), 200)
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'inline; filename="ledger_confirmation_' . $employee->EmployeeID . '.pdf"')
    //         ->header('Access-Control-Allow-Origin', '*');
    // }
    public function viewConfirmation($id)
    {
        // Fetch employee confirmation data (unchanged)
        $employee = DB::table('hrm_employee_ledger_confirmation as c')
            ->join('hrm_employee as e', 'e.EmployeeID', '=', 'c.EmployeeId')
            ->join('hrm_employee_general as g', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
            ->where('e.EmployeeID', $id)
            ->select(
                'e.EmployeeID',
                'e.EmpCode',
                'e.VCode',
                'e.CompanyId as company_id',
                DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
                'd.department_name',
                'c.Year',
                DB::raw("DATE_FORMAT(c.created_at, '%d-%b-%Y, %h:%i %p') as confirmed_at"),
                'c.ip_address'
            )
            ->orderByDesc('c.created_at')
            ->first();

        if (!$employee) {
            abort(404, 'No confirmation found.');
        }

        $employee->generated_at = now()->format('d-M-Y');
        $prefix = $employee->VCode === 'V' ? '' : 'E';
        $ledgerFile = "{$prefix}{$employee->EmpCode}.pdf";
        $filePath = 'Employee_Ledger/' . $employee->company_id . '/2024-25' . '/' . $ledgerFile;

        // Check file existence on S3
        if (!Storage::disk('s3')->exists($filePath)) {
            abort(404, 'Ledger PDF not found.');
        }

        // Get read stream from S3
        $stream = Storage::disk('s3')->readStream($filePath);

        // Initialize FPDI and set source file from stream
        $fpdi = new Fpdi();

        try {
            $pageCount = $fpdi->setSourceFile($stream);
        } catch (\Exception $e) {
            abort(500, 'Error loading PDF from S3: ' . $e->getMessage());
        }

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($tplIdx);
            $orientation = $size['orientation'] ?? 'P';
            $width = $size['width'] ?? 595;
            $height = $size['height'] ?? 842;

            $fpdi->AddPage($orientation, [$width, $height]);
            $fpdi->useTemplate($tplIdx);
        }

        // Add declaration content (same as before)
        $currentY = $fpdi->GetY();
        $safeBottomMargin = 30;
        $estimatedDeclHeight = 180;
        if (($currentY + $estimatedDeclHeight + $safeBottomMargin) < $height) {
            $fpdi->SetXY(20, $currentY + $safeBottomMargin);
        } else {
            $fpdi->AddPage($orientation, [$width, $height]);
            $fpdi->SetXY(20, 20);
        }

        $fpdi->SetFont('Helvetica', 'B', 16);
        $fpdi->Cell(0, 10, "EMPLOYEE LEDGER CONFIRMATION OF FY {$employee->Year}", 0, 1);
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Ln(5);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Employee Name:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->full_name, 0, 1);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Employee Code:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->EmpCode, 0, 1);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Department:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->department_name, 0, 1);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Ledger Period:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, "01-Apr-2024 to 31-Mar-2025", 0, 1);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "Confirmation Date:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->confirmed_at, 0, 1);
        $fpdi->Ln(8);

        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(0, 8, "Declaration:", 0, 1);
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->MultiCell(0, 8, "I, {$employee->full_name}, have reviewed the attached ledger and confirm that it reflects the correct record of my payroll, claims, advances, and settlements. I confirm the same electronically via the Peepal(ESS) portal.");
        $fpdi->Ln(5);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(0, 8, "Confirmed electronically", 0, 1);
        $fpdi->SetFont('Helvetica', 'B', 12);
        $fpdi->Cell(50, 8, "IP Address/Device:");
        $fpdi->SetFont('Helvetica', '', 12);
        $fpdi->Cell(0, 8, $employee->ip_address, 0, 1);
        $fpdi->Ln(10);
        $fpdi->SetFont('Helvetica', 'I', 10);
        $fpdi->Cell(0, 6, "Generated by Peepal on {$employee->generated_at}", 0, 1);
        $fpdi->Cell(0, 6, "This document is system-generated and does not require a physical signature.", 0, 1);

        // Return PDF inline response
        return response($fpdi->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="ledger_confirmation_' . $employee->EmployeeID . '.pdf"')
            ->header('Access-Control-Allow-Origin', '*');
    }


    public function checkConfirmation(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $year = $request->input('year', date('Y'));

        // Get employee full name
        $employee = DB::table('hrm_employee')
            ->select('Fname', 'Lname', 'Sname')
            ->where('EmployeeId', $employeeId)
            ->first();

        $fullName = $employee ? trim("{$employee->Fname} {$employee->Sname} {$employee->Lname}") : null;

        // Check for confirmation
        $confirmation = DB::table('hrm_employee_ledger_confirmation')
            ->where('EmployeeId', $employeeId)
            ->where('Year', $year)
            ->first();

        if ($confirmation) {
            return response()->json([
                'alreadyConfirmed' => true,
                'confirmationDate' => $confirmation->created_at,
                'fullName' => $fullName
            ]);
        }

        // Get query info
        $query = DB::table('hrm_employee_queryemp')
            ->where('EmployeeID', $employeeId)
            ->where('QuerySubject', 'Ledger Confirmation')
            ->where('QToDepartmentId', 4) // Ledger department
            ->orderBy('QueryDT', 'desc')
            ->first();

        if ($query) {
            $queryHistory = [];
            $hasReply = false;

            $statusLabels = [
                0 => 'Open',
                1 => 'In Process',
                2 => 'Replied',
                3 => 'Closed',
                4 => 'Escalated'
            ];

            // First query
            if ($query->QueryValue) {
                $queryHistory[] = [
                    'text' => $query->QueryValue,
                    'date' => $query->QueryDT,
                    'type' => 'question',
                    'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                ];
            }

            // Replies
            if ($query->QueryReply) {
                $queryHistory[] = [
                    'text' => $query->QueryReply,
                    'date' => $query->QReply2DT,
                    'type' => 'answer',
                    'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                ];
                $hasReply = true;
            } elseif ($query->Level_1ReplyAns) {
                $queryHistory[] = [
                    'text' => $query->Level_1ReplyAns,
                    'date' => $query->Level_1DTReplyAns ?? null,
                    'type' => 'answer',
                    'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                ];
                $hasReply = true;
            }

            // Query2
            if ($query->Query2Value) {
                $queryHistory[] = [
                    'text' => $query->Query2Value,
                    'date' => $query->Query2DT,
                    'type' => 'question',
                    'status' => $statusLabels[$query->QStatus] ?? 'Unknown'
                ];

                if ($query->Query2Reply) {
                    $queryHistory[] = [
                        'text' => $query->Query2Reply,
                        'date' => $query->QReply2DT,
                        'type' => 'answer',
                        'status' => $statusLabels[$query->QStatus] ?? 'Unknown'
                    ];
                    $hasReply = true;
                }
            }

            return response()->json([
                'hasQuery' => true,
                'queryStatus' => ($query->Level_1QStatus == 2 || $query->QueryStatus_Emp == 2),
                'queryHistory' => $queryHistory,
                'canAddNewQuery' => in_array($query->Level_1QStatus, [0, 1, 3]) || in_array($query->QueryStatus_Emp, [0, 1, 3]),
                'hasReply' => $hasReply,
                'latestQueryText' => $query->QueryValue,
                'latestReply' => $query->QueryReply,
                'queryDate' => $query->QueryDT,
                'replyDate' => $query->QReplyDT,
                'fullName' => $fullName,
                'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
            ]);
        }

        return response()->json([
            'alreadyConfirmed' => false,
            'hasQuery' => false,
            'fullName' => $fullName
        ]);
    }
}
