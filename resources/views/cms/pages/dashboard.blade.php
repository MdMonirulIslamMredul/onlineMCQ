@extends('cms.cms_master')
@section('admin_content')
@php

$totalStudents = DB::table('users')->count('id');
$totalExam =  DB::table('exams')->count('id');
$MCQtotalExam =  DB::table('exams')->where('mcq_written', 'mcq')->count('id');
$WrittentotalExam =  DB::table('exams')->where('mcq_written', 'written')->count('id');
$totalTeachers =  DB::table('teachers')->count('id');





@endphp
<section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
          <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-body card-type-3">
                  <div class="row">
                    <div class="col">
                      <h6 class="text-muted mb-0">Total Students</h6>
                      <span class="h4 text-warning font-weight-bold mb-0">{{$totalStudents}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="card-circle l-bg-orange text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="{{ route('cms.students.all') }}" class="text-info mr-2"><i class="fa fa-arrow-up"></i> See info</a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-body card-type-3">
                  <div class="row">
                    <div class="col">
                      <h6 class="text-muted mb-0">Total Exam</h6>
                      <span class="h4 text-warning font-weight-bold mb-0">{{$totalExam}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="card-circle l-bg-orange text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="{{route('cms.permanent_exams')}}" class="text-info mr-2"><i class="fa fa-arrow-up"></i> See info</a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-body card-type-3">
                  <div class="row">
                    <div class="col">
                      <h6 class="text-muted mb-0">MCQ Exams</h6>
                      <span class="h4 text-warning font-weight-bold mb-0">{{$MCQtotalExam}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="card-circle l-bg-orange text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="{{route('cms.temporary_exams')}}" class="text-info mr-2"><i class="fa fa-arrow-up"></i> See info</a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-body card-type-3">
                  <div class="row">
                    <div class="col">
                      <h6 class="text-muted mb-0">Written Exams</h6>
                      <span class="h4 text-warning font-weight-bold mb-0">{{$WrittentotalExam}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="card-circle l-bg-orange text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="{{route('cms.permanent_exams')}}" class="text-info mr-2"><i class="fa fa-arrow-up"></i> See info</a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-body card-type-3">
                  <div class="row">
                    <div class="col">
                      <h6 class="text-muted mb-0">Total Teachers</h6>
                      <span class="h4 text-warning font-weight-bold mb-0">{{$totalTeachers}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="card-circle l-bg-orange text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <a href="{{ route('cms.teachers') }}" class="text-info mr-2"><i class="fa fa-arrow-up"></i> See info</a>
                  </p>
                </div>
              </div>
            </div>

            

            

            
            

            

          </div>
         
        </section>
        
@endsection