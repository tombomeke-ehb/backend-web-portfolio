<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Repair migration: projects base table can exist while translation table is missing.
        if (!Schema::hasTable('project_translations')) {
            Schema::create('project_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
                $table->string('lang', 5); // nl/en
                $table->string('title');
                $table->text('description');
                $table->text('long_description')->nullable();
                $table->json('features')->nullable();
                $table->timestamps();

                $table->unique(['project_id', 'lang']);
                $table->index(['lang', 'title']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_translations');
    }
};
