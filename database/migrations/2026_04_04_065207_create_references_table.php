<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('references', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();

            // Identité du référent
            $table->string('full_name');
            $table->string('title');                          // Ex: "Professeur titulaire"
            $table->string('organization');                   // Ex: "UQAC"
            $table->string('department')->nullable();         // Ex: "Département d'informatique"
            $table->string('photo')->nullable();
            $table->string('organization_logo')->nullable();

            // Relation avec toi
            $table->string('relationship');                   // Ex: "Directeur de recherche"
            $table->string('relationship_period')->nullable();// Ex: "2023 — Présent"

            // Contenu
            $table->text('testimonial')->nullable();          // Citation / témoignage court
            $table->string('letter_file')->nullable();        // PDF lettre de recommandation
            $table->string('letter_status')->default('available'); // available, pending, on_request

            // Coordonnées (affichage contrôlable)
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('show_contact_info')->default(false); // Afficher ou masquer les coordonnées

            // Traductions
            $table->jsonb('title_translatable')->nullable();
            $table->jsonb('organization_translatable')->nullable();
            $table->jsonb('department_translatable')->nullable();
            $table->jsonb('relationship_translatable')->nullable();
            $table->jsonb('testimonial_translatable')->nullable();

            // Paramètres
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('references');
    }
};