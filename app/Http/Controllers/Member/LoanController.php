<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('bookCopy.book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('member.loan.index', compact('loans'));
    }

    public function store(Request $request, Book $book) {

        // 1. Cek apakah user sudah punya pengajuan aktif untuk buku ini
        $existingLoan = Loan::where('user_id', Auth::id())
        ->whereIn('status', ['pending','borrowed'])
        ->whereHas('bookCopy', function ($query) use ($book) {
            $query->where('book_id', $book->id);
        })
        ->exists();

        if ($existingLoan) {
            return back()->with('error','Anda masih memiliki pengajuan aktif');
        }

        // 2. Cari BookCopy yang available, lock supaya aman dari race condition
        DB::transaction(function () use ($book) {
            $availableCopy = $book->copies()
            ->where('status','available')
            ->lockForUpdate()
            ->first();

            if (!$availableCopy) {
                abort(422,'Tidak ada eksemplar yang tersedia saat ini.');
            }

            Loan::create([
                'user_id' => Auth::id(),
                'book_copy_id' => $availableCopy->id,
                'status' => 'pending'
            ]);

            $availableCopy->update(['status' => 'reserved']);
        });

        return redirect()->route('member.books.show', $book)->with('success','Pengajuan peminjaman berhasil dikirim, menunggu persetujuan admin.');
    }
}
