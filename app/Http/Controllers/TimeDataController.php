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
        $standing =Auth::user()->timedata()->where('mode', 'standing')->get();
        $sitting = Auth::user()->timedata()->where('mode', 'sitting')->get();

        $standingTotal=0;
        $sittingTotal=0;

        foreach ($standing as $stand) 
        {
            $end=new Carbon($stand->end_time);
            $start=new Carbon($stand->start_time);
            $time=$end->subtract($start);
            echo nl2br($start."\n");
            echo nl2br($end."\n");
            echo nl2br($time."\n"."\n");
        }

        $that=tat;

    }
}
