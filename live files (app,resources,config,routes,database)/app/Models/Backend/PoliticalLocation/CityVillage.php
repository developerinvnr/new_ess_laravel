<?php

namespace App\Models\Backend\PoliticalLocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CityVillage extends Model
{
    protected $table = 'core_city_village_by_state';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'state_id', 'district_id', 'division_name', 'city_village_name', 'city_village_code', 'pincode', 'longitude', 'latitude', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('city_village_name', function (Builder $builder) {
            $builder->orderBy('city_village_name', 'asc');
        });
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
