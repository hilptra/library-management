@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2">

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
                            <th class="pb-3 px-4 text-right">Status</th>
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
                                <td class="py-3.5 px-4 text-right">
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Menunggu Persetujuan',
                                            'borrowed' => 'Dipinjam',
                                            'returned' => 'Dikembalikan',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold inline-block {{ $loan->statusBadgeClass() }}">
                                        {{ $statusLabels[$loan->status] ?? ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada riwayat
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

    </div>
@endsection
