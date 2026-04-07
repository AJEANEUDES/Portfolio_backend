<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorizables', function (Blueprint $table) {
            $table->foreignUuid('category_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('categorizable');           // Crée categorizable_id (UUID) + categorizable_type
            // pivot polymorphique
            $table->primary(['category_id', 'categorizable_id', 'categorizable_type'], 'categorizables_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorizables');
    }
};