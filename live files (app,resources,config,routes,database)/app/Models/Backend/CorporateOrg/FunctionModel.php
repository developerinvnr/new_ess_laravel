<?php

namespace App\Models\Backend\CorporateOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FunctionModel extends Model
{
    protected $table = 'core_functions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'function_name', 'function_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('function_name', function (Builder $builder) {
            $builder->orderBy('function_name', 'asc');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
