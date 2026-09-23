<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'City Library - Perpustakaan Kota')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#ebf4ef] text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-200 selection:text-emerald-900">

    @php
        $isHome = request()->routeIs('home');
    @endphp

    {{-- Header / Navbar --}}
    <header x-data="{
        scrolled: false,
        mobileMenuOpen: false,
        isHome: {{ $isHome ? 'true' : 'false' }}
    }" @scroll.window="scrolled = (window.pageYOffset > 30)"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-6 lg:px-12"
        :class="(scrolled || !isHome || mobileMenuOpen) ?
        'bg-[#ebf4ef]/95 backdrop-blur-md border-b border-emerald-100/80 shadow-xs py-3.5' :
        'bg-transparent border-b border-transparent py-5'">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="text-xl sm:text-2xl font-extrabold tracking-tight transition-colors duration-300"
                    :class="(scrolled || !isHome || mobileMenuOpen) ? 'text-[#1b5e37] group-hover:text-[#144729]' :
                    'text-white drop-shadow-md'">
                    City Library
                </span>
            </a>

            {{-- Desktop Nav Links --}}
            <nav class="hidden md:flex items-center gap-8 text-xs sm:text-sm font-semibold transition-colors duration-300"
                :class="(scrolled || !isHome) ? 'text-slate-600' : 'text-white/90 drop-shadow-xs'">
                <a href="{{ route('home') }}#beranda" class="transition-colors duration-500"
                    :class="(scrolled || !isHome) ? 'hover:text-green-500' : 'hover:text-green-500 underline-offset-1'">Beranda</a>
                <a href="{{ route('home') }}#katalog" class="transition-colors duration-500"
                    :class="(scrolled || !isHome) ? 'hover:text-green-500' : 'hover:text-green-500'">Katalog Buku</a>
                <a href="{{ route('home') }}#kategori" class="transition-colors duration-500"
                    :class="(scrolled || !isHome) ? 'hover:text-green-500' : 'hover:text-green-500'">Kategori Buku</a>
                <a href="{{ route('home') }}#faq" class="transition-colors duration-500"
                    :class="(scrolled || !isHome) ? 'hover:text-green-500' : 'hover:text-green-500'">FAQ</a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 bg-[#1b5e37] hover:bg-[#144729] text-white rounded-full text-xs font-bold shadow-xs transition-all flex items-center gap-1.5">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('member.dashboard') }}"
                            class="px-4 py-2 bg-[#1b5e37] hover:bg-[#144729] text-white rounded-full text-xs font-bold shadow-xs transition-all flex items-center gap-1.5">
                            Dashboard Member
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-xs font-semibold transition-colors hidden sm:inline-block"
                        :class="(scrolled || !isHome) ? 'text-slate-700 hover:text-[#1b5e37]' :
                        'text-white hover:text-emerald-200 drop-shadow-xs'">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-[#2d7a4c] hover:bg-[#23633d] text-white rounded-full text-xs font-bold shadow-xs hover:shadow-md transition-all">
                        Join Now
                    </a>
                @endauth

                {{-- Globe icon --}}
                <div class="w-8 h-8 rounded-full border flex items-center justify-center transition-colors cursor-pointer"
                    :class="(scrolled || !isHome) ?
                    'border-slate-200 bg-white text-slate-500 hover:text-[#1b5e37] hover:border-emerald-300' :
                    'border-white/30 bg-white/20 backdrop-blur-md text-white hover:bg-white/30'"
                    title="Bahasa / Pengaturan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                        </path>
                    </svg>
                </div>

                {{-- Mobile Hamburger Button --}}
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2 rounded-xl transition-colors"
                    :class="(scrolled || !isHome || mobileMenuOpen) ? 'text-slate-700 hover:bg-emerald-100/50' :
                    'text-white hover:bg-white/20'"
                    title="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden mt-3 pt-3 border-t border-emerald-100/60 flex flex-col gap-2 font-semibold text-sm text-slate-700 pb-2">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="px-3 py-2 rounded-lg hover:bg-emerald-100/60 hover:text-[#1b5e37] transition-colors">Beranda</a>
            <a href="{{ route('public.books.index') }}" @click="mobileMenuOpen = false"
                class="px-3 py-2 rounded-lg hover:bg-emerald-100/60 hover:text-[#1b5e37] transition-colors">Katalog
                Buku</a>
            <a href="{{ route('home') }}#kategori" @click="mobileMenuOpen = false"
                class="px-3 py-2 rounded-lg hover:bg-emerald-100/60 hover:text-[#1b5e37] transition-colors">Kategori
                Buku</a>
            <a href="{{ route('home') }}#faq" @click="mobileMenuOpen = false"
                class="px-3 py-2 rounded-lg hover:bg-emerald-100/60 hover:text-[#1b5e37] transition-colors">FAQ</a>
            @guest
                <a href="{{ route('login') }}" @click="mobileMenuOpen = false"
                    class="px-3 py-2 rounded-lg hover:bg-emerald-100/60 text-[#1b5e37] font-bold transition-colors">Masuk ke
                    Akun</a>
            @endguest
        </div>
    </header>

    {{-- Main Content: full width for public pages --}}
    <main class="flex-1 {{ $isHome ? '' : 'pt-20' }}">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#e4efe8] border-t border-emerald-100/80 py-8 px-6 lg:px-12 text-slate-600 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <p class="font-bold text-[#1b5e37] text-sm mb-1">City Library</p>
                <p class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} City Library. A living room for the
                    city.</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 text-[11px] text-slate-500">
                <a href="#" class="hover:text-[#1b5e37] transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-[#1b5e37] transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-[#1b5e37] transition-colors">Accessibility</a>
                <a href="#" class="hover:text-[#1b5e37] transition-colors">Contact Us</a>
            </div>
        </div>
    </footer>

</body>

</html>
