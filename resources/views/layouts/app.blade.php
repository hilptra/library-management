<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Kota')</title>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf6f1] text-slate-800 antialiased font-sans h-screen overflow-hidden">

    {{-- Floating Toast Notification Top Center --}}
    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-full opacity-0"
            x-cloak class="fixed top-5 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 pointer-events-auto">
            @if (session('success'))
                <div
                    class="bg-emerald-800 text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center justify-between gap-3 border border-emerald-700/80">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1 rounded-full bg-emerald-700/60 text-emerald-200 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false"
                        class="text-emerald-300 hover:text-white font-bold p-1 text-lg leading-none transition-colors">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div
                    class="bg-rose-800 text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center justify-between gap-3 border border-rose-700/80">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1 rounded-full bg-rose-700/60 text-rose-200 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false"
                        class="text-rose-300 hover:text-white font-bold p-1 text-lg leading-none transition-colors">&times;</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Main App Layout Container --}}
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }" class="flex h-screen overflow-hidden min-w-0 w-full relative">

        {{-- Mobile Overlay Backdrop --}}
        <div x-show="mobileSidebarOpen" x-cloak @click="mobileSidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 md:hidden">
        </div>

        {{-- Sidebar Layout (Independently Scrollable, Compact / Minimized mode support) --}}
        <aside
            class="fixed md:static inset-y-0 left-0 z-40 bg-[#f4f9f6] border-r border-emerald-100/70 flex flex-col justify-between shrink-0 h-screen overflow-y-auto transition-all duration-300 ease-in-out"
            :class="{
                'translate-x-0': mobileSidebarOpen,
                '-translate-x-full md:translate-x-0': !mobileSidebarOpen,
                'w-72 p-5': sidebarOpen,
                'w-72 md:w-20 p-3': !sidebarOpen
            }">

            <div>
                {{-- Logo & Header --}}
                <div class="mb-6 px-1 flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div
                            class="w-10 h-10 rounded-2xl bg-[#409a63] text-white font-extrabold text-sm flex items-center justify-center shrink-0 shadow-xs">
                            PK
                        </div>
                        <div x-show="sidebarOpen" x-transition.opacity.duration.200ms
                            class="whitespace-nowrap overflow-hidden">
                            <h1 class="text-emerald-900 font-extrabold text-lg lg:text-xl tracking-tight leading-tight">
                                Perpustakaan Kota
                            </h1>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                {{ Auth::user()->role === 'admin' ? 'Admin Perpustakaan' : 'Anggota Perpustakaan' }}
                            </p>
                        </div>
                    </div>
                    {{-- Close button for mobile --}}
                    <button @click="mobileSidebarOpen = false"
                        class="md:hidden text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Primary Navigation Links --}}
                <nav class="space-y-1.5 font-medium text-sm">
                    @if (Auth::user()->role === 'admin')
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" :title="!sidebarOpen ? 'Dashboard' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('admin.dashboard') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('admin.dashboard'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Dashboard</span>
                        </a>

                        {{-- Kelola Buku --}}
                        <a href="{{ route('books.index') }}" :title="!sidebarOpen ? 'Kelola Buku' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('books.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('books.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('books.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Kelola Buku</span>
                        </a>

                        {{-- Kelola Kategori --}}
                        <a href="{{ route('categories.index') }}" :title="!sidebarOpen ? 'Kelola Kategori' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('categories.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('categories.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('categories.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Kelola Kategori</span>
                        </a>

                        {{-- Kelola Member --}}
                        <a href="{{ route('admin.users.index') }}" :title="!sidebarOpen ? 'Kelola Member' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('admin.users.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('admin.users.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Kelola Member</span>
                        </a>

                        {{-- Catatan Peminjaman --}}
                        <a href="{{ route('admin.loans.index') }}" :title="!sidebarOpen ? 'Catatan Peminjaman' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('admin.loans.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('admin.loans.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.loans.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Catatan Peminjaman</span>
                        </a>

                        {{-- Laporan --}}
                        <a href="{{ route('admin.reports.index') }}" :title="!sidebarOpen ? 'Laporan' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Laporan</span>
                        </a>

                        {{-- Pengaturan --}}
                        <a href="{{ route('admin.settings.index') }}" :title="!sidebarOpen ? 'Pengaturan' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Pengaturan</span>
                        </a>
                    @else
                        {{-- Member Navigation Links --}}
                        <a href="{{ route('member.dashboard') }}" :title="!sidebarOpen ? 'Dashboard' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.dashboard') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('member.dashboard'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('member.dashboard') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Dashboard</span>
                        </a>

                        <a href="{{ route('member.books.index') }}" :title="!sidebarOpen ? 'Katalog Buku' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.books.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('member.books.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('member.books.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Katalog Buku</span>
                        </a>

                        <a href="{{ route('member.loans.index') }}" :title="!sidebarOpen ? 'Riwayat Peminjaman' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.loans.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('member.loans.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('member.loans.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Riwayat Peminjaman</span>
                        </a>
                        <a href="{{ route('member.wishlist.index') }}"
                            :title="!sidebarOpen ? 'Daftar Keinginan' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.wishlist.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('member.wishlist.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('member.wishlist.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap">Daftar Keinginan</span>
                        </a>

                        <a href="{{ route('member.notifications.index') }}"
                            :title="!sidebarOpen ? 'Notifikasi' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl transition-colors relative {{ request()->routeIs('member.notifications.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            @if (request()->routeIs('member.notifications.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                            @endif
                            <div class="relative shrink-0">
                                <svg class="w-5 h-5 {{ request()->routeIs('member.notifications.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </div>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                                class="whitespace-nowrap flex-1 flex items-center justify-between">
                                <span>Notifikasi</span>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span class="px-1.5 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-700 rounded-full">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- Footer Sidebar Actions --}}
            <div class="mt-8 pt-4 border-t border-emerald-100/80 space-y-1 text-sm font-medium">
                @if (Auth::user()->role === 'member')
                    <a href="{{ route('member.profile.index') }}" :title="!sidebarOpen ? 'Profil' : ''"
                        class="flex items-center gap-3 py-2 rounded-xl transition-colors relative {{ request()->routeIs('member.profile.*') ? 'bg-[#dcfce7] text-[#166534] font-bold shadow-2xs' : 'text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900' }}"
                        :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                        @if (request()->routeIs('member.profile.*'))
                            <span class="absolute left-0 top-2 bottom-2 w-1 bg-[#16a34a] rounded-r-full"></span>
                        @endif
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('member.profile.*') ? 'text-[#16a34a]' : 'text-slate-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                            class="whitespace-nowrap">Profil</span>
                    </a>
                @endif

                <a href="#" :title="!sidebarOpen ? 'Bantuan' : ''"
                    class="flex items-center gap-3 py-2 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                    :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                    <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                        class="whitespace-nowrap">Bantuan</span>
                </a>

                <form method="POST" action="/logout" class="block">
                    @csrf
                    <button type="submit" :title="!sidebarOpen ? 'Keluar' : ''"
                        class="w-full flex items-center gap-3 py-2 rounded-xl text-slate-600 hover:bg-rose-50 hover:text-rose-700 transition-colors text-left font-medium"
                        :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                        <svg class="w-5 h-5 shrink-0 text-slate-500 group-hover:text-rose-700" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms
                            class="whitespace-nowrap">Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- Main Area Container (Independently Scrollable) --}}
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

            {{-- Top Navbar --}}
            <header
                class="relative z-40 py-4 px-6 lg:px-8 bg-[#edf6f1]/90 backdrop-blur-md border-b border-emerald-100/40 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">

                <div class="flex items-center gap-3">
                    {{-- Sidebar Toggle Button Desktop --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden md:flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-emerald-800 hover:bg-emerald-100/60 transition-colors"
                        title="Minimize / Maximize Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- Sidebar Toggle Button Mobile --}}
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="flex md:hidden items-center justify-center p-2 rounded-xl text-slate-600 hover:text-emerald-800 hover:bg-emerald-100/60 transition-colors"
                        title="Buka Menu Navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- User Profile Avatar Icon
                    <div class="flex items-center gap-2 pl-4 border-l border-emerald-200/60">
                        <a href="{{ Auth::user()->role === 'member' ? route('member.profile.index') : '#' }}"
                            class="w-8 h-8 rounded-full bg-emerald-100 border border-emerald-300 text-emerald-800 font-bold flex items-center justify-center text-xs shadow-2xs hover:bg-emerald-200 transition-colors"
                            title="Profil Saya">
                            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    </div> --}}
                </div>

                {{-- Header Right User Controls --}}
                <div class="flex items-center gap-4 self-end sm:self-center">

                    {{-- Notification Bell --}}
                    @php
                        $userUnreadCount = Auth::user()->unreadNotifications->count();
                        $recentNotifications = Auth::user()->notifications->take(5);
                    @endphp
                    <div x-data="{ notifOpen: false }" class="relative">
                        <button @click="notifOpen = !notifOpen"
                            class="relative p-2 text-slate-600 hover:text-emerald-700 rounded-xl hover:bg-emerald-50 transition-colors"
                            title="Notifikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if ($userUnreadCount > 0)
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-4 h-4 px-1 bg-red-500 text-white text-[10px] font-extrabold rounded-full flex items-center justify-center ring-2 ring-white">
                                    {{ $userUnreadCount > 9 ? '9+' : $userUnreadCount }}
                                </span>
                            @endif
                        </button>

                        <div x-show="notifOpen" x-cloak @click.outside="notifOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute right-0 mt-2 w-[calc(100vw-2rem)] sm:w-96 max-w-sm sm:max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 overflow-hidden divide-y divide-slate-100 ring-1 ring-slate-900/5">

                            {{-- Dropdown Header --}}
                            <div class="px-4 py-3 bg-slate-50/70 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-slate-800">Notifikasi</span>
                                    @if ($userUnreadCount > 0)
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-800 rounded-full">
                                            {{ $userUnreadCount }} Baru
                                        </span>
                                    @endif
                                </div>
                                @if ($userUnreadCount > 0 && Auth::user()->role === 'member')
                                    <form action="{{ route('member.notifications.markAllAsRead') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 hover:underline">
                                            Tandai sudah dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Notifications List --}}
                            <div class="max-h-96 overflow-y-auto divide-y divide-slate-50">
                                @forelse ($recentNotifications as $notification)
                                    @php
                                        $action = $notification->data['action'] ?? null;
                                        $title = $notification->data['title'] ?? 'Pemberitahuan';
                                        $message = $notification->data['message'] ?? '';
                                        $isUnread = is_null($notification->read_at);
                                    @endphp
                                    <a href="{{ Auth::user()->role === 'member' ? route('member.notifications.open', $notification->id) : '#' }}"
                                        class="block p-3.5 transition-colors focus:outline-none focus:ring-0 {{ $isUnread ? 'bg-emerald-50/40 hover:bg-emerald-50/70' : 'bg-white hover:bg-slate-50' }}">
                                        <div class="flex gap-3 items-start">
                                            <div
                                                class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center mt-0.5 {{ $action === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($action === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-700') }}">
                                                @if ($action === 'approved')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @elseif ($action === 'rejected')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-1 mb-0.5">
                                                    <p class="text-xs font-bold text-slate-800 truncate">{{ $title }}
                                                    </p>
                                                    @if ($isUnread)
                                                        <span
                                                            class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed wrap-break-words">
                                                    {{ $message }}</p>
                                                <p
                                                    class="text-[10px] font-medium text-slate-400 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-8 text-center">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </div>
                                        <p class="text-xs font-semibold text-slate-600">Tidak ada notifikasi baru</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Semua informasi aktivitas akan
                                            tampil di sini</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- Dropdown Footer --}}
                            @if (Auth::user()->role === 'member')
                                <div class="p-2.5 bg-slate-50/70 text-center">
                                    <a href="{{ route('member.notifications.index') }}"
                                        class="text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:underline">
                                        Lihat Semua Notifikasi &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </header>

            {{-- Main Content Area (Independent Scrollable Container: flex-1 overflow-y-auto) --}}
            <main class="flex-1 overflow-y-auto px-6 lg:px-8 py-6">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>
