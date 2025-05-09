<?php

namespace App\Http\Controllers\Export;

use App\Exports\EmployeePromotionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class EmployeePromotionController extends Controller // Extending the correct base controller
{
    public function exportPromotionData(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $pmsYId = $request->input('pms_year_id');
        $department = $request->input('department');
        $grade = $request->input('grade');
        $state = $request->input('state');
        $region = $request->input('region');
    
        return Excel::download(
            new EmployeePromotionExport($employeeId, $pmsYId, $department, $grade, $state, $region),
            'ExportPromotionData.xlsx'
        );
}
}
