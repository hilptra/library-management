<?php

use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\LoanController as MemberLoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (Hanya untuk pengguna yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Admin Routes
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'admin'])->name('admin.dashboard');

    Route::resource('categories', CategoryController::class)->except(['create','show','edit']);
    Route::resource('books', BookController::class);
    Route::resource('books.copies', BookCopyController::class)
    ->shallow()
    ->only(['store', 'update', 'destroy']);

    Route::get('/loans', [LoanController::class,'index'])->name('admin.loans.index');
    Route::patch('/loans/{loan}/approve', [LoanController::class,'approve'])->name('admin.loans.approve');
    Route::patch('/loans/{loan}/reject', [LoanController::class,'reject'])->name('admin.loans.reject');
    Route::patch('/loans/{loan}/return', [LoanController::class,'return'])->name('admin.loans.return');
});


// Member Routes
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [DashboardController::class, 'member'])->name('member.dashboard');

    Route::resource('member/books', MemberBookController::class)->only(['index', 'show'])->names('member.books');
    Route::post('/member/books/{book}/loans', [MemberLoanController::class, 'store'])->name('member.loans.store');
});