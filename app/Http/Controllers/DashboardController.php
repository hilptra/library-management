<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function admin() {
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

    public function member() {
        return view('member.dashboard');
    }
}

