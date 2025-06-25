<?php

namespace App\Http\Controllers\Manage\BusinessOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\BusinessOrg\Territory;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
    public function index()
    {
        $territory_list = Territory::all();
        return view('manage.basic.master.core.territory', compact('territory_list'));
    }
}
