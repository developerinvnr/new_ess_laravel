<?php

namespace App\Models\Backend\PoliticalLocation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Block extends Model
{
    protected $table = 'core_block_by_district';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'district_id', 'block_name', 'block_code', 'numeric_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('block_name', function (Builder $builder) {
            $builder->orderBy('block_name', 'asc');
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
