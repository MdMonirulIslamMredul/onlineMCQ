@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update Home Banner</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('/cms/update_banner/'.$banner->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="old_image" value="{{ $banner->image }}">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Banner Title</label>
                                        <input type="text" value="{{ $banner->title }}" class="form-control"
                                            placeholder="" name="title" />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-column">alt</label>
                                        <input type="text" id="" value="{{ $banner->alt }}" class="form-control"
                                            name="alt" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first-name-column">Banner New Image(2260 X 600)</label>
                                    <input type="file" id="first-name-column" class="form-control"
                                        placeholder="Category Name" name="image" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="first-name-column">Previous Image</label><br>
                                    <img style="border-radius: 5px;" src="{{ asset($banner->image) }}" alt=""
                                        width="300">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Publish Status</label>
                                    <select name="active" id="" class="form-control">
                                        <option @if($banner->active == 1) selected @endif value="1">Active</option>
                                        <option @if($banner->active == 0) selected @endif value="0">Deactive</option>
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
