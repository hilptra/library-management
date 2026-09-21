@extends('layouts.app')

@section('title', 'Detail Member')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <a href="{{ route('admin.users.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Kembali</a>

    <div class="bg-white rounded-2xl p-6 shadow-xs">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-500">{{ $user->phone ?? '-' }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                {{ $user->status === 'active' ? 'Aktif' : 'Suspended' }}
            </span>
        </div>

        <div class="grid grid-cols-4 gap-3 mt-4">
            <div class="bg-gray-50 p-3 rounded-xl text-center">
                <p class="text-xs text-gray-500">Total Pinjam</p>
                <p class="text-lg font-bold">{{ $loanStats['total'] }}</p>
            </div>
            <div class="bg-blue-50 p-3 rounded-xl text-center">
                <p class="text-xs text-blue-700">Sedang Pinjam</p>
                <p class="text-lg font-bold text-blue-800">{{ $loanStats['borrowed'] }}</p>
            </div>
            <div class="bg-green-50 p-3 rounded-xl text-center">
                <p class="text-xs text-green-700">Dikembalikan</p>
                <p class="text-lg font-bold text-green-800">{{ $loanStats['returned'] }}</p>
            </div>
            <div class="bg-red-50 p-3 rounded-xl text-center">
                <p class="text-xs text-red-700">Total Denda</p>
                <p class="text-lg font-bold text-red-800">Rp {{ number_format($loanStats['totalFine'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-xs">
        <h2 class="font-bold mb-4">Riwayat Peminjaman</h2>
        @forelse ($user->loans as $loan)
            <div class="flex justify-between items-center py-2 border-b text-sm">
                <span>{{ $loan->bookCopy->book->title }}</span>
                <span class="px-2 py-1 rounded text-xs {{ $loan->statusBadgeClass() }}">{{ ucfirst($loan->status) }}</span>
            </div>
        @empty
            <p class="text-sm text-gray-400">Belum ada riwayat peminjaman.</p>
        @endforelse
    </div>

</div>
@endsection