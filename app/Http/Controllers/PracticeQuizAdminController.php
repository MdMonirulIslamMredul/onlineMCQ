<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PracticeQuiz;
use App\Models\PracticeQuestion;
use App\Models\PracticeSession;
use App\Models\categories;

class PracticeQuizAdminController extends Controller
{
    /**
     * Display a listing of practice quizzes.
     */
    public function index()
    {
        $quizzes = PracticeQuiz::with('category')
            ->withCount(['questions', 'sessions'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('cms.practice_quiz.index', compact('quizzes'));
    }

    /**
     * Show form for creating a new practice quiz.
     */
    public function create()
    {
        $categories = categories::orderBy('name', 'ASC')->get();
        return view('cms.practice_quiz.create', compact('categories'));
    }

    /**
     * Store a newly created practice quiz.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_repetitions' => 'required|integer|min:1|max:20',
            'category_id' => 'nullable|integer',
        ]);

        $slugBase = Str::slug($request->title);
        $slug = $slugBase;
        $counter = 1;
        while (PracticeQuiz::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter++;
        }

        $quiz = PracticeQuiz::create([
            'category_id' => $request->category_id ?: null,
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'target_repetitions' => $request->target_repetitions ?: 4,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return redirect()->route('cms.practice_quiz.questions', $quiz->id)
            ->with('status', 'Practice Quiz created successfully! Now you can add questions.');
    }

    /**
     * Show form for editing the practice quiz.
     */
    public function edit($id)
    {
        $quiz = PracticeQuiz::findOrFail($id);
        $categories = categories::orderBy('name', 'ASC')->get();
        return view('cms.practice_quiz.edit', compact('quiz', 'categories'));
    }

    /**
     * Update the specified practice quiz.
     */
    public function update(Request $request, $id)
    {
        $quiz = PracticeQuiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'target_repetitions' => 'required|integer|min:1|max:20',
            'category_id' => 'nullable|integer',
        ]);

        if ($quiz->title !== $request->title) {
            $slugBase = Str::slug($request->title);
            $slug = $slugBase;
            $counter = 1;
            while (PracticeQuiz::where('slug', $slug)->where('id', '!=', $quiz->id)->exists()) {
                $slug = $slugBase . '-' . $counter++;
            }
            $quiz->slug = $slug;
        }

        $quiz->category_id = $request->category_id ?: null;
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->target_repetitions = $request->target_repetitions ?: 4;
        $quiz->is_active = $request->has('is_active') ? (bool)$request->is_active : true;
        $quiz->save();

        return redirect()->route('cms.practice_quizzes')
            ->with('status', 'Practice Quiz updated successfully.');
    }

    /**
     * Delete the specified practice quiz.
     */
    public function destroy($id)
    {
        $quiz = PracticeQuiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('cms.practice_quizzes')
            ->with('status', 'Practice Quiz deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus($id)
    {
        $quiz = PracticeQuiz::findOrFail($id);
        $quiz->is_active = !$quiz->is_active;
        $quiz->save();

        return back()->with('status', 'Status changed successfully.');
    }

    /**
     * Display and manage questions for a practice quiz.
     */
    public function questionsIndex($id)
    {
        $quiz = PracticeQuiz::with('category')->findOrFail($id);
        $questions = PracticeQuestion::where('practice_quiz_id', $id)->orderBy('id', 'ASC')->get();

        return view('cms.practice_quiz.questions', compact('quiz', 'questions'));
    }

    /**
     * Save/Update questions for a practice quiz.
     */
    public function saveQuestions(Request $request, $id)
    {
        $quiz = PracticeQuiz::findOrFail($id);

        if (!empty($request->questions)) {
            $count = count($request->questions);

            for ($i = 0; $i < $count; $i++) {
                if (empty(trim($request->questions[$i]))) {
                    continue;
                }

                $qId = isset($request->q_id[$i]) ? $request->q_id[$i] : 0;
                $data = [
                    'practice_quiz_id' => $quiz->id,
                    'question' => $request->questions[$i],
                    'optn1' => $request->optn1[$i] ?? '',
                    'optn2' => $request->optn2[$i] ?? '',
                    'optn3' => $request->optn3[$i] ?? null,
                    'optn4' => $request->optn4[$i] ?? null,
                    'optn5' => $request->optn5[$i] ?? null,
                    'right_ans' => (int)($request->right_ans[$i] ?? 1),
                    'explanation' => $request->explanation[$i] ?? null,
                ];

                if ($qId > 0) {
                    PracticeQuestion::where('id', $qId)->where('practice_quiz_id', $quiz->id)->update($data);
                } else {
                    PracticeQuestion::create($data);
                }
            }

            // Sync total questions in active sessions
            $totalQ = PracticeQuestion::where('practice_quiz_id', $quiz->id)->count();
            PracticeSession::where('practice_quiz_id', $quiz->id)->update(['total_questions' => $totalQ]);

            return back()->with('status', 'Questions saved successfully!');
        }

        return back()->with('error', 'No questions provided.');
    }

    /**
     * Delete a single question.
     */
    public function deleteQuestion($quizId, $questionId)
    {
        $question = PracticeQuestion::where('id', $questionId)
            ->where('practice_quiz_id', $quizId)
            ->firstOrFail();

        $question->delete();

        // Update total questions count in sessions
        $totalQ = PracticeQuestion::where('practice_quiz_id', $quizId)->count();
        PracticeSession::where('practice_quiz_id', $quizId)->update(['total_questions' => $totalQ]);

        return back()->with('status', 'Question deleted successfully.');
    }

    /**
     * Upload questions via CSV.
     */
    public function uploadCsv(Request $request, $id)
    {
        $quiz = PracticeQuiz::findOrFail($id);

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        $inserted = 0;
        $rowNum = 0;

        while (($row = fgetcsv($file, 10000, ',')) !== false) {
            $rowNum++;
            // Check if first row is header
            if ($rowNum === 1 && (strtolower($row[0]) === 'question' || strtolower($row[0]) === 'quiz_id')) {
                continue;
            }

            // If 1st column is quiz ID or directly the question:
            $offset = 0;
            if (is_numeric($row[0]) && count($row) >= 8) {
                // First column is quiz ID
                $offset = 1;
            }

            $questionText = trim($row[$offset] ?? '');
            if (empty($questionText)) {
                continue;
            }

            $optn1 = trim($row[$offset + 1] ?? '');
            $optn2 = trim($row[$offset + 2] ?? '');
            $optn3 = trim($row[$offset + 3] ?? '');
            $optn4 = trim($row[$offset + 4] ?? '');
            $optn5 = trim($row[$offset + 5] ?? '');
            $rightAns = (int)trim($row[$offset + 6] ?? '1');
            $explanation = trim($row[$offset + 7] ?? '');

            if (!empty($optn1) && !empty($optn2)) {
                PracticeQuestion::create([
                    'practice_quiz_id' => $quiz->id,
                    'question' => $questionText,
                    'optn1' => $optn1,
                    'optn2' => $optn2,
                    'optn3' => $optn3 ?: null,
                    'optn4' => $optn4 ?: null,
                    'optn5' => $optn5 ?: null,
                    'right_ans' => ($rightAns >= 1 && $rightAns <= 5) ? $rightAns : 1,
                    'explanation' => $explanation ?: null,
                ]);
                $inserted++;
            }
        }
        fclose($file);

        // Update session total questions
        $totalQ = PracticeQuestion::where('practice_quiz_id', $quiz->id)->count();
        PracticeSession::where('practice_quiz_id', $quiz->id)->update(['total_questions' => $totalQ]);

        return back()->with('status', "Successfully imported {$inserted} questions from CSV!");
    }
}
