<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardOpensTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_super_admin_can_see_dashboard()
    {
        $this->seedUsersAndRoles();
        $superAdmin = User::role('super_admin')->first();

        $this->actingAs($superAdmin);

        $response = $this->get('/adminr/dashboard');

        $response->assertStatus(200);
    }

    public function test_super_admin_can_see_resource_builder()
    {
        $this->seedUsersAndRoles();
        $superAdmin = User::role('super_admin')->first();

        $this->actingAs($superAdmin);

        $response = $this->get('/adminr/builder');

        $response->assertStatus(200);
    }

    public function test_user_can_not_see_dashboard()
    {
        $this->seedUsersAndRoles();
        $superAdmin = User::role('user')->first();

        $this->actingAs($superAdmin);

        $response = $this->get('/adminr/dashboard');

        $response->assertStatus(302);
    }

    public function test_user_can_not_see_resource_builder()
    {
        $this->seedUsersAndRoles();
        $superAdmin = User::role('user')->first();

        $this->actingAs($superAdmin);

        $response = $this->get('/adminr/builder');

        $response->assertStatus(302);
    }

    private function seedUsersAndRoles(){
        $this->seed(RolesAndPermissionsTableSeeder::class);
        $this->seed(UsersTableSeeder::class);
    }
}
