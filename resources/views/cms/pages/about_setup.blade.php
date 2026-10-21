@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>About Us Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    @if(empty($aboutInfo->id))
                    <form action="{{route('cms.add_about_us')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputState"><b><span class="text-danger">*</span>About Description</b></label>
                                <textarea name="editor1" required></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress"><span class="text-danger">*</span>Image( 520 X 410 )</label>
                                <input type="file" class="form-control" name="image" required>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-12">
                                <button type="submit" class="form-control btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                    @else 
                    <form action="{{url('/cms/about_info_update/'.$aboutInfo->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputState"><b><span class="text-danger">*</span>About Description</b></label>
                                <textarea name="editor1" required>{{$aboutInfo->aboutDes}}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress"><span class="text-danger">*</span>Image( 520 X 410 )</label>
                                <input type="file" class="form-control" name="image">
                                <input type="hidden" name="old_image" value="{{ $aboutInfo->image }}">
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Previous Image</label><br>
                                <img style="border-radius: 5px;" src="{{ asset(optional($aboutInfo)->image) }}" alt="" width="200px" >
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="form-control btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>




                    @endif
                </div>
               
            </div>
        </div>
    </div>

</section>

@endsection
