<?php

namespace App\Http\Controllers\Manage\PoliticalLocation;

use App\Http\Controllers\Controller;
use App\Models\Backend\PoliticalLocation\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $district_list = District::with('state')->get();
        return view('manage.basic.master.core.district', compact('district_list'));
    }
}
