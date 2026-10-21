@extends('user.user_master')
@section('user_content')
<style>

 label {
	 display: flex;
	 cursor: pointer;
	 font-weight: 500;
	 position: relative;
	 overflow: hidden;
	 margin-bottom: 0.375em;
	/* Accessible outline */
	/* Remove comment to use */
	/* &:focus-within {
		 outline: .125em solid $primary-color;
	}
	 */
}
 label input {
	 position: absolute;
	 left: -9999px;
}
 label input:checked + span {
	 background-color: #d6d6e5;
}
 label input:checked + span:before {
	 box-shadow: inset 0 0 0 0.4375em #00005c;
}
 label span {
	 display: flex;
	 align-items: center;
	 padding: 0.375em 0.75em 0.375em 0.375em;
	 border-radius: 99em;
	 transition: 0.25s ease;
}
 label span:hover {
	 background-color: #d6d6e5;
}
 label span:before {
	 display: flex;
	 flex-shrink: 0;
	 content: "";
	 background-color: #fff;
	 width: 1.5em;
	 height: 1.5em;
	 border-radius: 50%;
	 margin-right: 0.375em;
	 transition: 0.25s ease;
	 box-shadow: inset 0 0 0 0.125em #00005c;
}


</style>
@php

$product_info = DB::table('subscriptions')->where('id', $pid)->first();

$userID = Cookie::get('user_id');

$user_info = DB::table('users')->where('id', $userID)->first();



@endphp
<!-- ========================== Mission & Vission =============================== -->
<section class="bg-light">
    <div class="container" style="padding-bottom: 20px">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumbs-wrap">
                    <h3 class="breadcrumb-title PaulTitle">Checkout</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
			<div class="col-lg-8 col-md-12">
			<form method="post" action="{{ url('/buybook/pay') }}">
			{{-- <form method="post" action="{{route('user.confirm.checkout')}}"> --}}
			    @csrf
				<div class="cart_totals checkout light_form mb-4">
					<h4>Billing info</h4>
					<div class="row">

						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" name="name" value="{{optional($user_info)->name}}" class="form-control" required>
								@error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
						</div>

						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label>Email Address</label>
								<input type="email" name="email" value="{{optional($user_info)->email}}" class="form-control" required>
								@error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
						</div>

						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<label>Phone Number</label>
								<input type="text" name="phone" value="{{optional($user_info)->phone}}" class="form-control" required>
								@error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
						</div>

						<div class="col-lg-12 col-md-12">
							<div class="form-group">
								<label>Address</label>
								<input type="text" name="address" value="{{optional($user_info)->address}}" class="form-control" required>
								@error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
						</div>
							<div class="col-lg-12 col-md-12">
							<div class="form-group">

								<input type="checkbox" name="agree"   required>
							I agree to the	 <a href="{{ route('user.return_and_refund_policy') }}">return policy</a> &
                         <a href="{{ route('user.privacy_and_policy') }}">privacy policy</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" name="pid" value="{{optional($product_info)->id}}">
			<input type="hidden" name="quantity" value="{{$quantity ?? null}}">
			<input type="hidden" name="price" value="{{$product_info->price}}">


			<div class="col-lg-4 col-md-12">
				<!-- Total Cart -->
				<div class="cart_totals checkout">
					<h4>Order Summary</h4>
					<div class="cart-wrap">
					    <div class="row">
					        <div class="col-md-8 col-8">
					            {{$product_info->name}}
					        </div>
					        <div class="col-md-4 col-4">
					           ৳ {{$product_info->price}} X {{$quantity}}
					        </div>
					    </div>
						<div class="flex_cart">
							<div class="flex_cart_1">
								Total Cost
							</div>
							<div class="flex_cart_2">
								৳ {{number_format($product_info->price*$quantity, 2)}}
							</div>
						</div>
						<label>
							<input type="radio" name="radio" required value="cash"/>
							<span>Cash On</span>
						</label>
						<label>
							<input type="radio" name="radio" required value="online"/>
							<span>Online Payment</span>
						</label>
						<button type="submit" class="btn checkout_btn">Confirm Order</button>
					</div>
				</div>
			</div>
			</form>
		</div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
