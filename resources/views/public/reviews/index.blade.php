@extends('layouts.guest')

@section('title', 'Ulasan — ' . $book->title)

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <a href="{{ url()->previous() }}" class="text-sm text-emerald-700 hover:underline">&larr; Kembali</a>

    <h1 class="text-xl font-bold mt-4 mb-1">{{ $book->title }}</h1>
    <div class="flex items-center gap-2 mb-6">
        @include('partials.star-display', ['rating' => $book->averageRating()])
        <span class="text-sm text-gray-500">{{ $book->averageRating() }} dari {{ $book->reviewsCount() }} ulasan</span>
    </div>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <div class="bg-white p-4 rounded-xl shadow-xs">
                <div class="flex items-center gap-2 mb-1">
                    @include('partials.star-display', ['rating' => $review->rating])
                    <span class="font-semibold text-sm">{{ $review->user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                @if ($review->comment)
                    <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada ulasan untuk buku ini.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
</div>
@endsection