@extends('user.pages.test_master')
@section('content')
@php
$i = 1;
$examInfo = DB::table('exams')->where('id', $examID)->first();
$written_results = DB::table('written_results')->where('examID', $examID)->where('userID', $userID)->get();

$totalQ = DB::table('written_questions')->where('examID', $examInfo->id)->count();
$totalMarks = DB::table('written_questions')->where('examID', $examInfo->id)->sum('mark');
$studentMark = DB::table('written_results')->where('examID', $examInfo->id)->where('userID', $userID)->sum('rightansMark');
$resultsQ = DB::table('results')->where('examID', $examInfo->id)->where('userID', $userID)->first();
$isChecked = (optional($resultsQ)->written_status == 'checked');
$percentage = ($totalMarks > 0 && $isChecked) ? round(($studentMark / $totalMarks) * 100) : 0;
@endphp

<!-- Start Hero Banner -->
<div class="student-hero" style="padding: 50px 0 60px;">
    <div class="container text-center">
        <div class="student-hero-badge mx-auto">
            <i class="feather-award"></i> Written Exam Evaluation
        </div>
        <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
            {{ $examInfo->exam_name ?? 'Written Exam Result' }}
        </h1>
        <p class="student-hero-desc mx-auto mb-0">
            Instructor assessment report, remarks, and model answers.
        </p>
    </div>
</div>

<div class="rbt-section-gapTop pb--80 bg-color-white">
    <div class="container">
        <!-- Scorecard Overview -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 col-12">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; margin-top: -60px; position: relative; z-index: 10;">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-4 col-md-5 text-center border-end-md">
                            @if($isChecked)
                                <div class="score-meter-circle">
                                    <span class="score-meter-num">{{ $studentMark }}</span>
                                    <span style="font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 500;">out of {{ $totalMarks }}</span>
                                </div>
                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 14px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                                    Reviewed & Checked
                                </span>
                            @else
                                <div class="score-meter-circle" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                    <i class="feather-clock" style="font-size: 40px; margin-bottom: 6px;"></i>
                                    <span style="font-size: 13px; font-weight: 600;">Pending Review</span>
                                </div>
                                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #b45309; font-size: 14px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                                    Awaiting Instructor Evaluation
                                </span>
                            @endif
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
                                    <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <div class="text-muted" style="font-size: 13px;">Total Allocated Marks</div>
                                        <div style="font-family: var(--font-heading); font-size: 22px; font-weight: 700; color: #0f172a;">{{ $totalMarks }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mt-4">
                                <a href="{{ route('all.courses') }}" class="rbt-btn btn-gradient radius-round btn-sm">
                                    <span class="btn-text">Browse More Exams</span>
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

        <!-- Answers Review -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12">
                @foreach($written_results as $written)
                    @php
                        $questionsInfo = DB::table('written_questions')->where('id', $written->qid)->first();
                    @endphp
                    <div class="exam-question-card mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="exam-question-number">Question {{ $i }} of {{ count($written_results) }}</span>
                            <div>
                                <span class="badge" style="background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-weight: 700; padding: 6px 12px; border-radius: 9999px;">
                                    Max: {{ $written->mark }} Marks
                                </span>
                                @if($isChecked)
                                    <span class="badge ms-2" style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-weight: 700; padding: 6px 12px; border-radius: 9999px;">
                                        Obtained: {{ $written->rightansMark }} Marks
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="exam-question-text">
                            {!! optional($questionsInfo)->questions !!}
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div style="font-weight: 700; color: #475569; font-size: 13px; text-transform: uppercase;">Your Submitted Answer:</div>
                            <div class="mt-2" style="color: #1e293b; line-height: 1.6;">
                                {!! $written->userAns ?: '<span class="text-muted fst-italic">No text submitted</span>' !!}
                            </div>
                            @if($written->file_path)
                                <div class="mt-3 pt-2 border-top">
                                    <a href="{{ asset('file_path/' . $written->file_path) }}" class="rbt-btn btn-xs btn-border radius-round" download>
                                        <i class="feather-download me-1"></i> Download Attached File
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if(!empty(optional($questionsInfo)->ans))
                            <div class="p-3 rounded-3 mb-3" style="background: rgba(16, 185, 129, 0.08); border-left: 4px solid #10b981;">
                                <div style="color: #059669; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                                    <i class="feather-check-circle me-1"></i> Model / Ideal Answer:
                                </div>
                                <div class="mt-1" style="color: #334155; line-height: 1.6;">
                                    {{ optional($questionsInfo)->ans }}
                                </div>
                            </div>
                        @endif

                        @if(!empty($written->note))
                            <div class="p-3 rounded-3" style="background: rgba(79, 70, 229, 0.08); border-left: 4px solid #4f46e5;">
                                <div style="color: #4f46e5; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                                    <i class="feather-message-square me-1"></i> Instructor Feedback Note:
                                </div>
                                <div class="mt-1" style="color: #334155; line-height: 1.6;">
                                    {{ $written->note }}
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
