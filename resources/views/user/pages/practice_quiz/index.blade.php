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

    /* Practice Card Action Buttons */
    .btn-practice-start {
        background: transparent;
        border: 2px solid #03c6bb;
        color: #009e95;
        font-weight: 700;
        transition: all 0.25s ease;
        text-decoration: none;
    }
    .btn-practice-start:hover, .btn-practice-start:focus {
        background: linear-gradient(135deg, #03c6bb 0%, #4f46e5 100%) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        box-shadow: 0 8px 18px rgba(3, 198, 187, 0.35);
        transform: translateY(-2px);
    }
    .btn-practice-resume {
        background: linear-gradient(135deg, #03c6bb 0%, #4f46e5 100%);
        border: 2px solid transparent;
        color: #ffffff !important;
        font-weight: 700;
        transition: all 0.25s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(3, 198, 187, 0.25);
    }
    .btn-practice-resume:hover, .btn-practice-resume:focus {
        background: linear-gradient(135deg, #02b0a6 0%, #3e38c7 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 8px 20px rgba(3, 198, 187, 0.4);
        transform: translateY(-2px);
    }
    .btn-practice-again {
        background: #03c6bb;
        border: 2px solid #03c6bb;
        color: #ffffff !important;
        font-weight: 700;
        transition: all 0.25s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(3, 198, 187, 0.2);
    }
    .btn-practice-again:hover, .btn-practice-again:focus {
        background: #009e95 !important;
        border-color: #009e95 !important;
        color: #ffffff !important;
        box-shadow: 0 8px 18px rgba(3, 198, 187, 0.35);
        transform: translateY(-2px);
    }
    .btn-practice-review {
        border: 2px solid #e2e8f0;
        color: #64748b;
        font-weight: 600;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .btn-practice-review:hover, .btn-practice-review:focus {
        border-color: #03c6bb;
        color: #009e95 !important;
        background: rgba(3, 198, 187, 0.08);
    }
    .practice-history-pill {
        background: rgba(245, 158, 11, 0.08);
        border: 1px solid rgba(245, 158, 11, 0.25);
        border-radius: 12px;
        padding: 8px 12px;
        font-size: 12px;
        color: #b45309;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
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
    body.dark .btn-practice-start {
        border-color: #03c6bb;
        color: #03c6bb;
    }
    body.dark .btn-practice-start:hover {
        color: #ffffff !important;
    }
    body.dark .btn-practice-review {
        background: #1e293b;
        border-color: #334155;
        color: #94a3b8;
    }
    body.dark .btn-practice-review:hover {
        border-color: #03c6bb;
        color: #03c6bb !important;
    }
    body.dark .practice-history-pill {
        background: rgba(245, 158, 11, 0.12);
        border-color: rgba(245, 158, 11, 0.3);
        color: #fbbf24;
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
                    $activeSession = $quiz->active_session ?? null;
                    $lastCompleted = $quiz->last_completed_session ?? null;
                    $hasActive = $activeSession && $activeSession->status === 'in_progress';
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

                        <!-- User Session Progress If Active -->
                        @if($hasActive)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold" style="font-size: 12px; color: #03c6bb;">
                                        <i class="feather-clock me-1"></i> In Progress ({{ $activeSession->mastered_questions }}/{{ $activeSession->total_questions }} mastered)
                                    </span>
                                    <span class="small font-weight-bold text-dark-title" style="font-size: 12px;">
                                        {{ $activeSession->progress_percent }}%
                                    </span>
                                </div>
                                <div class="practice-progress-bar">
                                    <div class="practice-progress-fill" style="width: {{ $activeSession->progress_percent }}%;"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Past History Pill If Completed Previously -->
                        @if($lastCompleted)
                            <div class="practice-history-pill">
                                <div class="d-flex align-items-center gap-1 font-weight-bold">
                                    <i class="feather-award text-warning"></i>
                                    <span>Last Result: <strong>{{ $lastCompleted->accuracy_percent }}%</strong></span>
                                    <span class="text-muted ms-1" style="font-size: 11px;">({{ $lastCompleted->total_attempts }} attempts)</span>
                                </div>
                                <span class="badge bg-success text-white fw-bold px-2 py-1 rounded-pill" style="font-size: 10px;">
                                    ✔ Mastered
                                </span>
                            </div>
                        @endif

                        <div class="mt-auto">
                            @if($hasActive)
                                <a href="{{ route('practice_quiz.play', $activeSession->id) }}" class="btn btn-practice-resume rounded-pill w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                                    <i class="feather-play"></i> Resume Practice ({{ $activeSession->progress_percent }}%)
                                </a>
                            @elseif($lastCompleted)
                                <div class="d-flex gap-2">
                                    <a href="{{ route('practice_quiz.start', ['id' => $quiz->id, 'restart' => 1]) }}" class="btn btn-practice-again rounded-pill flex-grow-1 d-flex align-items-center justify-content-center gap-2 py-2">
                                        <i class="feather-rotate-ccw"></i> Practice Again
                                    </a>
                                    <a href="{{ route('practice_quiz.review', $lastCompleted->id) }}" class="btn btn-practice-review rounded-pill px-3 d-flex align-items-center justify-content-center" title="Review Explanations">
                                        <i class="feather-book-open"></i>
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-practice-start rounded-pill w-100 d-flex align-items-center justify-content-center gap-2 py-2">
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
