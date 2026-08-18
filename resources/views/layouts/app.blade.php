<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Kota')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf6f1] text-slate-800 antialiased font-sans min-h-screen">

    <div class="flex flex-col md:flex-row min-h-screen">

        {{-- Sidebar Layout --}}
        <aside
            class="w-full md:w-64 lg:w-72 bg-[#f4f9f6] border-r border-emerald-100/70 flex flex-col justify-between p-5 shrink-0">

            <div>
                {{-- Logo & Header --}}
                <div class="mb-6 px-2">
                    <h1 class="text-emerald-900 font-extrabold text-xl lg:text-2xl tracking-tight leading-tight">
                        Perpustakaan Kota
                    </h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        {{ Auth::user()->role === 'admin' ? 'Admin Perpustakaan' : 'Anggota Perpustakaan' }}
                    </p>
                </div>

                {{-- Quick Loan Action Button (Admin) --}}
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.loans.index') }}"
                        class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-semibold text-sm py-2.5 px-4 rounded-full shadow-sm hover:shadow-md flex items-center justify-center gap-2 transition-all mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Peminjaman Cepat</span>
                    </a>
                @endif

                {{-- Primary Navigation Links --}}
                <nav class="space-y-1.5 font-medium text-sm">
                    @if (Auth::user()->role === 'admin')
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('admin.dashboard') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('admin.dashboard'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Kelola Buku --}}
                        <a href="{{ route('books.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('books.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('books.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('books.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Kelola Buku</span>
                        </a>

                        {{-- Kelola Kategori --}}
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('categories.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('categories.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('categories.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Kelola Kategori</span>
                        </a>

                        {{-- Catatan Peminjaman --}}
                        <a href="{{ route('admin.loans.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('admin.loans.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('admin.loans.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.loans.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Catatan Peminjaman</span>
                        </a>

                        {{-- Laporan --}}
                        <a href="#"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Laporan</span>
                        </a>

                        {{-- Pengaturan --}}
                        <a href="#"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                    @else
                        {{-- Member Navigation Links --}}
                        <a href="{{ route('member.dashboard') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.dashboard') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('member.dashboard'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('member.dashboard') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('member.books.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.books.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('member.books.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('member.books.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Katalog Buku</span>
                        </a>


                        <a href="{{ route('member.loans.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.loans.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}">
                            @if (request()->routeIs('member.loans.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 {{ request()->routeIs('member.loans.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Riwayat Peminjaman</span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- Footer Sidebar Actions --}}
            <div class="mt-8 pt-4 border-t border-emerald-100/80 space-y-1 text-sm font-medium">
                <a href="#"
                    class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Bantuan</span>
                </a>

                <form method="POST" action="/logout" class="block">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3.5 py-2 rounded-xl text-slate-600 hover:bg-rose-50 hover:text-rose-700 transition-colors text-left font-medium">
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-rose-700" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- Main Area Container --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top Navbar --}}
            <header class="py-4 px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">

                {{-- Search Bar --}}
                <div class="relative w-full sm:w-80 md:w-96">
                    <div
                        class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600/70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari buku, anggota, atau peminjaman..."
                        class="w-full pl-10 pr-4 py-2 text-xs md:text-sm bg-white border border-emerald-100/90 rounded-full focus:outline-none focus:ring-2 focus:ring-emerald-500/40 text-slate-700 shadow-2xs placeholder-slate-400">
                </div>

                {{-- Header Right User Controls --}}
                <div class="flex items-center gap-6 self-end sm:self-center">

                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}"
                        class="text-sm font-semibold text-emerald-800 border-b-2 border-emerald-600 pb-0.5">
                        Dashboard
                    </a>

                    <a href="#"
                        class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                        Laporan
                    </a>

                    {{-- Notification Bell --}}
                    <button
                        class="relative p-1.5 text-slate-600 hover:text-emerald-700 rounded-full hover:bg-emerald-100/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="absolute top-1 right-1 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-emerald-50"></span>
                    </button>

                    {{-- User Profile Avatar Icon --}}
                    <div class="flex items-center gap-2 pl-2 border-l border-emerald-200/60">
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-100 border border-emerald-300 text-emerald-800 font-bold flex items-center justify-center text-xs shadow-2xs">
                            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>

                </div>

            </header>

            {{-- Main Content --}}
            <main class="flex-1 px-6 lg:px-8 pb-10">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>
