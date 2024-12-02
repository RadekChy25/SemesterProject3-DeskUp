<?php

namespace App\Http\Controllers;

use App\Models\TimeData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Preset;
use Illuminate\Support\Facades\Auth;


const DEFAULT_MODE_SEPARATOR = 1000;
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

    public function getDeskInfo(Request $request) //get data for a specific desk
    {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6"));
        $desk_info=json_decode($desk_info);

        return($desk_info); 
        //accessing the data is tricky, $deskinfo->state->position_mm gets the position. For the structure refer to the readme.md of wifi2ble v2
    }

    public function changeHeightTo(Request $request) //changes the positon to provided height
    {
        /*$request->validate([
            "height"=>"required"
        ]);*/

        if($request->height<600)
        {
            $height_to_set=$request->height*10;
        }
        else
        {
            $height_to_set=$request->height;
        }

        $this->recordIfChanged($request, $height_to_set);

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6").'/state', //This is for the final version
        ['position_mm'=>$height_to_set]);
        $feedback=json_decode($feedback); //response is the new height. There are upper and lower limits, so use this for display

        return redirect()->back()->with('feedback', $feedback);
    }


    public function moveDeskBy(Request $request)
    {
        $desk_info=$this->getDeskInfo($request);

        if(Preset::where('uID',Auth::id())->exists()) //find the point of separation
        {
            $sitting=Preset::where('uID',Auth::id())->where('name', 'sitting')->first();
            $standing=Preset::where('uID',Auth::id())->where('name', 'standing')->first();
            $separator=($sitting->height+$standing->height)/2;
        }
        else
        {
            $separator=DEFAULT_MODE_SEPARATOR;
        }
        if($request->heightChange+$desk_info->state->position_mm>$separator xor $desk_info->state->position_mm>$separator)//only start new record if the mode changed
        {
            $this->recordIfChanged($request, $request->heightChange+$desk_info->state->position_mm);
        }

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6").'/state', //This is for the final version
        ['position_mm'=>($request->heightChange+$desk_info->state->position_mm)]);
        $feedback=json_decode($feedback); //response is the new height. There are upper and lower limits, so use this for display


        return redirect()->back()->with('feedback', $feedback);
    }

    public function sitDown(Request $request)
    {
        if(Preset::where('uID',Auth::id())->exists())
        {
            $preset=Preset::where('uID',Auth::id())->where('name', 'sitting')->first();

            $request->height=$preset->height;
            $this->changeHeightTo($request);
            return redirect()->back();
        }

        return redirect()->back()->with('feedback', 'You have no presets');
    }

    public function standUp(Request $request)
    {
        if(Preset::where('uID',Auth::id())->exists())
        {
            $preset=Preset::where('uID',Auth::id())->where('name', 'standing')->first();
            
            $request->height=$preset->height;
            $this->changeHeightTo($request);
            return redirect()->back();
        }

        return redirect()->back()->with('feedback', 'You have no presets');
    }

    public function recordIfChanged(Request $request, $new_height)
    {

        $new_height = max(680, min(1320, $new_height));//get value into the range of desk movement

        if(Preset::where('uID',Auth::id())->exists()) //find the point fo separation
        {
            $sitting=Preset::where('uID',Auth::id())->where('name', 'sitting')->first();
            $standing=Preset::where('uID',Auth::id())->where('name', 'standing')->first();
            $separator=10*($sitting->height+$standing->height)/2;
        }
        else
        {
            $separator=DEFAULT_MODE_SEPARATOR;
        }

        //get current desk position to see it will at all
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6"));
        $desk_info=json_decode($desk_info);

        $position=$desk_info->state->position_mm;


        if($position!=$new_height) //so we don't make unnecessary records if the desk doesn't move
        {
            if(TimeData::where('uID',Auth::id())->exists())//search for the previous record and close it
            {
                $old_timedata=TimeData::where('uID', Auth::id())->latest()->first();
                $old_timedata->end_time=Carbon::now();
                $old_timedata->save();
            }
            
            $timedata=new Timedata;
            $timedata->start_time=Carbon::now();
            $timedata->end_time=Carbon::now();
            $timedata->uID=Auth::id();
            $timedata->height=$new_height;
            if($new_height>=$separator)
            {
                $timedata->mode='standing';
            }
            else
            {
                $timedata->mode='sitting';
            }

            $timedata->save();
        }
    }
}
