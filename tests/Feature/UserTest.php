<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_user_can_access_route()
    {
        $user = User::where('name', 'user')->first();
        $this->assertNotNull($user);
        $response = $this->actingAs($user)->get('/ui');

    }

    public function test_admin_can_access_route()
    {
        $admin = User::where('name', 'admin')->first();
        $this->assertNotNull($admin);
        $response = $this->actingAs($admin)->get('/ui');


    }
    public function test_guest_is_redirected_from_user_route()
    {
        $response = $this->get('/ui');
        $response->assertRedirect('/');
    }

}