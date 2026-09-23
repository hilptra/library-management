<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalBooksCount = Book::count();
        $activeMembersCount = User::where('role', 'member')->where('status', 'active')->count();
        $booksBorrowedCount = Loan::where('status', 'borrowed')->count();
        $overdueReturnsCount = Loan::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->count();

        $recentActivities = Loan::with(['user', 'bookCopy.book'])
            ->latest()
            ->take(5)
            ->get();

        $newRegistrations = User::where('role', 'member')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooksCount',
            'activeMembersCount',
            'booksBorrowedCount',
            'overdueReturnsCount',
            'recentActivities',
            'newRegistrations'
        ));
    }

    public function member()
    {
        $user = Auth::user();

        $settings = [
            'fine_per_day' => (int) Setting::get('fine_per_day', 1000),
            'loan_duration_days' => (int) Setting::get('loan_duration_days', 7),
            'max_active_loans' => (int) Setting::get('max_active_loans', 3),
        ];

        $activeLoans = Loan::with(['bookCopy.book'])
            ->where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->orderBy('due_date', 'asc')
            ->get();

        $latestBooks = Book::with(['categories', 'copies'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->take(6)
            ->get();

        $wishlistBooks = $user->wishlistedBooks()
            ->with(['categories', 'copies'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest('wishlists.created_at')
            ->take(4)
            ->get();

        return view('member.dashboard', compact('activeLoans', 'latestBooks', 'wishlistBooks', 'settings'));
    }
}
