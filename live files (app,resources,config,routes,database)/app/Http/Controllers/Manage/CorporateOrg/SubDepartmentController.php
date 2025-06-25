<?php

namespace App\Http\Controllers\Manage\CorporateOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\CorporateOrg\SubDepartment;
use Illuminate\Http\Request;

class SubDepartmentController extends Controller
{
    public function index()
    {
        $sub_department_list = SubDepartment::all();
        return view('manage.basic.master.core.sub_department', compact('sub_department_list'));
    }
}
