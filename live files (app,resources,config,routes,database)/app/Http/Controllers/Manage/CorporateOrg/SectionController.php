<?php

namespace App\Http\Controllers\Manage\CorporateOrg;

use App\Http\Controllers\Controller;
use App\Models\Backend\CorporateOrg\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
   public function index()
    {
        $section_list = Section::all();
        return view('manage.basic.master.core.section', compact('section_list'));
    }
}
