@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Kota')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pt-2" x-data="{ confirmDeleteOpen: false, deleteAction: '', deleteMessage: '' }">

        <div>
            <a href="{{ route('books.index') }}"
                class="text-xs font-bold text-slate-500 hover:text-emerald-800 transition-colors">
                &larr; Kembali ke daftar buku
            </a>
        </div>

        {{-- Detail Card --}}
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-100/90 flex flex-col md:flex-row gap-6">
            <div class="shrink-0">
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                        class="w-36 h-52 object-cover rounded-xl shadow-sm border border-slate-100 mx-auto md:mx-0">
                @else
                    <div
                        class="w-36 h-52 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-100 flex items-center justify-center text-xs font-bold mx-auto md:mx-0">
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
                    <a href="{{ route('books.edit', $book) }}"
                        class="px-5 py-2 rounded-xl border border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100 font-bold text-xs inline-block transition-colors shadow-2xs">
                        Edit Detail Buku
                    </a>
                </div>
            </div>
        </div>

        {{-- Book Copies Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Eksemplar Buku (Physical Copies)</h2>
                    <p class="text-xs text-slate-500 font-medium">Kelola eksemplar fisik untuk peminjaman</p>
                </div>
                <form action="{{ route('books.copies.store', $book) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs px-3.5 py-2 rounded-xl shadow-2xs transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Eksemplar</span>
                    </button>
                </form>
            </div>

            @if ($book->copies->isEmpty())
                <p class="text-xs text-slate-400 font-medium py-4 text-center">Belum ada eksemplar untuk buku ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr
                                class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3 px-4">Kode Inventaris</th>
                                <th class="pb-3 px-4">Status Available</th>
                                <th class="pb-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 font-medium">
                            @foreach ($book->copies as $copy)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $copy->inventory_code }}</td>
                                    <td class="py-3.5 px-4">
                                        <form action="{{ route('copies.update', $copy) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" onchange="this.form.submit()"
                                                class="border border-slate-200 rounded-lg px-2.5 py-1 text-xs font-semibold text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                                                @foreach (['available', 'reserved', 'borrowed', 'damaged', 'lost'] as $status)
                                                    <option value="{{ $status }}" @selected($copy->status === $status)>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <button type="button"
                                            @click="confirmDeleteOpen = true; deleteAction = '{{ route('copies.destroy', $copy) }}'; deleteMessage = 'Yakin ingin menghapus eksemplar \'{{ addslashes($copy->inventory_code) }}\'?'"
                                            class="text-rose-600 hover:text-rose-800 text-xs font-bold px-2 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Alpine.js Modal Konfirmasi Hapus Eksemplar --}}
        <div x-show="confirmDeleteOpen" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100 space-y-4"
                @click.outside="confirmDeleteOpen = false">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-2xl bg-rose-50 text-rose-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Hapus Eksemplar</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed" x-text="deleteMessage"></p>
                    </div>
                </div>

                <form method="POST" :action="deleteAction" class="flex justify-end gap-2 pt-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="confirmDeleteOpen = false"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-2xs transition-colors">
                        Hapus Eksemplar
                    </button>
                </form>
            </div>
        </div>

        {{-- Reader Reviews Section --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Ulasan & Rating Pembaca</h2>
                    <p class="text-xs text-slate-500 font-medium">Ulasan yang telah diberikan oleh anggota perpustakaan</p>
                </div>
                <div class="flex items-center gap-3 bg-emerald-50/70 border border-emerald-200/80 px-4 py-2 rounded-xl">
                    @include('partials.star-display', [
                        'rating' => $book->averageRating(),
                        'showScore' => true,
                        'reviewsCount' => $book->reviewsCount(),
                        'size' => 'md'
                    ])
                </div>
            </div>

            @if ($book->reviews->isEmpty())
                <div class="py-8 text-center bg-slate-50/50 rounded-xl border border-slate-100">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-xs sm:text-sm font-semibold text-slate-600">Belum Ada Ulasan</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Buku ini belum mendapatkan rating atau ulasan dari peminjam.</p>
                </div>
            @else
                <div class="space-y-4 divide-y divide-slate-100">
                    @foreach ($book->reviews as $review)
                        <div class="pt-4 first:pt-0 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900 leading-none">{{ $review->user->name ?? 'Pengguna' }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $review->user->email ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @include('partials.star-display', [
                                        'rating' => $review->rating,
                                        'showScore' => false,
                                        'size' => 'xs'
                                    ])
                                    <span class="text-[11px] text-slate-400 font-normal">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @if ($review->comment)
                                <div class="bg-slate-50/70 p-3 rounded-xl border border-slate-100 text-xs text-slate-700 leading-relaxed font-normal ml-0 sm:ml-10">
                                    "{{ $review->comment }}"
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
