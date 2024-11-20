<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeApplyLeave extends Model
{
    use HasFactory;
    protected $table ="hrm_employee_applyleave";

    protected $fillable = [
        'EmployeeID',
        'Apply_Date',
        'Leave_Type',
        'Apply_FromDate',
        'Apply_ToDate',
        'Apply_TotalDay',
        'Apply_Reason',
        'Apply_ContactNo',
        'Apply_DuringAddress',
        'LeaveAppReason',
        'LeaveAppUpDate',
        'LeaveAppUpDate',
        'LeaveRevReason',
        'LeaveRevUpDate',
        'LeaveHodReason',
        'LeaveHodUpDate',
        'ApplyLeave_UpdatedDate',
        'ApplyLeave_UpdatedYearId',
        'LeaveEmpCancelDate',
        'LeaveEmpCancelReason',
        'PartialComment',
        'AdminComment',
        'half_define',
        'back_date_flag',
        'Apply_SentToRev',
        'LeaveStatus',
        'LeaveAppStatus',
        'LeaveRevStatus'
    ]; 
}
