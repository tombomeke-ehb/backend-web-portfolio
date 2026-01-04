<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('faq_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_category_id')->constrained('faq_categories')->cascadeOnDelete();
            $table->string('lang', 5); // nl/en
            $table->string('name');
            $table->timestamps();

            $table->unique(['faq_category_id', 'lang']);
        });

        Schema::create('faq_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_category_id')->constrained('faq_categories')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['faq_category_id', 'sort_order']);
        });

        Schema::create('faq_item_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_item_id')->constrained('faq_items')->cascadeOnDelete();
            $table->string('lang', 5); // nl/en
            $table->string('question');
            $table->text('answer');
            $table->timestamps();

            $table->unique(['faq_item_id', 'lang']);
            $table->index(['lang', 'question']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_item_translations');
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('faq_category_translations');
        Schema::dropIfExists('faq_categories');
    }
};
