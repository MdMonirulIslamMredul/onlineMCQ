@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update testimonial</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('update_testimonial/'.$data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="old_image" value="{{ $data->image }}">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Name</label>
                                        <input type="text"  class="form-control"
                                           value="{{ $data->name }}" name="name" required />
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                    <label for="first-name-column">Designation</label>
                                    <input type="text"  class="form-control" value="{{ $data->designation }}"
                                        name="designation" required/>
                                        @error('designation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword4">Description</label>
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $data->description }}</textarea>
                                </div>

                                </div>
                                <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="first-name-column">Image(74 X 74)</label>
                                            <input type="file" id="first-name-column" class="form-control"
                                                placeholder="data Name" name="image" />
                                        </div>
                                        <div class="form-group col-md-6">
                                        <label for="first-name-column">Previous Image</label><br>
                                            <img style="border-radius: 5px;" src="{{ asset($data->image) }}" alt="" width="74" height="74">
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
