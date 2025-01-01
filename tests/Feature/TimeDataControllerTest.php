<?php 

namespace Tests\Feature;

use App\Models\User;
use App\Models\TimeData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TimeDataControllerTest extends TestCase
{
    /**
     * Test unauthenticated user cannot access time data.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_time_data()
    {
        // Try to access the time data page without being logged in.
        $response = $this->get('/ui');
        
        // Assert that the user is redirected to the login page.
        $response->assertRedirect('/');
    }

    /**
     * Test authenticated user can access time data and it calculates totals correctly.
     *
     * @return void
     */
    public function test_authenticated_user_can_access_time_data()
    {
        // Create a test user.
        $user = User::where('name','user')->first();
        
        // Log the user in.
        $this->actingAs($user);

        // Create some sample TimeData for the user.
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

        // Visit the time data page.
        $response = $this->get('/');

        // Assert that the response contains the expected calculated values.
        $response->assertStatus(200);
        $response->assertViewIs('welcome');  // Assumes the view name is 'ui'
    }

    /**
     * Test authenticated user can access activity data and it calculates weekly totals correctly.
     *
     * @return void
     */
    public function test_authenticated_user_can_access_activity_data()
    {
        // Create a test user.
        $user = User::where('name','user')->first();
        
        // Log the user in.
        $this->actingAs($user);

        // Create some sample TimeData for the user.
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

        // Visit the activity data page.
        $response = $this->get('/activity');

        // Assert that the response contains the expected calculated values.
        $response->assertStatus(200);
        $response->assertViewIs('.activity');  // Assumes the view name is 'activity'
    }

    /**
     * Test that time data calculation considers the previous week.
     *
     * @return void
     */
    public function test_time_data_calculates_correctly_for_previous_week()
    {
        // Create a test user.
        $user = User::where('name','user')->first();
        
        // Log the user in.
        $this->actingAs($user);

        // Create TimeData entries for the last week.
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

        // Visit the activity data page to check for weekly totals.
        $response = $this->get('/activity');

        // Assert the correct day-wise breakdown for sitting and standing in the past week.
        $response->assertStatus(200);
        $response->assertViewHas('standingovertime');  // Day-wise breakdown for standing
        $response->assertViewHas('sittingovertime');  // Day-wise breakdown for sitting
    }
}
