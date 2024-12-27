<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mode;
use Carbon\Carbon;
class ModeController extends Controller
{

    public function setModes(Request $request)
    {
        if ($request->has("cleanCheckbox")) {
            $request->validate([
                "cleanDuration"=> "required",
                "cleanStartHour"=> "required",
                "cleanHeight"=> "required",
            ]);
            $this->setCleaningMode($request->cleanHeight, $request->cleanStartHour, $request->cleanDuration);
        }

        if ($request->has("discoCheckbox")) {
            $request->validate([
                "discoDuration"=> "required",
                "discoStartHour"=> "required",
                "discoHeight"=> "required",
            ]);
            $this->setDiscoMode($request->discoHeight, $request->discoStartHour, $request->discoDuration);
        }

        if ($request->has("fancyCheckbox")) {
            $request->validate([
                "fancyDuration"=> "required",
                "fancyStartHour"=> "required",
                "fancyHeight"=> "required",
            ]);
            $this->setFancyMode($request->fancyHeight, $request->fancyStartHour, $request->fancyDuration);
        }
        
        return redirect()->back();
    }

    private function setCleaningMode($height, $starttime, $duration)
    {
        if(Mode::where('name','cleaningmode')->exists())
        {
            $cleaningmode = Mode::where('name', 'cleaningmode')->first();
        }
        else
        {
            $cleaningmode = new Mode();
        }

        $cleaningmode->name='cleaningmode';
        $cleaningmode->height=$height;
        $cleaningmode->start_time=Carbon::parse($starttime,'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');
        $cleaningmode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        $cleaningmode->save();
    }

    private function setDiscoMode($height, $starttime, $duration)
    {
        if(Mode::where('name', 'discomode')->exists())
        {
            $discomode = Mode::where('name', 'discomode')->first();
        }
        else
        {
            $discomode = new Mode();
        }

        $discomode->name='discomode';
        $discomode->height=$height;
        $discomode->start_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');
        $discomode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        $discomode->save();
    }

    private function setFancyMode($height, $starttime, $duration)
    {

        if(Mode::where('name', 'fancymode')->exists())
        {
            $fancymode = Mode::where('name', 'fancymode')->first();
        }
        else
        {
            $fancymode = new Mode();
        }

        $fancymode->name='fancymode';
        $fancymode->height=$height;
        $fancymode->start_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');
        $fancymode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        $fancymode->save();
    }
}
