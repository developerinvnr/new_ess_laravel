<?php

namespace App\Http\Controllers\Export;

use App\Exports\ApprovedEmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class LogisticsExportController extends Controller // Extending the correct base controller
{
    public function exportApprovedEmployees()
    {
        return Excel::download(new ApprovedEmployeesExport, 'approved_employees_logistics.xlsx');
    }
}
