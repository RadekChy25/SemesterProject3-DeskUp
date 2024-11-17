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
                "username" => "required",
                "password" => "required",
            ]);

        $credentials["username"] = $request->username;
        $credentials["password"] =$request->password;

        if(Auth::attempt($credentials))
        {
        }
        else
        {
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
