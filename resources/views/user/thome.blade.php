@extends('user.pages.test_master')
@push('test_style')
    <style>
        /* Card Container */
        .mainmenu li {
            margin: 0 10px;
        }

        .rbt-header .mainmenu-nav .mainmenu>li>a {
            font-weight: 600;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            margin: 15px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Rounded Image Styling */
        .instructor_thumb {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .instructor_thumb img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            /* Makes the image round */
            object-fit: cover;
            /* Ensures the image covers the container without distortion */
            border: 3px solid #03c6bb;
            /* Optional: add a border to enhance the image outline */
        }

        .instructor_caption {
            padding: 15px;
            text-align: center;
        }

        .instructor_caption h4 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 5px;
        }

        .instructor_caption span {
            display: block;
            font-size: 16px;
            color: #777;
            margin-bottom: 10px;
        }

        .instructor_caption ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .instructor_caption ul li {
            font-size: 16px;
            color: #555;
        }
        .rbt-btn.btn-border {
            background: #03c6bb;
            /* border: 2px solid var(--color-border);
            color: var(--color-heading);
            line-height: 57px; */
        }
    </style>
@endpush
@section('content')
    @php

        $home_banners = DB::table('slider_banners')->where('active', 1)->orderBy('id', 'asc')->get();
        if ($home_banners->isEmpty()) {
            $home_banners = collect([
                (object)[
                    'title' => 'বিসিএস ও সরকারি চাকরি নিশ্চিত প্রস্তুতি',
                    'alt' => 'Explore interactive online courses, take real-time timed model tests, and earn industry-recognized credentials with expert mentors.',
                    'image' => 'images/bcs_prep.jpg',
                ]
            ]);
        }
        // $categories = DB::table('categories')->where('active', 1)->get();
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
                'categories.created_at',
                'categories.updated_at',
                DB::raw('COUNT(exams.id) as examCount'),
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
                'categories.rank',
                'categories.created_at',
                'categories.updated_at',
            )
            ->having('examCount', '>', 0)// must have at least 1 exam
            ->whereIn('categories.rank', [1, 2, 3, 4]) // Filter by specific ranks
            ->orderBy('categories.rank') // Order by rank
            ->limit(4)
            ->get();

        $courses = DB::table('courses')->where('active', 1)->get();
        $blogs = DB::table('blogs')->orderBy('id', 'desc')->limit(3)->get();
        $teachers = DB::table('teachers')->where('active', 1)->orderBy('id', 'asc')->limit(6)->get();
        $about_info = DB::table('about_infos')->first();
        $freeExams = DB::table('exams')->where('free_paid', 'free')->where('active', 1)->limit(8)->get();
    @endphp
    <style>
        .hero-slider-wrapper {
            position: relative;
            overflow: hidden;
            background: #0f172a;
        }
        .hero-banner-swiper {
            width: 100%;
            position: relative;
        }
        .hero-slide-item {
            position: relative;
            min-height: 520px;
            display: flex;
            align-items: center;
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            padding: 85px 0 95px;
        }
        .hero-slide-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 30%, rgba(3, 198, 187, 0.12) 0%, transparent 60%);
            pointer-events: none;
            z-index: 1;
        }
        .hero-slide-item .container {
            position: relative;
            z-index: 2;
        }
        .hero-slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
            z-index: 15;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            padding: 0;
        }
        .hero-slider-nav:hover {
            background: #03c6bb;
            border-color: #03c6bb;
            color: #ffffff;
            transform: translateY(-50%) scale(1.08);
        }
        .hero-slider-prev {
            left: 25px;
        }
        .hero-slider-next {
            right: 25px;
        }
        .hero-swiper-pagination {
            position: absolute;
            bottom: 25px !important;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 15;
        }
        .hero-swiper-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            margin: 0 5px !important;
            background: rgba(255, 255, 255, 0.45);
            opacity: 1;
            border-radius: 9999px;
            transition: all 0.35s ease;
            display: inline-block;
            cursor: pointer;
        }
        .hero-swiper-pagination .swiper-pagination-bullet-active {
            width: 32px;
            background: #03c6bb !important;
            box-shadow: 0 0 12px rgba(3, 198, 187, 0.6);
        }
        @media (max-width: 768px) {
            .hero-slide-item {
                min-height: 440px;
                padding: 55px 0 70px;
            }
            .hero-slider-nav {
                display: none !important;
            }
        }
        .cat-card-img-wrap {
            position: relative;
            height: 180px;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 12px;
        }
        .cat-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .rbt-cat-box:hover .cat-card-img-wrap img {
            transform: scale(1.08);
        }
    </style>
    <!-- Start Banner Area -->
    <div class="hero-slider-wrapper">
        <div class="hero-banner-swiper swiper">
            <div class="swiper-wrapper">
                @foreach ($home_banners as $banner)
                    <div class="swiper-slide">
                        <div class="hero-slide-item student-hero"
                            style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.94) 0%, rgba(15, 23, 42, 0.82) 55%, rgba(15, 23, 42, 0.48) 100%), url('{{ asset($banner->image) }}') center/cover no-repeat;">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-md-12">
                                        <div class="inner text-start">
                                            <div class="student-hero-badge">
                                                <i class="feather-award"></i> 100% Practical Student Learning
                                            </div>
                                            <h1 class="student-hero-title">
                                                {{ $banner->title ?? 'Master In-Demand Skills & Boost Your Career' }}
                                            </h1>
                                            <p class="student-hero-desc">
                                                {{ $banner->alt ?? 'Explore interactive online courses, take real-time timed model tests, and earn industry-recognized credentials with expert mentors.' }}
                                            </p>
                                            <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                                                <a class="rbt-btn btn-gradient icon-hover radius-round" href="{{ route('course') }}">
                                                    <span class="btn-text">Explore Courses</span>
                                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </a>
                                                <a class="rbt-btn btn-white icon-hover radius-round" href="{{ route('all.courses') }}">
                                                    <span class="btn-text">Take Practice Exam</span>
                                                    <span class="btn-icon"><i class="feather-check-circle"></i></span>
                                                </a>
                                            </div>

                                            <!-- Hero Stats Bar -->
                                            <div class="hero-stats-wrapper">
                                                <div class="hero-stat-item">
                                                    <div class="hero-stat-icon"><i class="feather-users"></i></div>
                                                    <div>
                                                        <div class="hero-stat-num">{{ optional($company_info)->count1 ?? '500' }}+</div>
                                                        <div class="hero-stat-label">Active Learners</div>
                                                    </div>
                                                </div>
                                                <div class="hero-stat-item">
                                                    <div class="hero-stat-icon"><i class="feather-book-open"></i></div>
                                                    <div>
                                                        <div class="hero-stat-num">{{ optional($company_info)->count2 ?? '20' }}+</div>
                                                        <div class="hero-stat-label">Model Tests & Courses</div>
                                                    </div>
                                                </div>
                                                <div class="hero-stat-item">
                                                    <div class="hero-stat-icon"><i class="feather-award"></i></div>
                                                    <div>
                                                        <div class="hero-stat-num">98%</div>
                                                        <div class="hero-stat-label">Student Success Rate</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($home_banners->count() > 1)
                <!-- Navigation Controls -->
                <button type="button" class="hero-slider-nav hero-slider-prev" aria-label="Previous Banner">
                    <i class="feather-chevron-left"></i>
                </button>
                <button type="button" class="hero-slider-nav hero-slider-next" aria-label="Next Banner">
                    <i class="feather-chevron-right"></i>
                </button>

                <!-- Pagination Dots -->
                <div class="hero-swiper-pagination"></div>
            @endif
        </div>
    </div>
    <!-- End Banner Area -->

    <!-- Start Category / Exam Area  -->
    <div class="rbt-category-area rbt-section-gapTop pb--60 bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Exam Preparation Portal</span>
                        <h2 class="title mt--10">Check Your Preparation <br /> <span style="color: #03c6bb">Give an Online EXAM</span></h2>
                        <p class="section-subtext mt--10" style="width: 100% !important; max-width: 680px !important; margin: 12px auto 0 !important; padding: 0 !important; color: #64748b; font-size: 16px; line-height: 1.7; display: block !important;">
                            Test your knowledge with real-time timed mock exams, instant answer evaluation, and detailed explanations.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt--20">
                @foreach ($categories as $category)
                    @php
                        $url = str_replace(' ', '-', $category->name);
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a class="modern-category-card" href="{{ url('/category/' . $category->id . '/' . $url) }}">
                            <div class="modern-category-img-wrap">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                            </div>
                            <h5 class="modern-category-title">{{ $category->name }}</h5>
                            <div class="modern-category-meta">
                                <span class="modern-category-badge">
                                    <i class="feather-file-text"></i> {{ $category->examCount }} Exams
                                </span>
                                <span style="color: #03c6bb; font-weight: 600; font-size: 14px;">
                                    Start <i class="feather-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row pt-5 text-center">
                <div class="col-12">
                    <a class="rbt-btn btn-border-gradient icon-hover radius-round" href="{{ route('all.courses') }}">
                        <span class="btn-text">Browse All Examinations</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <style>
        .slick-slider .slick-slide {
            margin: 0 12px;
        }

        .rbt-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        }

        .rbt-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

        }

        /* Style the slick dots container */
        /* Add the custom CSS here */
        .slick-dots li {
            margin: 0 5px;
            width: 28px !important;
            height: 0;
        }

        .slick-dots li button {
            border: none;
            background-color: #d3dce6;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            padding: 0;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s, width 0.3s, height 0.3s, border-radius 0.3s;
            position: relative;
        }

        .slick-dots li button::before {
            content: "";
            display: none;
        }

        .slick-dots li.slick-active button {
            background-color: #03CCC0;
            width: 28px;
            height: 12px;
            border-radius: 12px;
        }

        /* .rbt-card-img img {
                            width: 100%;
                            height: auto;
                        }
                        .rbt-card-body {
                            padding: 20px;
                        }
                        .rbt-card-title a {
                            text-decoration: none;
                            color: #333;
                            font-size: 18px;
                            font-weight: 600;
                        }
                        .rbt-meta {
                            list-style: none;
                            padding: 0;
                            margin: 10px 0 20px;
                            display: flex;
                            justify-content: space-between;
                        }
                        .rbt-meta li {
                            font-size: 14px;
                            color: #777;
                        }
                        .rbt-price {
                            font-size: 16px;
                            color: #333;
                        }
                        .current-price {
                            font-weight: 700;
                        }
                        .off-price {
                            text-decoration: line-through;
                            color: #999;
                            margin-left: 10px;
                        }
                        .rbt-btn-link {
                            display: inline-block;
                            margin-top: 10px;
                            text-decoration: none;
                            color: #007bff;
                            font-weight: 600;
                        } */
    </style>
    <!-- Start Course Area  -->
    <div class="rbt-course-area bg-color-extra2 rbt-section-gap bg-gradient-9">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-secondary-opacity">Courses</span>
                        <h2 class="title"> All Courses</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <ul class="rbt-portfolio-filter filter-tab-button text-center nav nav-tabs" id="rbt-myTab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                                role="tab" aria-controls="all" aria-selected="true">
                                <span class="filter-text">All Courses</span>
                                <span class="course-number">{{ str_pad($courses->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            </button>
                        </li>

                        @php
                            // Fetch the categories with rank and course counts
                            $categories = DB::table('course_categories')
                                ->whereIn('rank', [1, 2, 3, 4])
                                ->orderBy('rank')
                                ->get();

                            $courseCounts = $courses->groupBy('catID')->map->count();
                        @endphp

                        @foreach ($categories as $category)
                            @php
                                // Count courses for this category
                                $categoryCourseCount = $courseCounts[$category->id] ?? 0;
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button id="category-tab-{{ $loop->iteration }}" data-bs-toggle="tab"
                                    data-bs-target="#category{{ $loop->iteration }}" type="button" role="tab"
                                    aria-controls="category{{ $loop->iteration }}" aria-selected="false">
                                    <span class="filter-text">{{ $category->name }}</span>
                                    <span
                                        class="course-number">{{ str_pad($categoryCourseCount, 2, '0', STR_PAD_LEFT) }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Start Card Area -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content mt--60" id="rbt-myTabContent">

                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <div class="row g-4 slick-slider">
                                @foreach ($courses as $course)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="modern-course-card">
                                            <div class="modern-course-thumb">
                                                <a href="{{ url('/course/' . $course->id) }}">
                                                    <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" loading="lazy">
                                                </a>
                                                <span class="modern-course-badge-top">
                                                    <i class="feather-award"></i> Certified
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
                                @endforeach
                            </div>
                        </div>

                        @foreach ($categories as $index => $category)
                            <div class="tab-pane fade" id="category{{ $index + 1 }}" role="tabpanel"
                                aria-labelledby="category-tab-{{ $index + 1 }}">
                                <div class="row g-4">
                                    @foreach ($courses->where('catID', $category->id) as $course)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="modern-course-card">
                                                <div class="modern-course-thumb">
                                                    <a href="{{ url('/course/' . $course->id) }}">
                                                        <img src="{{ asset($course->image) }}" alt="{{ $course->name }}" loading="lazy">
                                                    </a>
                                                    <span class="modern-course-badge-top">
                                                        <i class="feather-award"></i> {{ $category->name }}
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
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Course Area  -->
    <!-- End category Area  -->
    <!-- Start Advance Tab  -->
    <style>
        .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 300px;
            border-radius: 12px;
        }
        @media only screen and (min-width: 1100px) {
            .carousel-item img {
                height: 520px;
                min-height: 520px;
            }
        }
    </style>
    @php
        $slide_data = DB::table('slider_infos')
            ->join('slider_images', 'slider_infos.id', '=', 'slider_images.slider_info_id')
            ->select(
                'slider_infos.id as slider_info_id',
                'slider_infos.title',
                'slider_infos.description',
                'slider_images.image',
            )
            ->get();
        $slide_img = \App\Models\SliderInfo::with('images')->get();
    @endphp
    {{-- {{ dd($slide_img) }} --}}
    <div class="rbt-advance-tab-area rbt-section-gapTop rbt-section-gapBottom bg-color-white">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        {{-- <h2 class="title">About Us.</h2> --}}
                        {{-- <p class="description mt--30">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p> --}}
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12 mt_md--30 mt_sm--30 order-2 order-lg-1">
                    <div class="advance-tab-button advance-tab-button-1">
                        <ul class="nav nav-tabs tab-button-list" id="aboutmyTab" role="tablist">
                            @foreach ($slide_data->unique('slider_info_id')->take(3) as $info)
                                <li class="nav-item" role="presentation">
                                    <a href="#" class="nav-link tab-button {{ $loop->first ? 'active' : '' }}"
                                        id="tab{{ $info->slider_info_id }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#tab5{{ $info->slider_info_id }}" role="tab"
                                        aria-controls="tab{{ $info->slider_info_id }}" aria-selected="true">
                                        <div class="tab">
                                            <h4 class="title">{{ $info->title }}.</h4>
                                            <p class="description">{{ $info->description }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 order-1 order-lg-2">
                    <div class="tab-content">
                        @foreach ($slide_img as $info)
                            <div class="tab-pane fade advance-tab-content-1 {{ $loop->first ? 'active show' : '' }}"
                                id="tab5{{ $info->id }}" role="tabpanel"
                                aria-labelledby="tab{{ $info->id }}-tab">
                                <div id="carouselExampleCrossfade{{ $info->id }}"
                                    class="carousel slide carousel-fade" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach ($info->images as $index => $image)
                                            <button type="button"
                                                data-bs-target="#carouselExampleCrossfade{{ $info->id }}"
                                                data-bs-slide-to="{{ $index }}"
                                                class="{{ $index == 0 ? 'active' : '' }}"
                                                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach ($info->images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image) }}" class="d-block w-100"
                                                    alt="{{ $info->title }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleCrossfade{{ $info->id }}"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleCrossfade{{ $info->id }}"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Advance Tab  -->
    @php
        $subscriptions = DB::table('subscriptions')->orderBy('id', 'asc')->take(3)->get();
    @endphp
    <!-- Start pricing Area  -->
    <div class="rbt-pricing-area bg-color-white rbt-section-gap">
        {{-- <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-primary-opacity">COURSE PRICING</span>
                        <h2 class="title">Style One</h2>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="pricing-billing-duration text-start text-md-end">
                        <ul>
                            <li class="nav-item">
                                <button class="nav-link yearly-plan-btn" type="button" name="plan_type"
                                    value="yearly">Yearly Plan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link monthly-plan-btn active" type="button" name="plan_type"
                                    value="monthly">Monthly Plan</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row g-5">
                    @foreach ($subscriptions as $subscription)
                        <!-- Start Single Pricing  -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                            <div class="pricing-table {{ $subscription->is_popular ? 'active' : '' }}">
                                <div class="pricing-header">
                                    <h3 class="title">{{ $subscription->name }}</h3>
                                    <span class="rbt-badge mb--35">{{ $subscription->description }}</span>
                                    <div class="price-wrap">
                                        <div class="yearly-pricing" style="display: none;">
                                            <span class="amount">৳
                                                {{ number_format($subscription->yearly_price, 2) }}</span>
                                            <span class="duration">/yearly</span>
                                        </div>
                                        <div class="monthly-pricing" style="display: block;">
                                            <span class="amount">৳
                                                {{ number_format($subscription->monthly_price, 2) }}</span>
                                            <span class="duration">/monthly</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pricing-body">
                                    <ul class="list-item">
                                        <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                        <li
                                            class="{{ $subscription->name == 'Basic Plan' ? '' : ($subscription->name == 'Standard Plan' || $subscription->name == 'Exclusive Plan' ? '' : 'off') }}">
                                            <i class="feather-check"></i> Certificate After Completion
                                        </li>
                                        <li
                                            class="{{ $subscription->name == 'Standard Plan' || $subscription->name == 'Exclusive Plan' ? '' : 'off' }}">
                                            <i class="feather-check"></i> High Resolution Videos
                                        </li>
                                        <li class="{{ $subscription->name == 'Exclusive Plan' ? '' : 'off' }}">
                                            <i class="feather-check"></i> 24/7 Dedicated Support
                                        </li>
                                    </ul>
                                </div>
                                <form method="get" action="{{ route('subscription.checkout') }}" id="buy1Form">
                                    <input type="hidden" name="productID" value="{{ $subscription->id }}">
                                    <input type="hidden" name="plan_type" id="plan_type_{{ $subscription->id }}"
                                        value="monthly">
                                    <div class="pricing-btn">
                                        <a class="rbt-btn {{ $subscription->is_popular ? 'hover-icon-reverse' : 'bg-primary-opacity hover-icon-reverse' }} w-100"
                                            href=""
                                            onclick="event.preventDefault(); document.getElementById('buy1Form').submit()">
                                            <div class="icon-reverse-wrapper">
                                                <span class="btn-text">Buy Plan</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </div>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Single Pricing  -->
                    @endforeach
                </div>
            </div>
        </div> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearlyPlanBtn = document.querySelector('.yearly-plan-btn');
                const monthlyPlanBtn = document.querySelector('.monthly-plan-btn');
                const planTypeInput = document.getElementById('plan_type');

                yearlyPlanBtn.addEventListener('click', function() {
                    document.querySelectorAll('.yearly-pricing').forEach(el => el.style.display = 'block');
                    document.querySelectorAll('.monthly-pricing').forEach(el => el.style.display = 'none');
                    yearlyPlanBtn.classList.add('active');
                    monthlyPlanBtn.classList.remove('active');
                    planTypeInput.value = 'yearly';
                });

                monthlyPlanBtn.addEventListener('click', function() {
                    document.querySelectorAll('.yearly-pricing').forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.monthly-pricing').forEach(el => el.style.display = 'block');
                    monthlyPlanBtn.classList.add('active');
                    yearlyPlanBtn.classList.remove('active');
                    planTypeInput.value = 'monthly';
                });
            });
        </script>
        <!-- End pricing Area  -->
        {{-- <script>
    document.querySelector('.yearly-plan-btn').addEventListener('click', function() {
        document.querySelectorAll('.yearly-pricing').forEach(function(el) {
            el.style.display = 'block';
        });
        document.querySelectorAll('.monthly-pricing').forEach(function(el) {
            el.style.display = 'none';
        });
    });

    document.querySelector('.monthly-plan-btn').addEventListener('click', function() {
        document.querySelectorAll('.monthly-pricing').forEach(function(el) {
            el.style.display = 'block';
        });
        document.querySelectorAll('.yearly-pricing').forEach(function(el) {
            el.style.display = 'none';
        });
    });
</script> --}}


        <!-- Start About Area  -->
        <div class="rbt-video-area rbt-section-gapBottom pt--50 bg-color-white">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 order-1 order-lg-1">
                        <div class="video-popup-wrapper">
                            <img class="w-100 rbt-radius" src="{{ asset($about_info->image) }}" alt="Video Images">
                            <a class="popup-video position-to-top" href="https://www.youtube.com/watch?v=nA1Aqp0sPQo">
                                <span><img src="{{ asset('/') }}frontend/assets/images/icons/youtube.png"
                                        alt=""></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-2 order-lg-2">
                        <div class="inner pr--50">
                            <div class="section-title text-start">
                                <span class="subtitle bg-primary-opacity">About Us</span>
                                <p class="description mt--30">
                                    {!! $about_info->aboutDes !!}</p>
                                <div class="read-more-btn">
                                    <a class="rbt-moderbt-btn" href="{{ route('user.about_us') }}">
                                        <span class="moderbt-btn-text">Learn More About Us</span>
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End About Area  -->

        <section class="bg-color-extra2" style="padding: 100px 0;">
            <div class="container">
                <div class="row f-flex justify-content-center">
                    <div class="col-lg-7 col-md-9 col-sm-12">
                        <div class="sec-heading text-center mb--40">
                            <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 12px; border-radius: 9999px;">Expert Guidance</span>
                            <h2 class="mt--10">Meet Our Expert<span style="color: #03c6bb"> Mentors</span></h2>
                            <p style="color: #64748b; font-size: 15px;">Learn and prepare under the mentorship of top industry leaders and certified educators.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="slick-slider1">
                            @foreach ($teachers as $teacher)
                                <div class="four_slide-dots articles arrow_middle swiper-slide">
                                    <div class="singles_items card border-0 single-slide p-4 shadow-sm rounded-4 text-center h-100" style="background: #ffffff; border: 1px solid #e2e8f0 !important; transition: transform 0.25s ease;">
                                        <div class="instructor_wrap">
                                            <div class="instructor_thumb py-2">
                                                <a href="javascript: void(0)">
                                                    <img src="{{ asset($teacher->image) }}" class="img-fluid" alt="{{ $teacher->name }}" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50%; border: 3px solid #03c6bb; box-shadow: 0 6px 15px rgba(3, 198, 187, 0.2);">
                                                </a>
                                            </div>
                                            <div class="instructor_caption mt-2">
                                                <h4 style="font-size: 20px; font-weight: 700; margin-bottom: 6px;"><a
                                                        href="javascript: void(0)">{{ $teacher->name }}</a></h4>
                                                <span style="color: #03c6bb; font-weight: 600; font-size: 14px;">{{ $teacher->subject }}</span>
                                                <div class="mt-2 text-muted" style="font-size: 13px;">{{ $teacher->job_title }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>
        </section>


        <!-- Start Student Advantage / Why Choose Us Section -->
        <div class="rbt-service-area bg-color-white rbt-section-gap">
            <div class="container">
                <div class="row mb--50">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">The Student Advantage</span>
                            <h2 class="title mt--10">Why Thousands of Students <br /><span style="color: #03c6bb">Choose Pathjolpona</span></h2>
                            <p class="section-subtext mt--10" style="width: 100% !important; max-width: 680px !important; margin: 12px auto 0 !important; padding: 0 !important; color: #64748b; font-size: 16px; line-height: 1.7; display: block !important;">
                                Designed specifically for ambitious students aiming for academic brilliance and practical competitive success.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="p-4 text-center rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 65px; height: 65px; background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-size: 28px;">
                                <i class="feather-clock"></i>
                            </div>
                            <h5 style="font-weight: 700; margin-bottom: 10px;">Timed Mock Exams</h5>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Simulate actual competitive exam pressure with real-time countdown timer and auto-submit features.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="p-4 text-center rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 65px; height: 65px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 28px;">
                                <i class="feather-check-circle"></i>
                            </div>
                            <h5 style="font-weight: 700; margin-bottom: 10px;">Instant Explanations</h5>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Get immediate answer keys with comprehensive solution breakdowns to master tricky question types.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="p-4 text-center rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 65px; height: 65px; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 28px;">
                                <i class="feather-award"></i>
                            </div>
                            <h5 style="font-weight: 700; margin-bottom: 10px;">Verified Certificates</h5>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Earn industry and institution ready certificates upon completion to showcase your accomplishments.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="p-4 text-center rounded-4 h-100 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 65px; height: 65px; background: rgba(245, 158, 11, 0.12); color: #f59e0b; font-size: 28px;">
                                <i class="feather-smartphone"></i>
                            </div>
                            <h5 style="font-weight: 700; margin-bottom: 10px;">100% Mobile Friendly</h5>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Study anytime, anywhere on smartphones, tablets, or laptops with seamless speed and low data usage.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Student Advantage Section -->

        <!-- Start Feedback Area  -->
        @php
            $infos = DB::table('testimonials')->get();
        @endphp
        {{-- {{ dd($data) }} --}}
        <div class="rbt-testimonial-area rbt-section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb--60">
                        <div class="section-title text-center">
                            <span class="subtitle bg-primary-opacity" style="color: #03c6bb; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Student Testimonials</span>
                            <h2 class="title mt--10">What Our <span style="color: #03c6bb">Students Say</span></h2>
                            <p class="section-subtext mt--10" style="width: 100% !important; max-width: 680px !important; margin: 12px auto 0 !important; padding: 0 !important; color: #64748b; font-size: 16px; line-height: 1.7; display: block !important;">
                                Real feedback and success stories from candidates preparing for BCS, Primary Teacher, and Govt recruitment with Pathjolpona.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item-3-activation swiper rbt-arrow-between gutter-swiper-30">
                    <div class="swiper-wrapper">
                        @foreach ($infos as $info)
                            <!-- Start Single Testimonial  -->
                            <div class="swiper-slide">
                                <div class="single-slide">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner bg-no-shadow bg-color-primary-opacity">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset($info->image) }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">{{ $info->name }}</h5>
                                                    <span>{{ $info->designation }}</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">{{ $info->description }}</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->
                        @endforeach


                    </div>

                    <div class="rbt-swiper-arrow rbt-arrow-left">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-left"></i>
                            <i class="rbt-icon-top feather-arrow-left"></i>
                        </div>
                    </div>

                    <div class="rbt-swiper-arrow rbt-arrow-right">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-right"></i>
                            <i class="rbt-icon-top feather-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Feedback Area  -->


        <!-- Start Blog Style -->
        <div class="rbt-rbt-blog-area rbt-section-gapTop bg-gradient-8 rbt-round-bottom-shape">
            <div class="wrapper pb--50 rbt-index-upper">
                <div class="container">
                    <div class="row g-5 align-items-end mb--60">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="section-title text-start">
                                <h2 class="title color-white">Latest News & Jobs</h2>
                                {{-- <p class="description color-white-off mt--20">Learning communicate to global world and build a bright future and career development, increase your skill with our histudy.</p> --}}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="load-more-btn text-start text-lg-end">
                                <a class="rbt-btn btn-border icon-hover radius-round color-white-off"
                                    href="{{ route('user.blog') }}">
                                    <span class="btn-text">See All</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card Area -->
                    <div class="row g-5">
                        @foreach ($blogs as $blog)
                            <!-- Start Single Card  -->
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="rbt-card variation-02 rbt-hover">
                                    <div class="rbt-card-img">
                                        <a href="{{ url('/blog/' . $blog->id . '/' . $blog->url) }}">
                                            <img src="{{ asset($blog->image) }}" alt="Card image"> </a>
                                    </div>
                                    <div class="rbt-card-body">
                                        <ul class="meta-list justify-content-start mb--30">
                                            <li class="list-item">
                                                <i class="feather-clock"></i>
                                                <span>{{ date('d M, Y', strtotime($blog->date)) }}</span>
                                            </li>
                                        </ul>
                                        <h5 class="rbt-card-title"><a
                                                href="{{ url('/blog/' . $blog->id . '/' . $blog->url) }}">{{ $blog->title }}</a>
                                        </h5>
                                        <p class="rbt-card-text">{{ substr(strip_tags($blog->description ?? ''), 0, 150) }}....
                                        </p>
                                        <div class="rbt-card-bottom">
                                            <a class="transparent-button"
                                                href="{{ url('/blog/' . $blog->id . '/' . $blog->url) }}">Learn
                                                More<i><svg width="17" height="12"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                            <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                            <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                                        </g>
                                                    </svg></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Card  -->
                        @endforeach
                    </div>
                    <!-- End Card Area -->
                </div>
            </div>
        </div>
        <!-- End Blog Style -->

        <!-- Start CallTo Action Area  -->
        <style>
            .card {
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease-in-out;
            }

            .card:hover {
                transform: translateY(-10px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            }

            .bg-custom {
                background: transparent;
                color: #fff;
                border: none;
                transition: background 0.3s ease-in-out;
            }

            .bg-custom:hover {
                transition: all 0.3s ease-in-out;
            }

            .content {
                padding: 20px;
                /* text-align: center; */
            }
        </style>
        <div class="rbt-call-to-action-area rbt-section-gap bg-gradient-6 rbt-call-to-action-5">
            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="rbt-cta-5">
                                <div class="content">
                                    <h3 class="title">Contact Us.</h3>
                                    <div class="rbt-button-group justify-content-center">
                                        <div>
                                            <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                                                {{-- <h3 class="title">Get a Free Course You Can Contact With Me</h3> --}}
                                                <form method="POST" action="{{ route('contact.form') }}"
                                                    class=" max-width-auto">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input name="name" id="contact-name" type="text">
                                                        <label>Name</label>
                                                        <span class="focus-border"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="phone" type="number">
                                                        <label>Contact Number</label>
                                                        <span class="focus-border"></span>
                                                    </div>


                                                    <div class="form-submit-group">
                                                        <button type="submit"
                                                            class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                                            <span class="icon-reverse-wrapper">
                                                                <span class="btn-text">SUBMIT NOW</span>
                                                                <span class="btn-icon"><i
                                                                        class="feather-arrow-right"></i></span>
                                                                <span class="btn-icon"><i
                                                                        class="feather-arrow-right"></i></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- <a class="rbt-btn btn-gradient" href="tel:{{  optional($company_info)->phone_1  }}">Call Us</a> --}}
                                        {{-- <a class="rbt-btn btn-border" href="#">See Features</a> --}}
                                    </div>

                                    <ul class="social-icon social-default with-gradient justify-content-center mt--20">
                                        <li><a href="{{ optional($company_info)->facebook }}">
                                                <i class="feather-facebook"></i>
                                            </a>
                                        </li>
                                        <li><a href="{{ optional($company_info)->twitter }}">
                                                <i class="feather-twitter"></i>
                                            </a>
                                        </li>
                                        <li><a href="{{ optional($company_info)->instagram }}">
                                                <i class="feather-instagram"></i>
                                            </a>
                                        </li>
                                        <li><a href="{{ optional($company_info)->youtube }}">
                                                <i class="feather-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card bg-custom">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content">
                                            <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
                                            <div class="elfsight-app-aa1b4da3-ba95-40b8-8895-b79af06c5831"
                                                data-elfsight-app-lazy></div>
                                        </div>
                                        {{-- https://youtube.com/playlist?list=PL8FOWQnk4TXT7mzb0WdRksUB05mdqPbeG&si=-Lpd3-0AeJc8uGzh --}}

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card bg-custom mt-5">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="content">
                                    <h3 class="">Facebook Group</h3>
                                    {{-- <p>Includes all Course && Features</p> --}}
                            {{-- <div class="rbt-button-group justify-content-start">
                                        <a class="rbt-btn btn-gradient" href="#">Get Bundle</a> --}}
                            {{-- <a class="rbt-btn btn-border" href="#">See Features</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-images">
                <img src="{{ asset('/') }}frontend/assets/images/icons/three-shape.png" alt="Shape Images">
            </div>
        </div>
        <!-- End CallTo Action Area  -->
    @endsection

@push('frontend_script')
<script>
    function initHeroSlider() {
        var bannerCount = {{ $home_banners->count() }};
        if (bannerCount > 1 && typeof Swiper !== 'undefined') {
            var heroSwiper = new Swiper('.hero-banner-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                speed: 900,
                autoplay: {
                    delay: 5000, // Automatically transitions every 5 seconds
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.hero-swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.hero-slider-next',
                    prevEl: '.hero-slider-prev',
                },
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroSlider);
    } else {
        initHeroSlider();
    }
</script>
@endpush
