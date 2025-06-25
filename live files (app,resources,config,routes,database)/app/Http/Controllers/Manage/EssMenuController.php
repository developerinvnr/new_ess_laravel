<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\EssMenuVisibility;
use App\Models\Backend\EssMenuList;


class EssMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = EssMenuVisibility::all();
        $menuslist = EssMenuList::all();

        return view('manage.basic.master.menumaster_employee', compact('menus','menuslist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menuList = EssMenuList::where('name', $request->name)->first();
        
        // Check if a menu with same name & route already exists
        $existing = EssMenuVisibility::where('name', $request->name)
            ->where('menu_list_id', $menuList->id)
            ->where('route', $request->route)
            ->first();

        if ($existing) {
            // Return existing menu instead of creating new one
            return response()->json([
                'message' => 'Menu already exists',
                'menu' => $existing
            ], 409);  // HTTP 409 Conflict status
        }

        // Create new menu if not exists
        $menu = EssMenuVisibility::create([
            'name' => $request->name,
            'route' => $request->route,
            'menu_list_id'=> $menuList->id,
            'is_visible' => $request->is_visible,
        ]);

        return response()->json($menu);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $menu = EssMenuVisibility::find($request->id);
        $menu->update($request->only(['name', 'route', 'is_visible']));

        return response()->json($menu);
    }

    public function destroy(Request $request)
    {
        EssMenuVisibility::destroy($request->id);
        return response()->json(['status' => 'success']);
    }
    public function storeMenuList(Request $request)
    {

        $menuName = EssMenuList::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'List added successfully',
            'id' => $menuName->id,
            'name' => $menuName->name,
        ]);
    }


}
