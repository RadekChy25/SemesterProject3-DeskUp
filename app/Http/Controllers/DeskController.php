<?php

namespace App\Http\Controllers;

use App\Models\TimeData;
use App\Models\Desks_In_Use;
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
    public function getAvaibleDesks() //get all desk keys
    {     
        $desk_id_list=Http::get(URL.VERSION.API_KEY.'/desks'); //access the desks using the defined constant
        $desk_id_list=json_decode($desk_id_list); //decode the json

        $desk_name_list=[];
        
        $desks_in_use=Desks_In_Use::all();
        $desk_id_list=array_values(array_diff($desk_id_list, $desks_in_use->pluck('desk_id')->toArray()));

        foreach ($desk_id_list as $desk) 
        {
            $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$desk);
            $desk_info=json_decode($desk_info);
            $desk_name_list[]=$desk_info->config->name;
        }

        return (view('welcome' ,['desk_names'=>$desk_name_list, 'desk_ids'=>$desk_id_list] ));
    }

    private function getDeskInfo() //get data for a specific desk
    {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.session('desk_id'));
        $desk_info=json_decode($desk_info);

        return($desk_info); 
        //accessing the data is tricky, $deskinfo->state->position_mm gets the position. For the structure refer to the readme.md of wifi2ble v2
    }

    private function getSitStandSeparator(Request $request)
    {
        if(Preset::where('uID',Auth::id())->exists()) //find the point of separation
        {
            $sitting=Preset::where('uID',Auth::id())->where('name', 'sitting')->first();
            $standing=Preset::where('uID',Auth::id())->where('name', 'standing')->first();
            $separator=($sitting->height+$standing->height)/2*10;
        }
        else
        {
            $separator=DEFAULT_MODE_SEPARATOR;
        }

        return $separator;
    }

    public function changeHeightTo(Request $request) //changes the positon to provided height
    {

        if($request->height<600)
        {
            $height_to_set=$request->height*10;
        }
        else
        {
            $height_to_set=$request->height;
        }

        $this->recordIfChanged($request, $height_to_set);

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.session('desk_id').'/state', //This is for the final version
        ['position_mm'=>$height_to_set]);
        $feedback=json_decode($feedback); //response is the new height. There are upper and lower limits, so use this for display

        return redirect()->back()->with('feedback', $feedback);
    }

    public function moveDeskBy(Request $request)
    {
        $desk_info=$this->getDeskInfo();
        $separator=$this->getSitStandSeparator($request);

        if($request->heightChange+$desk_info->state->position_mm>=$separator xor $desk_info->state->position_mm>$separator)//only start new record if the mode changed
        {
            $this->recordIfChanged($request, $request->heightChange+$desk_info->state->position_mm);
        }

        $feedback=Http::put(URL.VERSION.API_KEY.'/desks'.'/'.session('desk_id').'/state', //This is for the final version
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

        $separator=$this->getSitStandSeparator($request);
        echo($separator);

        //get current desk position to see if it will move at all
        $desk_info=$this->getDeskInfo();
        $position=$desk_info->state->position_mm;


        if($position!=$new_height) //so we don't make unnecessary records if the desk doesn't move
        {
            if(Preset::where('uID',Auth::id())->where('name','sitting')->exists() &&
            Preset::where('uID',Auth::id())->where('name','standing')->exists())//search for the previous record and close it
            {
                $old_timedata=TimeData::where('uID', Auth::id())->latest()->first();
                $dayend=new Carbon($old_timedata->end_time);
                if(!($dayend->endOfDay()->isBefore(Carbon::now()))) //it would change the times between logins
                {
                    $old_timedata->end_time=Carbon::now();
                    $old_timedata->save();
                }
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
