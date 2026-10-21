@extends('user.pages.test_master')

@section('content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name') ?: 'Student';
$userQ = DB::table('users')->where('id', $userID)->first();

$attendExams = DB::table('results')
    ->join('exams', 'results.examID', 'exams.id')
    ->select('results.*', 'exams.exam_name')
    ->where('results.userID', optional($userQ)->id)
    ->latest()
    ->get();

$practiceSessions = \App\Models\PracticeSession::where('user_id', optional($userQ)->id)
    ->with('quiz')
    ->orderBy('updated_at', 'desc')
    ->get();

$courseOrders = DB::table('courses_order')
    ->where('phone', optional($userQ)->phone)
    ->orWhere('email', optional($userQ)->email)
    ->orderBy('id', 'desc')
    ->get(['pid']);
$courseIds = $courseOrders->pluck('pid');
$courses = DB::table('courses')
    ->whereIn('id', $courseIds)
    ->get();
@endphp

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 50px 0 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li><a href="{{ route('user.myaccount.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Quiz Attempts</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-check-circle"></i> Examination History
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
                    My Exam & Quiz Attempts
                </h1>
                <p class="student-hero-desc mb-0">
                    Review your complete examination record, detailed question breakdown, and performance metrics.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('/') }}#exam-categories" class="rbt-btn btn-gradient radius-round">
                    <span class="btn-text">Take Another Test</span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Area -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-md-4 col-12">
                <div class="p-4 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; position: sticky; top: 90px;">
                    <!-- Student Mini Profile -->
                    <div class="text-center pb-4 mb-4 border-bottom">
                        <div class="mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #03c6bb 0%, #4f46e5 100%); color: #ffffff; font-size: 32px; font-weight: 800; box-shadow: 0 6px 16px rgba(3, 198, 187, 0.3);">
                            {{ strtoupper(substr($userName, 0, 1)) }}
                        </div>
                        <h5 class="mb-1" style="font-weight: 700; color: #0f172a;">{{ $userName }}</h5>
                        <span class="text-muted" style="font-size: 13px;">{{ optional($userQ)->phone ?? optional($userQ)->email }}</span>
                    </div>

                    <!-- Navigation Items -->
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('user.myaccount.dashboard') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-grid"></i> Dashboard
                        </a>
                        <a href="{{ route('user.myaccount.courses') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-book-open"></i> Enrolled Courses ({{ $courses->count() }})
                        </a>
                        <a href="{{ route('user.myaccount.exam') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
                            <i class="feather-check-square"></i> My Quiz Attempts ({{ $attendExams->count() + $practiceSessions->count() }})
                        </a>
                        <a href="{{ route('user.myaccount.profile') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-user"></i> My Profile
                        </a>
                        <a href="{{ route('user.logout') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-danger mt-3 border-top pt-3" style="font-weight: 600;">
                            <i class="feather-log-out"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-8 col-12">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 22px;">Completed Assessments</h3>
                        <p class="text-muted mb-0" style="font-size: 14px;">Every exam you have submitted with full analytical breakdown.</p>
                    </div>
                    <span class="badge px-3 py-2 rounded-pill" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
                        {{ $attendExams->count() }} Submissions
                    </span>
                </div>

                @if($attendExams->count() > 0)
                    <div class="table-responsive rounded-4 shadow-sm" style="border: 1px solid #e2e8f0; background: #ffffff;">
                        <table class="table align-middle mb-0" style="font-size: 14px;">
                            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th class="py-3 px-4" style="font-weight: 700; color: #475569;">Exam & Details</th>
                                    <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Format</th>
                                    <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Score</th>
                                    <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Date & Time</th>
                                    <th class="py-3 px-4 text-end" style="font-weight: 700; color: #475569;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendExams as $resultExam)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($resultExam->created_at);
                                    @endphp
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td class="py-3 px-4">
                                            <div style="font-weight: 700; color: #0f172a; font-size: 15px;">{{ $resultExam->exam_name }}</div>
                                            <div class="text-muted" style="font-size: 12px;">Exam ID: #{{ $resultExam->examID }}</div>
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($resultExam->mcq_written == 'mcq')
                                                <span class="badge px-2 py-1 rounded-pill" style="background: rgba(3, 198, 187, 0.12); color: #009e95; font-weight: 700; font-size: 11px;">
                                                    <i class="feather-check-circle me-1"></i> MCQ Test
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1 rounded-pill" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-weight: 700; font-size: 11px;">
                                                    <i class="feather-edit-3 me-1"></i> Written Test
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            @if(isset($resultExam->score))
                                                <span class="badge px-3 py-1 rounded-pill" style="background: #f1f5f9; color: #0f172a; font-weight: 800; font-size: 13px;">
                                                    {{ $resultExam->score }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-muted" style="font-size: 13px;">
                                            <div>{{ $createdAt->format('M d, Y') }}</div>
                                            <div style="font-size: 11px;">{{ $createdAt->format('h:i A') }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-end">
                                            @if($resultExam->mcq_written == 'mcq')
                                                <a href="{{ url('/mcq-result/'.$resultExam->examID.'/'.$resultExam->exam_name) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                    <span class="btn-text">View Result</span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </a>
                                            @elseif($resultExam->mcq_written == 'written' && $resultExam->written_status == 'pending')
                                                <span class="badge px-2 py-1 rounded-pill bg-warning text-dark" style="font-size: 11px;">Under Evaluation</span>
                                            @else
                                                <a href="{{ url('/written-result/'.$resultExam->examID.'/'.$resultExam->exam_name) }}" class="rbt-btn btn-xs btn-border radius-round">
                                                    <span class="btn-text">Review Feedback</span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State for Live Mock Tests if none -->
                    <div class="text-center py-4 px-4 rounded-4 mb-4" style="background: #f8fafc; border: 2px dashed #e2e8f0;">
                        <h5 style="font-weight: 700; color: #0f172a;" class="mb-1">No Timed Mock Exams Yet</h5>
                        <p class="text-muted mb-3" style="max-width: 420px; margin: 0 auto; font-size: 13px;">
                            You haven't participated in live timed mock tests yet.
                        </p>
                        <a href="{{ route('/') }}#exam-categories" class="rbt-btn btn-xs btn-gradient radius-round">
                            Explore Exam Categories
                        </a>
                    </div>
                @endif

                <!-- Preparation / Active Recall Practice History -->
                <div class="mt-5">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 22px;">
                                <i class="feather-zap me-2" style="color: #f59e0b;"></i> Preparation Quiz Attempts
                            </h3>
                            <p class="text-muted mb-0" style="font-size: 14px;">Your active spaced-repetition practice sessions, accuracy rates, and mastery progress.</p>
                        </div>
                        <span class="badge px-3 py-2 rounded-pill" style="background: rgba(245, 158, 11, 0.1); color: #d97706; font-weight: 700;">
                            {{ $practiceSessions->count() }} Sessions
                        </span>
                    </div>

                    @if($practiceSessions->count() > 0)
                        <div class="table-responsive rounded-4 shadow-sm" style="border: 1px solid #e2e8f0; background: #ffffff;">
                            <table class="table align-middle mb-0" style="font-size: 14px;">
                                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                    <tr>
                                        <th class="py-3 px-4" style="font-weight: 700; color: #475569;">Quiz Title</th>
                                        <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Mastery</th>
                                        <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Accuracy & Attempts</th>
                                        <th class="py-3 px-3" style="font-weight: 700; color: #475569;">Date & Time</th>
                                        <th class="py-3 px-4 text-end" style="font-weight: 700; color: #475569;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($practiceSessions as $ps)
                                        @php
                                            $psDate = $ps->completed_at ?: $ps->updated_at;
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td class="py-3 px-4">
                                                <div style="font-weight: 700; color: #0f172a; font-size: 15px;">{{ $ps->quiz->title ?? 'Practice Quiz' }}</div>
                                                <div class="text-muted" style="font-size: 12px;">Session #{{ $ps->id }}</div>
                                            </td>
                                            <td class="py-3 px-3">
                                                @if($ps->status === 'completed')
                                                    <span class="badge px-2 py-1 rounded-pill" style="background: rgba(16, 185, 129, 0.12); color: #059669; font-weight: 700; font-size: 11px;">
                                                        <i class="feather-check-circle me-1"></i> 100% Mastered
                                                    </span>
                                                @else
                                                    <span class="badge px-2 py-1 rounded-pill" style="background: rgba(245, 158, 11, 0.12); color: #d97706; font-weight: 700; font-size: 11px;">
                                                        <i class="feather-clock me-1"></i> In Progress ({{ $ps->progress_percent }}%)
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3">
                                                <span class="badge px-3 py-1 rounded-pill" style="background: #f1f5f9; color: #0f172a; font-weight: 800; font-size: 13px;">
                                                    {{ $ps->accuracy_percent }}% Accuracy
                                                </span>
                                                <span class="text-muted small ms-1">({{ $ps->total_attempts }} attempts)</span>
                                            </td>
                                            <td class="py-3 px-3 text-muted" style="font-size: 13px;">
                                                <div>{{ $psDate ? $psDate->format('M d, Y') : '-' }}</div>
                                                <div style="font-size: 11px;">{{ $psDate ? $psDate->format('h:i A') : '' }}</div>
                                            </td>
                                            <td class="py-3 px-4 text-end">
                                                <div class="d-inline-flex gap-1 justify-content-end">
                                                    @if($ps->status === 'completed')
                                                        <a href="{{ route('practice_quiz.start', ['id' => $ps->practice_quiz_id, 'restart' => 1]) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                            Practice Again
                                                        </a>
                                                        <a href="{{ route('practice_quiz.review', $ps->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" title="Review Explanations">
                                                            <i class="feather-book-open"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('practice_quiz.play', $ps->id) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                            Resume
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 px-4 rounded-4" style="background: #f8fafc; border: 1px dashed #e2e8f0;">
                            <p class="text-muted mb-2" style="font-size: 14px;">No active recall practice sessions started yet.</p>
                            <a href="{{ route('practice_quiz.index') }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                Browse Practice Quizzes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
