<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'hrm_company_basic';
    protected $primaryKey = 'CompanyId';
    public $incrementing = false;
    public function getActiveDepartmentsWithSubjects($companyId)
    {
        return Department::with('subjects')
            ->where('CompanyId', $companyId)
            ->where('is_active', 'A')
            ->whereNotIn('DepartmentId', [4, 6, 26, 17, 18])
            ->orderBy('DepartmentCode', 'ASC')
            ->get(['DepartmentId', 'DepartmentCode']);
    }
}
