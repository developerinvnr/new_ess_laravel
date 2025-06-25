<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   
    protected $table = 'notification';
    public $timestamps = false;
    protected $fillable = [
        'userid', 'title', 'description',
    ];
}
