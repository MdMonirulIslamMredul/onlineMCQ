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
                           
                            <br>
                            <table class="table" id="WrittenQuestionsTable">
                                <tbody>
                                    @if($WrittenQuestions != '[]')
                                   
                                    <tr>
                                        <td>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="col-md-1 text-center">
                                                            <p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">1</p>
                                                        </div>
                                                        <div class="form-group col-md-11">
                                                            <input type="hidden" name="QID[]" value="0">
                                                            <textarea class="form-control" name="questions[]" id="WQ{{$question_number}}" rows="3"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-10">
                                                        <label for="inputEmail4">Ans</label>
                                                            <textarea class="form-control" name="ans[]" rows="3"></textarea>
                                                        </div>
                                                          <input type="hidden" name="optn1[]"  id="numserial" value="1" required>
                                                        <div class="form-group col-md-2">
                                                        <label for=""> <span class="text-danger">*</span>Mark</label>
                                                            <input type="text" name="mark[]" placeholder="Mark"
                                                                class="form-control" id="" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php( $question_number++ )
                                
                                    @else
                                    <tr id="noQtr">
                                        <td class="text-center p-5">
                                            <h1><b>Have No Written Questions!</b></h1>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="AddWrittenQTr()"
                                        class="btn btn-info btn-lg btn-block">Add New</button>
                                </div>
                            </div>
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
