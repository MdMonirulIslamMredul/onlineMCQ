@extends('user.pages.test_master')

@push('test_style')
<style>
    .modern-blog-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }
    .modern-blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #03c6bb;
    }
    .modern-blog-thumb {
        height: 220px;
        width: 100%;
        overflow: hidden;
        background: #f1f5f9;
        position: relative;
    }
    .modern-blog-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .modern-blog-card:hover .modern-blog-thumb img {
        transform: scale(1.05);
    }
    .modern-blog-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .modern-blog-title {
        font-size: 19px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.4;
        transition: color 0.2s ease;
    }
    .modern-blog-card:hover .modern-blog-title {
        color: #03c6bb;
    }
    .modern-blog-desc {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }
</style>
@endpush

@section('content')
<!-- Start Hero Banner -->
<div class="student-hero" style="padding: 55px 0 65px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">English Articles</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-globe"></i> International Standards
                </div>
                <h1 class="student-hero-title mb-2" style="font-size: clamp(28px, 4vw, 42px);">
                    English Language & Literature Articles
                </h1>
                <p class="student-hero-desc mb-0">
                    Master English grammar, vocabulary, reading comprehension, and BCS written English tactics.
                </p>
            </div>
            <div class="col-lg-4 col-12 mt-4 mt-lg-0 text-lg-end">
                <a href="{{ route('user.blog') }}" class="rbt-btn btn-border radius-round" style="color: #fff; border-color: rgba(255,255,255,0.25);">
                    <span class="btn-text">All Articles</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Banner -->

<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-4" id="blog_body">
            @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="modern-blog-card">
                        <div class="modern-blog-thumb">
                            <a href="{{ url('/blog/'.$blog->id.'/'.$blog->url) }}">
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/about/about-01.png') }}';">
                            </a>
                            <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill" style="background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); color: #fff; font-size: 11px; font-weight: 600;">
                                {{ date('M d, Y', strtotime($blog->date)) }}
                            </span>
                        </div>
                        <div class="modern-blog-body">
                            <div class="d-flex align-items-center gap-2 mb-2 text-muted" style="font-size: 12px; font-weight: 600;">
                                <i class="feather-user text-primary" style="color: #03c6bb !important;"></i>
                                <span>Author: {{ $blog->author ?: 'English Faculty' }}</span>
                            </div>
                            <h4 class="modern-blog-title">
                                <a href="{{ url('/blog/'.$blog->id.'/'.$blog->url) }}" style="text-decoration: none; color: inherit;">
                                    {{ $blog->title }}
                                </a>
                            </h4>
                            <p class="modern-blog-desc">
                                {{ Str::limit(strip_tags($blog->description), 110) }}
                            </p>
                            <div class="mt-auto pt-3 border-top">
                                <a href="{{ url('/blog/'.$blog->id.'/'.$blog->url) }}" class="rbt-btn-link d-flex align-items-center justify-content-between text-decoration-none" style="font-weight: 700; color: #03c6bb;">
                                    <span>Read Full Article</span>
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
