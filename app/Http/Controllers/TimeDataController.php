<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeDataController extends Controller
{
    public function getTimeData(Request $request)
    {
        $deskController = DeskController::class;
        $deskInfo = $deskController::getDeskInfo();
        $standing =Auth::user()->timedata()->where('mode', 'standing')->get();
        $sitting = Auth::user()->timedata()->where('mode', 'sitting')->get();

        $standingTotal=0;
        $sittingTotal=0;

        foreach ($standing as $stand) 
        {
            $end=new Carbon($stand->end_time);
            $start=new Carbon($stand->start_time);
            $time=$start->diffInMinutes($end);
            $standingTotal+=$time;
        }

        foreach ($sitting as $sit) 
        {
            $end=new Carbon($sit->end_time);
            $start=new Carbon($sit->start_time);
            $time=$start->diffInMinutes($end);
            $sittingTotal+=$time;
        }

        return view("/ui", ["standtime"=>$standingTotal, "sittime"=>$sittingTotal, "deskInfo"=>$deskInfo]);

    }
}
