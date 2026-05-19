@extends('layouts.public')

@section('title', $user->name . ' — Creator Profile')

@section('content')
    <!-- Creator Profile Header -->
    <div class="bg-indigo-700 pt-20 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0H20L0 20M40 40V20L20 40" fill="none" stroke="white" stroke-width="2" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-white text-indigo-700 text-4xl font-bold shadow-lg mb-6 uppercase">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">{{ $user->name }}</h1>
            <p class="text-indigo-100 text-sm">Joined {{ $user->created_at->format('F Y') }}</p>
            
            @if($user->bio)
                <div class="mt-6 max-w-2xl mx-auto">
                    <p class="text-white/90 leading-relaxed">{{ $user->bio }}</p>
                </div>
            @endif

            <!-- Stats -->
            <div class="mt-10 flex justify-center gap-8 sm:gap-16 border-t border-indigo-500/30 pt-8 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">{{ $user->exhibitions()->count() }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-1 font-medium">Exhibitions</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">{{ $user->exhibitions()->withCount('artworks')->get()->sum('artworks_count') }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-1 font-medium">Artworks</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">{{ $user->exhibitions()->withCount('comments')->get()->sum('comments_count') }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-1 font-medium">Comments</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Creator's Exhibitions -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Exhibitions by {{ $user->name }}</h2>
        </div>

        @php
            $exhibitions = $user->exhibitions()->latest()->get();
        @endphp

        @if($exhibitions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exhibitions as $exhibition)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Card Banner -->
                        <div class="aspect-video relative overflow-hidden bg-gray-100">
                            @if($exhibition->banner_image)
                                <img src="{{ $exhibition->banner_url }}"
                                     alt="{{ $exhibition->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 group-hover:scale-105 transition-transform duration-500"></div>
                            @endif
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-300"></div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 relative">
                            <!-- Category Badge -->
                            <div class="absolute -top-4 left-6 bg-white px-3 py-1 rounded-full shadow-sm text-xs font-semibold text-indigo-600 border border-gray-100">
                                {{ $exhibition->category ?? 'General' }}
                            </div>

                            <div class="flex items-center text-sm text-indigo-600 font-medium mb-2 mt-2">
                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                {{ $exhibition->exhibition_date->format('M d, Y') }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-1">
                                {{ $exhibition->title }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $exhibition->description }}</p>

                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-xs text-gray-400">{{ $exhibition->artworks()->count() }} {{ Str::plural('piece', $exhibition->artworks()->count()) }}</span>
                                <a href="{{ route('exhibitions.show', $exhibition) }}"
                                   class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                    View Exhibition
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                </svg>
                <h3 class="mt-4 text-base font-medium text-gray-900">No exhibitions</h3>
                <p class="mt-1 text-sm text-gray-500">This creator hasn't published any exhibitions yet.</p>
            </div>
        @endif
    </section>
@endsection
