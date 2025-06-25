<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = "hrm_employee_attendance";
    protected $primarykey = "EmployeeID";
    protected $fillable = [
        'EmployeeID',
        'AttValue',
        'AttDate',
        'Year',
        'YearId',
        'II',
        'OO',
        'Inn',
        'Outt',
    ];

}
