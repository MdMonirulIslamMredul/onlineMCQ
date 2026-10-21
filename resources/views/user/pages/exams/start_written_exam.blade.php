@extends('user.pages.test_master')
@section('content')
@php
date_default_timezone_set("Asia/Dhaka");
$examType = $examInfo->type ?? 'permanent';
$questions = DB::table('written_questions')->where('examID', $examInfo->exam_id)->get();
$i = 1;

if ($examType == 'permanent') {
    $examTime = $examInfo->examTime ?? 60;
    $startStatus = 1;
} else if ($examType == 'temporary') {
    $startTimesec = strtotime($examInfo->startDate);
    $Upnow = strtotime(date('Y-m-d h:i:sa'));
    $now = time();
    if ($Upnow < $startTimesec) {
        $startStatus = 0;
    } else if ($Upnow > $startTimesec) {
        $dbexamTime = $examInfo->examTime ?? 60;
        $examDateTime_with_eTime = strtotime($examInfo->startDate.' + '.$dbexamTime.' minute');
        $examTime1 = $examDateTime_with_eTime - $Upnow;
        $examTime = $examTime1 / 60;
        if ($Upnow > $examDateTime_with_eTime) {
            $startStatus = 3;
        } else if ($Upnow < $examDateTime_with_eTime) {
            $startStatus = 1;
        }
    }
} else {
    $examTime = 60;
    $startStatus = 1;
}
@endphp

<!-- Sticky Exam Top Control Bar -->
<div class="exam-portal-header" style="background: #ffffff; border-bottom: 2px solid #e2e8f0; position: sticky; top: 0; z-index: 1020; box-shadow: 0 4px 12px rgba(15,23,42,0.06);">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 py-1">
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-sm-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 18px;">
                    <i class="feather-edit-3"></i>
                </div>
                <div>
                    <h5 class="mb-0" style="font-size: clamp(16px, 2vw, 20px); font-weight: 700; color: #0f172a;">
                        {{ $examInfo->exam_name ?? 'Written Examination' }}
                    </h5>
                    <span class="text-muted" style="font-size: 13px;">
                        Total Questions: <strong style="color: #4f46e5;">{{ count($questions) }}</strong>
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

            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11 col-12">
                    @if(!empty($examInfo->written_paragraph))
                    <div class="p-4 rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h5 class="mb-2" style="font-weight: 700; color: #0f172a;"><i class="feather-book-open me-2" style="color: #4f46e5;"></i> Passage Instructions</h5>
                        <div style="line-height: 1.7; color: #334155;">
                            {!! $examInfo->written_paragraph !!}
                        </div>
                    </div>
                    @endif

                    <form id="writtenExamForm" method="POST" action="{{ route('user.written_exam.confirm') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="examID" value="{{ $examInfo->exam_id }}">
                        <input type="hidden" name="userID" value="{{ $userID }}">

                        @foreach($questions as $idx => $Question)
                            <div class="exam-question-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="exam-question-number">Question {{ $idx + 1 }} of {{ count($questions) }}</span>
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                                        {{ $Question->mark }} Marks
                                    </span>
                                </div>

                                <div class="exam-question-text">
                                    {!! $Question->questions !!}
                                </div>

                                <input type="hidden" value="{{ $Question->mark }}" name="mark[]">
                                <input type="hidden" value="{{ $Question->id }}" name="qid[]">

                                <div class="mt-3">
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; font-size: 14px;">Attach Document / Image (Optional):</label>
                                        <input type="file" class="form-control" name="file_path[]" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 10px;">
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-weight: 600; font-size: 14px;">Your Written Answer:</label>
                                        <textarea class="form-control" name="ans[]" rows="5" placeholder="Write your complete answer here..." style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 14px; font-size: 15px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="p-4 rounded-4 text-center mt-5" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h5 class="mb-2" style="font-weight: 700;">Finished Writing?</h5>
                            <p class="text-muted mb-4" style="font-size: 14px;">Submit your answers to send them for instructor evaluation.</p>
                            <button id="examCompleteButton" type="submit" class="rbt-btn btn-gradient radius-round px-5 py-3">
                                <span class="btn-text">Submit Written Exam</span>
                                <span class="btn-icon ms-2"><i class="feather-arrow-right"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @elseif($startStatus == 0)
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12 text-center py-5">
                    <div class="p-5 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <i class="feather-calendar text-primary" style="font-size: 40px;"></i>
                        <h3 class="mt-3" style="font-weight: 700;">Exam Has Not Started Yet</h3>
                        <p class="text-muted">Scheduled start time: {{ date('d M, Y - h:i:s A', strtotime($examInfo->startDate)) }}</p>
                    </div>
                </div>
            </div>

        @elseif($startStatus == 3)
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 text-center py-5">
                    <div class="p-4 rounded-4" style="background: #fff1f2; border: 1px solid #fecdd3;">
                        <h3 class="text-danger" style="font-weight: 700;">Exam Has Ended</h3>
                        <p class="text-muted">The allocated submission window for this written exam is closed.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function confirmExamSubmit() {
    if (confirm("Are you sure you want to submit your written exam now?")) {
        document.getElementById('examCompleteButton').click();
    }
}

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
