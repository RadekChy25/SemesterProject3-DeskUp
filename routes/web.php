<?php


use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DeskController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Users;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [RegistrationController::class,'register'])->name('register');

Route::get('/admin', function(){
    return view('admin', [
        'users' => User::all()
    ]);
})->middleware(Admin::class)->name('admin.index');

Route::post('/delete', [RegistrationController::class, 'delete'])->name('delete');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/ui', function (){
    return view('/ui');
})->middleware(User::class);

//These are the routes for interacting with desks
Route::get('/getdesks', [DeskController::class, 'getDesks']);
Route::post('/changeDeskHeight', [DeskController::class, 'changeHeightTo'])->name('changeHeight');
Route::post('/moveDeskBy', [DeskController::class, 'moveDeskBy'])->name('moveDesk');

Route::get('/faq', function () {
    return view('/faq');
})->name('faq');

Route::get('/ui', function (){
    return view('/ui');
})->name('ui');
Route::get('/activity', function () {
    return view('/activity');
})->name('activity');