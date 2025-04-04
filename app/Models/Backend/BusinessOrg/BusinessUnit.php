<?php

namespace App\Models\Backend\BusinessOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $table = 'core_business_unit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'business_unit_name', 'business_unit_code',  'numeric_code', 'effective_date', 'is_active', 'vertical_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('business_unit_name', function (Builder $builder) {
            $builder->orderBy('business_unit_name', 'asc');
        });
    }

    public function vertical()
    {
        return $this->belongsTo(\App\Models\Backend\CorporateOrg\Vertical::class, 'vertical_id', 'id');
    }
}
