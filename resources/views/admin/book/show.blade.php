@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="max-w-3xl mx-auto mt-10 px-4">

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke daftar buku</a>

        <div class="bg-white shadow rounded p-6 mt-4 flex gap-6">
            <div>
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                        class="w-32 h-44 object-cover rounded">
                @else
                    <div class="w-32 h-44 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                        Tanpa Cover
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <h1 class="text-2xl font-bold">{{ $book->title }}</h1>
                <p class="text-gray-600">{{ $book->author }}</p>

                <div class="mt-3 text-sm text-gray-700 space-y-1">
                    <p><span class="font-medium">ISBN:</span> {{ $book->isbn }}</p>
                    <p><span class="font-medium">Penerbit:</span> {{ $book->publisher ?? '-' }}</p>
                    <p><span class="font-medium">Tahun Terbit:</span> {{ $book->published_year }}</p>
                </div>

                <div class="mt-3">
                    <span class="font-medium text-sm">Kategori:</span>
                    @forelse ($book->categories as $category)
                        <span class="inline-block bg-gray-100 text-xs px-2 py-1 rounded mr-1">
                            {{ $category->name }}
                        </span>
                    @empty
                        <span class="text-xs text-gray-400">Tanpa kategori</span>
                    @endforelse
                </div>

                @if ($book->description)
                    <p class="mt-4 text-sm text-gray-700">{{ $book->description }}</p>
                @endif

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('books.edit', $book) }}"
                        class="px-4 py-2 rounded border text-yellow-600 inline-block">Edit</a>
                </div>
            </div>
        </div>

        {{-- Placeholder untuk BookCopy, dikerjakan di fitur berikutnya --}}
        <div class="bg-white shadow rounded p-6 mt-4">
            <h2 class="font-bold mb-2">Eksemplar Buku</h2>
            <p class="text-sm text-gray-400">Fitur pengelolaan eksemplar akan ditambahkan di tahap berikutnya.</p>
        </div>

    </div>
@endsection
