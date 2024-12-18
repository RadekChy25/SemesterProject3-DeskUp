<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;

class AuthControllerTest extends TestCase
{
    public function test_login_validation_fails_when_name_is_missing()
    {
        $response = $this->post('/login',[
            'password'=> 'admin',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function test_login_validation_fails_when_password_is_missing()
    {
        $response = $this->post('/login',[
            'name'=> 'admin',
        ]);
        $response->assertSessionHasErrors('password');
    }
    public function test_succesful_login_for_admin_user()
    {
        $admin = User::where('name', 'admin')->first();

    $this->assertNotNull($admin);
        $response=$this->actingAs($admin)->post('/login',[
            'name'=>'admin',
            'password'=>'admin'
        ]);
        $response->assertRedirect("/admin");
        $this->assertAuthenticatedAs($admin);
    }
}
