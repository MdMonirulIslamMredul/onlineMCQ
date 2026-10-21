@extends('user.user_master')
@section('user_content')
@php

$userQ = DB::table('users')->where('id', $userID)->first();

@endphp
<!--==========================Articles
    Section===============================-->
<section class="bg-light">
    <div class="container card">
        <div class="card-header">
        <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow p-2 mb-3 bg-white rounded">
                        <p><b>Category Name: </b> {{$catInfo->name}}</p>
                        <p><b>Fees: </b>৳ {{$catInfo->tk}}</p>
                    </div>
                    <div class="card shadow p-2 mb-3 bg-white rounded">
                        <div class="class-header text-center">
                            <p class="h5">-- Student Info --</p>
                            <hr>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{$userQ->name}}" readonly id="customer_name" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="phone" class="form-control" name="customer_mobile" value="{{$userQ->phone}}"  readonly id="mobile" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="customer_email" value="{{$userQ->email}}"  readonly id="email" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{$userQ->address}}" id="address" placeholder="">
                                </div>
                            </div>
                            
                            	<div class="col-lg-12 col-md-12">
							<div class="form-group">
							
								<input type="checkbox" name="agree"   required>
							I agree to the	 <a href="{{ route('user.return_and_refund_policy') }}">return policy</a> &
                         <a href="{{ route('user.privacy_and_policy') }}">privacy policy</a>
							</div>
						</div>
                            <div>
                                <input type="hidden" name="amount" value="{{$catInfo->tk}}" id="total_amount">
                                <input type="hidden" name="examID" value="{{$catInfo->id}}" id="">
                                <input type="hidden" name="userID" value="{{$userQ->id}}" id="">
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            
                <div class="col-md-4 card shadow p-2 mb-3 bg-white rounded">
                        <h6><b>Payment Info.</b> </h6>
                        <div class="row" style="padding: 30px 5px;">
                            <div class="col-md-9 text-left col-9">
                                <p>Payable Amount</p>
                            </div>
                            <div class="col-md-3 text-right col-3">
                                <p>৳ {{$catInfo->tk}}</p>
                            </div>

                            <div class="col-md-12 text-center p6">
                            <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to Payment</button>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</section>
<!-- ========================== Articles Section =============================== -->

@endsection
