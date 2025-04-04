<?php

namespace App\Http\Controllers\Manage\PoliticalLocation;

use App\Http\Controllers\Controller;
use App\Models\Backend\PoliticalLocation\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $state_list = State::with('country')->get();
        return view('manage.basic.master.core.state', compact('state_list'));
    }
}
