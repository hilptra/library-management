<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="px-6 py-4 border-b">
                <span class="font-bold text-lg">Perpustakaan</span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Kategori
                    </a>
                    <a href="{{ route('books.index') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('books.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Buku
                    </a>
                    <a href="{{ route('admin.loans.index') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.loans.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Peminjaman
                    </a>
                @else
                    <a href="{{ route('member.dashboard') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('member.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('member.books.index') }}"
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('member.books.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        Katalog Buku
                    </a>
                @endif
            </nav>

            <div class="px-4 py-4 border-t">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-3 py-2 rounded text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten Utama --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>
