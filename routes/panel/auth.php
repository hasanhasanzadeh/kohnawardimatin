<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:10,1')->prefix('auth')->group(function ($route){
    $route->get('/login',[UserController::class,'showLoginForm'])->name('login.show');
    $route->post('/login',[UserController::class,'login'])->name('login');
    $route->get('/logout',[UserController::class,'logout'])->name('logout');
    $route->get('/resend',[UserController::class,'resend'])->name('resend.code');
    $route->get('/verified',[UserController::class,'verifyShow'])->name('verify.show');
    $route->post('/verify',[UserController::class,'verify'])->name('verify');
});

