<?php

namespace App\Http\Controllers\Export;

use App\Exports\ApprovedEmployeesITExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class ITExportController extends Controller // Extending the correct base controller
{
    public function exportApprovedEmployees()
    {
        return Excel::download(new ApprovedEmployeesITExport, 'approved_employees_IT.xlsx');
    }
}
