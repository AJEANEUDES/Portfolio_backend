<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('degree');
            $table->string('institution');
            $table->string('institution_logo')->nullable();
            $table->string('institution_url')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();           // NULL = "En cours"
            $table->text('description')->nullable();
            $table->string('mention')->nullable();          // Ex: "Mention Bien", "3.8 GPA"
            $table->string('location')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};