<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminUserSeeder::class,
            LanguageSeeder::class,
            TechnologySeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ProfileSeeder::class,
            ServiceSeeder::class,
            ExperienceSeeder::class,
            ProjectSeeder::class,
            EducationSeeder::class,
            PostSeeder::class,
            PublicationSeeder::class,
            SocialLinkSeeder::class,
            ReferenceSeeder::class,
            SiteSectionSeeder::class,
            TranslationSeeder::class,
            CertificationSeeder::class,
        ]);


    }
}
