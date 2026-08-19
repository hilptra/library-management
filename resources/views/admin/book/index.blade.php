@extends('layouts.app')

@section('title', 'Kelola Buku - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2" x-data="{ confirmDeleteOpen: false, deleteAction: '', deleteMessage: '' }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Buku</h1>
            <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Daftar buku dan katalog Perpustakaan Kota</p>
        </div>
        <div>
            <a href="{{ route('books.create') }}" class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-2xs hover:shadow-xs flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Tambah Buku</span>
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-3 px-4">Cover</th>
                        <th class="pb-3 px-4">Judul Buku</th>
                        <th class="pb-3 px-4">Penulis</th>
                        <th class="pb-3 px-4">Kategori</th>
                        <th class="pb-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse ($books as $book)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4">
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-12 h-16 object-cover rounded-lg shadow-2xs border border-slate-100">
                                @else
                                    <div class="w-12 h-16 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100 flex items-center justify-center text-[10px] font-bold">
                                        N/A
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                <a href="{{ route('books.show', $book) }}" class="hover:text-emerald-700 transition-colors">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $book->author }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($book->categories as $category)
                                        <span class="bg-[#dcfce7] text-[#166534] text-[11px] font-bold px-2.5 py-0.5 rounded-md">
                                            {{ $category->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 font-normal">Tanpa kategori</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1">
                                <a href="{{ route('books.edit', $book) }}" class="text-amber-600 hover:text-amber-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-amber-50 transition-colors inline-block">
                                    Edit
                                </a>
                                <button type="button"
                                    @click="confirmDeleteOpen = true; deleteAction = '{{ route('books.destroy', $book) }}'; deleteMessage = 'Yakin ingin menghapus buku \'{{ addslashes($book->title) }}\'?'"
                                    class="text-rose-600 hover:text-rose-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada buku</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            {{ $books->links() }}
        </div>
    </div>

    {{-- Alpine.js Modal Konfirmasi Hapus Buku --}}
    <div x-show="confirmDeleteOpen" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100 space-y-4" @click.outside="confirmDeleteOpen = false">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-2xl bg-rose-50 text-rose-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Hapus Buku</h3>
                    <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed" x-text="deleteMessage"></p>
                </div>
            </div>

            <form method="POST" :action="deleteAction" class="flex justify-end gap-2 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" @click="confirmDeleteOpen = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-2xs transition-colors">
                    Hapus Buku
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
