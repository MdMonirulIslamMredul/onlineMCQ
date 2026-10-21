@extends('user.pages.test_master')
@section('content')

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 60px 0 70px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">{{ $course_category->name }}</li>
                    </ul>
                </nav>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="student-hero-badge">
                            <i class="feather-book-open"></i> Course Catalog
                        </div>
                        <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 4vw, 42px);">
                            {{ $course_category->name }}
                        </h1>
                        <p class="student-hero-desc mb-0" style="max-width: 650px;">
                            Master industry-demanded skills through structured video lessons, hands-on tasks, and expert support.
                        </p>
                    </div>
                    <div class="p-3 rounded-4 text-center" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15); min-width: 160px;">
                        <div style="font-family: var(--font-heading); font-size: 32px; font-weight: 800; color: #ffffff;">
                            {{ $courses->total() }}
                        </div>
                        <div style="color: #38bdf8; font-size: 13px; font-weight: 600; text-transform: uppercase;">
                            Courses Available
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Area -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4">
            @forelse ($courses as $course)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="modern-course-card">
                        <div class="modern-course-thumb">
                            <a href="{{ url('/course/' . $course->id) }}">
                                <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" loading="lazy">
                            </a>
                            <span class="modern-course-badge-top">
                                <i class="feather-award"></i> {{ $course_category->name }}
                            </span>
                        </div>
                        <div class="modern-course-body">
                            <div class="modern-course-meta">
                                <span><i class="feather-book-open"></i> 20 Lessons</span>
                                <span><i class="feather-users"></i> 40+ Students</span>
                            </div>
                            <h4 class="modern-course-title">
                                <a href="{{ url('/course/' . $course->id) }}">{{ $course->name }}</a>
                            </h4>
                            <div class="modern-course-footer">
                                <div class="modern-course-price">৳{{ number_format($course->price, 0) }}</div>
                                <a class="modern-btn-enroll" href="{{ url('/course/' . $course->id) }}">
                                    Enroll Now <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                        <i class="feather-folder text-muted" style="font-size: 36px;"></i>
                        <h4 class="mt-3 text-muted">No courses found in this category.</h4>
                        <a href="{{ url('/') }}" class="rbt-btn btn-sm btn-gradient radius-round mt-3">Back to Home</a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row mt-5">
            <div class="col-lg-12">
                <nav class="d-flex justify-content-center">
                    {!! $courses->links() !!}
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
}
.page-item .page-link {
    color: #1e293b;
    border-radius: 8px !important;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    font-weight: 600;
}
.page-item.active .page-link {
    background: #03c6bb !important;
    border-color: #03c6bb !important;
    color: #ffffff !important;
}
</style>

@endsection
