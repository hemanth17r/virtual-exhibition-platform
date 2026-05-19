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
            'bio' => 'Digital Curator and Professor of Fine Arts. Passionate about bringing traditional art forms into the digital age and exploring the intersection of technology and creativity.',
        ]);

        $visitor = User::factory()->create([
            'name' => 'Art Enthusiast',
            'email' => 'visitor@artvista.local',
            'password' => Hash::make('password'),
            'bio' => 'Avid collector and critic.',
        ]);

        // Exhibition 1
        $exhibition1 = Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Echoes of the Renaissance',
            'description' => 'A modern interpretation of classical renaissance themes, blending historical motifs with contemporary techniques. This exhibition features renowned pieces from the past decade that reimagine classic art.',
            'category' => 'Painting',
            'exhibition_date' => Carbon::now()->subDays(10),
            'banner_image' => 'https://images.unsplash.com/photo-1577083165243-92f7d988470a?q=80&w=2000&auto=format&fit=crop',
        ]);

        // Add some comments
        $exhibition1->comments()->create([
            'user_id' => $visitor->id,
            'content' => 'This collection is truly breathtaking. The modern interpretation brings a fresh perspective to classical themes.',
        ]);

        // Artworks for Exhibition 1
        $art1 = Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'Golden Era Portrait',
            'artist_name' => 'Leonardo Vargas',
            'description' => 'Oil on canvas. A striking portrait highlighting the interplay of light and shadow.',
            'image' => 'https://images.unsplash.com/photo-1579541814924-49fef17c5be5?q=80&w=1000&auto=format&fit=crop',
        ]);
        $art1->likes()->create(['user_id' => $visitor->id]);

        $art2 = Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'Abstract Symphony',
            'artist_name' => 'Elena Rossi',
            'description' => 'Acrylic on canvas. Exploring color theory through chaotic yet harmonious strokes.',
            'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?q=80&w=1000&auto=format&fit=crop',
        ]);

        $art3 = Artwork::create([
            'exhibition_id' => $exhibition1->id,
            'title' => 'The Silent Observer',
            'artist_name' => 'Marco Bianchi',
            'description' => 'Charcoal sketch representing the human condition.',
            'image' => 'https://images.unsplash.com/photo-1561214115-f2f134cc4912?q=80&w=1000&auto=format&fit=crop',
        ]);
        $art3->likes()->create(['user_id' => $user->id]);
        $art3->likes()->create(['user_id' => $visitor->id]);


        // Exhibition 2
        $exhibition2 = Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Digital Frontiers',
            'description' => 'Exploring the boundaries of digital art, generative landscapes, and cybernetic dreams. A showcase of what happens when technology meets creativity.',
            'category' => 'Digital Art',
            'exhibition_date' => Carbon::now()->addDays(5),
            'banner_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2000&auto=format&fit=crop',
        ]);

        $exhibition2->comments()->create([
            'user_id' => $user->id,
            'content' => 'I can\'t wait to showcase these digital pieces! The generative algorithms used here are cutting-edge.',
        ]);

        // Artworks for Exhibition 2
        $art4 = Artwork::create([
            'exhibition_id' => $exhibition2->id,
            'title' => 'Neon Nights',
            'artist_name' => 'Cyber Artist X',
            'description' => 'Digital render of a futuristic cityscape.',
            'image' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1000&auto=format&fit=crop',
        ]);
        
        $art5 = Artwork::create([
            'exhibition_id' => $exhibition2->id,
            'title' => 'Generative Flow',
            'artist_name' => 'Algorithm 99',
            'description' => 'Procedurally generated art utilizing perlin noise.',
            'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=1000&auto=format&fit=crop',
        ]);
        $art5->likes()->create(['user_id' => $visitor->id]);


        // Exhibition 3
        Exhibition::create([
            'user_id' => $user->id,
            'title' => 'Minimalist Perspectives',
            'description' => 'Focusing on the beauty of simplicity and space. Less is always more in this carefully curated selection of minimalist photography and sculpture.',
            'category' => 'Photography',
            'exhibition_date' => Carbon::now()->addDays(30),
            'banner_image' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?q=80&w=2000&auto=format&fit=crop',
        ]);
    }
}
