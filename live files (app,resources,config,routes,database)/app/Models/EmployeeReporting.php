<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeReporting extends Model
{
    use HasFactory;
    protected $table ="hrm_employee_reporting";
    protected $primaryKey="EmployeeID";
    protected $fillable = ['EmployeeID', 'ReportingId', 'HodId']; // Fillable fields
}
