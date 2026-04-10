<?php

namespace Database\Seeders;

use App\Models\SiteSection;
use Illuminate\Database\Seeder;

class SiteSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key'      => 'services',
                'title'    => 'Mes Services',
                'subtitle' => 'Solutions complètes adaptées à vos besoins',
                'title_translatable'    => ['en' => 'My Services'],
                'subtitle_translatable' => ['en' => 'Complete solutions tailored to your needs'],
                'order'    => 1,
            ],
            [
                'key'      => 'experiences',
                'title'    => 'Expériences',
                'subtitle' => 'Mon parcours professionnel et mes réalisations',
                'title_translatable'    => ['en' => 'Experience'],
                'subtitle_translatable' => ['en' => 'My professional journey and achievements'],
                'order'    => 2,
            ],
            [
                'key'      => 'projects',
                'title'    => 'Projets',
                'subtitle' => 'Découvrez mon portfolio de projets et solutions innovantes',
                'title_translatable'    => ['en' => 'Projects'],
                'subtitle_translatable' => ['en' => 'Discover my portfolio of projects and innovative solutions'],
                'order'    => 3,
            ],
            [
                'key'      => 'education',
                'title'    => 'Formation',
                'subtitle' => 'Mon parcours académique',
                'title_translatable'    => ['en' => 'Education'],
                'subtitle_translatable' => ['en' => 'My academic background'],
                'order'    => 4,
            ],
            [
                'key'      => 'blog',
                'title'    => 'Blog',
                'subtitle' => 'Articles, tutoriels et retours d\'expérience',
                'title_translatable'    => ['en' => 'Blog'],
                'subtitle_translatable' => ['en' => 'Articles, tutorials and experience feedback'],
                'order'    => 5,
            ],
            [
                'key'      => 'publications',
                'title'    => 'Publications',
                'subtitle' => 'Articles scientifiques, mémoires et rapports de recherche',
                'title_translatable'    => ['en' => 'Publications'],
                'subtitle_translatable' => ['en' => 'Scientific papers, theses and research reports'],
                'order'    => 6,
            ],
            [
                'key'      => 'references',
                'title'    => 'Références',
                'subtitle' => 'Personnes pouvant attester de mes compétences et de mon travail',
                'title_translatable'    => ['en' => 'References'],
                'subtitle_translatable' => ['en' => 'People who can vouch for my skills and work'],
                'order'    => 7,
            ],
            [
                'key'      => 'contact',
                'title'    => 'Contact',
                'subtitle' => 'Connectons-nous et construisons ensemble quelque chose d\'extraordinaire',
                'title_translatable'    => ['en' => 'Contact'],
                'subtitle_translatable' => ['en' => 'Let\'s connect and build something extraordinary together'],
                'order'    => 9,
            ],

            [
                'key'      => 'certifications',
                'title'    => 'Certifications',
                'subtitle' => 'Mes certifications professionnelles et compétences validées',
                'title_translatable'    => ['en' => 'Certifications'],
                'subtitle_translatable' => ['en' => 'My professional certifications and validated skills'],
                'order'    => 8,
            ],
        ];

        foreach ($sections as $data) {
            $titleTrans = $data['title_translatable'];
            $subTrans = $data['subtitle_translatable'];
            unset($data['title_translatable'], $data['subtitle_translatable']);

            SiteSection::firstOrCreate(
                ['key' => $data['key']],
                array_merge($data, [
                    'is_active' => true,
                    'title_translatable'    => json_encode($titleTrans),
                    'subtitle_translatable' => json_encode($subTrans),
                ])
            );
        }
    }
}