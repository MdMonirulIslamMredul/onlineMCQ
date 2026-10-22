@php
    $company_info = $company_info ?? DB::table('company_settings')->first();
    // $catgories = DB::table('categories')->where('active', 1)->limit(6)->get();
    $courses = DB::table('courses')->where('active', 1)->get();
    $news = DB::table('notice')->where('active', 1)->orderBy('id', 'desc')->get();
@endphp
<footer class="rbt-footer footer-style-1">
    <div class="footer-top">
        <div class="container">
            <div class="row row--15 mt_dec--30">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <div class="footer-logo-wrap">
                            <a href="/">
                                <img src="{{ asset(optional($company_info)->logo) }}" alt="{{ optional($company_info)->company_name ?? 'Logo' }}" style="max-height: 52px; width: auto; object-fit: contain;">
                            </a>
                        </div>

                        <p class="description mt--20">{{ optional($company_info)->footer_des }}
                        </p>

                        <div class="contact-btn mt--30">
                            <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round" href="{{ route('user.contact_us') }}">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Contact With Us</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Category</h5>
                        <ul class="ft-link">

                            @foreach ($courses->unique('catID') as $course)
                            @php
                                $category= DB::table('course_categories')->where('id',$course->catID)->first();
                            @endphp
                            <li>
                                <a href="{{ route('cat',$course->id) }}">{{ $category->name??null }}</a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Quick Links</h5>
                        <ul class="ft-link">
                            <li>
                                <a href="{{ route('user.about_us') }}">About Us</a>
                            </li>
                            <li>
                                <a href="{{ route('user.teachers') }}">Our Mentors</a>
                            </li>
                            <li>
                                <a href="{{ route('user.blog') }}">Educational Blog</a>
                            </li>
                            <li>
                                <a href="{{ route('user.mission_and_vission') }}">Mission & Vision</a>
                            </li>
                            <li>
                                <a href="{{ route('user.contact_us') }}">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Get Contact</h5>
                        <ul class="ft-link">
                            <li><span>Phone:</span> {{ optional($company_info)->phone_1 }}, {{ optional($company_info)->phone_2 }}</li>
                            <li><span>E-mail:</span> <a href="mailto:{{ optional($company_info)->email }}">{{ optional($company_info)->email }}</a></li>
                            <li><span>Location:</span> {{ optional($company_info)->address }}</li>
                        </ul>
                        <ul class="social-icon social-default icon-naked justify-content-start mt--20">
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
    </div>
</footer>
<!-- End Footer aera -->
<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
<!-- Start Copyright Area  -->
<div class="copyright-area copyright-style-1 ptb--20">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                <p class="rbt-link-hover text-center text-lg-start">{{ optional($company_info)->footer_credit ?? '© 2026 Pathjolpona. All Rights Reserved.' }}</p>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                <ul class="copyright-link rbt-link-hover justify-content-center justify-content-lg-end mt_sm--10 mt_md--10">
                    <li><a href="{{ route('user.trams_and_conditions') }}">Terms of service</a></li>
                    <li><a href="{{ route('user.privacy_and_policy') }}">Privacy policy</a></li>
                    <li><a href="{{ route('user.return_and_refund_policy') }}">Refund policy</a></li>
                    <li><a href="{{ route('user.login_or_signup') }}">Login & Register</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Copyright Area  -->
<div class="rbt-progress-parent">
    <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
