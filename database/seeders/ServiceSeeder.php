<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'       => 'Vision par Ordinateur & IA',
                'description' => 'Développement de pipelines de traitement d\'images, détection d\'objets avec YOLO, classification et analyse de données visuelles pour la recherche et l\'industrie.',
                'order'       => 1,
                'techs'       => ['Python', 'YOLO', 'OpenCV', 'PyTorch'],
                'title_translatable' => ['en' => 'Computer Vision & AI', 'es' => 'Visión por Computadora e IA'],
                'description_translatable' => [
                    'en' => 'Development of image processing pipelines, object detection with YOLO, classification and visual data analysis for research and industry.',
                ],
            ],
            [
                'title'       => 'Développement Web Full-Stack',
                'description' => 'Conception et développement d\'applications web modernes et performantes avec des frameworks robustes côté backend et frontend.',
                'order'       => 2,
                'techs'       => ['Laravel', 'Next.js', 'Django', 'PostgreSQL'],
                'title_translatable' => ['en' => 'Full-Stack Web Development'],
                'description_translatable' => [
                    'en' => 'Design and development of modern, high-performance web applications with robust backend and frontend frameworks.',
                ],
            ],
            [
                'title'       => 'Analyse de Données & ML',
                'description' => 'Extraction, traitement et analyse de données massives. Entraînement de modèles de machine learning pour la classification, la prédiction et l\'automatisation.',
                'order'       => 3,
                'techs'       => ['Python', 'Scikit-learn', 'Pandas', 'NumPy'],
                'title_translatable' => ['en' => 'Data Analysis & ML'],
                'description_translatable' => [
                    'en' => 'Extraction, processing and analysis of large datasets. Training machine learning models for classification, prediction and automation.',
                ],
            ],
            [
                'title'       => 'Applications Desktop',
                'description' => 'Développement d\'applications bureau riches avec interfaces graphiques modernes pour le traitement de données, l\'annotation et la visualisation.',
                'order'       => 4,
                'techs'       => ['Python', 'PyQt6'],
                'title_translatable' => ['en' => 'Desktop Applications'],
                'description_translatable' => [
                    'en' => 'Development of rich desktop applications with modern GUIs for data processing, annotation and visualization.',
                ],
            ],
            [
                'title'       => 'Automatisation & Scraping',
                'description' => 'Création de robots d\'extraction de données web, automatisation de workflows et intégration de systèmes via APIs.',
                'order'       => 5,
                'techs'       => ['Python', 'Selenium', 'FastAPI'],
                'title_translatable' => ['en' => 'Automation & Scraping'],
                'description_translatable' => [
                    'en' => 'Creation of web data extraction bots, workflow automation and system integration via APIs.',
                ],
            ],
            [
                'title'       => 'Recherche Académique',
                'description' => 'Contribution à la recherche scientifique en informatique, rédaction d\'articles, développement de méthodologies expérimentales et analyse statistique.',
                'order'       => 6,
                'techs'       => ['Python', 'NumPy', 'Pandas'],
                'title_translatable' => ['en' => 'Academic Research'],
                'description_translatable' => [
                    'en' => 'Contributing to computer science research, writing papers, developing experimental methodologies and statistical analysis.',
                ],
            ],
        ];

        foreach ($services as $data) {
            $techs = $data['techs'];
            $titleTrans = $data['title_translatable'] ?? null;
            $descTrans = $data['description_translatable'] ?? null;
            unset($data['techs'], $data['title_translatable'], $data['description_translatable']);

            $service = Service::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'is_active' => true,
                    'title_translatable' => $titleTrans ? json_encode($titleTrans) : null,
                    'description_translatable' => $descTrans ? json_encode($descTrans) : null,
                    'slug'      => Str::slug($data['title'])
                ])
            );

            $techIds = Technology::whereIn('name', $techs)->pluck('id');
            $service->technologies()->syncWithoutDetaching($techIds);
        }
    }
}