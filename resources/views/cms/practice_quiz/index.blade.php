@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Practice / Mastery Quizzes</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Practice Quizzes</div>
        </div>
    </div>
    <div class="section-body">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>All Preparation Quizzes</h4>
                        <a href="{{ route('cms.practice_quiz.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Practice Quiz
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Quiz Title</th>
                                        <th>Category</th>
                                        <th>Target Repetitions</th>
                                        <th>Questions</th>
                                        <th>Active Sessions</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quizzes as $index => $quiz)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $quiz->title }}</strong>
                                            @if($quiz->description)
                                                <p class="text-muted mb-0 small">{{ Str::limit($quiz->description, 60) }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($quiz->category)
                                                <span class="badge badge-info">{{ $quiz->category->cat_name ?? $quiz->category->name }}</span>
                                            @else
                                                <span class="badge badge-light text-muted">General</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary" style="font-size: 13px;">
                                                <i class="fas fa-redo-alt"></i> {{ $quiz->target_repetitions }}x Mastery
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cms.practice_quiz.questions', $quiz->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-list-ol"></i> {{ $quiz->questions_count }} Questions
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $quiz->sessions_count }} students</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cms.practice_quiz.toggle', $quiz->id) }}" class="badge {{ $quiz->is_active ? 'badge-success' : 'badge-danger' }}" style="cursor: pointer;" title="Click to toggle status">
                                                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('cms.practice_quiz.questions', $quiz->id) }}" class="btn btn-sm btn-info mr-1" title="Manage Questions">
                                                    <i class="fas fa-question-circle"></i> Questions
                                                </a>
                                                <a href="{{ route('cms.practice_quiz.edit', $quiz->id) }}" class="btn btn-sm btn-warning mr-1" title="Edit Quiz">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('cms.practice_quiz.delete', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Practice Quiz? All questions and student progress will be removed.');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Quiz">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            No practice quizzes created yet. <a href="{{ route('cms.practice_quiz.create') }}">Create the first one!</a>
                                        </td>
                                    </tr>
                                    @endforelse
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
