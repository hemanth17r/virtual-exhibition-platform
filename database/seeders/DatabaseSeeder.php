<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exhibition;
use App\Models\Artwork;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an instructor/presenter account
        $user = User::factory()->create([
            'name' => 'Presenter Admin',
            'email' => 'admin@artvista.local',
            'password' => Hash::make('password'),
        ]);

        // Exhibition 1
        $exhibition1 = Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Echoes of the Renaissance',
            'description' => 'A modern interpretation of classical renaissance themes, blending historical motifs with contemporary techniques. This exhibition features renowned pieces from the past decade that reimagine classic art.',
            'exhibition_date' => Carbon::now()->subDays(10),
            'banner_image' => 'https://images.unsplash.com/photo-1577083165243-92f7d988470a?q=80&w=2000&auto=format&fit=crop',
        ]);

        // Artworks for Exhibition 1
        Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'Golden Era Portrait',
            'artist_name' => 'Leonardo Vargas',
            'description' => 'Oil on canvas. A striking portrait highlighting the interplay of light and shadow.',
            'image' => 'https://images.unsplash.com/photo-1579541814924-49fef17c5be5?q=80&w=1000&auto=format&fit=crop',
        ]);

        Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'Abstract Symphony',
            'artist_name' => 'Elena Rossi',
            'description' => 'Acrylic on canvas. Exploring color theory through chaotic yet harmonious strokes.',
            'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?q=80&w=1000&auto=format&fit=crop',
        ]);

        Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'The Silent Observer',
            'artist_name' => 'Marco Bianchi',
            'description' => 'Charcoal sketch representing the human condition.',
            'image' => 'https://images.unsplash.com/photo-1561214115-f2f134cc4912?q=80&w=1000&auto=format&fit=crop',
        ]);


        // Exhibition 2
        $exhibition2 = Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Digital Frontiers',
            'description' => 'Exploring the boundaries of digital art, generative landscapes, and cybernetic dreams. A showcase of what happens when technology meets creativity.',
            'exhibition_date' => Carbon::now()->addDays(5),
            'banner_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2000&auto=format&fit=crop',
        ]);

        // Artworks for Exhibition 2
        Artwork::create([
            'exhibition_id' => $exhibition2->id,
            'title' => 'Neon Nights',
            'artist_name' => 'Cyber Artist X',
            'description' => 'Digital render of a futuristic cityscape.',
            'image' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1000&auto=format&fit=crop',
        ]);
        
        Artwork::create([
            'exhibition_id' => $exhibition2->id,
            'title' => 'Generative Flow',
            'artist_name' => 'Algorithm 99',
            'description' => 'Procedurally generated art utilizing perlin noise.',
            'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=1000&auto=format&fit=crop',
        ]);


        // Exhibition 3
        Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Minimalist Perspectives',
            'description' => 'Focusing on the beauty of simplicity and space. Less is always more in this carefully curated selection of minimalist photography and sculpture.',
            'exhibition_date' => Carbon::now()->addDays(30),
            'banner_image' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?q=80&w=2000&auto=format&fit=crop',
        ]);
    }
}
