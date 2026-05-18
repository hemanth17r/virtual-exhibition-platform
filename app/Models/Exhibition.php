<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

class Exhibition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'exhibition_date',
        'banner_image',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'exhibition_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the exhibition.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artworks for the exhibition.
     */
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }

    /**
     * Get the resolved URL for the banner image.
     */
    public function getBannerUrlAttribute(): ?string
    {
        if (!$this->banner_image) {
            return null;
        }

        if (Str::startsWith($this->banner_image, ['http://', 'https://'])) {
            return $this->banner_image;
        }

        return asset('storage/' . $this->banner_image);
    }
}
