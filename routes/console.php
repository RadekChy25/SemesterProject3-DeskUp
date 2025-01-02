<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Http;
use App\Models\Mode;

Schedule::call(function()//set cleaningmode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);
    
    $set_to_after=0;

    $modesets=Mode::where('name','cleaningmode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get($url.$version.$api_key.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;
        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', 
        ['position_mm'=>$height]);
    }
    $set_to_after/=count($desk_list);
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->start_time):'')
    ->when((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->is_active):false);


Schedule::call(function()//set fancymode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $set_to_after=0;

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get($url.$version.$api_key.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;

        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
    $set_to_after/=count($desk_list);
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'fancymode')->exists())?
    (Mode::firstWhere('name','fancymode'))->start_time:'')
    ->when((Mode::where('name', 'fancymode')->exists())?
    ((Mode::firstWhere('name', 'fancymode'))->is_active):false);

Schedule::call(function()//set discomode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $set_to_after=0;

    $modesets=Mode::where('name','discomode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get($url.$version.$api_key.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;

        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
    $set_to_after/=count($desk_list);
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->start_time):'')
    ->when((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->is_active):false);






Schedule::call(function()//set after cleaningmode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','cleaningmode')->first();
    $height=$modesets->heightbefore;

    foreach ($desk_list as $desk) {
        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>(float)$height]);
    }
})
    ->dailyAt((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->end_time):'')
    ->when((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->is_active):false);

Schedule::call(function()//set after fancymode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->heightbefore;

    foreach ($desk_list as $desk) {
        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>(float)$height]);
    }

})
    ->dailyAt((Mode::where('name', 'fancymode')->exists())?
    ((Mode::firstWhere('name', 'fancymode'))->end_time):'')
    ->when((Mode::where('name', 'fancymode')->exists())?
    ((Mode::firstWhere('name', 'fancymode'))->is_active):false);

Schedule::call(function()//set after discomode
{
    $url=config('constants.URL');
    $version=config('constants.VERSION');
    $api_key=config('constants.API_KEY');

    $desk_list=Http::get($url.$version.$api_key.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','discomode')->first();
    $height=$modesets->heightbefore;
    
    foreach ($desk_list as $desk) {
        $feedback=Http::put($url.$version.$api_key.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>(float)$height]);
    }

})
    ->dailyAt((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->end_time):'')
    ->when((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->is_active):false);