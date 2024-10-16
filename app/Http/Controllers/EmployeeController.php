<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeGeneral;


class EmployeeController extends Controller
{
    public function getEmployeeDetails($employeeId)
    {

        $employee = Employee::find($employeeId);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        $employeeGeneral = EmployeeGeneral::find($employeeId);
        if (!$employeeGeneral) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json([
            'company_id' => $employee->CompanyId,
            'department_id' => $employeeGeneral->DepartmentId ,
        ]);
    }
}
