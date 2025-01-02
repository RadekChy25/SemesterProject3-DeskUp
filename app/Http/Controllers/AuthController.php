<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\TimeData;
use App\Models\Desks_In_Use;
use Illuminate\Support\Facades\Http;
use App\Models\Preset;



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

            session(['desk_id'=>$request->desks]);
            $use_desk=new Desks_In_Use();
            $use_desk->desk_id=$request->desks;
            $use_desk->save();

            if(session('desk_id'!='no_desk'))$this->startNewTimedata($request);
            
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

        session(['sit_stand_logout_state'=>0]);

        $desk=session('desk_id');
        Desks_In_Use::where('desk_id', $desk)->delete();

        Auth::logout();
        return redirect('/');
    }

    private function startNewTimedata(Request $request)
    {
        $url=config('constants.URL');
        $version=config('constants.VERSION');
        $api_key=config('constants.API_KEY');

        $desk_info=Http::get($url.$version.$api_key.'/desks'.'/'.$request->session()->get('desk_id'));
        $desk_info=json_decode($desk_info);

        $position=$desk_info->state->position_mm;

        if(Preset::where('uID',Auth::id())->where('name','sitting')->exists() &&
        Preset::where('uID',Auth::id())->where('name','standing')->exists()) //find the point of separation
        {
            $sitting=Preset::where('uID',Auth::id())->where('name', 'sitting')->first();
            $standing=Preset::where('uID',Auth::id())->where('name', 'standing')->first();
            $separator=10*($sitting->height+$standing->height)/2;
        }
        else
        {
            $separator=config('constants.DEFAULT_MODE_SEPARATOR');
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
