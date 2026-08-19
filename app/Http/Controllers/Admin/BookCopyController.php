<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store(Request $request, Book $book)
    {
        $inventoryCode = DB::transaction(function () use ($book) {
            $lastNumber = $book->copies()
                ->lockForUpdate()
                ->selectRaw("MAX(CAST(SUBSTRING_INDEX(inventory_code, '-', -1) AS UNSIGNED)) as last_number")
                ->value('last_number');

            $nextNumber = ($lastNumber ?? 0) + 1;
            $code = 'BOOK-' . $book->id . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

            $book->copies()->create([
                'inventory_code' => $code,
                'status' => 'available',
            ]);

            return $code;
        });

        return redirect()->route('books.show', $book)->with('success', 'Eksemplar berhasil ditambahkan: ' . $inventoryCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCopy $copy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCopy $copy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCopy $copy)
    {
        $request->validate([
            'status' => 'required|in:available,reserved,borrowed,damaged,lost',
        ]);

        $copy->update([
            'status' => $request->status
        ]);

        return redirect()->route('books.show', $copy->book)->with('success','Status eksemplar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCopy $copy)
    {
        $book = $copy->book;
        $copy->delete();

        return redirect()->route('books.show', $book)->with('success','Eksemplar buku berhasil dihapus');
    }

}
