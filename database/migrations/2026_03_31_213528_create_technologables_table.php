<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technologables', function (Blueprint $table) {
            $table->foreignUuid('technology_id')->constrained()->cascadeOnDelete();
            $table->uuidMorphs('technologable');            // Crée technologable_id (UUID) + technologable_type
            // pivot polymorphique
            $table->primary(['technology_id', 'technologable_id', 'technologable_type'], 'technologables_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technologables');
    }
};