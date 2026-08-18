@extends('layouts.app')

@section('title', 'Catatan Peminjaman - Perpustakaan Kota')

@section('content')
<div class="space-y-6 pt-2">

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-rose-100 border border-rose-300 text-rose-800 text-sm px-4 py-3 rounded-xl shadow-2xs flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Catatan Peminjaman</h1>
            <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">Kelola transaksi dan riwayat peminjaman buku</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 border-b border-emerald-100 pb-3 overflow-x-auto">
        @php
            $labels = [
                'pending' => 'Menunggu',
                'borrowed' => 'Dipinjam',
                'returned' => 'Dikembalikan',
                'rejected' => 'Ditolak',
            ];
        @endphp
        @foreach (['pending', 'borrowed', 'returned', 'rejected'] as $tabStatus)
            <a href="{{ route('admin.loans.index', ['status' => $tabStatus]) }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $status === $tabStatus ? 'bg-[#409a63] text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-emerald-50' }}">
                <span>{{ $labels[$tabStatus] ?? ucfirst($tabStatus) }}</span>
            </a>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-100/90 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-3 px-4">Anggota</th>
                        <th class="pb-3 px-4">Judul Buku</th>
                        <th class="pb-3 px-4">Kode Eksemplar</th>
                        <th class="pb-3 px-4">Tgl Pinjam</th>
                        @if ($status === 'returned')
                            <th class="pb-3 px-4">Tgl Pengembalian</th>
                        @endif
                        <th class="pb-3 px-4">Jatuh Tempo</th>
                        @if (in_array($status, ['pending', 'borrowed']))
                            <th class="pb-3 px-4 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium">
                    @forelse ($loans as $loan)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $loan->user->name ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-slate-800">{{ $loan->bookCopy->book->title ?? '-' }}</td>
                            <td class="py-3.5 px-4 font-mono text-xs text-slate-600">{{ $loan->bookCopy->inventory_code ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $loan->loan_date?->format('d M Y') ?? '-' }}</td>
                            @if ($status === 'returned')
                                <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $loan->return_date?->format('d M Y') ?? '-' }}</td>
                            @endif
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $loan->due_date?->format('d M Y') ?? '-' }}</td>
                            
                            @if ($status === 'pending')
                                <td class="py-3.5 px-4 text-right space-x-2">
                                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-[#409a63] hover:bg-[#348353] text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-2xs transition-colors">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold px-3 py-1.5 rounded-lg border border-rose-200 transition-colors">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            @elseif ($status === 'borrowed')
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('admin.loans.return', $loan) }}" method="POST"
                                        onsubmit="return confirm('Tandai buku ini sebagai sudah dikembalikan?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-emerald-50 text-emerald-800 hover:bg-emerald-100 text-xs font-bold px-3 py-1.5 rounded-lg border border-emerald-200 transition-colors">
                                            Tandai Kembali
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Tidak ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100">
            {{ $loans->links() }}
        </div>
    </div>

</div>
@endsection
