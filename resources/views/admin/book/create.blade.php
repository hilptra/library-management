@extends('layouts.app')

@section('title', 'Tambah Buku - Perpustakaan Kota')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pt-2">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Buku</h1>
            <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Isi detail buku baru untuk dimasukkan ke katalog</p>
        </div>
        <a href="{{ route('books.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-100/90">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Judul Buku</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan judul buku" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                @error('title')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="Nama penulis" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    @error('author')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Contoh: 978-3-16-148410-0" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    @error('isbn')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Tahun Terbit</label>
                    <input type="number" name="published_year" value="{{ old('published_year') }}" placeholder="2024"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    @error('published_year')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Deskripsi Buku</label>
                <textarea name="description" rows="4" placeholder="Ringkasan atau sinopsis buku..."
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Cover Buku</label>
                <input type="file" name="cover_image"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm text-slate-800 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors">
                @error('cover_image')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kategori Buku</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($categories as $category)
                        <label class="flex items-center gap-2 bg-slate-50 hover:bg-emerald-50 border border-slate-200 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-700 cursor-pointer transition-colors">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <a href="{{ route('books.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs shadow-2xs transition-colors">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
