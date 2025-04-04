<?php

namespace App\Models\Backend\BusinessOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'core_zones';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'zone_name', 'zone_code',  'numeric_code', 'effective_date', 'is_active', 'vertical_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('zone_name', function (Builder $builder) {
            $builder->orderBy('zone_name', 'asc');
        });
    }

    public function vertical()
    {
        return $this->belongsTo(\App\Models\Backend\CorporateOrg\Vertical::class, 'vertical_id', 'id');
    }
}
