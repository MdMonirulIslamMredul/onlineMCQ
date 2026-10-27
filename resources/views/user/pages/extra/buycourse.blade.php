@extends('user.user_master')
@section('user_content')

@php
$product_info = DB::table('courses')->where('id', $courseid)->first();
$userID = Cookie::get('user_id');
$user_info = $userID ? DB::table('users')->where('id', $userID)->first() : null;
$gateways = isset($gateways) && count($gateways) ? $gateways : \App\Models\PaymentGateway::where('status', 1)->orderBy('id', 'asc')->get();
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
    padding: 30px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    margin-bottom: 24px;
    transition: all 0.25s ease;
}

.checkout-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 18px;
    margin-bottom: 22px;
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
    font-size: 19px;
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
    margin-bottom: 18px;
}

.checkout-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 7px;
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
    font-size: 14.5px;
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

/* Gateway Selection Grid */
.gateway-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.gateway-option-card {
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 14px;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.gateway-option-card:hover {
    border-color: #03c6bb;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(3, 198, 187, 0.12);
}

.gateway-option-card.selected {
    border-color: #03c6bb;
    background: #f0fdfa;
    box-shadow: 0 0 0 3px rgba(3, 198, 187, 0.2);
}

.gateway-option-card .check-circle {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 11px;
    transition: all 0.2s ease;
}

.gateway-option-card.selected .check-circle {
    background: #03c6bb;
}

.gateway-logo-container {
    height: 42px;
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.gateway-logo-img {
    max-height: 40px;
    max-width: 110px;
    object-fit: contain;
}

.gateway-card-name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}

.gateway-card-meta {
    font-size: 12px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}

.gateway-badge {
    padding: 2px 7px;
    border-radius: 6px;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.badge-mfs {
    background: rgba(236, 72, 153, 0.12);
    color: #db2777;
}

.badge-bank {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

/* Gateway Instructions Card */
.gateway-detail-panel {
    background: #f8fafc;
    border: 1.5px dashed #03c6bb;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 24px;
}

.gateway-acc-number {
    font-family: var(--font-heading, 'Outfit', monospace);
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: 0.03em;
}

.copy-pill-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.copy-pill-btn:hover {
    background: #03c6bb;
    color: #ffffff;
    border-color: #03c6bb;
}

/* Screenshot Upload Box */
.screenshot-upload-box {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    padding: 24px 20px;
    text-align: center;
    background: #ffffff;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
}

.screenshot-upload-box:hover {
    border-color: #03c6bb;
    background: #f0fdfa;
}

.screenshot-preview-wrap {
    max-width: 220px;
    margin: 12px auto 0;
    display: none;
    position: relative;
}

.screenshot-preview-wrap img {
    width: 100%;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.remove-screenshot-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 24px;
    height: 24px;
    background: #ef4444;
    color: #ffffff;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
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
    font-size: 13.5px;
    color: #475569;
    line-height: 1.5;
    margin: 0;
}

.checkout-agreement-text a {
    color: #03c6bb;
    font-weight: 600;
    text-decoration: underline;
}

.checkout-guarantee-strip {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 18px;
    margin-top: 20px;
    padding-top: 18px;
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

.order-confirm-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Dark Theme Adjustments */
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
html.dark-theme .gateway-card-name,
[data-theme="dark"] .gateway-card-name,
html.dark-theme .gateway-acc-number,
[data-theme="dark"] .gateway-acc-number,
html.dark-theme .order-price-row.total-row,
[data-theme="dark"] .order-price-row.total-row {
    color: #ffffff !important;
}

html.dark-theme .checkout-card-sub,
[data-theme="dark"] .checkout-card-sub,
html.dark-theme .checkout-label,
[data-theme="dark"] .checkout-label,
html.dark-theme .gateway-card-meta,
[data-theme="dark"] .gateway-card-meta,
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

html.dark-theme .gateway-option-card,
[data-theme="dark"] .gateway-option-card {
    background: #0f172a !important;
    border-color: #334155 !important;
}

html.dark-theme .gateway-option-card.selected,
[data-theme="dark"] .gateway-option-card.selected {
    border-color: #03c6bb !important;
    background: #0c2331 !important;
}

html.dark-theme .gateway-detail-panel,
[data-theme="dark"] .gateway-detail-panel {
    background: #0f172a !important;
    border-color: #03c6bb !important;
}

html.dark-theme .copy-pill-btn,
[data-theme="dark"] .copy-pill-btn {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #cbd5e1 !important;
}

html.dark-theme .screenshot-upload-box,
[data-theme="dark"] .screenshot-upload-box {
    background: #0f172a !important;
    border-color: #334155 !important;
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
                        <li style="color: #03c6bb; font-weight: 600;">Checkout & Payment</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-shield"></i> 256-Bit SSL Secure Enrollment
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(24px, 3.2vw, 38px); line-height: 1.35; padding-bottom: 6px;">
                    Complete Your Course Enrollment
                </h1>
                <p class="student-hero-desc mb-0" style="font-size: 15px; color: #94a3b8;">
                    Select your preferred payment gateway, submit your transaction ID and screenshot proof.
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

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
            <div class="fw-bold mb-1"><i class="feather-alert-triangle me-2"></i> Please correct the following errors:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($product_info)
        <form method="post" action="{{ route('course.order') }}" id="checkoutForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="course_id" value="{{ $product_info->id }}">
            <input type="hidden" name="price" value="{{ $product_info->price }}">

            <div class="row g-4">
                <!-- Left: Student Info & Payment Gateway Details -->
                <div class="col-lg-7 col-xl-8">

                    <!-- Step 1: Student Information -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-icon-badge">
                                <i class="feather-user-check"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">1. Student Contact Information</h3>
                                <p class="checkout-card-sub">Review your details to attach course enrollment access.</p>
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
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6 checkout-form-group">
                                <label class="checkout-label">Email Address <span class="text-danger">*</span></label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-mail checkout-input-icon"></i>
                                    <input type="email" name="email" value="{{ old('email', optional($user_info)->email) }}" class="checkout-input" placeholder="e.g. yourname@example.com" required>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 checkout-form-group">
                                <label class="checkout-label">Contact Phone Number <span class="text-danger">*</span></label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-phone checkout-input-icon"></i>
                                    <input type="text" name="phone" value="{{ old('phone', optional($user_info)->phone) }}" class="checkout-input" placeholder="e.g. 017XXXXXXXX" required>
                                </div>
                            </div>

                            <!-- Optional Address -->
                            <div class="col-12 checkout-form-group mb-0">
                                <label class="checkout-label">Address / District (Optional)</label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-map-pin checkout-input-icon"></i>
                                    <input type="text" name="address" value="{{ old('address', optional($user_info)->address) }}" class="checkout-input" placeholder="e.g. Dhaka, Bangladesh">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Payment Gateway Selection -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-icon-badge">
                                <i class="feather-credit-card"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">2. Select Payment Gateway</h3>
                                <p class="checkout-card-sub">Choose any of the verified payment accounts below to transfer <b>৳ {{ number_format($product_info->price, 0) }}</b>.</p>
                            </div>
                        </div>

                        @if($gateways->count() > 0)
                        <!-- Gateway Cards Grid -->
                        <div class="gateway-grid">
                            @foreach($gateways as $index => $gw)
                            <div class="gateway-option-card {{ ($loop->first && !old('payment_gateway_id')) || old('payment_gateway_id') == $gw->id ? 'selected' : '' }}"
                                 onclick="selectGateway({{ $gw->id }}, '{{ $gw->type }}', '{{ addslashes($gw->name) }}', '{{ addslashes($gw->account_number) }}', '{{ addslashes($gw->account_type ?? '') }}', '{{ addslashes($gw->bank_name ?? '') }}', '{{ addslashes($gw->branch_name ?? '') }}', '{{ addslashes($gw->routing_number ?? '') }}', '{{ addslashes(preg_replace('/\r|\n/', ' ', $gw->instruction ?? '')) }}')"
                                 id="gw_card_{{ $gw->id }}">
                                <div class="check-circle">
                                    <i class="feather-check"></i>
                                </div>

                                <div class="gateway-logo-container">
                                    @if($gw->logo && file_exists(public_path($gw->logo)))
                                        <img src="{{ asset($gw->logo) }}" alt="{{ $gw->name }}" class="gateway-logo-img">
                                    @else
                                        <div style="font-weight: 800; color: #03c6bb; font-size: 16px;">
                                            <i class="{{ $gw->type === 'bank' ? 'feather-home' : 'feather-smartphone' }} me-1"></i>
                                            {{ $gw->name }}
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="gateway-card-name">{{ $gw->name }}</div>
                                    <div class="gateway-card-meta">
                                        <span class="gateway-badge {{ $gw->type === 'mfs' ? 'badge-mfs' : 'badge-bank' }}">
                                            {{ $gw->type === 'mfs' ? 'Mobile Banking' : 'Bank Transfer' }}
                                        </span>
                                        @if($gw->account_type)
                                        <span>• {{ $gw->account_type }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Hidden Gateway ID Input -->
                        @php
                            $defaultGw = $gateways->first();
                            $selectedGwId = old('payment_gateway_id', optional($defaultGw)->id);
                        @endphp
                        <input type="hidden" name="payment_gateway_id" id="selectedGatewayId" value="{{ $selectedGwId }}">

                        <!-- Dynamic Gateway Instruction & Detail Panel -->
                        <div class="gateway-detail-panel" id="gatewayDetailPanel">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                                <div>
                                    <div class="text-muted small text-uppercase fw-bold mb-1" id="panelAccTypeLabel">Account Details</div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="gateway-acc-number" id="panelAccNumber">--</span>
                                        <button type="button" class="copy-pill-btn" onclick="copyAccountNumber()">
                                            <i class="feather-copy"></i> <span id="copyBtnText">Copy</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted small">Payable Amount</div>
                                    <div class="fw-bold fs-5 text-success">৳ {{ number_format($product_info->price, 0) }} BDT</div>
                                </div>
                            </div>

                            <!-- Bank Details (Shown if Bank) -->
                            <div id="bankExtraDetails" style="display: none; font-size: 13.5px; color: #475569; border-top: 1px dashed #cbd5e1; padding-top: 12px; margin-top: 12px;">
                                <div class="row g-2">
                                    <div class="col-sm-4">
                                        <span class="text-muted">Bank Name:</span> <strong id="panelBankName">--</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted">Branch:</span> <strong id="panelBranchName">--</strong>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted">Routing No:</span> <strong id="panelRoutingNumber">--</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Instruction Notice -->
                            <div class="d-flex align-items-start gap-2 mt-3 pt-2" style="font-size: 13px; color: #64748b; border-top: 1px solid rgba(0,0,0,0.05);">
                                <i class="feather-info text-info flex-shrink-0 mt-1"></i>
                                <span id="panelInstruction">Please send the exact amount to the account number above, then submit your transaction ID and screenshot below.</span>
                            </div>
                        </div>

                        <!-- Step 3: Payment Verification Fields -->
                        <div class="checkout-card-header mt-4">
                            <div class="checkout-icon-badge">
                                <i class="feather-file-text"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">3. Fill Payment Verification Information</h3>
                                <p class="checkout-card-sub">Provide proof of payment for manual admin verification and course access.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- MFS Specific Fields -->
                            <div id="mfsFieldsGroup" class="col-12">
                                <div class="checkout-form-group">
                                    <label class="checkout-label">Your Sender Mobile Number <span class="text-danger">*</span></label>
                                    <div class="checkout-input-wrap">
                                        <i class="feather-phone-call checkout-input-icon"></i>
                                        <input type="text" name="sender_number" id="senderNumberInput" value="{{ old('sender_number') }}" class="checkout-input" placeholder="e.g. 017XXXXXXXX (The number you sent money from)">
                                    </div>
                                    <small class="text-muted">Enter the bKash / Nagad / Rocket number you used to send money.</small>
                                </div>
                            </div>

                            <!-- Bank Specific Fields -->
                            <div id="bankFieldsGroup" class="col-12" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-md-6 checkout-form-group">
                                        <label class="checkout-label">Your Bank Name <span class="text-danger">*</span></label>
                                        <div class="checkout-input-wrap">
                                            <i class="feather-home checkout-input-icon"></i>
                                            <input type="text" name="bank_name" id="bankNameInput" value="{{ old('bank_name') }}" class="checkout-input" placeholder="e.g. City Bank, BRAC Bank, Islami Bank">
                                        </div>
                                    </div>
                                    <div class="col-md-6 checkout-form-group">
                                        <label class="checkout-label">Your Bank Account Number <span class="text-danger">*</span></label>
                                        <div class="checkout-input-wrap">
                                            <i class="feather-hash checkout-input-icon"></i>
                                            <input type="text" name="bank_account_number" id="bankAccInput" value="{{ old('bank_account_number') }}" class="checkout-input" placeholder="Enter your bank account number">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Common Field: Transaction ID -->
                            <div class="col-12 checkout-form-group">
                                <label class="checkout-label">
                                    <span id="trxLabel">Transaction ID (TrxID)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-tag checkout-input-icon"></i>
                                    <input type="text" name="trx_id" id="trxIdInput" value="{{ old('trx_id') }}" class="checkout-input" placeholder="e.g. 9J4K8LMN2P" required>
                                </div>
                                <small class="text-muted" id="trxHelp">Enter the unique TrxID from your SMS or bank transfer slip.</small>
                            </div>

                            <!-- Common Field: Payment Screenshot Proof -->
                            <div class="col-12 checkout-form-group">
                                <label class="checkout-label">
                                    Upload Payment Screenshot / Deposit Slip Proof <span class="text-danger">*</span>
                                </label>
                                <div class="screenshot-upload-box" onclick="document.getElementById('screenshotFileInput').click()">
                                    <i class="feather-upload-cloud text-primary" style="font-size: 36px;"></i>
                                    <div class="fw-bold mt-2" style="font-size: 15px; color: #1e293b;">Click to browse or drop payment screenshot here</div>
                                    <div class="text-muted small mt-1">Supports JPG, PNG, WEBP (Max 5MB)</div>
                                    <input type="file" name="screenshot" id="screenshotFileInput" accept="image/*" style="display: none;" onchange="handleFileSelect(this)" required>

                                    <!-- Live Preview -->
                                    <div class="screenshot-preview-wrap" id="screenshotPreviewWrap" onclick="event.stopPropagation()">
                                        <img id="screenshotPreviewImg" src="" alt="Proof Preview">
                                        <button type="button" class="remove-screenshot-btn" onclick="removeScreenshot(event)">
                                            <i class="feather-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted mt-1 d-block">Admin will check this screenshot and TrxID to approve enrollment.</small>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="feather-alert-triangle me-2"></i> No active payment gateway found. Please contact administration.
                        </div>
                        @endif

                        <!-- Agreement Checkbox -->
                        <div class="checkout-agreement-box">
                            <input type="checkbox" id="agreeTerms" name="agree" value="1" required checked>
                            <label for="agreeTerms" class="checkout-agreement-text mb-0">
                                I confirm my payment details are accurate and agree to Pathjolpona's
                                <a href="{{ route('user.trams_and_conditions') }}" target="_blank">Terms of Service</a> and
                                <a href="{{ route('user.privacy_and_policy') }}" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>

                        <!-- Guarantee Strip -->
                        <div class="checkout-guarantee-strip">
                            <span><i class="feather-lock text-success"></i> 256-Bit SSL Encrypted Verification</span>
                            <span><i class="feather-shield text-info"></i> Manual Admin Check</span>
                            <span><i class="feather-award text-primary"></i> Guaranteed Course Access</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary Sidebar -->
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
                            <span>Verification & Access</span>
                            <span class="text-success fw-semibold">FREE</span>
                        </div>
                        <div class="order-price-row">
                            <span>Selected Gateway</span>
                            <span class="fw-bold text-primary" id="summaryGatewayName">bKash</span>
                        </div>

                        <div class="order-price-row total-row">
                            <span>Total Payable</span>
                            <div class="order-total-amount">
                                ৳ {{ number_format($product_info->price, 0) }}
                            </div>
                        </div>

                        <button type="submit" class="order-confirm-btn" id="confirmOrderBtn">
                            <span>Submit Payment Proof</span>
                            <i class="feather-arrow-right"></i>
                        </button>

                        <div class="text-center mt-3" style="font-size: 12.5px; color: #64748b;">
                            <i class="feather-clock me-1"></i> Course will be unlocked upon admin payment approval.
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

<!-- Gateway Switching & File Preview Script -->
<script>
const gatewaysData = {
    @foreach($gateways as $gw)
    "{{ $gw->id }}": {
        id: {{ $gw->id }},
        name: "{{ addslashes($gw->name) }}",
        type: "{{ $gw->type }}",
        account_number: "{{ addslashes($gw->account_number) }}",
        account_type: "{{ addslashes($gw->account_type ?? '') }}",
        bank_name: "{{ addslashes($gw->bank_name ?? '') }}",
        branch_name: "{{ addslashes($gw->branch_name ?? '') }}",
        routing_number: "{{ addslashes($gw->routing_number ?? '') }}",
        instruction: "{{ addslashes(preg_replace('/\r|\n/', ' ', $gw->instruction ?? '')) }}"
    },
    @endforeach
};

let currentSelectedGateway = null;

function selectGateway(id, type, name, accNo, accType, bankName, branch, routing, instruction) {
    currentSelectedGateway = gatewaysData[id] || {
        id: id, type: type, name: name, account_number: accNo, account_type: accType,
        bank_name: bankName, branch_name: branch, routing_number: routing, instruction: instruction
    };

    // Update hidden input
    document.getElementById('selectedGatewayId').value = id;

    // Update active card styling
    document.querySelectorAll('.gateway-option-card').forEach(card => card.classList.remove('selected'));
    const activeCard = document.getElementById('gw_card_' + id);
    if (activeCard) activeCard.classList.add('selected');

    // Update Instruction Panel
    document.getElementById('panelAccNumber').innerText = currentSelectedGateway.account_number;
    document.getElementById('panelAccTypeLabel').innerText = (currentSelectedGateway.account_type ? currentSelectedGateway.account_type + ' ' : '') + (currentSelectedGateway.type === 'mfs' ? 'Number' : 'Account Number');
    document.getElementById('summaryGatewayName').innerText = currentSelectedGateway.name;

    if (currentSelectedGateway.instruction) {
        document.getElementById('panelInstruction').innerText = currentSelectedGateway.instruction;
    } else {
        document.getElementById('panelInstruction').innerText = "Please transfer the exact fee to the account above and enter your verification details below.";
    }

    // Toggle MFS vs Bank Fields
    const mfsGroup = document.getElementById('mfsFieldsGroup');
    const bankGroup = document.getElementById('bankFieldsGroup');
    const bankExtra = document.getElementById('bankExtraDetails');
    const senderNumberInput = document.getElementById('senderNumberInput');
    const bankNameInput = document.getElementById('bankNameInput');
    const bankAccInput = document.getElementById('bankAccInput');
    const trxLabel = document.getElementById('trxLabel');
    const trxHelp = document.getElementById('trxHelp');

    if (currentSelectedGateway.type === 'mfs') {
        mfsGroup.style.display = 'block';
        bankGroup.style.display = 'none';
        bankExtra.style.display = 'none';
        senderNumberInput.setAttribute('required', 'required');
        bankNameInput.removeAttribute('required');
        bankAccInput.removeAttribute('required');
        trxLabel.innerText = "Transaction ID (TrxID)";
        trxHelp.innerText = "Enter the 8-10 character TrxID from your bKash / Nagad confirmation SMS.";
    } else {
        mfsGroup.style.display = 'none';
        bankGroup.style.display = 'block';
        bankExtra.style.display = 'block';
        senderNumberInput.removeAttribute('required');
        bankNameInput.setAttribute('required', 'required');
        bankAccInput.setAttribute('required', 'required');
        document.getElementById('panelBankName').innerText = currentSelectedGateway.bank_name || '--';
        document.getElementById('panelBranchName').innerText = currentSelectedGateway.branch_name || '--';
        document.getElementById('panelRoutingNumber').innerText = currentSelectedGateway.routing_number || '--';
        trxLabel.innerText = "Deposit Reference / Transaction / Trx ID";
        trxHelp.innerText = "Enter the reference or transaction ID from your bank transfer or deposit receipt.";
    }
}

function copyAccountNumber() {
    if (!currentSelectedGateway || !currentSelectedGateway.account_number) return;
    navigator.clipboard.writeText(currentSelectedGateway.account_number).then(() => {
        const copyText = document.getElementById('copyBtnText');
        copyText.innerText = 'Copied!';
        setTimeout(() => { copyText.innerText = 'Copy'; }, 2000);
    });
}

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('screenshotPreviewImg').src = e.target.result;
            document.getElementById('screenshotPreviewWrap').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

function removeScreenshot(event) {
    event.stopPropagation();
    const input = document.getElementById('screenshotFileInput');
    input.value = '';
    document.getElementById('screenshotPreviewImg').src = '';
    document.getElementById('screenshotPreviewWrap').style.display = 'none';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedId = document.getElementById('selectedGatewayId').value;
    if (selectedId && gatewaysData[selectedId]) {
        const g = gatewaysData[selectedId];
        selectGateway(g.id, g.type, g.name, g.account_number, g.account_type, g.bank_name, g.branch_name, g.routing_number, g.instruction);
    } else {
        const firstKey = Object.keys(gatewaysData)[0];
        if (firstKey) {
            const g = gatewaysData[firstKey];
            selectGateway(g.id, g.type, g.name, g.account_number, g.account_type, g.bank_name, g.branch_name, g.routing_number, g.instruction);
        }
    }
});
</script>

<!-- Include Newsletter -->
@include('user.pages.newsletter')

@endsection
