@extends('layouts.app')

@section('title', 'Beranda Member - Perpustakaan Kota')

@section('content')
    <div class="space-y-8 pt-2">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3 rounded-xl flex items-center justify-between shadow-2xs">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-semibold px-5 py-3 rounded-xl shadow-2xs">
                {{ session('error') }}
            </div>
        @endif

        {{-- 1. Hero Welcome Banner --}}
        <div class="bg-linear-to-r from-[#1c5d37] via-[#2d834e] to-[#1c5d37] rounded-3xl p-6 lg:p-8 text-white shadow-md relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full mb-3 border border-white/20">
                        <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                        Anggota Aktif Perpustakaan
                    </span>
                    <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-emerald-100 text-xs sm:text-sm font-medium mt-1.5 max-w-2xl leading-relaxed">
                        Selamat datang di dashboard perpustakaan digital. Pantau status peminjaman buku Anda, temukan koleksi terbaru, dan simpan buku favorit Anda secara online.
                    </p>
                </div>

                {{-- Quick Stats Badges --}}
                <div class="flex items-center gap-3 shrink-0">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 text-center min-w-22.5">
                        <span class="block text-2xl font-black text-white">{{ $activeLoans->count() }}</span>
                        <span class="text-[11px] font-semibold text-emerald-100">Dipinjam</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 text-center min-w-22.5">
                        <span class="block text-2xl font-black text-white">{{ $wishlistBooks->count() }}</span>
                        <span class="text-[11px] font-semibold text-emerald-100">Wishlist</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Akses Cepat (Quick Actions / Shortcuts) --}}
        <div class="space-y-3">
            <h2 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Akses Cepat (Quick Actions)
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('member.books.index') }}"
                    class="bg-white p-4 rounded-2xl border border-slate-100/90 shadow-2xs hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mb-2.5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#409a63] transition-colors">Katalog Buku</span>
                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">Eksplorasi Koleksi</span>
                </a>

                <a href="{{ route('member.loans.index') }}"
                    class="bg-white p-4 rounded-2xl border border-slate-100/90 shadow-2xs hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center mb-2.5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#409a63] transition-colors">Peminjaman Saya</span>
                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">Riwayat & Status</span>
                </a>

                <a href="{{ route('member.wishlist.index') }}"
                    class="bg-white p-4 rounded-2xl border border-slate-100/90 shadow-2xs hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-2.5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#409a63] transition-colors">Daftar Keinginan</span>
                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">Buku Favorit</span>
                </a>

                <a href="{{ route('member.profile.index') }}"
                    class="bg-white p-4 rounded-2xl border border-slate-100/90 shadow-2xs hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mb-2.5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#409a63] transition-colors">Profil Anggota</span>
                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">Kartu & Akun</span>
                </a>
            </div>
        </div>

        {{-- 3. Ringkasan Peminjaman Aktif (Status Buku & Sisa Hari) --}}
        <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100/90 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ringkasan Peminjaman Aktif
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau sisa batas waktu pengembalian buku yang sedang Anda pinjam</p>
                </div>
                <a href="{{ route('member.loans.index') }}" class="text-xs font-bold text-[#409a63] hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($activeLoans->isEmpty())
                <div class="py-8 text-center bg-slate-50/60 rounded-2xl border border-slate-100 max-w-md mx-auto my-2">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Tidak Ada Peminjaman Aktif</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-4 leading-relaxed">Saat ini Anda tidak memiliki buku yang sedang dipinjam.</p>
                    <a href="{{ route('member.books.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#409a63] hover:bg-[#348353] text-white text-xs font-bold rounded-xl transition-all shadow-2xs">
                        <span>Cari & Pinjam Buku</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($activeLoans as $loan)
                        @php
                            $book = $loan->bookCopy?->book;
                            $dueDate = $loan->due_date;
                            $today = now()->startOfDay();
                            $due = $dueDate ? $dueDate->startOfDay() : null;
                            
                            $daysLeft = $due ? (int) $today->diffInDays($due, false) : 0;
                        @endphp
                        <div class="bg-slate-50/70 rounded-2xl p-4 border border-slate-200/80 hover:border-emerald-300 transition-all flex gap-4 relative group">
                            {{-- Cover --}}
                            <div class="w-16 h-22 shrink-0 rounded-xl overflow-hidden bg-slate-200 border border-slate-200 shadow-2xs flex items-center justify-center">
                                @if ($book?->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-center p-2 text-[10px] font-bold text-emerald-800">
                                        Cover
                                    </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-sm text-slate-900 truncate leading-snug">
                                        <a href="{{ $book ? route('member.books.show', $book) : '#' }}" class="hover:text-emerald-700 transition-colors">
                                            {{ $book?->title ?? 'Buku Perpustakaan' }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 truncate mt-0.5 font-medium">Penulis: {{ $book?->author ?? '-' }}</p>
                                    <p class="text-[11px] text-slate-400 mt-1 font-normal">Kode: {{ $loan->bookCopy?->inventory_code ?? '-' }}</p>
                                </div>

                                {{-- Sisa Hari Badge --}}
                                <div class="mt-3 flex items-center justify-between">
                                    @if ($daysLeft < 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 text-xs font-bold rounded-full border border-rose-200">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-ping"></span>
                                            Terlambat {{ abs($daysLeft) }} Hari!
                                        </span>
                                    @elseif ($daysLeft === 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 text-xs font-bold rounded-full border border-amber-200">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                            Jatuh Tempo Hari Ini!
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-full border border-emerald-200">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            Sisa {{ $daysLeft }} Hari Lagi
                                        </span>
                                    @endif

                                    <span class="text-[11px] text-slate-400 font-medium">
                                        Batas: {{ $loan->due_date ? $loan->due_date->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 4. Informasi & Pengumuman Perpustakaan --}}
        <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100/90 space-y-4">
            <h2 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                Informasi & Pengumuman Perpustakaan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-linear-to-br from-emerald-50/90 to-teal-50/80 p-4 rounded-2xl border border-emerald-100 space-y-2">
                    <div class="flex items-center gap-2 text-emerald-800 font-bold text-xs">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Jam Operasional</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Layanan sirkulasi & ruang baca buka setiap <strong class="text-slate-900">Senin - Sabtu (08:00 - 17:00 WIB)</strong>. Layanan peminjaman online aktif 24 jam.
                    </p>
                </div>

                <div class="bg-linear-to-br from-blue-50/90 to-indigo-50/80 p-4 rounded-2xl border border-blue-100 space-y-2">
                    <div class="flex items-center gap-2 text-blue-800 font-bold text-xs">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pengembalian & Aturan Sirkulasi</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Durasi peminjaman berlaku <strong class="text-slate-900">{{ $settings['loan_duration_days'] }} hari</strong> dengan batas maksimal <strong class="text-slate-900">{{ $settings['max_active_loans'] }} buku</strong>. Keterlambatan pengembalian dikenakan denda sebesar <strong class="text-slate-900">Rp {{ number_format($settings['fine_per_day'], 0, ',', '.') }}/hari</strong> per buku.
                    </p>
                </div>

                <div class="bg-linear-to-br from-amber-50/90 to-orange-50/80 p-4 rounded-2xl border border-amber-100 space-y-2">
                    <div class="flex items-center gap-2 text-amber-800 font-bold text-xs">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span>Agenda Literasi Mingguan</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        Ikuti sesi kuis bedah buku & diskusi literasi gratis bagi seluruh anggota terdaftar setiap hari Sabtu sore.
                    </p>
                </div>
            </div>
        </div>

        {{-- 5. Buku Terbaru di Perpustakaan --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Buku Terbaru di Perpustakaan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Koleksi teranyar yang baru saja ditambahkan ke katalog</p>
                </div>
                <a href="{{ route('member.books.index') }}" class="text-xs font-bold text-[#409a63] hover:underline flex items-center gap-1">
                    <span>Lihat Katalog Lengkap</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                @foreach ($latestBooks as $book)
                    @php
                        $avail = $book->copies ? $book->copies->where('status', 'available')->count() : 0;
                    @endphp
                    <div class="bg-white rounded-2xl p-3.5 shadow-2xs border border-slate-100/90 hover:shadow-lg hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            {{-- Cover --}}
                            <div class="relative rounded-xl overflow-hidden bg-slate-50 mb-3 aspect-3/4 flex items-center justify-center border border-slate-100 shadow-2xs">
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center p-2 text-center bg-linear-to-br from-emerald-50 to-teal-50 text-[10px] font-bold text-emerald-800">
                                        Tanpa Cover
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 z-10">
                                    @include('member.partials.wishlist-button', ['book' => $book, 'variant' => 'card-float'])
                                </div>
                            </div>

                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                                {{ $book->categories->first()->name ?? 'Umum' }}
                            </p>
                            <h3 class="font-bold text-xs text-slate-900 group-hover:text-[#409a63] transition-colors line-clamp-2 leading-tight">
                                <a href="{{ route('member.books.show', $book) }}">{{ $book->title }}</a>
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $book->author }}</p>

                            <div class="mt-1.5 flex items-center">
                                @include('partials.star-display', [
                                    'rating' => $book->averageRating(),
                                    'showScore' => true,
                                    'reviewsCount' => $book->reviewsCount(),
                                    'size' => 'xs'
                                ])
                            </div>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-bold {{ $avail > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                {{ $avail > 0 ? "Sisa $avail Eks" : 'Dipinjam' }}
                            </span>
                            <a href="{{ route('member.books.show', $book) }}"
                                class="text-[11px] font-bold text-[#409a63] hover:underline">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 6. Daftar Keinginan (Wishlist) Saya --}}
        <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100/90 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Daftar Keinginan (Wishlist) Saya
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Buku-buku favorit yang Anda simpan untuk peminjaman cepat</p>
                </div>
                <a href="{{ route('member.wishlist.index') }}" class="text-xs font-bold text-[#409a63] hover:underline flex items-center gap-1">
                    <span>Lihat Wishlist</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($wishlistBooks->isEmpty())
                <div class="py-8 text-center bg-slate-50/60 rounded-2xl border border-slate-100 max-w-md mx-auto my-2">
                    <div class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-700">Wishlist Masih Kosong</p>
                    <p class="text-[11px] text-slate-400 mt-0.5 mb-3">Klik ikon hati di katalog buku untuk menyimpan buku favorit Anda di sini.</p>
                    <a href="{{ route('member.books.index') }}" class="text-xs font-bold text-[#409a63] hover:underline">
                        Jelajahi Katalog Buku &rarr;
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($wishlistBooks as $book)
                        @php
                            $avail = $book->copies ? $book->copies->where('status', 'available')->count() : 0;
                        @endphp
                        <div class="bg-slate-50/70 rounded-2xl p-3.5 border border-slate-200/80 flex items-center gap-3.5 group hover:border-emerald-300 transition-all">
                            <div class="w-12 h-16 rounded-xl overflow-hidden shrink-0 bg-white border border-slate-200 shadow-2xs">
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-emerald-50 text-[9px] font-bold text-emerald-800 flex items-center justify-center text-center p-1">
                                        Cover
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 truncate leading-snug group-hover:text-[#409a63] transition-colors">
                                        <a href="{{ route('member.books.show', $book) }}">{{ $book->title }}</a>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5 font-medium">{{ $book->author }}</p>
                                </div>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-[10px] font-bold {{ $avail > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                        {{ $avail > 0 ? "Sisa $avail Eks" : 'Habis' }}
                                    </span>
                                    <a href="{{ route('member.books.show', $book) }}" class="text-[11px] font-bold text-[#409a63] hover:underline">
                                        Pinjam &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
