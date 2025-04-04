<?php

namespace App\Models\Backend\BusinessOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'core_regions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'region_name', 'region_code',  'numeric_code', 'effective_date', 'is_active', 'vertical_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('region_name', function (Builder $builder) {
            $builder->orderBy('region_name', 'asc');
        });
    }

    public function vertical()
    {
        return $this->belongsTo(\App\Models\Backend\CorporateOrg\Vertical::class, 'vertical_id', 'id');
    }
}
