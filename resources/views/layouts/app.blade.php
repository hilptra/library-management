<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Kota')</title>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf6f1] text-slate-800 antialiased font-sans h-screen overflow-hidden">

    {{-- Floating Toast Notification Top Center --}}
    @if (session('success') || session('error'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="-translate-y-full opacity-0"
             x-cloak
             class="fixed top-5 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 pointer-events-auto">
            @if (session('success'))
                <div class="bg-emerald-800 text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center justify-between gap-3 border border-emerald-700/80">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1 rounded-full bg-emerald-700/60 text-emerald-200 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-300 hover:text-white font-bold p-1 text-lg leading-none transition-colors">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-rose-800 text-white text-xs sm:text-sm font-semibold px-4 py-3 rounded-2xl shadow-xl flex items-center justify-between gap-3 border border-rose-700/80">
                    <div class="flex items-center gap-2.5">
                        <div class="p-1 rounded-full bg-rose-700/60 text-rose-200 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-300 hover:text-white font-bold p-1 text-lg leading-none transition-colors">&times;</button>
                </div>
            @endif
        </div>
    @endif

    {{-- Main App Layout Container --}}
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }" class="flex h-screen overflow-hidden min-w-0 w-full relative">

        {{-- Mobile Overlay Backdrop --}}
        <div x-show="mobileSidebarOpen"
             x-cloak
             @click="mobileSidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
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
                        <div class="w-10 h-10 rounded-2xl bg-[#409a63] text-white font-extrabold text-sm flex items-center justify-center shrink-0 shadow-xs">
                            PK
                        </div>
                        <div x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap overflow-hidden">
                            <h1 class="text-emerald-900 font-extrabold text-lg lg:text-xl tracking-tight leading-tight">
                                Perpustakaan Kota
                            </h1>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                {{ Auth::user()->role === 'admin' ? 'Admin Perpustakaan' : 'Anggota Perpustakaan' }}
                            </p>
                        </div>
                    </div>
                    {{-- Close button for mobile --}}
                    <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Quick Loan Action Button (Admin) --}}
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.loans.index') }}"
                        :title="!sidebarOpen ? 'Peminjaman Cepat' : ''"
                        class="w-full bg-[#409a63] hover:bg-[#348353] text-white font-semibold text-sm py-2.5 rounded-2xl shadow-sm hover:shadow-md flex items-center gap-2.5 transition-all mb-6 overflow-hidden"
                        :class="sidebarOpen ? 'justify-start px-4' : 'justify-center px-0'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Peminjaman Cepat</span>
                    </a>
                @endif

                {{-- Primary Navigation Links --}}
                <nav class="space-y-1.5 font-medium text-sm">
                    @if (Auth::user()->role === 'admin')
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                            :title="!sidebarOpen ? 'Dashboard' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Dashboard</span>
                        </a>

                        {{-- Kelola Buku --}}
                        <a href="{{ route('books.index') }}"
                            :title="!sidebarOpen ? 'Kelola Buku' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Kelola Buku</span>
                        </a>

                        {{-- Kelola Kategori --}}
                        <a href="{{ route('categories.index') }}"
                            :title="!sidebarOpen ? 'Kelola Kategori' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Kelola Kategori</span>
                        </a>

                        {{-- Kelola Member --}}
                        <a href="{{ route('admin.users.index') }}"
                            :title="!sidebarOpen ? 'Kelola Member' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Kelola Member</span>
                        </a>

                        {{-- Catatan Peminjaman --}}
                        <a href="{{ route('admin.loans.index') }}"
                            :title="!sidebarOpen ? 'Catatan Peminjaman' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Catatan Peminjaman</span>
                        </a>

                        {{-- Laporan --}}
                        <a href="#"
                            :title="!sidebarOpen ? 'Laporan' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Laporan</span>
                        </a>

                        {{-- Pengaturan --}}
                        <a href="#"
                            :title="!sidebarOpen ? 'Pengaturan' : ''"
                            class="flex items-center gap-3 py-2.5 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                            :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                            <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Pengaturan</span>
                        </a>
                    @else
                        {{-- Member Navigation Links --}}
                        <a href="{{ route('member.dashboard') }}"
                            :title="!sidebarOpen ? 'Dashboard' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Dashboard</span>
                        </a>

                        <a href="{{ route('member.books.index') }}"
                            :title="!sidebarOpen ? 'Katalog Buku' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Katalog Buku</span>
                        </a>

                        <a href="{{ route('member.loans.index') }}"
                            :title="!sidebarOpen ? 'Riwayat Peminjaman' : ''"
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
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Riwayat Peminjaman</span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- Footer Sidebar Actions --}}
            <div class="mt-8 pt-4 border-t border-emerald-100/80 space-y-1 text-sm font-medium">
                <a href="#"
                    :title="!sidebarOpen ? 'Bantuan' : ''"
                    class="flex items-center gap-3 py-2 rounded-xl text-slate-600 hover:bg-emerald-100/50 hover:text-slate-900 transition-colors"
                    :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                    <svg class="w-5 h-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Bantuan</span>
                </a>

                <form method="POST" action="/logout" class="block">
                    @csrf
                    <button type="submit"
                        :title="!sidebarOpen ? 'Keluar' : ''"
                        class="w-full flex items-center gap-3 py-2 rounded-xl text-slate-600 hover:bg-rose-50 hover:text-rose-700 transition-colors text-left font-medium"
                        :class="sidebarOpen ? 'px-3.5' : 'justify-center px-0'">
                        <svg class="w-5 h-5 shrink-0 text-slate-500 group-hover:text-rose-700" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- Main Area Container (Independently Scrollable) --}}
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

            {{-- Top Navbar --}}
            <header class="py-4 px-6 lg:px-8 bg-[#edf6f1]/90 backdrop-blur-md border-b border-emerald-100/40 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    {{-- Sidebar Toggle Button Desktop --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden md:flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-emerald-800 hover:bg-emerald-100/60 transition-colors"
                        title="Minimize / Maximize Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- Sidebar Toggle Button Mobile --}}
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen"
                        class="flex md:hidden items-center justify-center p-2 rounded-xl text-slate-600 hover:text-emerald-800 hover:bg-emerald-100/60 transition-colors"
                        title="Buka Menu Navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

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

            {{-- Main Content Area (Independent Scrollable Container: flex-1 overflow-y-auto) --}}
            <main class="flex-1 overflow-y-auto px-6 lg:px-8 py-6">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>
