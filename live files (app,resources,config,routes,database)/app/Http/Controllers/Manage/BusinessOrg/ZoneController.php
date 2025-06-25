<?php

namespace App\Http\Controllers\Manage\BusinessOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\BusinessOrg\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zone_list = Zone::all();
        return view('manage.basic.master.core.zone', compact('zone_list'));
    }
}
