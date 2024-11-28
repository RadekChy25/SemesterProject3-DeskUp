<?php


use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DeskController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', function () {
    User::create(
        [
            'name'=> request('name'),
            'password'=> request('password'),
        ]
    );
    return redirect('admin');
})->name('register');

Route::post('/delete', function ($user) {
    RegistrationController::delete($user->id);
    return redirect('admin');
})->name('delete');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth');
Route::get('/admin', function(){
    return view('admin', [
        'users' => User::all()
    ]);
})->name('admin.index');
Route::get('/ui', function (){
    return view('components/ui');
});

//These are the routes for interacting with desks
Route::get('/getdesks', [DeskController::class, 'getDesks']);
Route::post('/changeDeskHeight', [DeskController::class, 'changeHeightTo'])->name('changeHeight');
Route::post('/moveDeskBy', [DeskController::class, 'moveDeskBy'])->name('moveDesk');