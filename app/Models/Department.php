<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'core_departments';
    protected $primaryKey = 'id';

    public function subjects()
    {
        return $this->hasMany(DepartmentSubject::class, 'DepartmentId', 'id');
    }
    
}
