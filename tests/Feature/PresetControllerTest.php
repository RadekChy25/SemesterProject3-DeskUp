<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Preset;

class PresetControllerTest extends TestCase
{
    public function test_set_presets_creates_new_presets_for_user()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);
        $response =$this->post('setpresets',[
            'standingHeight'=>120,
            'sittingHeight'=>80,
        ]);
        $this->assertDatabaseHas('presets',[
            'uID'=>$user->id,
            'name'=>'standing',
            'height'=>120
        ]);
        $this->assertDatabaseHas('presets',[
            'uID'=>$user->id,
            'name'=>'sitting',
            'height'=>80
        ]);
        $response->assertRedirect()->with('feedback','Standing height:120 Sitting height:80');

    }
    public function test_set_presets_updates_existing_presets_for_user()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);

        Preset::create([
            'uID' => $user->id,
            'name' => 'standing',
            'height' => 100
        ]);

        Preset::create([
            'uID' => $user->id,
            'name' => 'sitting',
            'height' => 60
        ]);
        $response = $this->post('/setpresets', [
            'standingHeight' => 150,
            'sittingHeight' => 90,
        ]);
        $this->assertDatabaseHas('presets', [
            'uID' => $user->id,
            'name' => 'standing',
            'height' => 150,
        ]);
        $this->assertDatabaseHas('presets', [
            'uID' => $user->id,
            'name' => 'sitting',
            'height' => 90,
        ]);
        $response->assertRedirect()->with('feedback', 'New standing height:150 New sitting height:90');
    }
    public function test_set_presets_validation_fails_when_required_fields_are_missing()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);

        $response = $this->post('/setpresets', [
            'standingHeight' => 120,

        ]);

        $response->assertSessionHasErrors('sittingHeight');
    }
    public function test_delete_preset()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);

        $preset = Preset::create([
            'uID' => $user->id,
            'name' => 'standing',
            'height' => 100
        ]);
        $response = $this->post('/deletePreset', [
            'id' => $preset->id
        ]);
        $this->assertDatabaseMissing('presets', [
            'id' => $preset->id
        ]);
        $response->assertRedirect();
    }
    public function test_delete_preset_fails_when_id_is_missing()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);
        $response = $this->post('/deletePreset', []);
        $response->assertSessionHasErrors('id');
    }
    public function test_get_presets()
    {
        $user = User::where('name','user')->first();
        $this->actingAs($user);

        Preset::create([
            'uID' => $user->id,
            'name' => 'standing',
            'height' => 120
        ]);

        Preset::create([
            'uID' => $user->id,
            'name' => 'sitting',
            'height' => 80
        ]);

        $response = $this->get('/getpresets');
        $response->assertRedirect()->with('presets', $user->presets);
    }



}