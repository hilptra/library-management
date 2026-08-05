@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
            <h1 class="text-xl font-semibold mb-6">Daftar Akun</h1>

            <form method="POST" action="/register" id="registerForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2 @error('name') border-red-600 @enderror">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border rounded px-3 py-2 @error('email') border-red-600 @enderror">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Nomor Telepon (Opsional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full border rounded px-3 py-2 @error('phone') border-red-600 @enderror">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Kata Sandi</label>
                    <input type="password" name="password" id="password"
                        class="w-full border rounded px-3 py-2 @error('password') border-red-600 @enderror">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border rounded px-3 py-2">
                    <p id="password_indicator" class="text-sm text-red-600 mt-1 hidden">Kata sandi tidak cocok.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">
                    Daftar
                </button>
            </form>

            <p class="text-sm text-center mt-4">
                Sudah punya akun? <a href="/login" class="text-blue-600">Masuk di sini</a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const indicator = document.getElementById('password_indicator');

            form.addEventListener('submit', function(event) {
                if (passwordInput.value !== confirmInput.value) {
                    event.preventDefault(); // Mencegah form dikirim jika password tidak sama
                    confirmInput.classList.add('border-red-600', 'focus:border-red-600',
                        'focus:ring-red-600');
                    indicator.classList.remove('hidden');
                } else {
                    confirmInput.classList.remove('border-red-600', 'focus:border-red-600',
                        'focus:ring-red-600');
                    indicator.classList.add('hidden');
                }
            });

            // Menghilangkan error saat user mulai mengetik ulang di field konfirmasi
            confirmInput.addEventListener('input', function() {
                confirmInput.classList.remove('border-red-600', 'focus:border-red-600',
                    'focus:ring-red-600');
                indicator.classList.add('hidden');
            });
        });
    </script>
@endsection
