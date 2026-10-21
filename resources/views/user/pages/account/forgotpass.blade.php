@extends('user.pages.test_master')
@section('content')
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Password</span> Reset</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Password</span> Reset</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->
    <!-- ========================== Articles Section =============================== -->
    <div class="rbt-tab-area bg-color-white rbt-section-gap">
        <div class="container" style="padding-bottom: 100px;">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="center text-center mt-3">
                        <h2><span class="theme-cl">Password</span> Reset</h2>
                    </div>
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <div class="card-body">
                            {{-- <form class="theme-form" action="{{ route('user.pass_set_step_one') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12 form-group">
                                        <label for="email"><span class="text-danger">*</span>Enter Your Email</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Ex: cse.ridoypaul@gmail.com" required>
                                    </div>
                                </div>
                                <h5 style="color: danger">{{ session('pass') }}</h5>
                                <div class="row g-3">
                                    <div class="col-md-12 form-group"><button type="submit"
                                            class="btn btn-md full-width pop-login">Submit</button>
                                    </div>
                                </div>
                                <div class="row g-3">
    
                                </div>
                            </form> --}}
                            <h4>Contact With Administrator</h4>
                            <div class="form-submit-group">
                                <a href="{{ route('user.contact_us') }}" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">GET IT NOW</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
    <!-- ========================== Articles Section =============================== -->
@endsection


<!-- ========================== Articles Section =============================== -->
