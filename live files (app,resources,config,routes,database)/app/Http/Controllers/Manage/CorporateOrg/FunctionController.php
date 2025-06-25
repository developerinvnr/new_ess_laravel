<?php

namespace App\Http\Controllers\Manage\CorporateOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\CorporateOrg\FunctionModel;
use Illuminate\Http\Request;

class FunctionController extends Controller
{
    public function index()
    {
        $function_list = FunctionModel::all();
        return view('manage.basic.master.core.function', compact('function_list'));
    }
}
