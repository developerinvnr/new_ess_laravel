<?php

namespace App\Http\Controllers\Manage\PoliticalLocation;;

use App\Http\Controllers\Controller;
use App\Models\Backend\PoliticalLocation\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $block_list = Block::with('district')->get();
        return view('manage.basic.master.core.block', compact('block_list'));
    }
}
