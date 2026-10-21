@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update Books</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('/cms/update_books/'.$books->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Name</label>
                                    <textarea class="form-control" value="{{$books->name}}"  width="100" name="name" rows="3" required>{{$books->name}}</textarea>
                                </div>
                                <br>
                                <div class="form-group col-md-3">
                                    <label for="first-name-column">Price</label>
                                    <input type="number" name="price" value="{{$books->price}}" class="form-control" id="" step=any required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="first-name-column">New Image (600 X 600)</label>
                                    <input type="file" name="image" class="form-control" id="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="first-name-column">Old Image</label><br>
                                    <input type="hidden" name="old_image" class="form-control" value="{{$books->image}}" id="">
                                    <img src="{{asset($books->image)}}" width="40%">
                                </div>
                                
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4"><span class="text-danger">*</span>Status</label>
                                    <select name="active" id="" class="form-control" required="">
                                        <option @if($books->active == 1) selected @endif value="1">Active</option>
                                        <option @if($books->active == 0) selected @endif value="0">Deactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Description</label>
                                    <textarea class="form-control" id="editor1" name="description" >{{$books->description}}</textarea>
                                </div>
                                
                                
                                
                                <div class="form-group col-md-12">
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
