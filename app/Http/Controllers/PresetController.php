<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preset;
use Illuminate\Support\Facades\Auth;

class PresetController extends Controller
{
    public function setPresets(Request $request)
    {

        $request->validate([
            "standingHeight"=>"required",
            "sittingHeight"=>"required",
        ]);

        if(Preset::where('uID',Auth::id())->exists())
        {
            $standingPreset=Preset::where('uID',Auth::id())->where('name','standing')->first();
            $standingPreset->height=$request->standingHeight;
            echo($standingPreset->height);
            $standingPreset->save();

            $sittingPreset=Preset::where('uID',Auth::id())->where('name','sitting')->first();
            $sittingPreset->height=$request->sittingHeight;
            echo($sittingPreset->height);
            $sittingPreset->save();

            $feedback='New standing height:'.$standingPreset->height.' New sitting height:'.$sittingPreset->height;
        }
        else
        {
            $standingPreset=new Preset();
            $sittingPreset=new Preset();

            $standingPreset->height=$request->standingHeight;
            $standingPreset->name='standing';
            $standingPreset->uID=Auth::id();
            $standingPreset->save();

            $sittingPreset->height=$request->sittingHeight;
            $sittingPreset->name='sitting';
            $sittingPreset->uID=Auth::id();
            $sittingPreset->save();
            
            $feedback='Standing height:'.$standingPreset->height.' Sitting height:'.$sittingPreset->height;
        }

        return redirect()->back()->with('feedback' ,$feedback);
    }


    public function deletePreset(Request $request)
    {
        $request->validate([
            "id"=>"required"
        ]);

        Preset::destroy($request->id);

        return redirect()->back();
    }

    public function getPresets()
    {
        $user=Auth::user();

        $presets=$user->presets;
        return redirect()->back()->with("presets", $presets);
    }
}
