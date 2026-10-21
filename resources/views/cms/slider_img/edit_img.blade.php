@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update Categories</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('cms/update_img/'.$info->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="old_image" value="{{ $info->image }}">
                            <div class="row">


                                    <div class="form-group col-md-6">
                                        <label for="info_name">Slider Info </label>
                                        <select id="info_name" class="form-control" name="slider_info_id" required>
                                            <option value="" disabled selected>Select One</option>
                                            @foreach ($data as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $info->slider_info_id ? 'selected' : '' }}>{{ $data->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('slider_info_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="first-name-column">Image(860 x 600)</label>
                                            <input type="file" id="first-name-column" class="form-control"
                                                placeholder="info Name" name="image" />
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="first-name-column">Previous Image</label><br>
                                            <img style="border-radius: 5px;" src="{{ asset($info->image) }}" alt="" width="350" height="150">
                                        </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success form-control">Submit</button>
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
