<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Register
Route::get('/register', [RegisterController::class, 'showRegisterForm']);
Route::post('/register', [RegisterController::class, 'register']);

//Login
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

//Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'admin']);
});
Route::middleware(['auth','role:member'])->group(function () {
    Route::get('/member/dashboard', [DashboardController::class,'member']);
});