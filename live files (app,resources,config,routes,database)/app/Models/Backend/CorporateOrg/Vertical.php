<?php

namespace App\Models\Backend\CorporateOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Vertical extends Model
{
    protected $table = 'core_verticals';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'vertical_name', 'vertical_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('vertical_name', function (Builder $builder) {
            $builder->orderBy('vertical_name', 'asc');
        });
    }

    public function business_unit()
    {
        return $this->hasMany(\App\Models\Backend\BusinessOrg\BusinessUnit::class, 'vertical_id', 'id');
    }

    public function zone()
    {
        return $this->hasMany(\App\Models\Backend\BusinessOrg\Zone::class, 'vertical_id', 'id');
    }

    public function region()
    {
        return $this->hasMany(\App\Models\Backend\BusinessOrg\Region::class, 'vertical_id', 'id');
    }

   
}
