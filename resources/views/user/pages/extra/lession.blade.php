@extends('user.pages.test_master')
@section('content')
<div class="rbt-lesson-area bg-color-white">
    <div class="rbt-lesson-content-wrapper">
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
                                    Welcome Course {{ $courseInfo->name }}
                                </button>
                            </h2>
                            <div id="collapseTwo1" class="accordion-collapse collapse show" aria-labelledby="headingTwo1">
                                <div class="accordion-body card-body">
                                    <ul class="rbt-course-main-content liststyle">
                                        @foreach ($modules as $module)
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
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="accordion-item card">
                            <h2 class="accordion-header card-header" id="headingTwo4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#collapseTwo4" aria-controls="collapseTwo4">
                                    Welcome Lessons <span class="rbt-badge-5 ml--10">1/3</span>
                                </button>
                            </h2>
                            <div id="collapseTwo4" class="accordion-collapse collapse show" aria-labelledby="headingTwo4">
                                <div class="accordion-body card-body">
                                    <ul class="rbt-course-main-content liststyle">

                                        <li>
                                            <a href="lesson.html">
                                                <div class="course-content-left">
                                                    <i class="feather-play-circle"></i> <span class="text">Hello World!
                                    </span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="min-lable">0.37</span>
                                                    <span class="rbt-check"><i class="feather-check"></i></span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="course-content-left">
                                                    <i class="feather-play-circle"></i> <span class="text">Values and Variables</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="min-lable">20 min</span>
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="course-content-left">
                                                    <i class="feather-play-circle"></i> <span class="text">Basic Operators
                                    </span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="min-lable">15 min</span>
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item card">
                            <h2 class="accordion-header card-header" id="headingTwo2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#collapseTwo2" aria-controls="collapseTwo2">
                                    Histudy Quiz <span class="rbt-badge-5 ml--10">1/2</span>
                                </button>
                            </h2>
                            <div id="collapseTwo2" class="accordion-collapse collapse" aria-labelledby="headingTwo2">
                                <div class="accordion-body card-body">
                                    <ul class="rbt-course-main-content liststyle">
                                        <li>
                                            <a href="lesson-quiz.html">
                                                <div class="course-content-left">
                                                    <i class="feather-help-circle"></i> <span class="text">Histudy Quiz Start</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="lesson-quiz-result.html">
                                                <div class="course-content-left">
                                                    <i class="feather-help-circle"></i> <span class="text">Histudy Quiz Result</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item card">
                            <h2 class="accordion-header card-header" id="headingTwo3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#collapseTwo3" aria-controls="collapseTwo3">
                                    Histudy Assignments <span class="rbt-badge-5 ml--10">1/2</span>
                                </button>
                            </h2>
                            <div id="collapseTwo3" class="accordion-collapse collapse" aria-labelledby="headingTwo3">
                                <div class="accordion-body card-body">
                                    <ul class="rbt-course-main-content liststyle">
                                        <li>
                                            <a href="lesson-assignments.html">
                                                <div class="course-content-left">
                                                    <i class="feather-file-text"></i> <span class="text">Histudy Assignments</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="lesson-assignments-submit.html">
                                                <div class="course-content-left">
                                                    <i class="feather-file-text"></i> <span class="text">Histudy Assignments Submit</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="rbt-check unread"><i class="feather-circle"></i></span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}

                    </div>


                </div>
            </div>
        </div>

        <div class="rbt-lesson-rightsidebar overflow-hidden lesson-video">
            <div class="lesson-top-bar">
                <div class="lesson-top-left">
                    <div class="rbt-lesson-toggle">
                        <button class="lesson-toggle-active btn-round-white-opacity" title="Toggle Sidebar"><i class="feather-arrow-left"></i></button>
                    </div>
                    <h5>{{ $courseInfo->name }}</h5>
                </div>
                <div class="lesson-top-right">
                    <div class="rbt-btn-close">
                        <a href="{{ route('course.detail',$courseInfo->id) }}" title="Go Back to Course" class="rbt-round-btn"><i class="feather-x"></i></a>
                    </div>
                </div>
            </div>
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
            </style>
            <div class="inner">
                <div class="plyr__video-embed rbtplayer video-container">
                    <embed id="lessonIframe"   type="video/mp4">

                    {{-- <iframe id="lessonIframe" width="500" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"  allowfullscreen></iframe> --}}


                </div>

            </div>


        </div>
    </div>
</div>
 {{-- <div class="content">
                    <div class="section-title">
                        <h4>About Lesson</h4>
                        <p>Let us analyze the greatest hits of the past and learn what makes these tracks so
                            special. </p>
                    </div>
                </div> --}}
            {{-- <div class="bg-color-extra2 ptb--15 overflow-hidden">
                <div class="rbt-button-group">

                    <a class="rbt-btn icon-hover icon-hover-left btn-md bg-primary-opacity" href="#">
                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                        <span class="btn-text">Previous</span>
                    </a>

                    <a class="rbt-btn icon-hover btn-md" href="#">
                        <span class="btn-text">Next</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>

                </div>
            </div> --}}
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
               document.addEventListener('DOMContentLoaded', function() {
                    var videoLinks = document.querySelectorAll('.video-link');
                    var iframe = document.getElementById('lessonIframe');

                    videoLinks.forEach(function(link) {
                        link.addEventListener('click', function(event) {
                            event.preventDefault();
                            var moduleLink = this.getAttribute('data-link');
                            // Modify YouTube URL to embed format
                            var embedLink = moduleLink.replace('watch?v=', 'embed/');
                            iframe.src = embedLink;
                        });
                    });
                });
            </script>
@endsection
