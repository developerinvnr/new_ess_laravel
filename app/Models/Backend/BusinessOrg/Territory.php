<?php

namespace App\Models\Backend\BusinessOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    protected $table = 'core_territory';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'territory_name', 'territory_code',  'numeric_code', 'effective_date', 'is_active', 'vertical_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('territory_name', function (Builder $builder) {
            $builder->orderBy('territory_name', 'asc');
        });
    }

    
}
