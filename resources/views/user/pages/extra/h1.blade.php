@extends('user.user_master')
@section('user_content')

<!-- ========================== Mission & Vission =============================== -->
<section class="bg-light">
    <div class="container" style="padding-bottom: 20px">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumbs-wrap">
                    <h3 class="breadcrumb-title PaulTitle">Mission & Vission</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mission & Vission</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 col-sm-12 breadcrumb">
                <h3>Mission & Vission</h3>
                <p></p>


            </div>
        </div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
