<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('categories', 'copies')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('author', 'like', '%'.$request->search.'%')
                    ->orWhere('publisher', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        $books = $query->latest()->paginate(10)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        return view('member.book.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load('categories', 'copies', 'reviews.user');

        $totalCopies = $book->copies->count();
        $availableCount = $book->copies->where('status', 'available')->count();

        $hasReturnedLoan = Loan::where('user_id', Auth::id())
            ->where('status', 'returned')
            ->whereHas('bookCopy', fn($q) => $q->where('book_id', $book->id))
            ->exists();

        $myReview = Review::where('user_id', Auth::id())->where('book_id', $book->id)->first();

        $relatedBooks = Book::whereHas('categories', function ($q) use ($book) {
                $q->whereIn('categories.id', $book->categories->pluck('id'));
            })
            ->where('id', '!=', $book->id)
            ->with('categories', 'copies')
            ->take(3)
            ->get();

        return view('member.book.show', compact(
            'book', 'availableCount', 'totalCopies', 'hasReturnedLoan', 'myReview', 'relatedBooks'
        ));
    }
}
