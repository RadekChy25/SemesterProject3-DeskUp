<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TimeData;

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
            if (Auth::user()->usertype == 'admin') {
                return redirect("/admin");
            } elseif (Auth::user()->usertype == 'user') {
                return redirect('/ui');
            }
        }
        return redirect('/');
    }
    

    public function logout()
    {
        Auth::logout();

        if(TimeData::where('uID',Auth::id())->exists())//search for the previous record and close it
        {
            $old_timedata=TimeData::where('uID', Auth::id())->latest()->first();
            $old_timedata->end_time=Carbon::now();
            $old_timedata->save();
        }
        
        return redirect('/');
    }
}
