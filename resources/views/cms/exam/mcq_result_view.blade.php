@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Result Sheet For <span class="bg-primary p-1 rounded text-light">{{$exam_info->exam_name}}</span></h1>
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
                                        <th>Mark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($mcqExams as $mcqR)
                                        @php( $studentInfo = DB::table('users')->where('id', $mcqR->userID)->first() )
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ $studentInfo->name }}</td>
                                            <td>{{ $studentInfo->phone }}</td>
                                            <td>{{ $mcqR->total }}</td>
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
