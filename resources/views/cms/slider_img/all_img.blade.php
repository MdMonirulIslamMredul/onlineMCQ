@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Course infos</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#basicModal">Add New info</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#deactiveModal">Deactive infos</button>

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
                                        <th>Slider Info Name</th>
                                        {{-- <th>Url</th> --}}
                                        {{-- <th>Type</th> --}}
                                        {{-- <th>Tk</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $i = 0;  @endphp
                                    @foreach($infos as $info)
                                    @php
                                        $info_name = DB::table('slider_infos')->where('id',$info->slider_info_id)->first();
                                    @endphp
                                        @if($info->active == 1)
                                        <tr>
                                            <th>{{ ++$i}}</th>
                                            <td><img style="border-radius: 5px;" src="{{ asset($info->image) }}" alt="" width="350" height="150"></td>
                                             <td>{{  $info_name->title ?? null }}</td>
                                            {{-- <td>{{ $info->url }}</td> --}}
                                            {{-- <td>{{ $info->free_paid }}</td> --}}
                                            {{-- <td>{{ number_format($info->tk, 2) }}</td> --}}

                                            <td>
                                                <a href="{{ url('/cms/editimg/'.$info->id) }}" class="btn btn-primary">Edit</a>
                                                <a href="{{ url('/deactiveImg/'.$info->id) }}" class="btn btn-warning">Deactive</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    {{-- {{ dd($info_name) }} --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Begin:: This is the add new info modal -->
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
                <form class="form" action="{{ route('cms.add_img') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <div class="col-md-12 col-12">
                    <div class="form-group">
                                <label for="info_name">Slider Info </label>
                                <select id="info_name" class="form-control" name="slider_info_id" required>
                                    <option value="" disabled selected>Select One</option>
                                    @foreach ($data as $data)
                                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                                    @endforeach
                                </select>
                                @error('slider_info_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Image</label>
                                <input type="file" id="first-name-column" class="form-control"
                                    placeholder="info Name" name="image" required />
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
<!-- End:: This is the add new info modal -->

<!-- Begin:: This is the All Deactive info modal -->
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
                                        <th>Slider Info Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $i = 0; @endphp
                                    @foreach($infos as $info)
                                        @php
                                        $info_name = DB::table('slider_infos')->where('id',$info->slider_info_id)->first();
                                    @endphp
                                        @if($info->active == 0)
                                        <tr>
                                            <th>{{ ++$i }}</th>
                                            <td>{{ $info_name->title ?? null }}</td>
                                            <td><img style="border-radius: 5px;" src="{{ asset($info->image) }}" alt="" width="55" height="35"></td>
                                            <td>
                                                <a href="{{ url('/activeImg/'.$info->id) }}" class="btn btn-success">Active</a>
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
<!-- End:: This is the All Deactive info modal -->



@endsection
