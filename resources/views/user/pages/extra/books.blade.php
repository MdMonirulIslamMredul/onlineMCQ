@extends('user.user_master')
@section('user_content')

<!-- ========================== Mission & Vission =============================== -->
<section class="bg-light">
    <div class="container" style="padding-bottom: 20px">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumbs-wrap">
                    <h3 class="breadcrumb-title PaulTitle">Books</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Books</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($books as $book)
                <div class="col-md-3 col-12">
					@if ($book->active==1)
                    <div class="education_block_grid style_2">
						<div class="education_block_thumb">
							<a href="{{url('/book-details/'.$book->id.'/'.$book->name)}}"><img src="{{asset($book->image)}}" width="100%" class="img-fluid" alt="{{$book->name}}"></a>
						</div>
						<div class="education_block_body text-center">
							<h6 class=""><a href="{{url('/book-details/'.$book->id.'/'.$book->name)}}">{{$book->name}}</a></h6>
						</div>
						<div class="education_block_footer">
							<div class="education_block_author">
								<div class="cources_info_last">
    								<h4>৳ {{number_format($book->price, 2)}}</h4>
    							</div>
							</div>
							<a href="{{url('/book-details/'.$book->id.'/'.$book->name)}}" class="btn btn-theme btn-rounded text-light">Details</a>
						</div>
						
					</div>
                        
                    @endif	
				</div>
            @endforeach
        </div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
