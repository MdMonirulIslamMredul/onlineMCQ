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
                        <li style="color: #03c6bb; font-weight: 600;">Refund & Return Policy</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-refresh-cw"></i> Transparent Guarantee
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 40px);">
                    Refund & Return Policy
                </h1>
                <p class="student-hero-desc mb-0">
                    Clear guidelines for course cancellations, duplicate payments, and refund processing.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.contact_us') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">Contact Support</span>
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
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; font-size: 22px;">
                            <i class="feather-dollar-sign"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 22px;">Student Satisfaction & Refund Terms</h3>
                            <span class="text-muted" style="font-size: 13px;">Official Institutional Policy</span>
                        </div>
                    </div>

                    <p class="mb-4">
                        Thank you for choosing Pathjolpona for your educational and competitive exam preparation. We are committed to ensuring an outstanding learning experience. The following terms outline our cancellation and refund procedure:
                    </p>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-12">
                            <div class="p-4 rounded-3 h-100" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 style="font-weight: 700; color: #0f172a; font-size: 17px;" class="mb-2">
                                    <i class="feather-clock text-primary me-2"></i> Within 24 Hours
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 14px;">
                                    If a refund is requested within 24 hours of enrollment and fewer than 2 lessons have been accessed, <strong>90% of the course fee</strong> will be refunded.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-4 rounded-3 h-100" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 style="font-weight: 700; color: #0f172a; font-size: 17px;" class="mb-2">
                                    <i class="feather-alert-circle text-warning me-2"></i> Between 24 to 72 Hours
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 14px;">
                                    For requests between 24 and 72 hours, <strong>50% of the course fee</strong> will be refunded. After 72 hours or if more than 3 modules are accessed, no refunds can be processed.
                                </p>
                            </div>
                        </div>
                    </div>

                    <h4 style="font-weight: 700; color: #0f172a; font-size: 18px;" class="mb-2">Duplicate Payment Settlement</h4>
                    <p class="mb-4">
                        Any accidental duplicate payments made during online checkout will be credited back in full through the original payment gateway (bKash/Nagad/Cards) within <strong>7 to 10 working days</strong> after notification.
                    </p>

                    <div class="p-4 rounded-3" style="background: #f0fdf4; border-left: 4px solid #10b981;">
                        <h5 style="font-weight: 700; color: #065f46; font-size: 16px;" class="mb-1">How to request a refund?</h5>
                        <p class="text-muted mb-0" style="font-size: 14px;">Please forward your Order ID and registered phone number to our student support team via <a href="{{ route('user.contact_us') }}" style="color: #059669; font-weight: 600;">Contact Us</a> or call our direct hotline.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
