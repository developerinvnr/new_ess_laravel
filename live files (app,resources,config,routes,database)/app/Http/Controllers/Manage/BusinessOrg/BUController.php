<?php

namespace App\Http\Controllers\Manage\BusinessOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\BusinessOrg\BusinessUnit;
use Illuminate\Http\Request;

class BUController extends Controller
{
    public function index()
    {
        $business_unit_list = BusinessUnit::with('vertical')->get();
        return view('manage.basic.master.core.business_unit', compact('business_unit_list'));
    }
}
