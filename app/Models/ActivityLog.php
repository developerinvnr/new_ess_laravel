<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ActivityLog extends Model
{
    protected $table = 'activity_log'; // or whatever your table is called

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];

    protected $casts = [
        'properties' => 'array', // JSON column
    ];

    // Optional relationships (polymorphic)
    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }
}

