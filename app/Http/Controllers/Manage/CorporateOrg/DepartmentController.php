<?php

namespace App\Http\Controllers\Manage\CorporateOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\CorporateOrg\Department;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index()
    {
        $department_list = Department::all();
        return view('manage.basic.master.core.department', compact('department_list'));
    }
}
