@extends('layouts.app')

@section('title', 'Katalog Buku - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Buku Perpustakaan
                    </h1>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        {{ $books->total() }} Buku
                    </span>
                </div>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-1">
                    Pilih dan ajukan peminjaman buku favorit Anda secara langsung
                </p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3 rounded-xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <a href="{{ route('member.wishlist.index') }}"
                    class="text-xs font-bold text-emerald-700 underline hover:text-emerald-800">
                    Lihat Wishlist &rarr;
                </a>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-semibold px-5 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-slate-100/90">
            <form method="GET" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul buku atau penulis..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-2xs hover:shadow-xs flex items-center justify-center gap-2 transition-all">
                            <span>Cari</span>
                        </button>

                        @if (request('search') || request('categories'))
                            <a href="{{ route('member.books.index') }}"
                                class="border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

                @if ($categories->count() > 0)
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Filter
                            Kategori</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($categories as $category)
                                <label
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs font-semibold cursor-pointer transition-all select-none border-slate-200 bg-slate-50/70 text-slate-600 hover:bg-slate-100 has-checked:bg-[#dcfce7] has-checked:border-emerald-300 has-checked:text-[#166534]">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        @checked(collect(request('categories'))->contains($category->id)) onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-[#409a63] focus:ring-emerald-500/30">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
        </div>

        {{-- Book Catalog Card Grid --}}
        @if ($books->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-100/90 shadow-xs max-w-lg mx-auto my-8">
                <div
                    class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-2xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-1.5">Buku Tidak Ditemukan</h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Maaf, belum ada buku yang sesuai dengan kata kunci atau filter yang Anda pilih.
                </p>
                <a href="{{ route('member.books.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                    <span>Lihat Semua Buku</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @foreach ($books as $book)
                    @php
                        $availableCount = $book->copies ? $book->copies->where('status', 'available')->count() : 0;
                        $totalCopies = $book->copies ? $book->copies->count() : 0;
                    @endphp
                    <div
                        class="bg-white rounded-2xl p-4 shadow-xs border border-slate-100/90 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 flex flex-col justify-between group relative">
                        <div>
                            {{-- Cover Container with Wishlist & Status Badges --}}
                            <div
                                class="relative rounded-xl overflow-hidden bg-slate-50 mb-3.5 aspect-3/4 flex items-center justify-center border border-slate-100 shadow-2xs">
                                @if ($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-linear-to-br from-emerald-50/70 to-teal-50/70">
                                        <svg class="w-12 h-12 text-emerald-600/30 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <span class="text-xs font-bold text-emerald-700/80">Tanpa Cover</span>
                                    </div>
                                @endif

                                {{-- Floating Wishlist Button --}}
                                <div class="absolute top-2.5 right-2.5 z-10">
                                    @include('member.partials.wishlist-button', [
                                        'book' => $book,
                                        'variant' => 'card-float',
                                    ])
                                </div>

                                {{-- Availability Badge --}}
                                <div class="absolute bottom-2.5 left-2.5 z-10">
                                    @if ($availableCount > 0)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-600/90 text-white text-[10px] font-bold rounded-full backdrop-blur-xs shadow-xs">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                            Sisa {{ $availableCount }} Eks
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-800/80 text-white text-[10px] font-bold rounded-full backdrop-blur-xs shadow-xs">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                            Dipinjam
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Book Metadata --}}
                            <div>
                                <div class="flex flex-wrap gap-1 mb-1.5">
                                    @forelse ($book->categories as $category)
                                        <span
                                            class="bg-[#dcfce7] text-[#166534] text-[10px] font-bold px-2 py-0.5 rounded-md">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-slate-400 font-medium">Umum</span>
                                    @endforelse
                                </div>

                                <h2
                                    class="font-bold text-sm text-slate-900 group-hover:text-[#409a63] transition-colors line-clamp-2 leading-snug">
                                    <a href="{{ route('member.books.show', $book) }}">
                                        {{ $book->title }}
                                    </a>
                                </h2>

                                <p class="text-xs text-slate-500 mt-1 line-clamp-1 font-medium">
                                    Penulis: {{ $book->author }}
                                </p>

                                {{-- Rating & Review Count --}}
                                <div class="mt-2 flex items-center gap-1">
                                    @include('partials.star-display', [
                                        'rating' => $book->averageRating(),
                                        'showScore' => true,
                                        'reviewsCount' => $book->reviewsCount(),
                                        'size' => 'xs',
                                    ])
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2">
                            <a href="{{ route('member.books.show', $book) }}"
                                class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs py-2 px-3 rounded-xl border border-slate-200 text-center transition-colors">
                                Detail
                            </a>

                            @if ($availableCount > 0)
                                <form action="{{ route('member.loans.store', $book) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs py-2 px-3 rounded-xl shadow-2xs hover:shadow-xs transition-all flex items-center justify-center gap-1">
                                        <span>Pinjam</span>
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled
                                    class="flex-1 bg-slate-100 text-slate-400 font-bold text-xs py-2 px-3 rounded-xl cursor-not-allowed text-center">
                                    Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $books->links() }}
            </div>
        @endif

    </div>
@endsection
