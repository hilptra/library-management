@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 px-4">

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <h1 class="text-xl font-bold mb-4">Kelola Peminjaman</h1>

        <div class="flex gap-2 mb-4">
            @foreach (['pending', 'borrowed', 'returned', 'rejected'] as $tabStatus)
                <a href="{{ route('admin.loans.index', ['status' => $tabStatus]) }}"
                    class="px-3 py-1 rounded text-sm {{ $status === $tabStatus ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                    {{ ucfirst($tabStatus) }}
                </a>
            @endforeach
        </div>

        <table class="w-full bg-white shadow rounded text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Anggota</th>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Kode Eksemplar</th>
                    <th class="p-3">Tgl Pinjam</th>
                    @if ($status === 'returned')
                        <th class="p-3">Tgl Pengembalian</th>
                    @endif
                    <th class="p-3">Jatuh Tempo</th>
                    @if (in_array($status, ['pending', 'borrowed']))
                        <th class="p-3">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr class="border-b">
                        <td class="p-3">{{ $loan->user->name }}</td>
                        <td class="p-3">{{ $loan->bookCopy->book->title }}</td>
                        <td class="p-3">{{ $loan->bookCopy->inventory_code }}</td>
                        <td class="p-3">{{ $loan->loan_date?->format('d M Y') ?? '-' }}</td>
                        @if ($status === 'returned')
                            <td class="p-3">{{ $loan->return_date?->format('d M Y') ?? '-' }}</td>
                        @endif
                        <td class="p-3">{{ $loan->due_date?->format('d M Y') ?? '-' }}</td>
                        @if ($status === 'pending')
                            <td class="p-3 flex gap-2">
                                <form action="{{ route('admin.loans.approve', $loan) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600">Approve</button>
                                </form>
                                <form action="{{ route('admin.loans.reject', $loan) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600">Reject</button>
                                </form>
                            </td>
                        @elseif ($status === 'borrowed')
                            <td class="p-3">
                                <form action="{{ route('admin.loans.return', $loan) }}" method="POST"
                                    onsubmit="return confirm('Tandai buku ini sebagai sudah dikembalikan?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-600">Tandai Kembali</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-3 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $loans->links() }}</div>
    </div>
@endsection
