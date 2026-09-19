@extends('layouts.app')

@section('title', 'Edit Profil & Keamanan - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2 max-w-5xl mx-auto">

    {{-- Navigation Breadcrumb / Back Link & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('member.profile.index') }}" class="hover:text-emerald-700 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Profil Saya</span>
                </a>
                <span>/</span>
                <span class="text-slate-800">Edit Profil & Keamanan</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Edit Profil & Keamanan</h1>
            <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Perbarui informasi data diri dan kata sandi akun Anda</p>
        </div>

        <div>
            <a href="{{ route('member.profile.index') }}"
                class="inline-flex items-center gap-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-2xs transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Profil</span>
            </a>
        </div>
    </div>

    {{-- Main Grid: 2 Form Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Card 1: Data Diri Form --}}
        <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xs border border-slate-100/90 flex flex-col justify-between">
            <div class="space-y-6">
                {{-- Form Title Header --}}
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2.5 rounded-xl bg-emerald-50 text-[#409a63]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Informasi Data Diri</h2>
                        <p class="text-xs text-slate-500 font-medium">Perbarui nama dan nomor kontak pribadi Anda</p>
                    </div>
                </div>

                {{-- Edit Profile Form --}}
                <form method="POST" action="{{ route('member.profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    {{-- Nama Input --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                placeholder="Masukkan nama lengkap"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('name') border-rose-400 ring-2 ring-rose-500/20 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 focus:bg-white transition-all">
                        </div>
                        @error('name')
                            <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Phone Input --}}
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required
                                placeholder="Contoh: 08123456789"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('phone') border-rose-400 ring-2 ring-rose-500/20 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 focus:bg-white transition-all">
                        </div>
                        @error('phone')
                            <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Readonly Email Field --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Alamat Email
                            </label>
                            <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Tidak dapat diubah
                            </span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-100/70 border border-slate-200/80 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Email digunakan sebagai ID unik masuk akun Anda.</p>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-bold text-sm py-2.5 px-5 rounded-xl shadow-2xs hover:shadow-xs flex items-center justify-center gap-2 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Perubahan Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Card 2: Password Change Form --}}
        <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xs border border-slate-100/90 flex flex-col justify-between">
            <div class="space-y-6">
                {{-- Form Title Header --}}
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="p-2.5 rounded-xl bg-blue-50 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Ganti Kata Sandi</h2>
                        <p class="text-xs text-slate-500 font-medium">Perbarui kata sandi untuk menjaga keamanan akun Anda</p>
                    </div>
                </div>

                {{-- Change Password Form --}}
                <form method="POST" action="{{ route('member.profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Password Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z" />
                                </svg>
                            </div>
                            <input type="password" id="current_password" name="current_password" required
                                placeholder="Masukkan password saat ini"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('current_password') border-rose-400 ring-2 ring-rose-500/20 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:bg-white transition-all">
                        </div>
                        @error('current_password')
                            <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                placeholder="Minimal 8 karakter"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border @error('password') border-rose-400 ring-2 ring-rose-500/20 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:bg-white transition-all">
                        </div>
                        @error('password')
                            <p class="text-rose-600 text-xs font-medium mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Konfirmasi Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                placeholder="Ulangi password baru"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-2.5 px-5 rounded-xl shadow-2xs hover:shadow-xs flex items-center justify-center gap-2 transition-all">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Perbarui Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection

