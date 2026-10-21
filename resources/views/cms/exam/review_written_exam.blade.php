@extends('cms.cms_master')
@section('admin_content')
@php
$i = 1;

$written_results = DB::table('written_results')->where('examID', $writtenExam->examID)->where('userID', $writtenExam->userID)->get();

$studentInfo = DB::table('users')->where('id', $writtenExam->userID)->first();
$examMark = DB::table('written_results')->where('examID', $writtenExam->examID)->where('userID', $writtenExam->userID)->sum('mark');

@endphp
<section class="section">
<div class="section-header">
        <h1>{{$writtenExam->exam_name}}</h1>
        <div class="section-header-breadcrumb">
            <div class="form-group">
                <label for=""  class="text-danger">Exam Status</label>
                <select onchange="Change_Written_Review_Status()" class="form-control" id="ChangeCMSWStatus">
                    <option @if($writtenExam->written_status == 'pending') selected @endif value="pending">Pending</option>
                    <option @if($writtenExam->written_status == 'checked') selected @endif value="checked">Checked</option>
                </select>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <input type="hidden" id="examID" value="{{$writtenExam->examID}}" name="">
                            <input type="hidden" id="userID" value="{{$writtenExam->userID}}" name="">
                            <div class="col-md-12">
                                <h5><b>Student Info:</b></h5>
                                <p><b>Name: </b> {{$studentInfo->name}} <br> <b>Phone: </b> {{$studentInfo->phone}} </p>
                                <h4><b>Total Mark: </b> {{$examMark}}</h4>
                                <h4><b>Right Mark: </b> <span id="AnsrightMark"></span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        @foreach($written_results as $written)
                        @php
                            $questionsInfo = DB::table('written_questions')->where('id', $written->qid)->first();
                        @endphp
                        <div class="col-md-12">
                            <div class="card shadow p-2 mb-3 bg-white rounded">
                                <div class="card-header">
                                    <h6 class="text-dark"><b>{{ $i }} ) {{ $questionsInfo->questions }}</b></h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-dark"><b class="text-info">Student Ans:</b> {!! $written->userAns !!}</p>

                                    <!-- Check if a file was uploaded -->
                                    @if($written->file_path)
                                        <p class="text-dark">
                                            <b class="text-info">Uploaded File:</b>
                                            {{-- <a href="{{ asset('file_path/' . $written->file_path) }}" target="_blank">{{ $written->file_path }}</a> --}}
                                            <!-- Download link -->
                                            <a href="{{ asset('file_path/' . $written->file_path) }}" class="btn btn-primary btn-sm ml-4" download>Download</a>
                                        </p>
                                        <!-- Optional: Embed the file if it's an image or PDF -->
                                        {{-- @if(in_array(pathinfo($written->file_path, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg', 'pdf']))
                                            <img src="{{ asset('file_path/' . $written->file_path) }}" alt="" class="img-fluid">
                                        @endif --}}
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p class="text-dark"><b>Mark: </b> {{ $written->mark }}</p>
                                            <input type="number" id="QA{{ $written->id }}" onkeyup="setWrittenRMark('{{ $written->id }}')" onchange="setWrittenRMark('{{ $written->id }}')" step="any" class="form-control" placeholder="Ans Mark" value="{{ $written->rightansMark }}">
                                        </div>
                                        <div class="col-md-10">
                                            <p class="text-dark text-justify"> <b class="text-danger">Ans:</b> {{ $questionsInfo->ans }}</p>
                                        </div>
                                        <div class="col-md-10">
                                            <label for="inputEmail4" class="text-dark h5 text-bold"><b>Note</b></label>
                                            <textarea class="form-control" id="N{{ $written->id }}" rows="2">{{ $written->note }}</textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <button onclick="SetNote('{{ $written->id }}')" class="btn btn-success mt-5">Set Note</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php( $i++ )
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
