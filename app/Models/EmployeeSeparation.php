<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSeparation extends Model
{
    use HasFactory;
    protected $table = 'hrm_employee_separation';
    protected $primaryKey = 'EmpSepId';
    // protected $fillable = [
    //     'EmpSepId', 'EmployeeID', 'Emp_ResignationDate', 'Emp_RelievingDate',
    //     'Emp_Reason', 'SprUploadFile', 'Emp_SaveDate', 'Rep_EmployeeID',
    //     'Log_EmployeeID', 'HOD_Date', 'Hod_EmployeeID', 'HR_Date', 'ResignationStatus'
    // ];
}
