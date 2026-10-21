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
                        <li style="color: #03c6bb; font-weight: 600;">Institutional Registration</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-award"></i> Verified Organization
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 40px);">
                    TIN & Institutional Certificate
                </h1>
                <p class="student-hero-desc mb-0">
                    Official tax and government recognition documentation for Pathjolpona.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.about_us') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">About Us</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 text-center">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 64px; height: 64px; background: rgba(3, 198, 187, 0.1); color: #03c6bb; font-size: 28px;">
                        <i class="feather-check-circle"></i>
                    </div>
                    <h3 style="font-weight: 800; color: #0f172a; font-size: 24px;" class="mb-2">Official Certification Document</h3>
                    <p class="text-muted mb-4" style="font-size: 14px;">Government verified registration certificate of Pathjolpona.</p>

                    <div class="rounded-3 overflow-hidden shadow-sm border p-2" style="background: #f8fafc;">
                        <img src="{{ asset('images/certificate.jpg') }}" alt="TIN Certificate" class="img-fluid rounded-2" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/about/about-01.png') }}';">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
