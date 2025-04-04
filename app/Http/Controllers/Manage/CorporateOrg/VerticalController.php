<?php

namespace App\Http\Controllers\Manage\CorporateOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\CorporateOrg\Vertical;
use Illuminate\Http\Request;

class VerticalController extends Controller
{
    public function index()
    {
        $vertical_list = Vertical::all();
        return view('manage.basic.master.core.vertical', compact('vertical_list'));
    }
}
