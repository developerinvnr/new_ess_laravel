<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import the SoftDeletes trait

class EmployeeApplyLeave extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes trait
    protected $table ="hrm_employee_applyleave";
   
    // Specify the custom primary key
    protected $primaryKey = 'ApplyLeaveId'; 

    // Specify the column that stores the "deleted at" timestamp for soft deletes
    protected $dates = ['deleted_at']; 
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
