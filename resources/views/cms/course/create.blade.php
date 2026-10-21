@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>Add New Course</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    <form action="{{route('cms.add_course_confirm')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Category</label>
                                <select name="catID" id="" class="form-control" required="">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Name</label>
                                <input type="text" name="name" class="form-control" required id="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Price</label>
                                <input type="number" name="price" class="form-control" required id="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="inputPassword4"><span class="text-danger">*</span>Image(800 x 630)</label>
                                <input type="file" name="image" class="form-control" required id="">
                                @error('exam_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                             <div class="form-group col-md-12">
                                    <label for="first-name-column">Description</label>
                                    <textarea class="form-control" id="editor1" name="description" ></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="field_wrapper_second mt-3">
                                    <label>Item</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control" name="titles[]" placeholder="Module Title" />
                                        <input type="text" class="form-control" style="margin-left: 20px" name="links[]" placeholder="Link" />
                                        <div class="form-check " style="margin-left: 30px">
                                            <input class="form-check-input" type="checkbox" name="free_paid[]" value="free">
                                            <label class="form-check-label">Free</label>
                                            <input class="form-check-input" type="checkbox" name="free_paid[]" value="paid">
                                            <label class="form-check-label">Paid</label>
                                        </div>
                                        <a href="javascript:void(0);" class="add_button_second m-3" title="Add field"><img
                                                src="{{ asset('/') }}backend/assets/img/add-icon.png" style="height: 20px" /></a>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group col-md-3">-->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
        var maxField = 30; //Input fields increment limitation
        var addButton = $('.add_button_second'); //Add button selector
        var wrapper = $('.field_wrapper_second'); //Input field wrapper
        var fieldHTML = `
            <div class="d-flex align-items-center mt-2">
                <input type="text" class="form-control" name="titles[]" placeholder="Module Title" />
                <input type="text" class="form-control" style="margin-left: 20px" name="links[]" placeholder="Link" />
                <div class="form-check" style="margin-left: 30px">
                    <input class="form-check-input" type="checkbox" name="free_paid[]" value="free">
                    <label class="form-check-label">Free</label>
                    <input class="form-check-input ms-2" type="checkbox" name="free_paid[]" value="paid">
                    <label class="form-check-label">Paid</label>
                </div>
                <a href="javascript:void(0);" class="remove_button m-3">
                    <img src="{{ asset('/') }}backend/assets/img/remove-icon.png" style="height: 20px" />
                </a>
            </div>`; // New input field HTML

        var x = 1; // Initial field counter is 1

        // Once add button is clicked
        $(addButton).click(function(){
            // Check maximum number of input fields
            if(x < maxField){
                x++; // Increase field counter
                $(wrapper).append(fieldHTML); // Add field HTML
            } else {
                alert('A maximum of ' + maxField + ' fields are allowed to be added.');
            }
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); // Remove field HTML
            x--; // Decrease field counter
        });
    });
</script>

@endsection
