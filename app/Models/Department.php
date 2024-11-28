<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'hrm_department';
    protected $primaryKey = 'DepartmentId';

    public function subjects()
    {
        return $this->hasMany(DepartmentSubject::class, 'DepartmentId', 'DepartmentId');
    }
    
}
