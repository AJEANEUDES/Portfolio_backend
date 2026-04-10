<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();

            // Informations principales
            $table->string('name');
            $table->string('issuer');                     // Organisme émetteur
            $table->string('issuer_logo')->nullable();
            $table->string('category')->default('other'); // cloud, development, data_science, devops, security, other
            $table->string('credential_id')->nullable();  // ID officiel de la certif
            $table->string('verification_url')->nullable();// URL de vérification
            $table->string('badge_image')->nullable();    // Image du badge

            // Dates
            $table->date('issued_date');                  // Date d'obtention
            $table->date('expiration_date')->nullable(); // Null = ne expire pas

            // Description et compétences
            $table->text('description')->nullable();
            $table->jsonb('skills')->nullable();          // Tableau de compétences validées

            // Traductions
            $table->jsonb('name_translatable')->nullable();
            $table->jsonb('description_translatable')->nullable();

            // Paramètres
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index(['is_active', 'order']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};