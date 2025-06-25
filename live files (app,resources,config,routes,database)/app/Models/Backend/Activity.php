<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table="activities_master";
    protected $fillable = [
        'name',
        'approve',
        'reject',
        'modules',
        'notification_type',
        'status',
    ];

    protected $casts = [
        'modules' => 'array',
        'notification_type' => 'array',
    ];
}

