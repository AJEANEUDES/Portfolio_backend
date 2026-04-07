<?php

namespace Database\Seeders;

use App\Models\Reference;
use Database\Seeders\Helpers\ImageGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $references = [
            [
                'full_name'           => 'Prof. Bruno Bouchard',
                'title'               => 'Professeur titulaire',
                'organization'        => 'Université du Québec à Chicoutimi (UQAC)',
                'department'          => 'Département d\'informatique et de mathématique',
                'relationship'        => 'Directeur de recherche — Projet LADDER',
                'relationship_period' => 'Janvier 2024 — Présent',
                'testimonial'         => 'Jean a démontré une capacité exceptionnelle à concevoir et implémenter des systèmes complexes de vision par ordinateur. Sa rigueur méthodologique et son autonomie en font un chercheur remarquable.',
                'letter_status'       => 'available',
                'email'               => 'bruno.bouchard@uqac.ca',
                'linkedin_url'        => 'https://linkedin.com/in/bruno-bouchard',
                'website_url'         => 'https://www.uqac.ca/portfolio/brunobouchard/',
                'show_contact_info'   => true,
                'order'               => 1,
                'title_translatable'  => ['en' => 'Full Professor'],
                'organization_translatable' => ['en' => 'University of Quebec at Chicoutimi (UQAC)'],
                'department_translatable'   => ['en' => 'Department of Computer Science and Mathematics'],
                'relationship_translatable' => ['en' => 'Research Director — LADDER Project'],
                'testimonial_translatable'  => [
                    'en' => 'Jean demonstrated an exceptional ability to design and implement complex computer vision systems. His methodological rigor and autonomy make him a remarkable researcher.',
                ],
            ],
            [
                'full_name'           => 'Hugo Tremblay',
                'title'               => 'Professeur',
                'organization'        => 'Université du Québec à Chicoutimi (UQAC)',
                'department'          => 'Département d\'informatique et de mathématique',
                'relationship'        => 'Co-superviseur de recherche',
                'relationship_period' => 'Janvier 2024 — Présent',
                'testimonial'         => 'Le travail de Jean sur le pipeline de traitement vidéo est d\'une qualité remarquable. Il a su transformer des concepts théoriques en solutions pratiques performantes.',
                'letter_status'       => 'on_request',
                'email'               => 'hugo.tremblay@uqac.ca',
                'show_contact_info'   => true,
                'order'               => 2,
                'title_translatable'  => ['en' => 'Professor'],
                'relationship_translatable' => ['en' => 'Research Co-supervisor'],
                'testimonial_translatable'  => [
                    'en' => 'Jean\'s work on the video processing pipeline is of remarkable quality. He has been able to transform theoretical concepts into high-performance practical solutions.',
                ],
            ],
            [
                'full_name'           => 'Yannick Francillette',
                'title'               => 'Professeur',
                'organization'        => 'Université du Québec à Chicoutimi (UQAC)',
                'department'          => 'Département d\'informatique et de mathématique',
                'relationship'        => 'Co-superviseur de recherche',
                'relationship_period' => 'Janvier 2024 — Présent',
                'testimonial'         => null,
                'letter_status'       => 'pending',
                'email'               => 'yannick.francillette@uqac.ca',
                'show_contact_info'   => false,
                'order'               => 3,
                'title_translatable'  => ['en' => 'Professor'],
                'relationship_translatable' => ['en' => 'Research Co-supervisor'],
            ],
        ];

        foreach ($references as $data) {
            $titleTrans = $data['title_translatable'] ?? null;
            $orgTrans = $data['organization_translatable'] ?? null;
            $deptTrans = $data['department_translatable'] ?? null;
            $relTrans = $data['relationship_translatable'] ?? null;
            $testTrans = $data['testimonial_translatable'] ?? null;
            unset($data['title_translatable'], $data['organization_translatable'],
                  $data['department_translatable'], $data['relationship_translatable'],
                  $data['testimonial_translatable']);

            $photo = ImageGenerator::avatar(
                $data['full_name'],
                'references/photos/' . Str::slug($data['full_name']) . '.png'
            );

            Reference::firstOrCreate(
                ['full_name' => $data['full_name']],
                array_merge($data, [
                    'slug'                      => Str::slug($data['full_name']),
                    'photo'                     => $photo,
                    'is_active'                 => true,
                    'title_translatable'        => $titleTrans ? json_encode($titleTrans) : null,
                    'organization_translatable' => $orgTrans ? json_encode($orgTrans) : null,
                    'department_translatable'   => $deptTrans ? json_encode($deptTrans) : null,
                    'relationship_translatable' => $relTrans ? json_encode($relTrans) : null,
                    'testimonial_translatable'  => $testTrans ? json_encode($testTrans) : null,
                ])
            );
        }
    }
}