<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeGeneral extends Model
{
    use HasFactory;
    
    protected $table = 'hrm_employee_general'; 
    protected $primaryKey = 'EmployeeID';
    public $incrementing = false;
    
    

}
