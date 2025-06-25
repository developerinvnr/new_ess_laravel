<?php

namespace App\Models\Backend\PoliticalLocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class District extends Model
{
    protected $table = 'core_districts';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'state_id', 'district_name', 'district_code', 'numeric_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('district_name', function (Builder $builder) {
            $builder->orderBy('district_name', 'asc');
        });
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function block(){
        return $this->hasMany(Block::class, 'district_id', 'id');
    }
}
