@extends('layouts.app')

@section('title', 'Notifikasi - Perpustakaan Kota')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 pt-2">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-slate-400 font-semibold">
            <a href="{{ route('member.dashboard') }}" class="hover:text-emerald-700 transition-colors">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-slate-600">Notifikasi</span>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-5 py-3 rounded-xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 text-sm font-semibold px-5 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 tracking-tight">Pusat Notifikasi</h1>
                    @if ($unreadCount > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                            {{ $unreadCount }} Belum Dibaca
                        </span>
                    @endif
                </div>
                <p class="text-slate-500 text-xs sm:text-sm font-medium mt-1">
                    Pantau informasi persetujuan, penolakan, serta riwayat peminjaman buku Anda
                </p>
            </div>

            {{-- Bulk Actions --}}
            <div class="flex items-center gap-2">
                @if ($unreadCount > 0)
                    <form action="{{ route('member.notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-[#166534] border border-emerald-200 font-bold text-xs rounded-xl transition-all shadow-2xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7m-4 0l4 4L23 7" />
                            </svg>
                            <span>Tandai Semua Dibaca</span>
                        </button>
                    </form>
                @endif

                @if ($totalCount > 0)
                    <form action="{{ route('member.notifications.clearAll') }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-red-50 text-slate-500 hover:text-red-600 border border-slate-200 hover:border-red-200 font-semibold text-xs rounded-xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus Semua</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex gap-2 border-b border-slate-200 pb-3">
            <a href="{{ route('member.notifications.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $filter === 'all' ? 'bg-[#166534] text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span>Semua</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $totalCount }}
                </span>
            </a>
            <a href="{{ route('member.notifications.index', ['filter' => 'unread']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $filter === 'unread' ? 'bg-[#166534] text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span>Belum Dibaca</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'unread' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700' }}">
                    {{ $unreadCount }}
                </span>
            </a>
            <a href="{{ route('member.notifications.index', ['filter' => 'read']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $filter === 'read' ? 'bg-[#166534] text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span>Sudah Dibaca</span>
            </a>
        </div>

        {{-- Notification List --}}
        <div class="space-y-3">
            @forelse ($notifications as $notification)
                @php
                    $action = $notification->data['action'] ?? null;
                    $title = $notification->data['title'] ?? 'Pemberitahuan Peminjaman';
                    $message = $notification->data['message'] ?? '';
                    $bookCover = $notification->data['book_cover'] ?? null;
                    $isUnread = is_null($notification->read_at);
                @endphp
                <div class="rounded-2xl p-4 sm:p-5 border transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 {{ $isUnread ? 'bg-emerald-50/40 border-emerald-200/90 shadow-2xs' : 'bg-white border-slate-100/90 hover:border-slate-200' }}">
                    
                    {{-- Left Details --}}
                    <div class="flex items-start gap-4 flex-1 min-w-0">
                        {{-- Icon or Cover Thumbnail --}}
                        @if ($bookCover)
                            <div class="w-12 h-16 rounded-lg overflow-hidden shrink-0 border border-slate-200 shadow-2xs">
                                <img src="{{ asset('storage/' . $bookCover) }}" alt="Cover" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-11 h-11 rounded-2xl shrink-0 flex items-center justify-center {{ $action === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($action === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-700') }}">
                                @if ($action === 'approved')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif ($action === 'rejected')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                @endif
                            </div>
                        @endif

                        {{-- Text Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                <h2 class="font-bold text-sm text-slate-900 leading-snug">
                                    {{ $title }}
                                </h2>
                                @if ($isUnread)
                                    <span class="px-2 py-0.5 text-[10px] font-extrabold bg-[#dcfce7] text-[#166534] rounded-full border border-emerald-200">
                                        Baru
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-2">
                                {{ $message }}
                            </p>

                            <div class="flex items-center gap-4 text-[11px] text-slate-400 font-medium">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }} ({{ $notification->created_at->format('d M Y, H:i') }})
                                </span>

                                @if (!empty($notification->data['book_id']))
                                    <a href="{{ route('member.books.show', $notification->data['book_id']) }}"
                                        class="text-emerald-700 hover:text-emerald-800 font-bold hover:underline">
                                        Lihat Buku & Ulasan &rarr;
                                    </a>
                                @else
                                    <a href="{{ route('member.loans.index') }}"
                                        class="text-emerald-700 hover:text-emerald-800 font-bold hover:underline">
                                        Lihat Riwayat &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Right Action Buttons --}}
                    <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                        @if ($isUnread)
                            <form action="{{ route('member.notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="p-2 rounded-xl border border-slate-200 bg-white hover:bg-emerald-50 hover:border-emerald-200 text-slate-500 hover:text-emerald-700 transition-all text-xs font-semibold"
                                    title="Tandai sudah dibaca">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('member.notifications.destroy', $notification->id) }}" method="POST"
                            onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 rounded-xl border border-slate-200 bg-white hover:bg-red-50 hover:border-red-200 text-slate-400 hover:text-red-600 transition-all text-xs font-semibold"
                                title="Hapus notifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-100/90 shadow-xs max-w-md mx-auto my-8">
                    <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl mx-auto flex items-center justify-center mb-4 border border-slate-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-900 mb-1">Tidak Ada Notifikasi</h2>
                    <p class="text-xs text-slate-500 leading-relaxed mb-5">
                        @if ($filter === 'unread')
                            Semua notifikasi telah Anda baca.
                        @elseif ($filter === 'read')
                            Belum ada riwayat notifikasi yang telah dibaca.
                        @else
                            Anda belum memiliki pemberitahuan baru saat ini.
                        @endif
                    </p>
                    <a href="{{ route('member.books.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-[#409a63] hover:bg-[#348353] text-white font-bold text-xs rounded-xl transition-all shadow-2xs">
                        <span>Jelajahi Katalog Buku</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6 pt-4 border-t border-slate-100">
            {{ $notifications->links() }}
        </div>

    </div>
@endsection
