<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('authors');                      // "Nom1, A., Nom2, B."
            $table->string('type');                         // journal, conference, thesis, technical_report, book_chapter
            $table->string('venue')->nullable();            // Nom revue/conférence
            $table->unsignedSmallInteger('year');
            $table->string('doi_url')->nullable();
            $table->string('pdf_file')->nullable();
            $table->text('abstract')->nullable();
            $table->text('bibtex')->nullable();
            $table->foreignUuid('project_id')->nullable()
                  ->constrained('projects')->nullOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('type');
            $table->index('year');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};