<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $hasReturnedLoan = Loan::where('user_id', Auth::id())
            ->where('status', 'returned')
            ->whereHas('bookCopy', fn($q) => $q->where('book_id', $book->id))
            ->exists();

        if (!$hasReturnedLoan) {
            return back()->with('error', 'Anda hanya bisa memberi ulasan untuk buku yang pernah dipinjam dan dikembalikan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}