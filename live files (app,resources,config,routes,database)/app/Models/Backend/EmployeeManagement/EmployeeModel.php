<?php

namespace App\Models\Backend\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class EmployeeModel extends Model
{
    protected $table = 'hrm_employee';
    protected $primaryKey = 'EmployeeID';
    public $timestamps = false;

    public function getEmployeeList($filters = [])
    {
        $query = $this->select([
            'e.EmployeeID',
            'e.EmpCode',
            DB::raw("CONCAT(COALESCE(e.Fname, ''), ' ', COALESCE(e.Sname, ''), ' ', COALESCE(e.Lname, '')) AS employee_name"),
            DB::raw("COALESCE(cf.function_name, '-') AS function"),
            DB::raw("COALESCE(cv.vertical_name, '-') AS vertical"),
            DB::raw("COALESCE(d.department_code, '-') AS department_code"),
            DB::raw("COALESCE(g.GradeValue, '-') AS GradeValue"),
            DB::raw("COALESCE(eg.DateJoining, '-') AS DateJoining"),
            DB::raw("COALESCE(e.EmpStatus, '-') AS EmpStatus")
        ])
        ->from('hrm_employee AS e')
        ->leftJoin('hrm_employee_general AS eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
        ->leftJoin('hrm_grade AS g', 'eg.GradeId', '=', 'g.GradeId')
        ->leftJoin('core_departments AS d', 'eg.DepartmentId', '=', 'd.id')
        ->leftJoin('core_verticals AS cv', 'eg.EmpVertical', '=', 'cv.id')
        ->leftJoin('core_functions AS cf', 'eg.EmpFunction', '=', 'cf.id');
        if (!empty($filters['function'])) {
            $query->where('eg.EmpFunction', '=', $filters['function']);
        }
        if (!empty($filters['department'])) {
            $query->where('eg.DepartmentId', '=', $filters['department']);
        }
        if (!empty($filters['status'])) {
            $query->where('e.EmpStatus', '=', $filters['status']);
        }
        if (!empty($filters['vcode'])) {
            $query->where('e.VCode', '=', $filters['vcode']);
        } else {
            $query->where('e.VCode', '!=', 'V');
        }
        $query->orderBy('e.EmployeeID', 'ASC');
        return $query->get();
    }

}
