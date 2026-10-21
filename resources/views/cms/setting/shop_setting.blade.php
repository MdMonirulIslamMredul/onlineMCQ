@extends('cms.cms_master')
@section('admin_content')

@php
$company_info = DB::table('company_settings')->first();

@endphp

<section class="section">
    <div class="section-header">
        <h1>Company Settings</h1>
        @if(!empty($company_info->id))
        <div class="section-header-breadcrumb">
            <a href="{{ url('/cms/edit-company-setting/'.$company_info->id) }}" class="btn btn-warning btn-sm">Edit</a>
        </div>
        @endif
    </div>

    <div class="row">
        @if(!empty($company_info->id))
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Company Info</h4>
                        </div>
                        <div class="card-body">
                            <div class="author-box-center text-center">
                                <img alt="image" src="{{ asset($company_info->logo) }}" class="rounded author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <h4><b>{{ $company_info->company_name }}</b></h4>
                                </div>
                                <div class="author-box-job">{{ $company_info->address }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                    <div class="card">

                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Phone 1 :
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $company_info->phone_1 }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        phone 2 :
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $company_info->phone_2 }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Email :
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $company_info->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Counter :
                                    </span>
                                    <span class="float-right text-muted">
                                       Total Learners : {{ $company_info->count1 }}, </br>
                                       Total Courses & Video : {{ $company_info->count2 }}, </br>
                                       Certified Students : {{ $company_info->count3 }}, </br>
                                       Registered Enrolls : {{ $company_info->count4 }}



                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Facebook :
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="{{ $company_info->facebook }}">{{ $company_info->facebook }}</a>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Youtube :
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="">{{ $company_info->youtube }}</a>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Instagram :
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="#">{{ $company_info->instagram }}</a>
                                    </span>
                                </p>

                                <p class="clearfix">
                                    <span class="float-left">
                                        Twitter :
                                    </span>
                                    <span class="float-right text-muted">
                                        <a href="#">{{ $company_info->twitter }}</a>
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Footer Credit :
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $company_info->footer_credit }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Footer Description :
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $company_info->footer_des }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Others Info</b></h4>
                        </div>
                        <div class="card-body">
                            <h6 class="text-info"><b>Privacy & Policy: </b></h6>
                            {!!$company_info->privacy_policy!!}
                            <br>
                            <h6 class="text-info"><b>Mission & Vision: </b></h6>
                            {!!$company_info->mission_and_vission!!}

                            <br>
                            <h6 class="text-info"><b>Terms And Conditions: </b></h6>
                            {!!$company_info->trams_and_condition!!}


                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @else
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('company_info_set') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Company Name</label>
                                <input type="text" class="form-control" id="" required name="company_name"
                                    placeholder="Ex: FARA IT Fusion">
                                @error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4"><span class="text-danger">*</span>Address</label>
                                <input type="text" name="address" class="form-control" required id=""
                                    placeholder="Ex: Company Address">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress"><span class="text-danger">*</span>Phone 1</label>
                                <input type="text" class="form-control" name="phone_1" required minlength="11"
                                    maxlength="11" id="" placeholder="Ex: 01627382866">
                                @error('phone_1')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Phone 2</label>
                                <input type="text" minlength="11" maxlength="11" name="phone_2" class="form-control"
                                    id="" placeholder="Ex: 01627382866">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity"><span class="text-danger">*</span>Email</label>
                                <input type="email" class="form-control" required name="email" id=""
                                    placeholder="Ex: info@gmail.com">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState"><span class="text-danger">*</span>Logo (210 X 66)</label>
                                <input type="file" name="logo" required class="form-control" id="">
                                @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Facebook link</label>
                                <input type="text" class="form-control" name="facebook" id="" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Youtube link</label>
                                <input type="text" name="youtube" class="form-control" id="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Instagram link</label>
                                <input type="text" name="instagram" class="form-control" id="" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Twitter link</label>
                                <input type="text" name="twitter" class="form-control" id="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputState"><b>Privacy Policy</b></label>
                            <textarea name="editor1"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputState"><b>Mission & Vission</b></label>
                            <textarea name="editor2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputState"><b>Terms & Condition</b></label>
                            <textarea name="editor3"></textarea>
                        </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="form-control btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
        </div>

        @endif
    </div>

</section>

@endsection
