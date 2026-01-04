<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single source-of-truth migration to create any translation table that may be missing.
        // This exists because some environments ended up with base tables present, but translation
        // tables missing while migrations were marked as ran.

        if (Schema::hasTable('news_items') && !Schema::hasTable('news_item_translations')) {
            Schema::create('news_item_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('news_item_id')->constrained('news_items')->cascadeOnDelete();
                $table->string('lang', 5);
                $table->string('title');
                $table->text('content');
                $table->timestamps();

                $table->unique(['news_item_id', 'lang']);
                $table->index(['lang', 'title']);
            });
        }

        if (Schema::hasTable('faq_categories') && !Schema::hasTable('faq_category_translations')) {
            Schema::create('faq_category_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('faq_category_id')->constrained('faq_categories')->cascadeOnDelete();
                $table->string('lang', 5);
                $table->string('name');
                $table->timestamps();

                $table->unique(['faq_category_id', 'lang']);
            });
        }

        if (Schema::hasTable('faq_items') && !Schema::hasTable('faq_item_translations')) {
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

        if (Schema::hasTable('projects') && !Schema::hasTable('project_translations')) {
            Schema::create('project_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
                $table->string('lang', 5);
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
        // Intentionally no-op: we don't want to drop shared tables from a "repair" migration.
    }
};
