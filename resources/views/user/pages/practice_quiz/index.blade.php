@extends('user.pages.test_master')

@push('test_style')
<style>
    .practice-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.18) 0%, transparent 45%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 55px 0 65px;
        color: #ffffff;
        position: relative;
    }
    .practice-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
        position: relative;
    }
    .practice-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #03c6bb;
    }
    .practice-badge-game {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .practice-progress-bar {
        height: 8px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .practice-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #03c6bb 0%, #4f46e5 100%);
        border-radius: 10px;
        transition: width 0.4s ease;
    }

    /* Dark Mode Styles */
    body.dark .practice-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 45%),
                    linear-gradient(135deg, #070b14 0%, #0f172a 100%) !important;
    }
    body.dark .practice-card {
        background: #111827 !important;
        border-color: #1f2937 !important;
    }
    body.dark .practice-card:hover {
        border-color: #03c6bb !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4) !important;
    }
    body.dark .practice-progress-bar {
        background: #1f2937 !important;
    }
    body.dark .text-dark-title {
        color: #f1f5f9 !important;
    }
    body.dark .text-dark-muted {
        color: #94a3b8 !important;
    }
    body.dark .cat-pill {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    body.dark .cat-pill.active, body.dark .cat-pill:hover {
        background: #03c6bb !important;
        color: #ffffff !important;
        border-color: #03c6bb !important;
    }
</style>
@endpush

@section('content')
<!-- Hero Area -->
<div class="practice-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Preparation Quiz Game</li>
                    </ul>
                </nav>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(3, 198, 187, 0.15); border: 1px solid rgba(3, 198, 187, 0.3); font-size: 13px; font-weight: 600; color: #03c6bb;">
                    <i class="feather-zap"></i> Spaced-Repetition Active Recall
                </div>
                <h1 class="mb-2" style="font-size: clamp(28px, 4vw, 42px); font-weight: 800; color: #ffffff;">
                    Interactive Preparation Quizzes
                </h1>
                <p class="mb-0" style="color: #94a3b8; font-size: 16px; max-width: 650px; line-height: 1.6;">
                    Learn and permanently remember answers through gamified repetition. Incorrect answers repeat randomly until you master each question!
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <div class="p-3 rounded-4 d-inline-block text-start" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #03c6bb, #4f46e5); color: #fff; font-size: 24px;">
                            🎯
                        </div>
                        <div>
                            <div style="font-size: 13px; color: #94a3b8;">How It Works</div>
                            <div style="font-weight: 700; color: #ffffff; font-size: 15px;">Answer 4x Correct to Master</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Section -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <!-- Filter Tabs & Search -->
        <div class="row mb-5 align-items-center g-3">
            <div class="col-lg-8 col-12">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="{{ route('practice_quiz.index') }}" class="btn btn-sm rounded-pill px-3 py-2 cat-pill {{ empty($catId) ? 'active' : '' }}" style="{{ empty($catId) ? 'background: #03c6bb; color: #fff; font-weight: 700;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;' }}">
                        All Topics
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('practice_quiz.index', ['cat' => $category->id]) }}" class="btn btn-sm rounded-pill px-3 py-2 cat-pill {{ $catId == $category->id ? 'active' : '' }}" style="{{ $catId == $category->id ? 'background: #03c6bb; color: #fff; font-weight: 700;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;' }}">
                            {{ $category->cat_name ?? $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <form action="{{ route('practice_quiz.index') }}" method="GET">
                    @if($catId)
                        <input type="hidden" name="cat" value="{{ $catId }}">
                    @endif
                    <div class="input-group">
                        <input type="text" name="q" value="{{ $search }}" class="form-control rounded-pill-start ps-3" placeholder="Search preparation quiz..." style="border-right: none; height: 44px;">
                        <button class="btn btn-primary rounded-pill-end px-4" type="submit">
                            <i class="feather-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quizzes Grid -->
        <div class="row g-4">
            @forelse($quizzes as $quiz)
                @php
                    $session = $quiz->user_session ?? null;
                    $isCompleted = optional($session)->status === 'completed';
                    $hasProgress = $session && optional($session)->total_attempts > 0;
                    $progressPercent = $session ? $session->progress_percent : 0;
                @endphp
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="practice-card p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="practice-badge-game">
                                <i class="feather-award"></i> {{ $quiz->target_repetitions }}x Mastery Game
                            </span>
                            @if($quiz->category)
                                <span class="badge rounded-pill text-muted" style="background: rgba(3, 198, 187, 0.1); color: #009e95 !important; font-weight: 600; font-size: 12px; padding: 6px 12px;">
                                    {{ $quiz->category->cat_name ?? $quiz->category->name }}
                                </span>
                            @endif
                        </div>

                        <h4 class="text-dark-title mb-2" style="font-weight: 700; font-size: 19px; line-height: 1.4;">
                            <a href="{{ route('practice_quiz.show', $quiz->slug) }}" class="text-decoration-none text-dark-title" style="transition: color 0.2s;">
                                {{ $quiz->title }}
                            </a>
                        </h4>

                        @if($quiz->description)
                            <p class="text-dark-muted small mb-4 flex-grow-1" style="line-height: 1.6; color: #64748b;">
                                {{ Str::limit($quiz->description, 95) }}
                            </p>
                        @else
                            <div class="flex-grow-1 mb-4"></div>
                        @endif

                        <div class="d-flex align-items-center justify-content-between pt-3 border-top mb-3" style="border-color: #f1f5f9;">
                            <span class="text-dark-muted small d-flex align-items-center gap-1">
                                <i class="feather-help-circle text-primary"></i> <strong>{{ $quiz->questions_count }}</strong> Questions
                            </span>
                            <span class="text-dark-muted small d-flex align-items-center gap-1">
                                <i class="feather-repeat text-warning"></i> <strong>{{ $quiz->target_repetitions }}x</strong> Target
                            </span>
                        </div>

                        <!-- User Session Progress If Started -->
                        @if($hasProgress)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold" style="font-size: 12px; color: {{ $isCompleted ? '#10b981' : '#03c6bb' }};">
                                        {{ $isCompleted ? '🎉 Completed & Mastered!' : 'In Progress (' . $session->mastered_questions . '/' . $session->total_questions . ' mastered)' }}
                                    </span>
                                    <span class="small font-weight-bold text-dark-title" style="font-size: 12px;">
                                        {{ $progressPercent }}%
                                    </span>
                                </div>
                                <div class="practice-progress-bar">
                                    <div class="practice-progress-fill" style="width: {{ $progressPercent }}%; {{ $isCompleted ? 'background: #10b981;' : '' }}"></div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-auto">
                            @if($isCompleted)
                                <div class="d-flex gap-2">
                                    <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-primary rounded-pill flex-grow-1 d-flex align-items-center justify-content-center gap-2" style="font-weight: 700;">
                                        <i class="feather-play-circle"></i> Practice Again
                                    </a>
                                    <a href="{{ route('practice_quiz.review', $session->id) }}" class="btn btn-outline-secondary rounded-pill px-3" title="Review Explanations">
                                        <i class="feather-book-open"></i>
                                    </a>
                                </div>
                            @elseif($hasProgress)
                                <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-gradient rounded-pill w-100 d-flex align-items-center justify-content-center gap-2" style="font-weight: 700;">
                                    <i class="feather-play"></i> Resume Practice ({{ $progressPercent }}%)
                                </a>
                            @else
                                <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-outline-primary rounded-pill w-100 d-flex align-items-center justify-content-center gap-2" style="font-weight: 700; border-color: #03c6bb; color: #009e95;">
                                    <i class="feather-play-circle"></i> Start Preparation Game
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <div class="mb-3" style="font-size: 48px;">📚</div>
                        <h4 class="text-dark-title mb-2">No Preparation Quizzes Found</h4>
                        <p class="text-dark-muted">Please check back soon or try selecting a different category.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $quizzes->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
