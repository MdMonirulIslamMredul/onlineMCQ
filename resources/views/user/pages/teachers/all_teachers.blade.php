@extends('user.pages.test_master')
@section('content')

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 60px 0 70px;">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ul class="d-flex align-items-center justify-content-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                <li style="color: #03c6bb; font-weight: 600;">Instructors & Mentors</li>
            </ul>
        </nav>
        <div class="student-hero-badge mx-auto">
            <i class="feather-users"></i> World-Class Faculty
        </div>
        <h1 class="student-hero-title mb-3" style="font-size: clamp(30px, 4vw, 44px);">
            Learn from Certified Mentors & Experts
        </h1>
        <p class="student-hero-desc mx-auto mb-0" style="max-width: 650px;">
            Our instructors bring years of competitive examination expertise and practical industry knowledge directly to your screen.
        </p>
    </div>
</div>
<!-- End Hero Area -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4">
            @foreach($teachers as $teacher)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="p-4 rounded-4 text-center h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                        <div class="mb-3" style="width: 140px; height: 140px; margin: 0 auto; border-radius: 50%; overflow: hidden; border: 3px solid #03c6bb; box-shadow: 0 4px 14px rgba(3, 198, 187, 0.25);">
                            <img src="{{ asset($teacher->image) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $teacher->name }}">
                        </div>
                        <h4 class="mb-1" style="font-weight: 700; font-size: 20px;">
                            <a href="javascript:void(0)" style="color: #0f172a; text-decoration: none;">{{ $teacher->name }}</a>
                        </h4>
                        <span class="badge mb-2" style="background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-weight: 600; font-size: 13px; padding: 4px 12px; border-radius: 9999px;">
                            {{ $teacher->subject }}
                        </span>
                        <div class="text-muted mt-2" style="font-size: 14px;">
                            {{ $teacher->job_title }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
