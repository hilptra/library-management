<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function getDateRange(Request $request): array
    {
        $dateFrom = $request->filled('date_from')
            ? Carbon::parse($request->date_from)->startOfDay()
            : now()->startOfMonth();

        $dateTo = $request->filled('date_to')
            ? Carbon::parse($request->date_to)->endOfDay()
            : now()->endOfDay();

        return [$dateFrom, $dateTo];
    }

    public function index(Request $request)
    {
        [$dateFrom, $dateTo] = $this->getDateRange($request);

        $loans = Loan::with('bookCopy.book')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();

        $summary = [
            'total' => $loans->count(),
            'borrowed' => $loans->where('status', 'borrowed')->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'rejected' => $loans->where('status', 'rejected')->count(),
            'cancelled' => $loans->where('status', 'cancelled')->count(),
            'totalFine' => $loans->sum('fine_amount'),
        ];

        $topBooks = $loans->groupBy('bookCopy.book.id')
            ->map(fn ($group) => [
                'book' => $group->first()->bookCopy->book,
                'total' => $group->count(),
            ])
            ->sortByDesc('total')
            ->take(5);

        return view('admin.report.index', [
            'summary' => $summary,
            'topBooks' => $topBooks,
            'dateFrom' => $dateFrom->format('Y-m-d'),
            'dateTo' => $dateTo->format('Y-m-d'),
        ]);
    }

    public function export(Request $request)
    {
        [$dateFrom, $dateTo] = $this->getDateRange($request);

        $loans = Loan::with(['user', 'bookCopy.book'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->latest()
            ->get();

        $filename = 'laporan-peminjaman-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($loans) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nama Anggota', 'Judul Buku', 'Kode Eksemplar', 'Tgl Pinjam', 'Jatuh Tempo', 'Tgl Kembali', 'Denda', 'Status']);

            foreach ($loans as $loan) {
                fputcsv($handle, [
                    $loan->user->name,
                    $loan->bookCopy->book->title,
                    $loan->bookCopy->inventory_code,
                    $loan->loan_date?->format('Y-m-d') ?? '-',
                    $loan->due_date?->format('Y-m-d') ?? '-',
                    $loan->return_date?->format('Y-m-d') ?? '-',
                    $loan->fine_amount,
                    $loan->status,
                ]);
            }

            fclose($handle);
        }, $filename);
    }
}
