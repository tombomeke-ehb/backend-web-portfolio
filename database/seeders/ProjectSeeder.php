<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $p1 = Project::updateOrCreate(
            ['slug' => 'rpg-manager'],
            [
                'category' => 'cli',
                'status' => 'development',
                'repo_url' => 'https://github.com/tombomeke-ehb/RPGManager',
                'demo_url' => 'https://github.com/tombomeke-ehb/RPGManager/releases/latest/',
                'image_path' => null,
                'tech' => ['C#', '.NET', 'Console Application'],
                'sort_order' => 0,
            ]
        );
        $p1->translations()->updateOrCreate(
            ['lang' => 'nl'],
            [
                'title' => 'RPG Manager',
                'description' => 'RPG Manager is een console-based role-playing game framework in C# met een modulair systeem voor werelden, locaties, helden en wapens.',
                'long_description' => 'Het project bestaat uit namespaces zoals Characters, Weapons, Worlds, Locations, UI en Saves. Spelers maken helden, kiezen wapens en verkennen werelden.',
                'features' => [
                    'Modulaire architectuur',
                    'JSON-opslaan en laden',
                    'Uitbreidbare wereld/locatie-structuur',
                ],
            ]
        );
        $p1->translations()->updateOrCreate(
            ['lang' => 'en'],
            [
                'title' => 'RPG Manager',
                'description' => 'RPG Manager is a console-based role-playing game framework in C# featuring a modular system for worlds, locations, heroes and weapons.',
                'long_description' => 'The project is organized into namespaces like Characters, Weapons, Worlds, Locations, UI, and Saves. Players create heroes, choose weapons, and explore worlds.',
                'features' => [
                    'Modular architecture',
                    'JSON save/load',
                    'Extensible world/location structure',
                ],
            ]
        );

        $p2 = Project::updateOrCreate(
            ['slug' => 'portfolio-website'],
            [
                'category' => 'web',
                'status' => 'active',
                'repo_url' => 'https://github.com/tombomeke/portfolio',
                'demo_url' => 'https://tombomeke.com',
                'image_path' => null,
                'tech' => ['PHP', 'JavaScript', 'CSS'],
                'sort_order' => 1,
            ]
        );
        $p2->translations()->updateOrCreate(
            ['lang' => 'nl'],
            [
                'title' => 'Portfolio Website',
                'description' => 'Responsive portfolio website met PHP en moderne CSS. Project showcase, skills en contactformulier.',
                'long_description' => 'Portfolio met eigen MVC-architectuur, modals, meertaligheid (NL/EN) en responsive design.',
                'features' => [
                    'Meertalige ondersteuning (NL/EN)',
                    'Universeel modal systeem',
                    'Responsive design',
                ],
            ]
        );
        $p2->translations()->updateOrCreate(
            ['lang' => 'en'],
            [
                'title' => 'Portfolio Website',
                'description' => 'Responsive portfolio website built with PHP and modern CSS. Project showcase, skills and contact form.',
                'long_description' => 'Portfolio with custom MVC architecture, modals, multilingual (NL/EN) and responsive design.',
                'features' => [
                    'Multi-language support (NL/EN)',
                    'Universal modal system',
                    'Responsive design',
                ],
            ]
        );
    }
}
