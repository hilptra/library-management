@extends('layouts.app')

@section('title', 'Profil Saya - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2 max-w-5xl mx-auto">

        {{-- Page Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Profil Saya</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Informasi akun dan status keanggotaan
                    perpustakaan Anda</p>
            </div>
            <div>
                <a href="{{ route('member.profile.edit') }}"
                    class="inline-flex items-center gap-2 bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-2xs hover:shadow-xs transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Profil</span>
                </a>
            </div>
        </div>

        {{-- Header Profile Card --}}
        <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xs border border-slate-100/90 relative overflow-hidden">
            {{-- Background Decorative Element --}}
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-50 rounded-full opacity-60 pointer-events-none">
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-5">
                    {{-- Avatar Circle --}}
                    <div class="relative">
                        <div
                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-linear-to-br from-[#409a63] to-[#2d6e46] text-white text-2xl sm:text-3xl font-extrabold flex items-center justify-center shadow-md border-4 border-emerald-50">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span
                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center"
                            title="Akun Aktif">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </div>

                    {{-- User Basic Info --}}
                    <div class="space-y-1">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-[#dcfce7] text-[#166534] border border-emerald-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                Anggota Aktif
                            </span>
                        </div>
                        <p class="text-slate-500 text-xs sm:text-sm font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ Auth::user()->email }}
                        </p>
                        <p class="text-slate-400 text-xs font-medium flex items-center gap-1.5 pt-0.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Bergabung sejak {{ Auth::user()->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- Secondary action button --}}
                <div class="w-full md:w-auto flex md:flex-col gap-2 border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                    <a href="{{ route('member.loans.index') }}"
                        class="flex-1 md:flex-initial inline-flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-[#166534] font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-[#166534]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Riwayat Peminjaman</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards Grid --}}
        @php
            $totalLoans = Auth::user()->loans()->count();
            $activeLoans = Auth::user()->loans()->where('status', 'borrowed')->count();
            $returnedLoans = Auth::user()->loans()->where('status', 'returned')->count();
            $cancelledLoans = Auth::user()->loans()->where('status', 'cancelled')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            {{-- Total Peminjaman --}}
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/90 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Peminjaman</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalLoans }} <span
                            class="text-xs font-medium text-slate-500">Buku</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#409a63] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/90 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sedang Dipinjam</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $activeLoans }} <span
                            class="text-xs font-medium text-slate-500">Buku</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Telah Dikembalikan --}}
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/90 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telah Dikembalikan</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $returnedLoans }} <span
                            class="text-xs font-medium text-slate-500">Buku</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Dibatalkan --}}
            <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/90 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dibatalkan</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $cancelledLoans }} <span
                            class="text-xs font-medium text-slate-500">Buku</span></h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Details Column (2 Cols) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Detail Informasi Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-xl bg-emerald-50 text-[#409a63]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-900">Informasi Pribadi</h3>
                        </div>
                        <a href="{{ route('member.profile.edit') }}"
                            class="text-xs font-bold text-[#409a63] hover:text-[#348353]">
                            Ubah Informasi &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                        {{-- Nama Lengkap --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
                                <p class="text-slate-800 font-bold mt-0.5">{{ Auth::user()->name }}</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Alamat Email</p>
                                <p class="text-slate-800 font-bold mt-0.5 break-all">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Telepon / WA
                                </p>
                                <p class="text-slate-800 font-bold mt-0.5">
                                    {{ Auth::user()->phone ? Auth::user()->phone : 'Belum diatur' }}
                                </p>
                            </div>
                        </div>

                        {{-- Tanggal Bergabung --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal Bergabung
                                </p>
                                <p class="text-slate-800 font-bold mt-0.5">{{ Auth::user()->created_at->format('d F Y') }}
                                </p>
                            </div>
                        </div>

                        {{-- Status Akun --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Keanggotaan
                                </p>
                                <p class="text-[#166534] font-bold mt-0.5 capitalize flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    {{ Auth::user()->status ?? 'Aktif' }}
                                </p>
                            </div>
                        </div>

                        {{-- Peran --}}
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-slate-100 text-slate-500 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Peran Akun</p>
                                <p class="text-slate-800 font-bold mt-0.5 capitalize">
                                    {{ Auth::user()->role === 'member' ? 'Anggota Perpustakaan' : 'Admin' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Info / Guidance Alert Card --}}
                <div
                    class="bg-linear-to-r from-emerald-900 to-slate-800 rounded-2xl p-6 text-white shadow-xs relative overflow-hidden">
                    <div
                        class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-500/10 rounded-full blur-xl pointer-events-none">
                    </div>
                    <div class="flex items-start gap-4 relative z-10">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-300 rounded-xl shrink-0 mt-0.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-emerald-300">Catatan Anggota Perpustakaan</h4>
                            <p class="text-slate-300 text-xs leading-relaxed">
                                Pastikan nomor telepon dan data diri Anda selalu diperbarui agar staf perpustakaan dapat
                                menghubungi Anda mengenai konfirmasi peminjaman buku maupun pengingat masa pinjam.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar Column: Digital Member Card --}}
            <div class="space-y-6">

                {{-- Kartu Anggota Digital Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#409a63]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            <span>Kartu Anggota Digital</span>
                        </h3>
                        <span
                            class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">Resmi</span>
                    </div>

                    {{-- Visual Card Widget --}}
                    <div
                        class="bg-linear-to-br from-[#166534] via-[#228448] to-[#409a63] rounded-2xl p-5 text-white shadow-lg relative overflow-hidden border border-emerald-400/20">
                        {{-- Decorative Patterns --}}
                        <div
                            class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full blur-xs pointer-events-none">
                        </div>
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-emerald-300/10 rounded-bl-full pointer-events-none">
                        </div>

                        {{-- Top Header Card --}}
                        <div class="flex items-center justify-between mb-6 relative z-10">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center font-extrabold text-xs text-white">
                                    PK
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-xs tracking-wide uppercase leading-none">Perpustakaan
                                        Kota</h4>
                                    <p class="text-[9px] text-emerald-200 mt-0.5">Kartu Anggota Perpustakaan</p>
                                </div>
                            </div>
                            <span
                                class="text-[10px] font-mono tracking-widest text-emerald-200 bg-black/20 px-2 py-1 rounded">MEMBER</span>
                        </div>

                        {{-- Card Body --}}
                        <div class="space-y-3 relative z-10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-sm border border-white/20 text-white font-bold text-base flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <h3 class="font-extrabold text-sm truncate leading-tight">{{ Auth::user()->name }}
                                    </h3>
                                    <p class="text-[11px] text-emerald-100 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer & Code --}}
                        <div
                            class="mt-6 pt-3 border-t border-white/15 flex items-end justify-between relative z-10 text-[10px]">
                            <div>
                                <p class="text-emerald-200 uppercase tracking-wider text-[8px]">ID Anggota</p>
                                <p class="font-mono font-bold text-xs text-white">
                                    LIB-MBR-{{ str_pad(Auth::user()->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-emerald-200 uppercase tracking-wider text-[8px]">Bergabung</p>
                                <p class="font-medium text-white">{{ Auth::user()->created_at->format('m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-xs text-slate-400 font-medium pt-1">
                        Tunjukkan kartu digital ini kepada petugas saat berkunjung ke lokasi perpustakaan.
                    </p>
                </div>

                {{-- Quick Links Card --}}
                <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/90 space-y-3">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('member.profile.edit') }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors text-xs font-bold text-slate-700">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z" />
                                </svg>
                                Ganti Password
                            </span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('member.books.index') }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors text-xs font-bold text-slate-700">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Jelajahi Katalog Buku
                            </span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
