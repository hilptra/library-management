<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request) {
        $status = $request->query('status', 'pending');

        $loans = Loan::with(['user', 'bookCopy.book'])
            ->where('status', $status)
            ->latest()
            ->paginate(10);

        return view('admin.loan.index', compact('loans', 'status'));
    }


    public function approve(Loan $loan) {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($loan) {
            $loan->update([
                'status' => 'borrowed',
                'loan_date' => now(),
                'due_date' => now()->addDays(7),
            ]);

        $loan->bookCopy->update(['status' => 'borrowed']);
    });

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Loan $loan) {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($loan) {
            $loan->update(['status' => 'rejected']);
            $loan->bookCopy->update(['status' => 'available']);
        });

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function return(Loan $loan) {
        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Peminjaman ini tidak dalam status dipinjam.');
        }

        DB::transaction(function () use ($loan) {
            $fine = $loan->calculateFine();

            $loan->update([
                'status' => 'returned',
                'return_date' => now(),
                'fine_amount' => $fine,
            ]);

            $loan->bookCopy->update(['status' => 'available']);
        });

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
