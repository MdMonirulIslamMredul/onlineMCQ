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

$regDate = optional($userQ)->created_at ? \Carbon\Carbon::parse($userQ->created_at)->format('F d, Y') : 'N/A';
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
                        <li style="color: #03c6bb; font-weight: 600;">Student Profile</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-user-check"></i> Account Details
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
                    My Profile & Settings
                </h1>
                <p class="student-hero-desc mb-0">
                    Manage your personal account credentials, contact phone number, and student profile information.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.myaccount.psetting') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text"><i class="feather-edit-2 me-1"></i> Edit Information</span>
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
                        <a href="{{ route('user.myaccount.exam') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none text-muted" style="transition: all 0.2s;">
                            <i class="feather-check-square"></i> My Quiz Attempts ({{ $attendExams->count() }})
                        </a>
                        <a href="{{ route('user.myaccount.profile') }}" class="p-3 rounded-3 d-flex align-items-center gap-3 text-decoration-none" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700;">
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
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <i class="feather-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="d-flex align-items-center justify-content-between pb-4 mb-4 border-bottom">
                        <div>
                            <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 22px;">Student Profile Overview</h3>
                            <p class="text-muted mb-0" style="font-size: 14px;">Your registered information on Pathjolpona platform.</p>
                        </div>
                        <a href="{{ route('user.myaccount.psetting') }}" class="rbt-btn btn-sm btn-gradient radius-round">
                            <span class="btn-text">Edit Details</span>
                            <span class="btn-icon"><i class="feather-edit"></i></span>
                        </a>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-12">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">FULL NAME</span>
                                <span style="font-weight: 700; color: #0f172a; font-size: 16px;">{{ $userName }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">PHONE NUMBER</span>
                                <span style="font-weight: 700; color: #0f172a; font-size: 16px;">{{ optional($userQ)->phone ?? 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">EMAIL ADDRESS</span>
                                <span style="font-weight: 700; color: #0f172a; font-size: 16px;">{{ optional($userQ)->email ?? 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">JOINED DATE</span>
                                <span style="font-weight: 700; color: #0f172a; font-size: 16px;">{{ $regDate }}</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">MAILING ADDRESS</span>
                                <span style="font-weight: 700; color: #0f172a; font-size: 16px;">{{ optional($userQ)->address ?? 'No address registered yet.' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Quick Summary Banner -->
                    <div class="mt-5 p-4 rounded-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: linear-gradient(135deg, rgba(3, 198, 187, 0.08) 0%, rgba(79, 70, 229, 0.08) 100%); border: 1px solid rgba(3, 198, 187, 0.2);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #03c6bb; color: #ffffff; font-size: 20px;">
                                <i class="feather-shield"></i>
                            </div>
                            <div>
                                <h5 class="mb-0" style="font-weight: 700; color: #0f172a;">Verified Student Account</h5>
                                <p class="text-muted mb-0" style="font-size: 13px;">Your account is fully activated and eligible for live tests and certificate issue.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
