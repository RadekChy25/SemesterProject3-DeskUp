<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TimeData;
use Tests\TestCase;
use Carbon\Carbon;


class TimeDataControllerTest extends TestCase
{

    public function test_redirects_unauthenticated_users()
    {
        $response = $this->get('/time-data');
        
        $response->assertRedirect('/login');
    }

    public function test_no_records_for_user()
    {
        $user = User::where('name','user')->first();
        
        Auth::login($user);

        $response = $this->get('/time-data');


        $response->assertViewHas('standtime', 0);
        $response->assertViewHas('sittime', 0);
    }
    
}
