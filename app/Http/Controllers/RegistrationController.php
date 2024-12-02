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
            //"uname" => "required",
            "name"=> "required",
            "password" => "required",
            //"code" => "required",
            //"usertype" => "required",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);  

        if ($request->code == 'admin') {
            $user->usertype = 'admin';
            return back()->with('success', 'Success! New admin registered.');  
        } elseif ($request->code == null) {
            $user->usertype = 'user'; 
            return back()->with('success', 'Success! New user registered.');
        } else {
            return back()->with('error', 'Wrong admin code! Try again.');
        }
        $user->save();
        return(redirect('/admin'));
    }
    public function delete(Request $request)
    {
        $userId = $request->input('id');
        $user = User::find($userId);
        if ($user) {
            $user->delete();
        }
        return redirect('admin');
    }
}
