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
        Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage_resources']);
        $manageUsers = Permission::create(['name' => 'manage_users']);
        $managePermissions = Permission::create(['name' => 'manage_permissions']);
        $manageTemplates = Permission::create(['name' => 'manage_mail_templates']);
        $manageSettings = Permission::create(['name' => 'manage_settings']);

        $admin->givePermissionTo($manageUsers);
        $admin->givePermissionTo($managePermissions);
        $admin->givePermissionTo($manageUsers);
        $admin->givePermissionTo($manageTemplates);
        $admin->givePermissionTo($manageSettings);
    }
}
