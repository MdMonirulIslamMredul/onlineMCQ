@extends('user.user_master')
@section('user_content')

@php
$product_info = DB::table('courses')->where('id', $courseid)->first();
$userID = Cookie::get('user_id');
$user_info = $userID ? DB::table('users')->where('id', $userID)->first() : null;
@endphp

<style>
/* Scoped Checkout Styles */
.checkout-page-section {
    padding: 50px 0 80px;
    background-color: var(--slate-50, #f8fafc);
    min-height: 80vh;
}

.checkout-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    margin-bottom: 24px;
    transition: all 0.25s ease;
}

.checkout-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 20px;
    margin-bottom: 24px;
    border-bottom: 1px solid #f1f5f9;
}

.checkout-icon-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(3, 198, 187, 0.12);
    color: #03c6bb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.checkout-card-title {
    font-family: var(--font-heading, 'Outfit', sans-serif);
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.3;
}

.checkout-card-sub {
    font-size: 13px;
    color: #64748b;
    margin: 4px 0 0;
}

.checkout-form-group {
    margin-bottom: 20px;
}

.checkout-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

.checkout-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.checkout-input-icon {
    position: absolute;
    left: 16px;
    color: #94a3b8;
    font-size: 16px;
    pointer-events: none;
    transition: color 0.2s ease;
}

.checkout-input {
    width: 100%;
    height: 50px;
    padding: 10px 16px 10px 46px;
    font-size: 15px;
    font-weight: 500;
    color: #1e293b;
    background-color: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    outline: none;
    transition: all 0.2s ease;
}

.checkout-input:focus {
    border-color: #03c6bb;
    box-shadow: 0 0 0 4px rgba(3, 198, 187, 0.16);
    background-color: #ffffff;
}

.checkout-input:focus + .checkout-input-icon,
.checkout-input-wrap:focus-within .checkout-input-icon {
    color: #03c6bb;
}

.checkout-agreement-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-top: 24px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.checkout-agreement-box input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #03c6bb;
    cursor: pointer;
    margin-top: 3px;
    flex-shrink: 0;
}

.checkout-agreement-text {
    font-size: 14px;
    color: #475569;
    line-height: 1.5;
    margin: 0;
}

.checkout-agreement-text a {
    color: #03c6bb;
    font-weight: 600;
    text-decoration: underline;
    transition: color 0.2s ease;
}

.checkout-agreement-text a:hover {
    color: #009e95;
}

.checkout-guarantee-strip {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 18px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px dashed #e2e8f0;
    font-size: 13px;
    color: #64748b;
}

.checkout-guarantee-strip span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Order Summary Box */
.order-summary-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
    position: sticky;
    top: 90px;
}

.order-course-thumb {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 16px;
    border: 1px solid #f1f5f9;
}

.order-course-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    background: rgba(3, 198, 187, 0.12);
    color: #009e95;
    margin-bottom: 8px;
}

.order-course-title {
    font-family: var(--font-heading, 'Outfit', sans-serif);
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.4;
    margin-bottom: 16px;
}

.order-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 14px;
    color: #64748b;
}

.order-price-row.total-row {
    padding-top: 16px;
    margin-top: 12px;
    border-top: 2px dashed #e2e8f0;
    color: #0f172a;
    font-weight: 700;
    font-size: 16px;
}

.order-total-amount {
    font-family: var(--font-heading, 'Outfit', sans-serif);
    font-size: 28px;
    font-weight: 800;
    color: #009e95;
}

.order-confirm-btn {
    width: 100%;
    height: 54px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #03c6bb 0%, #009e95 100%);
    color: #ffffff;
    font-family: var(--font-heading, 'Outfit', sans-serif);
    font-size: 16px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 24px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(3, 198, 187, 0.35);
    transition: all 0.25s ease;
}

.order-confirm-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 198, 187, 0.45);
    color: #ffffff;
}

.order-confirm-btn:active {
    transform: translateY(0);
}

.payment-badges-row {
    margin-top: 20px;
    text-align: center;
}

.payment-badges-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
}

.payment-badges-list {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.payment-pill {
    padding: 4px 10px;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    color: #475569;
}

/* Dark Mode Overrides */
html.dark-theme .checkout-page-section,
[data-theme="dark"] .checkout-page-section {
    background-color: #0b1329 !important;
}

html.dark-theme .checkout-card,
[data-theme="dark"] .checkout-card,
html.dark-theme .order-summary-card,
[data-theme="dark"] .order-summary-card {
    background: #1e293b !important;
    border-color: #334155 !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4) !important;
}

html.dark-theme .checkout-card-header,
[data-theme="dark"] .checkout-card-header {
    border-bottom-color: #334155 !important;
}

html.dark-theme .checkout-card-title,
[data-theme="dark"] .checkout-card-title,
html.dark-theme .order-course-title,
[data-theme="dark"] .order-course-title,
html.dark-theme .order-price-row.total-row,
[data-theme="dark"] .order-price-row.total-row {
    color: #ffffff !important;
}

html.dark-theme .checkout-card-sub,
[data-theme="dark"] .checkout-card-sub,
html.dark-theme .checkout-label,
[data-theme="dark"] .checkout-label,
html.dark-theme .order-price-row,
[data-theme="dark"] .order-price-row,
html.dark-theme .checkout-guarantee-strip,
[data-theme="dark"] .checkout-guarantee-strip {
    color: #94a3b8 !important;
}

html.dark-theme .checkout-input,
[data-theme="dark"] .checkout-input {
    background-color: #0f172a !important;
    border-color: #334155 !important;
    color: #ffffff !important;
}

html.dark-theme .checkout-input:focus,
[data-theme="dark"] .checkout-input:focus {
    border-color: #03c6bb !important;
    background-color: #0f172a !important;
}

html.dark-theme .checkout-agreement-box,
[data-theme="dark"] .checkout-agreement-box {
    background: #0f172a !important;
    border-color: #334155 !important;
}

html.dark-theme .checkout-agreement-text,
[data-theme="dark"] .checkout-agreement-text {
    color: #cbd5e1 !important;
}

html.dark-theme .order-price-row.total-row,
[data-theme="dark"] .order-price-row.total-row,
html.dark-theme .checkout-guarantee-strip,
[data-theme="dark"] .checkout-guarantee-strip {
    border-color: #334155 !important;
}

html.dark-theme .payment-pill,
[data-theme="dark"] .payment-pill {
    background: #0f172a !important;
    color: #94a3b8 !important;
}

html.dark-theme .order-total-amount,
[data-theme="dark"] .order-total-amount {
    color: #03c6bb !important;
}
</style>

<!-- Modern Hero Banner -->
<div class="student-hero" style="padding: 55px 0 65px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li><a href="{{ route('course') }}" style="color: #94a3b8; text-decoration: none;">Courses</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Checkout</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-shield"></i> 256-Bit SSL Secure Enrollment
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(24px, 3.2vw, 38px); line-height: 1.35; padding-bottom: 6px;">
                    Complete Your Course Enrollment
                </h1>
                <p class="student-hero-desc mb-0" style="font-size: 15px; color: #94a3b8;">
                    Secure instant access to full lessons, exams, and verified certificates.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Main Checkout Section -->
<section class="checkout-page-section">
    <div class="container">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
            <i class="feather-alert-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($product_info)
        <form method="post" action="{{ route('course.order') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="course_id" value="{{ $product_info->id }}">
            <input type="hidden" name="price" value="{{ $product_info->price }}">

            <div class="row g-4">
                <!-- Left: Billing Information -->
                <div class="col-lg-7 col-xl-8">
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-icon-badge">
                                <i class="feather-user-check"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">Student & Billing Information</h3>
                                <p class="checkout-card-sub">Please review or provide your contact details for enrollment verification.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-12 checkout-form-group">
                                <label class="checkout-label">Full Name <span class="text-danger">*</span></label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-user checkout-input-icon"></i>
                                    <input type="text" name="name" value="{{ old('name', optional($user_info)->name) }}" class="checkout-input" placeholder="Enter your full name" required>
                                </div>
                                @error('name')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 checkout-form-group">
                                <label class="checkout-label">Email Address <span class="text-danger">*</span></label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-mail checkout-input-icon"></i>
                                    <input type="email" name="email" value="{{ old('email', optional($user_info)->email) }}" class="checkout-input" placeholder="e.g. yourname@example.com" required>
                                </div>
                                @error('email')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 checkout-form-group">
                                <label class="checkout-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-phone checkout-input-icon"></i>
                                    <input type="text" name="phone" value="{{ old('phone', optional($user_info)->phone) }}" class="checkout-input" placeholder="e.g. 017XXXXXXXX" required>
                                </div>
                                @error('phone')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="checkout-agreement-box">
                            <input type="checkbox" id="agreeTerms" name="agree" value="1" required checked>
                            <label for="agreeTerms" class="checkout-agreement-text mb-0">
                                I confirm my enrollment details and agree to Pathjolpona's
                                <a href="{{ route('user.trams_and_conditions') }}" target="_blank">Terms of Service</a>,
                                <a href="{{ route('user.return_and_refund_policy') }}" target="_blank">Refund Policy</a>, and
                                <a href="{{ route('user.privacy_and_policy') }}" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>
                        @error('agree')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror

                        <!-- Guarantee Strip -->
                        <div class="checkout-guarantee-strip">
                            <span><i class="feather-lock text-success"></i> 256-Bit SSL Encrypted Checkout</span>
                            <span><i class="feather-zap text-warning"></i> Instant Course Activation</span>
                            <span><i class="feather-award text-primary"></i> Verified Certificate of Completion</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="col-lg-5 col-xl-4">
                    <div class="order-summary-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="checkout-card-title" style="font-size: 18px;">Order Summary</h4>
                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">1 Course</span>
                        </div>

                        @if(!empty($product_info->image))
                        <img src="{{ asset($product_info->image) }}" alt="{{ $product_info->name }}" class="order-course-thumb">
                        @endif

                        <div class="order-course-badge">
                            <i class="feather-book-open me-1"></i> Online Course
                        </div>

                        <h5 class="order-course-title">
                            {{ $product_info->name }}
                        </h5>

                        <!-- Price Breakdown -->
                        <div class="order-price-row">
                            <span>Course Tuition Fee</span>
                            <span class="fw-semibold text-dark">৳ {{ number_format($product_info->price, 0) }}</span>
                        </div>
                        <div class="order-price-row">
                            <span>Platform & Access Fee</span>
                            <span class="text-success fw-semibold">FREE</span>
                        </div>
                        <div class="order-price-row">
                            <span>Lifetime Exam Access</span>
                            <span class="text-success fw-semibold">Included</span>
                        </div>

                        <div class="order-price-row total-row">
                            <span>Total Payable</span>
                            <div class="order-total-amount">
                                ৳ {{ number_format($product_info->price, 0) }}
                            </div>
                        </div>

                        <button type="submit" class="order-confirm-btn" id="confirmOrderBtn">
                            <span>Confirm & Pay Now</span>
                            <i class="feather-arrow-right"></i>
                        </button>

                        <div class="payment-badges-row">
                            <div class="payment-badges-label">Supported Payment Channels</div>
                            <div class="payment-badges-list">
                                <span class="payment-pill">bKash</span>
                                <span class="payment-pill">Nagad</span>
                                <span class="payment-pill">Rocket</span>
                                <span class="payment-pill">Cards / Net Banking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="text-center py-5">
            <i class="feather-alert-triangle text-warning" style="font-size: 48px;"></i>
            <h4 class="mt-3">Course Not Found</h4>
            <p class="text-muted">The requested course could not be located. Please browse our courses catalog.</p>
            <a href="{{ route('course') }}" class="btn btn-primary radius-round px-4 py-2 mt-2">Browse All Courses</a>
        </div>
        @endif
    </div>
</section>

<!-- Include Newsletter -->
@include('user.pages.newsletter')

@endsection
