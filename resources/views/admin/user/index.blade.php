@extends('layouts.app')

@section('title', 'Kelola Member - Perpustakaan Kota')

@section('content')
    <div class="space-y-6 pt-2" x-data="{
        editOpen: false,
        confirmOpen: false,
        userId: null,
        userName: '',
        userPhone: '',
        confirmTitle: '',
        confirmMessage: '',
        confirmAction: '',
        confirmBtnText: '',
        confirmBtnClass: ''
    }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Kelola Member</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Daftar anggota dan status akun Perpustakaan
                    Kota</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="pb-3 px-4">Nama Member</th>
                            <th class="pb-3 px-4">Email</th>
                            <th class="pb-3 px-4">Telepon</th>
                            <th class="pb-3 px-4">Status</th>
                            <th class="pb-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-medium">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $user->name }}</td>
                                <td class="py-3.5 px-4 text-slate-600 text-xs">{{ $user->email }}</td>
                                <td class="py-3.5 px-4 text-slate-600 text-xs">{{ $user->phone ?? '-' }}</td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-bold inline-block {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $user->status === 'active' ? 'Aktif' : 'Suspended' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right space-x-2">
                                    <button
                                        @click="editOpen = true; userId = {{ $user->id }}; userName = '{{ addslashes($user->name) }}'; userPhone = '{{ addslashes($user->phone ?? '') }}'"
                                        class="text-amber-600 hover:text-amber-800 text-xs font-bold px-2.5 py-1 rounded-lg hover:bg-amber-50 transition-colors">
                                        Edit
                                    </button>

                                    <button type="button"
                                        @click="confirmOpen = true; confirmTitle = 'Konfirmasi Status Member'; confirmMessage = 'Yakin ingin {{ $user->status === 'active' ? 'menonaktifkan (suspend)' : 'mengaktifkan kembali' }} member \'{{ addslashes($user->name) }}\'?'; confirmAction = '{{ route('admin.users.toggle-status', $user) }}'; confirmBtnText = '{{ $user->status === 'active' ? 'Ya, Suspend' : 'Ya, Aktifkan' }}'; confirmBtnClass = '{{ $user->status === 'active' ? 'bg-rose-600 hover:bg-rose-700 text-white' : 'bg-[#409a63] hover:bg-[#348353] text-white' }}'"
                                        class="{{ $user->status === 'active' ? 'text-rose-600 hover:text-rose-800 hover:bg-rose-50' : 'text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50' }} text-xs font-bold px-2.5 py-1 rounded-lg transition-colors">
                                        {{ $user->status === 'active' ? 'Suspend' : 'Aktifkan' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada data member
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        </div>

        {{-- Modal Edit Member --}}
        <div x-show="editOpen" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100 space-y-4"
                @click.outside="editOpen = false">
                <h2 class="text-xl font-extrabold text-slate-900">Edit Data Member</h2>

                <form method="POST" :action="'{{ route('admin.users.update', ':id') }}'.replace(':id', userId)"
                    class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama
                            Member</label>
                        <input type="text" name="name" x-model="userName" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nomor
                            Telepon</label>
                        <input type="text" name="phone" x-model="userPhone" placeholder="Contoh: 08123456789"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="editOpen = false"
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

        {{-- Modal Konfirmasi Action --}}
        <div x-show="confirmOpen" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-md shadow-xl border border-slate-100 space-y-4"
                @click.outside="confirmOpen = false">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-2xl bg-amber-50 text-amber-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900" x-text="confirmTitle"></h3>
                        <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed" x-text="confirmMessage"></p>
                    </div>
                </div>

                <form method="POST" :action="confirmAction" class="flex justify-end gap-2 pt-2">
                    @csrf
                    @method('PATCH')
                    <button type="button" @click="confirmOpen = false"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" :class="confirmBtnClass"
                        class="px-5 py-2.5 rounded-xl font-bold text-xs shadow-2xs transition-colors"
                        x-text="confirmBtnText">
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
