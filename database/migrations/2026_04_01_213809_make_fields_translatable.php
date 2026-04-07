<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // --- profiles ---
        Schema::table('profiles', function (Blueprint $table) {
            $table->json('name_translatable')->nullable()->after('name');
            $table->json('title_translatable')->nullable()->after('title');
            $table->json('bio_translatable')->nullable()->after('bio');
            $table->json('hero_phrases_translatable')->nullable()->after('hero_phrases');
        });

        // --- services ---
        Schema::table('services', function (Blueprint $table) {
            $table->json('title_translatable')->nullable()->after('title');
            $table->json('description_translatable')->nullable()->after('description');
        });

        // --- experiences ---
        Schema::table('experiences', function (Blueprint $table) {
            $table->json('position_translatable')->nullable()->after('position');
            $table->json('company_translatable')->nullable()->after('company');
            $table->json('description_translatable')->nullable()->after('description');
        });

        // --- projects ---
        Schema::table('projects', function (Blueprint $table) {
            $table->json('name_translatable')->nullable()->after('name');
            $table->json('description_translatable')->nullable()->after('description');
            $table->json('long_description_translatable')->nullable()->after('long_description');
        });

        // --- educations ---
        Schema::table('educations', function (Blueprint $table) {
            $table->json('degree_translatable')->nullable()->after('degree');
            $table->json('institution_translatable')->nullable()->after('institution');
            $table->json('description_translatable')->nullable()->after('description');
        });

        // --- posts ---
        Schema::table('posts', function (Blueprint $table) {
            $table->json('title_translatable')->nullable()->after('title');
            $table->json('excerpt_translatable')->nullable()->after('excerpt');
            $table->json('content_translatable')->nullable()->after('content');
            $table->json('seo_title_translatable')->nullable()->after('seo_title');
            $table->json('seo_description_translatable')->nullable()->after('seo_description');
        });

        // --- publications ---
        Schema::table('publications', function (Blueprint $table) {
            $table->json('title_translatable')->nullable()->after('title');
            $table->json('abstract_translatable')->nullable()->after('abstract');
        });

        // --- categories ---
        Schema::table('categories', function (Blueprint $table) {
            $table->json('name_translatable')->nullable()->after('name');
        });

        // --- tags ---
        Schema::table('tags', function (Blueprint $table) {
            $table->json('name_translatable')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        $tables = [
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

        foreach ($tables as $table => $columns) {
            Schema::table($table, function (Blueprint $t) use ($columns) {
                $t->dropColumn($columns);
            });
        }
    }
};