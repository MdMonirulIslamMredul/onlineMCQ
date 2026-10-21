@extends('user.user_master')
@section('user_content')

<!--slider start-->
@include('user.pages.body.slider')
<!--slider end-->

@php
    $categories = DB::table('categories')->where('active', 1)->get();
    $courses = DB::table('courses')->where('active', 1)->get();
    $blogs = DB::table('blogs')->orderBy('id', 'desc')->limit(3)->get();
    $teachers = DB::table('teachers')->where('active', 1)->orderBy('id', 'desc')->limit(5)->get();
    $about_info =  DB::table('about_infos')->first();
    $freeExams = DB::table('exams')->where('free_paid', 'free')->where('active', 1)->limit(8)->get();
@endphp

<!-- ========================== Featured Category Section =============================== -->
    <div class="container mt-4 mb-3">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="center text-center">
                    <h2><span class="theme-cl">Popular</span> Category For Learning</h2>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            @foreach($categories as $category)
            @php
                $examCount = DB::table('exams')->where('catID', $category->id)->where('active', 1)->count();
                $url = str_replace(" ","-", $category->name);
            @endphp
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="edu_cat_2 cat-1">
                    <div class="edu_cat_icons">
                        <a class="pic-main" href="{{url('/category/'.$category->id.'/'.$url)}}"><img style="border-radius: 20px;" src="{{asset($category->image)}}" class="img-fluid" alt="{{$category->name}}"></a>
                    </div>
                    <div class="edu_cat_data">
                        <h4 class="title"><a href="{{url('/category/'.$category->id.'/'.$url)}}">{{$category->name}}</a></h4>
                        <ul class="meta">
                            <li class="video"><i class="ti-video-clapper"></i>{{$examCount}} Exams</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>

<!-- ========================== Featured Category Section =============================== -->

<!-- ========================== About Facts List Section =============================== -->
<section class="bg-light">
    <div class="container">
    <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="list_facts_wrap">
                    <div class="sec-heading mb-3">
                    <h2>About <span class="theme-cl">English Explorers</span></h2>
                    </div>
                    <div class="text-justify">
                     {{substr(strip_tags($about_info->aboutDes), 0, 250)}}....
                    </div>
                    <div class="cource_facts">
                        <a href="{{route('user.about_us')}}" class="btn btn-modern">Know More<span><i class="ti-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="list_facts_wrap_img text-center">
                    <img src="{{ asset(optional($about_info)->image) }}" width="70%" class="img-fluid" alt="{{substr(strip_tags($about_info->aboutDes), 0, 250)}}">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!-- ========================== Quick Test =============================== -->
<div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="center text-center">
                    <h2><span class="theme-cl">Quick</span> Test <i class="fas fa-brain"></i></h2>
                </div>
            </div>
        </div>
        <br>
        <div class="p-50">
        <div class="row">
            @foreach($freeExams as $exam)
            @php
                $Eurl = str_replace(" ","-", $exam->exam_name);
                $key = rand(10000, 199999);
            @endphp
            <div class="col-md-6">
                <div class="individualExam">
                    <a href="{{url('/start-mcq-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">
                        <h5 class="indviExamA">{{$exam->exam_name}}</h5>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>

<!-- ========================== Quick Test =============================== -->


<!-- ========================== Articles Section =============================== -->
<section class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="sec-heading center">
                    <h2><span class="theme-cl">Recent</span> Articles</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($blogs as $blog)
                <!-- Single Article -->
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="articles_grid_style">
                        <div class="articles_grid_thumb">
                            <a href="{{url('/blog/'.$blog->id.'/'.$blog->url)}}"><img src="{{asset($blog->image)}}" class="img-fluid" alt="{{$blog->alt}}"></a>
                        </div>

                        <div class="articles_grid_caption">
                            <a href="{{url('/blog/'.$blog->id.'/'.$blog->url)}}"><h4>{{$blog->title}}</h4></a>
                            <div class="articles_grid_author">
                                <h4><span class="theme-cl text-bold">Author: </span> {{$blog->author}}, <span class="theme-cl text-bold">Date:</span> {{date('d M, Y', strtotime($blog->date))}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ========================== Articles Section =============================== -->


<!-- ============================ Featured Instructor Start ================================== -->
<section class="pt-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="center text-center">
                    <h2><span class="theme-cl">Top & Famous</span> Instructor</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="four_slide-dots articles arrow_middle">
                    @foreach($teachers as $teacher)
                    <div class="singles_items">
                            <div class="instructor_wrap">
                                <div class="instructor_thumb">
                                    <a href="javascript: void(0)"><img src="{{$teacher->image}}" class="img-fluid"
                                            alt="{{$teacher->name}}"></a>
                                </div>
                                <div class="instructor_caption">
                                    <h4><a href="javascript: void(0)">{{$teacher->name}}</a></h4>
                                    <span>{{$teacher->subject}}</span>
                                    <ul>
                                        <span>{{$teacher->job_title}}</span>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ============================ Featured Instructor End ================================== -->

@endsection
