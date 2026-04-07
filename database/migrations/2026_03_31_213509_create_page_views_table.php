<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url');
            $table->string('referrer')->nullable();
            $table->string('country', 2)->nullable();       // Code ISO 2 lettres
            $table->string('device_type')->nullable();       // desktop, mobile, tablet
            $table->string('browser')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('url');
            $table->index('created_at');
            $table->index(['url', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};