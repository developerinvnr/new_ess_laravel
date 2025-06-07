<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class EssMenuVisibility extends Model
{
    protected $table="menu_visibility"; 

    protected $fillable = ['name', 'route','menu_list_id','icon', 'is_visible'];
}
