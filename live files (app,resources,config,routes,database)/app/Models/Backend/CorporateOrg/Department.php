<?php

namespace App\Models\Backend\CorporateOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'core_departments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'department_name', 'department_code',  'numeric_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('department_name', function (Builder $builder) {
            $builder->orderBy('department_name', 'asc');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
