<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        $createCrud = Permission::create(['name' => 'create_crud']);
        $createRelations = Permission::create(['name' => 'create_relations']);
        $manageUsers = Permission::create(['name' => 'manage_users']);
        $managePermissions = Permission::create(['name' => 'manage_permissions']);

        $superAdmin->givePermissionTo($createCrud);
        $superAdmin->givePermissionTo($createRelations);
        $admin->givePermissionTo($manageUsers);
        $admin->givePermissionTo($managePermissions);
        $admin->givePermissionTo($manageUsers);
    }
}
