@extends('user.pages.test_master')
@section('content')

<!-- Start Hero / Breadcrumb Area -->
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
                        <li style="color: #03c6bb; font-weight: 600;">{{ $courseInfo->name }}</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-award"></i> Verified Curriculum
                </div>
                <h1 class="student-hero-title mb-3" style="font-size: clamp(26px, 3.5vw, 40px);">
                    {{ $courseInfo->name }}
                </h1>
                <div class="d-flex flex-wrap align-items-center gap-4 text-white-50" style="font-size: 14px;">
                    <span><i class="feather-book-open text-primary me-1"></i> Interactive Curriculum</span>
                    <span><i class="feather-users text-primary me-1"></i> 50+ Active Students</span>
                    <span><i class="feather-clock text-primary me-1"></i> Self-Paced Learning</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

                    {{-- <div class="d-flex align-items-center mb--20 flex-wrap rbt-course-details-feature">

                        <div class="feature-sin best-seller-badge">
                            <span class="rbt-badge-2">
                                <span class="image"><img src="{{asset('/')}}frontend/assets/images/icons/card-icon-1.png"
                                        alt="Best Seller Icon"></span> Bestseller
                            </span>
                        </div>

                        <div class="feature-sin rating">
                            <a href="#">4.8</a>
                            <a href="#"><i class="fa fa-star"></i></a>
                            <a href="#"><i class="fa fa-star"></i></a>
                            <a href="#"><i class="fa fa-star"></i></a>
                            <a href="#"><i class="fa fa-star"></i></a>
                            <a href="#"><i class="fa fa-star"></i></a>
                        </div>

                        <div class="feature-sin total-rating">
                            <a class="rbt-badge-4" href="#">215,475 rating</a>
                        </div>

                        <div class="feature-sin total-student">
                            <span>616,029 students</span>
                        </div>

                    </div>

                    <div class="rbt-author-meta mb--20">
                        <div class="rbt-avater">
                            <a href="#">
                                <img src="{{asset('/')}}frontend/assets/images/client/avatar-02.png" alt="Sophia Jaymes">
                            </a>
                        </div>
                        <div class="rbt-author-info">
                            By <a href="profile.html">Angela</a> In <a href="#">Development</a>
                        </div>
                    </div>

                    <ul class="rbt-meta">
                        <li><i class="feather-calendar"></i>Last updated 12/2024</li>
                        <li><i class="feather-globe"></i>English</li>
                        <li><i class="feather-award"></i>Certified Course</li>
                    </ul> --}}

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->

<div class="rbt-course-details-area ptb--60">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-8">
                <div class="course-details-content">
                    <div class="rbt-course-feature-box rbt-shadow-box thuumbnail">
                        <img class="w-100" src="{{asset($courseInfo->image)}}" alt="{{ $courseInfo->name }}" style="max-height: 420px; object-fit: cover; border-radius: 12px;">
                    </div>

                    <div class="rbt-inner-onepage-navigation sticky-top mt--30">
                        <nav class="mainmenu-nav onepagenav">
                            <ul class="mainmenu">
                                <li class="current">
                                    <a href="#overview">Overview</a>
                                </li>
                                <li>
                                    <a href="#coursecontent">Course Content</a>
                                </li>
                                {{-- <li>
                                    <a href="#details">Details</a>
                                </li>
                                <li>
                                    <a href="#intructor">Intructor</a>
                                </li>
                                <li>
                                    <a href="#review">Review</a>
                                </li> --}}
                            </ul>
                        </nav>
                    </div>

                    <!-- Start Course Feature Box  -->
                    <div class="rbt-course-feature-box overview-wrapper rbt-shadow-box mt--30 has-show-more" id="overview">
                        <div class="rbt-course-feature-inner has-show-more-inner-content">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">What you'll learn</h4>
                            </div>
                            <p>{!! $courseInfo->description !!}</p>

                        </div>
                        <div class="rbt-show-more-btn">Show More</div>
                    </div>
                    <!-- End Course Feature Box  -->

                    <!-- Start Course Content  -->
                    <div class="course-content rbt-shadow-box coursecontent-wrapper mt--30" id="coursecontent">
                        <div class="rbt-course-feature-inner">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Course Content</h4>
                            </div>
                            <div class="rbt-accordion-style rbt-accordion-02 accordion">
                                <div class="accordion" id="accordionExampleb2">
                    
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header card-header" id="headingTwo1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo1">
                                                Course {{ $courseInfo->name }} <span class="rbt-badge-5 ml--10"></span>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo1" class="accordion-collapse collapse show" aria-labelledby="headingTwo1" data-bs-parent="#accordionExampleb2">
                                            <div class="accordion-body card-body pr--0">
                                                <ul class="rbt-course-main-content liststyle">
                                                    @foreach ($courseInfo->courseModules as $module)
                                                    <li>
                                                        <a href="{{ $module->free_paid == 'free' ? route('free.lession', $courseInfo->id) : ($order && $order->status == 'enrolled' ? route('paid.lession', $courseInfo->id) : 'javascript:void(0)') }}">
                                                            <div class="course-content-left">
                                                                <i class="feather-play-circle"></i> <span class="text">{{ $module->title }}</span>
                                                            </div>
                                                            @if ($module->free_paid == 'free' || ($order && $order->status == 'enrolled'))
                                                            <div class="course-content-right">
                                                                <span class="min-lable"></span>
                                                                <span class="rbt-badge variation-03 bg-primary-opacity"><i class="feather-eye"></i> Preview</span>
                                                            </div>
                                                            @else
                                                            <div class="course-content-right">
                                                                <span class="course-lock"><i class="feather-lock"></i></span>
                                                            </div>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                    
                                    {{-- Additional accordion items can be added here as needed --}}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- End Course Content  -->

                    <!-- Start Course Feature Box  -->
                    {{-- <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30" id="details"> --}}
                        {{-- <div class="row g-5"> --}}
                            <!-- Start Feture Box  -->
                            {{-- <div class="col-lg-6">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3 mb--20">Requirements</h4>
                                </div>
                                <ul class="rbt-list-style-1">
                                    <li><i class="feather-check"></i>Become an advanced, confident, and modern
                                        JavaScript developer from scratch.</li>
                                    <li><i class="feather-check"></i>Have an intermediate skill level of Python
                                        programming.</li>
                                    <li><i class="feather-check"></i>Have a portfolio of various data analysis
                                        projects.</li>
                                    <li><i class="feather-check"></i>Use the numpy library to create and manipulate
                                        arrays.</li>
                                </ul>
                            </div> --}}
                            <!-- End Feture Box  -->

                            <!-- Start Feture Box  -->
                            {{-- <div class="col-lg-6">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3 mb--20">Description</h4>
                                </div>
                                <ul class="rbt-list-style-1">
                                    <li><i class="feather-check"></i>Use the Jupyter Notebook Environment.
                                        JavaScript developer from scratch.</li>
                                    <li><i class="feather-check"></i>Use the pandas module with Python to create and
                                        structure data.</li>
                                    <li><i class="feather-check"></i>Have a portfolio of various data analysis
                                        projects.</li>
                                    <li><i class="feather-check"></i>Create data visualizations using matplotlib and
                                        the seaborn.</li>
                                </ul>
                            </div> --}}
                            <!-- End Feture Box  -->
                        {{-- </div> --}}
                    {{-- </div> --}}
                    <!-- End Course Feature Box  -->

                    <!-- Start Intructor Area  -->
                    {{-- <div class="rbt-instructor rbt-shadow-box intructor-wrapper mt--30" id="intructor">
                        <div class="about-author border-0 pb--0 pt--0">
                            <div class="section-title mb--30">
                                <h4 class="rbt-title-style-3">Instructor</h4>
                            </div>
                            <div class="media align-items-center">
                                <div class="thumbnail">
                                    <a href="#">
                                        <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-7.jpg" alt="Author Images">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="author-info">
                                        <h5 class="title">
                                            <a class="hover-flip-item-wrapper" href="author.html">B.M. Rafekul Islam</a>
                                        </h5>
                                        <span class="b3 subtitle">Advanced Educator</span>
                                        <ul class="rbt-meta mb--20 mt--10">
                                            <li><i class="fa fa-star color-warning"></i>75,237 Reviews <span class="rbt-badge-5 ml--5">4.4 Rating</span></li>
                                            <li><i class="feather-users"></i>912,970 Students</li>
                                            <li><a href="#"><i class="feather-video"></i>16 Courses</a></li>
                                        </ul>
                                    </div>
                                    <div class="content">
                                        <p class="description">John is a brilliant educator, whose life was spent
                                            for computer science and love of nature.</p>

                                        <ul class="social-icon social-default icon-naked justify-content-start">
                                            <li><a href="https://www.facebook.com/">
                                                    <i class="feather-facebook"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.twitter.com">
                                                    <i class="feather-twitter"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.instagram.com/">
                                                    <i class="feather-instagram"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.linkdin.com/">
                                                    <i class="feather-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- End Intructor Area  -->

                    <!-- Start Edu Review List  -->
                    {{-- <div class="rbt-review-wrapper rbt-shadow-box review-wrapper mt--30" id="review">
                        <div class="course-content">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Review</h4>
                            </div>
                            <div class="row g-5 align-items-center">
                                <div class="col-lg-3">
                                    <div class="rating-box">
                                        <div class="rating-number">5.0</div>
                                        <div class="rating">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                        </div>
                                        <span class="sub-title">Course Rating</span>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="review-wrapper">
                                        <div class="single-progress-bar">
                                            <div class="rating-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 63%" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="value-text">63%</span>
                                        </div>

                                        <div class="single-progress-bar">
                                            <div class="rating-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 29%" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="value-text">29%</span>
                                        </div>

                                        <div class="single-progress-bar">
                                            <div class="rating-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 6%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="value-text">6%</span>
                                        </div>

                                        <div class="single-progress-bar">
                                            <div class="rating-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="value-text">1%</span>
                                        </div>

                                        <div class="single-progress-bar">
                                            <div class="rating-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                </svg>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="value-text">1%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- End Edu Review List  -->
                        {{-- review --}}
                    {{-- <div class="about-author-list rbt-shadow-box featured-wrapper mt--30 has-show-more">
                        <div class="section-title">
                            <h4 class="rbt-title-style-3">Featured review</h4>
                        </div>
                        <div class="has-show-more-inner-content rbt-featured-review-list-wrapper">
                            <div class="rbt-course-review about-author">
                                <div class="media">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-3.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="#">
                                                    Farjana Bawnia
                                                </a>
                                            </h5>
                                            <div class="rating">
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="description">At 29 years old, my favorite compliment is being
                                                told that I look like my mom. Seeing myself in her image, like this
                                                daughter up top.</p>
                                            <ul class="social-icon social-default transparent-with-border justify-content-start">
                                                <li><a href="#">
                                                        <i class="feather-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li><a href="#">
                                                        <i class="feather-thumbs-down"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-course-review about-author">
                                <div class="media">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-4.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="#">Razwan Islam</a>
                                            </h5>
                                            <div class="rating">
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="description">My favorite compliment is being
                                                told that I look like my mom. Seeing myself in her image, like this
                                                daughter up top.</p>
                                            <ul class="social-icon social-default transparent-with-border justify-content-start">
                                                <li><a href="#">
                                                        <i class="feather-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li><a href="#">
                                                        <i class="feather-thumbs-down"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-course-review about-author">
                                <div class="media">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-1.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="#">Babor Azom</a>
                                            </h5>
                                            <div class="rating">
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="description">My favorite compliment is being
                                                told that I look like my mom. Seeing myself in her image, like this
                                                daughter up top.</p>
                                            <ul class="social-icon social-default transparent-with-border justify-content-start">
                                                <li><a href="#">
                                                        <i class="feather-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li><a href="#">
                                                        <i class="feather-thumbs-down"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-course-review about-author">
                                <div class="media">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-6.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="#">Mohammad Ali</a>
                                            </h5>
                                            <div class="rating">
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="description">My favorite compliment is being
                                                told that I look like my mom. Seeing myself in her image, like this
                                                daughter up top.</p>
                                            <ul class="social-icon social-default transparent-with-border justify-content-start">
                                                <li><a href="#">
                                                        <i class="feather-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li><a href="#">
                                                        <i class="feather-thumbs-down"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-course-review about-author">
                                <div class="media">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="{{asset('/')}}frontend/assets/images/testimonial/testimonial-8.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="#">Sakib Al Hasan</a>
                                            </h5>
                                            <div class="rating">
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                                <a href="#"><i class="fa fa-star"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="description">My favorite compliment is being
                                                told that I look like my mom. Seeing myself in her image, like this
                                                daughter up top.</p>
                                            <ul class="social-icon social-default transparent-with-border justify-content-start">
                                                <li><a href="#">
                                                        <i class="feather-thumbs-up"></i>
                                                    </a>
                                                </li>
                                                <li><a href="#">
                                                        <i class="feather-thumbs-down"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rbt-show-more-btn">Show More</div>
                    </div> --}}
                </div>

            </div>

            <div class="col-lg-4">
                <div class="course-sidebar sticky-top rbt-shadow-box course-sidebar-top rbt-gradient-border ">
                    <div class="inner">
                        <!-- Start Viedo Wrapper  -->
                        <a class=" video-popup-with-text video-popup-wrapper sidebar-video-hidden text-center mb--15" href="javascript:void(0)">
                            <div class="video-content">
                                <img class="w-100 rbt-radius" src="{{asset($courseInfo->image)}}" alt="Video Images">
                                {{-- <div class="position-to-top">
                                    <span class="rbt-btn rounded-player-2 with-animation">
                                        <span class="play-icon"></span>
                                    </span>
                                </div>
                                {{-- <span class="play-view-text d-block color-white"><i class="feather-eye"></i> Preview this course</span> --}}
                            </div>
                        </a>
                        <!-- End Viedo Wrapper  -->
                        @if(optional($order)->status == 'enrolled')
                        <div class="p-4 rounded-3 text-center my-3" style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="feather-check-circle" style="font-size: 36px; color: #10b981;"></i>
                            <h5 class="mt-2 mb-1" style="font-weight: 700; color: #065f46;">You Are Enrolled!</h5>
                            <p style="color: #047857; font-size: 13px; line-height: 1.5;">You have unlimited access to all lessons and updates.</p>
                            <a href="#coursecontent" class="rbt-btn btn-gradient radius-round btn-sm w-100 mt-2">
                                <span>Go to Lessons</span>
                                <i class="feather-play ms-1"></i>
                            </a>
                        </div>
                        @else
                        <div class="content-item-content">
                            <div class="d-flex align-items-center justify-content-between my-3">
                                <span style="color: #64748b; font-size: 14px; font-weight: 600;">Course Price:</span>
                                <div style="font-family: var(--font-heading); font-size: 32px; font-weight: 800; color: #009e95;">
                                    ৳{{ number_format($courseInfo->price, 0) }}
                                </div>
                            </div>

                            <form method="get" action="{{route('user.buycourse')}}" id="buyForm">
                                <input type="hidden" name="productID" value="{{$courseInfo->id}}">
                                <button type="submit" class="rbt-btn btn-gradient icon-hover w-100 radius-round py-3 text-center">
                                    <span class="btn-text">Enroll In Course Now</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </button>
                            </form>

                            <!-- Course Value Props -->
                            <div class="mt-4 pt-3 border-top">
                                <h6 style="font-weight: 700; font-size: 14px; margin-bottom: 12px; color: #0f172a;">This Course Includes:</h6>
                                <ul class="d-flex flex-column gap-2 p-0 m-0" style="list-style: none; font-size: 14px; color: #475569;">
                                    <li><i class="feather-check text-success me-2"></i> Structured High-Quality Lectures</li>
                                    <li><i class="feather-check text-success me-2"></i> Real-Time Practice Quizzes</li>
                                    <li><i class="feather-check text-success me-2"></i> Full Lifetime Access</li>
                                    <li><i class="feather-check text-success me-2"></i> Mobile & Desktop Optimized</li>
                                    <li><i class="feather-check text-success me-2"></i> Verified Completion Certificate</li>
                                </ul>
                            </div>
                        </div>
                        @endif


                            {{-- <div class="rbt-widget-details has-show-more">
                                <ul class="has-show-more-inner-content rbt-course-details-list-wrapper">
                                    <li><span>Start Date</span><span class="rbt-feature-value rbt-badge-5">5 Hrs 20 Min</span>
                                    </li>
                                    <li><span>Enrolled</span><span class="rbt-feature-value rbt-badge-5">100</span></li>
                                    <li><span>Lectures</span><span class="rbt-feature-value rbt-badge-5">50</span></li>
                                    <li><span>Skill Level</span><span class="rbt-feature-value rbt-badge-5">Basic</span></li>
                                    <li><span>Language</span><span class="rbt-feature-value rbt-badge-5">English</span></li>
                                    <li><span>Quizzes</span><span class="rbt-feature-value rbt-badge-5">10</span></li>
                                    <li><span>Certificate</span><span class="rbt-feature-value rbt-badge-5">Yes</span></li>
                                    <li><span>Pass Percentage</span><span class="rbt-feature-value rbt-badge-5">95%</span></li>
                                </ul>
                                <div class="rbt-show-more-btn">Show More</div>
                            </div>

                            <div class="social-share-wrapper mt--30 text-center">
                                <div class="rbt-post-share d-flex align-items-center justify-content-center">
                                    <ul class="social-icon social-default transparent-with-border justify-content-center">
                                        <li><a href="https://www.facebook.com/">
                                                <i class="feather-facebook"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.twitter.com">
                                                <i class="feather-twitter"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.instagram.com/">
                                                <i class="feather-instagram"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.linkdin.com/">
                                                <i class="feather-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <hr class="mt--20">
                                <div class="contact-with-us text-center">
                                    <p>For details about the course</p>
                                    <p class="rbt-badge-2 mt--10 justify-content-center w-100"><i class="feather-phone mr--5"></i> Call Us: <a href="#"><strong>+444 555 666 777</strong></a></p>
                                </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>

{{-- <div class="rbt-related-course-area bg-color-white pt--60 rbt-section-gapBottom">
    <div class="container">
        <div class="section-title mb--30">
            <span class="subtitle bg-primary-opacity">More Similar Courses</span>
            <h4 class="title">Related Courses</h4>
        </div>
        <div class="row g-5">

            <!-- Start Single Card  -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="rbt-card variation-01 rbt-hover">
                    <div class="rbt-card-img">
                        <a href="course-details.html">
                            <img src="{{asset('/')}}frontend/assets/images/course/course-online-03.jpg" alt="Card image">
                            <div class="rbt-badge-3 bg-white">
                                <span>-10%</span>
                                <span>Off</span>
                            </div>
                        </a>
                    </div>
                    <div class="rbt-card-body">
                        <div class="rbt-card-top">
                            <div class="rbt-review">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count"> (5 Reviews)</span>
                            </div>
                            <div class="rbt-bookmark-btn">
                                <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                        class="feather-bookmark"></i></a>
                            </div>
                        </div>
                        <h4 class="rbt-card-title"><a href="course-details.html">Angular Zero to Mastery</a>
                        </h4>
                        <ul class="rbt-meta">
                            <li><i class="feather-book"></i>8 Lessons</li>
                            <li><i class="feather-users"></i>30 Students</li>
                        </ul>
                        <p class="rbt-card-text">Angular Js long fact that a reader will be distracted by
                            the readable.</p>

                        <div class="rbt-author-meta mb--20">
                            <div class="rbt-avater">
                                <a href="#">
                                    <img src="{{asset('/')}}frontend/assets/images/client/avatar-03.png" alt="Sophia Jaymes">
                                </a>
                            </div>
                            <div class="rbt-author-info">
                                By <a href="profile.html">Slaughter</a> In <a href="#">Languages</a>
                            </div>
                        </div>
                        <div class="rbt-card-bottom">
                            <div class="rbt-price">
                                <span class="current-price">$80</span>
                                <span class="off-price">$100</span>
                            </div>
                            <a class="rbt-btn-link" href="course-details.html">Learn
                                More<i class="feather-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Card  -->

            <!-- Start Single Card  -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="rbt-card variation-01 rbt-hover">
                    <div class="rbt-card-img">
                        <a href="course-details.html">
                            <img src="{{asset('/')}}frontend/assets/images/course/course-online-04.jpg" alt="Card image">
                            <div class="rbt-badge-3 bg-white">
                                <span>-40%</span>
                                <span>Off</span>
                            </div>
                        </a>
                    </div>
                    <div class="rbt-card-body">
                        <div class="rbt-card-top">
                            <div class="rbt-review">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count"> (15 Reviews)</span>
                            </div>
                            <div class="rbt-bookmark-btn">
                                <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                        class="feather-bookmark"></i></a>
                            </div>
                        </div>

                        <h4 class="rbt-card-title"><a href="course-details.html">Web Front To Back</a>
                        </h4>
                        <ul class="rbt-meta">
                            <li><i class="feather-book"></i>20 Lessons</li>
                            <li><i class="feather-users"></i>40 Students</li>
                        </ul>
                        <p class="rbt-card-text">Web Js long fact that a reader will be distracted by
                            the readable.</p>
                        <div class="rbt-author-meta mb--20">
                            <div class="rbt-avater">
                                <a href="#">
                                    <img src="{{asset('/')}}frontend/assets/images/client/avater-01.png" alt="Sophia Jaymes">
                                </a>
                            </div>
                            <div class="rbt-author-info">
                                By <a href="profile.html">Patrick</a> In <a href="#">Languages</a>
                            </div>
                        </div>

                        <div class="rbt-card-bottom">
                            <div class="rbt-price">
                                <span class="current-price">$60</span>
                                <span class="off-price">$120</span>
                            </div>
                            <a class="rbt-btn-link" href="course-details.html">Learn
                                More<i class="feather-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Card  -->

            <!-- Start Single Card  -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="rbt-card variation-01 rbt-hover">
                    <div class="rbt-card-img">
                        <a href="course-details.html">
                            <img src="{{asset('/')}}frontend/assets/images/course/course-online-05.jpg" alt="Card image">
                            <div class="rbt-badge-3 bg-white">
                                <span>-20%</span>
                                <span>Off</span>
                            </div>
                        </a>
                    </div>
                    <div class="rbt-card-body">
                        <div class="rbt-card-top">
                            <div class="rbt-review">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="rating-count"> (15 Reviews)</span>
                            </div>
                            <div class="rbt-bookmark-btn">
                                <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                        class="feather-bookmark"></i></a>
                            </div>
                        </div>
                        <h4 class="rbt-card-title"><a href="course-details.html">SQL Beginner Advanced</a>
                        </h4>
                        <ul class="rbt-meta">
                            <li><i class="feather-book"></i>12 Lessons</li>
                            <li><i class="feather-users"></i>50 Students</li>
                        </ul>
                        <p class="rbt-card-text">It is a long established fact that a reader will be
                            distracted
                            by the readable.</p>
                        <div class="rbt-author-meta mb--20">
                            <div class="rbt-avater">
                                <a href="#">
                                    <img src="{{asset('/')}}frontend/assets/images/client/avatar-02.png" alt="Sophia Jaymes">
                                </a>
                            </div>
                            <div class="rbt-author-info">
                                By <a href="profile.html">Angela</a> In <a href="#">Development</a>
                            </div>
                        </div>
                        <div class="rbt-card-bottom">
                            <div class="rbt-price">
                                <span class="current-price">$60</span>
                                <span class="off-price">$120</span>
                            </div>
                            <a class="rbt-btn-link left-icon" href="course-details.html"><i
                                    class="feather-shopping-cart"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Card  -->

        </div>
    </div>
</div> --}}

<!-- Start Course Action Bottom  -->
<div class="rbt-course-action-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="section-title text-center text-md-start">
                    <h5 class="title mb--0">{{ $courseInfo->name }}</h5>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mt_sm--15">
                <div class="course-action-bottom-right rbt-single-group">
                    <div class="rbt-single-list rbt-price large-size justify-content-center">
                        <span class="current-price color-primary">৳ {{number_format($courseInfo->price, 2)}}</span>
                        {{-- <span class="off-price">$1500.00</span> --}}
                    </div>

                    <div class="rbt-single-list action-btn">
                        <a class="rbt-btn btn-gradient hover-icon-reverse btn-md" href="#" onclick="event.preventDefault(); document.getElementById('buyForm').submit()" >
                            <span class="icon-reverse-wrapper">
                            <span class="btn-text">Purchase Now</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Course Action Bottom  -->

@endsection
