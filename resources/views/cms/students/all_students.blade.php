@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Students</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Student Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        {{-- <th>Password</th> --}}
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($students as $student)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>{{ $student->email }}</td>
                                            {{-- <td>{{ $student->password }}</td> --}}
                                            <td>{{ $student->address }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ route('cms.edit.student', $student->id) }}"
                                                            class="btn btn-primary mr-2">Edit</a>
                                                    </div>
                                                    <div>
                                                        <!-- Add a delete form with a button -->
                                                        <form action="{{ route('cms.delete.student', $student->id) }}"
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
@endsection
