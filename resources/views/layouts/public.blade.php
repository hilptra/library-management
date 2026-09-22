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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#ebf4ef] text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-200 selection:text-emerald-900">

    {{-- Header / Navbar --}}
    <header class="sticky top-0 z-50 bg-[#ebf4ef]/90 backdrop-blur-md border-b border-emerald-100/60 px-6 lg:px-12 py-3.5 transition-all">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="text-xl sm:text-2xl font-extrabold text-[#1b5e37] tracking-tight group-hover:text-[#144729] transition-colors">
                    City Library
                </span>
            </a>

            {{-- Nav Links --}}
            <nav class="hidden md:flex items-center gap-8 text-xs sm:text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-[#1b5e37] transition-colors">Beranda</a>
                <a href="{{ route('public.books.index') }}" class="hover:text-[#1b5e37] transition-colors">Katalog Buku</a>
                <a href="{{ route('home') }}#kategori" class="hover:text-[#1b5e37] transition-colors">Kategori Buku</a>
                <a href="{{ route('home') }}#faq" class="hover:text-[#1b5e37] transition-colors">FAQ</a>
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
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-[#1b5e37] transition-colors hidden sm:inline-block">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-[#2d7a4c] hover:bg-[#23633d] text-white rounded-full text-xs font-bold shadow-xs transition-all">
                        Join Now
                    </a>
                @endauth

                {{-- Globe icon --}}
                <div class="w-8 h-8 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:text-[#1b5e37] hover:border-emerald-300 transition-colors cursor-pointer" title="Bahasa / Pengaturan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content: full width for public pages --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#e4efe8] border-t border-emerald-100/80 py-8 px-6 lg:px-12 text-slate-600 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <p class="font-bold text-[#1b5e37] text-sm mb-1">City Library</p>
                <p class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} City Library. A living room for the city.</p>
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
