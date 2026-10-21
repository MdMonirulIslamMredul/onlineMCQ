@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All MCQ Results</h1>
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
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($mcqExams as $mcqR)
                                        @php( $studentInfo = DB::table('users')->where('id', $mcqR->userID)->first() )
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $studentInfo->name??null }}</td>
                                            <td>{{ $studentInfo->phone??null }}</td>
                                            <td>{{ $mcqR->exam_name }}</td>
                                            <td>{{ date('d M, Y', strtotime($mcqR->created_at))}}</td>
                                            <td>
                                                <div>
                                                    <form action="{{ route('cms.delete.mcq.result.page', $mcqR->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                                                    </form>
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
