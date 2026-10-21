@extends('user.pages.test_master')
@section('content')

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 50px 0 60px;">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ul class="d-flex align-items-center justify-content-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li style="color: #03c6bb; font-weight: 600;">Student Portal</li>
            </ul>
        </nav>
        <div class="student-hero-badge mx-auto">
            <i class="feather-user-check"></i> Student Access
        </div>
        <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 3.8vw, 42px);">
            Welcome to Your Learning Portal
        </h1>
        <p class="student-hero-desc mx-auto mb-0" style="max-width: 600px;">
            Log in to access your enrolled courses, model exam history, and performance reports.
        </p>
    </div>
</div>
<!-- End Hero Area -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5 align-items-center justify-content-center">
            <!-- Left Info Column -->
            <div class="col-lg-5 col-12 order-2 order-lg-1">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
                    <div class="student-hero-badge mb-3" style="background: rgba(3, 198, 187, 0.2); border-color: rgba(3, 198, 187, 0.4);">
                        <i class="feather-star"></i> Student Benefits
                    </div>
                    <h3 class="text-white mb-3" style="font-weight: 800; font-size: 26px;">
                        Why Learn With Us?
                    </h3>
                    <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 25px;">
                        Join an ambitious community of students and candidates preparing for academic and career excellence.
                    </p>

                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(3, 198, 187, 0.15); color: #03c6bb; font-size: 20px;">
                                <i class="feather-clock"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1" style="font-weight: 700;">Timed Model Tests</h6>
                                <p style="color: #94a3b8; font-size: 13px; margin: 0;">Experience real exam environments with instant score cards.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(79, 70, 229, 0.15); color: #818cf8; font-size: 20px;">
                                <i class="feather-book-open"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1" style="font-weight: 700;">Structured Courses</h6>
                                <p style="color: #94a3b8; font-size: 13px; margin: 0;">Step-by-step video lessons and verified curriculum.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-size: 20px;">
                                <i class="feather-award"></i>
                            </div>
                            <div>
                                <h6 class="text-white mb-1" style="font-weight: 700;">Verified Credentials</h6>
                                <p style="color: #94a3b8; font-size: 13px; margin: 0;">Earn official completion certificates for your profile.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-lg-6 col-12 order-1 order-lg-2">
                <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0;">
                    <!-- Nav Tabs Switcher -->
                    <ul class="nav nav-pills nav-fill mb-4 p-1 rounded-pill" style="background: #f1f5f9;" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill fw-bold py-2" id="login-tab-btn" data-bs-toggle="pill" data-bs-target="#login-pane" type="button" role="tab" style="font-size: 15px;">
                                <i class="feather-log-in me-1"></i> Sign In
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill fw-bold py-2" id="register-tab-btn" data-bs-toggle="pill" data-bs-target="#register-pane" type="button" role="tab" style="font-size: 15px;">
                                <i class="feather-user-plus me-1"></i> Register Free
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Login Form -->
                        <div class="tab-pane fade show active" id="login-pane" role="tabpanel">
                            <div class="mb-4">
                                <h4 style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Student Login</h4>
                                <p class="text-muted" style="font-size: 14px;">Enter your phone number or email to access your account.</p>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger py-2 px-3 rounded-3 mb-3" style="font-size: 14px;">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; font-size: 14px; color: #334155;">Phone Number / Email *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 8px 0 0 8px;"><i class="feather-user text-muted"></i></span>
                                        <input name="email_or_phone" type="text" class="form-control border-start-0" placeholder="e.g. 01712345678" required style="border-radius: 0 8px 8px 0; padding: 12px;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label mb-0" style="font-weight: 600; font-size: 14px; color: #334155;">Password *</label>
                                        <a href="{{ route('user.password.reset') }}" style="color: #03c6bb; font-size: 13px; font-weight: 600; text-decoration: none;">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 8px 0 0 8px;"><i class="feather-lock text-muted"></i></span>
                                        <input name="password" type="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 8px 8px 0; padding: 12px;">
                                    </div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme">
                                    <label class="form-check-label text-muted" for="rememberme" style="font-size: 14px;">
                                        Remember my login on this device
                                    </label>
                                </div>

                                <button type="submit" class="rbt-btn btn-gradient w-100 radius-round py-3">
                                    <span class="btn-text">Log In To Account</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </button>
                            </form>
                        </div>

                        <!-- Register Form -->
                        <div class="tab-pane fade" id="register-pane" role="tabpanel">
                            <div class="mb-4">
                                <h4 style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">Create Student Account</h4>
                                <p class="text-muted" style="font-size: 14px;">Fill in your details to start practicing immediately.</p>
                            </div>

                            <form action="{{ route('user.register') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; font-size: 14px; color: #334155;">Full Name *</label>
                                    <input name="name" type="text" class="form-control" placeholder="Your full name" required style="border-radius: 8px; padding: 12px;">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; font-size: 14px; color: #334155;">Phone Number *</label>
                                    <input name="phone" type="number" class="form-control" placeholder="01XXXXXXXXX" required style="border-radius: 8px; padding: 12px;">
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; font-size: 14px; color: #334155;">Password *</label>
                                    <input name="password" type="password" class="form-control" placeholder="Create a strong password" required style="border-radius: 8px; padding: 12px;">
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" style="font-weight: 600; font-size: 14px; color: #334155;">Confirm Password *</label>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm your password" required style="border-radius: 8px; padding: 12px;">
                                </div>

                                <button type="submit" class="rbt-btn btn-gradient w-100 radius-round py-3">
                                    <span class="btn-text">Create Free Account</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nav-pills .nav-link.active {
    background: #03c6bb !important;
    color: #ffffff !important;
}
.nav-pills .nav-link {
    color: #475569;
}
</style>

@endsection
