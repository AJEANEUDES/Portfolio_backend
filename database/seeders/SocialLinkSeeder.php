<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform'  => 'linkedin',
                'url'       => 'https://www.linkedin.com/in/jean-adjanohoun',
                'label'     => 'LinkedIn',
                'order'     => 1,
                'is_active' => true,
            ],
            [
                'platform'  => 'github',
                'url'       => 'https://github.com/jean-adjanohoun',
                'label'     => 'GitHub',
                'order'     => 2,
                'is_active' => true,
            ],
            [
                'platform'  => 'twitter',
                'url'       => 'https://twitter.com/jean_dev',
                'label'     => 'Twitter / X',
                'order'     => 3,
                'is_active' => true,
            ],
            [
                'platform'  => 'email',
                'url'       => 'mailto:jean@portfolio.com',
                'label'     => 'Email',
                'order'     => 4,
                'is_active' => true,
            ],
            [
                'platform'  => 'youtube',
                'url'       => 'https://youtube.com/@jean-dev',
                'label'     => 'YouTube',
                'order'     => 5,
                'is_active' => true,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::firstOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}