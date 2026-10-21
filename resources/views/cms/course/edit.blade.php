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
                    <form action="{{route('cms.update_course_confirm',$course->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Cagetories</label>
                                <select name="catID" id="" class="form-control" required="">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option @if($course->catID == $category->id) selected @endif value="{{$category->id}}">{{$category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Name</label>
                                <input type="text" name="name" class="form-control" value={{$course->name}} required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4"><span class="text-danger">*</span>Course Price</label>
                                <input type="number" name="price" class="form-control" value={{$course->price}} required id="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="inputPassword4"><span class="text-danger">*</span>Image (800 x 630)</label>
                                <input type="file" name="image" class="form-control"  id="">
                                <img src="{{asset($course->image)}}" width="40%">
                                @error('exam_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                             <div class="form-group col-md-12">
                                    <label for="first-name-column">Description</label>
                                    <textarea class="form-control" id="editor1" name="description" >{{$course->description}}</textarea>
                                </div>
                             <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <td>id</td>
                                            <td>Module</td>
                                            <td>Links</td>
                                            <td>Free/Paid</td>
                                            <td>Action</td>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="module-title">{{ $module->title }}</td>
                                            <td class="module-link">{{ $module->link }}</td>
                                            <td class="module-free-paid">{{ $module->free_paid }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="javascript:void(0);" class="btn btn-primary mr-2 edit-module-btn" data-id="{{ $module->id }}">Edit</a>
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0);" class="btn btn-warning mr-2 delete-module-btn" data-id="{{ $module->id }}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                             </div>
                            <!--<div class="form-group col-md-3">-->
                                <div class="col-md-6">
                                    <div class="field_wrapper_second mt-3">
                                        <label>Course Module</label>
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
                                <div class="form-group col-md-12">
                                    <label for="first-name-column">Publish Rank</label>
                                    <select name="rank" id="" class="form-control">
                                        <option @if($course->rank == 1) selected @endif value="1">Ranked</option>
                                        <option @if($course->rank == 0) selected @endif value="0">Unranked</option>
                                    </select>
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
<!-- Edit Module Modal -->
<div class="modal fade" id="editModuleModal" tabindex="-1" role="dialog" aria-labelledby="editModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModuleModalLabel">Edit Course Module</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="moduleId">
                <div class="form-group">
                    <label for="moduleTitle">Module Title</label>
                    <input type="text" class="form-control" id="moduleTitle">
                </div>
                <div class="form-group">
                    <label for="moduleLink">Module Link</label>
                    <input type="text" class="form-control" id="moduleLink">
                </div>
                <div class="form-group">
                    <label for="moduleFreePaid">Free/Paid</label>
                    <select class="form-control" id="moduleFreePaid">
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="saveEditModuleBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    var maxField = 30; // Maximum input fields
    var addButton = $('.add_button_second'); // Add button selector
    var wrapper = $('.field_wrapper_second'); // Input field wrapper
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
        </div>
    `; // New input field HTML

    var x = $('.field_wrapper_second .d-flex').length; // Initial field counter based on existing fields

    // Once add button is clicked
    $(addButton).click(function() {
        if (x < maxField) {
            x++; // Increase field counter
            $(wrapper).append(fieldHTML); // Add field HTML
        } else {
            alert('A maximum of ' + maxField + ' fields are allowed to be added.');
        }
    });

    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); // Remove field HTML
        x--; // Decrease field counter
    });

    // Handle Edit Button Click
    $('.edit-module-btn').click(function(e) {
        e.preventDefault();
        var moduleId = $(this).data('id');
        var title = $(this).closest('tr').find('.module-title').text();
        var link = $(this).closest('tr').find('.module-link').text();
        var freePaid = $(this).closest('tr').find('.module-free-paid').text();

        $('#editModuleModal #moduleTitle').val(title);
        $('#editModuleModal #moduleLink').val(link);
        $('#editModuleModal #moduleFreePaid').val(freePaid);
        $('#editModuleModal #moduleId').val(moduleId);
        $('#editModuleModal').modal('show');
    });

    // Handle Save Edit Button Click in Modal
    $('#saveEditModuleBtn').click(function(e) {
        e.preventDefault();
        var moduleId = $('#editModuleModal #moduleId').val();
        var title = $('#editModuleModal #moduleTitle').val();
        var link = $('#editModuleModal #moduleLink').val();
        var freePaid = $('#editModuleModal #moduleFreePaid').val();

        $.ajax({
            url: '{{ route("cms.edit_course_module") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: moduleId,
                title: title,
                link: link,
                free_paid: freePaid
            },
            success: function(response) {
                if (response.status === 'Module updated successfully') {
                    location.reload(); // Reload the page to see the changes
                } else {
                    alert('Error: ' + response.status);
                }
            }
        });
    });

    // Handle Delete Button Click
    $('.delete-module-btn').click(function(e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this module?')) {
            return;
        }

        var moduleId = $(this).data('id');

        $.ajax({
            url: '{{ route("cms.delete_course_module") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: moduleId
            },
            success: function(response) {
                if (response.status === 'Module deleted successfully') {
                    location.reload(); // Reload the page to see the changes
                } else {
                    alert('Error: ' + response.status);
                }
            }
        });
    });
});
</script>
@endsection
