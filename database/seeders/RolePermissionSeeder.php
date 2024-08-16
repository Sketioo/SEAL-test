<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $updateUsersPermission = Permission::firstOrCreate(['name' => 'update users', 'guard_name' => 'web']);
        $deleteUsersPermission = Permission::firstOrCreate(['name' => 'delete users', 'guard_name' => 'web']);

        $updateProjectsPermission = Permission::firstOrCreate(['name' => 'update projects', 'guard_name' => 'web']);
        $deleteProjectsPermission = Permission::firstOrCreate(['name' => 'delete projects', 'guard_name' => 'web']);

        $updateTasksPermission = Permission::firstOrCreate(['name' => 'update tasks', 'guard_name' => 'web']);
        $deleteTasksPermission = Permission::firstOrCreate(['name' => 'delete tasks', 'guard_name' => 'web']);

        Role::firstOrCreate(['name' => 'user']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $adminRole->givePermissionTo([
            $updateUsersPermission, $deleteUsersPermission,
            $updateProjectsPermission, $deleteProjectsPermission,
            $updateTasksPermission, $deleteTasksPermission,
        ]);
    }
}
