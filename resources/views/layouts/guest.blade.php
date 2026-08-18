<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Kota')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf6f1] text-slate-800 antialiased font-sans min-h-screen flex flex-col justify-between">

    <nav class="bg-white/80 backdrop-blur-md border-b border-emerald-100/70 px-6 py-4 flex justify-between items-center shadow-2xs">
        <div>
            <a href="/" class="text-emerald-900 font-extrabold text-xl tracking-tight leading-tight">
                Perpustakaan Kota
            </a>
        </div>
        <div class="flex items-center gap-3 text-sm font-semibold">
            <a href="{{ route('login') }}" class="px-4 py-2 text-emerald-800 hover:text-emerald-950 transition-colors">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-2xs transition-all">Daftar</a>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-4">
        @yield('content')
    </main>

    <footer class="py-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Perpustakaan Kota. All rights reserved.
    </footer>

</body>

</html>