@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1></h1>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="card">
                <div class="card-header">
                    <h3><b>Upload MCQ questions CSV</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form" action="{{route('cms.mcq_questions_csv_confirm')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="first-name-column">MCQ CSV</label>
                                    <input type="file" id="first-name-column" class="form-control" name="csvFile" required />
                                </div>

                                <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-6">
                        <a class="btn btn btn-info btn-lg btn-block" href="{{asset('mcq-questions.csv')}}">MCQ Questions Demo CSV Download</a> <br/>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3><b>Upload Written questions CSV</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form" action="{{route('cms.written_questions_csv_confirm')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="first-name-column">Written Questions CSV</label>
                                    <input type="file" id="first-name-column" class="form-control" name="csvFile" required />
                                </div>

                                <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-6">
                        <a class="btn btn btn-warning btn-lg btn-block" href="{{asset('written-questions.csv')}}">Written Questions Demo CSV Download</a> <br/>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection
