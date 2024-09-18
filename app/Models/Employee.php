<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    
        protected $table = 'hrm_employee'; // The table name
        protected $primaryKey = 'EmployeeID'; // The primary key column
        public $incrementing = false;
}