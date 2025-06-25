<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class ReasonMaster extends Model
{
    protected $table = 'reason_masters';

    protected $fillable = ['name', 'status'];

}
