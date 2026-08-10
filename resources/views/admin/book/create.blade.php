@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="max-w-2xl mx-auto my-10 px-4">

        <h1 class="text-xl font-bold mb-4">Tambah Buku</h1>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author') }}" class="w-full border rounded px-3 py-2">
                @error('author')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full border rounded px-3 py-2">
                @error('isbn')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher') }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tahun Terbit</label>
                <input type="number" name="published_year" value="{{ old('published_year') }}"
                    class="w-full border rounded px-3 py-2">
                @error('published_year')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Cover</label>
                <input type="file" name="cover_image" class="w-full border rounded px-3 py-2">
                @error('cover_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <div class="flex flex-wrap gap-3">
                    @foreach ($categories as $category)
                        <label class="flex items-center gap-1">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
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
