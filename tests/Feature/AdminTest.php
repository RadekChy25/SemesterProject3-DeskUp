<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AdminTest extends TestCase
{
    public function admin_can_access_protected_route()
    {
        $admin = User::where('name', 'admin')->first();
        $this->assertNotNull($admin);
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function not_admin_is_redirected_from_protected_route()
    {
        $user = User::where('name', 'user')->first();
        $this->assertNotNull($user);
        $response = $this->actingAs($user)->get('/admin');
        $response->assertRedirect('/');

    }
    public function guest_is_redirected_from_protected_route()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/');
    }

}