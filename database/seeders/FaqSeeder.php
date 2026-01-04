<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $general = FaqCategory::updateOrCreate(
            ['slug' => 'general'],
            ['slug' => 'general', 'sort_order' => 0]
        );
        $general->translations()->updateOrCreate(['lang' => 'en'], ['name' => 'General']);
        $general->translations()->updateOrCreate(['lang' => 'nl'], ['name' => 'Algemeen']);

        $account = FaqCategory::updateOrCreate(
            ['slug' => 'account'],
            ['slug' => 'account', 'sort_order' => 1]
        );
        $account->translations()->updateOrCreate(['lang' => 'en'], ['name' => 'Account']);
        $account->translations()->updateOrCreate(['lang' => 'nl'], ['name' => 'Account']);

        $item1 = FaqItem::updateOrCreate(
            ['faq_category_id' => $general->id, 'sort_order' => 0],
            ['faq_category_id' => $general->id, 'sort_order' => 0]
        );
        $item1->translations()->updateOrCreate(
            ['lang' => 'en'],
            ['question' => 'What is this site?', 'answer' => 'This is a Laravel portfolio project with news, FAQ and account features.']
        );
        $item1->translations()->updateOrCreate(
            ['lang' => 'nl'],
            ['question' => 'Wat is deze site?', 'answer' => 'Dit is een Laravel portfolio project met news, FAQ en account features.']
        );

        $item2 = FaqItem::updateOrCreate(
            ['faq_category_id' => $account->id, 'sort_order' => 0],
            ['faq_category_id' => $account->id, 'sort_order' => 0]
        );
        $item2->translations()->updateOrCreate(
            ['lang' => 'en'],
            ['question' => 'How do I change my profile?', 'answer' => 'After logging in, go to Profile and update your details.']
        );
        $item2->translations()->updateOrCreate(
            ['lang' => 'nl'],
            ['question' => 'Hoe pas ik mijn profiel aan?', 'answer' => 'Na login ga je naar Profiel en pas je je gegevens aan.']
        );

        // Extra categories
        $projects = FaqCategory::updateOrCreate(
            ['slug' => 'projects'],
            ['slug' => 'projects', 'sort_order' => 2]
        );
        $projects->translations()->updateOrCreate(['lang' => 'en'], ['name' => 'Projects']);
        $projects->translations()->updateOrCreate(['lang' => 'nl'], ['name' => 'Projecten']);

        $tech = FaqCategory::updateOrCreate(
            ['slug' => 'tech'],
            ['slug' => 'tech', 'sort_order' => 3]
        );
        $tech->translations()->updateOrCreate(['lang' => 'en'], ['name' => 'Tech & Stack']);
        $tech->translations()->updateOrCreate(['lang' => 'nl'], ['name' => 'Technologie & Stack']);

        $items = [
            [
                'category' => 'general',
                'sort_order' => 1,
                'en' => [
                    'q' => 'Why do I need an account?',
                    'a' => 'Some sections are protected so you can see personalized content and keep the site safe from spam.',
                ],
                'nl' => [
                    'q' => 'Waarom heb ik een account nodig?',
                    'a' => 'Sommige pagina’s zijn beschermd zodat je gepersonaliseerde content ziet en de site beschermd blijft tegen spam.',
                ],
            ],
            [
                'category' => 'account',
                'sort_order' => 1,
                'en' => [
                    'q' => 'I forgot my password. What now?',
                    'a' => 'Use the password reset link on the login page. You will receive an email with reset instructions.',
                ],
                'nl' => [
                    'q' => 'Ik ben mijn wachtwoord vergeten. Wat nu?',
                    'a' => 'Gebruik de password reset link op de login pagina. Je krijgt een email met instructies om te resetten.',
                ],
            ],
            [
                'category' => 'projects',
                'sort_order' => 0,
                'en' => [
                    'q' => 'Can I view the source code of projects?',
                    'a' => 'Yes. Many projects include a GitHub link in the project modal under “View on GitHub”.',
                ],
                'nl' => [
                    'q' => 'Kan ik de source code van projecten bekijken?',
                    'a' => 'Ja. Veel projecten hebben een GitHub link in de project modal onder “Bekijk op GitHub”.',
                ],
            ],
            [
                'category' => 'projects',
                'sort_order' => 1,
                'en' => [
                    'q' => 'Why do some projects not have a demo link?',
                    'a' => 'Some projects are libraries/CLI tools or private deployments. In that case only the repository is available.',
                ],
                'nl' => [
                    'q' => 'Waarom hebben sommige projecten geen demo link?',
                    'a' => 'Sommige projecten zijn libraries/CLI tools of private deployments. Dan is alleen de repository beschikbaar.',
                ],
            ],
            [
                'category' => 'tech',
                'sort_order' => 0,
                'en' => [
                    'q' => 'Which tech do you use most?',
                    'a' => 'Mostly PHP (Laravel), JavaScript, and modern CSS. For tooling: Git, Docker and CI workflows.',
                ],
                'nl' => [
                    'q' => 'Welke technologie gebruik je het meest?',
                    'a' => 'Vooral PHP (Laravel), JavaScript en moderne CSS. Voor tooling: Git, Docker en CI workflows.',
                ],
            ],
            [
                'category' => 'tech',
                'sort_order' => 1,
                'en' => [
                    'q' => 'Do you use a translation package?',
                    'a' => 'For content we store translations in separate tables (NL/EN). UI strings use a simple translation map.',
                ],
                'nl' => [
                    'q' => 'Gebruik je een translation package?',
                    'a' => 'Voor content slaan we vertalingen op in aparte tabellen (NL/EN). UI-teksten gebruiken een eenvoudige translation map.',
                ],
            ],
        ];

        $catMap = [
            'general' => $general,
            'account' => $account,
            'projects' => $projects,
            'tech' => $tech,
        ];

        foreach ($items as $row) {
            $category = $catMap[$row['category']];

            $item = FaqItem::updateOrCreate(
                ['faq_category_id' => $category->id, 'sort_order' => (int) $row['sort_order']],
                ['faq_category_id' => $category->id, 'sort_order' => (int) $row['sort_order']]
            );

            $item->translations()->updateOrCreate(
                ['lang' => 'en'],
                ['question' => $row['en']['q'], 'answer' => $row['en']['a']]
            );
            $item->translations()->updateOrCreate(
                ['lang' => 'nl'],
                ['question' => $row['nl']['q'], 'answer' => $row['nl']['a']]
            );
        }
    }
}
