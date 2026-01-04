{{--
  Source attribution:
  - Original portfolio page derived from https://tombomeke.com (author: Tom Dekoning).
  - Modified/adapted for this Laravel Backend Web course project.
--}}

@extends('layouts.app')

@section('content')
<section class="dev-life">
    <div class="container">
        <h1><i class="fas fa-laptop-code"></i> <span data-translate="skills_title"></span></h1>

        <div class="skills-section">
            <h2><i class="fas fa-code"></i> <span data-translate="skills_title"></span></h2>
            <p class="section-hint"><i class="fas fa-hand-pointer"></i> <span data-translate="skills_click_details"></span></p>

            <div class="skills-grid">
                @foreach($skills as $skill)
                    <div class="skill-card" data-modal='@json($skillModel->getModalData($skill))'>
                        <div class="skill-header">
                            <h3>{{ $skill['name'] }}</h3>
                            <span class="skill-level level-{{ $skill['level'] }}" data-translate="skills_level_{{ $skill['level'] == 1 ? 'beginner' : ($skill['level'] == 2 ? 'intermediate' : 'advanced') }}">
                                {{ $skillModel->getLevelText($skill['level']) }}
                            </span>
                        </div>
                        <div class="skill-progress">
                            <div class="progress-bar" data-width="{{ $skillModel->getLevelPercentage($skill['level']) }}%"></div>
                        </div>
                        <p class="skill-notes">{{ $skill['notes'] }}</p>
                        <span class="skill-category" data-translate="category_{{ $skill['category'] }}"></span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="education-section">
            <h2><i class="fas fa-graduation-cap"></i> <span data-translate="education_title"></span></h2>
            <p class="section-hint"><i class="fas fa-hand-pointer"></i> <span data-translate="education_click_details"></span></p>

            <ul class="education-list">
                @foreach($education as $index => $item)
                    @php
                        $educationTitle = is_array($item)
                            ? ($item['title'] ?? ($item['title_key'] ?? ''))
                            : $item;
                    @endphp
                    <li data-modal='@json($skillModel->buildEducationModalData($item, $index))'>
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $educationTitle }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="learning-section">
            <h2><i class="fas fa-target"></i> <span data-translate="learning_title"></span></h2>
            <p class="section-hint"><i class="fas fa-hand-pointer"></i> <span data-translate="learning_click_details"></span></p>

            <ul class="learning-list">
                @foreach($learning_goals as $index => $goal)
                    @php
                        $learningTitle = is_array($goal)
                            ? ($goal['title'] ?? ($goal['title_key'] ?? ''))
                            : $goal;
                    @endphp
                    <li data-modal='@json($skillModel->buildLearningModalData($goal, $index))'>
                        <i class="fas fa-arrow-right"></i>
                        <span>{{ $learningTitle }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endsection
