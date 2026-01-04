{{--
  Source attribution:
  - Original portfolio page derived from https://tombomeke.com (author: Tom Dekoning).
  - Modified/adapted for this Laravel Backend Web course project.
--}}

@extends('layouts.app')

@section('content')
<section class="games">
    <div class="container">
        <h1><i class="fas fa-gamepad"></i> <span data-translate="games_title"></span></h1>
        <div class="games-tabs">
            <button class="tab-btn active" data-tab="minecraft" data-translate="games_minecraft">
                <i class="fas fa-cube"></i> <span data-translate="games_minecraft"></span>
            </button>
            <button class="tab-btn" data-tab="r6siege" data-translate="games_r6siege">
                <i class="fas fa-crosshairs"></i> <span data-translate="games_r6siege"></span>
            </button>
        </div>

        <div class="tab-content active" id="minecraft">
            <div class="stats-card">
                <div class="stats-header">
                    <h2 data-translate="games_server_info"></h2>
                    <span class="status-badge {{ $minecraft['online'] ? 'online' : 'offline' }}" data-translate="status_{{ $minecraft['online'] ? 'online' : 'offline' }}">
                        <i class="fas fa-circle"></i>
                        <span></span>
                    </span>
                </div>

                <div class="server-info">
                    <p><strong data-translate="server_ip"></strong> {{ $minecraft['server_ip'] }}</p>
                    <p><strong data-translate="server_version"></strong> {{ $minecraft['version'] }}</p>
                    <p><strong data-translate="server_motd"></strong> {{ $minecraft['motd'] }}</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <span class="stat-number">{{ $minecraft['online_players'] }}/{{ $minecraft['max_players'] }}</span>
                            <span class="stat-label" data-translate="players_online"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <span class="stat-number">{{ $minecraft['uptime'] }}</span>
                            <span class="stat-label" data-translate="uptime"></span>
                        </div>
                    </div>
                </div>

                <h3 data-translate="games_top_players"><i class="fas fa-trophy"></i> <span data-translate="games_top_players"></span></h3>
                <div class="top-players">
                    @foreach($minecraft['top_players'] as $index => $player)
                        <div class="player-item">
                            <span class="rank">#{{ $index + 1 }}</span>
                            <span class="player-name">{{ $player['name'] }}</span>
                            <span class="player-rank">{{ $player['rank'] }}</span>
                            <span class="playtime">{{ $player['playtime'] }}</span>
                        </div>
                    @endforeach
                </div>

                <p class="last-update">
                    <i class="fas fa-sync-alt"></i>
                    <span data-translate="games_last_update"></span> {{ date('d-m-Y H:i', $minecraft['last_update']) }}
                </p>
            </div>
        </div>

        <div class="tab-content" id="r6siege">
            <div class="stats-card">
                <div class="stats-header">
                    <h2 data-translate="games_player_stats"></h2>
                    <span class="platform-badge">
                        <i class="fas fa-desktop"></i> {{ $r6siege['platform'] }}
                    </span>
                </div>

                <div class="player-info">
                    <p><strong data-translate="username"></strong> {{ $r6siege['username'] }}</p>
                    <p><strong data-translate="level"></strong> {{ $r6siege['level'] }}</p>
                    <p><strong data-translate="playtime"></strong> {{ $r6siege['playtime'] }}</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <i class="fas fa-trophy"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['current_rank'] }}</span>
                            <span class="stat-label" data-translate="current_rank"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-star"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['max_rank'] }}</span>
                            <span class="stat-label" data-translate="highest_rank"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-crosshairs"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['kd_ratio'] }}</span>
                            <span class="stat-label" data-translate="kd_ratio"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-percentage"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['win_rate'] }}</span>
                            <span class="stat-label" data-translate="win_rate"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-chart-line"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['mmr'] }}</span>
                            <span class="stat-label" data-translate="mmr"></span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-user-shield"></i>
                        <div>
                            <span class="stat-number">{{ $r6siege['favorite_operator'] }}</span>
                            <span class="stat-label" data-translate="favorite_operator"></span>
                        </div>
                    </div>
                </div>

                <div class="detailed-stats">
                    <h3 data-translate="detailed_stats"><i class="fas fa-chart-bar"></i> <span data-translate="detailed_stats"></span></h3>
                    <div class="stats-row">
                        <div class="stat-detail">
                            <span class="stat-value">{{ $r6siege['kills'] }}</span>
                            <span class="stat-name" data-translate="kills"></span>
                        </div>
                        <div class="stat-detail">
                            <span class="stat-value">{{ $r6siege['deaths'] }}</span>
                            <span class="stat-name" data-translate="deaths"></span>
                        </div>
                        <div class="stat-detail">
                            <span class="stat-value">{{ $r6siege['wins'] }}</span>
                            <span class="stat-name" data-translate="wins"></span>
                        </div>
                        <div class="stat-detail">
                            <span class="stat-value">{{ $r6siege['losses'] }}</span>
                            <span class="stat-name" data-translate="losses"></span>
                        </div>
                    </div>
                </div>

                <p class="last-update">
                    <i class="fas fa-sync-alt"></i>
                    <span data-translate="games_last_update"></span> {{ date('d-m-Y H:i', $r6siege['last_update']) }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
