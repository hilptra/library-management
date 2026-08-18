<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::with('categories')->latest()->paginate(10);
        return view('member.book.index', compact('books'));
    }

    public function show(Book $book) {
        $book->load('categories','copies');

        return view('member.book.show', compact('book'));
    }
}
