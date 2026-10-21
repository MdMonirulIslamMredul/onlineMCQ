@extends('user.pages.test_master')
@section('content')
@php
date_default_timezone_set("Asia/Dhaka");
$examType = $examInfo->type ?? 'permanent';
$i = 1;

if ($examType == 'permanent') {
    $examTime = $examInfo->examTime ?? 30;
    $startStatus = 1;
} else if ($examType == 'temporary') {
    $startTimesec = strtotime($examInfo->startDate);
    $Upnow = strtotime(date('Y-m-d, h:i:sa'));
    $now = time();
    if ($Upnow < $startTimesec) { 
        $startStatus = 0; 
    } else if ($Upnow > $startTimesec) { 
        $dbexamTime = $examInfo->examTime ?? 30;
        $examDateTime_with_eTime = strtotime($examInfo->startDate.' + '.$dbexamTime.' minute');
        $examTime1 = $examDateTime_with_eTime - $Upnow;
        $examTime = $examTime1 / 60;

        if ($Upnow > $examDateTime_with_eTime) {
            $startStatus = 3; // ended
        } else if ($Upnow < $examDateTime_with_eTime) {
            $startStatus = 1; // ongoing
        }  
    } 
} else {
    $examTime = 30;
    $startStatus = 1;
}
@endphp

<!-- Sticky Exam Top Control Bar -->
<div class="exam-portal-header" style="background: #ffffff; border-bottom: 2px solid #e2e8f0; position: sticky; top: 0; z-index: 1020; box-shadow: 0 4px 12px rgba(15,23,42,0.06);">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 py-1">
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-sm-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-size: 18px;">
                    <i class="feather-edit-3"></i>
                </div>
                <div>
                    <h5 class="mb-0" style="font-size: clamp(16px, 2vw, 20px); font-weight: 700; color: #0f172a;">
                        {{ $examInfo->exam_name ?? 'MCQ Examination' }}
                    </h5>
                    <span class="text-muted" style="font-size: 13px;">
                        Total Questions: <strong style="color: #03c6bb;">{{ count($questions) }}</strong>
                    </span>
                </div>
            </div>

            @if($startStatus == 1)
            <div class="d-flex align-items-center gap-3">
                <!-- Countdown Timer -->
                <div id="clockdiv" class="d-flex align-items-center gap-1 p-2 rounded-3" style="background: #0f172a; color: #ffffff; font-family: var(--font-heading); font-weight: 700;">
                    <i class="feather-clock ms-2 me-1" style="color: #03c6bb; font-size: 18px; animation: pulse 1.5s infinite;"></i>
                    <div class="px-2 py-1 rounded text-center" style="background: #1e293b; min-width: 36px;">
                        <span class="hours" style="font-size: 16px; color: #38bdf8;">00</span>
                        <div style="font-size: 9px; color: #94a3b8; text-transform: uppercase;">Hrs</div>
                    </div>
                    <span style="color: #64748b; font-weight: bold;">:</span>
                    <div class="px-2 py-1 rounded text-center" style="background: #1e293b; min-width: 36px;">
                        <span class="minutes" style="font-size: 16px; color: #38bdf8;">00</span>
                        <div style="font-size: 9px; color: #94a3b8; text-transform: uppercase;">Min</div>
                    </div>
                    <span style="color: #64748b; font-weight: bold;">:</span>
                    <div class="px-2 py-1 rounded text-center me-1" style="background: #1e293b; min-width: 36px;">
                        <span class="seconds" style="font-size: 16px; color: #f43f5e;">00</span>
                        <div style="font-size: 9px; color: #94a3b8; text-transform: uppercase;">Sec</div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" onclick="confirmExamSubmit()" class="rbt-btn btn-sm btn-gradient radius-round px-4">
                    <span>Submit</span>
                    <i class="feather-check ms-1"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="rbt-section-gapTop pb--80 bg-color-white" style="min-height: 80vh;">
    <div class="container">
        @if($startStatus == 1)
            <input type="hidden" id="examTime" value="{{ $examTime }}">

            <form id="mcqExamForm" method="POST" action="{{ route('user.mcq_exam.confirm') }}">
                @csrf
                <input type="hidden" name="examID" value="{{ $examInfo->exam_id ?? $examInfo->id }}">
                <input type="hidden" name="userID" value="{{ $userID }}">

                <div class="row justify-content-center">
                    <div class="col-lg-9 col-md-11 col-12">
                        @foreach($questions as $Question)
                            <div class="exam-question-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="exam-question-number">Question {{ $i }} of {{ count($questions) }}</span>
                                    <div class="d-flex gap-2">
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                                            +{{ $Question->mark }} Marks
                                        </span>
                                        @if(!empty($Question->negativeMark) && $Question->negativeMark > 0)
                                            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                                                -{{ $Question->negativeMark }} Negative
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="exam-question-text">
                                    {!! $Question->questions !!}
                                </div>

                                <input type="hidden" value="{{ $i }}" name="count[]">
                                <input type="hidden" value="{{ $Question->mark }}" name="mark[]">
                                <input type="hidden" value="{{ $Question->negativeMark }}" name="negativeMark[]">
                                <input type="hidden" value="{{ $Question->rightAns }}" name="r[]">
                                <input type="hidden" value="{{ $Question->id }}" name="qid[]">

                                <div class="d-flex flex-column gap-2 mt-3">
                                    <!-- Option 1 -->
                                    <label class="exam-option-item" for="opt_{{ $Question->id }}_1">
                                        <input type="radio" id="opt_{{ $Question->id }}_1" name="selectedOption{{ $Question->id }}" value="1">
                                        <div class="exam-option-label">
                                            <span class="exam-option-key">A</span>
                                            <span>{{ $Question->optn1 }}</span>
                                        </div>
                                    </label>

                                    <!-- Option 2 -->
                                    <label class="exam-option-item" for="opt_{{ $Question->id }}_2">
                                        <input type="radio" id="opt_{{ $Question->id }}_2" name="selectedOption{{ $Question->id }}" value="2">
                                        <div class="exam-option-label">
                                            <span class="exam-option-key">B</span>
                                            <span>{{ $Question->optn2 }}</span>
                                        </div>
                                    </label>

                                    <!-- Option 3 -->
                                    <label class="exam-option-item" for="opt_{{ $Question->id }}_3">
                                        <input type="radio" id="opt_{{ $Question->id }}_3" name="selectedOption{{ $Question->id }}" value="3">
                                        <div class="exam-option-label">
                                            <span class="exam-option-key">C</span>
                                            <span>{{ $Question->optn3 }}</span>
                                        </div>
                                    </label>

                                    <!-- Option 4 -->
                                    <label class="exam-option-item" for="opt_{{ $Question->id }}_4">
                                        <input type="radio" id="opt_{{ $Question->id }}_4" name="selectedOption{{ $Question->id }}" value="4">
                                        <div class="exam-option-label">
                                            <span class="exam-option-key">D</span>
                                            <span>{{ $Question->optn4 }}</span>
                                        </div>
                                    </label>

                                    <!-- Option 5 if present -->
                                    @if(!empty($Question->optn5))
                                        <label class="exam-option-item" for="opt_{{ $Question->id }}_5">
                                            <input type="radio" id="opt_{{ $Question->id }}_5" name="selectedOption{{ $Question->id }}" value="5">
                                            <div class="exam-option-label">
                                                <span class="exam-option-key">E</span>
                                                <span>{{ $Question->optn5 }}</span>
                                            </div>
                                        </label>
                                    @endif
                                </div>
                            </div>
                            @php($i++)
                        @endforeach

                        <!-- Bottom Submit Bar -->
                        <div class="p-4 rounded-4 text-center mt-5" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h5 class="mb-2" style="font-weight: 700;">Ready to finish your exam?</h5>
                            <p class="text-muted mb-4" style="font-size: 14px;">Make sure to review all answers. Once submitted, your score will be computed instantly.</p>
                            <button id="examCompleteButton" type="submit" class="rbt-btn btn-gradient radius-round px-5 py-3">
                                <span class="btn-text">Submit My Final Exam</span>
                                <span class="btn-icon ms-2"><i class="feather-arrow-right"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        @elseif($startStatus == 0)
            <!-- Exam Not Started Yet -->
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12 text-center py-5">
                    <div class="p-5 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 70px; height: 70px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 32px;">
                            <i class="feather-calendar"></i>
                        </div>
                        <h3 style="font-weight: 700;">Exam Has Not Started Yet</h3>
                        <p class="text-muted mt-2">
                            This exam is scheduled to begin on:
                        </p>
                        <div class="p-3 my-3 rounded-3" style="background: #ffffff; border: 1px solid #cbd5e1; font-family: var(--font-heading); font-size: 18px; font-weight: 700; color: #0f172a;">
                            {{ date('d M, Y - h:i:s A', strtotime($examInfo->startDate)) }}
                        </div>
                        <a href="{{ route('all.courses') }}" class="rbt-btn btn-border radius-round mt-3">
                            Back to Exams
                        </a>
                    </div>
                </div>
            </div>

        @elseif($startStatus == 3)
            <!-- Exam Expired -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="p-4 rounded-4 mb-4 text-center" style="background: #fff1f2; border: 1px solid #fecdd3;">
                        <h3 class="text-danger mb-2" style="font-weight: 700;"><i class="feather-alert-circle me-2"></i> This Exam Has Ended</h3>
                        <p class="text-muted mb-0">The scheduled time for this exam has passed. The questions are displayed below for study review.</p>
                    </div>

                    @foreach($questions as $Question)
                        <div class="exam-question-card mb-4">
                            <span class="exam-question-number">Question {{ $i }}</span>
                            <div class="exam-question-text">{!! $Question->questions !!}</div>
                            <div class="d-flex flex-column gap-2 mt-3">
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;"><strong>A)</strong> {{ $Question->optn1 }}</div>
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;"><strong>B)</strong> {{ $Question->optn2 }}</div>
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;"><strong>C)</strong> {{ $Question->optn3 }}</div>
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;"><strong>D)</strong> {{ $Question->optn4 }}</div>
                            </div>
                        </div>
                        @php($i++)
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function confirmExamSubmit() {
    if (confirm("Are you sure you want to submit your exam now?")) {
        document.getElementById('examCompleteButton').click();
    }
}

// Countdown timer script
document.addEventListener("DOMContentLoaded", function() {
    const examTimeInput = document.getElementById('examTime');
    if (!examTimeInput) return;

    let totalSeconds = Math.max(1, Math.floor(parseFloat(examTimeInput.value) * 60));
    const clockEl = document.getElementById('clockdiv');
    if (!clockEl) return;

    const hoursSpan = clockEl.querySelector('.hours');
    const minutesSpan = clockEl.querySelector('.minutes');
    const secondsSpan = clockEl.querySelector('.seconds');

    function renderTime() {
        if (totalSeconds <= 0) {
            clearInterval(timerInterval);
            alert("Time is up! Submitting your exam automatically...");
            document.getElementById('examCompleteButton').click();
            return;
        }

        const hrs = Math.floor(totalSeconds / 3600);
        const mins = Math.floor((totalSeconds % 3600) / 60);
        const secs = totalSeconds % 60;

        if (hoursSpan) hoursSpan.textContent = String(hrs).padStart(2, '0');
        if (minutesSpan) minutesSpan.textContent = String(mins).padStart(2, '0');
        if (secondsSpan) secondsSpan.textContent = String(secs).padStart(2, '0');

        totalSeconds--;
    }

    renderTime();
    const timerInterval = setInterval(renderTime, 1000);
});
</script>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.1); }
}
</style>

@endsection
