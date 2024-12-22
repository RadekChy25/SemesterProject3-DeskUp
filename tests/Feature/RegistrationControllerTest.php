<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    public function test_user_can_register_with_valid_data()
    {
        $response=$this->post('/register',[
            'name'=>'Test User',
            'password'=>'Password123!',
            're-password'=>'Password123!',
            'code'=>null,
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHas('success','Success! New user registered.');
        $user=User::where('name', 'Test User')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('Password123!', $user->password));
        $this->assertEquals('user', $user->usertype);

    }
    public function test_admin_can_register_with_valid_code()
    {
        $response = $this->post('/register', [
            'name' => 'Admin User',
            'password' => 'AdminPassword123!',
            're-password' => 'AdminPassword123!',
            'code' => 'admin', 
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Success! New admin registered.');

        $user = User::where('name', 'Admin User')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('AdminPassword123!', $user->password));
        $this->assertEquals('admin', $user->usertype);
    }
    public function test_registration_with_invalid_password()
    {
        $response = $this->post('/register', [
            'name' => 'Short Password User',
            'password' => 'short',
            'code' => null,
        ]);

        $response->assertSessionHasErrors(['password' => 'The password must be at least 8 characters.']);
    }
    public function test_registration_with_no_uppercase_in_password()
    {
        $response = $this->post('/register', [
            'name' => 'No Uppercase User',
            'password' => 'password123!',
            'code' => null,
        ]);

        $response->assertSessionHasErrors('password');
    }
    public function test_registration_with_no_special_char_in_password()
    {
        $response = $this->post('/register', [
            'name' => 'No Special Char User',
            'password' => 'Password123',
            're-password' => 'Password123',
            'code' => null,
        ]);

        $response->assertSessionHasErrors(['password' => 'The password must contain at least one uppercase letter and one special character (!@#$%^&*).']);

    }
    public function test_registration_with_incorrect_admin_code()
    {
        $response = $this->post('/register', [
            'name' => 'Invalid Admin User',
            'password' => 'Password123!',
            're-password' => 'Password123!',
            'code' => 'wrongcode',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Wrong admin code! Try again.');
    }
    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['name' => 'Admin User', 'usertype' => 'admin']);
        $user = User::factory()->create(['name' => 'Test User', 'usertype' => 'user']);

        $response = $this->actingAs($admin)->post('/delete', [
            'id' => $user->id,
        ]);
        $response->assertRedirect('/admin');
        $this->assertNull(User::find($user->id)); 
    }
    public function test_delete_nonexistent_user()
    {
       
        $response = $this->post('/delete', [
            'id' => 99999, 
        ]);

        $response->assertRedirect('admin'); 
        $this->assertNull(User::find(99999)); 

    }

}