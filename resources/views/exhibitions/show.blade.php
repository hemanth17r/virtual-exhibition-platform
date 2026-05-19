@extends('layouts.public')

@section('title', $exhibition->title . ' — ArtVista')

@section('content')
    <!-- Exhibition Banner -->
    <div class="relative">
        <div class="aspect-[21/9] sm:aspect-[3/1] lg:aspect-[4/1] overflow-hidden bg-gradient-to-br from-indigo-200 to-purple-200">
            @if($exhibition->banner_image)
                <img src="{{ $exhibition->banner_url }}"
                     alt="{{ $exhibition->title }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600"></div>
            @endif
        </div>

        <!-- Exhibition Title Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-12">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white drop-shadow-lg">{{ $exhibition->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 mt-3">
                    <span class="inline-flex items-center text-sm text-white/90">
                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        {{ $exhibition->exhibition_date->format('F j, Y') }}
                    </span>
                    <span class="inline-flex items-center text-sm text-white/90">
                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Curated by <a href="{{ route('creator.show', $exhibition->user) }}" class="underline hover:text-indigo-200 transition-colors">{{ $exhibition->user->name }}</a>
                    </span>
                    <span class="inline-flex items-center text-sm text-white/90">
                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                        </svg>
                        {{ $exhibition->artworks->count() }} {{ Str::plural('Artwork', $exhibition->artworks->count()) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Exhibition Description -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">About This Exhibition</h2>
            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $exhibition->description }}</p>
        </div>
    </section>

    <!-- Artwork Gallery -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Artwork Gallery</h2>
            <span class="text-sm text-gray-400">{{ $exhibition->artworks->count() }} {{ Str::plural('piece', $exhibition->artworks->count()) }}</span>
        </div>

        @if($exhibition->artworks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($exhibition->artworks as $artwork)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <!-- Artwork Image -->
                        <div class="aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $artwork->image_url }}"
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <!-- Artwork Info -->
                        <div class="p-4">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900 line-clamp-1">{{ $artwork->title }}</h3>
                                    <p class="text-sm text-indigo-600 mt-1">{{ $artwork->artist_name }}</p>
                                </div>
                                @auth
                                    <form action="{{ route('artworks.like', $artwork) }}" method="POST" class="inline flex-shrink-0">
                                        @csrf
                                        @php
                                            $hasLiked = $artwork->likes()->where('user_id', auth()->id())->exists();
                                        @endphp
                                        <button type="submit" class="flex items-center gap-1.5 text-sm {{ $hasLiked ? 'text-red-500 hover:text-red-600' : 'text-gray-400 hover:text-red-500' }} transition-colors" title="{{ $hasLiked ? 'Unlike' : 'Like' }}">
                                            <svg class="h-5 w-5 {{ $hasLiked ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                            <span class="font-medium">{{ $artwork->likes()->count() }}</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-1.5 text-sm text-gray-400 flex-shrink-0" title="Log in to like">
                                        <svg class="h-5 w-5 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                        <span class="font-medium">{{ $artwork->likes()->count() }}</span>
                                    </div>
                                @endauth
                            </div>
                            @if($artwork->description)
                                <p class="text-xs text-gray-500 mt-3 line-clamp-2">{{ $artwork->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                </svg>
                <h3 class="mt-4 text-base font-medium text-gray-900">No artworks yet</h3>
                <p class="mt-1 text-sm text-gray-500">This exhibition doesn't have any artworks.</p>
            </div>
        @endif
    </section>

    <!-- Comments Section -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Discussion</h2>
            <span class="text-sm text-gray-500">{{ $exhibition->comments()->count() }} {{ Str::plural('Comment', $exhibition->comments()->count()) }}</span>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            @auth
                <form action="{{ route('exhibitions.comment', $exhibition) }}" method="POST" class="mb-8">
                    @csrf
                    <div>
                        <label for="content" class="sr-only">Add a comment</label>
                        <textarea id="content" name="content" rows="3" required
                                  class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 resize-none shadow-sm"
                                  placeholder="Share your thoughts about this exhibition..."></textarea>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-full font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Post Comment
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 rounded-xl p-6 text-center mb-8 border border-gray-200">
                    <p class="text-gray-600 mb-4">Please log in to join the discussion.</p>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-2.5 bg-white border border-gray-300 rounded-full font-semibold text-sm text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Log In
                    </a>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($exhibition->comments()->latest()->get() as $comment)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold text-sm uppercase">{{ substr($comment->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="bg-gray-50 rounded-2xl rounded-tl-none px-5 py-4 border border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-bold text-gray-900">
                                        <a href="{{ route('creator.show', $comment->user) }}" class="hover:text-indigo-600 hover:underline">
                                            {{ $comment->user->name }}
                                        </a>
                                    </h4>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 text-sm">
                        No comments yet. Be the first to share your thoughts!
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Back Link -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <a href="{{ route('exhibitions.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to All Exhibitions
        </a>
    </section>
@endsection
