<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class NotificationMaster extends Model
{
   protected $table = 'notification_masters';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'notification_type',
        'message',
        'status',
    ];
}
