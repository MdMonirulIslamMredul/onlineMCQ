@extends('cms.cms_master')
@section('admin_content')
@php
$question_number = 1;
@endphp
<section class="section">
    <div class="section-header">
        <h1>Written Questins Of {{$exam->exam_name}}</h1>
        
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
            <div>
            {!!$exam->written_paragraph!!}
        </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">

                            </div>
                        </div>
                    </div>
                    <form action="{{route('cms.add_written_questions_confirm')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$exam->id}}" name="examID">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    
                                </div>
                                <div class="col-md-2">
                                   <a href="/cms/add_written_question/{{$exam->id}}" class="btn btn-info ">Add New</a>
                                </div>
                               
                            </div>
                            <br>
                            <table class="table" id="WrittenQuestionsTable">
                                <tbody>
                                    @if($WrittenQuestions != '[]')
                                    @foreach($WrittenQuestions as $question)
                                    <tr>
                                        <td>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="col-md-1 text-center">
                                                            <p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">{{$question_number}}</p>
                                                        </div>
                                                        <div class="form-group col-md-11">
                                                            <input type="hidden" name="QID[]" value="{{$question->id}}">
                                                            <h3 >{{$question->questions}}</h3>
                                                        </div>
                                                        <div class="form-group col-md-10">
                                                        <label for="inputEmail4">Ans</label>
                                                            <textarea class="form-control" name="ans[]" rows="3" readonly>{{$question->ans}}</textarea>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                        <label for=""> <span class="text-danger">*</span>Mark</label>
                                                            <span class="form-control" id=""  required>{{$question->mark}}</span>
                                                        </div>
                                                    </div>
                                                      <div class="form-group col-md-12 text-right">
                                                     <a class="btn btn-primary" href="/cms/exam-written-questions/edit/{{$question->id}}">Edit</a>
                                                     </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php( $question_number++ )
                                    @endforeach
                                    @else
                                    <tr id="noQtr">
                                        <td class="text-center p-5">
                                            <h1><b>Have No Written Questions!</b></h1>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!--<div class="row">-->
                            <!--    <div class="col-md-8">-->
                            <!--        <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <button type="button" onclick="AddWrittenQTr()"-->
                            <!--            class="btn btn-info btn-lg btn-block">Add New</button>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <div class="card-footer">
                            <input type="hidden" value="{{$question_number}}" id="numBerOfQuestions" name="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
