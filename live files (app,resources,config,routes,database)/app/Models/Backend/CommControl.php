<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class CommControl extends Model
{
    protected $table="communication_controls";

    protected $fillable = ['module_name','status'];
}
