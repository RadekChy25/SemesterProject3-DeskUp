<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        if(Auth::attempt($credentials))
        {
            return redirect('/ui');
        }
        else
        {
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
