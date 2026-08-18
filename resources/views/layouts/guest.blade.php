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

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <span class="font-bold text-lg">Perpustakaan</span>
        <div class="flex gap-4 text-sm">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
            <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600">Daftar</a>
        </div>
    </nav>

    @yield('content')

</body>

</html>