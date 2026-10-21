@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Add New Practice / Preparation Quiz</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('cms.practice_quizzes') }}">Practice Quizzes</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </div>
    <div class="section-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Quiz Information</h4>
                    </div>
                    <form action="{{ route('cms.practice_quiz.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Quiz Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. 46th BCS Preliminary Preparation - Bangladesh Affairs" required>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">-- Select Category (Optional) --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->cat_name ?? $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="target_repetitions">Target Repetitions Per Question <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="target_repetitions" name="target_repetitions" min="1" max="20" value="{{ old('target_repetitions', 4) }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Correct Times</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Number of times a student must answer each question correctly before it is considered mastered. (Default is 4).
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="description">Quiz Description / Instructions</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Brief description of topics covered or preparation guidelines...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Status</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="is_active" value="1" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Active / Published</span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-right">
                            <a href="{{ route('cms.practice_quizzes') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-arrow-right"></i> Save and Add Questions
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
