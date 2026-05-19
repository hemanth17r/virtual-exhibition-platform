<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ExhibitionController::class, 'home'])->name('home');
Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.index');
Route::get('/exhibitions/{exhibition}', [App\Http\Controllers\ExhibitionController::class, 'show'])->name('exhibitions.show');

Route::get('/creator/{creator}', [App\Http\Controllers\CreatorController::class, 'show'])->name('creator.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/artworks/{artwork}/like', [App\Http\Controllers\InteractionController::class, 'toggleLike'])->name('artworks.like');
    Route::post('/exhibitions/{exhibition}/comment', [App\Http\Controllers\InteractionController::class, 'storeComment'])->name('exhibitions.comment');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ExhibitionController::class, 'dashboard'])->name('dashboard');

    // Exhibition CRUD
    Route::get('/exhibitions-create', [ExhibitionController::class, 'create'])->name('exhibitions.create');
    Route::post('/exhibitions', [ExhibitionController::class, 'store'])->name('exhibitions.store');
    Route::get('/exhibitions/{exhibition}/edit', [ExhibitionController::class, 'edit'])->name('exhibitions.edit');
    Route::put('/exhibitions/{exhibition}', [ExhibitionController::class, 'update'])->name('exhibitions.update');
    Route::delete('/exhibitions/{exhibition}', [ExhibitionController::class, 'destroy'])->name('exhibitions.destroy');

    // Artwork management
    Route::post('/exhibitions/{exhibition}/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::delete('/artworks/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
