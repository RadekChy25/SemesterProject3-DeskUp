<?php


use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DeskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresetController;
use App\Http\Controllers\TimeDataController;
use App\Http\Controllers\ModeController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Users;

Route::get('/', [DeskController::class,'getAvaibleDesks']);

Route::post('/register', [RegistrationController::class,'register'])->name('register');

Route::get('/admin', [ModeController::class, 'getModesForAdmin']
)->middleware(Admin::class)->name('admin.index');

Route::post('/delete', [RegistrationController::class, 'delete'])->name('delete');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/ui', [TimeDataController::class, 'getTimeData'])->middleware(User::class);
Route::get ('/activity', [TimeDataController::class,'getActivityData'])->name('activity');

Route::post('/setpresets', [PresetController::class,'setPresets'])->name('setpresets');
Route::post('/setmodes', [ModeController::class, 'setModes'])->name('setmodes');

Route::post('/changeDeskHeight', [DeskController::class, 'changeHeightTo'])->name('changeHeight');
Route::post('/moveDeskBy', [DeskController::class, 'moveDeskBy'])->name('moveDesk');
Route::post('/sitDown', [DeskController::class, 'sitDown'])->name('sitDown');
Route::post('/standUp', [DeskController::class, 'standUp'])->name('standUp');

Route::get('/faq', function () {
    return view('/faq');
})->name('faq');

Route::get('/ui', [TimeDataController::class, 'getTimeData'])->name('ui');

