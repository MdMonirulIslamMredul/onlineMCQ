@extends('user.user_master')
@section('user_content')

@php
    $info = DB::table('learning_english_setting')->first();
@endphp

<!-- ========================== Mission & Vission =============================== -->
<section class="bg-light">
    <div class="container" style="padding-bottom: 20px">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumbs-wrap">
                    <h3 class="breadcrumb-title PaulTitle">Learning English</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Learning English</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 breadcrumb" style="margin: auto;">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <img width="100%" src="{{asset($info->image)}}" class="rounded">
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            
            <div class="col-md-12 breadcrumb">
                {!!$info->text!!}
            </div>
            
        </div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
