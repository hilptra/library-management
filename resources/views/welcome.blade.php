@extends('layouts.public')

@section('title', 'City Library - Perpustakaan Kota')

@section('content')

    {{-- Hero Section --}}
    <section
        class="relative overflow-hidden py-24 px-6 lg:px-12 text-center bg-linear-to-b from-[#e3f0e8] via-[#ebf4ef] to-[#ebf4ef]">
        {{-- Subtle decorative overlay/blur --}}
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_center,var(--tw-gradient-stops))] from-white/60 via-transparent to-transparent opacity-80 pointer-events-none">
        </div>

        <div class="relative max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-[#174e2d] tracking-tight mb-5 leading-tight">
                Jendela Dunia di Jantung Kota
            </h1>
            <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto mb-9 leading-relaxed">
                Temukan ribuan koleksi buku, nikmati layanan digital tanpa batas, dan jadilah bagian dari komunitas literasi
                yang inklusif. Ruang temu untuk kota... terbuka untuk semua.
            </p>
            <div>
                <a href="{{ route('login') }}"
                    class="bg-[#1c5d37] hover:bg-[#144729] text-white px-8 py-3.5 rounded-full font-bold text-sm tracking-wide shadow-md shadow-emerald-900/10 hover:shadow-lg transition-all duration-300 inline-block hover:-translate-y-0.5">
                    Mulai Pinjam
                </a>
            </div>
        </div>
    </section>

    {{-- Section: Pilihan Editor Bulan Ini --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Pilihan Editor Bulan Ini</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Rekomendasi bacaan terbaik dari kurator kami.</p>
            </div>
            <a href="{{ route('public.books.index') }}"
                class="text-xs sm:text-sm font-bold text-[#1c5d37] hover:text-[#144729] hover:underline flex items-center gap-1 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @php
            // Sample fallback books if database has few/no books
            $fallbackBooks = [
                [
                    'title' => 'Gema Waktu yang Hilang',
                    'author' => 'Pramoedya A. Toer',
                    'category' => 'Sastra & Klasik',
                    'badge' => 'TERPOPULER',
                ],
                [
                    'title' => 'Membangun Kota Hijau',
                    'author' => 'Dr. Rina S.',
                    'category' => 'Hari-Tua & Sejarah',
                    'badge' => 'REKOMENDASI',
                ],
                [
                    'title' => 'Petualangan di Taman Rahasia',
                    'author' => 'Budi Darma',
                    'category' => 'Anak & Remaja',
                    'badge' => 'PILAHAN',
                ],
                [
                    'title' => 'Masa Depan Kecerdasan Buatan',
                    'author' => 'Prof. Aris H.',
                    'category' => 'Sains & Teknologi',
                    'badge' => 'TERBARU',
                ],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @if (isset($latestBooks) && $latestBooks->count() > 0)
                @foreach ($latestBooks as $index => $book)
                    <a href="{{ route('public.books.show', $book) }}"
                        class="bg-white rounded-2xl p-4 shadow-xs border border-emerald-100/60 hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div
                                class="relative overflow-hidden rounded-xl bg-emerald-50 mb-3 aspect-3/4 flex items-center justify-center">
                                <span
                                    class="absolute top-2 right-2 bg-emerald-100/90 backdrop-blur-xs text-[#174e2d] text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider z-10 shadow-2xs">
                                    {{ $index % 2 == 0 ? 'TERPOPULER' : 'REKOMENDASI' }}
                                </span>

                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-linear-to-br from-emerald-100 via-teal-50 to-emerald-200 flex flex-col items-center justify-center p-4 text-center">
                                        <svg class="w-10 h-10 text-emerald-600/60 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-xs font-bold text-emerald-800 line-clamp-2">{{ $book->title }}</span>
                                    </div>
                                @endif
                            </div>

                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                                {{ $book->categories->first()->name ?? 'Kategori Umum' }}
                            </p>
                            <h3
                                class="text-sm font-bold text-slate-800 group-hover:text-[#1c5d37] transition-colors line-clamp-1">
                                {{ $book->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                {{ $book->author }}
                            </p>
                        </div>
                    </a>
                @endforeach
            @else
                @foreach ($fallbackBooks as $book)
                    <a href="{{ route('public.books.index') }}"
                        class="bg-white rounded-2xl p-4 shadow-xs border border-emerald-100/60 hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div
                                class="relative overflow-hidden rounded-xl bg-emerald-50 mb-3 aspect-3/4 flex items-center justify-center">
                                <span
                                    class="absolute top-2 right-2 bg-emerald-100/90 backdrop-blur-xs text-[#174e2d] text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider z-10 shadow-2xs">
                                    {{ $book['badge'] }}
                                </span>

                                <div
                                    class="w-full h-full bg-linear-to-br from-emerald-100/70 via-emerald-50 to-teal-100 flex flex-col items-center justify-center p-4 text-center">
                                    <svg class="w-12 h-12 text-[#174e2d]/40 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-bold text-[#174e2d] line-clamp-2">{{ $book['title'] }}</span>
                                </div>
                            </div>

                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                                {{ $book['category'] }}
                            </p>
                            <h3
                                class="text-sm font-bold text-slate-800 group-hover:text-[#1c5d37] transition-colors line-clamp-1">
                                {{ $book['title'] }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                {{ $book['author'] }}
                            </p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    {{-- Section: Populer Berdasarkan Kategori --}}
    <section id="kategori" class="bg-[#e4efe8]/60 border-y border-emerald-100/70 py-16 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 text-center mb-8 tracking-tight">
                Populer Berdasarkan Kategori
            </h2>

            @php
                $fallbackCategories = [
                    ['name' => 'Sastra & Fiksi', 'count' => '1,240', 'icon' => 'book'],
                    ['name' => 'Teknologi', 'count' => '850', 'icon' => 'tech'],
                    ['name' => 'Sejarah', 'count' => '620', 'icon' => 'history'],
                    ['name' => 'Anak-anak', 'count' => '930', 'icon' => 'kids'],
                    ['name' => 'Sains', 'count' => '710', 'icon' => 'science'],
                ];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @if (isset($categoriesWithCount) && $categoriesWithCount->count() > 0)
                    @foreach ($categoriesWithCount as $category)
                        <a href="{{ route('public.books.index', ['categories' => [$category->id]]) }}"
                            class="bg-white rounded-2xl p-5 text-center shadow-2xs border border-emerald-100/50 hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">

                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-[#174e2d] flex items-center justify-center mb-3 group-hover:bg-[#174e2d] group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>

                            <p class="font-bold text-sm text-slate-800 group-hover:text-[#174e2d] transition-colors">
                                {{ $category->name }}
                            </p>
                            <p class="text-xs text-slate-400 font-medium mt-1">
                                {{ number_format($category->books_count) }} Buku
                            </p>
                        </a>
                    @endforeach
                @else
                    @foreach ($fallbackCategories as $cat)
                        <a href="{{ route('public.books.index') }}"
                            class="bg-white rounded-2xl p-5 text-center shadow-2xs border border-emerald-100/50 hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">

                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-[#174e2d] flex items-center justify-center mb-3 group-hover:bg-[#174e2d] group-hover:text-white transition-colors duration-300">
                                @if ($cat['icon'] === 'tech')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                @elseif ($cat['icon'] === 'history')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif ($cat['icon'] === 'kids')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                @elseif ($cat['icon'] === 'science')
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.022.547l-1.07 1.07a2 2 0 00.586 3.414l.756.252a10 10 0 007.294 0l.756-.252a2 2 0 00.586-3.414l-1.07-1.07z">
                                        </path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                @endif
                            </div>

                            <p class="font-bold text-sm text-slate-800 group-hover:text-[#174e2d] transition-colors">
                                {{ $cat['name'] }}
                            </p>
                            <p class="text-xs text-slate-400 font-medium mt-1">
                                {{ $cat['count'] }} Buku
                            </p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- Section: FAQ (Tanya Jawab) --}}
    <section id="faq" class="max-w-4xl mx-auto px-6 lg:px-12 py-16" x-data="{ openFaq: null }">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800 text-center mb-8 tracking-tight">
            FAQ (Tanya Jawab)
        </h2>

        @php
            $faqs = [
                [
                    'q' => 'Cara mendaftar anggota?',
                    'a' =>
                        'Klik tombol "Join Now" di sudut kanan atas halaman ini, isi data diri singkat (nama, email, dan kata sandi), dan akun anggota Anda akan langsung aktif secara otomatis.',
                ],
                [
                    'q' => 'Berapa lama durasi peminjaman?',
                    'a' =>
                        'Durasi peminjaman standar adalah 7 hari. Anda dapat memantau status dan batas tanggal pengembalian buku secara langsung melalui dashboard akun anggota.',
                ],
                [
                    'q' => 'Lokasi perpustakaan?',
                    'a' =>
                        'Perpustakaan Kota berlokasi di pusat kota dengan fasilitas ruang baca yang tenang, ruang diskusi kelompok, serta koleksi buku fisik dan digital yang lengkap.',
                ],
            ];
        @endphp

        <div class="space-y-3">
            @foreach ($faqs as $index => $faq)
                <div
                    class="bg-white rounded-2xl shadow-2xs border border-emerald-100/60 overflow-hidden transition-all duration-200">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                        class="w-full text-left px-6 py-4 font-semibold text-sm sm:text-base text-slate-800 flex justify-between items-center hover:bg-emerald-50/50 transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center text-[#174e2d] shrink-0 ml-4 transition-transform duration-200"
                            :class="{ 'rotate-180 bg-emerald-100': openFaq === {{ $index }} }">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openFaq === {{ $index }}" x-collapse x-cloak
                        class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-50">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
