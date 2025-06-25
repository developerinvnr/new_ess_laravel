<?php

namespace App\Http\Controllers\Manage\BusinessOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\BusinessOrg\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $region_list = Region::all();
        return view('manage.basic.master.core.region', compact('region_list'));
    }
}
