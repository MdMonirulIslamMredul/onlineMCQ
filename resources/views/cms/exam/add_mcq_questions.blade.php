@extends('cms.cms_master')
@section('admin_content')
@php
    $question_number = 1;
@endphp
<section class="section">
    <div class="section-header">
        <h1>Questions Of {{$exam->exam_name}}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
      
                             
                       
                    </div>
                    <form action="{{route('cms.add_mcq_confirm')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$exam->id}}" name="examID">
                        <div class="card-body">
                             
                            <table class="table" id="MCQquestionsTable">
                                <tbody>
                                    @if($mcqQuestions != '[]')
                                      
                                            <tr id="">
                                                <td>
                                                    <div class="card">
                                                        <div class="card-body">
                         <div class="row">
                              <input type="hidden" name="QID[]" value="0">
                                                                <div class="col-md-1 text-center">
                                                                    <p style="background-color: #544AF4; padding: 5px; border-radius: 20px; font-size: 20px; color: #fff;">{{$question_number}}</p>
                                                                </div>
                                                                <div class="form-group col-md-11">
                                                                 
                                                                    <textarea id="Q{{$question_number}}" name="questions[]" placeholder="Question Text" class="form-control" id="" required rows="3"></textarea>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn1[]" placeholder="Option 1"  class="form-control" id="" required>
                                                                    <input type="hidden" name="optn1[]"  id="numserial" value="1" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn2[]" placeholder="Option 2"  class="form-control" id="" required>
                                                                   
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn3[]" placeholder="Option 3"  class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn4[]" placeholder="Option 4"  class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn5[]" placeholder="Option 5 (Optional)" class="form-control" id="">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    
                                                                    <select name="rightAns[]" class="form-control" id="" required readonly>
                                                                        <option value="">-- Select Ans --</option>
                                                                        <option  value="1">Option 1</option>
                                                                        <option value="2">Option 2</option>
                                                                        <option value="3">Option 3</option>
                                                                        <option  value="4">Option 4</option>
                                                                        <option value="5">Option 5</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="inputEmail4">Right Ans Description</label>
                                                                    <textarea class="form-control" name="writeAnsDes[]" id="" rows="3"></textarea>
                                                                </div>
                                                                <div class="form-group col-md-2">
                                                                    <label for=""> <span class="text-danger">*</span> Right Mark</label>
                                                                    <input type="text" name="mark[]"  class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-2">
                                                                    <label for=""> <span class="text-danger">*</span>Negative Mark</label>
                                                                    <input type="text" name="negativeMark[]"  class="form-control" id="" required>
                                                                </div>

                                                            </div>
                                                            
                                                        </div>
                                                                     
                                                    </div>
                                                    </td>
                                                </tr>
                                                @php( $question_number++ )
                                   
                                    @else
                                        <tr id="noQtr">
                                            <td class="text-center p-5"><h1><b>Have No MCQ Questions!</b></h1></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="AddMCQTr()" class="btn btn-info btn-lg btn-block">Add New</button>
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
