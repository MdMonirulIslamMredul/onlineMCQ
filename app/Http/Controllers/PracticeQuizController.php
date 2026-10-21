<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PracticeQuiz;
use App\Models\PracticeQuestion;
use App\Models\PracticeSession;
use App\Models\PracticeSessionQuestion;
use App\Models\categories;
use App\Models\User;

class PracticeQuizController extends Controller
{
    /**
     * Helper to get current logged in student ID.
     */
    protected function getStudentId()
    {
        $id = Cookie::get('user_id');
        if (!empty($id)) {
            return (int)$id;
        }
        if (auth()->check()) {
            return (int)auth()->id();
        }
        return null;
    }

    /**
     * Public listing of practice quizzes.
     */
    public function index(Request $request)
    {
        $userId = $this->getStudentId();
        $catId = $request->get('cat');
        $search = $request->get('q');

        $query = PracticeQuiz::where('is_active', true)
            ->with('category')
            ->withCount('questions');

        if ($catId) {
            $query->where('category_id', $catId);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $quizzes = $query->orderBy('id', 'DESC')->paginate(12);

        // Attach user session state if logged in
        if ($userId) {
            $sessions = PracticeSession::where('user_id', $userId)
                ->whereIn('practice_quiz_id', $quizzes->pluck('id'))
                ->get()
                ->keyBy('practice_quiz_id');

            foreach ($quizzes as $quiz) {
                $quiz->user_session = $sessions->get($quiz->id);
            }
        }

        $categories = categories::orderBy('name', 'ASC')->get();

        return view('user.pages.practice_quiz.index', compact('quizzes', 'categories', 'catId', 'search'));
    }

    /**
     * Overview / Start page for a practice quiz.
     */
    public function show($slug)
    {
        $quiz = PracticeQuiz::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->withCount('questions')
            ->firstOrFail();

        $userId = $this->getStudentId();
        $userSession = null;

        if ($userId) {
            $userSession = PracticeSession::where('user_id', $userId)
                ->where('practice_quiz_id', $quiz->id)
                ->first();
        }

        return view('user.pages.practice_quiz.show', compact('quiz', 'userSession'));
    }

    /**
     * Start or resume a practice session.
     */
    public function start(Request $request, $id)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            return redirect()->route('user.login_or_signup')->with('notAllow', 'Please login to start your preparation quiz.');
        }

        $quiz = PracticeQuiz::where('id', $id)->where('is_active', true)->withCount('questions')->firstOrFail();

        if ($quiz->questions_count === 0) {
            return back()->with('error', 'This quiz does not have any questions yet. Please try another one.');
        }

        // Find or create session
        $session = PracticeSession::firstOrCreate(
            ['user_id' => $userId, 'practice_quiz_id' => $quiz->id],
            [
                'total_questions' => $quiz->questions_count,
                'mastered_questions' => 0,
                'total_attempts' => 0,
                'correct_attempts' => 0,
                'status' => 'in_progress',
            ]
        );

        // If session was already completed or restart explicitly requested, reset progress for a fresh practice!
        if ($session->status === 'completed' || $request->has('restart')) {
            PracticeSessionQuestion::where('session_id', $session->id)->update([
                'correct_count' => 0,
                'incorrect_count' => 0,
                'is_mastered' => false,
                'last_answered_at' => null,
            ]);

            $session->mastered_questions = 0;
            $session->total_attempts = 0;
            $session->correct_attempts = 0;
            $session->status = 'in_progress';
            $session->completed_at = null;
            $session->save();
        }

        // Update total questions count in case questions were added/removed
        if ($session->total_questions !== $quiz->questions_count) {
            $session->total_questions = $quiz->questions_count;
            $session->save();
        }

        // Initialize question rows for session if not already existing
        $existingQIds = PracticeSessionQuestion::where('session_id', $session->id)->pluck('question_id')->toArray();
        $allQuizQIds = PracticeQuestion::where('practice_quiz_id', $quiz->id)->pluck('id')->toArray();

        $missingQIds = array_diff($allQuizQIds, $existingQIds);
        if (!empty($missingQIds)) {
            $insertBatch = [];
            $now = Carbon::now();
            foreach ($missingQIds as $qId) {
                $insertBatch[] = [
                    'session_id' => $session->id,
                    'question_id' => $qId,
                    'correct_count' => 0,
                    'incorrect_count' => 0,
                    'is_mastered' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            PracticeSessionQuestion::insert($insertBatch);
        }

        return redirect()->route('practice_quiz.play', $session->id);
    }

    /**
     * The gamified play screen.
     */
    public function play($sessionId)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            return redirect()->route('user.login_or_signup')->with('notAllow', 'Please login to continue.');
        }

        $session = PracticeSession::where('id', $sessionId)
            ->with('quiz.category')
            ->firstOrFail();

        // If this session belongs to another user, redirect to current user's session
        if ($session->user_id !== $userId) {
            $userSession = PracticeSession::where('practice_quiz_id', $session->practice_quiz_id)
                ->where('user_id', $userId)
                ->first();
            if ($userSession) {
                return redirect()->route('practice_quiz.play', $userSession->id);
            }
            return redirect()->route('practice_quiz.start', $session->practice_quiz_id);
        }

        return view('user.pages.practice_quiz.play', compact('session'));
    }

    /**
     * API: Get the next unmastered question for the session.
     */
    public function apiGetNextQuestion(Request $request, $sessionId)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $session = PracticeSession::where('id', $sessionId)
            ->with('quiz')
            ->firstOrFail();

        if ($session->user_id !== $userId) {
            $session = PracticeSession::where('practice_quiz_id', $session->practice_quiz_id)
                ->where('user_id', $userId)
                ->with('quiz')
                ->firstOrFail();
        }

        // Check unmastered questions
        $unmasteredQuestions = PracticeSessionQuestion::where('session_id', $session->id)
            ->where('is_mastered', false)
            ->get();

        if ($unmasteredQuestions->isEmpty()) {
            // All questions mastered! Mark session complete
            if ($session->status !== 'completed') {
                $session->status = 'completed';
                $session->completed_at = Carbon::now();
                $session->mastered_questions = $session->total_questions;
                $session->save();
            }

            return response()->json([
                'session_completed' => true,
                'stats' => [
                    'total_questions' => $session->total_questions,
                    'mastered_questions' => $session->mastered_questions,
                    'total_attempts' => $session->total_attempts,
                    'correct_attempts' => $session->correct_attempts,
                    'accuracy' => $session->total_attempts > 0 ? round(($session->correct_attempts / $session->total_attempts) * 100) : 100,
                ],
            ]);
        }

        // Exclude previous question if there is more than 1 question left
        $excludeQId = (int)$request->query('exclude_id', 0);
        $candidates = $unmasteredQuestions;
        if ($candidates->count() > 1 && $excludeQId > 0) {
            $filtered = $candidates->filter(function ($item) use ($excludeQId) {
                return $item->question_id !== $excludeQId;
            });
            if ($filtered->isNotEmpty()) {
                $candidates = $filtered;
            }
        }

        // Randomly pick one from candidates
        $selectedSessionQ = $candidates->random();
        $question = PracticeQuestion::findOrFail($selectedSessionQ->question_id);

        return response()->json([
            'session_completed' => false,
            'question' => [
                'id' => $question->id,
                'question' => $question->question,
                'optn1' => $question->optn1,
                'optn2' => $question->optn2,
                'optn3' => $question->optn3,
                'optn4' => $question->optn4,
                'optn5' => $question->optn5,
                'correct_count' => $selectedSessionQ->correct_count,
                'target_repetitions' => $session->quiz->target_repetitions,
            ],
            'session' => [
                'mastered_questions' => $session->mastered_questions,
                'total_questions' => $session->total_questions,
                'progress_percent' => $session->progress_percent,
                'target_repetitions' => $session->quiz->target_repetitions,
            ],
        ]);
    }

    /**
     * API: Submit answer for current question and evaluate.
     */
    public function apiSubmitAnswer(Request $request, $sessionId)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'question_id' => 'required|integer',
            'selected_option' => 'required|integer|min:1|max:5',
        ]);

        $session = PracticeSession::where('id', $sessionId)
            ->with('quiz')
            ->firstOrFail();

        if ($session->user_id !== $userId) {
            $session = PracticeSession::where('practice_quiz_id', $session->practice_quiz_id)
                ->where('user_id', $userId)
                ->with('quiz')
                ->firstOrFail();
        }

        $question = PracticeQuestion::where('id', $request->question_id)
            ->where('practice_quiz_id', $session->practice_quiz_id)
            ->firstOrFail();

        $sessionQ = PracticeSessionQuestion::where('session_id', $session->id)
            ->where('question_id', $question->id)
            ->firstOrFail();

        $isCorrect = ((int)$question->right_ans === (int)$request->selected_option);

        // Update question stats
        if ($isCorrect) {
            $sessionQ->correct_count += 1;
            if ($sessionQ->correct_count >= $session->quiz->target_repetitions) {
                $sessionQ->is_mastered = true;
            }
        } else {
            $sessionQ->incorrect_count += 1;
        }

        $sessionQ->last_answered_at = Carbon::now();
        $sessionQ->save();

        // Update session stats
        $session->total_attempts += 1;
        if ($isCorrect) {
            $session->correct_attempts += 1;
        }

        $masteredCount = PracticeSessionQuestion::where('session_id', $session->id)
            ->where('is_mastered', true)
            ->count();

        $session->mastered_questions = $masteredCount;

        $isCompleted = false;
        if ($masteredCount >= $session->total_questions && $session->total_questions > 0) {
            $session->status = 'completed';
            $session->completed_at = Carbon::now();
            $isCompleted = true;
        }
        $session->save();

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'selected_option' => (int)$request->selected_option,
            'right_ans' => (int)$question->right_ans,
            'explanation' => $question->explanation ?: null,
            'correct_count' => $sessionQ->correct_count,
            'target_repetitions' => $session->quiz->target_repetitions,
            'question_mastered' => (bool)$sessionQ->is_mastered,
            'mastered_questions' => $session->mastered_questions,
            'total_questions' => $session->total_questions,
            'progress_percent' => $session->progress_percent,
            'session_completed' => $isCompleted,
        ]);
    }

    /**
     * Restart / Reset a practice quiz session.
     */
    public function restartSession(Request $request, $sessionId)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('user.login_or_signup');
        }

        $session = PracticeSession::where('id', $sessionId)->firstOrFail();

        // Ensure session belongs to current user or find/create current user's session
        if ($session->user_id !== $userId) {
            $userSession = PracticeSession::where('practice_quiz_id', $session->practice_quiz_id)
                ->where('user_id', $userId)
                ->first();
            if ($userSession) {
                $session = $userSession;
            } else {
                return redirect()->route('practice_quiz.start', ['id' => $session->practice_quiz_id, 'restart' => 1]);
            }
        }

        // Reset all question progress
        PracticeSessionQuestion::where('session_id', $session->id)->update([
            'correct_count' => 0,
            'incorrect_count' => 0,
            'is_mastered' => false,
            'last_answered_at' => null,
        ]);

        // Reset session
        $session->mastered_questions = 0;
        $session->total_attempts = 0;
        $session->correct_attempts = 0;
        $session->status = 'in_progress';
        $session->completed_at = null;
        $session->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Quiz progress reset! Good luck on your practice.',
                'session_id' => $session->id,
            ]);
        }

        return redirect()->route('practice_quiz.play', $session->id)
            ->with('status', 'Quiz progress reset! Good luck on your practice.');
    }

    /**
     * Review all questions and explanations.
     */
    public function review($sessionId)
    {
        $userId = $this->getStudentId();
        if (!$userId) {
            return redirect()->route('user.login_or_signup');
        }

        $session = PracticeSession::where('id', $sessionId)
            ->where('user_id', $userId)
            ->with(['quiz.category', 'sessionQuestions.question'])
            ->firstOrFail();

        return view('user.pages.practice_quiz.review', compact('session'));
    }
}
