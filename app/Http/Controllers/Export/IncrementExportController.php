<?php

namespace App\Http\Controllers\Export;

use App\Exports\IncrementExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class IncrementExportController extends Controller
{
   
    public function export(Request $request, $type)
    {

        $employeeId = $request->input('employee_id');
        $pmsYId = $request->input('pms_year_id');
        $department = $request->input('department');
        $grade = $request->input('grade');
        $region = $request->input('region');
        $hod = $request->input('hod');
        $rev = $request->input('rev');

    
        // Dynamically choose file name based on type
        $fileName = ($type === 'data') ? 'Increment_WithData.xlsx' : 'Increment_Blank.xlsx';

        return Excel::download(new IncrementExport($type, $employeeId, $pmsYId, $department, $grade,$region,$hod,$rev), $fileName);
    }
}
