<?php

namespace Database\Seeders;

use App\Models\NewsItem;
use Illuminate\Database\Seeder;

class NewsItemSeeder extends Seeder
{
    public function run(): void
    {
        $item1 = NewsItem::firstOrCreate(
            ['published_at' => now()->subDays(7)],
            ['image_path' => null]
        );
        $item1->translations()->updateOrCreate(
            ['lang' => 'en'],
            [
                'title' => 'Project started',
                'content' => "This portfolio project was started using Laravel and a custom CSS layout.\n\nNext up: News, FAQ and contact improvements.",
            ]
        );
        $item1->translations()->updateOrCreate(
            ['lang' => 'nl'],
            [
                'title' => 'Project gestart',
                'content' => "Dit portfolio project is gestart met Laravel en een custom CSS layout.\n\nVolgende: News, FAQ en contact verbeteringen.",
            ]
        );

        $item2 = NewsItem::firstOrCreate(
            ['published_at' => now()->subDays(2)],
            ['image_path' => null]
        );
        $item2->translations()->updateOrCreate(
            ['lang' => 'en'],
            [
                'title' => 'Admin panel improvements',
                'content' => "Admins can now manage users from the admin panel, including role changes.\n\nNews items management is now in progress.",
            ]
        );
        $item2->translations()->updateOrCreate(
            ['lang' => 'nl'],
            [
                'title' => 'Admin paneel verbeteringen',
                'content' => "Admins kunnen nu users beheren via het admin paneel, inclusief rol wijzigingen.\n\nNews beheer is nu in ontwikkeling.",
            ]
        );

        $items = [
            [
                'published_at' => now()->subDays(14),
                'en' => [
                    'title' => 'New Projects page launched',
                    'content' => "The Projects page is now backed by the database and supports NL/EN translations.\n\nNext: improve filtering and add a featured-project highlight.",
                ],
                'nl' => [
                    'title' => 'Nieuwe projectenpagina gelanceerd',
                    'content' => "De projectenpagina is nu gekoppeld aan de database en ondersteunt NL/EN vertalingen.\n\nVolgende stap: filtering verbeteren en een featured-project highlight toevoegen.",
                ],
            ],
            [
                'published_at' => now()->subDays(10),
                'en' => [
                    'title' => 'Translation system update',
                    'content' => "A new translation-table approach was introduced for content (News/FAQ/Projects).\n\nAdmins can now maintain both Dutch and English text in the admin panel.",
                ],
                'nl' => [
                    'title' => 'Update aan het vertalingssysteem',
                    'content' => "Er is een nieuwe vertaal-structuur toegevoegd voor content (News/FAQ/Projects).\n\nAdmins kunnen nu zowel Nederlandse als Engelse tekst beheren in het admin panel.",
                ],
            ],
            [
                'published_at' => now()->subDays(6),
                'en' => [
                    'title' => 'Performance improvements',
                    'content' => "Pages have been optimized by eager-loading translations and reducing duplicate CSS rules.\n\nResult: faster loads and fewer UI glitches.",
                ],
                'nl' => [
                    'title' => 'Performance verbeteringen',
                    'content' => "Pagina’s zijn geoptimaliseerd door translations eager-loading te gebruiken en dubbele CSS regels op te kuisen.\n\nResultaat: snellere laadtijden en minder UI problemen.",
                ],
            ],
            [
                'published_at' => now()->subDays(4),
                'en' => [
                    'title' => 'Admin: Projects CRUD available',
                    'content' => "The admin panel now includes a full Projects manager.\n\nYou can add screenshots, tech stacks, demo links and GitHub links.",
                ],
                'nl' => [
                    'title' => 'Admin: Projects beheer beschikbaar',
                    'content' => "Het admin panel bevat nu een volledige Projects manager.\n\nJe kan screenshots, tech stack, demo links en GitHub links toevoegen.",
                ],
            ],
            [
                'published_at' => now()->subDays(1),
                'en' => [
                    'title' => 'Roadmap',
                    'content' => "Planned additions:\n- Tags translations\n- Skills management\n- Better modal animations\n- More game stats\n\nStay tuned.",
                ],
                'nl' => [
                    'title' => 'Roadmap',
                    'content' => "Geplande toevoegingen:\n- Tags vertalingen\n- Skills beheer\n- Betere modal animaties\n- Meer game stats\n\nWordt vervolgd.",
                ],
            ],
        ];

        foreach ($items as $row) {
            $newsItem = NewsItem::firstOrCreate(
                ['published_at' => $row['published_at']],
                ['image_path' => null]
            );

            $newsItem->translations()->updateOrCreate(
                ['lang' => 'en'],
                ['title' => $row['en']['title'], 'content' => $row['en']['content']]
            );
            $newsItem->translations()->updateOrCreate(
                ['lang' => 'nl'],
                ['title' => $row['nl']['title'], 'content' => $row['nl']['content']]
            );
        }
    }
}
