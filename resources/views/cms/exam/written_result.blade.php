@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Written Results</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Student Name</th>
                                        <th>Student Phone</th>
                                        <th>Exam Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($writtenExams as $writtenR)
                                        @php( $studentInfo = DB::table('users')->where('id', $writtenR->userID)->first() )
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $studentInfo->name }}</td>
                                            <td>{{ $studentInfo->phone }}</td>
                                            <td>{{ $writtenR->exam_name }}</td>
                                            <td>{{ date('d M, Y', strtotime($writtenR->created_at))}}</td>
                                            <td> @if($writtenR->written_status == 'pending') <span class="h5 text-danger">Pending</span> @else <span class="h5 text-success text-bold">Checked</span>@endif</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ url('/cms-review-written-exam/'.$writtenR->id) }}" class="btn btn-info mr-2">Review</a>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('cms.delete.mcq.result.page', $writtenR->id) }}" method="POST" style="display:inline;">
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
