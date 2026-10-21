@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Manage Questions: {{ $quiz->title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('cms.practice_quizzes') }}">Practice Quizzes</a></div>
            <div class="breadcrumb-item">Questions</div>
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Summary & CSV Upload Section -->
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="card card-hero card-primary mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header" style="background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); padding: 25px;">
                        <div class="card-icon" style="color: rgba(255,255,255,0.2);"><i class="fas fa-brain"></i></div>
                        <h4 style="font-size: 22px; font-weight: 700; color: #fff;">{{ $quiz->title }}</h4>
                        <div class="card-description" style="color: rgba(255,255,255,0.9);">
                            Category: <strong>{{ $quiz->category ? ($quiz->category->cat_name ?? $quiz->category->name) : 'General' }}</strong> |
                            Mastery Repetitions: <strong>{{ $quiz->target_repetitions }}x</strong> |
                            Total Questions: <strong>{{ $questions->count() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="card mb-4" style="border-radius: 12px;">
                    <div class="card-header bg-light">
                        <h4><i class="fas fa-file-csv text-success"></i> Bulk Upload via CSV</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cms.practice_quiz.upload_csv', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-2">
                                <label class="small text-muted mb-1">CSV Format: <code>Question, Optn1, Optn2, Optn3, Optn4, Optn5, RightAns(1-5), Explanation</code></label>
                                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm btn-block mt-2">
                                <i class="fas fa-cloud-upload-alt"></i> Import Questions CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add / Edit Questions Form -->
        <div class="row">
            <div class="col-12">
                <form action="{{ route('cms.practice_quiz.questions.save', $quiz->id) }}" method="POST">
                    @csrf
                    <div class="card" style="border-radius: 12px;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Quiz Questions Bank ({{ $questions->count() }})</h4>
                            <div>
                                <button type="button" id="addNewQuestionBtn" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Another Question
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm ml-2">
                                    <i class="fas fa-save"></i> Save All Changes
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="questionsContainer">
                            @php $qIndex = 0; @endphp
                            @forelse($questions as $question)
                                @php $qIndex++; @endphp
                                <div class="question-block card border mb-4 shadow-sm" style="border-left: 5px solid #4f46e5 !important; border-radius: 8px;">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <h6 class="mb-0 text-primary font-weight-bold">
                                            <span class="badge badge-primary mr-2">Q{{ $qIndex }}</span> Question #{{ $qIndex }}
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <input type="hidden" name="q_id[]" value="{{ $question->id }}">
                                            <a href="{{ route('cms.practice_quiz.questions.delete', ['quizId' => $quiz->id, 'questionId' => $question->id]) }}" 
                                               onclick="return confirm('Delete this question permanently?');" 
                                               class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Question Text <span class="text-danger">*</span></label>
                                            <textarea name="questions[]" class="form-control" rows="2" required>{{ $question->question }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold">Option 1 <span class="text-danger">*</span></label>
                                                <input type="text" name="optn1[]" class="form-control" value="{{ $question->optn1 }}" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold">Option 2 <span class="text-danger">*</span></label>
                                                <input type="text" name="optn2[]" class="form-control" value="{{ $question->optn2 }}" required>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold">Option 3</label>
                                                <input type="text" name="optn3[]" class="form-control" value="{{ $question->optn3 }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold">Option 4</label>
                                                <input type="text" name="optn4[]" class="form-control" value="{{ $question->optn4 }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold">Option 5 (Optional)</label>
                                                <input type="text" name="optn5[]" class="form-control" value="{{ $question->optn5 }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="small font-weight-bold text-success"><i class="fas fa-check-circle"></i> Correct Answer <span class="text-danger">*</span></label>
                                                <select name="right_ans[]" class="form-control font-weight-bold border-success">
                                                    <option value="1" {{ $question->right_ans == 1 ? 'selected' : '' }}>Option 1 is Correct</option>
                                                    <option value="2" {{ $question->right_ans == 2 ? 'selected' : '' }}>Option 2 is Correct</option>
                                                    <option value="3" {{ $question->right_ans == 3 ? 'selected' : '' }}>Option 3 is Correct</option>
                                                    <option value="4" {{ $question->right_ans == 4 ? 'selected' : '' }}>Option 4 is Correct</option>
                                                    <option value="5" {{ $question->right_ans == 5 ? 'selected' : '' }}>Option 5 is Correct</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="small font-weight-bold text-info"><i class="fas fa-lightbulb"></i> Explanation / Discussion (Shown to student on incorrect answer)</label>
                                            <textarea name="explanation[]" class="form-control" rows="2" placeholder="Explain why this answer is correct to help students learn...">{{ $question->explanation }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div id="emptyNotice" class="text-center py-4 text-muted">
                                    <i class="fas fa-question-circle fa-3x mb-3 text-secondary"></i>
                                    <h5>No questions added yet</h5>
                                    <p>Click the "Add Another Question" button below or upload a CSV file above to start adding questions.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="card-footer bg-whitesmoke d-flex justify-content-between align-items-center">
                            <button type="button" id="addNewQuestionBottomBtn" class="btn btn-outline-primary">
                                <i class="fas fa-plus"></i> Add Another Question
                            </button>
                            <div>
                                <a href="{{ route('cms.practice_quizzes') }}" class="btn btn-secondary mr-2">Back to List</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save"></i> Save Questions
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Template for Dynamic Question Addition -->
<template id="newQuestionTemplate">
    <div class="question-block card border mb-4 shadow-sm" style="border-left: 5px solid #10b981 !important; border-radius: 8px;">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 text-success font-weight-bold">
                <span class="badge badge-success mr-2">NEW</span> New Question <span class="new-q-number"></span>
            </h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-question-btn">
                <i class="fas fa-times"></i> Remove
            </button>
        </div>
        <div class="card-body">
            <input type="hidden" name="q_id[]" value="0">
            <div class="form-group mb-3">
                <label class="font-weight-bold">Question Text <span class="text-danger">*</span></label>
                <textarea name="questions[]" class="form-control" rows="2" placeholder="Write question here..." required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Option 1 <span class="text-danger">*</span></label>
                    <input type="text" name="optn1[]" class="form-control" placeholder="Option 1 text" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Option 2 <span class="text-danger">*</span></label>
                    <input type="text" name="optn2[]" class="form-control" placeholder="Option 2 text" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Option 3</label>
                    <input type="text" name="optn3[]" class="form-control" placeholder="Option 3 text">
                </div>
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Option 4</label>
                    <input type="text" name="optn4[]" class="form-control" placeholder="Option 4 text">
                </div>
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Option 5 (Optional)</label>
                    <input type="text" name="optn5[]" class="form-control" placeholder="Option 5 text">
                </div>
                <div class="col-md-6 form-group">
                    <label class="small font-weight-bold text-success"><i class="fas fa-check-circle"></i> Correct Answer <span class="text-danger">*</span></label>
                    <select name="right_ans[]" class="form-control font-weight-bold border-success">
                        <option value="1">Option 1 is Correct</option>
                        <option value="2">Option 2 is Correct</option>
                        <option value="3">Option 3 is Correct</option>
                        <option value="4">Option 4 is Correct</option>
                        <option value="5">Option 5 is Correct</option>
                    </select>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="small font-weight-bold text-info"><i class="fas fa-lightbulb"></i> Explanation / Discussion (Shown on incorrect answer)</label>
                <textarea name="explanation[]" class="form-control" rows="2" placeholder="Explain why this answer is correct..."></textarea>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('questionsContainer');
    const template = document.getElementById('newQuestionTemplate');
    const emptyNotice = document.getElementById('emptyNotice');
    let newCounter = 1;

    function addQuestionBlock() {
        if (emptyNotice) {
            emptyNotice.style.display = 'none';
        }
        const clone = template.content.cloneNode(true);
        const numberSpan = clone.querySelector('.new-q-number');
        if (numberSpan) {
            numberSpan.textContent = '#' + newCounter++;
        }
        const removeBtn = clone.querySelector('.remove-question-btn');
        removeBtn.addEventListener('click', function (e) {
            e.target.closest('.question-block').remove();
        });
        container.appendChild(clone);
    }

    document.getElementById('addNewQuestionBtn')?.addEventListener('click', addQuestionBlock);
    document.getElementById('addNewQuestionBottomBtn')?.addEventListener('click', addQuestionBlock);

    // If no questions initially, automatically add 1 block
    if (document.querySelectorAll('.question-block').length === 0) {
        addQuestionBlock();
    }
});
</script>
@endsection
