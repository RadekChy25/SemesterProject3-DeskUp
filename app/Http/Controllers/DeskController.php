<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

const URL='http://127.0.0.1:7500/api/';
const VERSION='v2/';
const API_KEY="E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";

class DeskController extends Controller
{
    public function getDesks(Request $request) //get all desk keys
    {     
        $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
        $desk_list=json_decode($desk_list); //decode the json

        echo('here');
        echo($request->route);
        
        return $desk_list;
    }

    public function getDeskInfo(Request $request) //get data for a specific desk
    {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$request->desk_id);
        $desk_info=json_decode($desk_info);

        return($desk_info); 
        //accessing the data is tricky, $deskinfo->state->position_mm gets the position. For the structure refer to the readme.md of wifi2ble v2
    }

    public function changeHeightTo(Request $request) //changes the positon to provided height
    {
        $mydesk=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$request->desk_id.'/state', 
        ['position_mm'=>$request->height]);
        $mydesk=json_decode($mydesk); //response is the new height. There are upper and lower limits, so use this for display


        return($mydesk);
    }
}
