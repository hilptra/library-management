@extends('layouts.app')

@section('title', 'Katalog Buku - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2">

    @if (session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Buku Perpustakaan</h1>
            <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Pilih buku pilihan Anda untuk mengajukan peminjaman</p>
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
                                <a href="{{ route('member.books.show', $book) }}" class="hover:text-emerald-700 transition-colors">
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
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('member.books.show', $book) }}"
                                    class="bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold text-xs px-3.5 py-1.5 rounded-xl border border-emerald-200 transition-colors inline-block">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada buku dalam katalog</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            {{ $books->links() }}
        </div>
    </div>

</div>
@endsection
