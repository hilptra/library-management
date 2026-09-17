@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2" x-data="{
        cancelModalOpen: false,
        cancelAction: '',
        bookTitle: ''
    }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Peminjaman Saya</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Daftar status dan riwayat peminjaman buku
                    Anda</p>
            </div>
            <div>
                <a href="{{ route('member.books.index') }}"
                    class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-2xs hover:shadow-xs flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Pinjam Buku Lain</span>
                </a>
            </div>
        </div>

        {{-- Warning Alert Jika Ada Buku Overdue / Denda Aktif --}}
        @php
            $overdueLoans = $loans->filter(function ($l) {
                return $l->status === 'borrowed' && $l->calculateFine() > 0;
            });
            $totalActiveFine = $overdueLoans->sum(function ($l) {
                return $l->calculateFine();
            });
        @endphp

        @if ($overdueLoans->count() > 0)
            <div class="bg-rose-50 border border-rose-200/80 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 text-xs sm:text-sm text-rose-900 shadow-2xs">
                <div class="p-2 rounded-xl bg-rose-100 text-rose-700 shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-rose-950 text-sm sm:text-base">Peringatan Keterlambatan Pengembalian!</h4>
                    <p class="mt-0.5 leading-relaxed text-rose-800">
                        Anda memiliki <strong class="font-bold text-rose-950">{{ $overdueLoans->count() }} buku</strong> yang telah melewati tanggal jatuh tempo dengan total denda sebesar <strong class="text-rose-950 font-extrabold">Rp {{ number_format($totalActiveFine, 0, ',', '.') }}</strong>. Harap segera melakukan pengembalian buku ke petugas perpustakaan.
                    </p>
                </div>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3 px-4">Judul Buku</th>
                            <th class="pb-3 px-4">Tgl Pinjam</th>
                            <th class="pb-3 px-4">Jatuh Tempo</th>
                            <th class="pb-3 px-4">Tgl Kembali</th>
                            <th class="pb-3 px-4">Denda</th>
                            <th class="pb-3 px-4">Status</th>
                            <th class="pb-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-medium">
                        @forelse ($loans as $loan)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    {{ $loan->bookCopy->book->title ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs">
                                    {{ $loan->loan_date?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs">
                                    {{ $loan->due_date?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs">
                                    {{ $loan->return_date?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-xs font-semibold">
                                    @php
                                        $fine = $loan->status === 'returned'
                                            ? (int) $loan->fine_amount
                                            : $loan->calculateFine();
                                    @endphp
                                    @if ($fine > 0)
                                        <span class="text-rose-600 font-bold px-2.5 py-0.5 rounded-md bg-rose-50 border border-rose-100/80 inline-block">
                                            Rp {{ number_format($fine, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-normal">Rp 0</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs">
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Menunggu Persetujuan',
                                            'borrowed' => 'Dipinjam',
                                            'returned' => 'Dikembalikan',
                                            'rejected' => 'Ditolak',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold inline-block {{ $loan->statusBadgeClass() }}">
                                        {{ $statusLabels[$loan->status] ?? ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if ($loan->status === 'pending')
                                        <button type="button"
                                            @click="cancelModalOpen = true; cancelAction = '{{ route('member.loans.cancel', $loan) }}'; bookTitle = '{{ addslashes($loan->bookCopy->book->title ?? '') }}'"
                                            class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200/80 font-bold text-xs px-2.5 py-1 rounded-lg transition-colors inline-flex items-center gap-1 shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Batalkan</span>
                                        </button>
                                    @else
                                        <span class="text-slate-300 text-xs font-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Belum ada riwayat
                                    peminjaman buku</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100">
                {{ $loans->links() }}
            </div>
        </div>

        {{-- Modal Konfirmasi Batal Peminjaman --}}
        <div x-show="cancelModalOpen" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100 space-y-4"
                @click.outside="cancelModalOpen = false">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-2xl bg-rose-50 text-rose-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Batalkan Peminjaman</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">
                            Apakah Anda yakin ingin membatalkan pengajuan peminjaman untuk buku <strong
                                class="text-slate-800" x-text="'\'' + bookTitle + '\''"></strong>?
                        </p>
                    </div>
                </div>

                <form method="POST" :action="cancelAction" class="flex justify-end gap-2 pt-2">
                    @csrf
                    @method('PATCH')
                    <button type="button" @click="cancelModalOpen = false"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                        Tidak, Kembali
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-2xs transition-colors">
                        Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
