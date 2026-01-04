@extends('layouts.app')

@section('content')
<section class="public-profile">
    <div class="container">
        <div class="profile-hero">
            <div class="profile-avatar">
                @php
                    $photo = $user->profile_photo_path
                        ? asset('storage/'.$user->profile_photo_path)
                        : asset('images/profile.png');
                @endphp
                <img src="{{ $photo }}" alt="{{ $user->name }}">
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p class="profile-username">{{ $user->username }}</p>
                @if ($user->birthday)
                    <p class="profile-meta"><i class="fas fa-birthday-cake"></i> {{ $user->birthday->format('F j, Y') }}</p>
                @endif

                @if(!empty($isOwnProfile) && $isOwnProfile)
                    <div class="profile-actions">
                        <a class="btn btn-secondary" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit"></i> {{ __('Edit profile') }}
                        </a>
                        <a class="btn btn-secondary" href="{{ route('settings') }}">
                            <i class="fas fa-sliders-h"></i> {{ __('Settings') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if ($user->about)
            <div class="account-card">
                <section class="card-section">
                    <header class="card-header">
                        <h2><i class="fas fa-user"></i> {{ __('About') }}</h2>
                    </header>
                    <div class="card-body">
                        <p class="profile-bio">{{ $user->about }}</p>
                    </div>
                </section>
            </div>
        @endif

        @if ($user->skills && $user->skills->count())
            <div class="account-card skills-card">
                <section class="card-section">
                    <header class="card-header">
                        <h2><i class="fas fa-code"></i> {{ __('Skills') }}</h2>
                        <p>{{ __('What this user can do') }}</p>
                    </header>
                    <div class="card-body">
                        <div class="skills-grid">
                            @foreach($user->skills as $skill)
                                <div class="skill-card">
                                    <div class="skill-header">
                                        <div class="skill-icon">
                                            @php
                                                $iconMap = [
                                                    'programming' => 'fas fa-code',
                                                    'frontend' => 'fas fa-palette',
                                                    'backend' => 'fas fa-server',
                                                    'database' => 'fas fa-database',
                                                    'devops' => 'fas fa-cloud',
                                                    'design' => 'fas fa-paint-brush',
                                                    'mobile' => 'fas fa-mobile-alt',
                                                    'tools' => 'fas fa-wrench',
                                                    'soft skills' => 'fas fa-users',
                                                    'language' => 'fas fa-language',
                                                ];
                                                $category = strtolower($skill->category ?? '');
                                                $icon = $iconMap[$category] ?? 'fas fa-star';
                                            @endphp
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                        <div class="skill-title">
                                            <h3>{{ $skill->name }}</h3>
                                            @if($skill->category)
                                                <span class="skill-category">{{ $skill->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="skill-level">
                                        <div class="skill-level-bar">
                                            <div class="skill-level-fill" style="width: {{ ($skill->level / 5) * 100 }}%"></div>
                                        </div>
                                        <span class="skill-level-text">{{ $skill->level }}/5</span>
                                    </div>
                                    @if($skill->notes)
                                        <p class="skill-notes">{{ $skill->notes }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        @endif
    </div>
</section>
@endsection
