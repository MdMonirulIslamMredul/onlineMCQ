@extends('user.pages.test_master')
@section('content')
@php
    $teachers = DB::table('teachers')->where('active', 1)->orderBy('id', 'desc')->limit(6)->get();
    $about_info = DB::table('about_infos')->first();
@endphp

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 60px 0 70px;">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ul class="d-flex align-items-center justify-content-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li style="color: #03c6bb; font-weight: 600;">About Us</li>
            </ul>
        </nav>
        <div class="student-hero-badge mx-auto">
            <i class="feather-info"></i> Our Mission & Purpose
        </div>
        <h1 class="student-hero-title mb-3" style="font-size: clamp(30px, 4vw, 46px);">
            Empowering the Next Generation of Learners
        </h1>
        <p class="student-hero-desc mx-auto mb-0" style="max-width: 680px;">
            We bridge academic theory with real-world competitive preparation, giving every student the tools, mentorship, and testing environment needed to excel.
        </p>
    </div>
</div>
<!-- End Hero Area -->

<!-- Start Mission / Core Pillars -->
<div class="rbt-section-gapTop bg-color-white">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="p-4 rounded-4 h-100 shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 56px; height: 56px; background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-size: 24px;">
                        <i class="feather-target"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #0f172a; margin-bottom: 10px;">Our Mission</h5>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0;">
                        To provide accessible, high-standard digital education and rigorous model test simulations to learners everywhere.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="p-4 rounded-4 h-100 shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 56px; height: 56px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 24px;">
                        <i class="feather-eye"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #0f172a; margin-bottom: 10px;">Our Vision</h5>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0;">
                        To become the leading national EdTech ecosystem for professional skills, competitive exam training, and lifelong career growth.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="p-4 rounded-4 h-100 shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 56px; height: 56px; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 24px;">
                        <i class="feather-award"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #0f172a; margin-bottom: 10px;">Student Focus</h5>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0;">
                        Every feature, timer, and question explanation is engineered to make learning intuitive, clear, and stress-free.
                    </p>
                </div>
            </div>
        </div>

        <!-- About Story Area -->
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-6 col-12">
                <div class="pe-lg-4">
                    <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 12px; border-radius: 9999px;">
                        Who We Are
                    </span>
                    <h2 class="title mt--10 mb--20" style="font-size: clamp(26px, 3.2vw, 36px); font-weight: 800;">
                        Transforming Exam Prep & Skill Development
                    </h2>
                    <div style="color: #475569; font-size: 15px; line-height: 1.8; text-align: justify;">
                        {!! optional($about_info)->aboutDes !!}
                    </div>
                    <div class="mt-4 pt-2">
                        <a href="{{ route('course') }}" class="rbt-btn btn-gradient radius-round">
                            <span>Explore Our Courses</span>
                            <i class="feather-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="position-relative">
                    <img src="{{ asset(optional($about_info)->image ?? 'images/about_pathjolpona.jpg') }}" class="w-100 rounded-4 shadow-lg" alt="About Pathjolpona Education" style="max-height: 520px; object-fit: cover; border: 4px solid #ffffff; box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.15);" onerror="this.onerror=null; this.src='{{ asset('images/about_pathjolpona.jpg') }}';">
                    <div class="position-absolute bottom-0 start-0 m-4 p-3 rounded-3 d-none d-sm-flex align-items-center gap-3" style="background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(10px); color: #ffffff; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #03c6bb; color: #ffffff; font-size: 20px;">
                            <i class="feather-award"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 15px;">BCS & Govt Cadre Mentorship</div>
                            <div style="font-size: 12px; color: #94a3b8;">41st–45th BCS Rank Holders</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Team / Mentors Section -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 12px; border-radius: 9999px;">
                    Mentorship
                </span>
                <h2 class="title mt--10">Meet Our Dedicated<span style="color: #03c6bb"> Team</span></h2>
                <p class="text-muted mt-2">Passionate educators and subject experts committed to your success.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($teachers as $teacher)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="p-4 rounded-4 text-center h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                        <div class="mb-3" style="width: 130px; height: 130px; margin: 0 auto; border-radius: 50%; overflow: hidden; border: 3px solid #03c6bb; box-shadow: 0 4px 12px rgba(3, 198, 187, 0.2);">
                            <img src="{{ asset($teacher->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $teacher->name }}">
                        </div>
                        <h5 class="mb-1" style="font-weight: 700; font-size: 18px;">
                            <a href="javascript:void(0)" style="color: #0f172a; text-decoration: none;">{{ $teacher->name }}</a>
                        </h5>
                        <span style="color: #03c6bb; font-weight: 600; font-size: 14px;">{{ $teacher->subject }}</span>
                        <div class="text-muted mt-2" style="font-size: 13px;">{{ $teacher->job_title }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
