<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Database\Seeders\Helpers\ImageGenerator;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name'        => 'LADDER — Speedrun Pipeline Manager',
                'description' => 'Application desktop PyQt6 pour automatiser l\'extraction, le téléchargement et l\'analyse de données de speedrun depuis speedrun.com. Pipeline de 15 modules atteignant 96.5% de classification automatisée.',
                'long_description' => 'Le Speedrun Pipeline Manager est le cœur technique du projet LADDER. Il orchestre un pipeline de 15 modules interconnectés qui traitent automatiquement les vidéos de speedrun de Super Mario Bros.',
                'category'    => 'academic',
                'website_url' => null,
                'github_url'  => 'https://github.com/jean/ladder-pipeline',
                'video_url'   => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'date'        => '2025-06-01',
                'is_featured' => true,
                'order'       => 1,
                'techs'       => ['Python', 'PyQt6', 'YOLO', 'OpenCV', 'Pandas'],
            ],
            [
                'name'        => 'YOLO Mario — Détection d\'objets',
                'description' => 'Modèle YOLO entraîné pour la détection d\'objets dans Super Mario Bros. 99.5% de précision pour la classification de niveaux sur 15 566 frames et 97% mAP50 pour la détection de 25 classes d\'objets.',
                'category'    => 'academic',
                'github_url'  => 'https://github.com/jean/yolo-mario',
                'video_url'   => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'date'        => '2025-03-01',
                'is_featured' => true,
                'order'       => 2,
                'techs'       => ['Python', 'YOLO', 'PyTorch', 'OpenCV', 'NumPy'],
            ],
            [
                'name'        => 'Portfolio Professionnel',
                'description' => 'Site portfolio personnel avec panel d\'administration complet. Architecture Laravel + Next.js, API REST, multilingue, dark mode, et statistiques visiteurs intégrées.',
                'category'    => 'personal',
                'website_url' => 'https://jean-portfolio.com',
                'github_url'  => 'https://github.com/jean/portfolio',
                'date'        => '2026-03-31',
                'is_featured' => true,
                'order'       => 3,
                'techs'       => ['Laravel', 'Next.js', 'TypeScript', 'Tailwind CSS', 'PostgreSQL', 'Filament'],
            ],
            [
                'name'        => 'Speedrun Data Scraper',
                'description' => 'Application de web scraping pour extraire les données de speedrun depuis speedrun.com. Gestion de 6 catégories Super Mario Bros avec détection automatique des pages et anti-détection.',
                'category'    => 'academic',
                'github_url'  => 'https://github.com/jean/speedrun-scraper',
                'date'        => '2024-11-01',
                'is_featured' => false,
                'order'       => 4,
                'techs'       => ['Python', 'Selenium', 'FastAPI'],
            ],
            [
                'name'        => 'Annotation Tool — Sprites Mario',
                'description' => 'Outil d\'annotation et d\'augmentation de données pour l\'entraînement de modèles de détection d\'objets. Support de 25 classes d\'objets Mario avec augmentation 7x du dataset.',
                'category'    => 'academic',
                'github_url'  => 'https://github.com/jean/mario-annotation-tool',
                'date'        => '2025-01-15',
                'is_featured' => false,
                'order'       => 5,
                'techs'       => ['Python', 'PyQt6', 'OpenCV'],
            ],
            [
                'name'        => 'E-Commerce API',
                'description' => 'API REST complète pour une plateforme e-commerce avec gestion des produits, panier, commandes, paiements Stripe et notifications en temps réel.',
                'category'    => 'customer',
                'website_url' => 'https://shop-demo.example.com',
                'date'        => '2023-09-01',
                'is_featured' => false,
                'order'       => 6,
                'techs'       => ['Laravel', 'PostgreSQL', 'Redis', 'Docker'],
            ],
            [
                'name'        => 'Dataset Analyzer',
                'description' => 'Scripts Python pour le parsing, la visualisation et l\'analyse statistique du dataset Rafael Pinto SMB contenant 737 000+ frames de gameplay.',
                'category'    => 'open_source',
                'github_url'  => 'https://github.com/jean/dataset-analyzer',
                'date'        => '2024-06-01',
                'is_featured' => false,
                'order'       => 7,
                'techs'       => ['Python', 'Pandas', 'NumPy', 'Scikit-learn'],
            ],
            [
                'name'        => 'Task Manager App',
                'description' => 'Application de gestion de tâches avec authentification, tableaux Kanban, notifications et API REST. Projet personnel pour explorer Django REST Framework.',
                'category'    => 'personal',
                'github_url'  => 'https://github.com/jean/task-manager',
                'video_url'   => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'date'        => '2023-04-01',
                'is_featured' => false,
                'order'       => 8,
                'techs'       => ['Django', 'React', 'PostgreSQL', 'Docker'],
            ],
        ];

        foreach ($projects as $data) {
            $techs = $data['techs'];
            unset($data['techs']);

            $screenshot = ImageGenerator::screenshot(
                $data['name'],
                'projects/screenshots/' . Str::slug($data['name']) . '.png'
            );

            $project = Project::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, [

                        'is_active' => true,
                        'slug' => Str::slug($data['name']),
                        'screenshot' => $screenshot,
                    ])
            );

            $techIds = Technology::whereIn('name', $techs)->pluck('id');
            $project->technologies()->syncWithoutDetaching($techIds);
        }
    }
}