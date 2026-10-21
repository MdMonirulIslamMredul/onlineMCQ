@extends('user.pages.test_master')

@push('test_style')
<style>
    .all-courses-hero {
        background: radial-gradient(circle at 10% 20%, rgba(3, 198, 187, 0.12) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(79, 70, 229, 0.12) 0%, transparent 40%),
                    linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 55px 0 65px;
        color: #ffffff;
        position: relative;
    }
    .modern-exam-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
        position: relative;
    }
    .modern-exam-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #03c6bb;
    }
    .modern-exam-thumb {
        width: 100%;
        height: 190px;
        overflow: hidden;
        position: relative;
        background: #f1f5f9;
    }
    .modern-exam-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .modern-exam-card:hover .modern-exam-thumb img {
        transform: scale(1.06);
    }
    .modern-exam-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .modern-exam-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.4;
        transition: color 0.2s ease;
    }
    .modern-exam-card:hover .modern-exam-title {
        color: #03c6bb;
    }
    .modern-exam-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #64748b;
    }
    .price-chip-free {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
    }
    .price-chip-paid {
        background: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
    }
    .filter-tab-pill {
        border-radius: 9999px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .filter-tab-pill.active,
    .filter-tab-pill:hover {
        background: #03c6bb;
        color: #ffffff;
        border-color: #03c6bb;
        box-shadow: 0 4px 12px rgba(3, 198, 187, 0.3);
    }
</style>
@endpush

@section('content')

@php
    $categories = DB::table('categories')
        ->leftJoin('exams', 'categories.id', '=', 'exams.catID')
        ->select(
            'categories.id',
            'categories.name',
            'categories.url',
            'categories.free_paid',
            'categories.tk',
            'categories.image',
            'categories.active',
            'categories.rank',
            DB::raw('COUNT(exams.id) as examCount')
        )
        ->where('exams.active', 1)
        ->groupBy(
            'categories.id',
            'categories.name',
            'categories.url',
            'categories.free_paid',
            'categories.tk',
            'categories.image',
            'categories.active',
            'categories.rank'
        )
        ->having('examCount', '>', 0)
        ->orderBy('categories.rank', 'asc')
        ->get();

    $courses = DB::table('courses')->where('active', 1)->orderBy('rank', 'asc')->get();
    $totalExams = DB::table('exams')->where('active', 1)->count();
    $totalQuestions = DB::table('mcq_questions')->count();
@endphp

<!-- Start Hero Banner -->
<div class="all-courses-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">All Examinations & Courses</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-check-circle"></i> Verified Bangladeshi Exam Syllabus
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 4vw, 42px);">
                    Examinations & Model Test Catalog
                </h1>
                <p class="student-hero-desc mb-0">
                    Participate in timed mock exams with instant negative-marking calculation, verified answer keys, and national merit rankings.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <div class="d-inline-flex flex-column align-items-lg-end align-items-start gap-2">
                    <span class="badge px-3 py-2 rounded-pill" style="background: rgba(3, 198, 187, 0.15); color: #03c6bb; font-weight: 700; font-size: 14px;">
                        <i class="feather-award me-1"></i> {{ $totalExams }} Active Live Exams
                    </span>
                    <span class="text-white-50" style="font-size: 13px;">
                        Over {{ $totalQuestions * 100 }}+ High-Yield Practice Questions
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<!-- Main Content Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">

        <!-- Navigation Filter Tabs -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5 pb-3 border-bottom">
            <div>
                <h2 style="font-weight: 800; color: #0f172a; font-size: clamp(22px, 3vw, 28px); margin: 0;">
                    Competitive Exam Categories
                </h2>
                <p class="text-muted mb-0" style="font-size: 14px;">Select your targeted recruitment exam to begin testing.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="#free-exams" class="filter-tab-pill">
                    <i class="feather-unlock text-success"></i> Free Model Tests
                </a>
                <a href="#paid-exams" class="filter-tab-pill">
                    <i class="feather-star text-warning"></i> Premium Programs
                </a>
                <a href="#online-courses" class="filter-tab-pill">
                    <i class="feather-video text-primary"></i> Video Courses
                </a>
            </div>
        </div>

        <!-- Section 1: Free Exams Grid -->
        <div id="free-exams" class="mb-5 pb-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 18px;">
                        <i class="feather-check"></i>
                    </div>
                    <div>
                        <h3 style="font-weight: 800; color: #0f172a; font-size: 22px; margin: 0;">Free Practice Model Exams</h3>
                        <span class="text-muted" style="font-size: 13px;">No subscription required - start test immediately</span>
                    </div>
                </div>
                <span class="badge px-3 py-1 rounded-pill bg-light text-muted border" style="font-size: 12px; font-weight: 600;">
                    {{ $categories->where('free_paid', 'free')->count() }} Categories
                </span>
            </div>

            <div class="row g-4">
                @forelse ($categories->where('free_paid', 'free') as $category)
                    @php
                        $catSlug = $category->url ?: str_replace(' ', '-', $category->name);
                    @endphp
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                        <div class="modern-exam-card">
                            <div class="modern-exam-thumb">
                                <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" onerror="this.onerror=null; this.src='{{ asset('images/bcs_prep.jpg') }}';">
                                </a>
                                <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill" style="background: rgba(16, 185, 129, 0.9); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 11px;">
                                    FREE ACCESS
                                </span>
                            </div>
                            <div class="modern-exam-body">
                                <div class="modern-exam-meta">
                                    <span><i class="feather-file-text me-1 text-primary" style="color: #03c6bb !important;"></i> {{ $category->examCount }} Mock Tests</span>
                                    <span><i class="feather-clock me-1 text-muted"></i> Real OMR Timer</span>
                                </div>
                                <h4 class="modern-exam-title">
                                    <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}" style="text-decoration: none; color: inherit;">
                                        {{ $category->name }}
                                    </a>
                                </h4>
                                <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                    <span class="price-chip-free">100% Free</span>
                                    <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                        <span class="btn-text">Start Exam</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-4 rounded-3 text-center bg-light text-muted">No free exams available at the moment.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section 2: Premium Programs Grid -->
        <div id="paid-exams" class="mb-5 pb-4 pt-3 border-top">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 18px;">
                        <i class="feather-award"></i>
                    </div>
                    <div>
                        <h3 style="font-weight: 800; color: #0f172a; font-size: 22px; margin: 0;">Specialized Career Programs</h3>
                        <span class="text-muted" style="font-size: 13px;">Full test series with dedicated question review & ranking</span>
                    </div>
                </div>
                <span class="badge px-3 py-1 rounded-pill bg-light text-muted border" style="font-size: 12px; font-weight: 600;">
                    {{ $categories->where('free_paid', 'paid')->count() }} Categories
                </span>
            </div>

            <div class="row g-4">
                @forelse ($categories->where('free_paid', 'paid') as $category)
                    @php
                        $catSlug = $category->url ?: str_replace(' ', '-', $category->name);
                    @endphp
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                        <div class="modern-exam-card">
                            <div class="modern-exam-thumb">
                                <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" onerror="this.onerror=null; this.src='{{ asset('images/bank_prep.jpg') }}';">
                                </a>
                                <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 rounded-pill" style="background: rgba(79, 70, 229, 0.9); backdrop-filter: blur(4px); color: #ffffff; font-weight: 700; font-size: 11px;">
                                    PREMIUM SERIES
                                </span>
                            </div>
                            <div class="modern-exam-body">
                                <div class="modern-exam-meta">
                                    <span><i class="feather-file-text me-1 text-primary" style="color: #03c6bb !important;"></i> {{ $category->examCount }} Mock Tests</span>
                                    <span><i class="feather-bar-chart-2 me-1 text-muted"></i> Merit Ranking</span>
                                </div>
                                <h4 class="modern-exam-title">
                                    <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}" style="text-decoration: none; color: inherit;">
                                        {{ $category->name }}
                                    </a>
                                </h4>
                                <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                    <span class="price-chip-paid">৳ {{ $category->tk ?: '500' }} / Program</span>
                                    <a href="{{ url('/category/' . $category->id . '/' . $catSlug) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                        <span class="btn-text">View Tests</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-4 rounded-3 text-center bg-light text-muted">No premium exam categories currently listed.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section 3: Online Video Courses Showcase -->
        @if($courses->count() > 0)
            <div id="online-courses" class="pt-4 border-top">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-size: 18px;">
                            <i class="feather-video"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 800; color: #0f172a; font-size: 22px; margin: 0;">Featured Online Video Courses</h3>
                            <span class="text-muted" style="font-size: 13px;">Complete syllabus video lessons by top cadre officers</span>
                        </div>
                    </div>
                    <a href="{{ route('course') }}" class="rbt-btn-link text-decoration-none" style="color: #03c6bb; font-weight: 700;">
                        View All Courses <i class="feather-arrow-right"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($courses as $course)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="modern-course-card h-100 d-flex flex-column">
                                <div class="modern-course-thumb">
                                    <a href="{{ route('course.detail', $course->id) }}">
                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" onerror="this.onerror=null; this.src='{{ asset('images/bcs_prep.jpg') }}';">
                                    </a>
                                    <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill" style="background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); color: #ffffff; font-size: 11px; font-weight: 600;">
                                        ৳ {{ $course->price }}
                                    </span>
                                </div>
                                <div class="modern-course-body d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center gap-3 text-muted mb-2" style="font-size: 12px; font-weight: 600;">
                                        <span><i class="feather-video me-1"></i> Live & Recorded</span>
                                        <span><i class="feather-file-text me-1"></i> Lecture PDF</span>
                                    </div>
                                    <h4 class="modern-course-title mb-2">
                                        <a href="{{ route('course.detail', $course->id) }}" style="text-decoration: none; color: inherit;">
                                            {{ $course->name }}
                                        </a>
                                    </h4>
                                    <p class="text-muted mb-4" style="font-size: 13px; line-height: 1.6; flex-grow: 1;">
                                        {{ Str::limit(strip_tags($course->description), 110) }}
                                    </p>
                                    <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                        <span style="font-size: 18px; font-weight: 800; color: #0f172a;">৳ {{ $course->price }}</span>
                                        <a href="{{ route('course.detail', $course->id) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                            <span class="btn-text">Enroll Course</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Student Advantage Highlight Grid -->
        <div class="mt-5 pt-4">
            <div class="p-4 p-md-5 rounded-4" style="background: linear-gradient(135deg, rgba(3, 198, 187, 0.06) 0%, rgba(79, 70, 229, 0.06) 100%); border: 1px solid rgba(3, 198, 187, 0.2);">
                <div class="row g-4 text-center">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="p-3">
                            <i class="feather-clock text-primary mb-2" style="font-size: 32px; color: #03c6bb !important;"></i>
                            <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;">Real-Time Countdown</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">Exact time limits and automatic submission simulating PSC examinations.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="p-3">
                            <i class="feather-check-circle text-success mb-2" style="font-size: 32px;"></i>
                            <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;">Detailed Explanations</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">Every question is backed by comprehensive Bengali solutions and notes.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="p-3">
                            <i class="feather-trending-up text-indigo mb-2" style="font-size: 32px; color: #4f46e5;"></i>
                            <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;">Instant Merit Ranking</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">Evaluate your position across thousands of active job candidates nationwide.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="p-3">
                            <i class="feather-smartphone text-warning mb-2" style="font-size: 32px;"></i>
                            <h5 style="font-weight: 700; color: #0f172a; font-size: 16px;">Mobile Friendly</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">Practice anywhere from your mobile device with zero latency or lag.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
