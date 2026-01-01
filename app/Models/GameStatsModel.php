<?php

namespace App\Models;

class GameStatsModel
{
    private string $cacheFile;
    private int $cacheExpiry = 300; // 5 minutes

    public function __construct()
    {
        $this->cacheFile = storage_path('app/game_stats.json');
    }

    public function getMinecraftStats(): array
    {
        $cached = $this->getCachedData('minecraft');
        if ($cached) {
            return $cached;
        }

        $stats = [
            'server_name' => 'JouwServer.nl',
            'server_ip' => 'play.jouwserver.nl',
            'online' => true,
            'online_players' => rand(8, 25),
            'max_players' => 50,
            'uptime' => '99.8%',
            'version' => '1.20.1',
            'motd' => 'Welkom op JouwServer!',
            'top_players' => [
                ['name' => 'PlayerOne', 'playtime' => '245h', 'rank' => 'Admin'],
                ['name' => 'BuilderPro', 'playtime' => '198h', 'rank' => 'Moderator'],
                ['name' => 'RedstoneGuru', 'playtime' => '156h', 'rank' => 'VIP'],
                ['name' => 'PvPMaster', 'playtime' => '134h', 'rank' => 'Member'],
                ['name' => 'Miner2023', 'playtime' => '112h', 'rank' => 'Member'],
            ],
            'last_update' => time(),
        ];

        $this->cacheData('minecraft', $stats);
        return $stats;
    }

    public function getR6Stats(): array
    {
        $cached = $this->getCachedData('r6siege');
        if ($cached) {
            return $cached;
        }

        $stats = [
            'username' => 'JouwGamertag',
            'platform' => 'PC',
            'uplay_id' => 'jouw-uplay-id',
            'current_rank' => 'Gold II',
            'max_rank' => 'Platinum III',
            'mmr' => '2567',
            'kd_ratio' => '1.23',
            'win_rate' => '54.2%',
            'kills' => '3456',
            'deaths' => '2801',
            'wins' => '543',
            'losses' => '459',
            'level' => 156,
            'playtime' => '487h',
            'favorite_operator' => 'Ash',
            'last_update' => time(),
        ];

        $this->cacheData('r6siege', $stats);
        return $stats;
    }

    private function getCachedData(string $type): ?array
    {
        if (!file_exists($this->cacheFile)) {
            return null;
        }

        $cache = json_decode(file_get_contents($this->cacheFile), true);
        if (!$cache || !isset($cache[$type])) {
            return null;
        }

        if (time() - $cache[$type]['last_update'] > $this->cacheExpiry) {
            return null;
        }

        return $cache[$type];
    }

    private function cacheData(string $type, array $data): void
    {
        $cache = [];
        if (file_exists($this->cacheFile)) {
            $cache = json_decode(file_get_contents($this->cacheFile), true) ?? [];
        }

        $dir = dirname($this->cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $cache[$type] = $data;
        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
}
