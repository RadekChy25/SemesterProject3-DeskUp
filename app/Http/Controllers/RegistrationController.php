<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "uname" => "required",
            "name"=> "required",
            "password" => "required",
            "usertype" => "required",
        ]);

        if($request->code==123456789)
        {

            $user=new User();
        
            $user->uname = $request->uname;
            $user->name =$request->name;
            $user->password = Hash::make($request->password);
            $user->type =$request->usertype;

            if ($user->save())
            {
            }

        }
        else
        {
        }
    }
    public static function delete(User $user)
    {
        User::destroy($user->id);
        return(redirect("/management"));
    }
}
