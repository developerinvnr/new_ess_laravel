<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaldetails extends Model
{
    use HasFactory;
    protected $table ="hrm_employee_personal";
    protected $primaryKey ="EmployeeID";
    
}
