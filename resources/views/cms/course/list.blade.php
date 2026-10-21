@extends('cms.cms_master')
@section('admin_content')
    <section class="section">
        <div class="section-header">
            <h1>All Courses</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SI</th>
                                            <th>Course Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Rank</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i = 0)
                                        @foreach ($courses as $course)
                                            <tr>
                                                <th>{{ $i += 1 }}</th>
                                                <td>{{ $course->name }}</td>
                                                <td>{{ $course->price }}</td>
                                                @if ($course->active == 1)
                                                    <td>Active</td>
                                                @else
                                                    <td>Deactive</td>
                                                @endif
                                                <td>
                                                    @if ($course->rank == 1)
                                                        <span class="h3 text-bold text-success">Ranked</span>
                                                    @else
                                                        <span class="h4 text-bold text-danger">Unranked</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <a href="{{ url('/editCourse/' . $course->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    @if ($course->active == 1)
                                                        <a href="{{ url('/deactiveCourse/' . $course->id) }}"
                                                            class="btn btn-warning">Deactive</a>
                                                    @else
                                                        <a href="{{ url('/activeCourse/' . $course->id) }}"
                                                            class="btn btn-success">Active</a>
                                                    @endif

                                                </td> --}}
                                                <td>
                                                    <div class="d-flex">
                                                        <div>
                                                            <a href="{{ url('/editCourse/' . $course->id) }}"
                                                                class="btn btn-primary mr-2">Edit</a>
                                                        </div>
                                                        <div>
                                                            @if ($course->active == 1)
                                                                <a href="{{ url('/deactiveCourse/' . $course->id) }}"
                                                                    class="btn btn-warning mr-2">Deactive</a>
                                                            @else
                                                                <a href="{{ url('/activeCourse/' . $course->id) }}"
                                                                    class="btn btn-success mr-2">Active</a>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <!-- Add a delete form with a button -->
                                                            <form action="{{ route('cms.delete.course', $course->id) }}"
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
