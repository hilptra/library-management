<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-between items-center p-6 text-gray-800">
    <header class="w-full max-w-4xl flex items-center justify-between py-4">
        <h1 class="text-xl font-bold text-gray-800">Perpustakaan</h1>
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Dashboard Admin</a>
                    @else
                        <a href="{{ route('member.dashboard') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Dashboard Member</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-black">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Daftar</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-4xl bg-white p-8 sm:p-12 rounded-lg shadow-md my-auto text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Selamat Datang di Sistem Manajemen Perpustakaan</h2>
        <p class="text-gray-600 mb-8 max-w-lg mx-auto">
            Temukan dan kelola koleksi buku perpustakaan dengan mudah. Silakan masuk atau mendaftar untuk mulai
            menggunakan layanan perpustakaan.
        </p>
        <div class="flex items-center justify-center gap-4">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Ke Dashboard
                        Admin</a>
                @else
                    <a href="{{ route('member.dashboard') }}"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Ke Dashboard
                        Member</a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">Masuk Sekarang</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 font-medium">Daftar
                        Akun</a>
                @endif
            @endauth
        </div>
    </main>

    <footer class="text-xs text-gray-500 py-4">
        &copy; {{ date('Y') }} Sistem Manajemen Perpustakaan. All rights reserved.
    </footer>
</body>

</html>
