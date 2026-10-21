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
                        <li style="color: #03c6bb; font-weight: 600;">Terms & Conditions</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-file-text"></i> Student Agreement
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 40px);">
                    Terms & Conditions
                </h1>
                <p class="student-hero-desc mb-0">
                    User agreement and student conduct rules for utilizing Pathjolpona learning services.
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
                            <i class="feather-check-square"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 22px;">Terms of Use & Learning Agreement</h3>
                            <span class="text-muted" style="font-size: 13px;">Applicable to all registered members</span>
                        </div>
                    </div>

                    <div class="legal-content-body">
                        {!! optional($company_info)->trams_and_condition ?: '<p>By accessing Pathjolpona platform, students agree to adhere to standard academic integrity rules. All study materials, model exam questions, video lectures, and lecture notes are copyrighted property of Pathjolpona. Account credentials must remain confidential and cannot be shared across multiple learners.</p>' !!}
                    </div>

                    <div class="mt-5 p-4 rounded-3" style="background: #f8fafc; border-left: 4px solid #03c6bb;">
                        <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;" class="mb-1">Academic Integrity Guarantee</h5>
                        <p class="text-muted mb-0" style="font-size: 14px;">We are proud to uphold the highest standard of educational quality. For further assistance, contact our administrative office.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
