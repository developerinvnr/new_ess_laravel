<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryLog extends Model
{
    use HasFactory;
    protected $table = "hrm_employee_querylog";
    protected $primaryKey ="EmployeeID";
    
}
