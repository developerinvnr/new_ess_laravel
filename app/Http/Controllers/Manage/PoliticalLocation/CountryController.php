<?php

namespace App\Http\Controllers\Manage\PoliticalLocation;

use App\Http\Controllers\Controller;
use App\Models\Backend\PoliticalLocation\Country;

class CountryController extends Controller
{
    public function index()
    {
        $country_list = Country::all();
        return view('manage.basic.master.core.country', compact('country_list'));
    }
}
