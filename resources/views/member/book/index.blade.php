@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 px-4">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Daftar Buku</h1>
        </div>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">Cover</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Penulis</th>
                    <th class="p-3">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr class="border-b">
                        <td class="p-3">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-12 h-16 object-cover rounded">
                            @else
                                <div
                                    class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                                    N/A
                                </div>
                            @endif
                        </td>
                        <td class="p-3">
                            <a href="{{ route('member.books.show', $book) }}" class="text-blue-600 hover:underline">
                                {{ $book->title }}
                            </a>
                        </td>
                        <td class="p-3">{{ $book->author }}</td>
                        <td class="p-3">
                            @forelse ($book->categories as $category)
                                <span class="inline-block bg-gray-100 text-xs px-2 py-1 rounded mr-1">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-400">Tanpa kategori</span>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">Belum ada buku</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
