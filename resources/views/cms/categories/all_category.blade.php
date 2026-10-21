@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Exam Categories</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#basicModal">Add New Category</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#deactiveModal">Deactive Categories</button>

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
                                        <th>Category Name</th>
                                        <th>Url</th>
                                        <th>Type</th>
                                        <th>Tk</th>
                                        <th>Rank</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($categories as $category)
                                        @if($category->active == 1)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td><img style="border-radius: 5px;" src="{{ asset($category->image) }}" alt="" width="39" height="39"></td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->url }}</td>
                                            <td>{{ $category->free_paid }}</td>
                                            <td>{{ number_format($category->tk, 2) }}</td>
                                            <td>{{ $category->rank }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ url('/editCategory/'.$category->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ url('/deactiveCategory/'.$category->id) }}" class="btn btn-warning mr-2">Deactive</a>
                                                    </div>
                                                    <div>
                                                        <!-- Add a delete form with a button -->
                                                        <form action="{{ route('delete.category', $category->id) }}"
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
                <form class="form" action="{{ route('add_category') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <div class="col-md-12 col-12">
                    <div class="form-group">
                                <label for="first-name-column">Category Name</label>
                                <input type="text" id="category_name" class="form-control"
                                    placeholder="Category Name" name="name" required />
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="first-name-column">Url</label>
                                <input type="text" id="category_url" class="form-control"
                                     name="url" required/>
                                @error('url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail4"><span class="text-danger">*</span>Free or Paid</label>
                                <select name="free_paid" id="" class="form-control" required="">
                                    <option value="">Select One</option>
                                    <option value="free">Free</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword4"><span class="text-danger">*</span>Tk(Only for Paid Category)</label>
                                <input type="number" name="tk" class="form-control" step=any>
                            </div>
                            <div class="form-group">
                                <label for="first-name-column">Publish Rank</label>
                                <input type="number" class="form-control"
                                       value="{{ old('rank') }}" name="rank" required />
                            </div>

                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Category Image(400 X 400)</label>
                                <input type="file" id="first-name-column" class="form-control"
                                    placeholder="Category Name" name="image" required />
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
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($categories as $category)
                                        @if($category->active == 0)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a href="{{ url('/activeCat/'.$category->id) }}" class="btn btn-success">Active</a>
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
