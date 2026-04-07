<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();              // header.experience, hero.contact_button...
            $table->string('group')->index();             // header, hero, filters, contact...
            $table->text('value_fr');                     // Texte français (par défaut)
            $table->jsonb('translations')->nullable();    // {"en": "...", "es": "..."}
            $table->text('description')->nullable();      // Aide pour comprendre où ça s'affiche
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};