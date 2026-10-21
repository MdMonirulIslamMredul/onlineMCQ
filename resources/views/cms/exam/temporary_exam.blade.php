@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Temporary Exams</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <a href="{{route('cms.add_exams')}}" type="button" class="btn btn-primary" >Add New Exam</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Exam Name</th>
                                        <th>Category</th>
                                        <th>MCQ or Written</th>
                                        <th>Time</th>
                                        <th>Start Date And Time</th>
                                        <th>Publish Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($exams as $exam)
                                    <?php
                                        if($exam->mcq_written == 'mcq') {
                                            $totalQ = DB::table('mcq_questions')->where('examID', $exam->exam_id)->count();
                                            $totalMarks = DB::table('mcq_questions')->where('examID', $exam->exam_id)->sum('mark');
                                        }
                                        else {
                                            $totalQ = DB::table('written_questions')->where('examID', $exam->exam_id)->count();
                                            $totalMarks = DB::table('written_questions')->where('examID', $exam->exam_id)->sum('mark');
                                        }
                                    ?>
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td width="20%">{{ $exam->exam_name }}
                                                <p class="text-danger"><b>Total Questions: </b> {{$totalQ}}<br><span class="text-info"><b>Total Marks: </b> {{$totalMarks}}</span><br><span class="text-warning h6"><b>ID: </b> {{$exam->exam_id}}</span></p>
                                            </td>
                                            <td>{{ $exam->name }} <h3>({{ $exam->free_paid}})</h3></td>
                                            <td><p class="text-uppercase">{{ $exam->mcq_written }}</p></td>
                                            <td>{{ $exam->examTime }} min</td>
                                            <td>{{date('d M, Y. h:i:sA', strtotime($exam->startDate))}}</td>
                                            <td>@if($exam->exam_active == 1) <span style="font-weight: bold;" class="text-success">Published</span> @else <span style="font-weight: bold;" class="text-danger">Unpublished</span> @endif </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <a href="{{ url('/cms/edit-exam/'.$exam->exam_id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                                                    </div>
                                                    <div>
                                                        @if($exam->mcq_written == 'mcq')
                                                        <a href="{{ url('/cms/exam-mcq-questions/'.$exam->exam_id) }}" class="btn btn-warning btn-sm mr-2">Questions</a>
                                                    @else
                                                        <a href="{{ url('/cms/exam-written-questions/'.$exam->exam_id) }}" class="btn btn-warning btn-sm mr-2">Questions</a>
                                                    @endif
                                                    </div>
                                                    <div>
                                                        <a href="{{ url('/cms/result/'.$exam->exam_id) }}" class="btn btn-primary btn-sm mr-2">Result</a>
                                                    </div>
                                                     
                                                     <div>
                                                        {{-- <form action="{{ route('cms.delete.exam', $exam->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                                                        </form> --}}
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
