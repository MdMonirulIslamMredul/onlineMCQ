@extends('user.pages.test_master')
@section('content')

@php
    $product_info = $product_info ?? DB::table('books')->where('id', $pid)->first();
    $userID = Cookie::get('user_id');
    $user_info = $user_info ?? ($userID ? DB::table('users')->where('id', $userID)->first() : null);
    $selectedBookType = $book_type ?? 'hardcopy';
    $unitPrice = isset($unit_price) ? $unit_price : ($selectedBookType == 'softcopy' && !empty($product_info->softcopy_price) ? $product_info->softcopy_price : ($product_info->hardcopy_price ?: $product_info->price));
    $quantity = isset($quantity) ? $quantity : 1;
    $totalAmount = $unitPrice * $quantity;
    $gateways = isset($gateways) && count($gateways) ? $gateways : \App\Models\PaymentGateway::where('status', 1)->orderBy('id', 'asc')->get();
@endphp

<style>
/* Scoped Checkout Styles (Identical to Course Checkout System) */
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
    background: rgba(0, 122, 85, 0.12);
    color: #007A55;
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
    width: 100%;
}

.checkout-input-wrap .checkout-input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
    pointer-events: none;
    z-index: 2;
    transition: color 0.2s ease;
}

.checkout-input-wrap input.checkout-input,
.checkout-input-wrap .checkout-input,
input.checkout-input,
.checkout-input {
    width: 100% !important;
    height: 50px !important;
    padding: 10px 16px 10px 52px !important;
    padding-left: 52px !important;
    font-size: 14.5px !important;
    font-weight: 500 !important;
    color: #1e293b !important;
    background-color: #ffffff !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 12px !important;
    outline: none !important;
    box-shadow: none !important;
    transition: all 0.2s ease;
}

.checkout-input-wrap input.checkout-input:focus,
.checkout-input-wrap .checkout-input:focus,
input.checkout-input:focus,
.checkout-input:focus {
    border-color: #007A55 !important;
    box-shadow: 0 0 0 4px rgba(0, 122, 85, 0.16) !important;
    background-color: #ffffff !important;
}

.checkout-input:focus + .checkout-input-icon,
.checkout-input-wrap:focus-within .checkout-input-icon {
    color: #007A55 !important;
}

/* Method Mode Switcher (Gateway vs COD) */
.method-mode-selector {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.method-mode-btn {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 16px;
    background: #ffffff;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    font-size: 14px;
    color: #334155;
    transition: all 0.2s ease;
}

.method-mode-btn.active {
    border-color: #007A55;
    background: #f0fdfa;
    color: #007A55;
    box-shadow: 0 0 0 3px rgba(0, 122, 85, 0.15);
}

.method-mode-btn i {
    font-size: 20px;
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
    border-color: #007A55;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 122, 85, 0.12);
}

.gateway-option-card.selected {
    border-color: #007A55;
    background: #f0fdfa;
    box-shadow: 0 0 0 3px rgba(0, 122, 85, 0.2);
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
    background: #007A55;
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
    border: 1.5px dashed #007A55;
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
    background: #007A55;
    color: #ffffff;
    border-color: #007A55;
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
    border-color: #007A55;
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
    accent-color: #007A55;
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
    color: #007A55;
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

.order-book-thumb {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
    border-radius: 12px;
    margin-bottom: 16px;
    background: #f8fafc;
    padding: 10px;
    border: 1px solid #f1f5f9;
}

.order-format-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 10px;
}

.badge-softcopy {
    background: rgba(14, 165, 233, 0.12);
    color: #0284c7;
}

.badge-hardcopy {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
}

.order-book-title {
    font-family: var(--font-heading, 'Outfit', sans-serif);
    font-size: 18px;
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
    color: #007A55;
}

.order-confirm-btn {
    width: 100%;
    height: 54px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #007A55 0%, #005a3e 100%);
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
    box-shadow: 0 4px 15px rgba(0, 122, 85, 0.35);
    transition: all 0.25s ease;
}

.order-confirm-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 122, 85, 0.45);
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
html.dark-theme .order-book-title,
[data-theme="dark"] .order-book-title,
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
    border-color: #007A55 !important;
    background-color: #0f172a !important;
}

html.dark-theme .method-mode-btn,
[data-theme="dark"] .method-mode-btn {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #cbd5e1 !important;
}

html.dark-theme .method-mode-btn.active,
[data-theme="dark"] .method-mode-btn.active {
    border-color: #007A55 !important;
    background: #0c2331 !important;
    color: #10b981 !important;
}

html.dark-theme .gateway-option-card,
[data-theme="dark"] .gateway-option-card {
    background: #0f172a !important;
    border-color: #334155 !important;
}

html.dark-theme .gateway-option-card.selected,
[data-theme="dark"] .gateway-option-card.selected {
    border-color: #007A55 !important;
    background: #0c2331 !important;
}

html.dark-theme .gateway-detail-panel,
[data-theme="dark"] .gateway-detail-panel {
    background: #0f172a !important;
    border-color: #007A55 !important;
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

html.dark-theme .order-book-thumb,
[data-theme="dark"] .order-book-thumb {
    background: #0f172a !important;
    border-color: #334155 !important;
}

html.dark-theme .order-price-row.total-row,
[data-theme="dark"] .order-price-row.total-row,
html.dark-theme .checkout-guarantee-strip,
[data-theme="dark"] .checkout-guarantee-strip {
    border-color: #334155 !important;
}

html.dark-theme .order-total-amount,
[data-theme="dark"] .order-total-amount {
    color: #10b981 !important;
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
                        <li><a href="{{ route('shop') }}" style="color: #94a3b8; text-decoration: none;">Books</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #007A55; font-weight: 600;">Checkout & Payment</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-shield"></i> 256-Bit SSL Secure Order
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(24px, 3.2vw, 38px); line-height: 1.35; padding-bottom: 6px;">
                    Complete Your Book Order
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

        @if(isset($errors) && $errors->any())
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
        <form method="post" action="{{ url('/buybook/pay') }}" id="bookCheckoutForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pid" value="{{ $product_info->id }}">
            <input type="hidden" name="price" value="{{ $unitPrice }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
            <input type="hidden" name="book_type" id="bookTypeInput" value="{{ $selectedBookType }}">
            <input type="hidden" name="payment_method_type" id="paymentMethodType" value="gateway">

            <div class="row g-4">
                <!-- Left: Customer Info & Payment Details -->
                <div class="col-lg-7 col-xl-8">

                    <!-- Step 1: Customer Contact & Delivery Info -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-icon-badge">
                                <i class="feather-user-check"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">1. Customer & Delivery Information</h3>
                                <p class="checkout-card-sub">
                                    @if($selectedBookType === 'softcopy')
                                        Contact details to link your digital online reader access.
                                    @else
                                        Shipping details for postal/courier delivery of your printed book.
                                    @endif
                                </p>
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

                            <!-- Delivery Address -->
                            <div class="col-12 checkout-form-group mb-0">
                                <label class="checkout-label">
                                    Delivery Address / District 
                                    @if($selectedBookType === 'hardcopy')
                                        <span class="text-danger">*</span>
                                    @else
                                        <span class="text-muted small">(Optional for E-Book)</span>
                                    @endif
                                </label>
                                <div class="checkout-input-wrap">
                                    <i class="feather-map-pin checkout-input-icon"></i>
                                    <input type="text" name="address" id="addressInput" value="{{ old('address', optional($user_info)->address) }}" class="checkout-input" placeholder="e.g. House #12, Road #4, Dhanmondi, Dhaka" {{ $selectedBookType === 'hardcopy' ? 'required' : '' }}>
                                </div>
                                @if($selectedBookType === 'hardcopy')
                                <small class="text-muted mt-1 d-block">Courier delivery will be shipped to this address.</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Payment Method Selection -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-icon-badge">
                                <i class="feather-credit-card"></i>
                            </div>
                            <div>
                                <h3 class="checkout-card-title">2. Select Payment Method</h3>
                                <p class="checkout-card-sub">Choose your preferred payment method to complete this order of <b>৳ {{ number_format($totalAmount, 0) }}</b>.</p>
                            </div>
                        </div>

                        <!-- Method Switcher (Gateway vs COD) -->
                        @if($selectedBookType === 'hardcopy')
                        <div class="method-mode-selector">
                            <div class="method-mode-btn active" id="modeBtnGateway" onclick="setPaymentMode('gateway')">
                                <i class="feather-credit-card"></i>
                                <div>
                                    <div>Manual Payment Gateway</div>
                                    <small style="font-weight: normal; opacity: 0.8;">bKash, Nagad, Rocket, Bank</small>
                                </div>
                            </div>
                            <div class="method-mode-btn" id="modeBtnCod" onclick="setPaymentMode('cash')">
                                <i class="feather-truck"></i>
                                <div>
                                    <div>Cash on Delivery (COD)</div>
                                    <small style="font-weight: normal; opacity: 0.8;">Pay cash upon delivery</small>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-info py-2 px-3 mb-3 rounded-3 d-flex align-items-center gap-2" style="font-size: 13.5px;">
                            <i class="feather-info text-info fs-5 flex-shrink-0"></i>
                            <div>
                                <strong>ডিজিটাল ই-বুক (Softcopy):</strong> ক্রয়ের সাথে সাথে অনলাইনে পড়ার জন্য যেকোনো মোবাইল ব্যাংকিং (bKash/Nagad/Rocket) বা ব্যাংক ট্রান্সফারের মাধ্যমে পেমেন্ট সম্পন্ন করুন।
                            </div>
                        </div>
                        @endif

                        <!-- Gateway Content Section -->
                        <div id="gatewaySection">
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
                                            <div style="font-weight: 800; color: #007A55; font-size: 16px;">
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
                                        <div class="fw-bold fs-5 text-success">৳ {{ number_format($totalAmount, 0) }} BDT</div>
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
                                    <p class="checkout-card-sub">Provide proof of payment for manual admin verification and order processing.</p>
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
                                        <input type="text" name="trx_id" id="trxIdInput" value="{{ old('trx_id') }}" class="checkout-input" placeholder="e.g. 9J4K8LMN2P">
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
                                        <input type="file" name="screenshot" id="screenshotFileInput" accept="image/*" style="display: none;" onchange="handleFileSelect(this)">

                                        <!-- Live Preview -->
                                        <div class="screenshot-preview-wrap" id="screenshotPreviewWrap" onclick="event.stopPropagation()">
                                            <img id="screenshotPreviewImg" src="" alt="Proof Preview">
                                            <button type="button" class="remove-screenshot-btn" onclick="removeScreenshot(event)">
                                                <i class="feather-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Admin will check this screenshot and TrxID to approve the book order.</small>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-warning">
                                <i class="feather-alert-triangle me-2"></i> No active payment gateway found. Please contact administration.
                            </div>
                            @endif
                        </div>

                        <!-- COD Notification Box (Shown when COD is selected) -->
                        <div id="codNoticeBox" style="display: none;" class="p-4 rounded-3 border border-success bg-success-subtle mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="checkout-icon-badge" style="background: rgba(16, 185, 129, 0.2); color: #059669;">
                                    <i class="feather-package"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark fw-bold">Cash on Delivery (ক্যাশ অন ডেলিভারি)</h5>
                                    <p class="mb-0 text-muted" style="font-size: 13.5px;">
                                        বইটি কুরিয়ার ডেলিভারিম্যান থেকে হাতে পেয়ে মূল্য <b>৳ {{ number_format($totalAmount, 0) }}</b> নগদ পরিশোধ করবেন। কোনো অগ্রিম পেমেন্ট বা স্ক্রিনশটের প্রয়োজন নেই।
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="checkout-agreement-box">
                            <input type="checkbox" id="agreeTerms" name="agree" value="1" required checked>
                            <label for="agreeTerms" class="checkout-agreement-text mb-0">
                                I confirm my order and contact details are accurate and agree to Pathjolpona's
                                <a href="{{ route('user.trams_and_conditions') }}" target="_blank">Terms of Service</a> and
                                <a href="{{ route('user.privacy_and_policy') }}" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>

                        <!-- Guarantee Strip -->
                        <div class="checkout-guarantee-strip">
                            <span><i class="feather-lock text-success"></i> 256-Bit SSL Encrypted</span>
                            <span><i class="feather-shield text-info"></i> Verified Order Guarantee</span>
                            <span><i class="feather-award text-primary"></i> 100% Authentic Quality</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary Sidebar -->
                <div class="col-lg-5 col-xl-4">
                    <div class="order-summary-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="checkout-card-title" style="font-size: 18px;">Order Summary</h4>
                            <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">{{ $quantity }} {{ $quantity > 1 ? 'Items' : 'Item' }}</span>
                        </div>

                        @if(!empty($product_info->image) && file_exists(public_path($product_info->image)))
                        <img src="{{ asset($product_info->image) }}" alt="{{ $product_info->name }}" class="order-book-thumb">
                        @else
                        <div class="order-book-thumb d-flex align-items-center justify-content-center text-muted" style="height: 160px;">
                            <i class="feather-book" style="font-size: 48px; color: #94a3b8;"></i>
                        </div>
                        @endif

                        <div>
                            @if($selectedBookType === 'softcopy')
                            <span class="order-format-badge badge-softcopy">
                                <i class="feather-book-open me-1"></i> E-Book (Softcopy Online Read)
                            </span>
                            @else
                            <span class="order-format-badge badge-hardcopy">
                                <i class="feather-book me-1"></i> Hardcopy (Printed Delivery)
                            </span>
                            @endif
                        </div>

                        <h5 class="order-book-title">
                            {{ $product_info->name }}
                        </h5>

                        <!-- Price Breakdown -->
                        <div class="order-price-row">
                            <span>Unit Price</span>
                            <span class="fw-semibold text-dark">৳ {{ number_format($unitPrice, 0) }}</span>
                        </div>
                        <div class="order-price-row">
                            <span>Quantity</span>
                            <span class="fw-semibold text-dark">{{ $quantity }}</span>
                        </div>
                        <div class="order-price-row">
                            <span>Selected Method</span>
                            <span class="fw-bold text-primary" id="summaryGatewayName">
                                {{ $selectedBookType === 'softcopy' ? 'Online Gateway' : 'bKash / Gateway' }}
                            </span>
                        </div>

                        <div class="order-price-row total-row">
                            <span>Total Payable</span>
                            <div class="order-total-amount">
                                ৳ {{ number_format($totalAmount, 0) }}
                            </div>
                        </div>

                        <button type="submit" class="order-confirm-btn" id="confirmOrderBtn">
                            <span id="btnSubmitText">Place Order & Submit Payment</span>
                            <i class="feather-arrow-right"></i>
                        </button>

                        <div class="text-center mt-3" style="font-size: 12.5px; color: #64748b;">
                            @if($selectedBookType === 'softcopy')
                            <i class="feather-check-circle me-1 text-success"></i> E-Book will be available in your library upon payment approval.
                            @else
                            <i class="feather-truck me-1 text-primary"></i> Fast and secure courier delivery across Bangladesh.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="text-center py-5">
            <i class="feather-alert-triangle text-warning" style="font-size: 48px;"></i>
            <h4 class="mt-3">Book Not Found</h4>
            <p class="text-muted">The requested book could not be located. Please browse our books catalog.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary radius-round px-4 py-2 mt-2">Browse All Books</a>
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
let currentPaymentMode = 'gateway';

function setPaymentMode(mode) {
    currentPaymentMode = mode;
    const modeInput = document.getElementById('paymentMethodType');
    const gatewaySection = document.getElementById('gatewaySection');
    const codNotice = document.getElementById('codNoticeBox');
    const btnText = document.getElementById('btnSubmitText');
    const summaryGateway = document.getElementById('summaryGatewayName');
    const btnGateway = document.getElementById('modeBtnGateway');
    const btnCod = document.getElementById('modeBtnCod');

    const trxInput = document.getElementById('trxIdInput');
    const screenshotInput = document.getElementById('screenshotFileInput');
    const senderNumberInput = document.getElementById('senderNumberInput');
    const bankNameInput = document.getElementById('bankNameInput');
    const bankAccInput = document.getElementById('bankAccInput');

    if (modeInput) modeInput.value = mode;

    if (mode === 'cash') {
        if (btnGateway) btnGateway.classList.remove('active');
        if (btnCod) btnCod.classList.add('active');
        if (gatewaySection) gatewaySection.style.display = 'none';
        if (codNotice) codNotice.style.display = 'block';
        if (btnText) btnText.innerText = 'Confirm Cash on Delivery Order';
        if (summaryGateway) summaryGateway.innerText = 'Cash on Delivery (COD)';

        // Remove required from payment proof fields
        if (trxInput) trxInput.removeAttribute('required');
        if (screenshotInput) screenshotInput.removeAttribute('required');
        if (senderNumberInput) senderNumberInput.removeAttribute('required');
        if (bankNameInput) bankNameInput.removeAttribute('required');
        if (bankAccInput) bankAccInput.removeAttribute('required');
    } else {
        if (btnGateway) btnGateway.classList.add('active');
        if (btnCod) btnCod.classList.remove('active');
        if (gatewaySection) gatewaySection.style.display = 'block';
        if (codNotice) codNotice.style.display = 'none';
        if (btnText) btnText.innerText = 'Place Order & Submit Payment';

        if (trxInput) trxInput.setAttribute('required', 'required');
        if (screenshotInput) screenshotInput.setAttribute('required', 'required');

        if (currentSelectedGateway) {
            selectGateway(
                currentSelectedGateway.id,
                currentSelectedGateway.type,
                currentSelectedGateway.name,
                currentSelectedGateway.account_number,
                currentSelectedGateway.account_type,
                currentSelectedGateway.bank_name,
                currentSelectedGateway.branch_name,
                currentSelectedGateway.routing_number,
                currentSelectedGateway.instruction
            );
        }
    }
}

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
    const accEl = document.getElementById('panelAccNumber');
    if (accEl) accEl.innerText = currentSelectedGateway.account_number;

    const labelEl = document.getElementById('panelAccTypeLabel');
    if (labelEl) labelEl.innerText = (currentSelectedGateway.account_type ? currentSelectedGateway.account_type + ' ' : '') + (currentSelectedGateway.type === 'mfs' ? 'Number' : 'Account Number');

    const summaryEl = document.getElementById('summaryGatewayName');
    if (summaryEl && currentPaymentMode === 'gateway') summaryEl.innerText = currentSelectedGateway.name;

    const instEl = document.getElementById('panelInstruction');
    if (instEl) {
        if (currentSelectedGateway.instruction) {
            instEl.innerText = currentSelectedGateway.instruction;
        } else {
            instEl.innerText = "Please transfer the exact fee to the account above and enter your verification details below.";
        }
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
        if (mfsGroup) mfsGroup.style.display = 'block';
        if (bankGroup) bankGroup.style.display = 'none';
        if (bankExtra) bankExtra.style.display = 'none';
        if (senderNumberInput && currentPaymentMode === 'gateway') senderNumberInput.setAttribute('required', 'required');
        if (bankNameInput) bankNameInput.removeAttribute('required');
        if (bankAccInput) bankAccInput.removeAttribute('required');
        if (trxLabel) trxLabel.innerText = "Transaction ID (TrxID)";
        if (trxHelp) trxHelp.innerText = "Enter the 8-10 character TrxID from your bKash / Nagad confirmation SMS.";
    } else {
        if (mfsGroup) mfsGroup.style.display = 'none';
        if (bankGroup) bankGroup.style.display = 'block';
        if (bankExtra) bankExtra.style.display = 'block';
        if (senderNumberInput) senderNumberInput.removeAttribute('required');
        if (bankNameInput && currentPaymentMode === 'gateway') bankNameInput.setAttribute('required', 'required');
        if (bankAccInput && currentPaymentMode === 'gateway') bankAccInput.setAttribute('required', 'required');
        
        const bName = document.getElementById('panelBankName');
        if (bName) bName.innerText = currentSelectedGateway.bank_name || '--';
        const bBranch = document.getElementById('panelBranchName');
        if (bBranch) bBranch.innerText = currentSelectedGateway.branch_name || '--';
        const bRouting = document.getElementById('panelRoutingNumber');
        if (bRouting) bRouting.innerText = currentSelectedGateway.routing_number || '--';

        if (trxLabel) trxLabel.innerText = "Deposit Reference / Transaction / Trx ID";
        if (trxHelp) trxHelp.innerText = "Enter the reference or transaction ID from your bank transfer or deposit receipt.";
    }
}

function copyAccountNumber() {
    if (!currentSelectedGateway || !currentSelectedGateway.account_number) return;
    navigator.clipboard.writeText(currentSelectedGateway.account_number).then(() => {
        const copyText = document.getElementById('copyBtnText');
        if (copyText) {
            copyText.innerText = 'Copied!';
            setTimeout(() => { copyText.innerText = 'Copy'; }, 2000);
        }
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
    const selectedId = document.getElementById('selectedGatewayId') ? document.getElementById('selectedGatewayId').value : null;
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

@endsection
