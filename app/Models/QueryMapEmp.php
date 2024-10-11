<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryMapEmp extends Model
{
    use HasFactory;
    protected $table="hrm_employee_queryemp";
    protected $fillable = [
        'EmployeeID',
        'RepMgrId',
        'HodId',
        'QToDepartmentId',
        'QSubjectId',
        'QuerySubject',
        'HideYesNo',
        'QueryDT',
        'QueryValue',
        'AssignEmpId',
        'Level_1ID',2
    ]; // Fillable fields
}
