@extends('user.pages.test_master')

@section('content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name') ?: 'Student';
$userQ = DB::table('users')->where('id', $userID)->first();
@endphp

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 22px 0 24px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li><a href="{{ route('user.myaccount.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #007A55; font-weight: 600;">My E-Books</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-book"></i> Digital Library
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(26px, 3.5vw, 38px);">
                    My E-Books (অনলাইন লাইব্রেরি)
                </h1>
                <p class="student-hero-desc mb-0">
                    আপনার ক্রয়কৃত ডিজিটাল ই-বুকসমূহ সরাসরি অনলাইনে পড়তে নিচের বইগুলো নির্বাচন করুন।
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('shop') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.06);">
                    <i class="feather-shopping-bag me-1"></i> Browse More Books
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Area -->

<!-- Start Dashboard Content Area -->
<div class="rbt-dashboard-area rbt-section-gapBottom bg-color-white">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 col-md-12">
                @include('user.pages.account.sidebar')
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
                    <div class="content">
                        <div class="section-title mb-4 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h4 class="rbt-title-style-3 mb-1">Purchased E-Books</h4>
                                <p class="text-muted small mb-0">Protected online reading only (Anti-Piracy DRM enabled).</p>
                            </div>
                            <span class="badge px-3 py-2 rounded-pill" style="background: rgba(0, 122, 85, 0.1); color: #007A55; font-weight: 700; font-size: 13px;">
                                Total: {{ $myBooks->count() }} E-Books
                            </span>
                        </div>

                        @if($myBooks->count() > 0)
                            <div class="row g-4">
                                @foreach($myBooks as $item)
                                    <div class="col-lg-4 col-md-6 col-12 d-flex">
                                        <div class="modern-course-card w-100 d-flex flex-column" style="border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.04); background: #ffffff;">
                                            <div class="modern-course-thumb" style="height: 220px; position: relative; background: #f8fafc; overflow: hidden;">
                                                <a href="{{ route('user.book.read', $item->book_id) }}">
                                                    <img src="{{ asset($item->book_image) }}" alt="{{ $item->book_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('frontend/assets/images/course-cat-default.jpg') }}'">
                                                </a>
                                                <span class="modern-course-badge-top" style="background: rgba(0, 122, 85, 0.9); backdrop-filter: blur(4px); color: #fff; font-size: 11.5px; font-weight: 700;">
                                                    <i class="feather-book-open"></i> E-Book (PDF)
                                                </span>
                                            </div>
                                            <div class="modern-course-body p-3 d-flex flex-column flex-grow-1">
                                                <div class="text-muted small mb-2 d-flex align-items-center justify-content-between">
                                                    <span><i class="feather-calendar me-1"></i> {{ date('d M, Y', strtotime($item->date)) }}</span>
                                                    <span class="badge bg-success-opacity text-success" style="font-size: 11px;">#{{ $item->orderNum }}</span>
                                                </div>
                                                <h5 class="modern-course-title mb-3" style="font-size: 16px; font-weight: 700; line-height: 1.4; min-height: 44px;">
                                                    <a href="{{ route('user.book.read', $item->book_id) }}" style="color: #0f172a; text-decoration: none;">
                                                        {{ $item->book_name }}
                                                    </a>
                                                </h5>
                                                <div class="mt-auto pt-3 border-top">
                                                    <a href="{{ route('user.book.read', $item->book_id) }}" class="rbt-btn btn-sm btn-gradient w-100 text-center radius-round" style="padding: 9px 16px; font-weight: 700;">
                                                        <i class="feather-eye me-1"></i> Read Online
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(0, 122, 85, 0.1); color: #007A55; display: inline-flex; align-items: center; justify-content: center; font-size: 32px;">
                                    <i class="feather-book"></i>
                                </div>
                                <h4 class="mb-2" style="font-weight: 700; color: #1e293b;">কোনো ডিজিটাল ই-বুক পাওয়া যায়নি</h4>
                                <p class="text-muted mx-auto mb-4" style="max-width: 480px; font-size: 14.5px;">
                                    আপনি এখনো কোনো ই-বুক (সফটকপি) ক্রয় করেননি। বইয়ের সেকশন থেকে আপনার প্রয়োজনীয় বইয়ের সফটকপি ক্রয় করে সাথে সাথেই অনলাইনে পড়তে পারবেন।
                                </p>
                                <a href="{{ route('shop') }}" class="rbt-btn btn-sm btn-gradient radius-round">
                                    <span class="btn-text">বইসমূহ দেখুন</span> <i class="feather-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

