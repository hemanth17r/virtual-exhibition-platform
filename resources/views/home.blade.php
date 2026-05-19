@extends('layouts.public')

@section('title', 'ArtVista — Explore Virtual Exhibitions')

@section('content')
    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- HERO --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-700 to-indigo-900">
        {{-- Animated blobs --}}
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-purple-500 opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-indigo-400 opacity-20 blur-3xl animate-pulse" style="animation-delay:1.5s"></div>
        {{-- Dot grid --}}
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:28px 28px"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-36 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-widest bg-white/10 text-white/80 border border-white/20 backdrop-blur-sm mb-6">
                ✦ Virtual Art Platform
            </span>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight">
                Explore Virtual
                <span class="block bg-gradient-to-r from-amber-200 via-yellow-300 to-orange-200 bg-clip-text text-transparent">Exhibitions</span>
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-indigo-200 leading-relaxed">
                Discover curated art collections from talented creators worldwide. Showcase your gallery and inspire millions.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('exhibitions.index') }}"
                   class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-indigo-700 font-bold rounded-2xl shadow-lg hover:shadow-2xl hover:bg-amber-50 transition-all duration-300 text-base">
                    Browse Exhibitions
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-white/10 text-white font-semibold rounded-2xl border border-white/25 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 text-base">
                        Create Your Gallery
                    </a>
                @else
                    <a href="{{ route('exhibitions.create') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-white/10 text-white font-semibold rounded-2xl border border-white/25 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 text-base">
                        Create Exhibition
                    </a>
                @endguest
            </div>
        </div>
        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0 80L1440 80L1440 30C1200 70 960 10 720 30C480 50 240 10 0 30Z" fill="#f9fafb"/></svg>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- PLATFORM STATS --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="bg-gray-50 py-14">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @php
                    $statItems = [
                        ['value' => number_format($stats['exhibitions']), 'label' => 'Exhibitions',   'icon' => '🖼️',  'color' => 'from-indigo-500 to-purple-600'],
                        ['value' => number_format($stats['artworks']),    'label' => 'Artworks',       'icon' => '🎨',  'color' => 'from-pink-500 to-rose-600'],
                        ['value' => number_format($stats['creators']),    'label' => 'Creators',       'icon' => '👨‍🎨', 'color' => 'from-amber-500 to-orange-600'],
                        ['value' => number_format($stats['likes']),       'label' => 'Total Likes',    'icon' => '❤️',  'color' => 'from-emerald-500 to-teal-600'],
                    ];
                @endphp
                @foreach($statItems as $s)
                    <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-100 shadow-sm p-6 text-center group hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $s['color'] }} opacity-0 group-hover:opacity-5 transition-opacity duration-300 rounded-2xl"></div>
                        <div class="text-3xl mb-2">{{ $s['icon'] }}</div>
                        <div class="text-3xl sm:text-4xl font-extrabold text-gray-900 tabular-nums">{{ $s['value'] }}</div>
                        <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- LEADERBOARD + TRENDING --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- ── TOP CREATORS (3 cols) ── --}}
            <div class="lg:col-span-3">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-2xl">🏆</span>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Creator Leaderboard</h2>
                        <p class="text-sm text-gray-500">Ranked by total artwork likes</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($topCreators as $i => $creator)
                        @php
                            $medals = ['🥇','🥈','🥉','④','⑤'];
                            $medal  = $medals[$i] ?? ($i+1);
                            $rowBg  = $i === 0 ? 'bg-gradient-to-r from-amber-50 to-yellow-50 border-amber-200' : 'bg-white border-gray-100';
                        @endphp
                        <a href="{{ route('creator.show', $creator) }}"
                           class="flex items-center gap-4 p-4 rounded-2xl border {{ $rowBg }} shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-x-0.5 group">
                            {{-- Rank --}}
                            <div class="w-10 text-center text-xl flex-shrink-0">{{ $medal }}</div>
                            {{-- Avatar --}}
                            <div class="flex-shrink-0 w-11 h-11 rounded-full bg-indigo-600 text-white font-bold text-lg flex items-center justify-center uppercase shadow">
                                {{ substr($creator->name, 0, 1) }}
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $creator->name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $creator->exhibitions_count }} exhibitions &bull; {{ $creator->total_artworks }} artworks</div>
                            </div>
                            {{-- Likes --}}
                            <div class="flex-shrink-0 flex items-center gap-1 text-rose-500 font-bold text-sm">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                {{ $creator->total_likes }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ── TRENDING ARTWORKS (2 cols) ── --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-2xl">🔥</span>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Trending Now</h2>
                        <p class="text-sm text-gray-500">Most liked artworks</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($trendingArtworks as $artwork)
                        <a href="{{ route('exhibitions.show', $artwork->exhibition) }}"
                           class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 group">
                            {{-- Thumbnail --}}
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                <img src="{{ $artwork->image }}" alt="{{ $artwork->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $artwork->title }}</div>
                                <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $artwork->artist_name }}</div>
                                <div class="flex items-center gap-1 mt-1 text-rose-400 text-xs font-semibold">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    {{ $artwork->likes_count }} likes
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- CATEGORIES QUICK-FILTER --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-700 mb-5 text-center">Browse by Category</h2>
            <div class="flex flex-wrap justify-center gap-3">
                @php
                    $catIcons = ['General'=>'🌐','Painting'=>'🖌️','Photography'=>'📷','Sculpture'=>'🗿','Digital Art'=>'💻','Mixed Media'=>'🎭'];
                @endphp
                @foreach($catIcons as $cat => $icon)
                    <a href="{{ route('exhibitions.index', ['category' => $cat]) }}"
                       class="flex items-center gap-2 px-5 py-2.5 bg-white rounded-full border border-gray-200 shadow-sm font-medium text-gray-700 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:shadow-md transition-all duration-200 text-sm">
                        {{ $icon }} {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- LATEST EXHIBITIONS --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Latest Exhibitions</h2>
                <p class="mt-1 text-gray-500">Recently curated virtual galleries</p>
            </div>
            <a href="{{ route('exhibitions.index') }}"
               class="hidden sm:inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                View all
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>

        @if($exhibitions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exhibitions as $exhibition)
                    <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        {{-- Banner --}}
                        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 relative">
                            @if($exhibition->banner_image)
                                <img src="{{ $exhibition->bannerUrl }}" alt="{{ $exhibition->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="h-16 w-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                </div>
                            @endif
                            {{-- Category chip --}}
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-semibold text-indigo-700 shadow-sm">
                                {{ $exhibition->category ?? 'General' }}
                            </span>
                        </div>
                        {{-- Content --}}
                        <div class="p-5">
                            <div class="flex items-center text-xs text-gray-400 mb-2 gap-1.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                {{ $exhibition->exhibition_date->format('M d, Y') }}
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $exhibition->title }}
                            </h3>
                            <p class="mt-1.5 text-sm text-gray-500 line-clamp-2">{{ $exhibition->description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('creator.show', $exhibition->user) }}"
                                   class="text-xs text-gray-400 hover:text-indigo-600 transition-colors font-medium">
                                    by {{ $exhibition->user->name }}
                                </a>
                                <a href="{{ route('exhibitions.show', $exhibition) }}"
                                   class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    View
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('exhibitions.index') }}"
                   class="inline-flex items-center px-7 py-3 bg-indigo-600 text-white font-semibold rounded-2xl hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all duration-200">
                    View All Exhibitions
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-400">No exhibitions yet. Be the first to create one!</p>
                <a href="{{ route('register') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl">Get Started</a>
            </div>
        @endif
    </section>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- GLASS CTA BANNER --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-indigo-700 via-purple-700 to-indigo-800 py-16 my-10 mx-4 sm:mx-8 rounded-3xl">
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:24px 24px"></div>
        <div class="relative text-center px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-white">Ready to showcase your art?</h2>
            <p class="mt-3 text-indigo-200 text-lg">Join {{ number_format($stats['creators']) }} creators already sharing their work on ArtVista.</p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-indigo-700 font-bold rounded-2xl shadow-lg hover:shadow-2xl hover:bg-amber-50 transition-all duration-300">
                        Start for Free
                    </a>
                @else
                    <a href="{{ route('exhibitions.create') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-indigo-700 font-bold rounded-2xl shadow-lg hover:shadow-2xl hover:bg-amber-50 transition-all duration-300">
                        Create an Exhibition
                    </a>
                @endguest
            </div>
        </div>
    </section>
@endsection
