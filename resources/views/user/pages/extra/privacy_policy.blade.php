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
                        <li style="color: #03c6bb; font-weight: 600;">Privacy Policy</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-shield"></i> Student Security & Trust
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 40px);">
                    Privacy Policy
                </h1>
                <p class="student-hero-desc mb-0">
                    How we safeguard student data, learning records, and transaction privacy.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.contact_us') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">Support Helpdesk</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; line-height: 1.8; color: #334155;">
                    <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(3, 198, 187, 0.1); color: #03c6bb; font-size: 22px;">
                            <i class="feather-lock"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 22px;">Data Protection & Privacy Commitment</h3>
                            <span class="text-muted" style="font-size: 13px;">Last updated: Current Term</span>
                        </div>
                    </div>

                    <div class="legal-content-body">
                        {!! optional($company_info)->privacy_policy ?: '<p>Pathjolpona is dedicated to preserving the trust and security of all enrolled students and users. We collect only necessary student details required to facilitate academic assessments, course access, and certified testing credentials. Student contact credentials and evaluation data are strictly encrypted and never distributed to third-party marketing entities.</p>' !!}
                    </div>

                    <div class="mt-5 p-4 rounded-3" style="background: #f8fafc; border-left: 4px solid #03c6bb;">
                        <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;" class="mb-1">Questions regarding your privacy?</h5>
                        <p class="text-muted mb-0" style="font-size: 14px;">If you have inquiries regarding how your exam data or student profiles are stored, please reach out directly through our <a href="{{ route('user.contact_us') }}" style="color: #03c6bb; font-weight: 600;">contact portal</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
