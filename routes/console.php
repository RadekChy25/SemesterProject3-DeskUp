<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Http;
use App\Models\Mode;

const DEFAULT_MODE_SEPARATOR = 1000;
const URL='http://127.0.0.1:7500/api/';
const VERSION='v2/';
const API_KEY="E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";


Schedule::call(function()//set cleaningmode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);
    
    $set_to_after=0;

    $modesets=Mode::where('name','cleaningmode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;
        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
    $set_to_after/=count($desk_list);
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->start_time):'');


Schedule::call(function()//set fancymode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $set_to_after=0;

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
    $set_to_after/=$desk_list->count();
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'fancymode')->exists())?
    (Mode::firstWhere('name','fancymode'))->start_time:'');

Schedule::call(function()//set discomode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $set_to_after=0;

    $modesets=Mode::where('name','discomode')->first();
    $height=$modesets->height*10;

    foreach ($desk_list as $desk) {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$desk);
        $desk_info=json_decode($desk_info);
        $set_to_after+=$desk_info->state->position_mm;

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
    $set_to_after/=$desk_list->count();
    $modesets->heightbefore=$set_to_after;
    $modesets->save();
})
    ->dailyAt((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->start_time):'');






Schedule::call(function()//set after cleaningmode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','cleaningmode')->first();
    $height=$modesets->heightbefore;

    foreach ($desk_list as $desk) {
        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }
})
    ->dailyAt((Mode::where('name', 'cleaningmode')->exists())?
    ((Mode::firstWhere('name', 'cleaningmode'))->end_time):'');

Schedule::call(function()//set after fancymode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->heightbefore;

    foreach ($desk_list as $desk) {
        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }

})
    ->dailyAt((Mode::where('name', 'fancymode')->exists())?
    ((Mode::firstWhere('name', 'fancymode'))->end_time):'');

Schedule::call(function()//set after discomode
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->heightbefore;

    foreach ($desk_list as $desk) {
        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
    }

})
    ->dailyAt((Mode::where('name', 'discomode')->exists())?
    ((Mode::firstWhere('name', 'discomode'))->end_time):'');