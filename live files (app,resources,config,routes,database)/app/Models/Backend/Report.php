<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'admin_report_masters';
    public $timestamps = false;

    protected $fillable = [
        'report_name',
        'status',
    ];
}
