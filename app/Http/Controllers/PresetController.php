<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preset;
use Illuminate\Support\Facades\Auth;

class PresetController extends Controller
{
    public function createPreset(Request $request)
    {
        $request->validate([
            "height"=>"required",
            "name"=>"required",
        ]);

        $preset=new Preset();

        $preset->height=$request->height;
        $preset->name=$request->name;
        $preset->uID=Auth::id();

        return redirect()->back();
    }


    public function deletePreset(Request $request)
    {
        $request->validate([
            "id"=>"required"
        ]);

        Preset::destroy($request->id);

        return redirect()->back();
    }


    public function updatePreset(Request $request)
    {
        $request->validate([
            "id"=>"required",
            "height"=>"required",
            "name"=>"required",
        ]);

        $preset = Preset::find($request->id);
        
        $preset->height=$request->height;
        $preset->name=$request->name;
        $preset->save();

        return redirect()->back();
    }

    public function getPresets()
    {
        $user=Auth::user();

        $presets=$user->presets();
        return redirect()->back()->with("presets", $presets);
    }
}
