<?php

namespace App\Models\Backend\CorporateOrg;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'core_section';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'section_name', 'section_code', 'effective_date', 'is_active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('section_name', function (Builder $builder) {
            $builder->orderBy('section_name', 'asc');
        });
    }
}
