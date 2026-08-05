@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h1 class="text-xl font-semibold mb-6">Login</h1>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-100 p-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-4">
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-2">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            Belum punya akun? <a href="/register" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
