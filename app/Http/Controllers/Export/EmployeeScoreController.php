<?php

namespace App\Http\Controllers\Export;

use App\Exports\EmployeeScoreExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class EmployeeScoreController extends Controller // Extending the correct base controller
{
    public function exportScoreData(Request $request)
    {

        $employeeId = $request->input('employee_id');
        $pmsYId = $request->input('pms_year_id');
        $department = $request->input('department');
        $grade = $request->input('grade');
        $state = $request->input('state');
        $region = $request->input('region');
    
        return Excel::download(new EmployeeScoreExport($employeeId, $pmsYId, $department, $grade, $state, $region), 'ExportScoreData.xlsx');
    }
}
