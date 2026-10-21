@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>Update Exam</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    <form action="{{url('/cms/update-exam/'.$exam->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Cagetories</label>
                                <select name="catID" id="" class="form-control" required="">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option @if($exam->catID == $category->id) selected @endif value="{{$category->id}}">{{$category->name}} ({{$category->free_paid}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>MCQ or Written</label>
                                <select name="mcq_written" id="" class="form-control" required="">
                                    <option value="">Select One</option>
                                    <option @if($exam->mcq_written == 'mcq') selected @endif value="mcq">MCQ</option>
                                    <option @if($exam->mcq_written == 'written') selected @endif value="written">Written</option>
                                </select>
                            </div>
                            <!--<div class="form-group col-md-4">-->
                            <!--    <label for="inputEmail4"><span class="text-danger">*</span>Free or Paid</label>-->
                            <!--    <select name="free_paid" id="" class="form-control" required="">-->
                            <!--        <option value="">Select One</option>-->
                            <!--        <option value="free">Free</option>-->
                            <!--        <option value="paid">Paid</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <div class="form-group col-md-12">
                                <label for="inputPassword4"><span class="text-danger">*</span>Exam Name</label>
                                <input type="text" name="exam_name" value="{{$exam->exam_name}}" class="form-control" required id="">
                                @error('exam_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--<div class="form-group col-md-3">-->
                            <!--    <label for="inputPassword4"><span class="text-danger">*</span>Tk(Only for Paid Exam)</label>-->
                            <!--    <input type="number" name="tk" value="" class="form-control" step=any>-->
                            <!--</div>-->
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Type</label>
                                <select name="type" id="" class="form-control" required="">
                                    <option value="">Select One</option>
                                    <option @if($exam->type == 'permanent') selected @endif value="permanent">Permament</option>
                                    <option @if($exam->type == 'temporary') selected @endif value="temporary">Temporary</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Exam Time( in minutes)</label>
                                <input type="number" value="{{$exam->examTime}}" name="examTime" class="form-control" placeholder="Ex: 90" required step=any id="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Start Date and Time( Only for Temporary Exam)</label>
                                <input type="datetime-local" value="{{$exam->startDate}}" name="startDate" class="form-control" >
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Publish Status</label>
                                <select name="active" id="" class="form-control" required="">
                                    <option @if($exam->active == 1) selected @endif  value="1">Publish</option>
                                    <option @if($exam->active == 0) selected @endif value="0">Unpublish</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail4"><b>Written Paragraph( Only For Written Exam )</b></label>
                                <textarea name="editor1">{{$exam->written_paragraph}}</textarea>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="form-control btn btn-success">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>

</section>

@endsection
