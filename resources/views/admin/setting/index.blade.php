@extends('layouts.app')

@section('title', 'Pengaturan Sistem - Perpustakaan Kota')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pt-2">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Sistem</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">
                    Konfigurasi aturan peminjaman, durasi transaksi, dan kalkulasi denda perpustakaan
                </p>
            </div>
            <div>
                <div
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200/60 shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Sirkulasi & Aturan</span>
                </div>
            </div>
        </div>

        {{-- Form Settings Card --}}
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-100/90 space-y-8">

            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Group Settings Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- 1. Denda Per Hari --}}
                    <div
                        class="bg-slate-50/50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:border-amber-200 hover:bg-amber-50/20 transition-all">
                        <div class="space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100/80 text-amber-700 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-900">Tarif Denda Telat</label>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Nominal denda per hari per buku saat melewati tanggal jatuh tempo.
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                    Rp
                                </span>
                                <input type="number" name="fine_per_day"
                                    value="{{ old('fine_per_day', $settings['fine_per_day']) }}" min="0"
                                    step="500" required
                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 transition-all">
                            </div>
                            @error('fine_per_day')
                                <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                    <span>⚠️</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. Durasi Peminjaman --}}
                    <div
                        class="bg-slate-50/50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:border-emerald-200 hover:bg-emerald-50/20 transition-all">
                        <div class="space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-900">Durasi Peminjaman</label>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Durasi standar peminjaman (dalam hari) sejak disetujui admin.
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="relative">
                                <input type="number" name="loan_duration_days"
                                    value="{{ old('loan_duration_days', $settings['loan_duration_days']) }}" min="1"
                                    max="60" required
                                    class="w-full pl-4 pr-12 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all">
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                    Hari
                                </span>
                            </div>
                            @error('loan_duration_days')
                                <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                    <span>⚠️</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. Batas Maksimal Pinjam --}}
                    <div
                        class="bg-slate-50/50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:border-blue-200 hover:bg-blue-50/20 transition-all">
                        <div class="space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100/80 text-blue-700 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-900">Batas Maksimal Pinjam</label>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    Jumlah batas maksimal buku aktif yang boleh dipinjam 1 member.
                                </p>
                            </div>
                        </div>

                        <div>
                            <div class="relative">
                                <input type="number" name="max_active_loans"
                                    value="{{ old('max_active_loans', $settings['max_active_loans']) }}" min="1"
                                    max="20" required
                                    class="w-full pl-4 pr-14 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all">
                                <span
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-bold text-slate-400 pointer-events-none">
                                    Buku
                                </span>
                            </div>
                            @error('max_active_loans')
                                <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                    <span>⚠️</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Info Preview Banner --}}
                <div
                    class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-start gap-3 text-xs text-emerald-900 font-medium leading-relaxed">
                    <div class="p-1.5 bg-emerald-100 rounded-lg text-emerald-700 shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold block text-emerald-950 mb-0.5">Ringkasan Simulasi Aturan Peminjaman:</span>
                        Setiap anggota dapat mengajukan/meminjam maksimal <strong
                            class="text-emerald-900 font-bold">{{ $settings['max_active_loans'] }} buku</strong> sekaligus.
                        Setiap transaksi persetujuan peminjaman berlaku selama <strong
                            class="text-emerald-900 font-bold">{{ $settings['loan_duration_days'] }} hari</strong>. Apabila
                        dikembalikan terlambat, sistem secara otomatis menghitung denda sebesar <strong
                            class="text-emerald-900 font-bold">Rp
                            {{ number_format($settings['fine_per_day'], 0, ',', '.') }}/hari</strong> per buku.
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                        class="bg-[#409a63] hover:bg-[#348353] text-white px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-2xs hover:shadow-xs flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>

        </div>

    </div>
@endsection
