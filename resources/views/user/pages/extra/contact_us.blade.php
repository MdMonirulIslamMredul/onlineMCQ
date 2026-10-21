@extends('user.pages.test_master')

@push('test_style')
<style>
    .contact-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }
    .contact-card-modern:hover {
        transform: translateY(-6px);
        border-color: #03c6bb;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .contact-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(3, 198, 187, 0.12) 0%, rgba(79, 70, 229, 0.12) 100%);
        color: #009e95;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
</style>
@endpush

@section('content')
<!-- Start Hero Banner -->
<div class="student-hero" style="padding: 55px 0 65px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Contact Us</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-headphones"></i> 24/7 Student Support
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 4vw, 42px);">
                    We're Here to Guide Your Learning Journey
                </h1>
                <p class="student-hero-desc mb-0">
                    Have questions about courses, mock test schedules, or subscription access? Reach out to our dedicated student counselor team.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="tel:{{ optional($company_info)->phone_1 }}" class="rbt-btn btn-gradient radius-round">
                    <span class="btn-text">Call Now</span>
                    <span class="btn-icon"><i class="feather-phone-call"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<!-- Contact Channels Cards -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-card-modern">
                    <div class="contact-icon-box">
                        <i class="feather-phone"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #0f172a; font-size: 18px; margin-bottom: 10px;">Contact Phone</h4>
                    <p class="text-muted mb-2" style="font-size: 14px;">Direct hotline for admission inquiries</p>
                    <div class="d-flex flex-column gap-1">
                        <a href="tel:{{ optional($company_info)->phone_1 }}" style="font-weight: 700; color: #03c6bb; text-decoration: none; font-size: 16px;">
                            {{ optional($company_info)->phone_1 ?: '+880 1700-000000' }}
                        </a>
                        @if(optional($company_info)->phone_2)
                            <a href="tel:{{ $company_info->phone_2 }}" style="font-weight: 600; color: #64748b; text-decoration: none; font-size: 14px;">
                                {{ $company_info->phone_2 }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-card-modern">
                    <div class="contact-icon-box">
                        <i class="feather-mail"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #0f172a; font-size: 18px; margin-bottom: 10px;">Email Support</h4>
                    <p class="text-muted mb-2" style="font-size: 14px;">Send us your academic questions</p>
                    <a href="mailto:{{ optional($company_info)->email }}" style="font-weight: 700; color: #03c6bb; text-decoration: none; font-size: 16px;">
                        {{ optional($company_info)->email ?: 'support@pathjolpona.com' }}
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-12">
                <div class="contact-card-modern">
                    <div class="contact-icon-box">
                        <i class="feather-map-pin"></i>
                    </div>
                    <h4 style="font-weight: 700; color: #0f172a; font-size: 18px; margin-bottom: 10px;">Head Office</h4>
                    <p class="text-muted mb-2" style="font-size: 14px;">Visit our guidance & learning center</p>
                    <span style="font-weight: 600; color: #334155; font-size: 14px; line-height: 1.5;">
                        {{ optional($company_info)->address ?: 'Dhaka, Bangladesh' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Consultation Form Section -->
        <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 col-12">
                    <div class="pe-lg-4">
                        <span class="badge px-3 py-2 rounded-pill text-uppercase mb-3" style="background: rgba(3, 198, 187, 0.1); color: #009e95; font-weight: 700; font-size: 12px;">
                            Quick Response Form
                        </span>
                        <h2 style="font-weight: 800; color: #0f172a; font-size: clamp(24px, 3vw, 32px);" class="mb-3">
                            Request Free Consultation or Demo Course Access
                        </h2>
                        <p class="text-muted mb-4" style="line-height: 1.7; font-size: 15px;">
                            Fill out the brief inquiry form and our course coordinator will contact you directly within 2 hours to explain the exam curriculum, fee structure, and scholarship possibilities.
                        </p>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="feather-check"></i>
                                </div>
                                <span style="color: #334155; font-weight: 600;">Personalized career counselling & exam roadmap</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="feather-check"></i>
                                </div>
                                <span style="color: #334155; font-weight: 600;">Instant access to free sample practice exams</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="feather-check"></i>
                                </div>
                                <span style="color: #334155; font-weight: 600;">Guidance by BCS & Govt Cadre Mentors</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="p-4 p-md-5 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h4 style="font-weight: 700; color: #0f172a; font-size: 20px;" class="mb-4">
                            Send Us a Message
                        </h4>
                        @if(session('success'))
                            <div class="alert alert-success rounded-3 mb-4">
                                <i class="feather-check-circle me-2"></i> {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('contact.form') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="c_name" class="form-label" style="font-weight: 600; color: #334155; font-size: 14px;">Your Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="feather-user"></i></span>
                                    <input type="text" id="c_name" name="name" class="form-control border-start-0 py-2" placeholder="e.g. Tanvir Ahmed" required style="font-size: 14px; border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="c_phone" class="form-label" style="font-weight: 600; color: #334155; font-size: 14px;">Contact Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="feather-phone"></i></span>
                                    <input type="tel" id="c_phone" name="phone" class="form-control border-start-0 py-2" placeholder="e.g. 01712345678" required style="font-size: 14px; border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <button type="submit" class="rbt-btn btn-gradient radius-round w-100 text-center py-3">
                                <span class="btn-text">Submit Inquiry</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
