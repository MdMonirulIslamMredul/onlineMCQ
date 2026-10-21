@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update Teachers Info</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('/cms/update_teacher/'.$teacher->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="old_image" value="{{ $teacher->image }}">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column"> <span class="text-danger">*</span> Name</label>
                                        <input type="text" value="{{$teacher->name}}" id="name" class="form-control" placeholder="" name="name"
                                            required />
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-column"><span class="text-danger">*</span>Subject</label>
                                        <input type="text" id="" value="{{$teacher->subject}}" class="form-control" name="subject" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-column"><span class="text-danger">*</span>Job
                                            Title</label>
                                        <input type="text" id="" value="{{$teacher->job_title}}" class="form-control" name="job_title" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first-name-column">New Image(80 X 80)</label>
                                    <input type="file" id="first-name-column" class="form-control"
                                        placeholder="Category Name" name="image" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first-name-column">Previous Image</label><br>
                                    <img style="border-radius: 5px;" src="{{ asset($teacher->image) }}" alt=""
                                        width="80">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Publish Status</label>
                                    <select name="active" id="" class="form-control">
                                        <option @if($teacher->active == 1) selected @endif value="1">Active</option>
                                        <option @if($teacher->active == 0) selected @endif value="0">Deactive</option>
                                    </select>
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
