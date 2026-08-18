@extends('layouts.guest')

@section('title', 'Login - Perpustakaan Kota')

@section('content')
<div class="w-full max-w-md my-8">
    <div class="bg-white p-8 lg:p-10 rounded-2xl shadow-sm border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Masuk ke akun Perpustakaan Kota Anda</p>
        </div>

        @if (session('success'))
            <div class="mb-5 text-sm text-emerald-800 bg-emerald-100/70 border border-emerald-200 p-3.5 rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 text-sm text-rose-700 bg-rose-50 border border-rose-200 p-3.5 rounded-xl font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-colors">
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center text-xs font-medium text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 shadow-2xs focus:ring-emerald-500 mr-2">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-bold text-sm py-3 rounded-xl shadow-xs hover:shadow-md transition-all mt-2">
                Login
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 font-medium mt-6">
            Belum punya akun? <a href="/register" class="text-emerald-700 font-bold hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
