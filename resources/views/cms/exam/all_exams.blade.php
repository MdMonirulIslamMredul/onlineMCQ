@extends('cms.cms_master')
@section('admin_content')

<style>
    /* Filter Tabs Styling */
    .exam-nav-pills {
        display: flex;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .exam-nav-pills .nav-link {
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 15px;
        color: #475569 !important;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-right: 8px;
        margin-bottom: 4px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }
    .exam-nav-pills .nav-link:hover {
        background: #edf2f7;
        color: #0f172a !important;
        border-color: #cbd5e1;
    }
    .exam-nav-pills .nav-link.active {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
        border-color: #4f46e5 !important;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }
    .tab-counter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 20px;
        padding: 0 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800 !important;
        line-height: 1;
        margin-left: 8px;
    }
    /* When tab is active: solid white badge with bold dark indigo text */
    .exam-nav-pills .nav-link.active .tab-counter {
        background-color: #ffffff !important;
        color: #4338ca !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
    }
    /* Inactive tab badge colors */
    .tab-counter-all {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
    }
    .tab-counter-mcq {
        background-color: #bae6fd !important;
        color: #0369a1 !important;
    }
    .tab-counter-written {
        background-color: #fef08a !important;
        color: #854d0e !important;
    }
    .tab-counter-permanent {
        background-color: #bbf7d0 !important;
        color: #166534 !important;
    }
    .tab-counter-temporary {
        background-color: #e2e8f0 !important;
        color: #334155 !important;
    }

    /* Exam Stats Pills (under Exam Name) */
    .exam-stat-tag {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
        line-height: 1.3;
    }
    .exam-stat-id {
        background-color: #f1f5f9;
        color: #1e293b !important;
        border: 1px solid #cbd5e1;
    }
    .exam-stat-id b, .exam-stat-id span {
        color: #1e293b !important;
    }
    .exam-stat-qs {
        background-color: #e0f2fe;
        color: #0369a1 !important;
        border: 1px solid #7dd3fc;
    }
    .exam-stat-qs i, .exam-stat-qs b, .exam-stat-qs span {
        color: #0369a1 !important;
    }
    .exam-stat-marks {
        background-color: #dcfce7;
        color: #15803d !important;
        border: 1px solid #86efac;
    }
    .exam-stat-marks i, .exam-stat-marks b, .exam-stat-marks span {
        color: #15803d !important;
    }

    /* Category Fee Badges */
    .badge-fee-paid {
        background-color: #fff7ed;
        color: #c2410c !important;
        border: 1px solid #fdba74;
        font-weight: 700;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 4px;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-fee-free {
        background-color: #f0fdf4;
        color: #15803d !important;
        border: 1px solid #86efac;
        font-weight: 700;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 4px;
        text-transform: uppercase;
        display: inline-block;
    }

    /* Action buttons spacing */
    .exam-actions-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        flex-wrap: nowrap;
    }
    .exam-actions-wrap .btn {
        border-radius: 5px !important;
        font-weight: 600;
        font-size: 12px;
        padding: 5px 9px;
        display: inline-flex;
        align-items: center;
        line-height: 1.2;
    }
</style>

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <div>
            <h1>{{ $pageTitle ?? 'Exam Management' }}</h1>
            <div class="section-header-breadcrumb mt-1">
                <div class="breadcrumb-item active"><a href="{{ url('/cms') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('cms.all_exams') }}">Exams</a></div>
                <div class="breadcrumb-item">{{ $pageTitle ?? 'List' }}</div>
            </div>
        </div>
        <div>
            <a href="{{ route('cms.add_exams') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle mr-1"></i> Add New Exam
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                <i class="fas fa-check-circle mr-1"></i> {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="section-body">
        <!-- Quick Filter Navigation Tabs -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body py-2 px-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <ul class="exam-nav-pills my-1">
                        <li>
                            <a class="nav-link {{ ($activeTab ?? '') == 'all' ? 'active' : '' }}" href="{{ route('cms.all_exams') }}">
                                <i class="fas fa-layer-group mr-1"></i> All Exams
                                <span class="tab-counter {{ ($activeTab ?? '') == 'all' ? '' : 'tab-counter-all' }}">
                                    {{ $counts['all'] ?? count($exams) }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ ($activeTab ?? '') == 'mcq' ? 'active' : '' }}" href="{{ route('cms.mcq_exams') }}">
                                <i class="fas fa-check-square mr-1"></i> MCQ Exams
                                <span class="tab-counter {{ ($activeTab ?? '') == 'mcq' ? '' : 'tab-counter-mcq' }}">
                                    {{ $counts['mcq'] ?? 0 }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ ($activeTab ?? '') == 'written' ? 'active' : '' }}" href="{{ route('cms.written_exams') }}">
                                <i class="fas fa-pen-alt mr-1"></i> Written Exams
                                <span class="tab-counter {{ ($activeTab ?? '') == 'written' ? '' : 'tab-counter-written' }}">
                                    {{ $counts['written'] ?? 0 }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('cms.permanent_exams') }}">
                                <i class="fas fa-calendar-check mr-1"></i> Permanent
                                <span class="tab-counter tab-counter-permanent">{{ $counts['permanent'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('cms.temporary_exams') }}">
                                <i class="fas fa-clock mr-1"></i> Temporary
                                <span class="tab-counter tab-counter-temporary">{{ $counts['temporary'] ?? 0 }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="my-1">
                        <a href="{{ route('cms.questions.csv') }}" class="btn btn-outline-info btn-sm font-weight-600">
                            <i class="fas fa-file-csv mr-1"></i> CSV Upload Questions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-list-alt text-primary mr-2"></i> {{ $pageTitle ?? 'Exam List' }}
                            <small class="text-muted font-weight-normal">({{ count($exams) }} found)</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Exam Name</th>
                                        <th>Category</th>
                                        <th>Format</th>
                                        <th>Type & Schedule</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th style="min-width: 280px;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach($exams as $exam)
                                        <?php
                                            $i += 1;
                                            $totalQ = $exam->total_questions ?? 0;
                                            $totalMarks = $exam->total_marks ?? 0;
                                            if (!isset($exam->total_questions)) {
                                                if ($exam->mcq_written == 'mcq') {
                                                    $totalQ = DB::table('mcq_questions')->where('examID', $exam->exam_id)->count();
                                                    $totalMarks = DB::table('mcq_questions')->where('examID', $exam->exam_id)->sum('mark');
                                                } else {
                                                    $totalQ = DB::table('written_questions')->where('examID', $exam->exam_id)->count();
                                                    $totalMarks = DB::table('written_questions')->where('examID', $exam->exam_id)->sum('mark');
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold text-muted">{{ $i }}</td>
                                            <td>
                                                <div class="font-weight-bold text-dark" style="font-size: 15px;">
                                                    {{ $exam->exam_name }}
                                                </div>
                                                <div class="mt-1 d-flex flex-wrap align-items-center" style="gap: 6px;">
                                                    <span class="exam-stat-tag exam-stat-id" title="Exam ID">
                                                        <b>ID:</b>&nbsp;#{{ $exam->exam_id }}
                                                    </span>
                                                    <span class="exam-stat-tag exam-stat-qs" title="Total Questions">
                                                        <i class="fas fa-question-circle mr-1"></i><b>{{ $totalQ }}</b>&nbsp;Qs
                                                    </span>
                                                    <span class="exam-stat-tag exam-stat-marks" title="Total Marks">
                                                        <i class="fas fa-award mr-1"></i><b>{{ $totalMarks }}</b>&nbsp;Marks
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-600 text-dark">{{ $exam->cat_name ?? $exam->name ?? 'N/A' }}</div>
                                                <div class="mt-1">
                                                    @if(strtolower($exam->cat_free_paid ?? $exam->free_paid ?? '') == 'paid')
                                                        <span class="badge-fee-paid">Paid</span>
                                                    @else
                                                        <span class="badge-fee-free">Free</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if(strtolower($exam->mcq_written) == 'mcq')
                                                    <span class="badge" style="background-color: #0284c7; color: #ffffff !important; font-weight: 700; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-check-square mr-1"></i> MCQ
                                                    </span>
                                                @else
                                                    <span class="badge" style="background-color: #d97706; color: #ffffff !important; font-weight: 700; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-pen-alt mr-1"></i> Written
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($exam->type == 'permanent')
                                                    <span class="badge" style="background-color: #16a34a; color: #ffffff !important; font-weight: 600; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-infinity mr-1"></i> Permanent
                                                    </span>
                                                @else
                                                    <span class="badge" style="background-color: #475569; color: #ffffff !important; font-weight: 600; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-stopwatch mr-1"></i> Temporary
                                                    </span>
                                                    @if(!empty($exam->startDate))
                                                        <div class="small text-muted mt-1" style="font-size: 11px;">
                                                            <i class="far fa-calendar-alt mr-1"></i>{{ date('d M, Y h:i A', strtotime($exam->startDate)) }}
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-weight-600 text-dark">{{ $exam->examTime }}</span> <small class="text-muted">min</small>
                                            </td>
                                            <td>
                                                @if($exam->exam_active == 1)
                                                    <span class="badge" style="background-color: #16a34a; color: #ffffff !important; font-weight: 600; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-check-circle mr-1"></i> Published
                                                    </span>
                                                @else
                                                    <span class="badge" style="background-color: #dc2626; color: #ffffff !important; font-weight: 600; padding: 5px 10px; font-size: 12px; border-radius: 4px;">
                                                        <i class="fas fa-times-circle mr-1"></i> Unpublished
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="exam-actions-wrap">
                                                    <!-- Edit Exam Button -->
                                                    <a href="{{ url('/cms/edit-exam/'.$exam->exam_id) }}" class="btn btn-primary" title="Edit Exam Information">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>

                                                    <!-- View Questions Button -->
                                                    @if(strtolower($exam->mcq_written) == 'mcq')
                                                        <a href="{{ url('/cms/exam-mcq-questions/'.$exam->exam_id) }}" class="btn btn-warning" title="Manage MCQ Questions" style="background-color: #f59e0b; border-color: #f59e0b; color: #ffffff !important;">
                                                            <i class="fas fa-list-ol mr-1"></i> Questions
                                                        </a>
                                                        <a href="{{ url('/cms/add_mcq_question/'.$exam->exam_id) }}" class="btn btn-info" title="Add New MCQ Question" style="background-color: #0ea5e9; border-color: #0ea5e9; color: #ffffff !important;">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ url('/cms/exam-written-questions/'.$exam->exam_id) }}" class="btn btn-warning" title="Manage Written Questions" style="background-color: #f59e0b; border-color: #f59e0b; color: #ffffff !important;">
                                                            <i class="fas fa-list-ol mr-1"></i> Questions
                                                        </a>
                                                        <a href="{{ url('/cms/add_written_question/'.$exam->exam_id) }}" class="btn btn-info" title="Add New Written Question" style="background-color: #0ea5e9; border-color: #0ea5e9; color: #ffffff !important;">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    @endif

                                                    <!-- Result Button -->
                                                    <a href="{{ url('/cms/result/'.$exam->exam_id) }}" class="btn btn-dark" title="View Results" style="background-color: #1e293b; border-color: #1e293b; color: #ffffff !important;">
                                                        <i class="fas fa-poll mr-1"></i> Result
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('cms.delete.exam', $exam->exam_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this exam? All associated questions will be removed.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete Exam" style="background-color: #ef4444; border-color: #ef4444;">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
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
