<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Repair migration: FAQ base tables can exist while translation tables are missing.

        if (!Schema::hasTable('faq_category_translations')) {
            Schema::create('faq_category_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('faq_category_id')->constrained('faq_categories')->cascadeOnDelete();
                $table->string('lang', 5);
                $table->string('name');
                $table->timestamps();

                $table->unique(['faq_category_id', 'lang']);
            });
        }

        if (!Schema::hasTable('faq_item_translations')) {
            Schema::create('faq_item_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('faq_item_id')->constrained('faq_items')->cascadeOnDelete();
                $table->string('lang', 5);
                $table->string('question');
                $table->text('answer');
                $table->timestamps();

                $table->unique(['faq_item_id', 'lang']);
                $table->index(['lang', 'question']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_item_translations');
        Schema::dropIfExists('faq_category_translations');
    }
};
