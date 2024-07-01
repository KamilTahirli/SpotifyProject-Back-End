<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "name" => "Azəri",
                "slug" => "azerbaijan",
                "image" => asset('uploads/categories/azerbaijan.webp'),
                "search_query" => "azeri music 2024",
                "color" => "#017A66"
            ],
            [
                "name" => "Türk",
                "slug" => "turkish",
                "image" => asset('uploads/categories/turkish.webp'),
                "search_query" => "turkish music 2024",
                "color" => "#8F1ACD"
            ],
            [
                "name" => "Rus",
                "slug" => "russian",
                "image" => asset('uploads/categories/russian.webp'),
                "search_query" => "russian music 2024",
                "color" => "#E91E63"
            ],
            [
                "name" => "Pop",
                "slug" => "pop",
                "image" => asset('uploads/categories/pop.webp'),
                "search_query" => "pop music",
                "color" => "#4CAF50"
            ],
            [
                "name" => "Rok",
                "slug" => "rock",
                "image" => asset('uploads/categories/rock.webp'),
                "search_query" => "rock music",
                "color" => "#3F51B5"
            ],
            [
                "name" => "Hip-hop",
                "slug" => "hip-hop",
                "image" => asset('uploads/categories/hip-hop.webp'),
                "search_query" => "hip-hop music",
                "color" => "#6A1B9A"
            ],
            [
                "name" => "Caz",
                "slug" => "jazz",
                "image" => asset('uploads/categories/jazz.webp'),
                "search_query" => "jazz music",
                "color" => "#00695C"
            ],
            [
                "name" => "Klassik",
                "slug" => "classic",
                "image" => asset('uploads/categories/classic.webp'),
                "search_query" => "classic music",
                "color" => "#F44336"
            ],
            [
                "name" => "Fitnes",
                "slug" => "fitness",
                "image" => asset('uploads/categories/fitness.webp'),
                "search_query" => "fitness music",
                "color" => "#303F9F"
            ],
            [
                "name" => "Yuxu",
                "slug" => "sleep",
                "image" => asset('uploads/categories/sleep.webp'),
                "search_query" => "sleep music",
                "color" => "#5D99C6"
            ],
            [
                "name" => "Karaoke",
                "slug" => "karaoke",
                "image" => asset('uploads/categories/karaoke.webp'),
                "search_query" => "karaoke music",
                "color" => "#5D6D7E"
            ],
            [
                "name" => "Geyminq",
                "slug" => "gaming",
                "image" => asset('uploads/categories/gaming.webp'),
                "search_query" => "Gaming music",
                "color" => "#8E44AD"
            ]
        ];

        Category::query()->insert($categories);
    }
}
