<?php

namespace App\Models;

class ProjectModel
{
    public function getAllProjects(): array
    {
        $lang = 'nl'; // later we can hook this into Laravel localization

        $projectsData = [
            [
                'id' => 1,
                'title' => 'RPG Manager',
                'description' => [
                    'nl' => 'RPG Manager is een console-based role-playing game framework in C# met een modulair systeem voor werelden, locaties, helden en wapens.',
                    'en' => 'RPG Manager is a console-based role-playing game framework in C# featuring a modular system for worlds, locations, heroes and weapons.',
                ],
                'long_description' => [
                    'nl' => 'Het project bestaat uit namespaces zoals Characters, Weapons, Worlds, Locations, UI en Saves. Spelers maken helden, kiezen wapens en verkennen werelden.',
                    'en' => 'The project is organized into namespaces like Characters, Weapons, Worlds, Locations, UI, and Saves. Players create heroes, choose weapons, and explore worlds.',
                ],
                'tech' => ['C#', '.NET', 'Object-Oriented Design', 'System.Text.Json', 'Console Application'],
                'repo_url' => 'https://github.com/tombomeke-ehb/RPGManager',
                'demo_url' => 'https://github.com/tombomeke-ehb/RPGManager/releases/latest/',
                'image' => asset('images/projects/p1.png'),
                'category' => 'cli',
                'status' => 'development',
                'features' => [
                    'nl' => [
                        'Modulaire architectuur',
                        'JSON-opslaan en laden',
                        'Wapenrarity & upgrades',
                        'Heldensysteem met levels',
                        'Uitbreidbare wereld/locatie-structuur',
                    ],
                    'en' => [
                        'Modular architecture',
                        'JSON save/load',
                        'Weapon rarity & upgrades',
                        'Hero system with levels',
                        'Extensible world/location structure',
                    ],
                ],
            ],
            [
                'id' => 2,
                'title' => 'Portfolio Website',
                'description' => [
                    'nl' => 'Responsive portfolio website met PHP en moderne CSS. Project showcase, skills en contactformulier.',
                    'en' => 'Responsive portfolio website built with PHP and modern CSS. Project showcase, skills and contact form.',
                ],
                'long_description' => [
                    'nl' => 'Portfolio met eigen MVC-architectuur, modals, meertaligheid (NL/EN) en responsive design.',
                    'en' => 'Portfolio with custom MVC architecture, modals, multilingual (NL/EN) and responsive design.',
                ],
                'tech' => ['PHP', 'JavaScript', 'CSS Grid', 'HTML5'],
                'repo_url' => 'https://github.com/tombomeke/portfolio',
                'demo_url' => 'https://tomdekoning.nl',
                'image' => asset('images/projects/p2.png'),
                'category' => 'web',
                'status' => 'active',
                'features' => [
                    'nl' => [
                        'Meertalige ondersteuning (NL/EN)',
                        'Universeel modal systeem',
                        'Responsive design',
                        'Contactformulier met validatie',
                        'Dark theme',
                    ],
                    'en' => [
                        'Multi-language support (NL/EN)',
                        'Universal modal system',
                        'Responsive design',
                        'Contact form with validation',
                        'Dark theme',
                    ],
                ],
            ],
        ];

        $projects = [];
        foreach ($projectsData as $project) {
            $project['description'] = $project['description'][$lang];
            $project['long_description'] = $project['long_description'][$lang] ?? $project['description'];
            $project['features'] = $project['features'][$lang] ?? [];
            $projects[] = $project;
        }

        return $projects;
    }

    public function getModalData(array $project): string
    {
        return htmlspecialchars(json_encode($project), ENT_QUOTES, 'UTF-8');
    }
}
