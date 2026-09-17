<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) {
        $query = Book::with('categories');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%')
                  ->orWhere('publisher', 'like', '%' . $request->search . '%');
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

    public function show(Book $book) {
        $book->load('categories','copies');

        return view('member.book.show', compact('book'));
    }
}
