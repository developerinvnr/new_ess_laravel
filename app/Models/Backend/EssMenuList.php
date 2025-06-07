<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class EssMenuList extends Model
{
    protected $table="menu_list";

    protected $fillable = ['name'];
}
