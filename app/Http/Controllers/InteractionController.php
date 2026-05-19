<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function toggleLike(Artwork $artwork)
    {
        $user = auth()->user();

        if ($artwork->likes()->where('user_id', $user->id)->exists()) {
            $artwork->likes()->where('user_id', $user->id)->delete();
        } else {
            $artwork->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }

    public function storeComment(Request $request, Exhibition $exhibition)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $exhibition->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment posted successfully!');
    }
}
