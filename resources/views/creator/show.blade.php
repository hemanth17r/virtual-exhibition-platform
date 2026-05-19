@extends('layouts.public')

@section('title', $user->name . ' — Creator Profile')

@section('content')
    {{-- Creator Profile Header --}}
    <div class="bg-gradient-to-br from-indigo-700 via-purple-700 to-indigo-900 pt-20 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:28px 28px"></div>
        <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-purple-500 opacity-20 blur-3xl"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            {{-- Avatar --}}
            <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-white text-indigo-700 text-4xl font-extrabold shadow-2xl mb-5 uppercase ring-4 ring-white/30">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-1">{{ $user->name }}</h1>
            <p class="text-indigo-300 text-sm">
                @if($user->created_at)
                    Joined {{ $user->created_at->format('F Y') }}
                @else
                    Member of ArtVista
                @endif
            </p>

            @if($user->bio)
                <div class="mt-5 max-w-2xl mx-auto">
                    <p class="text-white/80 leading-relaxed text-base">{{ $user->bio }}</p>
                </div>
            @endif

            {{-- Stats bar --}}
            @php
                $exhibitionList = $user->exhibitions()->withCount('artworks')->get();
                $totalArtworks  = $exhibitionList->sum('artworks_count');
                $totalComments  = $user->exhibitions()->withCount('comments')->get()->sum('comments_count');
            @endphp
            <div class="mt-10 inline-flex divide-x divide-white/20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden">
                <div class="px-8 py-4 text-center">
                    <div class="text-2xl font-bold text-white">{{ $exhibitionList->count() }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-0.5 font-medium">Exhibitions</div>
                </div>
                <div class="px-8 py-4 text-center">
                    <div class="text-2xl font-bold text-white">{{ $totalArtworks }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-0.5 font-medium">Artworks</div>
                </div>
                <div class="px-8 py-4 text-center">
                    <div class="text-2xl font-bold text-white">{{ $totalComments }}</div>
                    <div class="text-xs text-indigo-200 uppercase tracking-wider mt-0.5 font-medium">Comments</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Creator's Exhibitions --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">
            Exhibitions by <span class="text-indigo-600">{{ $user->name }}</span>
        </h2>

        @php $exhibitions = $user->exhibitions()->latest()->get(); @endphp

        @if($exhibitions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exhibitions as $exhibition)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">

                        {{-- Banner with category chip inside --}}
                        <div class="aspect-video relative overflow-hidden bg-gray-100">
                            @if($exhibition->banner_image)
                                <img src="{{ $exhibition->bannerUrl }}" alt="{{ $exhibition->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                            @endif
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-semibold text-indigo-700 shadow-sm">
                                {{ $exhibition->category ?? 'General' }}
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <div class="flex items-center text-xs text-gray-400 mb-2 gap-1.5">
                                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                                @if($exhibition->exhibition_date)
                                    {{ $exhibition->exhibition_date->format('M d, Y') }}
                                @endif
                            </div>

                            <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $exhibition->title }}
                            </h3>
                            <p class="mt-1.5 text-sm text-gray-500 line-clamp-2">{{ $exhibition->description }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs text-gray-400">
                                    {{ $exhibition->artworks()->count() }} {{ Str::plural('piece', $exhibition->artworks()->count()) }}
                                </span>
                                <a href="{{ route('exhibitions.show', $exhibition) }}"
                                   class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    View
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                </svg>
                <h3 class="mt-4 text-base font-medium text-gray-900">No exhibitions yet</h3>
                <p class="mt-1 text-sm text-gray-500">This creator hasn't published any exhibitions.</p>
            </div>
        @endif
    </section>
@endsection
