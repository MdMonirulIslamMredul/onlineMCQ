@extends('user.user_master')
@section('user_content')

<!-- ========================== Articles Section =============================== -->
<section class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 card">
                <div class="center text-center mt-3">
                    <h2><span class="theme-cl">Password</span> Reset</h2>
                </div>
                <div class="card-body">
                    <form class="theme-form" action="{{ route('admin.pass_set_step_one') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12 form-group">
                                <label for="email"><span class="text-danger">*</span>Enter Your Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Ex: cse.ridoypaul@gmail.com"
                                    required>
                            </div>
                        </div>
                        <h5 style="color: danger">{{session('pass')}}</h5>
                        <div class="row g-3">
                            <div class="col-md-12 form-group"><button type="submit"
                                    class="btn btn-md full-width pop-login">Submit</button></div>
                        </div>
                        <div class="row g-3">
                            
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>
<!-- ========================== Articles Section =============================== -->

@endsection
