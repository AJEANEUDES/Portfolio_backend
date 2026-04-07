<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 5)->unique();        // fr, en, es, pt, de...
            $table->string('name');                      // Français, English...
            $table->string('native_name');               // Français, English, Español...
            $table->string('flag')->nullable();          // Emoji drapeau ou code pays
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('code');
            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};