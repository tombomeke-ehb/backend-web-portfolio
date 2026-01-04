<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Repair migration: the migration record can exist while the table is missing
        // (e.g. table was dropped manually or migrations ran on another schema).
        if (!Schema::hasTable('news_item_translations')) {
            Schema::create('news_item_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('news_item_id')->constrained('news_items')->cascadeOnDelete();
                $table->string('lang', 5); // nl/en
                $table->string('title');
                $table->text('content');
                $table->timestamps();

                $table->unique(['news_item_id', 'lang']);
                $table->index(['lang', 'title']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_item_translations');
    }
};
