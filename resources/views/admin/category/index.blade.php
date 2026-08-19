@extends('layouts.app')

@section('title', 'Kelola Kategori - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2" x-data="{ open: false, mode: 'create', categoryId: null, categoryName: '', confirmDeleteOpen: false, deleteAction: '', deleteMessage: '' }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Kategori</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Daftar kategori buku di Perpustakaan Kota</p>
            </div>
            <div>
                <button @click="open = true; mode = 'create'; categoryId = null; categoryName = ''"
                    class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-2xs hover:shadow-xs flex items-center gap-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3 px-4">Nama Kategori</th>
                            <th class="pb-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-medium">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $category->name }}</td>
                                <td class="py-3.5 px-4 text-right space-x-2">
                                    <button
                                        @click="open = true; mode = 'edit'; categoryId = {{ $category->id }}; categoryName = '{{ addslashes($category->name) }}'"
                                        class="text-yellow-600">Edit</button>
                                    <button type="button"
                                        @click="confirmDeleteOpen = true; deleteAction = '{{ route('categories.destroy', $category) }}'; deleteMessage = 'Yakin menghapus kategori \'{{ addslashes($category->name) }}\'?'"
                                        class="text-rose-600 hover:text-rose-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-8 text-center text-slate-400 font-medium">Belum ada kategori
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100">
                {{ $categories->links() }}
            </div>
        </div>

        {{-- Alpine.js Modal Form Create/Edit --}}
        <div x-show="open" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100"
                @click.outside="open = false">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4"
                    x-text="mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'"></h2>

                <form method="POST"
                    :action="mode === 'create' ? '{{ route('categories.store') }}' : '{{ route('categories.update', ':id') }}'
                        .replace(':id', categoryId)"
                    class="space-y-4">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama
                            Kategori</label>
                        <input type="text" name="name" x-model="categoryName" placeholder="Masukkan nama kategori"
                            required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="open = false"
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs shadow-2xs transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Alpine.js Modal Konfirmasi Hapus --}}
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
                        <h3 class="text-lg font-extrabold text-slate-900">Hapus Kategori</h3>
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
                        Hapus Kategori
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
