<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Exhibition') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ===== Edit Exhibition Form ===== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Exhibition Details</h3>

                    <form method="POST" action="{{ route('exhibitions.update', $exhibition) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Exhibition Title</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title', $exhibition->title) }}"
                                   required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('title')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description"
                                      id="description"
                                      rows="5"
                                      required
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description', $exhibition->description) }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Exhibition Date -->
                        <div class="mb-6">
                            <label for="exhibition_date" class="block text-sm font-medium text-gray-700 mb-2">Exhibition Date</label>
                            <input type="date"
                                   name="exhibition_date"
                                   id="exhibition_date"
                                   value="{{ old('exhibition_date', $exhibition->exhibition_date->format('Y-m-d')) }}"
                                   required
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('exhibition_date')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Banner -->
                        @if($exhibition->banner_image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Banner</label>
                                <div class="rounded-xl overflow-hidden border border-gray-200 max-w-md">
                                    <img src="{{ $exhibition->banner_url }}"
                                         alt="Current banner"
                                         class="w-full h-40 object-cover">
                                </div>
                            </div>
                        @endif

                        <!-- Banner Image Upload -->
                        <div class="mb-8">
                            <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $exhibition->banner_image ? 'Replace Banner Image' : 'Upload Banner Image' }}
                            </label>
                            <input type="file"
                                   name="banner_image"
                                   id="banner_image"
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                            @error('banner_image')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all duration-200">
                                Update Exhibition
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== Add Artwork Form ===== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Add New Artwork</h3>

                    <form method="POST" action="{{ route('artworks.store', $exhibition) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Artwork Title -->
                            <div>
                                <label for="artwork_title" class="block text-sm font-medium text-gray-700 mb-2">Artwork Title</label>
                                <input type="text"
                                       name="title"
                                       id="artwork_title"
                                       value="{{ old('title') }}"
                                       required
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                       placeholder="e.g. Starry Night">
                                @error('title')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Artist Name -->
                            <div>
                                <label for="artist_name" class="block text-sm font-medium text-gray-700 mb-2">Artist Name</label>
                                <input type="text"
                                       name="artist_name"
                                       id="artist_name"
                                       value="{{ old('artist_name') }}"
                                       required
                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                       placeholder="e.g. Vincent van Gogh">
                                @error('artist_name')
                                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Artwork Description -->
                        <div class="mt-6">
                            <label for="artwork_description" class="block text-sm font-medium text-gray-700 mb-2">Description (optional)</label>
                            <textarea name="description"
                                      id="artwork_description"
                                      rows="3"
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                      placeholder="Brief description of the artwork...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Artwork Image -->
                        <div class="mt-6">
                            <label for="artwork_image" class="block text-sm font-medium text-gray-700 mb-2">Artwork Image</label>
                            <input type="file"
                                   name="image"
                                   id="artwork_image"
                                   accept="image/*"
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                            @error('image')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="mt-6 flex items-center justify-end">
                            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-sm hover:shadow-md transition-all duration-200">
                                Add Artwork
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== Existing Artworks ===== --}}
            @if($exhibition->artworks->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">
                            Artworks ({{ $exhibition->artworks->count() }})
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($exhibition->artworks as $artwork)
                                <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                    <div class="aspect-square overflow-hidden">
                                        <img src="{{ $artwork->image_url }}"
                                             alt="{{ $artwork->title }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-medium text-gray-900 text-sm line-clamp-1">{{ $artwork->title }}</h4>
                                        <p class="text-xs text-indigo-600 mt-0.5">{{ $artwork->artist_name }}</p>

                                        <form method="POST" action="{{ route('artworks.destroy', $artwork) }}" class="mt-3"
                                              onsubmit="return confirm('Are you sure you want to delete this artwork?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-800 transition-colors">
                                                Remove Artwork
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
