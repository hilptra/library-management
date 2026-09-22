@extends('layouts.public')

@section('title', 'Katalog Buku - City Library')

@section('content')
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-10 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight mt-4">Katalog Buku</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Jelajahi koleksi lengkap perpustakaan kami
                </p>
            </div>
            <p class="text-xs text-slate-400 font-medium shrink-0 mt-4">
                Menampilkan {{ $books->total() }} buku
            </p>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-slate-100/90">
            <form method="GET" action="{{ route('public.books.index') }}" class="space-y-4">
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
                            class="bg-[#1c5d37] hover:bg-[#144729] text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-2xs hover:shadow-xs flex items-center justify-center gap-2 transition-all">
                            <span>Cari</span>
                        </button>

                        @if (request('search') || request('categories'))
                            <a href="{{ route('public.books.index') }}"
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

        {{-- Book Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @forelse ($books as $book)
                <a href="{{ route('public.books.show', $book) }}"
                    class="bg-white rounded-2xl p-4 shadow-xs border border-emerald-100/60 hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div
                        class="relative overflow-hidden rounded-xl bg-emerald-50 mb-3 aspect-3/4 flex items-center justify-center">
                        @if ($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div
                                class="w-full h-full bg-linear-to-br from-emerald-100 via-teal-50 to-emerald-200 flex flex-col items-center justify-center p-3 text-center">
                                <svg class="w-10 h-10 text-emerald-600/50 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <span class="text-[11px] font-bold text-emerald-800 line-clamp-2">{{ $book->title }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">
                            {{ $book->categories->first()->name ?? 'Umum' }}
                        </p>
                        <h3
                            class="text-sm font-bold text-slate-800 group-hover:text-[#1c5d37] transition-colors line-clamp-2 leading-tight">
                            {{ $book->title }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $book->author }}</p>
                    </div>

                    <div class="mt-3 pt-3 border-t border-slate-50">
                        <span class="text-xs font-bold text-[#1c5d37] group-hover:underline">Lihat Detail &rarr;</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-semibold">Buku tidak ditemukan</p>
                    <p class="text-xs mt-1">Coba kata kunci atau filter yang berbeda</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($books->hasPages())
            <div class="pt-2">
                {{ $books->links() }}
            </div>
        @endif

    </div>
@endsection
