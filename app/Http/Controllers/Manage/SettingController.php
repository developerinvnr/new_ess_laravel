<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Backend\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        return view('manage.basic.basicsetting.setting');
    }

    public function basicsetting_master()
    {
        $menuItems = Menu::whereNull('parent_id')->where('module','BasicSetting')->with('children')->orderBy('menu_position')->get();
        return view('manage.basic.basicsetting.master.index', compact('menuItems'));
    }
    
}
