<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueryMapEmp extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'hrm_employee_queryemp';
    protected $primaryKey = 'QueryId'; 

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
        'Level_1ID',
        'Level_2ID',
        'Level_3ID' ,
        'Mngmt_ID',
        'Level_1QToDT' ,
        'Level_2QToDT',
        'Level_3QToDT',
        'Mngmt_QToDT',
    ]; // Fillable fields
}
