@php
    $company_info = $company_info ?? DB::table('company_settings')->first();
    $catgories = DB::table('categories')->where('active', 1)->get();
    $courses = DB::table('courses')->where('active', 1)->get();
    $news = DB::table('notice')->where('active', 1)->orderBy('id', 'desc')->get();
@endphp
<style>
    .grab {
        cursor: -webkit-grab;
        cursor: grab;
    }
    .nav-menu > li > a {
        padding: 37px 12px;
    }
    .navigation-portrait {
        height: 100px;
    }
    .nav-toggle {
        top: 3%;
    }
    .nav-menu.nav-menu-social > li.login_click a {
            top: 0;
            padding: 14px 20px;
        }
    @media only screen and (min-width: 1100px) {
        .nav-header img {
            margin: -10px 30px;
            object-fit: cover;
            max-height: 110px
        }

        .nav-container {
            display: flex;
            justify-content: center;
        }

        .nav-menus-wrapper {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0 auto;
        }

        .nav-menu>li {
            margin: 0 10px;
            /* Adjust margin as needed */
        }

        .nav-menu-social {
            margin-right: 3rem !important;
        }

    }

    @media only screen and (max-width: 700px) {
        .nav-header img {
            object-fit: cover;
            max-height: 80px
        }
        .nav-menu.nav-menu-social > li.login_click a {
            top: 0;
            padding: 14px 20px;
        }
    }
</style>

<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->
<!-- Start Navigation -->
<div class="header header-light">
    {{-- <div class="container-fluied height27" style="background-color: #252C41;">
        <div class="row">
            <div class="col-md-1 col-2 text-center text-light bg-danger height27">
                <div>
                    <p id="noticeMoblie"><b>Notice</b></p>
                </div>
            </div>
            <div class="col-md-11 col-10 text-light" id="marqueeeFather">
                <marquee id="marQueee" onmouseover="this.stop();" style="}" onmouseout="this.start();" width="100%" direction="left" class="grab" scrollamount="5">
                @foreach ($news as $notice)
                📋 {{$notice->title}}
                @endforeach
                </marquee>
            </div>
        </div>
    </div> --}}
    <style>
        .header-main-container {
            padding-left: 15px;
            padding-right: 15px;
        }
        @media only screen and (min-width: 1200px) {
            .header-main-container {
                padding-left: 80px;
                padding-right: 80px;
            }
        }
    </style>
    <div class="container-fluid header-main-container">
        <nav id="navigation" class="navigation-landscape nav-container">
            <div class="nav-header">
                <a class="py-1" href="{{ route('/') }}">
                    <img src="{{ asset(optional($company_info)->logo) }}" class="img-fluid" alt="{{ optional($company_info)->company_name ?? 'Logo' }}"
                        title="{{ optional($company_info)->company_name }}" style="max-height: 52px; width: auto; object-fit: contain;">
                </a>
                <div class="nav-header-actions">
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
                </div>
                <div class="nav-toggle"></div>
            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">
                <ul class="nav-menu">

                    <li class=""><a href="{{ route('/') }}">Home</span></a></li>
                    <li><a href="{{ route('course') }}">Courses<span class="submenu-indicator"></span></a>

                    <li><a href="{{ route('all.courses') }}">Examination<span class="submenu-indicator"></span></a>
                        {{-- <ul class="nav-dropdown nav-submenu">
                            @foreach ($catgories as $category)
                                @php
                                    $exams = DB::table('exams')
                                        ->where('catID', $category->id)
                                        ->where('active', 1)
                                        ->get();
                                    $url = str_replace(' ', '-', $category->name);
                                @endphp
                                <li><a href="{{ url('/category/' . $category->id . '/' . $url) }}">{{ $category->name }}
                                        @if ($category->free_paid == 'paid')
                                            (Paid)
                                        @endif
                                        <span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu">
                                        @if ($exams != '[]')
                                            @foreach ($exams as $exam)
                                                @php
                                                    $Eurl = str_replace(' ', '-', $exam->exam_name);
                                                    $key = rand(10000, 199999);
                                                @endphp
                                                @if ($exam->mcq_written == 'mcq')
                                                    <li><a
                                                            href="{{ url('/start-mcq-exam/' . $exam->id . '/' . $Eurl . '/' . $key) }}">{{ $exam->exam_name }}</a>
                                                    </li>
                                                @elseif($exam->mcq_written == 'written')
                                                    <li><a
                                                            href="{{ url('/start-written-exam/' . $exam->id . '/' . $Eurl . '/' . $key) }}">{{ $exam->exam_name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li>
                                                <div class="text-center">
                                                    <h4><b>Coming Soon!</b></h4>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        </ul> --}}
                    </li>
                    {{-- <ul class="nav-dropdown nav-submenu">
                            @foreach ($courses as $course)

                                <li><a href="{{url('/course/'.$course->id)}}">{{$course->name}} <span class="submenu-indicator"></span></a>

                                            @endforeach




                                </li>

                        </ul> --}}
                    </li>
                    {{-- <li><a href="#">Blog<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{route('user.blog.english')}}">English</a></li>
                            <li><a href="{{route('user.blog.bangla')}}">Bangla</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    {{-- <li><a href="{{route('user.books')}}">Admission Program</a></li> --}}
                    <li><a href="{{ route('user.about_us') }}">About Us</a></li>
                    {{-- <li><a href="#">Others<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{route('user.about_us')}}">About Us</a></li>
                            <li><a href="{{route('user.contact_us')}}">Contact</a></li>
                            <li><a href="{{route('user.mission_and_vission')}}">Mission & Vission</a></li>
                            <li><a href="{{route('user.privacy_and_policy')}}">Privacy and Policy</a></li>
                            <li><a href="{{route('user.trams_and_conditions')}}">Terms and Conditions</a></li>
                        </ul>
                    </li> --}}
                </ul>

                <ul class="nav-menu nav-menu-social align-items-center">
                    <li class="theme-toggle-nav-item">
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
                            <span class="theme-toggle-label d-xl-none ms-2">Dark Mode</span>
                        </button>
                    </li>

                    @if (!empty($userID))
                        <li title="Go to profile" class="login_click green light">
                            <a href="{{ route('user.myaccount.dashboard') }}"><i class="fas fa-user-check"></i> &#160;
                                {{ $userName }}</a>
                        </li>
                    @else
                        <li class="login_click"
                            style="color: #fff;
                            background-size: 300% 100%;
                            background-image: linear-gradient(to right, #03C6BB, #b966e7, #b966e7, #03C6BB);">
                            <a href="{{ route('user.login_or_signup') }}">Login/Sign Up</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- End Navigation -->
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->
