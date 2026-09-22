<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latestBooks = Book::with('categories')->latest()->take(4)->get();
        $categoriesWithCount = Category::withCount('books')->orderByDesc('books_count')->take(5)->get();

        return view('welcome', compact('latestBooks', 'categoriesWithCount'));
    }
}