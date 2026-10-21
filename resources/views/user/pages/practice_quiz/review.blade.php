@extends('user.pages.test_master')

@push('test_style')
<style>
    .review-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.18) 0%, transparent 45%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 50px 0 60px;
        color: #ffffff;
    }
    .review-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }
    .review-option {
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 8px;
        font-size: 15px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .review-option.is-correct {
        background: #ecfdf5;
        border-color: #10b981;
        color: #065f46;
        font-weight: 600;
    }

    body.dark .review-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.08) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 45%),
                    linear-gradient(135deg, #070b14 0%, #0f172a 100%) !important;
    }
    body.dark .review-card {
        background: #111827 !important;
        border-color: #1f2937 !important;
    }
    body.dark .review-option {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body.dark .review-option.is-correct {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #a7f3d0 !important;
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
<div class="review-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li><a href="{{ route('practice_quiz.index') }}" style="color: #94a3b8; text-decoration: none;">Practice Quizzes</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li style="color: #03c6bb; font-weight: 600;">Review Questions</li>
            </ul>
        </nav>
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <span class="badge rounded-pill mb-2" style="background: rgba(3, 198, 187, 0.15); border: 1px solid rgba(3, 198, 187, 0.3); color: #03c6bb; padding: 6px 14px; font-weight: 600;">
                    Study & Review Mode
                </span>
                <h1 style="font-size: clamp(26px, 3.5vw, 36px); font-weight: 800; color: #ffffff;">
                    {{ $session->quiz->title }}
                </h1>
                <p style="color: #94a3b8; font-size: 15px;" class="mb-0">
                    Review all {{ $session->sessionQuestions->count() }} questions, correct answers, and learning explanations.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('practice_quiz.start', $session->quiz->id) }}" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold">
                    <i class="feather-play"></i> Return to Game
                </a>
            </div>
        </div>
    </div>
</div>

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                @foreach($session->sessionQuestions as $index => $sq)
                    @php $q = $sq->question; @endphp
                    @if($q)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge rounded-pill" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5; font-weight: 700; font-size: 13px; padding: 6px 14px;">
                                Question {{ $index + 1 }}
                            </span>
                            <span class="badge {{ $sq->is_mastered ? 'badge-success' : 'badge-warning' }}" style="font-size: 12px;">
                                {{ $sq->is_mastered ? '✔ Mastered (' . $sq->correct_count . 'x)' : 'Learning (' . $sq->correct_count . '/' . $session->quiz->target_repetitions . ')' }}
                            </span>
                        </div>

                        <h4 class="text-dark-title mb-4" style="font-weight: 700; font-size: 18px; line-height: 1.5;">
                            {{ $q->question }}
                        </h4>

                        <div class="options-list mb-3">
                            @php
                                $opts = [
                                    1 => $q->optn1,
                                    2 => $q->optn2,
                                    3 => $q->optn3,
                                    4 => $q->optn4,
                                    5 => $q->optn5,
                                ];
                                $letters = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];
                            @endphp

                            @foreach($opts as $num => $optText)
                                @if(!empty($optText))
                                    <div class="review-option {{ $q->right_ans == $num ? 'is-correct' : '' }}">
                                        <span class="badge {{ $q->right_ans == $num ? 'bg-success text-white' : 'bg-light text-dark' }}" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                            {{ $letters[$num] }}
                                        </span>
                                        <span class="flex-grow-1">{{ $optText }}</span>
                                        @if($q->right_ans == $num)
                                            <i class="feather-check-circle text-success" title="Correct Answer"></i>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if(!empty($q->explanation))
                            <div class="p-3 rounded-3 mt-3" style="background: rgba(3, 198, 187, 0.08); border-left: 4px solid #03c6bb;">
                                <div class="small font-weight-bold mb-1" style="color: #009e95;">
                                    <i class="feather-info"></i> Explanation / Discussion:
                                </div>
                                <div class="text-dark-title small" style="line-height: 1.6;">
                                    {{ $q->explanation }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                @endforeach

                <div class="text-center mt-5">
                    <a href="{{ route('practice_quiz.start', $session->quiz->id) }}" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold">
                        <i class="feather-play mr-2"></i> Continue Practice Game
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
