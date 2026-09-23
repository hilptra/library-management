@extends('layouts.public')

@section('title', $book->title . ' - City Library')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-8 space-y-10">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 font-semibold mt-4">
            <a href="{{ route('home') }}" class="hover:text-[#1b5e37] transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('public.books.index') }}" class="hover:text-[#1b5e37] transition-colors">Katalog Buku</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-slate-600 line-clamp-1">Detail Buku ({{ $book->title }})</span>
        </div>

        {{-- ========== MAIN: TWO COLUMN LAYOUT ========== --}}
        <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-8">

            {{-- ===== LEFT COLUMN: Cover + Status ===== --}}
            <div class="space-y-5">
                {{-- Cover Image --}}
                <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/80">
                    <div
                        class="rounded-xl overflow-hidden bg-linear-to-br from-emerald-50 via-teal-50/40 to-emerald-100 flex items-center justify-center">
                        @if ($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-auto object-contain rounded-xl">
                        @else
                            <div class="w-full aspect-2/3 flex flex-col items-center justify-center p-6 text-center">
                                <svg class="w-16 h-16 text-emerald-600/30 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <span class="text-sm font-bold text-emerald-700">Tanpa Cover</span>
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons under cover --}}
                    <div class="flex gap-2 mt-4">
                        <button
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            Wishlist
                        </button>
                        <button
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            Bagikan
                        </button>
                    </div>
                </div>

                {{-- Status & Availability --}}
                <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/80 space-y-4">
                    <div class="flex items-center gap-3">
                        @if ($availableCount > 0)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Status: Tersedia
                            </span>
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200">
                                Sisa {{ $availableCount }} Eks
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-200">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                Status: Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Sebanyak {{ $totalCopies }} eksemplar tersedia untuk peminjaman oleh semua anggota terdaftar.
                    </p>

                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Info Koleksi</p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-600 font-medium">
                                📚 Perpustakaan Fisik (Lantai 2 • Rak {{ strtoupper(substr($book->title, 0, 1)) }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== RIGHT COLUMN: Info + Actions ===== --}}
            <div class="space-y-6">

                {{-- Title, Author & Categories --}}
                <div>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @forelse ($book->categories as $category)
                            <span
                                class="bg-emerald-50 text-[#166534] text-[11px] font-bold px-3 py-1 rounded-full border border-emerald-200">
                                {{ $category->name }}
                            </span>
                        @empty
                            <span
                                class="bg-slate-50 text-slate-500 text-[11px] font-bold px-3 py-1 rounded-full border border-slate-200">
                                Umum
                            </span>
                        @endforelse
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-2">
                        {{ $book->title }}
                    </h1>
                    <p class="text-slate-500 font-semibold text-sm">
                        Karya <span class="text-slate-700">{{ $book->author }}</span>
                        @if ($book->publisher)
                            <span class="text-slate-400 mx-1">•</span>
                            <span class="text-slate-500">{{ $book->publisher }}</span>
                        @endif
                    </p>
                </div>

                {{-- Ringkasan Utama --}}
                @if ($book->description)
                    <div class="bg-emerald-50/50 border border-emerald-100/80 rounded-2xl p-5">
                        <p class="text-[10px] font-bold text-[#1b5e37] uppercase tracking-wider mb-2">Ringkasan Utama</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif

                {{-- Meta Info Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-2xs text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">ISBN / Kode</p>
                        <p class="text-xs font-bold text-slate-800 break-all">{{ $book->isbn ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-2xs text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Penerbit</p>
                        <p class="text-xs font-bold text-slate-800">{{ $book->publisher ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-2xs text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tahun Terbit</p>
                        <p class="text-xs font-bold text-slate-800">{{ $book->published_year ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-2xs text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Bahasa & Edisi</p>
                        <p class="text-xs font-bold text-slate-800">Bahasa Indonesia</p>
                    </div>
                </div>

                {{-- Availability Banner + CTA --}}
                <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-100/80 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            @if ($availableCount > 0)
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#1b5e37]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Buku Tersedia</p>
                                    <p class="text-[11px] text-slate-500">{{ $availableCount }} dari {{ $totalCopies }}
                                        eksemplar siap dipinjam</p>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Stok Tidak Tersedia</p>
                                    <p class="text-[11px] text-slate-500">Semua eksemplar sedang dipinjam</p>
                                </div>
                            @endif
                        </div>

                        @if ($availableCount > 0)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200 shrink-0">
                                🕐 Siap Dipinjam Hari Ini!
                            </span>
                        @endif
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        @if ($availableCount > 0)
                            <a href="{{ route('login') }}"
                                class="flex-1 bg-[#1c5d37] hover:bg-[#144729] text-white font-bold text-sm px-6 py-3 rounded-xl shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Ajukan Pinjam Buku Sekarang
                            </a>
                        @else
                            <button disabled
                                class="flex-1 bg-slate-200 text-slate-500 font-bold text-sm px-6 py-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                Stok Tidak Tersedia
                            </button>
                        @endif
                    </div>

                    <p class="text-[11px] text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Anda perlu mendaftar / login terlebih dahulu. Pengajuan akan dikonfirmasi oleh admin perpustakaan.
                    </p>
                </div>
            </div>
        </div>

        {{-- ========== TENTANG BUKU (Tabs) ========== --}}
        @if ($book->description)
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100/80 overflow-hidden"
                x-data="{ activeTab: 'sinopsis' }">
                <div class="border-b border-slate-100 px-6 pt-5">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Lengkap
                        Perpustakaan</p>
                    <h2 class="text-xl font-extrabold text-slate-900 mb-4">Tentang Buku</h2>
                    <div class="flex gap-1 overflow-x-auto">
                        <button @click="activeTab = 'sinopsis'"
                            :class="activeTab === 'sinopsis' ? 'bg-[#1c5d37] text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-4 py-2 rounded-t-xl text-xs font-bold transition-all whitespace-nowrap">
                            Sinopsis Lengkap
                        </button>
                        <button @click="activeTab = 'detail'"
                            :class="activeTab === 'detail' ? 'bg-[#1c5d37] text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-4 py-2 rounded-t-xl text-xs font-bold transition-all whitespace-nowrap">
                            Detail Teknis & Identitas
                        </button>
                    </div>
                </div>

                {{-- Tab Content --}}
                <div class="p-6">
                    {{-- Sinopsis --}}
                    <div x-show="activeTab === 'sinopsis'" x-cloak>
                        <div class="prose prose-sm prose-slate max-w-none">
                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $book->description }}
                            </p>
                        </div>
                    </div>

                    {{-- Detail Teknis --}}
                    <div x-show="activeTab === 'detail'" x-cloak>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Identifikasi
                                </p>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">ISBN</span>
                                        <span class="text-slate-800 font-bold">{{ $book->isbn ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Judul</span>
                                        <span class="text-slate-800 font-bold">{{ $book->title }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Penulis</span>
                                        <span class="text-slate-800 font-bold">{{ $book->author }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Penerbitan
                                </p>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Penerbit</span>
                                        <span class="text-slate-800 font-bold">{{ $book->publisher ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Tahun Terbit</span>
                                        <span class="text-slate-800 font-bold">{{ $book->published_year ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Total Eksemplar</span>
                                        <span class="text-slate-800 font-bold">{{ $totalCopies }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ========== ULASAN PEMBACA ========== --}}
        <div class="mt-6 bg-white p-6 rounded-xl shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold">Ulasan Pembaca</h2>
                <a href="{{ route('books.reviews.index', $book) }}"
                    class="text-sm text-emerald-700 hover:underline">Lihat Semua</a>
            </div>
            <div class="flex items-center gap-2">
                @include('partials.star-display', ['rating' => $book->averageRating()])
                <span class="text-sm text-gray-500">({{ $book->reviewsCount() }} ulasan)</span>
            </div>
        </div>

        {{-- ========== BUKU SERUPA ========== --}}
        @if ($relatedBooks->count() > 0)
            <div>
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mungkin Kamu Menyukai
                        </p>
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Buku Serupa yang Sering Dipinjam
                        </h2>
                    </div>
                    <a href="{{ route('public.books.index') }}"
                        class="text-xs font-bold text-[#1c5d37] hover:underline flex items-center gap-1 shrink-0">
                        Lihat Semua
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @foreach ($relatedBooks as $related)
                        <a href="{{ route('public.books.show', $related) }}"
                            class="bg-white rounded-2xl p-4 shadow-xs border border-slate-100/80 hover:shadow-lg hover:border-emerald-200 hover:-translate-y-1 transition-all duration-300 flex gap-4 group">

                            {{-- Cover mini --}}
                            <div class="w-20 shrink-0">
                                @if ($related->cover_image)
                                    <div class="w-20 rounded-lg overflow-hidden border border-slate-100 shadow-2xs">
                                        <img src="{{ asset('storage/' . $related->cover_image) }}"
                                            alt="{{ $related->title }}" class="w-full h-auto object-contain">
                                    </div>
                                @else
                                    <div
                                        class="w-20 aspect-2/3 bg-linear-to-br from-emerald-50 to-emerald-100 rounded-lg border border-emerald-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-emerald-600/30" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0 flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                                        {{ $related->categories->first()->name ?? 'Umum' }}
                                    </p>
                                    <h3
                                        class="text-sm font-bold text-slate-800 group-hover:text-[#1b5e37] transition-colors line-clamp-2 leading-tight">
                                        {{ $related->title }}
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $related->author }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    @php $relAvail = $related->copies->where('status', 'available')->count(); @endphp
                                    <span
                                        class="text-[11px] font-bold {{ $relAvail > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $relAvail > 0 ? "Tersedia $relAvail buku" : 'Tidak tersedia' }}
                                    </span>
                                    <span
                                        class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-emerald-100 text-slate-400 group-hover:text-[#1b5e37] flex items-center justify-center transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
