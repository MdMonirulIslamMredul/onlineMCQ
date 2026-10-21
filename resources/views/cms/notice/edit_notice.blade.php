@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Update Notice & News</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ url('/cms/update_news_notice/'.$news->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Title</label>
                                    <textarea class="form-control" id="" width="100" name="title" rows="5" required>{{$news->title}}</textarea>
                                </div>
                                <br>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4"><span class="text-danger">*</span>Status</label>
                                    <select name="active" id="" class="form-control" required="">
                                        <option @if($news->active == 1) selected @endif value="1">Active</option>
                                        <option @if($news->active == 0) selected @endif value="0">Deactive</option>
                                    </select>
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
