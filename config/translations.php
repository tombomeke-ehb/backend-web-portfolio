<?php
// config/translations.php
return [
    'nl' => [
        // Navigation
        'nav_about' => 'About',
        'nav_devlife' => 'Dev Life',
        'nav_games' => 'Games',
        'nav_projects' => 'Projecten',
        'nav_contact' => 'Contact',

        // Hero Section
        'hero_greeting' => 'Hoi, ik ben',
        'hero_intro' => 'Full-stack developer met passie voor gaming en open source projecten. Gespecialiseerd in PHP, JavaScript en Minecraft plugin development.',
        'hero_view_work' => 'Bekijk mijn werk',
        'hero_download_cv' => 'Download CV',

        // Skills Section
        'skills_title' => 'Skills & Technologieën',
        'skills_level_beginner' => 'Leer',
        'skills_level_intermediate' => 'Basis',
        'skills_level_advanced' => 'Goed',
        'skills_click_details' => 'Klik voor meer details',

        // Skills Modal
        'modal_skill_level' => 'Niveau',
        'modal_skill_category' => 'Categorie',
        'modal_skill_experience' => 'Ervaring',
        'modal_skill_projects' => 'Gebruikte Projecten',
        'modal_close' => 'Sluiten',

        // Projects Section
        'projects_title' => 'Mijn Projecten',
        'projects_intro' => 'Een overzicht van mijn recente projecten en bijdragen',
        'projects_filter_all' => 'Alle',
        'projects_filter_minecraft' => 'Minecraft',
        'projects_filter_web' => 'Web',
        'projects_filter_api' => 'API',
        'projects_filter_cli' => 'CLI',
        'projects_view_code' => 'Code',
        'projects_view_demo' => 'Demo',
        'projects_click_details' => 'Klik voor meer details',

        // Projects Modal
        'modal_project_tech' => 'Technologieën',
        'modal_project_features' => 'Features',
        'modal_project_github' => 'Bekijk op GitHub',
        'modal_project_demo' => 'Live Demo',
        'modal_project_status' => 'Status',
        'modal_project_status_active' => 'Actief',
        'modal_project_status_completed' => 'Afgerond',
        'modal_project_status_development' => 'In Ontwikkeling',

        // Project-specific translations (NL)
        'project_title_1' => 'RPG Manager',
        'project_description_1' => 'RPG Manager is een console-based role-playing game framework in C# met een modulair systeem voor werelden, locaties, helden en wapens.',
        'project_long_description_1' => 'Het project bestaat uit namespaces zoals Characters, Weapons, Worlds, Locations, UI en Saves. Spelers maken helden, kiezen wapens en verkennen werelden.',
        'project_features_1' => [
            'Modulaire architectuur',
            'JSON-opslaan en laden',
            'Wapenrarity & upgrades',
            'Heldensysteem met levels',
            'Uitbreidbare wereld/locatie-structuur',
        ],
        'project_title_2' => 'Portfolio Website',
        'project_description_2' => 'Responsive portfolio website met PHP en moderne CSS. Project showcase, skills en contactformulier.',
        'project_long_description_2' => 'Portfolio met eigen MVC-architectuur, modals, meertaligheid (NL/EN) en responsive design.',
        'project_features_2' => [
            'Meertalige ondersteuning (NL/EN)',
            'Universeel modal systeem',
            'Responsive design',
            'Contactformulier met validatie',
            'Dark theme',
        ],
        'contact_download_cv' => 'Download CV (PDF)',

        // Education Section
        'education_title' => 'Opleiding & Certificaten',
        'education_click_details' => 'Klik voor meer details',
        // Education content keys (voorbeeld)
        'education_hbo_title' => 'HBO ICT - Hogeschool van Amsterdam (2023-heden)',
        'education_hbo_inst' => 'Hogeschool van Amsterdam',
        'education_hbo_period' => '2023-heden',
        'education_hbo_desc' => 'Uitgebreide opleiding met focus op softwareontwikkeling en best practices.',
        'education_hbo_skill_arch' => 'Software Architectuur',

        // Education Modal
        'modal_education_institution' => 'Instelling',
        'modal_education_period' => 'Periode',
        'modal_education_description' => 'Beschrijving',
        'modal_education_skills' => 'Opgedane Skills',

        // Learning Goals Section
        'learning_title' => 'Huidige Leerdoelen',
        'learning_click_details' => 'Klik voor meer details',
        // Learning content keys (voorbeeld)
        'learning_laravel_title' => 'Laravel Framework diepgaand leren',
        'learning_laravel_desc' => 'Van routing en Eloquent tot queues, testing en deployment.',
        'learning_laravel_timeline' => '3-6 maanden',
        'learning_resource_docs' => 'Officiële documentatie',

        // Learning Modal
        'modal_learning_goal' => 'Leerdoel',
        'modal_learning_progress' => 'Voortgang',
        'modal_learning_resources' => 'Bronnen',
        'modal_learning_timeline' => 'Tijdlijn',

        // Contact Section
        'contact_title' => 'Contact',
        'contact_intro' => 'Heb je een vraag of wil je samenwerken? Stuur me een bericht!',
        'contact_send_message' => 'Stuur me een bericht',
        'contact_name' => 'Naam',
        'contact_name_placeholder' => 'Jouw naam',
        'contact_email' => 'E-mail',
        'contact_email_placeholder' => 'jouw@email.com',
        'contact_message' => 'Bericht',
        'contact_message_placeholder' => 'Jouw bericht...',
        'contact_send' => 'Verzenden',
        'contact_success' => 'Bericht succesvol verzonden! Ik neem zo snel mogelijk contact met je op.',
        'contact_error' => 'Er is een fout opgetreden bij het verzenden.',
        'contact_direct' => 'Direct contact',
        'contact_methods_intro' => 'Je kunt me ook direct bereiken via onderstaande kanalen:',
        'contact_view_profile' => 'Bekijk profiel',
        'contact_view_repositories' => 'Bekijk repositories',
        'contact_view_cv' => 'Bekijk mijn CV',
        'contact_cv_description' => 'Download mijn volledige CV voor meer informatie.',
        'contact_availability_title' => 'Beschikbaarheid',
        'contact_availability_freelance' => 'Beschikbaar voor freelance opdrachten',
        'contact_availability_collaboration' => 'Open voor samenwerkingen aan projecten',
        'contact_availability_response' => 'Ik probeer binnen 2 werkdagen te antwoorden',

        // Form Validation
        'form_required' => 'Dit veld is verplicht',
        'form_email_invalid' => 'Voer een geldig e-mailadres in',
        'form_name_short' => 'Naam moet minimaal 2 karakters bevatten',
        'form_message_short' => 'Bericht moet minimaal 10 karakters bevatten',

        // Footer
        'footer_rights' => 'Alle rechten voorbehouden',

        // 404 Page
        'error_404_title' => 'Pagina niet gevonden',
        'error_404_message' => 'Sorry, de pagina die je zoekt bestaat niet of is verplaatst.',
        'error_404_home' => 'Terug naar Home',
        'error_404_suggestions' => 'Misschien zoek je:',

        // WIP Page
        'wip_page_title' => 'Work in progress',
        'wip_heading' => 'Bijna klaar',
        'wip_intro' => 'Ik ben bezig met {page}. Binnenkort staat hier meer.',
        'wip_secondary' => 'In de tussentijd kun je mijn projecten bekijken of mij direct een bericht sturen.',
        'wip_status_badge' => 'In ontwikkeling',
        'wip_back_home' => 'Terug naar home',
        'wip_view_projects' => 'Bekijk projecten',
        'wip_contact' => 'Plan een gesprek',
        'wip_feedback' => 'Heb je specifieke wensen? Laat het me weten, dan neem ik het mee.',
        'wip_default_page_name' => 'deze pagina',

        // Games Section
        'games_title' => 'Gaming stats',
        'games_minecraft' => 'Minecraft',
        'games_r6siege' => 'Rainbow Six Siege',
        'games_server_info' => 'Server Info',
        'games_player_stats' => 'Speler Statistieken',
        'games_top_players' => 'Top spelers',
        'games_last_update' => 'Laatst bijgewerkt:',
        'uptime' => 'Uptime',
        'players_online' => 'Spelers online',
        'server_ip' => 'IP:',
        'server_version' => 'Versie:',
        'server_motd' => 'MOTD:',
        'current_rank' => 'Huidige rank',
        'highest_rank' => 'Hoogste rank',
        'kd_ratio' => 'K/D ratio',
        'win_rate' => 'Winrate',
        'mmr' => 'MMR',
        'favorite_operator' => 'Favoriete operator',
        'detailed_stats' => 'Gedetailleerde statistieken',
        'kills' => 'Kills',
        'deaths' => 'Deaths',
        'wins' => 'Wins',
        'losses' => 'Losses',

        // Categories
        'category_languages' => 'Talen',
        'category_frameworks' => 'Frameworks',
        'category_database' => 'Database',
        'category_tools' => 'Tools',

        // General
        'loading' => 'Laden...',
        'read_more' => 'Lees meer',
        'view_all' => 'Bekijk alles',
        'close' => 'Sluiten',
        'open' => 'Openen',
        'download' => 'Download',
        'copied' => 'Gekopieerd!',

        // About Page
        'about_intro' => 'Welkom op mijn portfolio! Dit is de centrale plek voor mijn projecten, skills, nieuws en meer. Ontdek wie ik ben, wat ik doe en neem gerust contact op!',
    ],

    'en' => [
        // Navigation
        'nav_about' => 'About',
        'nav_devlife' => 'Dev Life',
        'nav_games' => 'Games',
        'nav_projects' => 'Projects',
        'nav_contact' => 'Contact',

        // Hero Section
        'hero_greeting' => 'Hi, I\'m',
        'hero_intro' => 'Full-stack developer with a passion for gaming and open source projects. Specialized in PHP, JavaScript and Minecraft plugin development.',
        'hero_view_work' => 'View my work',
        'hero_download_cv' => 'Download CV',

        // Skills Section
        'skills_title' => 'Skills & Technologies',
        'skills_level_beginner' => 'Learning',
        'skills_level_intermediate' => 'Intermediate',
        'skills_level_advanced' => 'Advanced',
        'skills_click_details' => 'Click for more details',

        // Skills Modal
        'modal_skill_level' => 'Level',
        'modal_skill_category' => 'Category',
        'modal_skill_experience' => 'Experience',
        'modal_skill_projects' => 'Used in Projects',
        'modal_close' => 'Close',

        // Projects Section
        'projects_title' => 'My Projects',
        'projects_intro' => 'An overview of my recent projects and contributions',
        'projects_filter_all' => 'All',
        'projects_filter_minecraft' => 'Minecraft',
        'projects_filter_web' => 'Web',
        'projects_filter_api' => 'API',
        'projects_filter_cli' => 'CLI',
        'projects_view_code' => 'Code',
        'projects_view_demo' => 'Demo',
        'projects_click_details' => 'Click for more details',

        // Projects Modal
        'modal_project_tech' => 'Technologies',
        'modal_project_features' => 'Features',
        'modal_project_github' => 'View on GitHub',
        'modal_project_demo' => 'Live Demo',
        'modal_project_status' => 'Status',
        'modal_project_status_active' => 'Active',
        'modal_project_status_completed' => 'Completed',
        'modal_project_status_development' => 'In Development',

        // Project-specific translations (EN)
        'project_title_1' => 'RPG Manager',
        'project_description_1' => 'RPG Manager is a console-based role-playing game framework in C# featuring a modular system for worlds, locations, heroes and weapons.',
        'project_long_description_1' => 'The project is organized into namespaces like Characters, Weapons, Worlds, Locations, UI, and Saves. Players create heroes, choose weapons, and explore worlds.',
        'project_features_1' => [
            'Modular architecture',
            'JSON save/load',
            'Weapon rarity & upgrades',
            'Hero system with levels',
            'Extensible world/location structure',
        ],
        'project_title_2' => 'Portfolio Website',
        'project_description_2' => 'Responsive portfolio website built with PHP and modern CSS. Project showcase, skills and contact form.',
        'project_long_description_2' => 'Portfolio with custom MVC architecture, modals, multilingual (NL/EN) and responsive design.',
        'project_features_2' => [
            'Multi-language support (NL/EN)',
            'Universal modal system',
            'Responsive design',
            'Contact form with validation',
            'Dark theme',
        ],
        'contact_download_cv' => 'Download CV (PDF)',

        // Education Section
        'education_title' => 'Education & Certificates',
        'education_click_details' => 'Click for more details',
        // Education content keys (example)
        'education_hbo_title' => 'HBO ICT - University of Applied Sciences Amsterdam (2023-present)',
        'education_hbo_inst' => 'University of Applied Sciences Amsterdam',
        'education_hbo_period' => '2023-present',
        'education_hbo_desc' => 'Comprehensive program focused on software development and best practices.',
        'education_hbo_skill_arch' => 'Software Architecture',

        // Education Modal
        'modal_education_institution' => 'Institution',
        'modal_education_period' => 'Period',
        'modal_education_description' => 'Description',
        'modal_education_skills' => 'Skills Acquired',

        // Learning Goals Section
        'learning_title' => 'Current Learning Goals',
        'learning_click_details' => 'Click for more details',
        // Learning content keys (example)
        'learning_laravel_title' => 'Learn Laravel Framework in-depth',
        'learning_laravel_desc' => 'From routing and Eloquent to queues, testing, and deployment.',
        'learning_laravel_timeline' => '3-6 months',
        'learning_resource_docs' => 'Official documentation',

        // Learning Modal
        'modal_learning_goal' => 'Learning Goal',
        'modal_learning_progress' => 'Progress',
        'modal_learning_resources' => 'Resources',
        'modal_learning_timeline' => 'Timeline',

        // Contact Section
        'contact_title' => 'Contact',
        'contact_intro' => 'Have a question or want to collaborate? Send me a message!',
        'contact_send_message' => 'Send me a message',
        'contact_name' => 'Name',
        'contact_name_placeholder' => 'Your name',
        'contact_email' => 'Email',
        'contact_email_placeholder' => 'your@email.com',
        'contact_message' => 'Message',
        'contact_message_placeholder' => 'Your message...',
        'contact_send' => 'Send',
        'contact_success' => 'Message sent successfully! I\'ll get back to you as soon as possible.',
        'contact_error' => 'An error occurred while sending.',
        'contact_direct' => 'Direct Contact',
        'contact_methods_intro' => 'You can also reach me directly through these channels:',
        'contact_view_profile' => 'View profile',
        'contact_view_repositories' => 'View repositories',
        'contact_view_cv' => 'View my CV',
        'contact_cv_description' => 'Download my full CV for more information.',
        'contact_availability_title' => 'Availability',
        'contact_availability_freelance' => 'Available for freelance projects',
        'contact_availability_collaboration' => 'Open for project collaborations',
        'contact_availability_response' => 'I try to respond within 2 business days',

        // Form Validation
        'form_required' => 'This field is required',
        'form_email_invalid' => 'Please enter a valid email address',
        'form_name_short' => 'Name must be at least 2 characters',
        'form_message_short' => 'Message must be at least 10 characters',

        // Footer
        'footer_rights' => 'All rights reserved',

        // 404 Page
        'error_404_title' => 'Page not found',
        'error_404_message' => 'Sorry, the page you\'re looking for doesn\'t exist or has been moved.',
        'error_404_home' => 'Back to Home',
        'error_404_suggestions' => 'You might be looking for:',

        // WIP Page
        'wip_page_title' => 'Work in progress',
        'wip_heading' => 'Almost there',
        'wip_intro' => 'I\'m polishing the {page} page. New content is coming soon.',
        'wip_secondary' => 'In the meantime, feel free to browse my projects or drop me a message.',
        'wip_status_badge' => 'In progress',
        'wip_back_home' => 'Back to home',
        'wip_view_projects' => 'View projects',
        'wip_contact' => 'Schedule a chat',
        'wip_feedback' => 'Have requests? Let me know and I\'ll include them.',
        'wip_default_page_name' => 'this page',

        // Games Section
        'games_title' => 'Gaming stats',
        'games_minecraft' => 'Minecraft',
        'games_r6siege' => 'Rainbow Six Siege',
        'games_server_info' => 'Server Info',
        'games_player_stats' => 'Player Statistics',
        'games_top_players' => 'Top players',
        'games_last_update' => 'Last updated:',
        'uptime' => 'Uptime',
        'players_online' => 'Players online',
        'server_ip' => 'IP:',
        'server_version' => 'Version:',
        'server_motd' => 'MOTD:',
        'current_rank' => 'Current rank',
        'highest_rank' => 'Highest rank',
        'kd_ratio' => 'K/D ratio',
        'win_rate' => 'Winrate',
        'mmr' => 'MMR',
        'favorite_operator' => 'Favorite operator',
        'detailed_stats' => 'Detailed statistics',
        'kills' => 'Kills',
        'deaths' => 'Deaths',
        'wins' => 'Wins',
        'losses' => 'Losses',

        // Categories
        'category_languages' => 'Languages',
        'category_frameworks' => 'Frameworks',
        'category_database' => 'Database',
        'category_tools' => 'Tools',

        // General
        'loading' => 'Loading...',
        'read_more' => 'Read more',
        'view_all' => 'View all',
        'close' => 'Close',
        'open' => 'Open',
        'download' => 'Download',
        'copied' => 'Copied!',

        // About Page
        'about_intro' => 'Welcome to my portfolio! This is the central place for my projects, skills, news, and more. Discover who I am, what I do, and feel free to get in touch!',
    ]
];
