@extends('user.pages.test_master')

@push('test_style')
<style>
    .quiz-detail-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.18) 0%, transparent 45%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 55px 0 65px;
        color: #ffffff;
    }
    .rule-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        height: 100%;
        transition: transform 0.2s;
    }
    .rule-card:hover {
        transform: translateY(-3px);
    }
    .rule-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    body.dark .quiz-detail-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 45%),
                    linear-gradient(135deg, #070b14 0%, #0f172a 100%) !important;
    }
    body.dark .rule-card {
        background: #111827 !important;
        border-color: #1f2937 !important;
    }
    body.dark .text-dark-title {
        color: #f1f5f9 !important;
    }
    body.dark .text-dark-muted {
        color: #94a3b8 !important;
    }
</style>
@endpush

@section('content')
<div class="quiz-detail-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li><a href="{{ route('practice_quiz.index') }}" style="color: #94a3b8; text-decoration: none;">Practice Quizzes</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li style="color: #03c6bb; font-weight: 600;">{{ $quiz->title }}</li>
            </ul>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <span class="badge rounded-pill mb-3" style="background: rgba(3, 198, 187, 0.15); border: 1px solid rgba(3, 198, 187, 0.3); color: #03c6bb; padding: 6px 14px; font-weight: 600;">
                    {{ $quiz->category ? ($quiz->category->cat_name ?? $quiz->category->name) : 'General Practice' }}
                </span>
                <h1 style="font-size: clamp(28px, 4vw, 42px); font-weight: 800; color: #ffffff; line-height: 1.3;" class="mb-3">
                    {{ $quiz->title }}
                </h1>
                <p style="color: #94a3b8; font-size: 16px; line-height: 1.6; max-width: 680px;" class="mb-4">
                    {{ $quiz->description ?: 'Interactive mastery preparation quiz designed to help you memorize all answers through spaced repetition and immediate feedback.' }}
                </p>

                <div class="d-flex flex-wrap gap-4 pt-2">
                    <div>
                        <div class="text-muted small">Total Questions</div>
                        <div class="h4 font-weight-bold text-white mb-0">{{ $quiz->questions_count }}</div>
                    </div>
                    <div style="border-left: 1px solid rgba(255,255,255,0.1); padding-left: 20px;">
                        <div class="text-muted small">Target Repetition</div>
                        <div class="h4 font-weight-bold text-white mb-0">{{ $quiz->target_repetitions }}x Correct</div>
                    </div>
                    <div style="border-left: 1px solid rgba(255,255,255,0.1); padding-left: 20px;">
                        <div class="text-muted small">Quiz Format</div>
                        <div class="h4 font-weight-bold text-white mb-0">Active Recall Game</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <div class="p-4 rounded-4 text-start shadow-lg" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px);">
                    @if($userSession)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small font-weight-bold text-white">Your Progress</span>
                                <span class="small font-weight-bold" style="color: #03c6bb;">{{ $userSession->progress_percent }}%</span>
                            </div>
                            <div class="progress" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                                <div class="progress-bar" style="width: {{ $userSession->progress_percent }}%; background: linear-gradient(90deg, #03c6bb, #4f46e5); border-radius: 10px;"></div>
                            </div>
                            <div class="text-muted small mt-2">
                                {{ $userSession->mastered_questions }} of {{ $userSession->total_questions }} questions mastered
                            </div>
                        </div>

                        @if($userSession->status === 'completed')
                            <div class="alert alert-success py-2 px-3 small rounded-3 mb-3">
                                <i class="feather-check-circle"></i> You have already mastered this quiz!
                            </div>
                            <a href="{{ route('practice_quiz.start', ['id' => $quiz->id, 'restart' => 1]) }}" class="btn btn-primary rounded-pill w-100 py-3 mb-2 font-weight-bold">
                                <i class="feather-rotate-ccw"></i> Practice Again
                            </a>
                            <a href="{{ route('practice_quiz.review', $userSession->id) }}" class="btn btn-outline-light rounded-pill w-100 py-2 small">
                                <i class="feather-book-open"></i> Review All Explanations
                            </a>
                        @else
                            <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-gradient rounded-pill w-100 py-3 font-weight-bold" style="background: linear-gradient(90deg, #03c6bb, #4f46e5);">
                                <i class="feather-play"></i> Resume Practice Now
                            </a>
                        @endif

                        @if(isset($pastCompletedSessions) && $pastCompletedSessions->isNotEmpty() && $userSession->status !== 'completed')
                            <div class="mt-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.15) !important;">
                                <div class="small font-weight-bold text-white mb-2 d-flex align-items-center gap-1">
                                    <i class="feather-award text-warning"></i> Last Completed Result:
                                </div>
                                @php $lastCompleted = $pastCompletedSessions->first(); @endphp
                                <div class="p-2 rounded-3" style="background: rgba(255,255,255,0.08); font-size: 13px;">
                                    <div class="d-flex justify-content-between text-white font-weight-bold">
                                        <span class="text-success"><i class="feather-check-circle"></i> 100% Mastered</span>
                                        <span class="text-warning">{{ $lastCompleted->accuracy_percent }}% Accuracy</span>
                                    </div>
                                    <div class="text-muted small mt-1 d-flex justify-content-between">
                                        <span>{{ $lastCompleted->total_attempts }} total attempts</span>
                                        <span>{{ $lastCompleted->completed_at ? $lastCompleted->completed_at->format('M d, Y') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <h5 class="text-white mb-2">Ready to Prepare?</h5>
                        <p class="text-muted small mb-4">No time pressure or negative marks. Learn through repetition until 100% mastered.</p>
                        <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-gradient rounded-pill w-100 py-3 font-weight-bold" style="background: linear-gradient(90deg, #03c6bb, #4f46e5); font-size: 16px;">
                            <i class="feather-play-circle"></i> Start Preparation Game
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <h3 class="text-dark-title text-center mb-2" style="font-weight: 800;">How the Mastery System Works</h3>
        <p class="text-dark-muted text-center mb-5" style="max-width: 600px; margin-inline: auto;">
            Unlike standard exams where guessing can yield accidental points, this practice system reinforces actual memory retention.
        </p>

        <div class="row g-4">
            <div class="col-md-4 col-12">
                <div class="rule-card text-center">
                    <div class="rule-icon mx-auto" style="background: rgba(3, 198, 187, 0.1); color: #009e95;">
                        <i class="feather-eye"></i>
                    </div>
                    <h5 class="text-dark-title mb-2" style="font-weight: 700;">1 Question at a Time</h5>
                    <p class="text-dark-muted small mb-0" style="line-height: 1.6;">
                        Focus fully on one question. Read the options carefully and test your active recall without distractions.
                    </p>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="rule-card text-center">
                    <div class="rule-icon mx-auto" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="feather-alert-triangle"></i>
                    </div>
                    <h5 class="text-dark-title mb-2" style="font-weight: 700;">Instant Learning on Error</h5>
                    <p class="text-dark-muted small mb-0" style="line-height: 1.6;">
                        If you pick an incorrect option, the right answer and explanation appear immediately, and that question is returned to the pool to reappear later.
                    </p>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="rule-card text-center">
                    <div class="rule-icon mx-auto" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                        <i class="feather-award"></i>
                    </div>
                    <h5 class="text-dark-title mb-2" style="font-weight: 700;">{{ $quiz->target_repetitions }}x Mastery Target</h5>
                    <p class="text-dark-muted small mb-0" style="line-height: 1.6;">
                        Each question must be correctly answered {{ $quiz->target_repetitions }} times to be permanently mastered, ensuring strong memory retention for your real exam.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('practice_quiz.start', $quiz->id) }}" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold" style="font-size: 17px;">
                <i class="feather-play-circle mr-2"></i> Begin Quiz Practice Now
            </a>
        </div>
    </div>
</div>
@endsection
