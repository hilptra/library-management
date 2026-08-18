@extends('layouts.app')

@section('title', 'Dashboard Member - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2">

    @if (session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    {{-- Welcome Banner --}}
    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xs border border-slate-100/90 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="inline-block bg-[#dcfce7] text-[#166534] text-xs font-bold px-3 py-1 rounded-full mb-3">Selamat Datang</span>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-slate-500 text-sm font-medium mt-1">Jelajahi koleksi buku terbaru dan kelola peminjaman buku perpustakaan Anda secara online.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('member.books.index') }}"
                class="bg-[#409a63] hover:bg-[#348353] text-white font-bold text-sm py-3 px-6 rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Jelajahi Katalog Buku</span>
            </a>
        </div>
    </div>

</div>
@endsection
