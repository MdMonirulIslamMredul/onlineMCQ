@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All News And Notice</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#basicModal">Add New Notice</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example2" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($news as $notice)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $notice->title }}</td>
                                            <td> @if($notice->active == 1) <span class="h4 text-success"><b>Active</b></span> @else <span class="h4 text-danger"><b>Deactive</b></span> @endif</td>
                                            <td>{{date("d M, Y", strtotime($notice->date))}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ url('/cms/edit-notice/'.$notice->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                    </div>
                                                    <div>
                                                        <!-- Add a delete form with a button -->
                                                        <form action="{{ route('cms.delete.notice', $notice->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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

<!-- Begin:: This is the add new category modal -->
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
                <form class="form" action="{{ route('cms.add_notice') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <div class="col-md-12 col-12">
                    <div class="form-group">
                                <label for="first-name-column">Title</label>
                                <textarea class="form-control" id="" name="title" rows="4" required></textarea>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail4"><span class="text-danger">*</span>Status</label>
                                <select name="active" id="" class="form-control" required="">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
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
<!-- End:: This is the add new category modal -->

@endsection
