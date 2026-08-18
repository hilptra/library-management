@extends('layouts.app')

@section('title', 'Kelola Kategori - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2" x-data="{ open: false, mode: 'create', categoryId: null, categoryName: '' }">

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Tambah Kategori</span>
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
                                    @click="open = true; mode = 'edit'; categoryId = {{ $category->id }}; categoryName = '{{ $category->name }}'"
                                    class="text-amber-600 hover:text-amber-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-amber-50 transition-colors">
                                    Edit
                                </button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin menghapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-8 text-center text-slate-400 font-medium">Belum ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Alpine.js Modal --}}
    <div x-show="open" x-cloak class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100" @click.outside="open = false">
            <h2 class="text-xl font-extrabold text-slate-900 mb-4" x-text="mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'"></h2>

            <form method="POST"
                :action="mode === 'create' ? '{{ route('categories.store') }}' : '{{ route('categories.update', ':id') }}'.replace(':id', categoryId)" class="space-y-4">
                @csrf
                <template x-if="mode === 'edit'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" x-model="categoryName" placeholder="Masukkan nama kategori" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="open = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs shadow-2xs transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
