@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>Questions Of {{$exam->exam_name}}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                
                            </div>
                        </div>
                    </div>
                    <form action="{{route('cms.add_mcq_confirm')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$exam->id}}" name="examID">
                        <div class="card-body">
                            <table class="table" id="MCQquestionsTable">
                                <tbody>
                                
                               
                                            <tr id="">
                                                <td>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-row">
                                               
                                                               
                                                                <div class="form-group col-md-11">
                                                                    <input type="hidden" name="QID[]" value="{{$mcqQuestions->id}}">
                                                                    <textarea  name="questions[]" placeholder="Question Text" class="form-control" id="" required rows="3">{{$mcqQuestions->questions}}</textarea>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn1[]" placeholder="Option 1" value="{{$mcqQuestions->optn1}}" class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn2[]" placeholder="Option 2" value="{{$mcqQuestions->optn2}}" class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn3[]" placeholder="Option 3" value="{{$mcqQuestions->optn3}}" class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn4[]" placeholder="Option 4" value="{{$mcqQuestions->optn4}}" class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <input type="text" name="optn5[]" placeholder="Option 5 (Optional)" value="{{$mcqQuestions->optn5}}" class="form-control" id="">
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    
                                                                    <select name="rightAns[]" class="form-control" id="" required readonly>
                                                                        <option value="">-- Select Ans --</option>
                                                                        <option @if($mcqQuestions->rightAns == 1) selected @endif value="1">Option 1</option>
                                                                        <option @if($mcqQuestions->rightAns == 2) selected @endif value="2">Option 2</option>
                                                                        <option @if($mcqQuestions->rightAns == 3) selected @endif value="3">Option 3</option>
                                                                        <option @if($mcqQuestions->rightAns == 4) selected @endif value="4">Option 4</option>
                                                                        <option @if($mcqQuestions->rightAns == 5) selected @endif value="5">Option 5</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-8">
                                                                    <label for="inputEmail4">Right Ans Description</label>
                                                                    <textarea class="form-control" name="writeAnsDes[]" id="" rows="3">{{$mcqQuestions->writeAnsDes}}</textarea>
                                                                </div>
                                                                <div class="form-group col-md-2">
                                                                    <label for=""> <span class="text-danger">*</span> Right Mark</label>
                                                                    <input type="text" name="mark[]" value="{{$mcqQuestions->mark}}" class="form-control" id="" required>
                                                                </div>
                                                                <div class="form-group col-md-2">
                                                                    <label for=""> <span class="text-danger">*</span>Negative Mark</label>
                                                                    <input type="text" name="negativeMark[]" value="{{$mcqQuestions->negativeMark}}" class="form-control" id="" required>
                                                                </div>

                                                            </div>
                                                            
                                                        </div>
                                                                    
                                                    </div>
                                                    </td>
                                                </tr>
                                             
                                   
                                   
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">Update</button>
                                </div>
                               
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
