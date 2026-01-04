<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\NewsComment;
use App\Models\NewsItem;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExtraFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // Tags
        $tags = collect([
            'Laravel',
            'Backend',
            'School',
            'Update',
        ])->map(function (string $name) {
            return Tag::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'slug' => Str::slug($name)]
            );
        });

        // Attach some tags to existing news
        $news = NewsItem::query()->orderBy('id')->get();
        foreach ($news as $i => $item) {
            $item->tags()->syncWithoutDetaching($tags->take(($i % 3) + 1)->pluck('id')->all());
        }

        // Seed multiple users so comments look like real conversations
        $users = collect([
            [
                'name' => 'Alice Developer',
                'username' => 'alice',
                'email' => 'alice@example.com',
            ],
            [
                'name' => 'Bob Builder',
                'username' => 'bob',
                'email' => 'bob@example.com',
            ],
            [
                'name' => 'Charlie Reviewer',
                'username' => 'charlie',
                'email' => 'charlie@example.com',
            ],
        ])->map(function (array $u) {
            return User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'username' => $u['username'],
                    'email' => $u['email'],
                    'password' => Hash::make('Password!321'),
                    'is_admin' => false,
                ]
            );
        });

        // Add some realistic skills for those users (so admins can click profiles from comments)
        $skillSets = [
            'alice@example.com' => [
                ['name' => 'Laravel', 'category' => 'backend', 'level' => 4, 'notes' => 'Auth, REST APIs, Eloquent, Blade', 'is_public' => true],
                ['name' => 'PHP', 'category' => 'backend', 'level' => 4, 'notes' => 'OOP, testing, refactoring', 'is_public' => true],
                ['name' => 'Tailwind/CSS', 'category' => 'frontend', 'level' => 3, 'notes' => 'Responsive UI, utility-first', 'is_public' => true],
            ],
            'bob@example.com' => [
                ['name' => 'JavaScript', 'category' => 'frontend', 'level' => 4, 'notes' => 'DOM, modules, fetch, Vite', 'is_public' => true],
                ['name' => 'Vue', 'category' => 'frontend', 'level' => 3, 'notes' => 'Components, state, routing', 'is_public' => true],
                ['name' => 'Docker', 'category' => 'devops', 'level' => 3, 'notes' => 'Local dev, containers, compose', 'is_public' => true],
            ],
            'charlie@example.com' => [
                ['name' => 'Testing', 'category' => 'backend', 'level' => 4, 'notes' => 'Pest/PHPUnit, factories, CI mindset', 'is_public' => true],
                ['name' => 'Accessibility', 'category' => 'frontend', 'level' => 3, 'notes' => 'Keyboard nav, aria, contrast', 'is_public' => true],
                ['name' => 'SQL', 'category' => 'backend', 'level' => 3, 'notes' => 'Indexes, joins, query tuning basics', 'is_public' => true],
            ],
        ];

        foreach ($users as $u) {
            foreach (($skillSets[$u->email] ?? []) as $skill) {
                UserSkill::updateOrCreate(
                    ['user_id' => $u->id, 'name' => $skill['name']],
                    [
                        'category' => $skill['category'] ?? null,
                        'level' => $skill['level'] ?? 3,
                        'notes' => $skill['notes'] ?? null,
                        'is_public' => $skill['is_public'] ?? true,
                    ]
                );
            }
        }

        // Example contact messages (for admin inbox)
        // - Some unread
        // - Some already replied by admin
        ContactMessage::updateOrCreate(
            ['email' => 'student@example.com', 'subject' => 'Hello'],
            [
                'name' => 'Student',
                'message' => 'Hi! This is a seeded contact message so the admin inbox is not empty.',
                'read_at' => null,
                'admin_reply' => null,
                'replied_at' => null,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
            ]
        );

        ContactMessage::updateOrCreate(
            ['email' => 'collab@example.com', 'subject' => 'Collaboration idea'],
            [
                'name' => 'Potential Collaborator',
                'message' => "Hey! I love your portfolio. Want to collaborate on a small open-source project?\n\nI can help with frontend & accessibility.",
                'read_at' => now()->subDays(2),
                'admin_reply' => "Thanks for reaching out! Yes, let's discuss. Could you share your GitHub and availability?",
                'replied_at' => now()->subDays(2)->addHours(2),
                'ip_address' => '10.0.0.10',
                'user_agent' => 'Seeder',
            ]
        );

        ContactMessage::updateOrCreate(
            ['email' => 'recruiter@example.com', 'subject' => 'Question about your stack'],
            [
                'name' => 'Recruiter',
                'message' => "Hi! Quick question: do you have experience with CI/CD and Docker in production?",
                'read_at' => now()->subDays(1),
                'admin_reply' => null,
                'replied_at' => null,
                'ip_address' => '10.0.0.11',
                'user_agent' => 'Seeder',
            ]
        );

        // Seed realistic comment conversations across multiple news items
        $newsItems = NewsItem::query()->orderBy('id')->take(3)->get();
        if ($newsItems->count() === 0) {
            return;
        }

        $alice = $users->firstWhere('email', 'alice@example.com');
        $bob = $users->firstWhere('email', 'bob@example.com');
        $charlie = $users->firstWhere('email', 'charlie@example.com');

        // Thread 1: Approved comments
        $itemA = $newsItems[0];
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemA->id, 'user_id' => $alice->id, 'body' => 'Nice update! The UI looks much cleaner now.'],
            ['is_approved' => true, 'approved_at' => now()->subDays(3)]
        );
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemA->id, 'user_id' => $bob->id, 'body' => "Agreed. Also love the language toggle—how are you handling persistence?"],
            ['is_approved' => true, 'approved_at' => now()->subDays(3)]
        );
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemA->id, 'user_id' => $charlie->id, 'body' => "The new admin styles are really solid. Especially the tables and action buttons."],
            ['is_approved' => true, 'approved_at' => now()->subDays(2)]
        );

        // Thread 2: Mixed approval (for moderation view)
        $itemB = $newsItems->count() > 1 ? $newsItems[1] : $newsItems[0];
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemB->id, 'user_id' => $alice->id, 'body' => 'Could you add more details on how the projects are stored/translatable?'],
            ['is_approved' => true, 'approved_at' => now()->subDays(1)]
        );
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemB->id, 'user_id' => $bob->id, 'body' => 'This is awesome—please add a feature to edit skills inline in settings.'],
            ['is_approved' => false, 'approved_at' => null]
        );
        NewsComment::updateOrCreate(
            ['news_item_id' => $itemB->id, 'user_id' => $charlie->id, 'body' => 'One thought: add rate limiting to the contact form to prevent spam.'],
            ['is_approved' => true, 'approved_at' => now()->subDay()]
        );

        // Thread 3: Another moderation example
        if ($newsItems->count() > 2) {
            $itemC = $newsItems[2];
            NewsComment::updateOrCreate(
                ['news_item_id' => $itemC->id, 'user_id' => $bob->id, 'body' => 'The modal animations feel snappy. Nice work.'],
                ['is_approved' => true, 'approved_at' => now()->subHours(12)]
            );
            NewsComment::updateOrCreate(
                ['news_item_id' => $itemC->id, 'user_id' => $alice->id, 'body' => 'Can admins pin a news item to the top?'],
                ['is_approved' => false, 'approved_at' => null]
            );
        }
    }
}
