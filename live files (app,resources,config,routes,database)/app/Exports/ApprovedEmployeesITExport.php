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


class ApprovedEmployeesITExport implements FromView, WithStyles, WithColumnFormatting, WithHeadings,ShouldAutoSize
{
    public function view(): View
    {
         // Fetching approved employees with additional employee details
         $approvedEmployees = \DB::table('hrm_employee_separation as es')
         ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // join to fetch employee details
         ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // join to fetch general employee details
         ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // join to fetch department name
         ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
         ->orderBy('es.Emp_ResignationDate', 'desc')
         ->select(
             'es.*',
             'e.Fname',  // First name
             'e.Lname',  // Last name
             'e.Sname',  // Surname
             'e.EmpCode',  // Employee Code
             'd.department_name',  // Department name
             'eg.EmailId_Vnr',  // Email ID from the employee general table
             'dg.designation_name'  // Designation name
         )
         ->get(); // Paginate the results

        return view('exports.approved_employees_it', compact('approvedEmployees'));
    }

    // Apply styles to specific columns
    public function styles($sheet)
    {
        return [
            // Applying styles to header row
            1    => ['font' => ['bold' => true]],
        ];
    }

    // Define headings for the Excel export
    public function headings(): array
    {
        return [
            'Employee ID', 'First Name', 'Last Name', 'Surname', 'Employee Code', 'Department', 'Email ID', 'Designation',
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

