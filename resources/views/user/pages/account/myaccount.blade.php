@extends('user.user_master')
@section('user_content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name');
$userQ = DB::table('users')->where('id', $userID)->first();

$attendExams = DB::table('results')
->join('exams', 'results.examID', 'exams.id')
->select('results.*', 'exams.exam_name')
->where('results.userID', $userQ->id)
->latest()->get();

$orders = DB::table('books_order')->where('phone', $userQ->phone)->orWhere('email', $userQ->email)->orderBy('id', 'desc')->get();


@endphp

<!-- ============================ Dashboard: My Order Start ================================== -->
<section class="gray pt-0">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-3 col-md-3 p-0">
                <div class="dashboard-navbar">
                    <div class="d-user-avater">
                        <i style="font-size: 105px; color: #6C63FF;" class="fas fa-user-circle"></i>
                        <h4>{{$userName}}</h4>
                        <span></span>
                    </div>

                    <div class="d-navigation">
                        <ul id="side-menu">
                            <li class="active"><a href="{{route('user.myaccount')}}"><i class="ti-heart"></i>My
                                    Profile</a></li>
                            <li><a href="{{route('user.logout')}}"><i class="ti-power-off"></i>Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-12">

                <!-- Row -->
                <div class="row align-items-center mt-3">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_body p-4">
                                <div class="viewer_detail_wraps">
                                    <div class="caption">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill"
                                                    href="#pills-profile" role="tab" aria-controls="pills-profile"
                                                    aria-selected="false">Profile</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                                                    href="#pills-contact" role="tab" aria-controls="pills-contact"
                                                    aria-selected="false">Setting</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-exam-tab" data-toggle="pill"
                                                    href="#pills-exams" role="tab" aria-controls="pills-contact"
                                                    aria-selected="false">Exams</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-exam-tab" data-toggle="pill"
                                                    href="#pills-orders" role="tab" aria-controls="pills-contact"
                                                    aria-selected="false">Orders</a>
                                            </li>
                                            

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab">
                                                <div class="viewer_header">
                                                    <h4>{{$userName}}</h4>
                                                    <ul>
                                                        <li><strong>Address: </strong> @if(!empty($userQ->address))
                                                            {{$userQ->address}} @else Not Set @endif</li><br>
                                                        <li><strong>Phone: </strong> {{$userQ->phone}}</li><br>
                                                        <li><strong>Email: </strong> {{$userQ->email}}</li><br>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                                aria-labelledby="pills-contact-tab">
                                                <form action="{{url('/update-userprofile/'.$userQ->id)}}" method="post">
                                                    @csrf
                                                    <div class="row card-body">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1"><span
                                                                        class="text-danger">*</span> Name</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    id="" value="{{$userQ->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1"><span
                                                                        class="text-danger">*</span>Email</label>
                                                                <input type="email" class="form-control" readonly id=""
                                                                    value="{{$userQ->email}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1"><span
                                                                        class="text-danger">*</span> Phone</label>
                                                                <input type="text" class="form-control" readonly id=""
                                                                    value="{{$userQ->phone}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1"><span
                                                                        class="text-danger">*</span>Address</label>
                                                                <input type="text" name="address" class="form-control"
                                                                    id="" value="{{$userQ->address}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit"
                                                                class="btn btn-md full-width pop-login">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="pills-exams" role="tabpanel"
                                                aria-labelledby="pills-exam-tab">
                                                <div class="viewer_header">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Exam Name</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															@foreach($attendExams as $resultExam)
															<tr>
                                                                <td>{{$resultExam->exam_name}}</td>
                                                                <td>
																	@if($resultExam->mcq_written == 'mcq')
																	<a target="_blank" href="{{url('/mcq-result/'.$resultExam->examID.'/'.$resultExam->exam_name)}}" class="btn btn-primary btn-sm">View Result</a>
																	@elseif($resultExam->mcq_written == 'written' && $resultExam->written_status == 'pending')
																		<p>Exam is Pending</p>
																	@else
																	<a target="_blank" href="{{url('/written-result/'.$resultExam->examID.'/'.$resultExam->exam_name)}}" class="btn btn-primary btn-sm">View Result</a>
																	@endif
																</td>
                                                            </tr>
															@endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-orders" role="tabpanel"
                                                aria-labelledby="pills-exam-tab">
                                                <div class="viewer_header">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Order Num</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															@foreach($orders as $order)
															<tr>
                                                                <td>{{$order->orderNum}}</td>
                                                                <td>{{date("d M, Y", strtotime($order->date))}}</td>
                                                                <td>{{$order->status}}</td>
                                                                <td><a target="_blank" href="{{url('/ordres-info/'.$order->orderNum)}}" class="btn btn-primary btn-sm">View details</a></td>
                                                            </tr>
															@endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
























                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
            </div>
        </div>
        <!-- Row -->
    </div>
</section>
<!-- ============================ Dashboard: My Order Start End ================================== -->

@endsection
