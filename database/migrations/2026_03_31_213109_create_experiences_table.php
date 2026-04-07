<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('position');                     // Titre du poste
            $table->string('company');
            $table->string('company_logo')->nullable();
            $table->string('company_url')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();           // NULL = "Présent"
            $table->string('category');                     // paid_position, founded, volunteer, internship
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('work_type')->default('on_site'); // on_site, remote, hybrid
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('category');
            $table->index(['is_active', 'order']);
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};