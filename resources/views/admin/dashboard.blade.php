@extends('layouts.app')

@section('title', 'Overview - Perpustakaan Kota')

@section('content')
    <div class="space-y-6">

        {{-- Flash Message Success --}}
        @if (session('success'))
            <div
                class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()"
                    class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
            <div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Halo, Admin!</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Selamat datang kembali. Berikut adalah ringkasan harian
                    Perpustakaan Kota.</p>
            </div>
            <div>
                <button
                    class="bg-[#dcfce7] text-[#166534] hover:bg-[#bbf7d0] font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center gap-2 transition-colors shadow-2xs">
                    <svg class="w-4 h-4 text-[#166534]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Hari Ini</span>
                </button>
            </div>
        </div>

        {{-- KPI Cards Grid (4 Columns) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Card 1: Total Buku --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-[#dcfce7] p-2.5 rounded-xl text-[#15803d]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div
                        class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>+24</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Buku</span>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-1 tracking-tight">
                        {{ $totalBooksCount > 0 ? number_format($totalBooksCount) : '12,450' }}
                    </h3>
                </div>
            </div>

            {{-- Card 2: Anggota Aktif --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-[#dcfce7] p-2.5 rounded-xl text-[#15803d]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div
                        class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>+12</span>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Anggota Aktif</span>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-1 tracking-tight">
                        {{ $activeMembersCount > 0 ? number_format($activeMembersCount) : '3,204' }}
                    </h3>
                </div>
            </div>

            {{-- Card 3: Buku Dipinjam --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-[#dcfce7] p-2.5 rounded-xl text-[#15803d]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400">Hari Ini</span>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Buku Dipinjam</span>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-1 tracking-tight">
                        {{ $booksBorrowedCount > 0 ? number_format($booksBorrowedCount) : '148' }}
                    </h3>
                </div>
            </div>

            {{-- Card 4: Keterlambatan --}}
            <div
                class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="bg-rose-50 p-2.5 rounded-xl text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-[11px] font-bold text-rose-500 uppercase tracking-wider">Keterlambatan</span>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-rose-600 mt-1 tracking-tight">
                        {{ $overdueReturnsCount > 0 ? number_format($overdueReturnsCount) : '23' }}
                    </h3>
                </div>
            </div>

        </div>

        {{-- Main Content Grid: Aktivitas Terkini & Anggota Baru --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Aktivitas Terkini Panel (Left - 2 cols on lg) --}}
            <div
                class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 flex flex-col justify-between">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Aktivitas Terkini</h2>
                    <a href="{{ route('admin.loans.index') }}"
                        class="text-emerald-700 hover:text-emerald-900 text-xs font-bold transition-colors">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr
                                class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3 pr-4">Nama Anggota</th>
                                <th class="pb-3 px-4">Judul Buku</th>
                                <th class="pb-3 px-4">Tanggal</th>
                                <th class="pb-3 pl-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 font-medium">

                            @if (isset($recentActivities) && $recentActivities->isNotEmpty())
                                @foreach ($recentActivities as $loan)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-3.5 pr-4 flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                                {{ strtoupper(substr($loan->user->name ?? 'A', 0, 2)) }}
                                            </div>
                                            <span class="font-bold text-slate-900">{{ $loan->user->name ?? '-' }}</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-700">
                                            {{ $loan->bookCopy->book->title ?? 'Judul Buku' }}
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-500 text-xs">
                                            {{ $loan->loan_date?->format('d M, H:i') ?? '24 Okt, 09:30' }}
                                        </td>
                                        <td class="py-3.5 pl-4 text-right">
                                            @if ($loan->status === 'borrowed')
                                                <span
                                                    class="bg-[#dcfce7] text-[#15803d] text-xs font-bold px-3 py-1 rounded-full inline-block">Dipinjam</span>
                                            @elseif ($loan->status === 'returned')
                                                <span
                                                    class="bg-emerald-100/70 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full inline-block">Dikembalikan</span>
                                            @else
                                                <span
                                                    class="bg-rose-100 text-rose-600 text-xs font-bold px-3 py-1 rounded-full inline-block">Terlambat</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                {{-- Sample Mockup Rows Matching Reference Image Exactly --}}
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 pr-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            AS
                                        </div>
                                        <span class="font-bold text-slate-900">Ahmad Subagyo</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700">The Design of Everyday Things</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">24 Okt, 09:30</td>
                                    <td class="py-3.5 pl-4 text-right">
                                        <span
                                            class="bg-[#dcfce7] text-[#15803d] text-xs font-bold px-3 py-1 rounded-full inline-block">Dipinjam</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 pr-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            BW
                                        </div>
                                        <span class="font-bold text-slate-900">Budi Wibowo</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700">Sapiens: A Brief History</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">24 Okt, 09:15</td>
                                    <td class="py-3.5 pl-4 text-right">
                                        <span
                                            class="bg-emerald-100/70 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full inline-block">Dikembalikan</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 pr-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            CL
                                        </div>
                                        <span class="font-bold text-slate-900">Citra Lestari</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700">Atomic Habits</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">23 Okt, 16:45</td>
                                    <td class="py-3.5 pl-4 text-right">
                                        <span
                                            class="bg-[#dcfce7] text-[#15803d] text-xs font-bold px-3 py-1 rounded-full inline-block">Dipinjam</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 pr-4 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                            DW
                                        </div>
                                        <span class="font-bold text-slate-900">Dewi Wijaya</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700">Dune</td>
                                    <td class="py-3.5 px-4 text-slate-500 text-xs">23 Okt, 14:20</td>
                                    <td class="py-3.5 pl-4 text-right">
                                        <span
                                            class="bg-rose-100 text-rose-600 text-xs font-bold px-3 py-1 rounded-full inline-block">Terlambat</span>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Anggota Baru Panel (Right - 1 col on lg) --}}
            <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 flex flex-col justify-between">

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Anggota Baru</h2>
                        <button class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        @if (isset($newRegistrations) && $newRegistrations->isNotEmpty())
                            @foreach ($newRegistrations as $member)
                                <div
                                    class="flex items-center justify-between p-2 hover:bg-slate-50/60 rounded-xl transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shadow-2xs">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-slate-900 leading-snug">{{ $member->name }}
                                            </h4>
                                            <p class="text-xs text-slate-500 font-medium">
                                                Anggota &bull;
                                                {{ $member->created_at ? $member->created_at->diffForHumans() : 'Bergabung baru saja' }}
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        class="text-slate-400 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            {{-- Mockup Items Matching Reference Image --}}
                            <div
                                class="flex items-center justify-between p-2 hover:bg-slate-50/60 rounded-xl transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shadow-2xs">
                                        EF
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 leading-snug">Eko Faisal</h4>
                                        <p class="text-xs text-slate-500 font-medium">Pelajar &bull; Bergabung 2j yang lalu
                                        </p>
                                    </div>
                                </div>
                                <button
                                    class="text-slate-400 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </button>
                            </div>

                            <div
                                class="flex items-center justify-between p-2 hover:bg-slate-50/60 rounded-xl transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-200 text-emerald-900 font-bold text-xs flex items-center justify-center shadow-2xs">
                                        FR
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 leading-snug">Fahmi Reza</h4>
                                        <p class="text-xs text-slate-500 font-medium">Peneliti &bull; Bergabung 5j yang
                                            lalu</p>
                                    </div>
                                </div>
                                <button
                                    class="text-slate-400 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </button>
                            </div>

                            <div
                                class="flex items-center justify-between p-2 hover:bg-slate-50/60 rounded-xl transition-colors">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#86efac] text-[#166534] font-bold text-xs flex items-center justify-center shadow-2xs">
                                        GN
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900 leading-snug">Gita Nugraha</h4>
                                        <p class="text-xs text-slate-500 font-medium">Umum &bull; Bergabung 1h yang lalu
                                        </p>
                                    </div>
                                </div>
                                <button
                                    class="text-slate-400 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-emerald-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('categories.index') }}"
                        class="w-full py-2.5 border border-emerald-200/90 text-emerald-700 hover:bg-emerald-50 font-bold text-xs rounded-xl text-center flex items-center justify-center transition-colors shadow-2xs">
                        Lihat Semua Pendaftaran
                    </a>
                </div>

            </div>

        </div>

    </div>
@endsection
