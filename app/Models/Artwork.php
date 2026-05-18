<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artwork extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'artist_name',
        'description',
        'image',
        'exhibition_id',
    ];

    /**
     * Get the exhibition that owns the artwork.
     */
    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}
