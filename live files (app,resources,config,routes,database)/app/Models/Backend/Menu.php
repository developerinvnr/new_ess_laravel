<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    
    protected $table = 'menu_master';
    public $timestamps = false;
    protected $fillable = ['menu_name', 'icon', 'menu_url', 'parent_id', 'menu_position','module', 'has_submenu','permission','status'];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('children')->orderBy('menu_position');
    }
}
