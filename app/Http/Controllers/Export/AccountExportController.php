<?php

namespace App\Http\Controllers\Export;

use App\Exports\ApprovedEmployeesAcctExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class AccountExportController extends Controller // Extending the correct base controller
{
    public function exportApprovedEmployees()
    {
        return Excel::download(new ApprovedEmployeesAcctExport, 'approved_employees_account.xlsx');
    }
}
