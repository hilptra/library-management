@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h1 class="text-xl font-semibold mb-6">Login</h1>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-4">
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">
                Login
            </button>
        </form>
    </div>
</div>
@endsection