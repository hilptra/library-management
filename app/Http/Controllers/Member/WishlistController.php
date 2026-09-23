<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $books = Auth::user()->wishlistedBooks()
            ->with(['categories', 'copies'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest('wishlists.created_at')
            ->paginate(12);

        return view('member.wishlist.index', compact('books'));
    }

    public function toggle(Book $book)
    {
        Auth::user()->wishlistedBooks()->toggle($book->id);

        return back()->with('success', 'Daftar Keinginan diperbarui.');
    }
}
