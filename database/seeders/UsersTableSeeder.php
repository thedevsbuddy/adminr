<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = User::create([
            'name' => 'Developer',
            'email' => 'dev@adminr.com',
            'username' => 'developer',
            'phone' => '9999999999',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@adminr.com',
            'username' => 'super_admin',
            'phone' => '9876543211',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@adminr.com',
            'username' => 'admin',
            'phone' => '9876543210',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@adminr.com',
            'username' => 'user',
            'phone' => '9876543212',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);

        $developer->assignRole(Role::where('name', 'developer')->first());
        $superAdmin->assignRole(Role::where('name', 'super_admin')->first());
        $admin->assignRole(Role::where('name', 'admin')->first());
        $user->assignRole(Role::where('name', 'user')->first());
    }
}
