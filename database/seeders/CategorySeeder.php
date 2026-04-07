<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Machine Learning',     'type' => 'post'],
            ['name' => 'Vision par Ordinateur', 'type' => 'post'],
            ['name' => 'Développement Web',     'type' => 'post'],
            ['name' => 'DevOps',                'type' => 'post'],
            ['name' => 'Tutoriel',              'type' => 'post'],
            ['name' => 'Intelligence Artificielle', 'type' => 'publication'],
            ['name' => 'Analyse de Jeux Vidéo',     'type' => 'publication'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => $cat['type']],
                array_merge($cat, ['slug' => Str::slug($cat['name'])])
            );
        }
    }
}