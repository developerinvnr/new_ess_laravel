<?php

namespace App\Http\Controllers\Manage\PoliticalLocation;

use App\Http\Controllers\Controller;
use App\Models\Backend\PoliticalLocation\CityVillage;
use Illuminate\Http\Request;

class CityVillageController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
    }
    public function index()
    {
        $city_list = CityVillage::with('state', 'district')->paginate(10);
        return view('manage.basic.master.core.city_village', compact('city_list'));
    }
}
