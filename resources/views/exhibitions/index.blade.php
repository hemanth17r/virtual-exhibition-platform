@extends('layouts.public')

@section('title', 'All Exhibitions — ArtVista')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900">All Exhibitions</h1>
            <p class="mt-2 text-gray-500 text-lg">Browse through our collection of virtual exhibitions</p>
        </div>

        <!-- Search and Filters -->
        <div class="mb-10 flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <!-- Categories -->
            <div class="flex flex-wrap gap-2">
                @php
                    $categories = ['General', 'Painting', 'Photography', 'Sculpture', 'Digital Art', 'Mixed Media'];
                    $currentCategory = request('category');
                @endphp
                <a href="{{ route('exhibitions.index', ['search' => request('search')]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !$currentCategory ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('exhibitions.index', ['category' => $cat, 'search' => request('search')]) }}"
                       class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $currentCategory === $cat ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Search -->
            <form action="{{ route('exhibitions.index') }}" method="GET" class="w-full md:w-auto relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search exhibitions..."
                           class="w-full md:w-72 pl-10 pr-4 py-2 rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>

        @if($exhibitions->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($exhibitions as $exhibition)
                    <article class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <!-- Banner Image -->
                        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100">
                            @if($exhibition->banner_image)
                                <img src="{{ $exhibition->banner_url }}"
                                     alt="{{ $exhibition->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="h-16 w-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                    </svg>
                                </div>
                            @endif
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
                                <a href="{{ route('creator.show', $exhibition->user) }}" class="text-xs text-gray-500 hover:text-indigo-600 transition-colors">
                                    by <span class="font-medium">{{ $exhibition->user->name }}</span>
                                </a>
                                <a href="{{ route('exhibitions.show', $exhibition) }}"
                                   class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                                    View Exhibition
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $exhibitions->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No exhibitions found</h3>
                <p class="mt-2 text-gray-500">Check back later for new exhibitions.</p>
            </div>
        @endif
    </section>
@endsection
