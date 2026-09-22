<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('categories');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }

        $books = $query->latest()->paginate(12)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        return view('public.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load('categories', 'copies');
        $availableCount = $book->copies->where('status', 'available')->count();
        $totalCopies = $book->copies->count();

        // Buku serupa berdasarkan kategori yang sama
        $categoryIds = $book->categories->pluck('id');
        $relatedBooks = Book::with('categories', 'copies')
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->where('id', '!=', $book->id)
            ->take(3)
            ->get();

        return view('public.books.show', compact('book', 'availableCount', 'totalCopies', 'relatedBooks'));
    }
}