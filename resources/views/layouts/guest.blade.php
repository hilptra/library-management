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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
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

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-[#1b5e37] transition-colors hidden sm:inline-block">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2 bg-[#2d7a4c] hover:bg-[#23633d] text-white rounded-full text-xs font-bold shadow-xs transition-all">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content: centered for auth forms --}}
    <main class="flex-1 flex items-center justify-center p-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="py-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} City Library. All rights reserved.
    </footer>

</body>

</html>