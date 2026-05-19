@extends('layouts.public')

@section('title', 'All Exhibitions — ArtVista')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">All Exhibitions</h1>
            <p class="mt-1.5 text-gray-500 text-lg">Browse through our collection of virtual exhibitions</p>
        </div>

        {{-- Search & Filters bar --}}
        <div class="mb-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            {{-- Search form (submit on change) --}}
            <form action="{{ route('exhibitions.index') }}" method="GET" id="search-form">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                {{-- Search input row --}}
                <div class="relative mb-4">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by title, description or creator name…"
                           class="w-full pl-10 pr-32 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-gray-50 outline-none transition">
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Search
                    </button>
                </div>

                {{-- Category pills --}}
                @php
                    $categories = ['General', 'Painting', 'Photography', 'Sculpture', 'Digital Art', 'Mixed Media'];
                    $currentCategory = request('category');
                @endphp
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-xs font-medium text-gray-400 mr-1 uppercase tracking-wide">Filter:</span>
                    <a href="{{ route('exhibitions.index', array_filter(['search' => request('search')])) }}"
                       class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-150 {{ !$currentCategory ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('exhibitions.index', array_filter(['category' => $cat, 'search' => request('search')])) }}"
                           class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-150 {{ $currentCategory === $cat ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </form>

            {{-- Active search indicator --}}
            @if(request('search') || request('category'))
                <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                    <span>Showing results for:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-medium text-xs">
                            "{{ request('search') }}"
                            <a href="{{ route('exhibitions.index', array_filter(['category' => request('category')])) }}" class="ml-1 hover:text-indigo-900">✕</a>
                        </span>
                    @endif
                    @if(request('category'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 font-medium text-xs">
                            {{ request('category') }}
                            <a href="{{ route('exhibitions.index', array_filter(['search' => request('search')])) }}" class="ml-1 hover:text-purple-900">✕</a>
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Results --}}
        @if($exhibitions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exhibitions as $exhibition)
                    <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                        {{-- Banner with category chip inside --}}
                        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 relative">
                            @if($exhibition->banner_image)
                                <img src="{{ $exhibition->bannerUrl }}"
                                     alt="{{ $exhibition->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="h-16 w-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                                    </svg>
                                </div>
                            @endif
                            {{-- Category chip overlaid on image (not below) --}}
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-semibold text-indigo-700 shadow-sm">
                                {{ $exhibition->category ?? 'General' }}
                            </span>
                        </div>

                        {{-- Card Content — NO relative badge, no overlap --}}
                        <div class="p-5">
                            {{-- Date row --}}
                            <div class="flex items-center text-xs text-gray-400 mb-2 gap-1.5">
                                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                                {{ $exhibition->exhibition_date->format('M d, Y') }}
                            </div>

                            <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-1">
                                {{ $exhibition->title }}
                            </h3>
                            <p class="mt-1.5 text-sm text-gray-500 line-clamp-2">{{ $exhibition->description }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('creator.show', $exhibition->user) }}"
                                   class="text-xs text-gray-400 hover:text-indigo-600 transition-colors font-medium">
                                    by <span class="font-semibold">{{ $exhibition->user->name }}</span>
                                </a>
                                <a href="{{ route('exhibitions.show', $exhibition) }}"
                                   class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                    View
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $exhibitions->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No exhibitions found</h3>
                <p class="mt-2 text-gray-500">Try a different search term or category.</p>
                <a href="{{ route('exhibitions.index') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    Clear filters →
                </a>
            </div>
        @endif
    </section>
@endsection
