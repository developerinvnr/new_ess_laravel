<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Example: Create Permissions
        $permissions = [
            ['name' => 'leavebalance', 'group_name' => 'Attendance', 'module' => 'Employee'],
            ['name' => 'applyleave', 'group_name' => 'Attendance', 'module' => 'Employee'],
            ['name' => 'authorization', 'group_name' => 'Attendance', 'module' => 'Employee'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['name' => $perm['name'], 'guard_name' => 'web'],
                ['group_name' => $perm['group_name'], 'module' => $perm['module']]
            );
        }

    }
}
