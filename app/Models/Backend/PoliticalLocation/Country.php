<?php

namespace App\Models\Backend\PoliticalLocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
    protected $table = 'core_countries';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'global_region', 'country_name', 'country_code', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('country_name', function (Builder $builder) {
            $builder->orderBy('country_name', 'asc');
        });
    }

    public function state()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
