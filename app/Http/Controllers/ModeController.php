<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mode;
use App\Models\User;
use Carbon\Carbon;
class ModeController extends Controller
{
    public function getModesForAdmin()
    {
        $cleaningmode=$fancymode=$discomode=null;
        if(Mode::where('name','cleaningmode')->exists())
        {
            $cleaningmode = Mode::where('name', 'cleaningmode')->first();
            $cleaningmode->duration=Carbon::parse($cleaningmode->start_time)->diffInMinutes(Carbon::parse($cleaningmode->end_time));
            $cleaningmode->start_time=Carbon::parse($cleaningmode->start_time,'UTC')->setTimezone('Europe/Copenhagen')->format('H:i');
        }
        
        if(Mode::where('name', 'discomode')->exists())
        {
            $discomode = Mode::where('name', 'discomode')->first();
            $discomode->duration=Carbon::parse($discomode->start_time)->diffInMinutes(Carbon::parse($discomode->end_time));
            $discomode->start_time=Carbon::parse($discomode->start_time,'UTC')->setTimezone('Europe/Copenhagen')->format('H:i');
        }

        if(Mode::where('name', 'fancymode')->exists())
        {
            $fancymode = Mode::where('name', 'fancymode')->first();
            $fancymode->duration=Carbon::parse($fancymode->start_time)->diffInMinutes(Carbon::parse($fancymode->end_time));
            $fancymode->start_time=Carbon::parse($fancymode->start_time,'UTC')->setTimezone('Europe/Copenhagen')->format('H:i');
        }
        
        
        if(!is_null($cleaningmode)&&!is_null($fancymode)&&!is_null($discomode))
        {
            return view("/admin", ['cleaningmode'=>$cleaningmode, 'discomode'=>$discomode, 'fancymode'=>$fancymode, 'users' => User::all()]);
        }
        
        else return view("/admin", ['cleaningmode'=>null, 'discomode'=>null, 'fancymode'=>null, 'users' => User::all()]);
        
    }

    public function setModes(Request $request)
    {
        //Don't block changes if mode is not active
        if($request->has("cleanCheckbox")) $request->validate(["cleanHeight"=> "required",]);
        if($request->has("discoCheckbox")) $request->validate(["discoHeight"=> "required",]);
        if($request->has("fancyCheckbox")) $request->validate(["fancyHeight"=> "required",]);

        $this->setCleaningMode($request->cleanHeight, $request->cleanStartHour, $request->cleanDuration, $request->has("cleanCheckbox"));
        
        $this->setDiscoMode($request->discoHeight, $request->discoStartHour, $request->discoDuration, $request->has("discoCheckbox"));
        
        $this->setFancyMode($request->fancyHeight, $request->fancyStartHour, $request->fancyDuration, $request->has("fancyCheckbox"));

        return redirect()->back();
    }

    private function setCleaningMode($height, $starttime, $duration, $is_activated)
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

        !is_null($height)?$cleaningmode->height=$height:$cleaningmode->height=60;

        if(is_null($duration)) $duration=5;
        if(!is_null($starttime))
        {
            $cleaningmode->start_time=Carbon::parse($starttime,'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $cleaningmode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }
        else
        {
            $cleaningmode->start_time=Carbon::parse("00:00",'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $cleaningmode->end_time=Carbon::parse("00:00", 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }

        $cleaningmode->is_active=$is_activated;

        $cleaningmode->save();
    }

    private function setDiscoMode($height, $starttime, $duration, $is_activated)
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

        !is_null($height)?$discomode->height=$height:$discomode->height=60;

        if(is_null($duration)) $duration=5;
        if(!is_null($starttime))
        {
            $discomode->start_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $discomode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }
        else
        {
            $discomode->start_time=Carbon::parse("00:00", 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $discomode->end_time=Carbon::parse("00:00", 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }

        $discomode->is_active=$is_activated;

        $discomode->save();
    }

    private function setFancyMode($height, $starttime, $duration, $is_activated)
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

        !is_null($height)?$fancymode->height=$height:$fancymode->height=60;

        if(is_null($duration)) $duration=5;
        if(!is_null($starttime))
        {
            $fancymode->start_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $fancymode->end_time=Carbon::parse($starttime, 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }
        else
        {
            $fancymode->start_time=Carbon::parse("00:00", 'Europe/Copenhagen')->setTimezone('UTC')->format('H:i');

            $fancymode->end_time=Carbon::parse("00:00", 'Europe/Copenhagen')->setTimezone('UTC')->addMinutes((int)$duration)->format('H:i');
        }

        $fancymode->is_active=$is_activated;
        
        $fancymode->save();
    }
}
