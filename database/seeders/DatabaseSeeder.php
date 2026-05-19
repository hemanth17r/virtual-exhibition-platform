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
    public function run(): void
    {
        // ── Users ────────────────────────────────────────────────────────
        $admin = User::factory()->create([
            'name'     => 'Presenter Admin',
            'email'    => 'admin@artvista.local',
            'password' => Hash::make('password'),
            'bio'      => 'Digital Curator and Professor of Fine Arts. Passionate about bringing traditional art forms into the digital age and exploring the intersection of technology and creativity.',
        ]);

        $visitor = User::factory()->create([
            'name'     => 'Art Enthusiast',
            'email'    => 'visitor@artvista.local',
            'password' => Hash::make('password'),
            'bio'      => 'Avid collector and art critic. Travels the world seeking undiscovered talent and emerging art movements.',
        ]);

        $sofia = User::factory()->create([
            'name'     => 'Sofia Nakamura',
            'email'    => 'sofia@artvista.local',
            'password' => Hash::make('password'),
            'bio'      => 'Independent photographer and sculptor based in Tokyo. My work explores the tension between organic forms and urban environments.',
        ]);

        // ── Exhibition 1 — Painting ──────────────────────────────────────
        $ex1 = Exhibition::create([
            'user_id'         => $admin->id,
            'title'           => 'Echoes of the Renaissance',
            'description'     => 'A modern interpretation of classical renaissance themes, blending historical motifs with contemporary techniques. This exhibition features renowned pieces from the past decade that reimagine classic art.',
            'category'        => 'Painting',
            'exhibition_date' => Carbon::now()->subDays(10),
            'banner_image'    => 'https://images.unsplash.com/photo-1577083165243-92f7d988470a?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex1->comments()->create(['user_id' => $visitor->id, 'content' => 'This collection is truly breathtaking. The modern interpretation brings a fresh perspective to classical themes.']);
        $ex1->comments()->create(['user_id' => $sofia->id,   'content' => 'The use of chiaroscuro here is masterful — reminds me of Caravaggio\'s intensity.']);
        $a1 = Artwork::create(['exhibition_id' => $ex1->id, 'title' => 'Golden Era Portrait',   'artist_name' => 'Leonardo Vargas', 'description' => 'Oil on canvas. A striking portrait highlighting the interplay of light and shadow.',       'image' => 'https://images.unsplash.com/photo-1579541814924-49fef17c5be5?q=80&w=1000&auto=format&fit=crop']);
        $a1->likes()->create(['user_id' => $visitor->id]);
        $a1->likes()->create(['user_id' => $sofia->id]);
        $a2 = Artwork::create(['exhibition_id' => $ex1->id, 'title' => 'Abstract Symphony',     'artist_name' => 'Elena Rossi',     'description' => 'Acrylic on canvas. Exploring color theory through chaotic yet harmonious strokes.',    'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?q=80&w=1000&auto=format&fit=crop']);
        $a3 = Artwork::create(['exhibition_id' => $ex1->id, 'title' => 'The Silent Observer',   'artist_name' => 'Marco Bianchi',   'description' => 'Charcoal sketch representing the human condition.',                                   'image' => 'https://images.unsplash.com/photo-1561214115-f2f134cc4912?q=80&w=1000&auto=format&fit=crop']);
        $a3->likes()->create(['user_id' => $admin->id]);
        $a3->likes()->create(['user_id' => $visitor->id]);

        // ── Exhibition 2 — Digital Art ───────────────────────────────────
        $ex2 = Exhibition::create([
            'user_id'         => $admin->id,
            'title'           => 'Digital Frontiers',
            'description'     => 'Exploring the boundaries of digital art, generative landscapes, and cybernetic dreams. A showcase of what happens when technology meets creativity.',
            'category'        => 'Digital Art',
            'exhibition_date' => Carbon::now()->addDays(5),
            'banner_image'    => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex2->comments()->create(['user_id' => $admin->id, 'content' => 'I can\'t wait to showcase these digital pieces! The generative algorithms used here are cutting-edge.']);
        $a4 = Artwork::create(['exhibition_id' => $ex2->id, 'title' => 'Neon Nights',      'artist_name' => 'Cyber Artist X', 'description' => 'Digital render of a futuristic cityscape.',             'image' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1000&auto=format&fit=crop']);
        $a5 = Artwork::create(['exhibition_id' => $ex2->id, 'title' => 'Generative Flow',  'artist_name' => 'Algorithm 99',   'description' => 'Procedurally generated art utilizing perlin noise.', 'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=1000&auto=format&fit=crop']);
        $a5->likes()->create(['user_id' => $visitor->id]);

        // ── Exhibition 3 — Photography ───────────────────────────────────
        $ex3 = Exhibition::create([
            'user_id'         => $admin->id,
            'title'           => 'Minimalist Perspectives',
            'description'     => 'Focusing on the beauty of simplicity and space. Less is always more in this carefully curated selection of minimalist photography and sculpture.',
            'category'        => 'Photography',
            'exhibition_date' => Carbon::now()->addDays(30),
            'banner_image'    => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex3->comments()->create(['user_id' => $visitor->id, 'content' => 'The negative space in these photographs speaks volumes. Less truly is more.']);
        $a6 = Artwork::create(['exhibition_id' => $ex3->id, 'title' => 'White on White',   'artist_name' => 'Hana Park',     'description' => 'A study of texture and light using a purely monochromatic palette.',               'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=1000&auto=format&fit=crop']);
        $a6->likes()->create(['user_id' => $sofia->id]);
        $a7 = Artwork::create(['exhibition_id' => $ex3->id, 'title' => 'Breath of Space',  'artist_name' => 'James Whitmore','description' => 'Long-exposure shot capturing the serenity of an empty field at dawn.',           'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=1000&auto=format&fit=crop']);

        // ── Exhibition 4 — General ───────────────────────────────────────
        $ex4 = Exhibition::create([
            'user_id'         => $sofia->id,
            'title'           => 'Voices from the Margin',
            'description'     => 'A powerful collection spotlighting emerging artists from underrepresented communities around the globe. Each piece is a window into a world often unseen.',
            'category'        => 'General',
            'exhibition_date' => Carbon::now()->subDays(3),
            'banner_image'    => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex4->comments()->create(['user_id' => $admin->id,   'content' => 'An essential exhibition. The diversity of voices here is both moving and necessary.']);
        $ex4->comments()->create(['user_id' => $visitor->id, 'content' => 'Deeply inspiring. I discovered three new artists I\'m now following closely.']);
        $a8 = Artwork::create(['exhibition_id' => $ex4->id, 'title' => 'Roots & Routes',       'artist_name' => 'Amara Diallo', 'description' => 'Mixed media collage exploring African diaspora identity.',                               'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?q=80&w=1000&auto=format&fit=crop']);
        $a8->likes()->create(['user_id' => $admin->id]);
        $a8->likes()->create(['user_id' => $visitor->id]);
        $a8->likes()->create(['user_id' => $sofia->id]);
        $a9 = Artwork::create(['exhibition_id' => $ex4->id, 'title' => 'Urban Prayer',         'artist_name' => 'Priya Mehta',  'description' => 'Street photography series documenting spiritual rituals in Indian megacities.',      'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?q=80&w=1000&auto=format&fit=crop']);
        $a9->likes()->create(['user_id' => $visitor->id]);
        Artwork::create(['exhibition_id' => $ex4->id, 'title' => 'The Weight of Words', 'artist_name' => 'Carlos Reyes', 'description' => 'Typography-based installation commenting on immigration and belonging.',               'image' => 'https://images.unsplash.com/photo-1555685812-4b8f286b17c2?q=80&w=1000&auto=format&fit=crop']);

        // ── Exhibition 5 — Sculpture ─────────────────────────────────────
        $ex5 = Exhibition::create([
            'user_id'         => $sofia->id,
            'title'           => 'Form in Motion',
            'description'     => 'An exploration of kinetic and static sculpture, from polished marble to reclaimed industrial metal. These works challenge our notion of stillness and movement in three dimensions.',
            'category'        => 'Sculpture',
            'exhibition_date' => Carbon::now()->addDays(14),
            'banner_image'    => 'https://images.unsplash.com/photo-1503661931156-98fe97ec56e4?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex5->comments()->create(['user_id' => $visitor->id, 'content' => 'The kinetic piece in the centre literally moved me — both physically and emotionally.']);
        $a11 = Artwork::create(['exhibition_id' => $ex5->id, 'title' => 'Torso in Marble', 'artist_name' => 'Giulia Ferretti',  'description' => 'Hand-carved Carrara marble. A contemporary take on the classical torso.',   'image' => 'https://images.unsplash.com/photo-1571115764595-644a1f56a55c?q=80&w=1000&auto=format&fit=crop']);
        $a11->likes()->create(['user_id' => $admin->id]);
        $a12 = Artwork::create(['exhibition_id' => $ex5->id, 'title' => 'Iron Bloom',      'artist_name' => 'Kenji Watanabe',   'description' => 'Welded steel sculpture mimicking the unfurling of a flower.',            'image' => 'https://images.unsplash.com/photo-1549887534-1541e9326578?q=80&w=1000&auto=format&fit=crop']);
        $a12->likes()->create(['user_id' => $visitor->id]);
        $a12->likes()->create(['user_id' => $sofia->id]);

        // ── Exhibition 6 — Mixed Media ───────────────────────────────────
        $ex6 = Exhibition::create([
            'user_id'         => $visitor->id,
            'title'           => 'Collisions',
            'description'     => 'Where paint meets pixel, and paper meets projected light. Collisions is a boundary-breaking mixed media showcase that refuses to be categorised.',
            'category'        => 'Mixed Media',
            'exhibition_date' => Carbon::now()->subDays(5),
            'banner_image'    => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex6->comments()->create(['user_id' => $admin->id, 'content' => 'The projection-mapped canvases completely redefined my understanding of what a painting can be.']);
        $a13 = Artwork::create(['exhibition_id' => $ex6->id, 'title' => 'Pixel & Pigment', 'artist_name' => 'Nadia Okafor', 'description' => 'Oil painting overlaid with real-time projected data visualizations.',         'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?q=80&w=1000&auto=format&fit=crop']);
        $a13->likes()->create(['user_id' => $admin->id]);
        $a13->likes()->create(['user_id' => $sofia->id]);
        Artwork::create(['exhibition_id' => $ex6->id, 'title' => 'Torn Reality',     'artist_name' => 'Ben Hartley',   'description' => 'Collage of magazine clippings, resin, and embedded LEDs.',                     'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?q=80&w=1000&auto=format&fit=crop']);

        // ── Exhibition 7 — Photography ───────────────────────────────────
        $ex7 = Exhibition::create([
            'user_id'         => $sofia->id,
            'title'           => 'Street Pulse',
            'description'     => 'Raw, unfiltered documentary photography from the world\'s busiest streets. This exhibition captures the heartbeat of urban humanity in its most candid form.',
            'category'        => 'Photography',
            'exhibition_date' => Carbon::now()->subDays(20),
            'banner_image'    => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex7->comments()->create(['user_id' => $visitor->id, 'content' => 'Every frame tells a complete story. The Tokyo night market series is unforgettable.']);
        $a15 = Artwork::create(['exhibition_id' => $ex7->id, 'title' => 'Tokyo Rush',         'artist_name' => 'Sofia Nakamura', 'description' => 'Long exposure street photography during rush hour in Shinjuku.',              'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?q=80&w=1000&auto=format&fit=crop']);
        $a15->likes()->create(['user_id' => $admin->id]);
        $a15->likes()->create(['user_id' => $visitor->id]);
        $a16 = Artwork::create(['exhibition_id' => $ex7->id, 'title' => 'Mumbai Morning',     'artist_name' => 'Rajan Patel',    'description' => 'Documentary shot of the Dabbawala network at sunrise.',                    'image' => 'https://images.unsplash.com/photo-1529253355930-ddbe423a2ac7?q=80&w=1000&auto=format&fit=crop']);
        $a16->likes()->create(['user_id' => $sofia->id]);
        Artwork::create(['exhibition_id' => $ex7->id, 'title' => 'New York Silhouettes', 'artist_name' => 'Maria Chen',     'description' => 'Black-and-white portrait of commuters against Manhattan glass towers.',      'image' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?q=80&w=1000&auto=format&fit=crop']);

        // ── Exhibition 8 — Painting ──────────────────────────────────────
        $ex8 = Exhibition::create([
            'user_id'         => $visitor->id,
            'title'           => 'Watercolor Worlds',
            'description'     => 'Delicate, luminous, and alive with colour — this exhibition celebrates the timeless medium of watercolour painting in all its translucent glory.',
            'category'        => 'Painting',
            'exhibition_date' => Carbon::now()->addDays(7),
            'banner_image'    => 'https://images.unsplash.com/photo-1501472312651-726afe119ff1?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex8->comments()->create(['user_id' => $sofia->id, 'content' => 'The layering technique on the landscape pieces is exceptional — you can feel the depth of each wash.']);
        $a18 = Artwork::create(['exhibition_id' => $ex8->id, 'title' => 'Monsoon in Blue', 'artist_name' => 'Lina Torres',   'description' => 'Watercolour depicting the onset of monsoon rains over terracotta rooftops.', 'image' => 'https://images.unsplash.com/photo-1501472312651-726afe119ff1?q=80&w=1000&auto=format&fit=crop']);
        $a18->likes()->create(['user_id' => $admin->id]);
        $a18->likes()->create(['user_id' => $visitor->id]);
        Artwork::create(['exhibition_id' => $ex8->id, 'title' => 'Forest at Dusk',   'artist_name' => 'Thomas Webb',   'description' => 'Layered washes of green and amber capturing a forest at twilight.',            'image' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1000&auto=format&fit=crop']);

        // ── Exhibition 9 — Sculpture ─────────────────────────────────────
        $ex9 = Exhibition::create([
            'user_id'         => $admin->id,
            'title'           => 'Earth & Fire',
            'description'     => 'A celebration of ceramics and pottery as fine art. From ancient kiln techniques to contemporary glazing, this exhibition shows the boundless potential of clay.',
            'category'        => 'Sculpture',
            'exhibition_date' => Carbon::now()->subDays(15),
            'banner_image'    => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex9->comments()->create(['user_id' => $visitor->id, 'content' => 'I never imagined ceramics could be this emotionally compelling. The cracked glaze series is stunning.']);
        $ex9->comments()->create(['user_id' => $sofia->id,   'content' => 'The wabi-sabi philosophy is beautifully expressed throughout. Imperfection has never looked so intentional.']);
        $a20 = Artwork::create(['exhibition_id' => $ex9->id, 'title' => 'Wabi-Sabi Bowl',   'artist_name' => 'Yuki Tanaka',  'description' => 'Hand-thrown stoneware with intentional crackling glaze inspired by Japanese aesthetics.', 'image' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?q=80&w=1000&auto=format&fit=crop']);
        $a20->likes()->create(['user_id' => $visitor->id]);
        $a20->likes()->create(['user_id' => $sofia->id]);
        $a21 = Artwork::create(['exhibition_id' => $ex9->id, 'title' => 'Vessel Series III', 'artist_name' => 'Alma Fischer', 'description' => 'Tall, smoke-fired vessel with copper oxide highlights.',                                   'image' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?q=80&w=1000&auto=format&fit=crop']);
        $a21->likes()->create(['user_id' => $admin->id]);

        // ── Exhibition 10 — Digital Art ──────────────────────────────────
        $ex10 = Exhibition::create([
            'user_id'         => $visitor->id,
            'title'           => 'AI Dreams',
            'description'     => 'An exhibition questioning authorship and creativity in the age of machine intelligence. All works were created collaboratively between human artists and AI image models.',
            'category'        => 'Digital Art',
            'exhibition_date' => Carbon::now()->addDays(21),
            'banner_image'    => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex10->comments()->create(['user_id' => $admin->id, 'content' => 'Raises profound questions about the nature of art and authorship. Highly recommended.']);
        $ex10->comments()->create(['user_id' => $sofia->id, 'content' => 'The human-AI dialogue is evident in every piece. Neither could have made these alone.']);
        $a22 = Artwork::create(['exhibition_id' => $ex10->id, 'title' => 'Latent Space Garden', 'artist_name' => 'Aria & GPT-4o',      'description' => 'A lush dreamscape grown from text prompts and artistic direction.',                   'image' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=1000&auto=format&fit=crop']);
        $a22->likes()->create(['user_id' => $admin->id]);
        $a22->likes()->create(['user_id' => $visitor->id]);
        $a22->likes()->create(['user_id' => $sofia->id]);
        $a23 = Artwork::create(['exhibition_id' => $ex10->id, 'title' => 'The Uncanny Valley', 'artist_name' => 'Mark & Diffusion',    'description' => 'AI-generated portraits sitting just at the edge of the uncanny valley.',          'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1000&auto=format&fit=crop']);
        $a23->likes()->create(['user_id' => $visitor->id]);

        // ── Exhibition 11 — Mixed Media ──────────────────────────────────
        $ex11 = Exhibition::create([
            'user_id'         => $sofia->id,
            'title'           => 'Nature Reclaimed',
            'description'     => 'Artworks that use natural materials — driftwood, pressed flowers, stone, and earth — combined with modern techniques to explore our relationship with the natural world.',
            'category'        => 'Mixed Media',
            'exhibition_date' => Carbon::now()->addDays(45),
            'banner_image'    => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex11->comments()->create(['user_id' => $admin->id, 'content' => 'The driftwood installations are magnificent — you can almost smell the ocean.']);
        $a24 = Artwork::create(['exhibition_id' => $ex11->id, 'title' => 'Tide Line',      'artist_name' => 'Freya Jensen', 'description' => 'Driftwood, sea glass and resin panel collected from 12 different beaches.',          'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1000&auto=format&fit=crop']);
        $a24->likes()->create(['user_id' => $visitor->id]);
        $a25 = Artwork::create(['exhibition_id' => $ex11->id, 'title' => 'Pressed Memory', 'artist_name' => 'Cora Bell',    'description' => 'Botanical prints and pressed wildflowers set in hand-poured beeswax panels.',       'image' => 'https://images.unsplash.com/photo-1508193638397-1c4234db14d8?q=80&w=1000&auto=format&fit=crop']);
        $a25->likes()->create(['user_id' => $admin->id]);
        $a25->likes()->create(['user_id' => $sofia->id]);

        // ── Exhibition 12 — General ──────────────────────────────────────
        $ex12 = Exhibition::create([
            'user_id'         => $admin->id,
            'title'           => 'The Human Form',
            'description'     => 'A cross-disciplinary survey of how artists across centuries and media have depicted the human body — from anatomical studies to abstract interpretations.',
            'category'        => 'General',
            'exhibition_date' => Carbon::now()->subDays(25),
            'banner_image'    => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=2000&auto=format&fit=crop',
        ]);
        $ex12->comments()->create(['user_id' => $sofia->id, 'content' => 'A comprehensive and thoughtfully organised survey. The contrast between classical and modern depictions is striking.']);
        $a26 = Artwork::create(['exhibition_id' => $ex12->id, 'title' => 'Study in Red',       'artist_name' => 'Henri Blanc', 'description' => 'Gestural figure drawing in red chalk exploring musculature and motion.',               'image' => 'https://images.unsplash.com/photo-1474552226712-ac0f0961a954?q=80&w=1000&auto=format&fit=crop']);
        $a26->likes()->create(['user_id' => $visitor->id]);
        $a26->likes()->create(['user_id' => $sofia->id]);
        $a27 = Artwork::create(['exhibition_id' => $ex12->id, 'title' => 'Silhouette I',       'artist_name' => 'Jade Osei',   'description' => 'Photographic series using dramatic backlighting to isolate the body\'s silhouette.', 'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?q=80&w=1000&auto=format&fit=crop']);
        $a27->likes()->create(['user_id' => $admin->id]);
        Artwork::create(['exhibition_id' => $ex12->id, 'title' => 'Anatomy in Motion', 'artist_name' => 'Yusuf Amir',  'description' => 'Digital 3D rendering of the body mid-movement, inspired by Muybridge.',               'image' => 'https://images.unsplash.com/photo-1574169208507-84376144848b?q=80&w=1000&auto=format&fit=crop']);
    }
}
