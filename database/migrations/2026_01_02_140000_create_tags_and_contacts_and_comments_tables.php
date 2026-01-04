<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Many-to-many: tags for news items
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->unique(['name']);
        });

        Schema::create('news_item_tag', function (Blueprint $table) {
            $table->foreignId('news_item_id')->constrained('news_items')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

            $table->primary(['news_item_id', 'tag_id']);
        });

        // Extra feature: contact form messages stored in DB + admin replies
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('subject')->nullable();
            $table->text('message');

            $table->timestamp('read_at')->nullable()->index();
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable()->index();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });

        // Extra feature: comments on news items
        Schema::create('news_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_item_id')->constrained('news_items')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');

            $table->boolean('is_approved')->default(true)->index();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index(['news_item_id', 'is_approved', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('news_item_tag');
        Schema::dropIfExists('tags');
    }
};
