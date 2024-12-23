<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Http;
use App\Models\Mode;

const DEFAULT_MODE_SEPARATOR = 1000;
const URL='http://127.0.0.1:7500/api/';
const VERSION='v2/';
const API_KEY="E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";


Schedule::call(function()
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    foreach ($desk_list as $desk) {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($desk);

        $modesets=Mode::where('name','discomode')->first();
        $height=$modesets->height;

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
        $out->writeln($feedback);
    }
})
    ->dailyAt(Mode::first())
    ->when(function()
    {
        if(Mode::where('name', 'cleaningmode')->exists()){return true;} 
        else{return false;}
    });

Schedule::call(function()
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','fancymode')->first();
    $height=$modesets->height;

    foreach ($desk_list as $desk) {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($desk);

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
        $out->writeln($feedback);
    }
})
    ->dailyAt(Mode::first())
    ->when(function()
    {
        if(Mode::where('name', 'fancymode')->exists()){return true;} 
        else{return false;}
    });

Schedule::call(function()
{
    $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
    $desk_list=json_decode($desk_list);

    $modesets=Mode::where('name','discomode')->first();
    $height=$modesets->height;

    foreach ($desk_list as $desk) {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($desk);

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$desk.'/state', //This is for the final version
        ['position_mm'=>$height]);
        $out->writeln($feedback);
    }
})
    ->dailyAt(Mode::first())
    ->when(function()
    {
        if(Mode::where('name', 'discomode')->exists()){return true;} 
        else{return false;}
    });