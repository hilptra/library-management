@php
    $variant = $variant ?? 'icon';
    $isWishlisted = isset($isWishlisted) ? $isWishlisted : (Auth::check() && Auth::user()->wishlistedBooks->contains('id', $book->id));
@endphp

@if ($variant === 'detail')
    <form action="{{ route('member.wishlist.toggle', $book) }}" method="POST" class="flex-1">
        @csrf
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition-all {{ $isWishlisted ? 'bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 hover:border-rose-300 shadow-2xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-rose-600' }}"
            title="{{ $isWishlisted ? 'Hapus dari Daftar Keinginan' : 'Tambahkan ke Daftar Keinginan' }}">
            @if ($isWishlisted)
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>Hapus Wishlist</span>
            @else
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span>Wishlist</span>
            @endif
        </button>
    </form>
@elseif ($variant === 'card-float')
    <form action="{{ route('member.wishlist.toggle', $book) }}" method="POST" class="inline-flex">
        @csrf
        <button type="submit"
            class="w-8 h-8 rounded-full backdrop-blur-md shadow-xs flex items-center justify-center transition-all duration-200 {{ $isWishlisted ? 'bg-white/95 text-rose-500 hover:scale-110 shadow-rose-200' : 'bg-white/90 text-slate-400 hover:text-rose-500 hover:bg-white hover:scale-110' }}"
            title="{{ $isWishlisted ? 'Hapus dari Daftar Keinginan' : 'Tambah ke Daftar Keinginan' }}">
            @if ($isWishlisted)
                <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            @endif
        </button>
    </form>
@else
    <form action="{{ route('member.wishlist.toggle', $book) }}" method="POST" class="inline-flex">
        @csrf
        <button type="submit"
            class="w-8 h-8 rounded-xl border flex items-center justify-center transition-all duration-200 {{ $isWishlisted ? 'bg-rose-50 border-rose-200 text-rose-600 hover:bg-rose-100 hover:scale-105' : 'bg-white border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50/70 hover:scale-105' }}"
            title="{{ $isWishlisted ? 'Hapus dari Daftar Keinginan' : 'Tambah ke Daftar Keinginan' }}">
            @if ($isWishlisted)
                <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            @endif
        </button>
    </form>
@endif