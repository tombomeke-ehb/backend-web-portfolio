<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Required default admin
        User::updateOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@ehb.be',
                'password' => Hash::make('Password!321'),
                'is_admin' => true,
            ]
        );

        // Optional normal user for local testing
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'email' => 'test@example.com',
                'password' => Hash::make('Password!321'),
                'is_admin' => false,
            ]
        );

        $this->call([
            NewsItemSeeder::class,
            FaqSeeder::class,
            ProjectSeeder::class,
            ExtraFeaturesSeeder::class,

            // Site configuration (required for Admin > Site Settings to not be empty)
            SiteSettingsSeeder::class,
        ]);
    }
}
