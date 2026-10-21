@extends('user.user_master')
@section('user_content')

<!-- ========================== Articles Section =============================== -->
<section class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 card">
                <div class="center text-center mt-3">
                    <h2><span class="theme-cl">Sign</span> Up <i class="fas fa-user"></i></h2>
                </div>
                <div class="card-body">
                    <form class="theme-form" action="{{ route('user.register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12 form-group">
                                <label for="email"><span class="text-danger">*</span>Full Name</label>
                                <input type="text" class="form-control" name="name" id="fname" placeholder="Full Name"
                                    required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label><span class="text-danger">*</span>email</label>
                                <input type="text" class="form-control" name="email" id="" placeholder="Email" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 col-12 form-group">
                                <label for="review"><span class="text-danger">*</span>Phone</label>
                                <input type="text" maxlength='11' name="phone" class="form-control" required
                                    id="register_phone" placeholder="Ex: 01627382866">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label><span class="text-danger">*</span>Password (min 5 character)</label>
                                <input type="password" class="form-control" name="password" id=""
                                    placeholder="Enter your password" required>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label><span class="text-danger">*</span>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id=""
                                    placeholder="" required>
                            </div>
                            <div class="col-md-12 form-group"><button type="submit"
                                    class="btn btn-md full-width pop-login">create
                                    Account</button></div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12 ">
                                <p>Have you already account? <a href="" data-toggle="modal" data-target="#login" class="theme-cl">click</a> here to
                                    &nbsp;<a href="" data-toggle="modal" data-target="#login" class="theme-cl">Login</a></p>
                            </div>
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
