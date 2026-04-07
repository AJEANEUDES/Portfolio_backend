<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('post');        // post, publication
            $table->timestamps();

            $table->index('slug');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};