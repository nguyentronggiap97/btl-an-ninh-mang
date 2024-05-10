<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RSAController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/generate-key', [RSAController::class, 'register'])->name('generate-key');
Route::get('/test', [RSAController::class, 'test'])->name('test');


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/messages', [HomeController::class, 'messages'])->name('messages');
Route::post('/message', [HomeController::class, 'message'])->name('message');
