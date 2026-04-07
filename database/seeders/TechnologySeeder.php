<?php

namespace Database\Seeders;

use App\Models\Technology;
use Database\Seeders\Helpers\ImageGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        $technologies = 
        [
            ['name' => 'Python',       'description' => 'Langage polyvalent',   'order' => 1,  'color' => '3776ab'],
            ['name' => 'Django',       'description' => 'Framework Python',     'order' => 2,  'color' => '092e20'],
            ['name' => 'FastAPI',      'description' => 'API Python rapide',    'order' => 3,  'color' => '009688'],
            ['name' => 'Laravel',      'description' => 'Framework PHP',        'order' => 4,  'color' => 'ff2d20'],
            ['name' => 'PHP',          'description' => 'Langage backend',      'order' => 5,  'color' => '777bb4'],
            ['name' => 'Next.js',      'description' => 'Framework React',      'order' => 6,  'color' => '000000'],
            ['name' => 'React',        'description' => 'Bibliothèque UI',      'order' => 7,  'color' => '61dafb'],
            ['name' => 'TypeScript',   'description' => 'JavaScript typé',      'order' => 8,  'color' => '3178c6'],
            ['name' => 'JavaScript',   'description' => 'Langage web',          'order' => 9,  'color' => 'f7df1e'],
            ['name' => 'Tailwind CSS', 'description' => 'Framework CSS',        'order' => 10, 'color' => '06b6d4'],
            ['name' => 'PostgreSQL',   'description' => 'Base de données',      'order' => 11, 'color' => '4169e1'],
            ['name' => 'MySQL',        'description' => 'Base de données',      'order' => 12, 'color' => '4479a1'],
            ['name' => 'Redis',        'description' => 'Cache en mémoire',     'order' => 13, 'color' => 'dc382d'],
            ['name' => 'Docker',       'description' => 'Conteneurisation',     'order' => 14, 'color' => '2496ed'],
            ['name' => 'Git',          'description' => 'Contrôle de versions', 'order' => 15, 'color' => 'f05032'],
            ['name' => 'PyTorch',      'description' => 'Deep Learning',        'order' => 16, 'color' => 'ee4c2c'],
            ['name' => 'YOLO',         'description' => 'Détection d\'objets',  'order' => 17, 'color' => '00ff00'],
            ['name' => 'OpenCV',       'description' => 'Vision par ordinateur','order' => 18, 'color' => '5c3ee8'],
            ['name' => 'Scikit-learn', 'description' => 'Machine Learning',     'order' => 19, 'color' => 'f7931e'],
            ['name' => 'PyQt6',        'description' => 'Interface Desktop',    'order' => 20, 'color' => '41cd52'],
            ['name' => 'Selenium',     'description' => 'Automatisation web',   'order' => 21, 'color' => '43b02a'],
            ['name' => 'Filament',     'description' => 'Admin Laravel',        'order' => 22, 'color' => 'fdae4b'],
            ['name' => 'Flutter',      'description' => 'Applications mobiles', 'order' => 23, 'color' => '02569b'],
            ['name' => 'Firebase',     'description' => 'Backend as a Service', 'order' => 24, 'color' => 'ffca28'],
            ['name' => 'AWS',          'description' => 'Cloud computing',      'order' => 25, 'color' => 'ff9900'],
            ['name' => 'Linux',        'description' => 'Système d\'exploitation', 'order' => 26, 'color' => 'fcc624'],
            ['name' => 'Pandas',       'description' => 'Analyse de données',   'order' => 27, 'color' => '150458'],
            ['name' => 'NumPy',        'description' => 'Calcul scientifique',  'order' => 28, 'color' => '013243'],
        
            ];

        foreach ($technologies as $tech) {
            $icon = ImageGenerator::logo(
                $tech['name'],
                'technologies/' . Str::slug($tech['name']) . '.png',
                $tech['color']
            );

            Technology::firstOrCreate(
                ['name' => $tech['name']],
                [
                    'slug'      => Str::slug($tech['name']),
                    'description' => $tech['description'],
                    'icon'      => $icon,
                    'order'     => $tech['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}