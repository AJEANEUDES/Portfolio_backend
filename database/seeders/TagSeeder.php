<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'YOLO', 'Computer Vision', 'Deep Learning', 'Python',
            'Laravel', 'Next.js', 'API REST', 'PostgreSQL',
            'Docker', 'Speedrun', 'Mario', 'Dataset',
            'Recherche', 'Open Source', 'Tutorial',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['name' => $tag],
                ['slug' => Str::slug($tag)]
            );
        }
    }
}