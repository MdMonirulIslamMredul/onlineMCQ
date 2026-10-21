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
                        <form class="form" action="{{ url('cms/update_info/'.$category->id) }}" method="POST"
                           >
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Title</label>
                                        <input type="text" id="category_name" class="form-control"
                                           value="{{ $category->title }}" name="title" required />
                                    </div>
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                    <label for="first-name-column">Description</label>
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $category->description }}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
