@extends('user.pages.test_master')

@section('content')
<!-- Start Hero Banner -->
<div class="student-hero" style="padding: 50px 0 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Mission & Vision</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-compass"></i> Institutional Purpose
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 40px);">
                    Our Mission & Vision
                </h1>
                <p class="student-hero-desc mb-0">
                    Empowering students nationwide with accessible, high-yield examination preparation and expert mentorship.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.about_us') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">About Our Story</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-6 col-12">
                <div class="p-4 p-md-5 rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 56px; height: 56px; background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-size: 26px;">
                        <i class="feather-target"></i>
                    </div>
                    <h3 style="font-weight: 800; color: #0f172a; font-size: 24px;" class="mb-3">Our Core Mission</h3>
                    <p style="color: #475569; line-height: 1.8; font-size: 15px;">
                        To democratize access to elite competitive test preparation, providing every student across Bangladesh with realistic mock tests, real-time analytics, and verified solutions regardless of geographic constraints.
                    </p>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="p-4 p-md-5 rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 56px; height: 56px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 26px;">
                        <i class="feather-eye"></i>
                    </div>
                    <h3 style="font-weight: 800; color: #0f172a; font-size: 24px;" class="mb-3">Our Vision</h3>
                    <p style="color: #475569; line-height: 1.8; font-size: 15px;">
                        To become Bangladesh's most reliable and technologically advanced EdTech learning ecosystem, transforming ambitious learners into successful civil servants, bankers, teachers, and professionals.
                    </p>
                </div>
            </div>
        </div>

        @if(optional($company_info)->mission_and_vission)
            <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #f8fafc; border: 1px solid #e2e8f0; line-height: 1.8; color: #334155;">
                <h4 style="font-weight: 800; color: #0f172a; font-size: 20px;" class="mb-3">Executive Statement</h4>
                <div>
                    {!! $company_info->mission_and_vission !!}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
