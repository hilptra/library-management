@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <h1 class="text-xl font-bold mb-4">Edit Buku</h1>

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}"
                    class="w-full border rounded px-3 py-2">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}"
                    class="w-full border rounded px-3 py-2">
                @error('author')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                    class="w-full border rounded px-3 py-2">
                @error('isbn')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tahun Terbit</label>
                <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}"
                    class="w-full border rounded px-3 py-2">
                @error('published_year')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $book->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Cover Saat Ini</label>
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-24 h-32 object-cover rounded mb-2">
                @else
                    <p class="text-sm text-gray-400 mb-2">Belum ada cover</p>
                @endif
                <input type="file" name="cover_image" class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah cover</p>
                @error('cover_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <div class="flex flex-wrap gap-3">
                    @foreach ($categories as $category)
                        <label class="flex items-center gap-1">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                @checked($book->categories->contains($category->id))>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('books.index') }}" class="px-4 py-2 rounded border">Batal</a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
            </div>
        </form>

    </div>
@endsection
