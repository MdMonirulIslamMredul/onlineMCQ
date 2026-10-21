@extends('user.user_master')
@section('user_content')

<!--section start-->
<section class="login-page section-big-py-space b-g-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 offset-lg-4"></div>
            <div class="col-lg-6 offset-lg-4">
                <div class="theme-card">
                    <h3 class="text-center">Verify Account</h3>
                    <p>We have send an OTP code in your phone. Please Verify your Account</p>
                    <form class="theme-form" action="{{ route('admin.verify.otp') }}" method="POST">
                        @csrf
                                <input type="hidden" name="uid"  value="{{$uid}}"  >
                               
                            
                            <div class="col-md-12 form-group">
                                <label ><span class="text-danger">*</span>Enter OTP</label>
                                <input type="text" class="form-control" id="" name="otp" placeholder="Enter your OTP" required>
                            </div>
                            
                            <div class="col-md-12 form-group"><button type="submit" class="btn btn-danger">Verify</button></div>
                        </div>
                       
                    </form>
                    <form class="theme-form" action="{{ route('admin.pass_set_step_one') }}" method="POST">
                        @csrf
                    <div class="row g-3">
                        <div class="col-md-12 ">
                            <h5 style="color: danger">{{session('pass')}}</h5>
                            <input type="hidden" name="email" value="{{$email}}">
                            <p>OTP Not Matched? or Not Sent? <span style="cursor: pointer;" class="txt-default"><button type="submit" class="btn btn-primary">Send Again</button></span></p>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->

@endsection


