@extends('user.user_master')
@section('user_content')

<!-- ============================ Page Title Start================================== -->
	<div class="ed_detail_head">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-3">
					<img style="border-radius: 10px;" class="pro_img img-fluid w100" src="{{asset($book_info->image)}}" alt="{{$book_info->name}}">
				</div>
				<div class="col-md-9">
					<div class="ed_detail_wrap">
						<div class="ed_header_caption">
							<h2 class="ed_title">{{$book_info->name}}</h2>
						</div>
						<div class="ed_rate_info">
							<div class="star_info">
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
								<i class="fas fa-star filled"></i>
							</div>
						</div>
						<h4>৳ {{number_format($book_info->price, 2)}}</h4>
						<form method="get" action="{{route('user.checkout')}}">
						    <input type="hidden" name="productID" value="{{$book_info->id}}">
						<div class="ed_rate_info">
							<!-- Change the `data-field` of buttons and `name` of input field's for multiple plus minus buttons-->
                                <div class="input-group plus-minus-input">
                                  <div class="input-group-button">
                                    <button type="button" onclick="Qunatity_Minus()" class="button hollow circle btn btn-theme btn-rounded" data-quantity="minus" data-field="quantity">
                                      <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                  <input class="input-group-field" type="number" name="quantity" id="books_quantity" value="1" min="1">
                                  <div class="input-group-button">
                                    <button type="button" onclick="Qunatity_Plus()" class="button hollow circle btn btn-theme btn-rounded" data-quantity="plus" data-field="quantity">
                                      <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                  </div>
                                </div>
                                
							<div class="review_counter">
								<button type="submit" class="btn btn-theme btn-rounded text-light">Buy Now</a>
							</div>
							</form>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- ============================ Page Title End ================================== -->
	
	<section class="bg-light">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<!-- Overview -->
							<div class="edu_wraper">
								{!!$book_info->description!!}
							</div>
						</div>
					</div>
				</div>
			</section>
	
<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
