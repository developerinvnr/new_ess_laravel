<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Backend\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasicController extends Controller
{
    public function index()
    {
        return view('manage.basic.basic');
    }

    public function basic_master()
    {
        $menuItems = Menu::whereNull('parent_id')->where('module','Basic')->with('children')->orderBy('menu_position')->get();
        return view('manage.basic.master.index', compact('menuItems'));
    }
}
