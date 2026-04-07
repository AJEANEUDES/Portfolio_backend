<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('cover_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');                    // Markdown ou HTML
            $table->string('status')->default('draft');     // draft, published, archived
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('reading_time')->default(0); // En minutes
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->foreignUuid('author_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};