<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Database\Seeders\Helpers\ImageGenerator;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first();

        $posts = [
            [
                'title'     => 'Comment j\'ai atteint 99.5% de précision avec YOLO sur des sprites Mario',
                'excerpt'   => 'Retour d\'expérience sur l\'entraînement d\'un modèle YOLO pour la classification de niveaux dans Super Mario Bros, avec les défis rencontrés et les solutions appliquées.',
                'content'   => '<h2>Introduction</h2><p>Dans le cadre du projet LADDER, j\'ai dû entraîner un modèle YOLO pour classifier automatiquement les niveaux de Super Mario Bros à partir de captures d\'écran de speedruns.</p><h2>Le défi</h2><p>Les sprites Mario sont petits (16x16 pixels), les arrière-plans varient entre les mondes, et certains ennemis se ressemblent fortement. La première itération du modèle plafonnait à 85%.</p><h2>La solution</h2><p>Trois techniques ont fait la différence : l\'augmentation de données ciblée (rotation, flip, ajustement de luminosité), le fine-tuning progressif avec un learning rate scheduler, et l\'ajout de classes intermédiaires pour les objets ambigus.</p><h2>Résultats</h2><p>Le modèle final atteint 99.5% de précision sur 15 566 frames de test, avec un temps d\'inférence de 12ms par frame.</p>',
                'status'    => 'published',
                'published_at' => '2025-11-15 10:00:00',
                'categories' => ['Vision par Ordinateur', 'Machine Learning'],
                'tags'       => ['YOLO', 'Computer Vision', 'Deep Learning', 'Mario'],
            ],
            [
                'title'     => 'Construire un pipeline de traitement vidéo à 200 FPS avec Python',
                'excerpt'   => 'Architecture et optimisations pour traiter des vidéos de gameplay en temps quasi-réel avec OpenCV et multiprocessing.',
                'content'   => '<h2>Le besoin</h2><p>Pour le projet LADDER, il fallait traiter des centaines d\'heures de vidéos de speedrun. Un traitement séquentiel frame par frame prenait des semaines.</p><h2>Architecture du pipeline</h2><p>Le pipeline utilise une architecture producteur-consommateur avec multiprocessing Python. Le décodeur vidéo alimente une queue partagée, et N workers traitent les frames en parallèle.</p><h2>Optimisations clés</h2><p>Trois optimisations ont fait passer le throughput de 30 à 200+ FPS : le décodage matériel avec FFmpeg, le batch processing YOLO, et la réduction intelligente de frames (skip des frames statiques).</p>',
                'status'    => 'published',
                'published_at' => '2025-10-01 14:00:00',
                'categories' => ['Vision par Ordinateur'],
                'tags'       => ['Python', 'Computer Vision', 'Speedrun'],
            ],
            [
                'title'     => 'Laravel + Next.js : architecture d\'un portfolio moderne',
                'excerpt'   => 'Guide technique sur l\'architecture d\'un site portfolio avec Laravel comme API backend, Filament pour l\'admin, et Next.js pour le frontend SSR.',
                'content'   => '<h2>Pourquoi cette stack ?</h2><p>Laravel offre un écosystème PHP mature avec Eloquent, Filament pour l\'admin, et une gestion des API REST robuste. Next.js apporte le SSR pour le SEO et une expérience développeur React moderne.</p><h2>Architecture</h2><p>Le backend expose une API REST versionée (/api/v1/), le frontend Next.js consomme cette API côté serveur pour le SSR. Filament génère automatiquement le CRUD admin.</p>',
                'status'    => 'published',
                'published_at' => '2026-03-20 09:00:00',
                'categories' => ['Développement Web'],
                'tags'       => ['Laravel', 'Next.js', 'API REST'],
            ],
            [
                'title'     => 'Introduction au web scraping éthique avec Selenium',
                'excerpt'   => 'Comment extraire des données web de manière responsable, avec gestion des anti-détection et respect des rate limits.',
                'content'   => '<h2>Contexte</h2><p>Pour alimenter le dataset LADDER, j\'ai dû extraire des milliers d\'entrées depuis speedrun.com. Voici les leçons apprises.</p><h2>Bonnes pratiques</h2><p>Respecter le robots.txt, implémenter des délais aléatoires entre les requêtes, et toujours vérifier les conditions d\'utilisation du site cible.</p>',
                'status'    => 'draft',
                'published_at' => null,
                'categories' => ['Tutoriel'],
                'tags'       => ['Python', 'Tutorial'],
            ],
        ];

        foreach ($posts as $data) {
            $catNames = $data['categories'];
            $tagNames = $data['tags'];
            unset($data['categories'], $data['tags']);
            $cover = ImageGenerator::coverImage(
                Str::limit($data['title'], 30),
                'posts/covers/' . Str::slug($data['title']) . '.png'
            );

            $post = Post::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'author_id' => $author?->id,
                    'slug' => Str::slug($data['title']),
                    'cover_image' => $cover,
                ])
            );

            $catIds = Category::whereIn('name', $catNames)->pluck('id');
            $post->categories()->syncWithoutDetaching($catIds);

            $tagIds = Tag::whereIn('name', $tagNames)->pluck('id');
            $post->tags()->syncWithoutDetaching($tagIds);
        }
    }
}