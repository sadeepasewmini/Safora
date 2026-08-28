<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RbacSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Unauthenticated Guest cannot access Admin Dashboard.
     */
    public function test_unauthenticated_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Test 2: Regular Public User cannot escalate privileges to Admin Dashboard.
     */
    public function test_public_user_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'public_user',
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Unauthorized access to Admin Dashboard.');
    }

    /**
     * Test 3: Regular Public User cannot escalate privileges to Moderator Dashboard.
     */
    public function test_public_user_cannot_access_moderator_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'public_user',
        ]);

        $response = $this->actingAs($user)->get('/moderator/dashboard');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error', 'Unauthorized access to Moderator Dashboard.');
    }

    /**
     * Test 4: Regular Public User cannot create staff accounts via POST /admin/staff.
     */
    public function test_public_user_cannot_create_staff_account()
    {
        $user = User::factory()->create([
            'role' => 'public_user',
        ]);

        $response = $this->actingAs($user)->post('/admin/staff', [
            'name' => 'Fake Admin',
            'email' => 'fakeadmin@safora.lk',
            'phone' => '0770000000',
            'role' => 'admin',
            'password' => 'password123',
        ]);

        $response->assertSessionHas('error', 'Only Admins can create staff accounts.');
    }

    /**
     * Test 5: Admin User CAN access Admin Dashboard.
     */
    public function test_admin_user_can_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}
