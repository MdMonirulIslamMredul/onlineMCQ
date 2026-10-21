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
                        <li style="color: #03c6bb; font-weight: 600;">Enrolled Courses</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-book-open"></i> Student Classroom
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
                    My Enrolled Courses
                </h1>
                <p class="student-hero-desc mb-0">
                    Access your course modules, lecture notes, and classroom video resources anytime.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('course') }}" class="rbt-btn btn-gradient radius-round">
                    <span class="btn-text">Browse More Courses</span>
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
                        <a href="{{ route('user.myaccount.courses') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
                            <i class="feather-book-open"></i> Enrolled Courses ({{ $courses->count() }})
                        </a>
                        <a href="{{ route('user.myaccount.exam') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-check-square"></i> My Quiz Attempts ({{ $attendExams->count() }})
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
                        <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 22px;">My Learning Modules</h3>
                        <p class="text-muted mb-0" style="font-size: 14px;">Courses you currently have full access to study.</p>
                    </div>
                    <span class="badge px-3 py-2 rounded-pill" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
                        {{ $courses->count() }} Active
                    </span>
                </div>

                @if($courses->count() > 0)
                    <div class="row g-4">
                        @foreach ($courses as $course)
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="modern-course-card h-100 d-flex flex-column">
                                    <div class="modern-course-thumb" style="height: 180px;">
                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/course-cat-default.jpg') }}';">
                                        <span class="badge position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill" style="background: #10b981; color: #fff; font-weight: 700; font-size: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                            Enrolled & Active
                                        </span>
                                    </div>
                                    <div class="modern-course-body d-flex flex-column flex-grow-1">
                                        <h4 class="modern-course-title mb-2" style="font-size: 18px;">{{ $course->name }}</h4>
                                        <div class="d-flex align-items-center gap-3 text-muted mb-4" style="font-size: 13px;">
                                            <span><i class="feather-video me-1"></i> Video Lectures</span>
                                            <span><i class="feather-file-text me-1"></i> Lecture PDF</span>
                                        </div>
                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ url('/lession/'.$course->id.'/'.$course->name) }}" class="rbt-btn btn-gradient btn-sm radius-round w-100 text-center">
                                                <span class="btn-text">Enter Classroom</span>
                                                <span class="btn-icon"><i class="feather-play-circle"></i></span>
                                            </a>
                                            <a href="{{ route('course.detail', $course->id) }}" class="rbt-btn btn-border btn-sm radius-round" title="Course Info">
                                                <i class="feather-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5 px-4 rounded-4" style="background: #f8fafc; border: 2px dashed #e2e8f0;">
                        <div class="mb-3 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; background: rgba(3, 198, 187, 0.1); color: #03c6bb; font-size: 32px;">
                            <i class="feather-book-open"></i>
                        </div>
                        <h4 style="font-weight: 700; color: #0f172a;" class="mb-2">No Enrolled Courses Found</h4>
                        <p class="text-muted mb-4" style="max-width: 420px; margin: 0 auto; font-size: 14px;">
                            You haven't enrolled in any courses yet. Browse our comprehensive syllabus catalog to start your learning journey today!
                        </p>
                        <a href="{{ route('course') }}" class="rbt-btn btn-gradient radius-round">
                            <span class="btn-text">Discover Courses</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
