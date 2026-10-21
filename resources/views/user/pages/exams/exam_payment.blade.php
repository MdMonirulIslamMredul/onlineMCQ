@extends('user.user_master')
@section('user_content')
@php

if($pageFrom == 'm') {
$totamMark = DB::table('mcq_questions')->where('examID', $examInfo->id)->sum('mark');
}
elseif($pageFrom == 'w') {
$totamMark = DB::table('written_questions')->where('examID', $examInfo->id)->sum('mark');
}

$userQ = DB::table('users')->where('id', $userID)->first();

$OrdersQ = DB::table('orders')->where('examID', $examInfo->id)->where('userID', $userID)->where(function($query) {
                $query->where('status', 'Processing')
                      ->orWhere('status',  'Complete');
            })
            ->first();


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
                        <p><b>Exam Name: </b> {{$examInfo->exam_name}}</p>
                        <p><b>Mark: </b> {{$totamMark}}</p>
                        <p><b>Time: </b> {{$examInfo->examTime}} min</p>
                        <p><b>Exam fees: </b>৳ {{$examInfo->tk}}</p>
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
                            <div>
                                <input type="hidden" name="amount" value="{{$examInfo->tk}}" id="total_amount">
                                <input type="hidden" name="examID" value="{{$examInfo->id}}" id="">
                                <input type="hidden" name="userID" value="{{$userQ->id}}" id="">
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            
                <div class="col-md-4 card shadow p-2 mb-3 bg-white rounded">
                    @if(!empty($OrdersQ->id))
                        @if($pageFrom == 'm')
                            <a class="btn btn-primary btn-lg btn-block" href="{{url('/running-mcq-exam/'.$examInfo->id.'/'.$examInfo->exam_name)}}">Start Exam</a>
                        @elseif($pageFrom == 'w')
                            <a class="btn btn-primary btn-lg btn-block" href="{{url('/running-written-exam/'.$examInfo->id.'/'.$examInfo->exam_name)}}">Start Exam</a>
                        @endif
                    @else
                        <h6><b>Payment Info.</b> </h6>
                        <div class="row" style="padding: 30px 5px;">
                            <div class="col-md-9 text-left col-9">
                                <p>Payable Amount</p>
                            </div>
                            <div class="col-md-3 text-right col-3">
                                <p>৳ {{$examInfo->tk}}</p>
                            </div>

                            <div class="col-md-12 text-center p6">
                            <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to Payment</button>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
            </form>
        </div>
    </div>

</section>
<!-- ========================== Articles Section =============================== -->

@endsection
