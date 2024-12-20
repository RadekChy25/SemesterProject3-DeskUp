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
        "name" => "required",
        "password" => [
            "required",
            "string",
            "min:8",
            "regex:/[A-Z]/",
            "regex:/[!@#$%^&*]/",
        ],
        "re-password" => "required|same:password",
    ], [
        'password.min' => 'The password must be at least 8 characters.',
        'password.regex' => 'The password must contain at least one uppercase letter and one special character (!@#$%^&*).',
        're-password.same' => 'The confirmation password must match the password.',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->password = Hash::make($request->password);

    if ($request->code == 'admin') {
        $user->usertype = 'admin';
        $user->save();
        return back()->with('success', 'Success! New admin registered.');
    } elseif ($request->code == null) {
        $user->usertype = 'user';
        $user->save();
        return back()->with('success', 'Success! New user registered.');
    } else {
        return back()->with('error', 'Wrong admin code! Try again.');
    }
}
}
