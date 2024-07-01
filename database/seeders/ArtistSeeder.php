<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $artists = [
            [
                "name" => "Röya Ayxan",
                "slug" => "roya-ayxan",
                "cover" => "http://localhost:8000/uploads/artists/roya-ayxan.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Faiq Ağayev",
                "slug" => "faiq-aghayev",
                "cover" => "http://localhost:8000/uploads/artists/faiq-agayev.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Miri Yusif",
                "slug" => "miri-yusif",
                "cover" => "http://localhost:8000/uploads/artists/miri-yusif.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Paster",
                "slug" => "paster",
                "cover" => "http://localhost:8000/uploads/artists/paster.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Miro",
                "slug" => "miro",
                "cover" => "http://localhost:8000/uploads/artists/miro.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Nahide Babaşlı",
                "slug" => "nahide-babashli",
                "cover" => "http://localhost:8000/uploads/artists/nahide-babashli.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Ayaz Babayev",
                "slug" => "ayaz-babayev",
                "cover" => "http://localhost:8000/uploads/artists/ayaz-babayev.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Fahree",
                "slug" => "fahree",
                "cover" => "http://localhost:8000/uploads/artists/fahree.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Semincenk",
                "slug" => "semincenk",
                "cover" => "http://localhost:8000/uploads/artists/semincenk.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Sezen Aksu",
                "slug" => "sezen-aksu",
                "cover" => "http://localhost:8000/uploads/artists/sezen-aksu.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Hadise",
                "slug" => "hadise",
                "cover" => "http://localhost:8000/uploads/artists/hadise.jpg",
                "created_at" => now()
            ],
            [
                "name" => "Hande Yener",
                "slug" => "hande-yener",
                "cover" => "http://localhost:8000/uploads/artists/hande-yener.jpg",
                "created_at" => now()
            ]
        ];

        Artist::query()->insert($artists);
    }
}
