@extends('user.pages.test_master')

@push('test_style')
<style>
    .category-hero-banner {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.12) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.12) 0%, transparent 40%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 55px 0 65px;
        color: #ffffff;
        position: relative;
    }
    .modern-cat-grid-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        text-decoration: none;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }
    .modern-cat-grid-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        border-color: #03c6bb;
    }
    .modern-cat-img-box {
        width: 100%;
        height: 150px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 18px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modern-cat-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .modern-cat-grid-card:hover .modern-cat-img-box img {
        transform: scale(1.05);
    }
    .modern-cat-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.35;
        transition: color 0.2s ease;
    }
    .modern-cat-grid-card:hover .modern-cat-title {
        color: #03c6bb;
    }
    .modern-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: rgba(3, 198, 187, 0.1);
        color: #009e95;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        margin-top: auto;
    }
    .course-slider-wrap {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
    .course-slider-wrap img {
        height: 380px;
        width: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<!-- Start Hero Banner -->
<div class="category-hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">Course Categories</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-book"></i> Comprehensive Course Programs
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 4vw, 42px);">
                    Explore Our Academic & Job Prep Categories
                </h1>
                <p class="student-hero-desc mb-0">
                    Find top-tier courses, video lessons, and mock test preparation for government and competitive exams.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('/') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">Back to Home</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<!-- Main Categories & Featured Slider Section -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        @php
            $featuredCats = DB::table('course_categories')
                ->whereIn('rank', [1, 2, 3, 4])
                ->orderBy('rank')
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();

            $courseCounts = DB::table('courses')
                ->select('catID', DB::raw('count(*) as total'))
                ->groupBy('catID')
                ->pluck('total', 'catID');

            $info = \App\Models\SliderInfo::with('images')->orderBy('id', 'desc')->first();
        @endphp

        <div class="row g-4 align-items-stretch">
            <!-- Featured Categories Left Column -->
            <div class="col-lg-5 col-12">
                <div class="mb-4">
                    <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 24px;">Top Specializations</h3>
                    <p class="text-muted mb-0" style="font-size: 14px;">Select your field of study to view available modules.</p>
                </div>
                <div class="row g-3">
                    @foreach ($featuredCats as $course)
                        @php
                            $cCount = $courseCounts[$course->id] ?? 0;
                        @endphp
                        <div class="col-sm-6 col-12">
                            <a href="{{ route('cat', $course->id) }}" class="modern-cat-grid-card">
                                <div class="modern-cat-img-box" style="height: 110px;">
                                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/course-cat-default.jpg') }}';">
                                </div>
                                <h4 class="modern-cat-title" style="font-size: 16px;">{{ $course->name }}</h4>
                                <span class="modern-cat-badge">
                                    <i class="feather-book-open"></i> {{ $cCount }} Courses
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Slider Right Column -->
            <div class="col-lg-7 col-12">
                <div class="mb-4 d-none d-lg-block">
                    <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 24px;">Featured Highlights</h3>
                    <p class="text-muted mb-0" style="font-size: 14px;">Latest announcements and scholarship opportunities.</p>
                </div>
                @if($info && $info->images && $info->images->count() > 0)
                    <div id="courseCatSlider" class="carousel slide carousel-fade course-slider-wrap" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($info->images as $index => $image)
                                <button type="button" data-bs-target="#courseCatSlider"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($info->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->image) }}" class="d-block w-100" alt="{{ $info->title }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#courseCatSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#courseCatSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <div class="p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center h-100" style="background: linear-gradient(135deg, rgba(3, 198, 187, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%); border: 1px dashed #cbd5e1; min-height: 300px;">
                        <i class="feather-award text-primary mb-3" style="font-size: 48px; color: #03c6bb !important;"></i>
                        <h4 style="color: #0f172a; font-weight: 700;">Student Career Guidance</h4>
                        <p class="text-muted" style="max-width: 400px; font-size: 14px;">Explore our job-specific prep courses to secure your dream government or private sector position.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Secondary Categories (Rank 5-8) -->
        @php
            $secondaryCats = DB::table('course_categories')
                ->whereIn('rank', [5, 6, 7, 8])
                ->orderBy('rank')
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();
        @endphp

        @if($secondaryCats->count() > 0)
            <div class="row mt-5 pt-3">
                <div class="col-12 mb-4">
                    <h3 style="font-weight: 800; color: #0f172a; font-size: 24px;">Additional Programs</h3>
                </div>
                @foreach ($secondaryCats as $data)
                    @php
                        $cCount = $courseCounts[$data->id] ?? 0;
                    @endphp
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ route('cat', $data->id) }}" class="modern-cat-grid-card">
                            <div class="modern-cat-img-box" style="height: 130px;">
                                <img src="{{ asset($data->image) }}" alt="{{ $data->name }}" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/course-cat-default.jpg') }}';">
                            </div>
                            <h4 class="modern-cat-title">{{ $data->name }}</h4>
                            <span class="modern-cat-badge">
                                <i class="feather-book-open"></i> {{ $cCount }} Courses
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Other Special & Govt Exam Categories -->
        @php
            $otherCats = DB::table('course_categories')
                ->whereNotIn('rank', [1, 2, 3, 4, 5, 6, 7, 8])
                ->orderBy('rank')
                ->orderBy('id', 'desc')
                ->get();
        @endphp

        @if($otherCats->count() > 0)
            <div class="row mt-5 pt-3 border-top">
                <div class="col-12 text-center mb-5">
                    <span class="badge px-3 py-2 rounded-pill text-uppercase" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5; font-weight: 700; letter-spacing: 0.5px;">More Opportunities</span>
                    <h2 class="mt-2" style="font-weight: 800; color: #0f172a; font-size: 28px;">Other Govt & Competitive Jobs</h2>
                    <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 15px;">Discover specialized preparation courses targeting specific government departments.</p>
                </div>
                @foreach ($otherCats as $data)
                    @php
                        $cCount = $courseCounts[$data->id] ?? 0;
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ route('cat', $data->id) }}" class="modern-cat-grid-card">
                            <div class="modern-cat-img-box" style="height: 140px;">
                                <img src="{{ asset($data->image) }}" alt="{{ $data->name }}" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/course-cat-default.jpg') }}';">
                            </div>
                            <h4 class="modern-cat-title">{{ $data->name }}</h4>
                            <span class="modern-cat-badge">
                                <i class="feather-book-open"></i> {{ $cCount }} Courses
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
