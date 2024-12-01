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
        return redirect('/');
    }
}
