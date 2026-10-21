@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>Update Learning English Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    <form action="{{url('/cms/update-learning-english-setting/'.$info->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">New Image (600 X 370)</label>
                                <input type="file" name="image" class="form-control" id="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState"><span class="text-danger">*</span>Old Image</label>
                                <input type="hidden" name="old_image" value="{{$info->image}}"><br>
                                <img src="{{asset($info->image)}}" width="50%">
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                            <label for="inputState"><b>Text</b></label>
                            <textarea name="editor1" required>{{$info->text}}</textarea>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="form-control btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>

</section>

@endsection
