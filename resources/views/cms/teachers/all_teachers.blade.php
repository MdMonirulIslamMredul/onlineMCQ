@extends('cms.cms_master')
@section('admin_content')
    <section class="section">
        <div class="section-header">
            <h1>Teachers</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#basicModal">Add New Teachers</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="example2" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SI</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Job Title</th>
                                            <th>Active Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i = 0)
                                        @foreach ($teachers as $teacher)
                                            <tr>
                                                <th>{{ $i += 1 }}</th>
                                                <td><img style="border-radius: 5px;" src="{{ asset($teacher->image) }}"
                                                        alt="" width="70"></td>
                                                <td>{{ $teacher->name }}</td>
                                                <td>{{ $teacher->subject }}</td>
                                                <td>{{ $teacher->job_title }}</td>
                                                <td>
                                                    @if ($teacher->active == 1)
                                                        <span style="font-weight: bold;"
                                                            class="h3 text-bold text-success">Active</span>
                                                    @else
                                                        <span class="h4 text-bold text-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div>
                                                            <a href="{{ url('/cms/editteacher/' . $teacher->id) }}"
                                                                class="btn btn-primary mr-2">Edit</a>
                                                        </div>
                                                        <div>
                                                            <!-- Add a delete form with a button -->
                                                            <form action="{{ route('cms.delete_teacher', $teacher->id) }}"
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" action="{{ route('cms.add_teachers') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="first-name-column"> <span class="text-danger">*</span> Name</label>
                                    <input type="text" id="name" class="form-control" placeholder="" name="name"
                                        required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="first-name-column"><span class="text-danger">*</span>Subject</label>
                                    <input type="text" id="" class="form-control" name="subject" required />
                                </div>
                                <div class="form-group">
                                    <label for="first-name-column"><span class="text-danger">*</span>Job Title</label>
                                    <input type="text" id="" class="form-control" name="job_title" required />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="first-name-column"><span class="text-danger">*</span>Image(80 X 80)</label>
                                    <input type="file" id="first-name-column" class="form-control" name="image"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="first-name-column"><span class="text-danger">*</span>Publish Status</label>
                                    <select name="active" id="" class="form-control">
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
