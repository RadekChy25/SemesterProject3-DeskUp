<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Preset;
use App\Models\TimeData;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_presets()
    {
        $user = User::where('name', 'user')->first();
        $this->assertNotNull($user);

        $preset1 = Preset::create(['uID' => $user->id, 'name' => 'standing', 'height' => 120]);
        $preset2 = Preset::create(['uID' => $user->id, 'name' => 'sitting', 'height' => 80]);
        $this->assertTrue($user->presets->contains($preset1));
        $this->assertTrue($user->presets->contains($preset2));

    }

    public function test_user_can_be_created_with_mass_assignment()
    {
        $user = User::where('name', 'user')->first();
        $this->assertNotNull($user);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
        ]);

    }

    public function test_user_password_is_hashed()
    {
        $user = User::where('name', 'user')->first();
        $this->assertNotNull($user);

        $this->assertNotEquals('user', $user->password);
        $this->assertTrue(\Hash::check('user', $user->password));
    }

}
