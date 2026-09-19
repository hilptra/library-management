@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="space-y-6 pb-8">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
            <div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Laporan Peminjaman</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">
                    Analisis ringkasan peminjaman, status denda, dan tren buku terpopuler.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-2 bg-emerald-50 text-[#166534] border border-emerald-200/80 px-3.5 py-2 rounded-xl text-xs font-semibold shadow-2xs">
                    <svg class="w-4 h-4 text-[#166534]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($dateFrom)->translatedFormat('d M Y') }} &ndash;
                        {{ \Carbon\Carbon::parse($dateTo)->translatedFormat('d M Y') }}</span>
                </span>
            </div>
        </div>

        {{-- Filter & Action Card --}}
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100">
            <form method="GET" action="{{ route('admin.reports.index') }}"
                class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="flex flex-wrap items-end gap-3 flex-1">
                    <div class="w-full sm:w-auto flex-1 min-w-40">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a] transition-all">
                    </div>
                    <div class="w-full sm:w-auto flex-1 min-w-40">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a] transition-all">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="bg-[#409a63] hover:bg-[#348353] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-xs hover:shadow-md transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Terapkan</span>
                        </button>
                        @if (request()->has('date_from') || request()->has('date_to'))
                            <a href="{{ route('admin.reports.index') }}"
                                class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-colors"
                                title="Reset Filter">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                <div class="pt-2 md:pt-0 border-t md:border-t-0 border-slate-100 flex justify-end">
                    <a href="{{ route('admin.reports.export', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                        class="w-full sm:w-auto bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Export CSV</span>
                    </a>
                </div>
            </form>
        </div>

        {{-- Ringkasan Metrics Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            {{-- Metric 1: Total Pengajuan --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-slate-100 p-2.5 rounded-xl text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Total Transaksi</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pengajuan</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">
                        {{ number_format($summary['total']) }}
                    </h3>
                </div>
            </div>

            {{-- Metric 2: Sedang Dipinjam --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-blue-50 p-2.5 rounded-xl text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Sedang Berjalan</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-blue-500 uppercase tracking-wider">Sedang Dipinjam</span>
                    <h3 class="text-3xl font-extrabold text-blue-700 mt-1 tracking-tight">
                        {{ number_format($summary['borrowed']) }}
                    </h3>
                </div>
            </div>

            {{-- Metric 3: Dikembalikan --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-emerald-50 p-2.5 rounded-xl text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Selesai</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Dikembalikan</span>
                    <h3 class="text-3xl font-extrabold text-emerald-700 mt-1 tracking-tight">
                        {{ number_format($summary['returned']) }}
                    </h3>
                </div>
            </div>

            {{-- Metric 4: Ditolak --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-rose-50 p-2.5 rounded-xl text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Ditolak</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-rose-500 uppercase tracking-wider">Pengajuan Ditolak</span>
                    <h3 class="text-3xl font-extrabold text-rose-600 mt-1 tracking-tight">
                        {{ number_format($summary['rejected']) }}
                    </h3>
                </div>
            </div>

            {{-- Metric 5: Dibatalkan --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-amber-50 p-2.5 rounded-xl text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Batal</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Dibatalkan Anggota</span>
                    <h3 class="text-3xl font-extrabold text-amber-700 mt-1 tracking-tight">
                        {{ number_format($summary['cancelled']) }}
                    </h3>
                </div>
            </div>

            {{-- Metric 6: Total Denda Terkumpul --}}
            <div
                class="bg-linear-to-br from-slate-900 to-slate-800 rounded-2xl p-5 shadow-sm text-white flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-white/10 p-2.5 rounded-xl text-emerald-400 backdrop-blur-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-bold text-emerald-300 bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-500/30">Pendapatan
                        Denda</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">Total Denda
                        Terkumpul</span>
                    <h3 class="text-3xl font-extrabold text-white mt-1 tracking-tight">
                        Rp {{ number_format($summary['totalFine'], 0, ',', '.') }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- Buku Terpopuler Section --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-xl bg-amber-50 text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">5 Buku Paling Sering Dipinjam</h2>
                        <p class="text-xs text-slate-500 font-medium">Buku favorit anggota perpustakaan pada periode yang
                            dipilih.</p>
                    </div>
                </div>
            </div>

            @if ($topBooks->isEmpty())
                <div class="py-12 text-center flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Belum ada data peminjaman</p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Tidak ada transaksi peminjaman buku pada periode
                        rentang tanggal ini.</p>
                </div>
            @else
                @php
                    $maxBorrow = $topBooks->max('total') ?: 1;
                @endphp
                <div class="space-y-4">
                    @foreach ($topBooks as $item)
                        @php
                            $percentage = round(($item['total'] / $maxBorrow) * 100);
                        @endphp
                        <div
                            class="p-4 rounded-xl bg-slate-50/70 hover:bg-slate-100/70 transition-colors border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3.5 flex-1 min-w-0">
                                {{-- Rank Badge --}}
                                <div
                                    class="w-8 h-8 rounded-xl font-black text-xs flex items-center justify-center shrink-0 shadow-2xs {{ $loop->iteration === 1 ? 'bg-amber-400 text-amber-950' : ($loop->iteration === 2 ? 'bg-slate-300 text-slate-800' : ($loop->iteration === 3 ? 'bg-amber-700 text-amber-50' : 'bg-slate-200 text-slate-600')) }}">
                                    #{{ $loop->iteration }}
                                </div>

                                {{-- Cover image / placeholder --}}
                                @if (isset($item['book']->cover_image) && $item['book']->cover_image)
                                    <img src="{{ Storage::url($item['book']->cover_image) }}"
                                        alt="{{ $item['book']->title }}"
                                        class="w-10 h-14 object-cover rounded-md shadow-2xs shrink-0">
                                @else
                                    <div
                                        class="w-10 h-12 bg-emerald-100/70 text-[#166534] rounded-lg flex items-center justify-center shrink-0 font-bold text-xs shadow-2xs">
                                        <svg class="w-5 h-5 text-[#16a34a]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Book info & progress bar --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-slate-900 truncate">{{ $item['book']->title }}</h4>
                                    <p class="text-xs text-slate-500 font-medium truncate">
                                        {{ $item['book']->author ?? 'Penulis tidak diketahui' }}</p>

                                    {{-- Visual Progress Bar --}}
                                    <div class="w-full bg-slate-200/80 rounded-full h-1.5 mt-2 overflow-hidden">
                                        <div class="bg-[#16a34a] h-1.5 rounded-full transition-all duration-500"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Borrow Count Pill --}}
                            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                                <span
                                    class="bg-[#dcfce7] text-[#15803d] font-bold text-xs px-3 py-1.5 rounded-full shadow-2xs border border-emerald-200/60">
                                    {{ $item['total'] }}x dipinjam
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
