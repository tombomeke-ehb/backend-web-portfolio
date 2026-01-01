<?php

namespace App\Models;

class SkillModel
{
    private array $education = [
        'nl' => [],
        'en' => [],
    ];

    private array $learningGoals = [
        'nl' => [],
        'en' => [],
    ];

    public function getAllSkills(): array
    {
        return [
            ['name' => 'PHP', 'level' => 1, 'category' => 'languages', 'notes' => 'Object-oriented, Laravel, API development', 'projects' => ['Portfolio Website', 'Laravel Project']],
            ['name' => 'Java', 'level' => 1, 'category' => 'languages', 'notes' => 'Minecraft plugins, Spring basics, Basic Projects', 'projects' => []],
            ['name' => 'JavaScript', 'level' => 1, 'category' => 'languages', 'notes' => 'ES6+, DOM manipulation, AJAX', 'projects' => ['Portfolio Website', 'Contract Companion', 'Lyrics Finder']],
            ['name' => 'Python', 'level' => 1, 'category' => 'languages', 'notes' => 'Learning fundamentals, automation scripts, Business Analytics', 'projects' => []],
            ['name' => 'SQL', 'level' => 2, 'category' => 'languages', 'notes' => 'Oracle, Database', 'projects' => ['Contract Companion']],
            ['name' => 'HTML/CSS', 'level' => 3, 'category' => 'languages', 'notes' => 'Semantic HTML, CSS Grid, Flexbox', 'projects' => ['Portfolio Website', 'Contract Companion']],
            ['name' => 'Laravel', 'level' => 1, 'category' => 'frameworks', 'notes' => 'Currently learning MVC patterns', 'projects' => []],
            ['name' => 'Vue.js', 'level' => 1, 'category' => 'frameworks', 'notes' => 'Learning reactive programming', 'projects' => ['Contract Companion']],
            ['name' => 'Spigot/Bukkit', 'level' => 1, 'category' => 'frameworks', 'notes' => 'Advanced plugin development', 'projects' => []],
            ['name' => 'Git', 'level' => 3, 'category' => 'tools', 'notes' => 'Version control, branching, collaboration', 'projects' => ['All projects']],
            ['name' => 'Linux', 'level' => 1, 'category' => 'tools', 'notes' => 'Server management, bash scripting', 'projects' => []],
            ['name' => 'VS Code', 'level' => 3, 'category' => 'tools', 'notes' => 'Extensions, debugging, Git integration', 'projects' => ['All projects']],
        ];
    }

    public function getLevelText(int $level): string
    {
        return match ($level) {
            1 => 'Beginner',
            2 => 'Intermediate',
            3 => 'Gevorderd',
            default => 'Unknown',
        };
    }

    public function getLevelPercentage(int $level): float
    {
        return ($level / 3) * 100;
    }

    public function getModalData(array $skill): array
    {
        return $skill;
    }

    public function getEducation(string $lang = 'nl'): array
    {
        return $this->education[$lang] ?? [];
    }

    public function getLearningGoals(string $lang = 'nl'): array
    {
        return $this->learningGoals[$lang] ?? [];
    }

    public function buildEducationModalData($item, int $index): array
    {
        return $this->normalizeEducationItem($item, $index);
    }

    public function buildLearningModalData($item, int $index): array
    {
        return $this->normalizeLearningItem($item, $index);
    }

    private function normalizeEducationItem($item, int $index): array
    {
        if (!is_array($item)) {
            $item = ['title' => $item];
        }

        $skills = $item['skills'] ?? [];

        return [
            'id' => $index,
            'title' => $item['title'] ?? ($item['title_key'] ?? ''),
            'institution' => $item['institution'] ?? ($item['institution_key'] ?? ''),
            'period' => $item['period'] ?? ($item['period_key'] ?? ''),
            'description' => $item['description'] ?? ($item['description_key'] ?? ''),
            'skills' => $skills,
            'certificate_url' => $item['certificate_url'] ?? '',
        ];
    }

    private function normalizeLearningItem($item, int $index): array
    {
        if (!is_array($item)) {
            $item = ['title' => $item];
        }

        return [
            'id' => $index,
            'title' => $item['title'] ?? ($item['title_key'] ?? ''),
            'description' => $item['description'] ?? ($item['description_key'] ?? ''),
            'progress' => $item['progress'] ?? null,
            'resources' => $item['resources'] ?? [],
            'timeline' => $item['timeline'] ?? ($item['timeline_key'] ?? ''),
        ];
    }
}
