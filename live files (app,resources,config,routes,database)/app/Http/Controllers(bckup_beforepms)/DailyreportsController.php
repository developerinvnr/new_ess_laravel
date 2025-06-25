<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use DB;
class DailyreportsController extends Controller
{

   public function dailyreports(Request $request)
   {
       
    $EmployeeID = Auth::user()->EmployeeID;

    // Get all employees reporting to the logged-in user (RepEmployeeID)
    $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get();

    foreach ($employeesReportingTo as $employee) {
        $year = $request->input('Y', date('Y'));
        $month = $request->input('m', date('m'));
        $tableName = "hrm_employee_moreve_report_" . $year;

        $dailyreportsQuery = DB::table($tableName . ' as r')
            ->leftJoin('hrm_employee as e', 'r.EmployeeID', '=', 'e.EmployeeID')
            ->leftJoin('hrm_employee_general as g', 'r.EmployeeID', '=', 'g.EmployeeID')
            ->leftJoin('hrm_employee_personal as p', 'r.EmployeeID', '=', 'p.EmployeeID')
            ->leftJoin('core_city_village_by_state as hq', 'g.HqId', '=', 'hq.id') // Join with Headquater table
            ->where('g.RepEmployeeID',  Auth::user()->EmployeeID)
            ->select([
                'r.*',
                'g.DepartmentId',
                'g.DesigId',
                'e.EmpCode',
                'e.Fname',
                'e.Sname',
                'e.Lname',
                'p.Married',
                'p.Gender',
                'hq.city_village_name',
                'p.DR'
            ]);

        // Apply month and employee filters if selected
        if ($request->month) {
            $dailyreportsQuery->whereMonth('r.MorEveDate', $request->month);
        }

        // Decrypt the EmployeeID from the request
        if ($request->employee) {
            $decryptedEmployeeID = Crypt::decrypt($request->employee);
            $dailyreportsQuery->where('r.EmployeeID', $decryptedEmployeeID);
        }

        // Get daily reports
        $dailyreports = $dailyreportsQuery->get();
    }
return view('employee.daily_reports',compact('dailyreports'));
   
}
}
