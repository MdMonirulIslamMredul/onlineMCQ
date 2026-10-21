@extends('user.pages.test_master')
@section('content')

@php

$product_info = DB::table('books')->where('id', $orders_info->pid)->first();

@endphp
<!-- Start breadcrumb Area -->
<div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h2 class="title">Orders Info</h2>
                    <ul class="page-list">
                        <li class="rbt-breadcrumb-item"><a href="/">Home</a></li>
                        <li>
                            <div class="icon-right"><i class="feather-chevron-right"></i></div>
                        </li>
                        <li class="rbt-breadcrumb-item active">Orders Info</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area -->
<!-- ========================== Mission & Vission =============================== -->
<style>
    .card {
        border: none;
    }

    .card-header {
        border-bottom: none;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .list-group-item {
        background-color: transparent;
    }
</style>
<section class="checkout_area bg-color-white rbt-section-gap">
    <div class="container">
        <div class="row g-5">

                <div class="col-lg-8 col-md-12">
                    @csrf
                    <div class="card shadow-sm mb-4">
                        <div class="card-header text-white">
                            <h4 class="mb-0">Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{$orders_info->name}}</p>
                            <p><strong>Phone:</strong> {{$orders_info->phone}}</p>
                            <p><strong>Email:</strong> {{$orders_info->email}}</p>
                            <p><strong>Address:</strong> {{$orders_info->address}}</p>
                            <hr>
                            <h4>Product</h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="60%">{{ optional($product_info)->name }}</th>
                                        <td class="text-center">৳ {{$orders_info->price}} X {{$orders_info->quantity}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end" style="padding: 10px 90px;"><strong>Total:</strong> ৳ {{ number_format($orders_info->price * $orders_info->quantity, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <!-- Total Cart -->
                    <div class="card shadow-sm">
                        <div class="card-header  text-white">
                            <h4 class="mb-0">Others Info</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Date: <strong>{{ date("d M, Y", strtotime($orders_info->date)) }}</strong></li>
                                <li class="list-group-item">Order Status: <strong>{{$orders_info->status}}</strong></li>
                                <li class="list-group-item">Order Num.: <strong>{{$orders_info->orderNum}}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
		</div>
    </div>
</section>
<!-- ========================== About Facts List Section =============================== -->



@endsection
