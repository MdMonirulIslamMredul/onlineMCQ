@extends('cms.cms_master')
@section('admin_content')
    <section class="section">
        <div class="section-header">
            <h1>Reset Password</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <form class="form" action="{{ route('cms.update.student', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column"> Student
                                                Name</label>
                                            <input type="text" value="{{ $student->name }}" id="name"
                                                class="form-control" placeholder="" name="name" disabled />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="first-name-column">
                                                Email</label>
                                            <input type="email" value="{{ $student->email }}" id="email"
                                                class="form-control" placeholder="" name="email" disabled />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="first-name-column">
                                                Phone</label>
                                            <input type="number" value="{{ $student->phone }}" id="phone"
                                                class="form-control" placeholder="" name="phone" disabled />
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="first-name-column"> <span
                                                    class="text-danger">*</span>Password</label>
                                            <input type="password" value="" id="password" class="form-control"
                                                placeholder="Enter New Password" name="password" />
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success form-control">Update</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
