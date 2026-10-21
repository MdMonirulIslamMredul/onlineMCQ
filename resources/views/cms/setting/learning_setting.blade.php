@extends('cms.cms_master')
@section('admin_content')

@php
$info = DB::table('learning_english_setting')->first();
@endphp

<section class="section">
    <div class="section-header">
        <h1>Learning English Settings</h1>
        @if(!empty($info->id))
        <div class="section-header-breadcrumb">
            <a href="{{ url('/cms/edit-learning-english-setting/'.$info->id) }}" class="btn btn-info btn-sm">Edit</a>
        </div>
        @endif
    </div>

    <div class="row">
        @if(!empty($info->id))
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                        </div>
                        <div class="card-body">
                            <div class="author-box-center text-center">
                                <img alt="image" src="{{ asset($info->image) }}" class="rounded author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <br>

                                </div>
                            </div>
                            {!!$info->text!!}
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
                    <form action="{{ route('cms.set_learning_english') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputState"><span class="text-danger">*</span>Image (600 X 370)</label>
                                <input type="file" name="image" required class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputState"><b>Text</b></label>
                            <textarea name="editor1" required></textarea>
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
