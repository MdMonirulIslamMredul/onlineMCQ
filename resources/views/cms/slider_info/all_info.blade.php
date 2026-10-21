@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Slider Infos</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#basicModal">Add New Slider Info</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#deactiveModal">Deactive Infos</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($infos as $info)
                                        @if($info->active == 1)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $info->title }}</td>
                                            <td>{{ $info->description }}</td>
                                            <td>
                                                <a href="{{ url('/cms/editinfo/'.$info->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ url('/deactiveInfo/'.$info->id) }}" class="btn btn-warning">Deactive</a>
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
                <form class="form" action="{{ route('cms.add_info') }}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-md-12 col-12">
                    <div class="form-group">
                                <label for="first-name-column">Title</label>
                                <input type="text" id="category_name" class="form-control"
                                    placeholder="Title" name="title" required />
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="first-name-column">Description</label>
                                     <textarea name="description" id="" cols="30" rows="10" class="form-control" placeholder="Description"></textarea>
                                @error('url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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

<!-- Begin:: This is the All Deactive category modal -->
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
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($infos as $info)
                                        @if($info->active == 0)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $info->title }}</td>
                                            <td>
                                                <a href="{{ url('/activeInfo/'.$info->id) }}" class="btn btn-success">Active</a>
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
<!-- End:: This is the All Deactive category modal -->



@endsection
