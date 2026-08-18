@extends('layouts.guest')

@section('title', 'Daftar Akun - Perpustakaan Kota')

@section('content')
<div class="w-full max-w-md my-8">
    <div class="bg-white p-8 lg:p-10 rounded-2xl shadow-sm border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Member</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Buat akun untuk mengakses layanan Perpustakaan Kota</p>
        </div>

        <form method="POST" action="/register" id="registerForm" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap Anda"
                    class="w-full border rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com"
                    class="w-full border rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nomor Telepon (Opsional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890"
                    class="w-full border rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors @error('phone') border-rose-500 @enderror">
                @error('phone')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Kata Sandi</label>
                <input type="password" name="password" id="password" required placeholder="••••••••"
                    class="w-full border rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
                <p id="password_indicator" class="text-xs text-rose-600 mt-1 font-medium hidden">Kata sandi tidak cocok.</p>
            </div>

            <button type="submit" class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-bold text-sm py-3 rounded-xl shadow-xs hover:shadow-md transition-all mt-2">
                Daftar
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 font-medium mt-6">
            Sudah punya akun? <a href="/login" class="text-emerald-700 font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const indicator = document.getElementById('password_indicator');

        form.addEventListener('submit', function(event) {
            if (passwordInput.value !== confirmInput.value) {
                event.preventDefault();
                confirmInput.classList.add('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500');
                indicator.classList.remove('hidden');
            } else {
                confirmInput.classList.remove('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500');
                indicator.classList.add('hidden');
            }
        });

        confirmInput.addEventListener('input', function() {
            confirmInput.classList.remove('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-500');
            indicator.classList.add('hidden');
        });
    });
</script>
@endsection
