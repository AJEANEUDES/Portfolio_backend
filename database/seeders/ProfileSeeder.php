<?php

namespace Database\Seeders;

use App\Models\Profile;
use Database\Seeders\Helpers\ImageGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $photo = ImageGenerator::avatar('Jean Adjanohoun', 'profiles/photo.png');

        Profile::firstOrCreate(
            ['email' => 'jean@portfolio.com'],
            [
                'name'  => 'Jean Adjanohoun',
                'title' => 'Étudiant M.Sc. Informatique & Développeur',
                'bio'   => 'Passionné par la vision par ordinateur, le machine learning et le développement logiciel. Actuellement en maîtrise à l\'UQAC, je travaille sur le projet LADDER — un dataset pour l\'analyse comparative de difficulté dans les jeux vidéo de plateformes.',
                'photo' => $photo,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'hero_phrases' => [
                    'Computer Vision & Machine Learning',
                    'Développeur Full-Stack passionné',
                    'Créateur de solutions innovantes',
                    'Chercheur en Intelligence Artificielle',
                ],
                'name_translatable' => json_encode([
                    'en' => 'Jean Adjanohoun',
                    'es' => 'Jean Adjanohoun',
                ]),
                'title_translatable' => json_encode([
                    'en' => 'M.Sc. Computer Science Student & Developer',
                    'es' => 'Estudiante M.Sc. Informática & Desarrollador',
                ]),
                'bio_translatable' => json_encode([
                    'en' => 'Passionate about computer vision, machine learning and software development. Currently pursuing my Master\'s at UQAC, working on the LADDER project — a dataset for comparative difficulty analysis in platformer video games.',
                    'es' => 'Apasionado por la visión por computadora, el aprendizaje automático y el desarrollo de software. Actualmente cursando mi maestría en UQAC.',
                ]),
                'hero_phrases_translatable' => json_encode([
                    'en' => [
                        'Computer Vision & Machine Learning',
                        'Passionate Full-Stack Developer',
                        'Building innovative solutions',
                        'AI Researcher',
                    ],
                ]),
            ]
        );
    }
}