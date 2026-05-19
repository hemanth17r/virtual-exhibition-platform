<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExhibitionController extends Controller
{
    /**
     * Display the public home page with latest exhibitions.
     */
    public function home(): View
    {
        $exhibitions = Exhibition::with('user')
            ->latest('exhibition_date')
            ->take(12)
            ->get();

        return view('home', compact('exhibitions'));
    }

    /**
     * Display all exhibitions (public listing).
     */
    public function index(Request $request): View
    {
        $query = Exhibition::with('user')->latest('exhibition_date');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $exhibitions = $query->paginate(12)->withQueryString();

        return view('exhibitions.index', compact('exhibitions'));
    }

    /**
     * Display a single exhibition with its artworks (public).
     */
    public function show(Exhibition $exhibition): View
    {
        $exhibition->load(['artworks', 'user']);

        return view('exhibitions.show', compact('exhibition'));
    }

    /**
     * Display the authenticated user's dashboard with their exhibitions.
     */
    public function dashboard(): View
    {
        $exhibitions = Auth::user()
            ->exhibitions()
            ->withCount('artworks')
            ->latest()
            ->get();

        return view('dashboard', compact('exhibitions'));
    }

    /**
     * Show the form for creating a new exhibition.
     */
    public function create(): View
    {
        return view('exhibitions.create');
    }

    /**
     * Store a newly created exhibition in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => 'required|string|max:50',
            'exhibition_date' => 'required|date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('exhibitions', 'public');
        }

        $validated['user_id'] = Auth::id();

        Exhibition::create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Exhibition created successfully.');
    }

    /**
     * Show the form for editing an exhibition.
     */
    public function edit(Exhibition $exhibition): View|RedirectResponse
    {
        if ($exhibition->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $exhibition->load('artworks');

        return view('exhibitions.edit', compact('exhibition'));
    }

    /**
     * Update the specified exhibition in storage.
     */
    public function update(Request $request, Exhibition $exhibition): RedirectResponse
    {
        if ($exhibition->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => 'required|string|max:50',
            'exhibition_date' => 'required|date',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            // Delete old banner image if it exists
            if ($exhibition->banner_image) {
                Storage::disk('public')->delete($exhibition->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('exhibitions', 'public');
        }

        $exhibition->update($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Exhibition updated successfully.');
    }

    /**
     * Remove the specified exhibition from storage.
     */
    public function destroy(Exhibition $exhibition): RedirectResponse
    {
        if ($exhibition->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete banner image
        if ($exhibition->banner_image) {
            Storage::disk('public')->delete($exhibition->banner_image);
        }

        // Delete all artwork images
        foreach ($exhibition->artworks as $artwork) {
            if ($artwork->image) {
                Storage::disk('public')->delete($artwork->image);
            }
        }

        $exhibition->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Exhibition deleted successfully.');
    }
}
