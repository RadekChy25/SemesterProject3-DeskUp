<?php

namespace Tests\Feature;

use Tests\TestCase;
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
        $admin = User::where('name', 'NewAdmin')->first();

        $this->assertNotNull($admin);
        $response=$this->actingAs($admin)->post('/login',[
            'name'=>'NewAdmin',
            'password'=>'Admin2024!'
        ]);
        $response->assertRedirect("/admin");
        $this->assertAuthenticatedAs($admin);
    }
    public function test_succesful_login_for_user()
    {
        $user = User::where('name', 'user')->first();

        $this->assertNotNull($user);
        $response=$this->actingAs($user)->post('/login', [
            'name'=>'user',
            'password'=>'user'
        ]);
        $response->assertRedirect('/ui');
        $this->assertAuthenticatedAs($user);

    }
    public function test_failed_login_due_to_incorrect_credentials()
    {
        $admin = User::where('name', 'admin')->first();
        $response=$this->post('/login',[
            'name'=>'admin',
            'passwword'=>'wrongpassword'
        ]);
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
    public function test_succesful_logout_as_user()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);
        $response=$this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
    public function test_succesful_logout_as_admin()
    {
        $admin = User::where('name','admin')->first();
        $this->actingAs($admin);
        $response=$this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
