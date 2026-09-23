<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Book;

class ReviewController extends Controller
{
    public function index(Book $book)
    {
        $reviews = $book->reviews()->with('user')->latest()->paginate(10);

        return view('public.reviews.index', compact('book', 'reviews'));
    }
}