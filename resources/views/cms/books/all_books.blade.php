@extends('cms.cms_master')
@section('admin_content')
    <section class="section">
        <div class="section-header">
            <h1>All Books</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#basicModal">Add New Books</button>
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
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i = 0)
                                        @foreach ($books as $book)
                                            <tr>
                                                <th>{{ $i += 1 }}</th>
                                                <td><img style="border-radius: 5px;"
                                                        src="{{ asset(optional($book)->image) }}" alt=""
                                                        width="20%"></td>
                                                <td>{{ $book->name }}</td>
                                                <td>৳ {{ $book->price }}</td>
                                                <td>
                                                    @if ($book->active == 1)
                                                        <span class="h4 text-success"><b>Active</b></span>
                                                    @else
                                                        <span class="h4 text-danger"><b>Deactive</b></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div>
                                                            <a href="{{ url('/cms/edit-books/' . $book->id) }}"
                                                                class="btn btn-primary mr-2">Edit</a>
                                                        </div>
                                                        <div>
                                                            <form action="{{ route('cms.delete.books', $book->id) }}" method="POST" style="display:inline;">
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
    <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Books</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" action="{{ route('cms.add_books') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="first-name-column">Name</label>
                                    <textarea class="form-control" id="" name="name" rows="2" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="first-name-column">Price</label>
                                            <input type="number" name="price" class="form-control" id=""
                                                step=any required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="first-name-column">Image (600 X 600)</label>
                                            <input type="file" name="image" class="form-control" id=""
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputEmail4"><span class="text-danger">*</span>Status</label>
                                            <select name="active" id="" class="form-control" required="">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="first-name-column">Description</label>
                                    <textarea class="form-control" id="editor1" name="description"></textarea>
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
