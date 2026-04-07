<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'profiles'     => ['name_translatable', 'title_translatable', 'bio_translatable', 'hero_phrases_translatable'],
            'services'     => ['title_translatable', 'description_translatable'],
            'experiences'  => ['position_translatable', 'company_translatable', 'description_translatable'],
            'projects'     => ['name_translatable', 'description_translatable', 'long_description_translatable'],
            'educations'   => ['degree_translatable', 'institution_translatable', 'description_translatable'],
            'posts'        => ['title_translatable', 'excerpt_translatable', 'content_translatable', 'seo_title_translatable', 'seo_description_translatable'],
            'publications' => ['title_translatable', 'abstract_translatable'],
            'categories'   => ['name_translatable'],
            'tags'         => ['name_translatable'],
        ];

        foreach ($columns as $table => $cols) {
            foreach ($cols as $col) {
                DB::statement("ALTER TABLE {$table} ALTER COLUMN {$col} TYPE jsonb USING {$col}::jsonb");
            }
        }
    }

    public function down(): void
    {
        // Pas de rollback nécessaire, jsonb est rétrocompatible avec json
    }
};