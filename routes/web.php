<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

use App\Http\Controllers\DeskController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/admin', function () {
    User::create(
        [
            'name'=> request('name'),
            'password'=> request('password'),
        ]
    );
    return redirect('admin');
})->name('admin');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth');
Route::get('/admin', function(){
    return view('admin', [
        'users' => User::all()
    ]);
})->name('admin.index');

Route::get('/getdesks', [DeskController::class, 'getDesks']);