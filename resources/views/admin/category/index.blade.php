@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 px-4" x-data="{ open: false, mode: 'create', categoryId: null, categoryName: '' }">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Kelola Kategori</h1>
            <button @click="open = true; mode = 'create'; categoryId = null; categoryName = ''"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Kategori
            </button>
        </div>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">Nama Kategori</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="p-3">{{ $category->name }}</td>
                        <td class="p-3">
                            <button
                                @click="open = true; mode = 'edit'; categoryId = {{ $category->id }}; categoryName = '{{ $category->name }}'"
                                class="text-yellow-600">Edit</button>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin menghapus kategori {{ $category->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-3 text-center text-gray-500">Belum ada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        {{-- Modal --}}
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.outside="open = false">

                <h2 class="text-lg font-bold mb-4" x-text="mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'"></h2>

                <form method="POST"
                    :action="mode === 'create'
                        ?
                        '{{ route('categories.store') }}' :
                        '{{ route('categories.update', ':id') }}'.replace(':id', categoryId)">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <input type="text" name="name" x-model="categoryName" placeholder="Nama kategori"
                        class="w-full border rounded px-3 py-2 mb-4">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="open = false" class="px-4 py-2 rounded border">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
