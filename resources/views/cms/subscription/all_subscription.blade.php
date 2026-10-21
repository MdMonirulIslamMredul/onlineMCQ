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
                                    data-target="#basicModal">Add New Subscription</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#deactiveModal">Deactive Subscription</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Monthly Price</th>
                                        <th>Yearly Price</th>
                                        <th>Description</th>
                                        <th>Popular</th>
                                        <th>Free Trial</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                    @if($data->active == 1)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>TK. {{ $data->monthly_price }}</td>
                                        <td>TK. {{ $data->yearly_price }}</td>
                                        <td>{{ $data->description }}</td>
                                        <td>{{ $data->is_popular ? 'Yes' : 'No' }}</td>
                                        <td>{{ $data->is_free_trial ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <a href="{{ url('/editSubscription/'.$data->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('/deactiveSubscription/'.$data->id) }}" class="btn btn-warning">Deactivate</a>
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
                <form class="form" action="{{ route('add.subscription') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Plan Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Yearly Price</label>
                        <input type="number" name="yearly_price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Monthly Price</label>
                        <input type="number" name="monthly_price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="is_popular">Is Popular</label>
                        <input type="checkbox" name="is_popular" value="1">
                    </div>
                    <div class="form-group">
                        <label for="is_free_trial">Is Free Trial</label>
                        <input type="checkbox" name="is_free_trial" value="1">
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
                                        <th>Monthly Price</th>
                                        <th>Yearly Price</th>
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
                                            <td>TK. {{ $data->monthly_price }}</td>
                                            <td>TK. {{ $data->yearly_price }}</td>
                                            <td>
                                                <a href="{{ url('/activeSubscription/'.$data->id) }}" class="btn btn-success">Active</a>
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
