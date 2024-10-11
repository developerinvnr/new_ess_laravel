<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentSubject extends Model
{
    use HasFactory;

    protected $table = 'hrm_deptquerysub';

    protected $fillable = ['DeptQSubId', 'DeptQSubject', 'DepartmentId','AssignEmpId']; // Fillable fields



}
