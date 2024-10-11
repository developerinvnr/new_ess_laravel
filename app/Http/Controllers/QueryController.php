<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepartmentSubject;
use App\Models\EmployeeReporting;
use App\Models\QueryMapEmp;
use App\Models\EmployeeGeneral;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use App\Mail\QuerySubmitted;



class QueryController extends Controller
{
    public function query(){
        return view("employee.query");
    }

    public function querysubmit(Request $request)
    {

        $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->Department_name_sub)
        ->where('DepartmentId', $request->Department_name)
        ->first();


        if (!$departmentQuerySub) {
        return response()->json(['error' => 'Invalid subject or department'], 404);
        }

        // Fetch the employee reporting details
        $employeeReporting = EmployeeReporting::where('EmployeeID', $request->employee_id)->first();

        if (!$employeeReporting) {
        return response()->json(['error' => 'Employee reporting details not found'], 404);
        }

        // Fetch the employee's email from EmployeeGeneral
        $employeeGeneral = EmployeeGeneral::where('EmployeeID', $employeeReporting->ReportingId)->first();
        
        if (!$employeeGeneral) {
            return response()->json(['error' => 'Employee email not found'], 404);
        }
        $queryData = [
            'EmployeeID' => $request->employee_id,
            'RepMgrId' => $employeeReporting->ReportingId,
            'HodId' => $employeeReporting->HodId,
            'QToDepartmentId' => $request->Department_name,
            'QSubjectId' => $departmentQuerySub->DeptQSubId,
            'QuerySubject' => $request->Department_name_sub,
            'HideYesNo' => $request->has('hide_name') ? 'Y' : 'N', // 'Y' if checked, 'N' if unchecked
            'QueryDT' => Carbon::now(),
            'QueryValue' =>$request->remarks,
            'AssignEmpId'=>$departmentQuerySub->AssignEmpId,
            'Level_1ID' =>$departmentQuerySub->AssignEmpId,
            
        ];
        // Insert the data into hrm_employee_queryemp
       QueryMapEmp::create($queryData);
       try {
        Mail::to($employeeGeneral->EmailId_Vnr)->send(new QuerySubmitted($queryData));
        return response()->json(['success' => 'Query submitted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
        // return response()->json(['success' => 'Query submitted successfully!']);
        }

}
