@extends('user.pages.test_master')
@section('content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name');
$userQ = DB::table('users')->where('id', $userID)->first();

$attendExams = DB::table('results')
->join('exams', 'results.examID', 'exams.id')
->select('results.*', 'exams.exam_name')
->where('results.userID', $userQ->id)
->latest()->get();

$orders = DB::table('books_order')->where('phone', $userQ->phone)->orWhere('email', $userQ->email)->orderBy('id', 'desc')->get();
$course = DB::table('courses_order')->where('phone', $userQ->phone)->orWhere('email', $userQ->email)->orderBy('id', 'desc')->get();

@endphp

<!-- ============================ Dashboard: My Order Start ================================== -->
<div class="rbt-page-banner-wrapper">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image"></div>
    <!-- End Banner BG Image  -->
</div>
<!-- Start Card Style -->
<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Start Dashboard Top  -->
                <div class="rbt-dashboard-content-wrapper">
                    <div class="tutor-bg-photo bg-gradient-7  height-350"></div>
                    <!-- Start Tutor Information  -->
                    <div class="rbt-tutor-information">
                        <div class="rbt-tutor-information-left">
                            <div class="thumbnail rbt-avatars size-lg">
                                <img src="{{ asset('/') }}frontend/assets/images/user-student.png" alt="Instructor">
                            </div>
                            <div class="tutor-content">
                                <h5 class="title">{{$userName}}</h5>
                                <ul class="rbt-meta rbt-meta-white mt--5">
                                    <li><i class="feather-book"></i>{{ $course->count()}} Courses Enroled</li>
                                    {{-- <li><i class="feather-award"></i>4 Certificate</li> --}}
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="rbt-tutor-information-right">
                            <div class="tutor-btn">
                                <a class="rbt-btn btn-md hover-icon-reverse" href="#">
                                    <span class="icon-reverse-wrapper">
                    <span class="btn-text">Become an Instructor</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- End Tutor Information  -->
                </div>
                <!-- End Dashboard Top  -->


                <div class="row g-5">
                    <div class="col-lg-3">
                        <!-- Start Dashboard Sidebar  -->
                        <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                            <div class="inner">
                                <div class="content-item-content">

                                    <div class="rbt-default-sidebar-wrapper">
                                        <div class="section-title mb--20">
                                            <h6 class="rbt-title-style-2">Welcome, {{$userName}}</h6>
                                        </div>
                                        <nav class="mainmenu-nav">
                                            <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                <li><a href="{{ route('user.myaccount.dashboard') }}"><i class="feather-home"></i><span>Dashboard</span></a></li>
                                                <li><a href="{{ route('user.myaccount.profile') }}"><i class="feather-user"></i><span>My Profile</span></a></li>
                                                <li><a href="{{ route('user.myaccount.courses') }}"><i class="feather-book-open"></i><span>Enrolled Courses</span></a>
                                                {{-- </li>
                                                <li><a href="student-wishlist.html"><i class="feather-bookmark"></i><span>Wishlist</span></a>
                                                </li>
                                                <li><a href="student-reviews.html"><i class="feather-star"></i><span>Reviews</span></a></li> --}}
                                                <li><a href="{{ route('user.myaccount.exam') }}"><i class="feather-help-circle"></i><span>My Quiz Attempts</span></a></li>
                                                <li><a href="{{ route('user.myaccount.order') }}"><i class="feather-shopping-bag"></i><span>Order History</span></a></li>
                                            </ul>
                                        </nav>

                                        <div class="section-title mt--40 mb--20">
                                            <h6 class="rbt-title-style-2">User</h6>
                                        </div>

                                        <nav class="mainmenu-nav">
                                            <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                <li><a href="{{ route('user.myaccount.psetting') }}"><i class="feather-settings"></i><span>Settings</span></a></li>
                                                <li><a href="{{route('user.logout')}}"><i class="feather-log-out"></i><span>Logout</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Dashboard Sidebar  -->
                    </div>
                    <div class="col-lg-9">
                        <!-- Start Enrole Course  -->
                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                            <div class="content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Order History</h4>
                                </div>

                                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                    <table class="rbt-table table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Course Name</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <th>{{$order->orderNum}}</th>
                                                <td>App Development</td>
                                                <td>{{date("F d, Y", strtotime($order->date))}}</td>
                                                <td><span class="rbt-badge-5 bg-color-success-opacity color-success">{{$order->status}}</span></td>
                                                <td>
                                                    <a target="_blank" href="{{url('/ordres-info/'.$order->orderNum)}}" class="rbt-btn btn-xs bg-primary-opacity radius-round">View details</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!-- End Enrole Course  -->
                    </div>



                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Card Style -->
<!-- ============================ Dashboard: My Order Start End ================================== -->

@endsection
