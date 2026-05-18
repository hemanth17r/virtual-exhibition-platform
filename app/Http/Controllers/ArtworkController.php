<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Exhibition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Store a newly created artwork for an exhibition.
     */
    public function store(Request $request, Exhibition $exhibition): RedirectResponse
    {
        if ($exhibition->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $validated['image'] = $request->file('image')->store('artworks', 'public');
        $validated['exhibition_id'] = $exhibition->id;

        Artwork::create($validated);

        return redirect()
            ->route('exhibitions.edit', $exhibition)
            ->with('success', 'Artwork added successfully.');
    }

    /**
     * Remove the specified artwork from storage.
     */
    public function destroy(Artwork $artwork): RedirectResponse
    {
        $exhibition = $artwork->exhibition;

        if ($exhibition->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the artwork image file
        if ($artwork->image) {
            Storage::disk('public')->delete($artwork->image);
        }

        $artwork->delete();

        return redirect()
            ->route('exhibitions.edit', $exhibition)
            ->with('success', 'Artwork removed successfully.');
    }
}
