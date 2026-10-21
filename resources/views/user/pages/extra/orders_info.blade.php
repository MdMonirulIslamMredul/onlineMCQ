@extends('user.user_master')
@section('user_content')

@php

$product_info = DB::table('books')->where('id', $orders_info->pid)->first();

@endphp
<!-- ========================== Mission & Vission =============================== -->
<section class="bg-light">
    <div class="container" style="padding-bottom: 20px">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumbs-wrap">
                    <h3 class="breadcrumb-title PaulTitle">Orders Info</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Orders Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
			<div class="col-lg-8 col-md-12">
			    @csrf
				<div class="cart_totals checkout light_form mb-4">
				    <h4>Order Summary</h4>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							Name: {{$orders_info->name}}<br>
							Phone: {{$orders_info->phone}}<br>
							Email: {{$orders_info->email}}<br>
							Address: {{$orders_info->address}}<br>
						</div>
						<hr>
						<div class="col-lg-12 col-md-12">
							<table class="table">
                              <tbody>
                                <tr>
                                  <th width="60%">{{optional($product_info)->name}}</th>
                                  <td class="text-center">৳ {{$orders_info->price}} X {{$orders_info->quantity}} </td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-right flex_cart_1">Total = ৳ {{number_format($orders_info->price*$orders_info->quantity, 2)}}</td>
                                </tr>
                              </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
			
		
			
			<div class="col-lg-4 col-md-12">
				<!-- Total Cart -->
				<div class="cart_totals checkout">
					<h4>Others Info-</h4>
					<div class="cart-wrap">
					    <ul class="cart_list">
							<li>Date: <strong>{{date("d M, Y", strtotime($orders_info->date))}}</strong></li>
							<li>Order Status<strong>{{$orders_info->status}}</strong></li>
							<li>Order Num.<strong>{{$orders_info->orderNum}}</strong></li>
						</ul>
						<div class="flex_cart">
							<div class="flex_cart_2">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->

<!--Include Newsletter-->
@include('user.pages.newsletter')
<!--Include Newsletter-->

@endsection
