<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mode;
use Carbon\Carbon;
class ModeController extends Controller
{
    public function SetCleaningMode(Request $request)
    {
        $request->validate([
            "height"=> "required",
            "starttime"=> "required",
            "duration"=> "required",
        ]);

        if(Mode::where('id')->exists())
        {
            $cleaningmode = Mode::first()->get();
        }
        else
        {
            $cleaningmode = new Mode();
        }

        $cleaningmode->name='cleaningmode';
        $cleaningmode->height=$request->height;
        $cleaningmode->starttime=Carbon::parse($request->starttime);
        $cleaningmode->endtime=Carbon::parse($request->starttime)->addMinutes($request->duration);
        $cleaningmode->save();
    }

    public function SetDiscoMode(Request $request)
    {
        $request->validate([
            "height"=> "required",
            "starttime"=> "required",
            "duration"=> "required",
        ]);

        if(Mode::where('id')->exists())
        {
            $cleaningmode = Mode::first()->get();
        }
        else
        {
            $cleaningmode = new Mode();
        }

        $cleaningmode->name='discomode';
        $cleaningmode->height=$request->height;
        $cleaningmode->starttime=Carbon::parse($request->starttime);
        $cleaningmode->endtime=Carbon::parse($request->starttime)->addMinutes($request->duration);
        $cleaningmode->save();
    }

    public function SetFancyMode(Request $request)
    {
        $request->validate([
            "height"=> "required",
            "starttime"=> "required",
            "duration"=> "required",
        ]);

        if(Mode::where('id')->exists())
        {
            $cleaningmode = Mode::first()->get();
        }
        else
        {
            $cleaningmode = new Mode();
        }

        $cleaningmode->name='fancymode';
        $cleaningmode->height=$request->height;
        $cleaningmode->starttime=Carbon::parse($request->starttime);
        $cleaningmode->endtime=Carbon::parse($request->starttime)->addMinutes($request->duration);
        $cleaningmode->save();
    }
}
