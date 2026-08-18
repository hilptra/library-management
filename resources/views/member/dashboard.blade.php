@extends('layouts.app')

@section('title', 'Dashboard Member')

@section('content')
    <div class="p-6">
        @if (session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Dashboard Member</h1>

        <a href="{{ route('member.books.index') }}"
            class="inline-block text-sm bg-blue-500 text-white px-4 py-2 mb-4 rounded hover:bg-blue-700">Lihat Buku</a>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="text-sm bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
        </form>


    </div>
@endsection
