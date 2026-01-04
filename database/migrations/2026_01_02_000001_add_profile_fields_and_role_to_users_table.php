<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->date('birthday')->nullable()->after('email');
            $table->string('profile_photo_path')->nullable()->after('birthday');
            $table->text('about')->nullable()->after('profile_photo_path');
            $table->boolean('is_admin')->default(false)->after('password');
            $table->string('preferred_language', 2)->default('nl')->after('about');
            $table->boolean('public_profile')->default(true)->after('preferred_language');
            $table->boolean('email_notifications')->default(true)->after('public_profile');
            $table->string('timezone', 64)->nullable()->after('email_notifications');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'birthday',
                'profile_photo_path',
                'about',
                'is_admin',
                'preferred_language',
                'public_profile',
                'email_notifications',
                'timezone',
            ]);
        });
    }
};
