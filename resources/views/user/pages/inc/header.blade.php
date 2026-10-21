@php
    $company_info = $company_info ?? DB::table('company_settings')->first();
    $catgories = DB::table('categories')->where('active', 1)->get();
    $courses = DB::table('courses')->where('active', 1)->get();
    $news = DB::table('notice')->where('active', 1)->orderBy('id', 'desc')->get();
@endphp
<!-- Start Header Area -->
<header class="rbt-header rbt-header-10">
    <div class="rbt-sticky-placeholder"></div>
    <!-- Start Header Top  -->
    {{-- <div class="rbt-header-top rbt-header-top-1 header-space-betwween bg-not-transparent bg-color-darker top-expended-activation">
        <div class="container-fluid">
            <div class="top-expended-wrapper">
                <div class="top-expended-inner rbt-header-sec align-items-center ">
                    <div class="rbt-header-sec-col rbt-header-left d-none d-xl-block">
                        <div class="rbt-header-content">
                            <!-- Start Header Information List  -->
                            <div class="header-info">
                                <ul class="rbt-information-list">
                                    <li>
                                        <a href="#"><i class="fab fa-instagram"></i>100k <span class="d-none d-xxl-block">Followers</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fab fa-facebook-square"></i>500k <span class="d-none d-xxl-block">Followers</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Header Information List  -->
                        </div>
                    </div>
                    <div class="rbt-header-sec-col rbt-header-center">
                        <div class="rbt-header-content justify-content-start justify-content-xl-center">
                            <div class="header-info">
                                <div class="rbt-header-top-news">
                                    <div class="inner">
                                        <div class="content">
                                            <span class="rbt-badge variation-02 bg-color-primary color-white radius-round">Hot</span>
                                            <span class="news-text"><img src="{{ asset('/') }}frontend/assets/images/icons/hand-emojji.svg" alt="Hand Emojji Images"> Intro price. Get Histudy for Big Sale -95% off.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rbt-header-sec-col rbt-header-right mt_md--10 mt_sm--10">
                        <div class="rbt-header-content justify-content-start justify-content-lg-end">
                            <div class="header-info d-none d-xl-block">
                                <ul class="social-share-transparent">
                                    <li>
                                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fab fa-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="rbt-separator d-none d-xl-block"></div>

                            <div class="header-info">
                                <ul class="rbt-dropdown-menu switcher-language">
                                    <li class="has-child-menu">
                                        <a href="#">
                                            <img class="left-image" src="{{ asset('/') }}frontend/assets/images/icons/en-us.png" alt="Language Images">
                                            <span class="menu-item">English</span>
                                            <i class="right-icon feather-chevron-down"></i>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="#">
                                                    <img class="left-image" src="{{ asset('/') }}frontend/assets/images/icons/fr.png" alt="Language Images">
                                                    <span class="menu-item">Français</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="left-image" src="{{ asset('/') }}frontend/assets/images/icons/de.png" alt="Language Images">
                                                    <span class="menu-item">Deutsch</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="header-info">
                                <ul class="rbt-dropdown-menu currency-menu">
                                    <li class="has-child-menu">
                                        <a href="#">
                                            <span class="menu-item">USD</span>
                                            <i class="right-icon feather-chevron-down"></i>
                                        </a>
                                        <ul class="sub-menu hover-reverse">
                                            <li>
                                                <a href="#">
                                                    <span class="menu-item">EUR</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="menu-item">GBP</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-info">
                    <div class="top-bar-expended d-block d-lg-none">
                        <button class="topbar-expend-button rbt-round-btn"><i class="feather-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Header Top  -->
    <div class="rbt-header-wrapper header-space-betwween header-sticky py-0">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-center align-items-center">
                <div class="header-left rbt-header-content">
                    <div class="header-info">
                        <div class="logo_image">
                            <a href="/">
                                <img src="{{ asset(optional($company_info)->logo) }}" class="img-fluid" alt="{{ optional($company_info)->company_name ?? 'Logo' }}" style="max-height: 52px; width: auto; object-fit: contain;">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="/">Home </a>
                            </li>

                            <li class="with-megamenu has-menu-child-item">
                                <a href="{{ route('course') }}">Courses </a>
                            </li>

                            <li class="has-dropdown has-menu-child-item">
                                <a href="{{ route('all.courses') }}">Examination
                                    {{-- <i class="feather-chevron-down"></i> --}}
                                </a>
                            </li>

                            <li class="has-menu-child-item">
                                <a href="{{ route('practice_quiz.index') }}">
                                    Quiz Preparation <span class="badge bg-warning text-dark ms-1" style="font-size: 10px; border-radius: 12px; padding: 2px 7px; font-weight: 800;">GAME</span>
                                </a>
                            </li>
                                {{-- <ul class="submenu">
                                    @foreach($catgories as $category)
                                    @php
                                        $exams = DB::table('exams')->where('catID', $category->id)->where('active', 1)->get();
                                        $url = str_replace(" ","-", $category->name);
                                    @endphp
                                    <li class="has-dropdown"><a href="{{url('/category/'.$category->id.'/'.$url)}}">{{$category->name}} @if($category->free_paid == 'paid') (Paid) @endif</a>
                                        <ul class="submenu">
                                            @if($exams != '[]')
                                            @foreach($exams as $exam)
                                            @php
                                                $Eurl = str_replace(" ","-", $exam->exam_name);
                                                $key = rand(10000, 199999);
                                            @endphp
                                             @if($exam->mcq_written == 'mcq')

                                             <li><a href="{{url('/start-mcq-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">{{$exam->exam_name}}</a></li>
                                             @elseif($exam->mcq_written == 'written')
                                                 <li><a href="{{url('/start-written-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">{{$exam->exam_name}}</a></li>
                                             @endif
                                            @endforeach
                                            @else
                                            <li><div class="text-center"><h4><b>Coming Soon!</b></h4></div></li>
                                            @endif
                                        </ul>
                                    </li>
                                    @endforeach

                                </ul> --}}
                            </li>

                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="{{ route('shop') }}">Shop </a>

                            </li>

                            <!--<li class="with-megamenu has-menu-child-item position-static">-->
                            <!--    <a href="#">Admission Program</a>-->
                            <!--</li>-->

                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="{{ route('user.about_us') }}">About Us </a>

                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="header-right">

                    <!-- Navbar Icons -->
                    <ul class="quick-access">
                        <!-- Dark Mode Toggle Button -->
                        <li class="access-icon theme-toggle-quick-item me-2">
                            <button type="button" class="theme-toggle-btn" aria-label="Toggle dark mode" title="Toggle dark mode">
                                <span class="theme-toggle-icon-wrap">
                                    <svg class="theme-icon theme-icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="5"></circle>
                                        <line x1="12" y1="1" x2="12" y2="3"></line>
                                        <line x1="12" y1="21" x2="12" y2="23"></line>
                                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                        <line x1="1" y1="12" x2="3" y2="12"></line>
                                        <line x1="21" y1="12" x2="23" y2="12"></line>
                                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                                    </svg>
                                    <svg class="theme-icon theme-icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                    </svg>
                                </span>
                            </button>
                        </li>
                        {{-- <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn" href="#">
                                <i class="feather-search"></i>
                            </a>
                        </li> --}}

                        {{-- <li class="access-icon rbt-mini-cart me-3">
                            <a class="rbt-cart-sidenav-activation rbt-round-btn" href="#">
                                <i class="feather-shopping-cart"></i>
                                <span class="rbt-cart-count">4</span>
                            </a>
                        </li> --}}

                        @if(!empty($userID))
                        <li class="account-access rbt-user-wrapper d-none d-xl-block">
                            <a href="#"><i class="feather-user"></i>{{$userName}}</a>
                            <div class="rbt-user-menu-list-wrapper">
                                <div class="inner">
                                    <div class="rbt-admin-profile">
                                        <div class="admin-thumbnail">
                                            <img src="{{ asset('/') }}frontend/assets/images/user-student.png" alt="User Images">
                                        </div>
                                        <div class="admin-info">
                                            <span class="name">{{$userName}}</span>
                                            <a class="rbt-btn-link color-primary" href="{{ route('user.myaccount.profile') }}">View Profile</a>
                                        </div>
                                    </div>
                                    {{-- <ul class="user-list-wrapper">
                                        <li>
                                            <a href="{{route('user.myaccount')}}">
                                                <i class="feather-home"></i>
                                                <span>My Dashboard</span>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="#">
                                                <i class="feather-bookmark"></i>
                                                <span>Bookmark</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-enrolled-courses.html">
                                                <i class="feather-shopping-bag"></i>
                                                <span>Enrolled Courses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-wishlist.html">
                                                <i class="feather-heart"></i>
                                                <span>Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-reviews.html">
                                                <i class="feather-star"></i>
                                                <span>Reviews</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-my-quiz-attempts.html">
                                                <i class="feather-list"></i>
                                                <span>My Quiz Attempts</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-order-history.html">
                                                <i class="feather-clock"></i>
                                                <span>Order History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-quiz-attempts.html">
                                                <i class="feather-message-square"></i>
                                                <span>Question & Answer</span>
                                            </a>
                                        </li>
                                    </ul> --}}
                                    {{-- <hr class="mt--10 mb--10"> --}}
                                    {{-- <ul class="user-list-wrapper">
                                        <li>
                                            <a href="#">
                                                <i class="feather-book-open"></i>
                                                <span>Getting Started</span>
                                            </a>
                                        </li>
                                    </ul> --}}
                                    {{-- <hr class="mt--10 mb--10"> --}}
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="{{route('user.myaccount.dashboard')}}">
                                                <i class="feather-home"></i>
                                                <span>My Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('user.logout')}}">
                                                <i class="feather-log-out"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="access-icon rbt-user-wrapper d-block d-xl-none">
                            <a class="rbt-round-btn" href="#"><i class="feather-user"></i></a>
                            <div class="rbt-user-menu-list-wrapper">
                                <div class="inner">
                                    <div class="rbt-admin-profile">
                                        <div class="admin-thumbnail">
                                            <img src="{{ asset('/') }}frontend/assets/images/user-student.png" alt="User Images">
                                        </div>
                                        <div class="admin-info">
                                            <span class="name">{{$userName}}</span>
                                            <a class="rbt-btn-link color-primary" href="{{ route('user.myaccount.profile') }}">View Profile</a>
                                        </div>
                                    </div>
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="{{route('user.myaccount.dashboard')}}">
                                                <i class="feather-home"></i>
                                                <span>My Dashboard</span>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="#">
                                                <i class="feather-bookmark"></i>
                                                <span>Bookmark</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-enrolled-courses.html">
                                                <i class="feather-shopping-bag"></i>
                                                <span>Enrolled Courses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-wishlist.html">
                                                <i class="feather-heart"></i>
                                                <span>Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-reviews.html">
                                                <i class="feather-star"></i>
                                                <span>Reviews</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-my-quiz-attempts.html">
                                                <i class="feather-list"></i>
                                                <span>My Quiz Attempts</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-order-history.html">
                                                <i class="feather-clock"></i>
                                                <span>Order History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-quiz-attempts.html">
                                                <i class="feather-message-square"></i>
                                                <span>Question & Answer</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                    {{-- <hr class="mt--10 mb--10">
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="#">
                                                <i class="feather-book-open"></i>
                                                <span>Getting Started</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="mt--10 mb--10"> --}}
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="{{ route('user.myaccount.psetting') }}">
                                                <i class="feather-settings"></i>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.logout') }}">
                                                <i class="feather-log-out"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @else
                    <div class="rbt-btn-wrapper d-none d-xl-block">
                        {{-- <a class="rbt-btn rbt-marquee-btn marquee-auto btn-border-gradient radius-round btn-sm hover-transform-none" href="#">
                            <span data-text="Enroll Now">Enroll Now</span>
                        </a> --}}
                        <a class="rbt-btn rbt-switch-btn btn-gradient btn-sm hover-transform-none" href="{{ route('user.login_or_signup') }}">
                            <span data-text="Login/Sign Up">Login/Sign Up</span>
                        </a>
                    </div>
                    @endif
                    </ul>

                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar d-block d-xl-none">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->

                </div>
            </div>
        </div>
        <!-- Start Search Dropdown  -->
        <div class="rbt-search-dropdown">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#">
                            <input type="text" placeholder="What are you looking for?">
                            <div class="submit-btn">
                                <a class="rbt-btn btn-gradient btn-md" href="#">Search</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="rbt-separator-mid">
                    <hr class="rbt-separator m-0">
                </div>

                <div class="row g-4 pt--30 pb--60">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h5 class="rbt-title-style-2">Our Top Course</h5>
                        </div>
                    </div>

                    <!-- Start Single Card  -->
                    {{-- <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="course-details.html">
                                    <img src="{{ asset('/') }}frontend/assets/images/course/course-online-01.jpg" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="course-details.html">React Js</a>
                                </h5>
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
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$15</span>
                                        <span class="off-price">$25</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- End Single Card  -->


                </div>

            </div>
        </div>
        <!-- End Search Dropdown  -->
    </div>
    <a class="rbt-close_side_menu" href="javascript:void(0);"></a>
</header>
<!-- Mobile Menu Section -->
<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <a href="/">
                        <img src="{{ asset(optional($company_info)->logo) }}" alt="{{ optional($company_info)->company_name ?? 'Logo' }}" style="max-height: 48px; width: auto; object-fit: contain;">
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="theme-toggle-btn" aria-label="Toggle dark mode" title="Toggle dark mode">
                        <span class="theme-toggle-icon-wrap">
                            <svg class="theme-icon theme-icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                            <svg class="theme-icon theme-icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
            </div>
            {{-- <p class="description">Histudy is a education website template. You can customize all.</p> --}}
            <ul class="navbar-top-left rbt-information-list justify-content-start">
                <li>
                    <a href="mailto:{{ (optional($company_info)->email) }}"><i class="feather-mail"></i>{{ (optional($company_info)->email) }}</a>
                </li>
                <li>
                    <a href="#"><i class="feather-phone"></i>{{ (optional($company_info)->phone_1) }}</a>
                </li>
            </ul>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                <li class=" position-static">
                    <a href="/">Home </a>

                </li>

                <li class="">
                    <a href="{{ route('course') }}">Courses </a>
                </li>
                <li class="">
                    <a href="{{ route('all.courses') }}">Examination </a>
                </li>
                <li class="">
                    <a href="{{ route('practice_quiz.index') }}">Quiz Preparation <span class="badge bg-warning text-dark ms-1" style="font-size: 10px; border-radius: 10px; padding: 2px 6px;">GAME</span></a>
                </li>
                {{-- <li class="has-dropdown has-menu-child-item">
                    <a href="{{ route('all.courses') }}" class="">Examination
                        <i class="feather-chevron-down"></i>
                    </a>
                    <ul class="submenu" style="display: none;">
                        @foreach($catgories as $category)
                        @php
                            $exams = DB::table('exams')->where('catID', $category->id)->where('active', 1)->get();
                            $url = str_replace(" ","-", $category->name);
                        @endphp
                        <li class="has-dropdown"><a href="{{url('/category/'.$category->id.'/'.$url)}}">{{$category->name}} @if($category->free_paid == 'paid') (Paid) @endif</a>
                            <ul class="submenu">
                                @if($exams != '[]')
                                @foreach($exams as $exam)
                                @php
                                    $Eurl = str_replace(" ","-", $exam->exam_name);
                                    $key = rand(10000, 199999);
                                @endphp
                                 @if($exam->mcq_written == 'mcq')

                                 <li><a href="{{url('/start-mcq-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">{{$exam->exam_name}}</a></li>
                                 @elseif($exam->mcq_written == 'written')
                                     <li><a href="{{url('/start-written-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">{{$exam->exam_name}}</a></li>
                                 @endif
                                @endforeach
                                @else
                                <li><div class="text-center"><h4><b>Coming Soon!</b></h4></div></li>
                                @endif
                            </ul>
                        </li>
                        @endforeach

                    </ul>
                </li> --}}
                <li class=" position-static">
                    <a href="{{ route('shop') }}">Shop </a>
                </li>

                {{-- <li class=" position-static">
                    <a href="#">Admission Program </a>
                </li> --}}

                <li class=" position-static">
                    <a href="{{ route('user.about_us') }}">About Us </a>

                </li>
            </ul>
        </nav>

        <div class="mobile-menu-bottom">
            <div class="rbt-btn-wrapper mb--20">
                {{-- <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center" href="#">
                    <span>Enroll Now</span>
                </a> --}}
                @if(empty($userID))
                <a class="rbt-btn rbt-switch-btn btn-gradient btn-sm hover-transform-none w-100 justify-content-center text-center" href="{{ route('user.login_or_signup') }}">
                    <span data-text="Login/Sign Up">Login/Sign Up</span>
                </a>
                @endif
            </div>

            <div class="social-share-wrapper">
                <span class="rbt-short-title d-block">Find With Us</span>
                <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
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
<!-- Start Side Vav -->
{{-- <div class="rbt-cart-side-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="title">
                    <h4 class="title mb--0">Your shopping cart</h4>
                </div>
                <div class="rbt-btn-close" id="btn_sideNavClose">
                    <button class="minicart-close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
        </div>
        <nav class="side-nav w-100">
            <ul class="rbt-minicart-wrapper">
                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('/') }}frontend/assets/images/product/1.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Miracle Morning</a></h6>

                        <span class="quantity">1 * <span class="price">$22</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('/') }}frontend/assets/images/product/7.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Happy Strong</a></h6>

                        <span class="quantity">1 * <span class="price">$30</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('/') }}frontend/assets/images/product/3.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Rich Dad Poor Dad</a></h6>

                        <span class="quantity">1 * <span class="price">$50</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>

                <li class="minicart-item">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ asset('/') }}frontend/assets/images/product/4.jpg" alt="Product Images">
                        </a>
                    </div>
                    <div class="product-content">
                        <h6 class="title"><a href="single-product.html">Momentum Theorem</a></h6>

                        <span class="quantity">1 * <span class="price">$50</span></span>
                    </div>
                    <div class="close-btn">
                        <button class="rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="rbt-minicart-footer">
            <hr class="mb--0">
            <div class="rbt-cart-subttotal">
                <p class="subtotal"><strong>Subtotal:</strong></p>
                <p class="price">$121</p>
            </div>
            <hr class="mb--0">
            <div class="rbt-minicart-bottom mt--20">
                <div class="view-cart-btn">
                    <a class="rbt-btn btn-border icon-hover w-100 text-center" href="#">
                        <span class="btn-text">View Cart</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
                <div class="checkout-btn mt--20">
                    <a class="rbt-btn btn-gradient icon-hover w-100 text-center" href="#">
                        <span class="btn-text">Checkout</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div> --}}
<!-- End Side Vav -->
<a class="close_side_menu" href="javascript:void(0);"></a>




<!-- Start Header Area -->
