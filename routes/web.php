<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\LoanController as MemberLoanController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\WishlistController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\BookController as PublicBookController;

// Guest Routes (Hanya untuk pengguna yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Public Routes
Route::get('/catalog', [PublicBookController::class, 'index'])->name('public.books.index');
Route::get('/catalog/{book}', [PublicBookController::class, 'show'])->name('public.books.show');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Categories Routes
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);

    // Book Routes
    Route::resource('books', BookController::class);
    Route::resource('books.copies', BookCopyController::class)
        ->shallow()
        ->only(['store', 'update', 'destroy']);

    // Loan Routes
    Route::get('/loans', [LoanController::class, 'index'])->name('admin.loans.index');
    Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('admin.loans.approve');
    Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('admin.loans.reject');
    Route::patch('/loans/{loan}/return', [LoanController::class, 'return'])->name('admin.loans.return');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');

    // Setting Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Report Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
});

// Member Routes
Route::middleware(['auth', 'active', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [DashboardController::class, 'member'])->name('member.dashboard');

    // Book Routes
    Route::resource('member/books', MemberBookController::class)->only(['index', 'show'])->names('member.books');
    Route::post('/member/books/{book}/loans', [MemberLoanController::class, 'store'])->name('member.loans.store');
    Route::get('/member/loans', [MemberLoanController::class, 'index'])->name('member.loans.index');
    Route::patch('/member/loans/{loan}/cancel', [MemberLoanController::class, 'cancel'])->name('member.loans.cancel');

    // Profile Routes
    Route::get('/member/profile', [ProfileController::class, 'index'])->name('member.profile.index');
    Route::get('/member/profile/edit', [ProfileController::class, 'edit'])->name('member.profile.edit');
    Route::patch('/member/profile', [ProfileController::class, 'update'])->name('member.profile.update');
    Route::patch('/member/profile/password', [ProfileController::class, 'updatePassword'])->name('member.profile.password');

    // Wishlist Routes
    Route::get('/member/wishlist', [WishlistController::class, 'index'])->name('member.wishlist.index');
    Route::post('/member/wishlist/{book}/toggle', [WishlistController::class, 'toggle'])->name('member.wishlist.toggle');
});

