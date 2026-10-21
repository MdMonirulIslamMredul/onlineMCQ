@extends('user.pages.test_master')

@push('frontend_style')
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
    }

    .video-container iframe,
    .video-container embed,
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    @media (max-width: 768px) {
        .video_portion {
            display: none; /* Hide the fixed position container on mobile */
        }

        .video-modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.8); /* Black background with opacity */
        }

        .video-modal-content {
            background-color: #000;
            margin: 15% auto; /* Center modal */
            padding: 0;
            border: 1px solid #888;
            width: 90%; /* 90% of screen width */
            max-width: 900px;
            height: 80%; /* Set height */
            position: relative;
        }

        .video-modal-content iframe {
            width: 100%;
            height: 100%;
        }

        .close {
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover {
            color: #ddd;
        }
    }
</style>
@endpush

@section('content')
<div class="rbt-lesson-area bg-color-white">
    <div class="rbt-lesson-content-wrapper">
        <div class="rbt-lesson-rightsidebar video_portion overflow-hidden lesson-video">
            <div class="lesson-top-bar">
                <div class="lesson-top-left">
                    <div class="rbt-lesson-toggle">
                        <button class="lesson-toggle-active btn-round-white-opacity" title="Toggle Sidebar">
                            <i class="feather-arrow-left"></i>
                        </button>
                    </div>
                    <h5>{{ $courseInfo->name ?? 'Course Title' }}</h5>
                </div>
                <div class="lesson-top-right">
                    <div class="rbt-btn-close">
                        <a href="{{ route('course.detail', ['id' => $courseInfo->id]) }}" title="Go Back to Course" class="rbt-round-btn">
                            <i class="feather-x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
                <div class="plyr__video-embed rbtplayer video-container">
                    <embed id="lessonIframe" type="video/mp4">
                    {{-- <iframe id="lessonIframe" width="500" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> --}}
                </div>
            </div>
        </div>

        <div class="rbt-lesson-leftsidebar">
            <div class="rbt-course-feature-inner rbt-search-activation">
                <div class="section-title">
                    <h4 class="rbt-title-style-3">Course Content</h4>
                </div>

                <div class="lesson-search-wrapper">
                    <form action="#" class="rbt-search-style-1">
                        <input class="rbt-search-active" type="text" placeholder="Search Lesson">
                        <button class="search-btn disabled"><i class="feather-search"></i></button>
                    </form>
                </div>

                <hr class="mt--10">

                <div class="rbt-accordion-style rbt-accordion-02 for-right-content accordion">
                    <div class="accordion" id="accordionExampleb2">
                        <div class="accordion-item card">
                            <h2 class="accordion-header card-header" id="headingTwo1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#collapseTwo1" aria-controls="collapseTwo1">
                                    Welcome Course {{ $courseInfo->name ?? 'Course Title' }}
                                </button>
                            </h2>
                            <div id="collapseTwo1" class="accordion-collapse collapse show" aria-labelledby="headingTwo1">
                                <div class="accordion-body card-body">
                                    <ul class="rbt-course-main-content liststyle">
                                        @forelse ($modules as $module)
                                            <li>
                                                <a href="#" class="video-link" data-link="{{ $module->link }}">
                                                    <div class="course-content-left">
                                                        <i class="feather-play-circle"></i> <span class="text">{{ $module->title }}</span>
                                                    </div>
                                                    <div class="course-content-right">
                                                        <span class="min-lable"></span>
                                                        <span class="rbt-check"><i class="feather-check"></i></span>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                            <li>No videos found</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Video Modal -->
    <div id="videoModal" class="video-modal">
        <div class="video-modal-content">
            <span class="close">&times;</span>
            <iframe id="modalIframe" width="100%" height="100%" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var videoLinks = document.querySelectorAll('.video-link');
            var videoModal = document.getElementById('videoModal');
            var modalIframe = document.getElementById('modalIframe');
            var closeModal = document.querySelector('.close');

            videoLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    var moduleLink = this.getAttribute('data-link');
                    var embedLink = moduleLink.replace('watch?v=', 'embed/');
                    if (window.innerWidth <= 768) { // Check if the screen width is 768px or less
                        modalIframe.src = embedLink;
                        videoModal.style.display = "block";
                    } else {
                        var iframe = document.getElementById('lessonIframe');
                        iframe.src = embedLink;
                    }
                });
            });

            closeModal.addEventListener('click', function() {
                videoModal.style.display = "none";
                modalIframe.src = ""; // Stop the video when modal is closed
            });

            window.addEventListener('click', function(event) {
                if (event.target == videoModal) {
                    videoModal.style.display = "none";
                    modalIframe.src = ""; // Stop the video when clicking outside
                }
            });
        });
    </script>
@endsection
