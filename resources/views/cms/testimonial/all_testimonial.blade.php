@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Testimonial</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#basicModal">Add New Testimonial</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#deactiveModal">Deactive Testimonial</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($datas as $data)
                                        @if($data->active == 1)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td><img style="border-radius: 5px;" src="{{ asset($data->image) }}" alt="" width="64" height="64"></td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->designation }}</td>
                                            <td>{{ $data->description }}</td>
                                            <td>
                                                <a href="{{ url('/edittestimonial/'.$data->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ url('/deactiveTestimonial/'.$data->id) }}" class="btn btn-warning">Deactive</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Begin:: This is the add new data modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" action="{{ route('add.testimonial') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <div class="col-md-12 col-12">
                    <div class="form-group">
                                <label for="first-name-column">Name</label>
                                <input type="text" id="data_name" class="form-control"
                                    placeholder="Name" name="name" required />
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="first-name-column">Designation</label>
                                <input type="text"  class="form-control"
                                     name="designation" placeholder="Designation" required/>
                                @error('designation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="first-name-column">Description</label>
                                <textarea name="description"  cols="30" rows="10" class="form-control" placeholder="Description" required></textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Image(74 X 74)</label>
                                <input type="file" id="first-name-column" class="form-control"
                                    placeholder="data Name" name="image" required />
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: This is the add new data modal -->

<!-- Begin:: This is the All Deactive data modal -->
<div class="modal fade" id="deactiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($datas as $data)
                                        @if($data->active == 0)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $data->name }}</td>
                                            <td><img style="border-radius: 5px;" src="{{ asset($data->image) }}" alt="" width="64" height="64"></td>
                                            <td>
                                                <a href="{{ url('/activeTestimonial/'.$data->id) }}" class="btn btn-success">Active</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </div>
</div>
<!-- End:: This is the All Deactive data modal -->



@endsection
