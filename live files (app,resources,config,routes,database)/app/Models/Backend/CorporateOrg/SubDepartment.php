<?php

namespace App\Models\Backend\CorporateOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = 'core_sub_department_master';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'sub_department_name', 'sub_department_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sub_department_name', function (Builder $builder) {
            $builder->orderBy('sub_department_name', 'asc');
        });
    }
}
