<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with('roles')->get();

        $moduleGroups = [
            'employee' => ['attendance-action', 'leave-management'],
            'admin' => ['role', 'user-management'],
        ];

        return view('roles_permissions.index', compact('roles', 'permissions', 'users', 'moduleGroups'));
    }

    // Add Role
    public function storeRole(Request $request)
    {
        $request->validate(['role_name' => 'required|unique:roles,name']);
        $query = Role::create(['name' => $request->input('role_name'), 'status' => 'active']);
        $id = $query->id;

        $role = Role::find($id);
        $role->syncPermissions($request->input('permission'));

        return response()->json([
            'success' => true,
            'message' => 'Role added successfully',
        ]);
    }
    public function edit($id)
    {
        $role = Role::find($id);
        $results = Permission::orderBy('group_name')->get();

        $grouped = $results->groupBy('module')->map(function ($modulePermissions) {
            return $modulePermissions->groupBy('group_name')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                    ];
                });
            });
        });

        $permissions = $grouped->toArray(); // send to blade

        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('manage.roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permission' => 'array',
            'permission.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->role_name;
        $role->save();
        // Convert permission IDs to Permission models
        $permissions = Permission::whereIn('id', $request->input('permission', []))->get();

        // Extract permission IDs as an array
        $permissionIds = $permissions->pluck('id')->toArray();

        // Make sure IDs are unique
        $uniquePermissionIds = array_unique($permissionIds);

        // Sync permissions using IDs
        $role->syncPermissions($uniquePermissionIds);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.'
        ]);

    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // Remove role permissions (not strictly required, but clean)
        $role->syncPermissions([]);

        // Delete the role
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }





}

