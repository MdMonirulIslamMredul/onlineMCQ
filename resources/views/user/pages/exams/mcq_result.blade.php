@extends('user.pages.test_master')
@section('content')
@php
$i = 1;
$examInfo = DB::table('exams')->where('id', $examID)->first();
$mcq_results = DB::table('mcq_results')->where('examID', $examID)->where('userID', $userID)->get();

$totalQ = DB::table('mcq_questions')->where('examID', $examInfo->id)->count();
$totalMarks = DB::table('mcq_questions')->where('examID', $examInfo->id)->sum('mark');
$studentMark = DB::table('mcq_results')->where('examID', $examInfo->id)->where('userID', $userID)->sum('obtained_mark');
$mark = $studentMark;

$correctCount = 0;
$wrongCount = 0;
$skippedCount = 0;

foreach ($mcq_results as $r) {
    if ($r->userAns == '') {
        $skippedCount++;
    } else if ($r->rightAns == $r->userAns) {
        $correctCount++;
    } else {
        $wrongCount++;
    }
}

$percentage = $totalMarks > 0 ? round(($mark / $totalMarks) * 100) : 0;
@endphp

<!-- Start Hero Banner -->
<div class="student-hero" style="padding: 50px 0 60px;">
    <div class="container text-center">
        <div class="student-hero-badge mx-auto">
            <i class="feather-award"></i> Exam Evaluation Report
        </div>
        <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
            {{ $examInfo->exam_name ?? 'Exam Results' }}
        </h1>
        <p class="student-hero-desc mx-auto mb-0">
            Review your detailed score breakdown, correct answers, and expert solution explanations.
        </p>
    </div>
</div>
<!-- End Hero Banner -->

<div class="rbt-section-gapTop pb--80 bg-color-white">
    <div class="container">
        <!-- Scorecard Overview -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 col-12">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; margin-top: -60px; position: relative; z-index: 10;">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-4 col-md-5 text-center border-end-md">
                            <div class="score-meter-circle">
                                <span class="score-meter-num">{{ $mark }}</span>
                                <span style="font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 500;">out of {{ $totalMarks }}</span>
                            </div>
                            <h4 class="mb-1" style="font-weight: 700;">
                                @if($percentage >= 80)
                                    🎉 Outstanding!
                                @elseif($percentage >= 50)
                                    👏 Well Done!
                                @else
                                    📚 Keep Practicing!
                                @endif
                            </h4>
                            <span class="badge" style="background: rgba(3, 198, 187, 0.15); color: #009e95; font-size: 14px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                                Score: {{ $percentage }}%
                            </span>
                        </div>

                        <div class="col-lg-8 col-md-7">
                            <div class="row g-3">
                                <div class="col-sm-6 col-12">
                                    <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <div class="text-muted" style="font-size: 13px;">Total Questions</div>
                                        <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: #0f172a;">{{ $totalQ }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="p-3 rounded-3" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                                        <div style="color: #059669; font-size: 13px; font-weight: 600;">Correct Answers</div>
                                        <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: #10b981;">{{ $correctCount }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="p-3 rounded-3" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2);">
                                        <div style="color: #dc2626; font-size: 13px; font-weight: 600;">Wrong Answers</div>
                                        <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: #ef4444;">{{ $wrongCount }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="p-3 rounded-3" style="background: #f1f5f9; border: 1px solid #cbd5e1;">
                                        <div class="text-muted" style="font-size: 13px;">Skipped / Unanswered</div>
                                        <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: #64748b;">{{ $skippedCount }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-4">
                                <a href="{{ route('all.courses') }}" class="rbt-btn btn-gradient radius-round btn-sm">
                                    <span class="btn-text">Take Another Exam</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </a>
                                <a href="{{ route('user.myaccount.dashboard') }}" class="rbt-btn btn-border radius-round btn-sm">
                                    <span class="btn-text">My Dashboard</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Question Breakdown Header -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-9 col-12">
                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom">
                    <h3 class="mb-0" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                        <i class="feather-list me-2" style="color: #03c6bb;"></i> Detailed Question Review
                    </h3>
                    <span class="text-muted" style="font-size: 14px;">Total {{ count($mcq_results) }} Reviewed</span>
                </div>
            </div>
        </div>

        <!-- Question Review Cards -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12">
                @foreach($mcq_results as $mcq)
                    @php
                        $questionsInfo = DB::table('mcq_questions')->where('id', $mcq->qid)->first();
                        $isCorrect = ($mcq->rightAns == $mcq->userAns);
                        $isSkipped = ($mcq->userAns == '');
                    @endphp
                    <div class="exam-question-card mb-4" style="border-left: 5px solid {{ $isCorrect ? '#10b981' : ($isSkipped ? '#94a3b8' : '#ef4444') }};">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="exam-question-number">Question {{ $i }} of {{ count($mcq_results) }}</span>
                            <div>
                                @if($isCorrect)
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-weight: 700; padding: 6px 12px; border-radius: 9999px;">
                                        <i class="feather-check me-1"></i> Correct (+{{ $mcq->mark }})
                                    </span>
                                @elseif($isSkipped)
                                    <span class="badge" style="background: #f1f5f9; color: #64748b; font-weight: 600; padding: 6px 12px; border-radius: 9999px;">
                                        <i class="feather-minus me-1"></i> Skipped (0)
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; font-weight: 700; padding: 6px 12px; border-radius: 9999px;">
                                        <i class="feather-x me-1"></i> Wrong (-{{ $mcq->negativeMark }})
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="exam-question-text">
                            {!! optional($questionsInfo)->questions !!}
                        </div>

                        <!-- Options Review -->
                        <div class="d-flex flex-column gap-2 mt-3">
                            @for($optIdx = 1; $optIdx <= 5; $optIdx++)
                                @php
                                    $optKey = 'optn' . $optIdx;
                                    $optText = optional($questionsInfo)->$optKey;
                                    $keyLetter = chr(64 + $optIdx);
                                    $isThisRight = ($mcq->rightAns == $optIdx);
                                    $isThisUserAns = ($mcq->userAns == $optIdx);
                                @endphp

                                @if(!empty($optText))
                                    <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="
                                        background: {{ $isThisRight ? 'rgba(16, 185, 129, 0.08)' : ($isThisUserAns && !$isCorrect ? 'rgba(239, 68, 68, 0.08)' : '#f8fafc') }};
                                        border: 2px solid {{ $isThisRight ? '#10b981' : ($isThisUserAns && !$isCorrect ? '#ef4444' : '#e2e8f0') }};
                                    ">
                                        <div class="d-flex align-items-center gap-3">
                                            <span style="
                                                width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;
                                                background: {{ $isThisRight ? '#10b981' : ($isThisUserAns && !$isCorrect ? '#ef4444' : '#ffffff') }};
                                                color: {{ ($isThisRight || ($isThisUserAns && !$isCorrect)) ? '#ffffff' : '#64748b' }};
                                                border: 1px solid {{ $isThisRight ? '#10b981' : ($isThisUserAns && !$isCorrect ? '#ef4444' : '#cbd5e1') }};
                                            ">
                                                {{ $keyLetter }}
                                            </span>
                                            <span style="font-size: 15px; {{ ($isThisUserAns && !$isCorrect) ? 'text-decoration: line-through; color: #ef4444;' : 'color: #1e293b;' }}">
                                                {{ $optText }}
                                            </span>
                                        </div>

                                        <div>
                                            @if($isThisRight)
                                                <span class="badge" style="background: #10b981; color: #ffffff; font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                                                    <i class="feather-check me-1"></i> Correct Answer
                                                </span>
                                            @elseif($isThisUserAns && !$isCorrect)
                                                <span class="badge" style="background: #ef4444; color: #ffffff; font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                                                    <i class="feather-x me-1"></i> Your Choice
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>

                        <!-- Answer Explanation Note -->
                        @if(!empty(optional($questionsInfo)->writeAnsDes))
                            <div class="p-3 rounded-3 mt-3" style="background: rgba(3, 198, 187, 0.08); border-left: 4px solid #03c6bb;">
                                <div style="color: #009e95; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em;">
                                    <i class="feather-info me-1"></i> Solution Explanation
                                </div>
                                <div class="mt-1" style="color: #334155; font-size: 14px; line-height: 1.6;">
                                    {{ optional($questionsInfo)->writeAnsDes }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @php($i++)
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
