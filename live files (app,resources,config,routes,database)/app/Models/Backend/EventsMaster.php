<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsMaster extends Model
{
    protected $table = 'events_master';

    protected $fillable = [
        'name',
        'status',
    ];
}
