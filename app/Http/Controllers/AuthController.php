<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\TimeData;
use Illuminate\Support\Facades\Http;
use App\Models\Preset;

const DEFAULT_MODE_SEPARATOR = 1000;
const URL='http://127.0.0.1:7500/api/';
const VERSION='v2/';
const API_KEY="E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Login logic here
        $request->validate([
                "name" => "required",
                "password" => "required",
            ]);

        $credentials["name"] = $request->name;
        $credentials["password"] =$request->password;

        if(Auth::attempt($credentials)){
            $this->startNewTimedata($request);
            if (Auth::user()->usertype == 'admin') {
                return redirect("/admin");
            } elseif (Auth::user()->usertype == 'user') {
                return redirect('/ui');
            }
        }
        else {
            // Authentication failed, send error message
            return back()->withErrors([
                'password' => 'Wrong password! Try again.',
            ])->onlyInput('name'); // Retain only the name input for security
        }
        return redirect('/');
    }
    

    public function logout()
    {
        if(TimeData::where('uID',Auth::id())->exists())//search for the previous record and close it
        {
            $old_timedata=TimeData::where('uID', Auth::id())->latest()->first();
            $old_timedata->end_time=Carbon::now();
            $old_timedata->save();
        }
        Auth::logout();
        return redirect('/');
    }

    private function startNewTimedata(Request $request)
    {
        $desk_info=Http::get(URL.VERSION.API_KEY.'/desks'.'/'.$request->session()->get('desk_id', "cd:fb:1a:53:fb:e6"));
        $desk_info=json_decode($desk_info);

        $position=$desk_info->state->position_mm;

        $sitting = Preset::where('uID', Auth::id())->where('name', 'sitting')->first();
        $standing = Preset::where('uID', Auth::id())->where('name', 'standing')->first();

        if ($sitting && $standing) {
            $separator = 10 * ($sitting->height + $standing->height) / 2;
        } else {
            $separator = DEFAULT_MODE_SEPARATOR;
        }

        $timedata=new Timedata;
        $timedata->start_time=Carbon::now();
        $timedata->end_time=Carbon::now();
        $timedata->uID=Auth::id();
        $timedata->height=$position;
        if($position>=$separator)
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
