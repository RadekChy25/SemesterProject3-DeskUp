<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

const URL='http://127.0.0.1:7500/api/';
const VERSION='v2/';
const API_KEY="E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";

class DeskController extends Controller
{
    public function getDesks() //get all desk keys
    {     
        $desk_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
        $desk_list=json_decode($desk_list); //decode the json
        
        return $desk_list;
    }

    public function assignDesk(Request $request)
    {
        $request->session()->put('desk_id', $request->desk_id);
    }

    public function getDeskInfo(Request $request) //get data for a specific desk
    {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6"));
        $desk_info=json_decode($desk_info);

        return($desk_info); 
        //accessing the data is tricky, $deskinfo->state->position_mm gets the position. For the structure refer to the readme.md of wifi2ble v2
    }

    public function changeHeightTo(Request $request) //changes the positon to provided height
    {

        $request->validate([
            "height"=>"required"
        ]);

        if($request->height<600)
        {
            $height_to_set=$request->height*10;
        }
        else
        {
            $height_to_set=$request->height;
        }

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6").'/state', //This is for the final version
        ['position_mm'=>$height_to_set]);
        $feedback=json_decode($feedback); //response is the new height. There are upper and lower limits, so use this for display

        return redirect()->back()->with('feedback', $feedback);
    }


    public function moveDeskBy(Request $request)
    {
        $desk_info=$this->getDeskInfo($request);

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6").'/state', //This is for the final version
        ['position_mm'=>($request->heightChange+$desk_info->state->position_mm)]);
        $feedback=json_decode($feedback); //response is the new height. There are upper and lower limits, so use this for display


        return redirect()->back()->with('feedback', $feedback);
    }
}
