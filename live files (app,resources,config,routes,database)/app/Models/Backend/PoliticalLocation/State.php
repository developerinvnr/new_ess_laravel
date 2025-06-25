<?php

namespace App\Models\Backend\PoliticalLocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class State extends Model
{
    protected $table = 'core_states';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'country_id', 'state_name', 'state_code', 'short_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('state_name', function (Builder $builder) {
            $builder->orderBy('state_name', 'asc');
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function district()
    {
        return $this->hasMany(District::class, 'state_id', 'id');
    }
}
