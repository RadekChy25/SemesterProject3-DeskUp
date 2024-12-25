<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TimeData;
class TimeDataController extends Controller
{
    public function getTimeData(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
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
        $activeStanding = Auth::user()->timedata()->where('mode', 'standing')->whereColumn('start_time','end_time')->get();
        $activeSitting = Auth::user()->timedata()->where('mode', 'sitting')->whereColumn('start_time','end_time')->get();

        $activeStandingTime = 0;
        $activeSittingTime = 0;
        // Calculate the active time for standing sessions
        if($activeStanding) {
            $start = new Carbon($stand->start_time);
            $activeStandingTime = $start->diffInMinutes(Carbon::now()); // Compare with current time
            
        }

        // Calculate the active time for sitting sessions
        if($activeSitting) {
            $start = new Carbon($sit->start_time);
            $activeSittingTime = $start->diffInMinutes(Carbon::now()); // Compare with current time
           
        }

        return view("/ui", [
            "standtime" => $standingTotal,
            "sittime" => $sittingTotal,
            "activeStandtime" => $activeStandingTime,
            "activeSittime" => $activeSittingTime
        ]);
    }
   

    public function getActivityData(Request $request)
    {
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



        //Calculating for the last week chart
        $startOfLastWeek = Carbon::now()->subDays(7)->startOfWeek();
        $endOfLastWeek = Carbon::now()->subDays(7)->endOfWeek()->subDays(2);

        $dayOfWeekDataStanding=[];
        $dayOfWeekDataSitting=[];

        for($i=$startOfLastWeek; $i<=$endOfLastWeek; $i->addDays(1))
        {
            $startOfThisDay=$i->startOfDay()->copy();
            $endOfThisDay=$i->endOfDay()->copy();

            $dayStandingTotal=0;
            foreach( $standing as $stand)
            {
                if($start->between($startOfThisDay,$endOfThisDay,true))
                {
                    $end=new Carbon($stand->end_time);
                    $start=new Carbon($stand->start_time);
                    $dayStandingTotal+=$start->diffInMinutes($end);
                }
            }
            $dayOfWeekDataStanding[$i->dayOfWeek]=$dayStandingTotal;

            $daySittingTotal=0;
            foreach( $sitting as $sit)
            {
                if($start->between($startOfThisDay,$endOfThisDay,true))
                {
                    $end=new Carbon($sit->end_time);
                    $start=new Carbon($sit->start_time);
                    $daySittingTotal+=$start->diffInMinutes($end);
                }
            }
            $dayOfWeekDataSitting[$i->dayOfWeek]=$daySittingTotal;
        }
        

        return view("/activity", ["standtime"=>$standingTotal, "sittime"=>$sittingTotal, 
        "sitpercentage"=>$sittingTotal/($sittingTotal+$standingTotal), 
        "standpercentage"=>$standingTotal/($sittingTotal+$standingTotal),
        "sittingovertime"=>$dayOfWeekDataSitting,
        "standingovertime"=>$dayOfWeekDataStanding,
        ]);
    }
}
