<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = 'admin_policy_masters';
    public $timestamps = false;

    protected $fillable = [
        'policy_name',
        'status',
    ];
}
