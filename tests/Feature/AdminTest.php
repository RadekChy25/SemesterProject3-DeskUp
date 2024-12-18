<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_protected_route()
    {
        $admin = User::factory()->create([
            'usertype' => 'admin',
        ]);
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    /** @test */
    public function not_admin_is_redirected_from_protected_route()
    {
        $user = User::factory()->create([
            'usertype' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/admin');
        $response->assertRedirect('/');
    }

    /** @test */
    public function guest_is_redirected_from_protected_route()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/');
    }

}