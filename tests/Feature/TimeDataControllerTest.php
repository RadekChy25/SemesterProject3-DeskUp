<?php 

namespace Tests\Feature;

use App\Models\User;
use App\Models\TimeData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TimeDataControllerTest extends TestCase
{

    public function test_unauthenticated_user_cannot_access_time_data()
    {

        $response = $this->get('/ui');
        
       
        $response->assertRedirect('/');
    }

    public function test_authenticated_user_can_access_time_data()
    {

        $user = User::where('name','user')->first();
        

        $this->actingAs($user);


        TimeData::create([
            'uID' => $user->id,
            'start_time' => Carbon::now()->subMinutes(60),
            'end_time' => Carbon::now(),
            'mode' => 'standing',
            'height'=>'120'
        ]);

        TimeData::create([
            'uID' => $user->id,
            'start_time' => Carbon::now()->subMinutes(120),
            'end_time' => Carbon::now()->subMinutes(60),
            'mode' => 'sitting',
            'height'=>'80'
        ]);


        $response = $this->get('/');

      
        $response->assertStatus(200);
        $response->assertViewIs('welcome'); 
    }

    public function test_authenticated_user_can_access_activity_data()
    {
     
        $user = User::where('name','user')->first();
        
        
        $this->actingAs($user);

        
        TimeData::create([
            'uID' => $user->id,
            'start_time' => Carbon::now()->subMinutes(60),
            'end_time' => Carbon::now(),
            'mode' => 'standing',
            'height'=>'120'
        ]);

        TimeData::create([
            'uID' => $user->id,
            'start_time' => Carbon::now()->subMinutes(120),
            'end_time' => Carbon::now()->subMinutes(60),
            'mode' => 'sitting',
            'height'=>'80'
        ]);

     
        $response = $this->get('/activity');


        $response->assertStatus(200);
        $response->assertViewIs('.activity');  
    }
     
    public function test_time_data_calculates_correctly_for_previous_week()
    {

        $user = User::where('name','user')->first();

        $this->actingAs($user);

        $lastWeekStanding = Carbon::now()->subWeek()->subDays(3);
        TimeData::create([
            'uID' => $user->id,
            'start_time' => $lastWeekStanding->copy()->startOfDay(),
            'end_time' => $lastWeekStanding->copy()->endOfDay(),
            'mode' => 'standing',
            'height'=>'120'
        ]);

        $lastWeekSitting = Carbon::now()->subWeek()->subDays(5);
        TimeData::create([
            'uID' => $user->id,
            'start_time' => $lastWeekSitting->copy()->startOfDay(),
            'end_time' => $lastWeekSitting->copy()->endOfDay(),
            'mode' => 'sitting',
            'height'=>'80'
        ]);

        $response = $this->get('/activity');

        $response->assertStatus(200);
        $response->assertViewHas('standingovertime'); 
        $response->assertViewHas('sittingovertime');  
    }
}
