<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Database\Seeders\Helpers\ImageGenerator;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'position'    => 'Chercheur — Projet LADDER',
                'company'     => 'UQAC — Université du Québec à Chicoutimi',
                'company_url' => 'https://www.uqac.ca',
                'start_date'  => '2024-01-15',
                'end_date'    => null,
                'category'    => 'paid_position',
                'description' => 'Développement du projet LADDER : dataset pour l\'analyse comparative de difficulté dans les jeux vidéo de plateformes (Super Mario Bros, Super Meat Boy, Mega Man). Pipeline de vision par ordinateur avec YOLO atteignant 99.5% de précision sur 15 566 frames. Traitement à 180-220 FPS avec réduction de données de 60-70%.',
                'location'    => 'Chicoutimi, QC, Canada',
                'work_type'   => 'on_site',
                'order'       => 1,
                'techs'       => ['Python', 'YOLO', 'OpenCV', 'PyTorch', 'PyQt6', 'Pandas'],
                'position_translatable' => ['en' => 'Researcher — LADDER Project'],
                'description_translatable' => [
                    'en' => 'Development of the LADDER project: dataset for comparative difficulty analysis in platformer video games (Super Mario Bros, Super Meat Boy, Mega Man). Computer vision pipeline with YOLO achieving 99.5% accuracy on 15,566 frames.',
                ],
            ],
            [
                'position'    => 'Développeur Full-Stack',
                'company'     => 'Projet Freelance',
                'start_date'  => '2023-06-01',
                'end_date'    => '2024-01-01',
                'category'    => 'paid_position',
                'description' => 'Développement d\'applications web sur mesure pour des clients variés. Conception d\'APIs REST, intégration de systèmes de paiement, et mise en place d\'architectures scalables avec Laravel et Django.',
                'location'    => 'Montréal, QC, Canada',
                'work_type'   => 'remote',
                'order'       => 2,
                'techs'       => ['Laravel', 'Django', 'PostgreSQL', 'Docker', 'React'],
                'position_translatable' => ['en' => 'Full-Stack Developer'],
                'description_translatable' => [
                    'en' => 'Custom web application development for various clients. REST API design, payment system integration, and scalable architecture setup with Laravel and Django.',
                ],
            ],
            [
                'position'    => 'Stagiaire en Développement Logiciel',
                'company'     => 'Entreprise Tech XYZ',
                'start_date'  => '2022-05-01',
                'end_date'    => '2022-08-31',
                'category'    => 'internship',
                'description' => 'Stage de développement logiciel axé sur la création d\'outils internes d\'automatisation. Développement de scripts Python pour le traitement de données et intégration avec des APIs tierces.',
                'location'    => 'Montréal, QC, Canada',
                'work_type'   => 'hybrid',
                'order'       => 3,
                'techs'       => ['Python', 'FastAPI', 'PostgreSQL', 'Git'],
                'position_translatable' => ['en' => 'Software Development Intern'],
                'description_translatable' => [
                    'en' => 'Software development internship focused on building internal automation tools. Python scripting for data processing and third-party API integration.',
                ],
            ],
            [
                'position'    => 'Co-fondateur & Développeur',
                'company'     => 'Projet Open Source — GameAnalytics',
                'start_date'  => '2023-09-01',
                'end_date'    => null,
                'category'    => 'founded',
                'description' => 'Création d\'une plateforme open source d\'analyse de gameplay utilisant la vision par ordinateur. Coordination d\'une équipe de 3 contributeurs, gestion du repo GitHub et documentation technique.',
                'location'    => 'Remote',
                'work_type'   => 'remote',
                'order'       => 4,
                'techs'       => ['Python', 'OpenCV', 'YOLO', 'FastAPI', 'React'],
                'position_translatable' => ['en' => 'Co-founder & Developer'],
                'description_translatable' => [
                    'en' => 'Creation of an open-source gameplay analysis platform using computer vision. Coordinating a team of 3 contributors, GitHub repo management and technical documentation.',
                ],
            ],
            [
                'position'    => 'Bénévole — Mentorat Tech',
                'company'     => 'Communauté Dev Montréal',
                'start_date'  => '2023-01-01',
                'end_date'    => null,
                'category'    => 'volunteer',
                'description' => 'Mentorat de développeurs juniors en Python et développement web. Organisation d\'ateliers pratiques sur Git, les bonnes pratiques de code et l\'introduction au machine learning.',
                'location'    => 'Montréal, QC, Canada',
                'work_type'   => 'on_site',
                'order'       => 5,
                'techs'       => ['Python', 'Git', 'Django'],
                'position_translatable' => ['en' => 'Volunteer — Tech Mentoring'],
                'description_translatable' => [
                    'en' => 'Mentoring junior developers in Python and web development. Organizing hands-on workshops on Git, code best practices and machine learning introduction.',
                ],
            ],
        ];

        foreach ($experiences as $data) {
            $techs = $data['techs'];
            $posTrans = $data['position_translatable'] ?? null;
            $descTrans = $data['description_translatable'] ?? null;
            unset($data['techs'], $data['position_translatable'], $data['description_translatable']);
            $logo = ImageGenerator::logo(
            $data['company'],
                'experiences/' . Str::slug($data['company']) . '.png',
                collect(['2563eb', '059669', 'dc2626', '7c3aed', 'd97706'])->random()
            );

            $experience = Experience::firstOrCreate(
                ['position' => $data['position'], 'company' => $data['company']],
                array_merge($data, [
                    'is_active' => true,
                    'position_translatable' => $posTrans ? json_encode($posTrans) : null,
                    'description_translatable' => $descTrans ? json_encode($descTrans) : null,
                    'slug' => Str::slug($data['position'] . '-' . $data['company']),
                    'company_logo' => $logo,
                ])
            );

            $techIds = Technology::whereIn('name', $techs)->pluck('id');
            $experience->technologies()->syncWithoutDetaching($techIds);
        }
    }
}