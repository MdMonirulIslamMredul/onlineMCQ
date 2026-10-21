@extends('user.user_master')
@section('user_content')

<!--section start-->
<section class="login-page section-big-py-space b-g-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 offset-lg-4"></div>
            <div class="col-lg-6 offset-lg-4">
                <div class="theme-card">
                    <h3 class="text-center">Update Password</h3>
                    <form class="theme-form" action="{{ route('user.pass_reset') }}" method="POST">
                        @csrf
                                <input type="hidden" name="uid" maxlength='11' value="{{$uid}}"  >
                            
                                <div class="col-md-12 form-group">
                                <label ><span class="text-danger">*</span>Enter Password( min 5 digit )</label>
                                <input type="password" class="form-control" id="" name="password" placeholder="Enter your Password" required>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label ><span class="text-danger">*</span>Confirm Password</label>
                                <input type="password" class="form-control" id="" name="password_confirmation"  required>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <h5 style="color: danger">{{session('pass')}}</h5>
                            {{-- <div class="col-md-12 form-group">
                                <label ><span class="text-danger">*</span>OTP</label>
                                <input type="text" class="form-control" id="" name="otp"  required>
                            </div> --}}
                            
                            <div class="col-md-12 form-group"><button type="submit" class="btn btn-normal">Submit</button></div>
                        </div>
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->

@endsection
