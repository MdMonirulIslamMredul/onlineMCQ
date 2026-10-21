@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update testimonial</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('update_subscription/'.$data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Plan Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Monthly Price</label>
                                <input type="number" name="monthly_price" class="form-control" value="{{ $data->monthly_price }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Yearly Price</label>
                                <input type="number" name="yearly_price" class="form-control" value="{{ $data->yearly_price }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control">{{ $data->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="is_popular">Is Popular</label>
                                <input type="checkbox" name="is_popular" value="1" {{ $data->is_popular ? 'checked' : '' }}>
                            </div>
                            <div class="form-group">
                                <label for="is_free_trial">Is Free Trial</label>
                                <input type="checkbox" name="is_free_trial" value="1" {{ $data->is_free_trial ? 'checked' : '' }}>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
