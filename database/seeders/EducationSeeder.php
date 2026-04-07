<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Database\Seeders\Helpers\ImageGenerator;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $educations = [
            [
                'degree'          => 'Maîtrise en Informatique (M.Sc.)',
                'institution'     => 'Université du Québec à Chicoutimi (UQAC)',
                'institution_url' => 'https://www.uqac.ca',
                'start_date'      => '2023-09-01',
                'end_date'        => null,
                'description'     => 'Recherche sur l\'analyse comparative de difficulté dans les jeux vidéo de plateformes via la vision par ordinateur et le machine learning. Projet LADDER sous la supervision du Prof. Bruno Bouchard, Hugo Tremblay et Yannick Francillette.',
                'mention'         => 'En cours',
                'location'        => 'Chicoutimi, QC, Canada',
                'order'           => 1,
                'techs'           => ['Python', 'YOLO', 'PyTorch', 'OpenCV', 'Pandas'],
                'degree_translatable' => ['en' => 'Master\'s in Computer Science (M.Sc.)'],
                'description_translatable' => [
                    'en' => 'Research on comparative difficulty analysis in platformer video games using computer vision and machine learning. LADDER project supervised by Prof. Bruno Bouchard, Hugo Tremblay and Yannick Francillette.',
                ],
            ],
            [
                'degree'          => 'Baccalauréat en Informatique',
                'institution'     => 'Université de Lomé',
                'institution_url' => 'https://www.univ-lome.tg',
                'start_date'      => '2019-09-01',
                'end_date'        => '2023-06-30',
                'description'     => 'Formation en informatique couvrant les fondamentaux de la programmation, les algorithmes, les bases de données, les réseaux et le développement web. Projet de fin d\'études en développement d\'applications.',
                'mention'         => 'Mention Bien',
                'location'        => 'Lomé, Togo',
                'order'           => 2,
                'techs'           => ['Python', 'JavaScript', 'PHP', 'MySQL', 'Git'],
                'degree_translatable' => ['en' => 'Bachelor\'s in Computer Science'],
                'description_translatable' => [
                    'en' => 'Computer science education covering programming fundamentals, algorithms, databases, networks and web development. Final project in application development.',
                ],
            ],
        ];

        foreach ($educations as $data) {
            $techs = $data['techs'];
            $degreeTrans = $data['degree_translatable'] ?? null;
            $descTrans = $data['description_translatable'] ?? null;
            unset($data['techs'], $data['degree_translatable'], $data['description_translatable']);
            $logo = ImageGenerator::logo(
                $data['institution'],
                'educations/' . Str::slug($data['institution']) . '.png',
                collect(['1e40af', '166534', '9333ea'])->random()
            );

            $education = Education::firstOrCreate(
                ['degree' => $data['degree'], 'institution' => $data['institution']],
                array_merge($data, [
                    'is_active' => true,
                    'degree_translatable' => $degreeTrans ? json_encode($degreeTrans) : null,
                    'description_translatable' => $descTrans ? json_encode($descTrans) : null,
                    'slug' => Str::slug($data['degree']),
                    'institution_logo' => $logo,
                ])
            );

            $techIds = Technology::whereIn('name', $techs)->pluck('id');
            $education->technologies()->syncWithoutDetaching($techIds);
        }
    }
}