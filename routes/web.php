<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'admin']);
});
Route::middleware(['auth','role:member'])->group(function () {
    Route::get('/member/dashboard', [DashboardController::class,'member']);
});