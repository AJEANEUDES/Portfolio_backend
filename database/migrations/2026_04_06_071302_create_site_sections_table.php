<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key')->unique();           // services, experiences, projects...
            $table->string('title');                    // Titre affiché
            $table->text('subtitle')->nullable();       // Sous-titre
            $table->jsonb('title_translatable')->nullable();
            $table->jsonb('subtitle_translatable')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_sections');
    }
};