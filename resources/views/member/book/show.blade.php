@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Kota')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pt-2">

    @if (session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    <div>
        <a href="{{ route('member.books.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-800 transition-colors">
            &larr; Kembali ke katalog buku
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-100/90 flex flex-col md:flex-row gap-6">
        <div class="shrink-0">
            @if ($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                    class="w-36 h-52 object-cover rounded-xl shadow-sm border border-slate-100 mx-auto md:mx-0">
            @else
                <div class="w-36 h-52 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-100 flex items-center justify-center text-xs font-bold mx-auto md:mx-0">
                    Tanpa Cover
                </div>
            @endif
        </div>

        <div class="flex-1 space-y-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $book->title }}</h1>
                <p class="text-slate-500 font-semibold text-sm mt-0.5">{{ $book->author }}</p>
            </div>

            <div class="text-xs text-slate-600 space-y-1.5 bg-slate-50 p-4 rounded-xl border border-slate-100">
                <p><span class="font-bold text-slate-700">ISBN:</span> {{ $book->isbn }}</p>
                <p><span class="font-bold text-slate-700">Penerbit:</span> {{ $book->publisher ?? '-' }}</p>
                <p><span class="font-bold text-slate-700">Tahun Terbit:</span> {{ $book->published_year }}</p>
            </div>

            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Kategori</span>
                <div class="flex flex-wrap gap-1.5">
                    @forelse ($book->categories as $category)
                        <span class="bg-[#dcfce7] text-[#166534] text-xs font-bold px-3 py-1 rounded-full">
                            {{ $category->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400 font-medium">Tanpa kategori</span>
                    @endforelse
                </div>
            </div>

            @if ($book->description)
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Deskripsi</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $book->description }}</p>
                </div>
            @endif

            <div class="pt-2">
                <form action="{{ route('member.loans.store', $book) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-2xs hover:shadow-xs transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Ajukan Pinjam Buku</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
