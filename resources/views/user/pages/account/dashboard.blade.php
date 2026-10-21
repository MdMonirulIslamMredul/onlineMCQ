@extends('user.pages.test_master')
@section('content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name') ?: 'Student';
$userQ = DB::table('users')->where('id', $userID)->first();

$attendExams = DB::table('results')
    ->join('exams', 'results.examID', '=', 'exams.id')
    ->select('results.*', 'exams.exam_name')
    ->where('results.userID', optional($userQ)->id)
    ->latest()
    ->get();

$orders = DB::table('books_order')
    ->where('phone', optional($userQ)->phone)
    ->orWhere('email', optional($userQ)->email)
    ->orderBy('id', 'desc')
    ->get();

$course = DB::table('courses_order')
    ->where('phone', optional($userQ)->phone)
    ->orWhere('email', optional($userQ)->email)
    ->orderBy('id', 'desc')
    ->get();

$unfinishedPracticeQuizzes = \App\Models\PracticeSession::where('user_id', optional($userQ)->id)
    ->where('status', 'in_progress')
    ->with('quiz')
    ->get();

$completedPracticeQuizzes = \App\Models\PracticeSession::where('user_id', optional($userQ)->id)
    ->where('status', 'completed')
    ->with('quiz')
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
                        <li style="color: #03c6bb; font-weight: 600;">Student Dashboard</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-user"></i> Student Learning Portal
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
                    Welcome back, {{ $userName }}!
                </h1>
                <p class="student-hero-desc mb-0">
                    Track your exam preparation progress, review test performances, and continue course modules.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('all.courses') }}" class="rbt-btn btn-gradient radius-round">
                    <span class="btn-text">Take a Practice Exam</span>
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
                        <a href="{{ route('user.myaccount.dashboard') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
                            <i class="feather-grid"></i> Dashboard
                        </a>
                        <a href="{{ route('user.myaccount.courses') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-book-open"></i> Enrolled Courses ({{ $course->count() }})
                        </a>
                        <a href="{{ route('user.myaccount.exam') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-check-square"></i> My Quiz Attempts ({{ $attendExams->count() }})
                        </a>
                        <a href="{{ route('practice_quiz.index') }}" class="p-3 rounded-3 d-flex align-items-center justify-content-between text-decoration-none text-muted" style="transition: all 0.2s;">
                            <span class="d-flex align-items-center gap-3">
                                <i class="feather-zap text-warning"></i> Preparation Quizzes
                            </span>
                            @if($unfinishedPracticeQuizzes->isNotEmpty())
                                <span class="badge bg-danger rounded-pill" style="font-size: 11px;">{{ $unfinishedPracticeQuizzes->count() }} Active</span>
                            @endif
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
                <!-- Unfinished Quiz Sessions Notification Banner -->
                @if($unfinishedPracticeQuizzes->isNotEmpty())
                    <div class="mb-4">
                        @foreach($unfinishedPracticeQuizzes as $unf)
                            <div class="p-4 rounded-4 mb-3" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(239, 68, 68, 0.12) 100%); border: 2px solid rgba(245, 158, 11, 0.4); box-shadow: 0 6px 20px rgba(245, 158, 11, 0.12);">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; font-size: 22px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);">
                                            <i class="feather-bell"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge bg-warning text-dark font-weight-bold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    ⚡ Action Required
                                                </span>
                                                <span class="text-muted small" style="font-size: 13px;">You have an unfinished preparation quiz</span>
                                            </div>
                                            <h5 class="mb-1" style="font-weight: 700; color: #0f172a;">
                                                {{ $unf->quiz->title ?? 'Preparation Quiz' }}
                                            </h5>
                                            <div class="d-flex align-items-center gap-3 text-muted small">
                                                <span><i class="feather-check-circle text-success"></i> <strong>{{ $unf->mastered_questions }}</strong> of {{ $unf->total_questions }} mastered</span>
                                                <span>•</span>
                                                <span><i class="feather-trending-up text-primary"></i> <strong>{{ $unf->progress_percent }}%</strong> completed</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('practice_quiz.play', $unf->id) }}" class="btn btn-gradient rounded-pill px-4 py-2 font-weight-bold d-inline-flex align-items-center gap-2" style="background: linear-gradient(90deg, #f59e0b, #ef4444); color: #ffffff; text-decoration: none; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                                            <span>Finish Quiz Now</span>
                                            <i class="feather-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-3 progress" style="height: 6px; background: rgba(0,0,0,0.06); border-radius: 6px;">
                                    <div class="progress-bar" style="width: {{ $unf->progress_percent }}%; background: linear-gradient(90deg, #f59e0b, #ef4444); border-radius: 6px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- KPI Widgets Row -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="student-kpi-card h-100">
                            <div class="student-kpi-icon icon-teal">
                                <i class="feather-book-open"></i>
                            </div>
                            <div class="student-kpi-num">{{ $course->count() }}</div>
                            <div class="student-kpi-label">Enrolled Courses</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="student-kpi-card h-100">
                            <div class="student-kpi-icon icon-indigo">
                                <i class="feather-check-circle"></i>
                            </div>
                            <div class="student-kpi-num">{{ $attendExams->count() }}</div>
                            <div class="student-kpi-label">Model Exams Taken</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="student-kpi-card h-100">
                            <div class="student-kpi-icon icon-green">
                                <i class="feather-award"></i>
                            </div>
                            <div class="student-kpi-num">{{ $course->where('status', 'completed')->count() }}</div>
                            <div class="student-kpi-label">Completed Courses</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Exam Attempts Card -->
                <div class="p-4 rounded-4 shadow-sm mb-4" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                        <h4 class="mb-0" style="font-weight: 700; font-size: 20px; color: #0f172a;">
                            <i class="feather-clock me-2" style="color: #03c6bb;"></i> Recent Exam Attempts
                        </h4>
                        <a href="{{ route('all.courses') }}" class="btn btn-sm" style="color: #03c6bb; font-weight: 600; text-decoration: none;">
                            Take Another Exam <i class="feather-arrow-right"></i>
                        </a>
                    </div>

                    @if($attendExams->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Exam Name</th>
                                        <th>Marks</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendExams->take(5) as $examAttempt)
                                        <tr>
                                            <td class="fw-bold" style="color: #1e293b;">
                                                {{ $examAttempt->exam_name }}
                                            </td>
                                            <td>
                                                <span class="badge" style="background: rgba(3, 198, 187, 0.12); color: #009e95; font-size: 13px; font-weight: 700; padding: 4px 10px; border-radius: 9999px;">
                                                    {{ $examAttempt->obtained_mark ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success-light text-success fw-bold px-2 py-1 rounded">
                                                    Submitted
                                                </span>
                                            </td>
                                            <td class="text-muted" style="font-size: 13px;">
                                                {{ date('d M, Y', strtotime($examAttempt->created_at)) }}
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ url('/exam-result/' . $examAttempt->examID . '/' . $userID) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <i class="feather-edit-3 text-muted" style="font-size: 32px;"></i>
                            <h5 class="mt-3 text-muted">No exam attempts recorded yet.</h5>
                            <p class="text-muted" style="font-size: 14px;">Test your knowledge now with timed model tests.</p>
                            <a href="{{ route('all.courses') }}" class="rbt-btn btn-sm btn-gradient radius-round mt-2">
                                Start Your First Exam
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Preparation Quizzes (Spaced Repetition) Card -->
                <div class="p-4 rounded-4 shadow-sm mb-4" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                        <h4 class="mb-0" style="font-weight: 700; font-size: 20px; color: #0f172a;">
                            <i class="feather-zap me-2" style="color: #f59e0b;"></i> Preparation Quizzes (Active Recall)
                        </h4>
                        <a href="{{ route('practice_quiz.index') }}" class="btn btn-sm" style="color: #03c6bb; font-weight: 600; text-decoration: none;">
                            Browse All Practice Quizzes <i class="feather-arrow-right"></i>
                        </a>
                    </div>

                    @php
                        $allStudentSessions = \App\Models\PracticeSession::where('user_id', optional($userQ)->id)
                            ->with('quiz')
                            ->orderBy('updated_at', 'desc')
                            ->get();
                    @endphp

                    @if($allStudentSessions->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light text-muted" style="font-size: 13px;">
                                    <tr>
                                        <th>Quiz Title</th>
                                        <th>Mastery Progress</th>
                                        <th>Attempts</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allStudentSessions as $stSession)
                                        <tr>
                                            <td class="fw-bold" style="color: #1e293b;">
                                                {{ $stSession->quiz->title ?? 'Practice Quiz' }}
                                            </td>
                                            <td style="min-width: 140px;">
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>{{ $stSession->mastered_questions }}/{{ $stSession->total_questions }}</span>
                                                    <span class="font-weight-bold">{{ $stSession->progress_percent }}%</span>
                                                </div>
                                                <div class="progress" style="height: 6px; border-radius: 6px;">
                                                    <div class="progress-bar" style="width: {{ $stSession->progress_percent }}%; background: linear-gradient(90deg, #03c6bb, #4f46e5); border-radius: 6px;"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $stSession->total_attempts }} attempts</span>
                                            </td>
                                            <td>
                                                @if($stSession->status === 'completed')
                                                    <span class="badge bg-success-light text-success fw-bold px-2 py-1 rounded">
                                                        ✔ Mastered
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning-light text-warning fw-bold px-2 py-1 rounded">
                                                        In Progress
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ $stSession->status === 'completed' ? route('practice_quiz.start', ['id' => $stSession->practice_quiz_id, 'restart' => 1]) : route('practice_quiz.play', $stSession->id) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                    {{ $stSession->status === 'completed' ? 'Practice Again' : 'Continue' }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <i class="feather-zap text-muted" style="font-size: 32px;"></i>
                            <h5 class="mt-3 text-muted">No preparation quizzes started yet.</h5>
                            <p class="text-muted" style="font-size: 14px;">Memorize questions through active spaced-repetition.</p>
                            <a href="{{ route('practice_quiz.index') }}" class="rbt-btn btn-sm btn-gradient radius-round mt-2">
                                Explore Practice Quizzes
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Enrolled Courses Quick Preview -->
                <div class="p-4 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                        <h4 class="mb-0" style="font-weight: 700; font-size: 20px; color: #0f172a;">
                            <i class="feather-book me-2" style="color: #4f46e5;"></i> My Enrolled Courses
                        </h4>
                        <a href="{{ route('course') }}" class="btn btn-sm" style="color: #4f46e5; font-weight: 600; text-decoration: none;">
                            Browse All Courses <i class="feather-arrow-right"></i>
                        </a>
                    </div>

                    @if($course->count() > 0)
                        <div class="row g-3">
                            @foreach($course->take(3) as $c)
                                <div class="col-md-6 col-12">
                                    <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <div>
                                            <h6 class="mb-1" style="font-weight: 700; color: #0f172a;">Course #{{ $c->course_id }}</h6>
                                            <span class="badge bg-success-light text-success fw-bold px-2 py-1 rounded">Active</span>
                                        </div>
                                        <a href="{{ url('/course/' . $c->course_id) }}" class="rbt-btn btn-xs btn-border radius-round">
                                            Continue
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <p class="text-muted mb-2">You have not enrolled in any video courses yet.</p>
                            <a href="{{ route('course') }}" class="rbt-btn btn-sm btn-gradient radius-round">
                                Explore Courses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
