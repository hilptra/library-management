<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Kota - Landing Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf6f1] text-slate-800 antialiased font-sans min-h-screen flex flex-col justify-between p-6">
    <header class="w-full max-w-5xl mx-auto flex items-center justify-between py-4">
        <div>
            <h1 class="text-emerald-950 font-extrabold text-2xl tracking-tight">Perpustakaan Kota</h1>
            <p class="text-xs text-slate-500 font-medium">City Library Management System</p>
        </div>
        @if (Route::has('login'))
            <nav class="flex items-center gap-3 text-sm font-semibold">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-5 py-2.5 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-2xs transition-all">Dashboard Admin</a>
                    @else
                        <a href="{{ route('member.dashboard') }}"
                            class="px-5 py-2.5 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-2xs transition-all">Dashboard Member</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-emerald-800 hover:text-emerald-950 transition-colors">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-2xs transition-all">Daftar</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-4xl mx-auto bg-white p-8 sm:p-14 rounded-2xl shadow-sm border border-slate-100 my-auto text-center">
        <span class="inline-block bg-[#dcfce7] text-[#166534] text-xs font-bold px-3.5 py-1 rounded-full mb-4">Perpustakaan Digital</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold mb-4 text-slate-900 tracking-tight">Selamat Datang di Perpustakaan Kota</h2>
        <p class="text-slate-500 mb-8 max-w-lg mx-auto text-sm sm:text-base font-medium">
            Temukan ribuan koleksi buku digital, kelola peminjaman eksemplar fisik, dan pantau aktivitas perpustakaan secara real-time.
        </p>
        <div class="flex items-center justify-center gap-4 flex-wrap">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-3 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-xs hover:shadow-md font-bold text-sm transition-all">Ke Dashboard Admin</a>
                @else
                    <a href="{{ route('member.dashboard') }}"
                        class="px-6 py-3 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-xs hover:shadow-md font-bold text-sm transition-all">Ke Dashboard Member</a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-[#409a63] hover:bg-[#348353] text-white rounded-xl shadow-xs hover:shadow-md font-bold text-sm transition-all">Masuk Sekarang</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 border border-emerald-200 text-emerald-800 hover:bg-emerald-50 rounded-xl font-bold text-sm transition-colors">Daftar Akun</a>
                @endif
            @endauth
        </div>
    </main>

    <footer class="text-xs text-slate-400 text-center py-4">
        &copy; {{ date('Y') }} Perpustakaan Kota. All rights reserved.
    </footer>
</body>

</html>
