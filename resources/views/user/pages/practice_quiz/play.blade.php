@extends('user.pages.test_master')

@push('test_style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Full game view container */
    .game-wrapper {
        min-height: calc(100vh - 120px);
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 40px 0;
        transition: background 0.3s ease;
    }
    .game-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 40px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .game-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .game-badge-streak {
        background: linear-gradient(135deg, #ffedd5 0%, #fee2e2 100%);
        color: #ea580c;
        border: 1px solid #fed7aa;
        font-weight: 800;
        font-size: 14px;
        padding: 6px 16px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .game-mastery-meter {
        height: 10px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
        flex-grow: 1;
        max-width: 280px;
    }
    .game-mastery-fill {
        height: 100%;
        background: linear-gradient(90deg, #03c6bb 0%, #4f46e5 100%);
        border-radius: 10px;
        transition: width 0.4s ease;
    }
    .question-title {
        font-size: clamp(20px, 2.5vw, 26px);
        font-weight: 700;
        color: #0f172a;
        line-height: 1.5;
        margin-bottom: 28px;
    }
    .option-btn {
        width: 100%;
        text-align: left;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 14px;
        font-size: 16px;
        font-weight: 500;
        color: #1e293b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .option-btn:hover:not(:disabled) {
        border-color: #03c6bb;
        background: #f0fdfa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(3, 198, 187, 0.12);
    }
    .option-letter {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .option-btn:hover:not(:disabled) .option-letter {
        background: #03c6bb;
        color: #ffffff;
    }

    /* Option States */
    .option-btn.selected-correct {
        background: #ecfdf5 !important;
        border-color: #10b981 !important;
        color: #065f46 !important;
        animation: correctPulse 0.4s ease;
    }
    .option-btn.selected-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    .option-btn.selected-incorrect {
        background: #fef2f2 !important;
        border-color: #ef4444 !important;
        color: #991b1b !important;
        animation: shake 0.4s ease;
    }
    .option-btn.selected-incorrect .option-letter {
        background: #ef4444 !important;
        color: #ffffff !important;
    }

    .option-btn.reveal-correct {
        background: #ecfdf5 !important;
        border-color: #10b981 !important;
        border-style: dashed !important;
        color: #065f46 !important;
    }
    .option-btn.reveal-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-8px); }
        40%, 80% { transform: translateX(8px); }
    }
    @keyframes correctPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    /* Feedback Banner */
    .feedback-panel {
        border-radius: 18px;
        padding: 20px 24px;
        margin-top: 24px;
        animation: slideUp 0.3s ease;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .feedback-panel.correct {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }
    .feedback-panel.incorrect {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* Repetition Stars */
    .repetition-pills {
        display: inline-flex;
        gap: 4px;
        align-items: center;
    }
    .repetition-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #cbd5e1;
        transition: all 0.3s;
    }
    .repetition-dot.active {
        background: #f59e0b;
        box-shadow: 0 0 6px rgba(245, 158, 11, 0.5);
    }

    /* Sound button */
    .sound-toggle-btn {
        background: transparent;
        border: 1px solid #cbd5e1;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }
    .sound-toggle-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Victory Screen */
    .victory-card {
        text-align: center;
        padding: 50px 30px;
        animation: slideUp 0.5s ease;
    }
    .victory-trophy {
        font-size: 72px;
        animation: bounce 1.2s infinite alternate ease-in-out;
        display: inline-block;
        margin-bottom: 20px;
    }
    @keyframes bounce {
        from { transform: translateY(0); }
        to { transform: translateY(-12px); }
    }

    /* Dark Mode Overrides */
    body.dark .game-wrapper {
        background: #090e17 !important;
    }
    body.dark .game-card {
        background: #111827 !important;
        border-color: #1f2937 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
    }
    body.dark .question-title {
        color: #f1f5f9 !important;
    }
    body.dark .option-btn {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #e2e8f0 !important;
    }
    body.dark .option-btn:hover:not(:disabled) {
        background: #0f2c39 !important;
        border-color: #03c6bb !important;
    }
    body.dark .option-letter {
        background: #334155 !important;
        color: #cbd5e1 !important;
    }
    body.dark .option-btn.selected-correct {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #a7f3d0 !important;
    }
    body.dark .option-btn.selected-incorrect {
        background: #7f1d1d !important;
        border-color: #dc2626 !important;
        color: #fecaca !important;
    }
    body.dark .option-btn.reveal-correct {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #a7f3d0 !important;
    }
    body.dark .feedback-panel.correct {
        background: #064e3b !important;
        border-color: #059669 !important;
        color: #a7f3d0 !important;
    }
    body.dark .feedback-panel.incorrect {
        background: #7f1d1d !important;
        border-color: #dc2626 !important;
        color: #fecaca !important;
    }
    body.dark .game-badge-streak {
        background: #451a03 !important;
        border-color: #78350f !important;
        color: #fdba74 !important;
    }
    body.dark .sound-toggle-btn {
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    body.dark .sound-toggle-btn:hover {
        background: #1e293b !important;
        color: #ffffff !important;
    }
    body.dark .game-mastery-meter {
        background: #1f2937 !important;
    }
</style>
@endpush

@section('content')
<div class="game-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <!-- Top Navigation & Dashboard Link -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('user.myaccount.dashboard') }}" class="btn btn-sm btn-link text-decoration-none text-muted p-0 d-flex align-items-center gap-1">
                        <i class="feather-arrow-left"></i> Exit to Dashboard
                    </a>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="soundToggleBtn" class="sound-toggle-btn" title="Toggle Sound">
                            <i class="feather-volume-2" id="soundIcon"></i>
                        </button>
                        <a href="{{ route('practice_quiz.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            All Quizzes
                        </a>
                    </div>
                </div>

                <!-- Active Game Card Container -->
                <div class="game-card" id="gameCard">
                    <!-- Top Game Stats Bar -->
                    <div class="game-header-bar">
                        <div class="d-flex align-items-center gap-3">
                            <span class="game-badge-streak" id="streakBadge">
                                🔥 Streak: <span id="streakCount">0</span>
                            </span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small font-weight-bold" style="color: #64748b;" id="questionRepetitionText">
                                    Mastery: 0/{{ $session->quiz->target_repetitions }}
                                </span>
                                <div class="repetition-pills" id="repetitionPillsContainer">
                                    @for($i = 0; $i < $session->quiz->target_repetitions; $i++)
                                        <span class="repetition-dot" id="repDot-{{ $i }}"></span>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div class="small font-weight-bold" style="color: #03c6bb;" id="sessionProgressLabel">
                                {{ $session->mastered_questions }}/{{ $session->total_questions }} Mastered ({{ $session->progress_percent }}%)
                            </div>
                            <div class="game-mastery-meter">
                                <div class="game-mastery-fill" id="sessionProgressFill" style="width: {{ $session->progress_percent }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Question Loading State -->
                    <div id="loadingState" class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5 class="text-muted">Loading next question...</h5>
                    </div>

                    <!-- Question Play State -->
                    <div id="questionState" style="display: none;">
                        <h3 class="question-title" id="questionText">Question text goes here</h3>

                        <!-- Options Container -->
                        <div id="optionsContainer">
                            <!-- Dynamic Option Buttons will be rendered here -->
                        </div>

                        <!-- Feedback Panel (Shown after answering) -->
                        <div id="feedbackPanel" class="feedback-panel" style="display: none;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2" id="feedbackTitle">
                                    <!-- Correct or Incorrect icon and title -->
                                </h5>
                                <span class="badge" id="feedbackSubBadge" style="font-size: 13px;"></span>
                            </div>
                            <p class="mb-0 small" id="feedbackMessage"></p>
                            
                            <!-- Explanation Block -->
                            <div id="explanationContainer" class="mt-3 pt-3 border-top" style="display: none; border-color: rgba(0,0,0,0.1);">
                                <div class="small font-weight-bold mb-1"><i class="feather-info"></i> Explanation:</div>
                                <div class="small" id="explanationText" style="line-height: 1.6;"></div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="button" id="nextQuestionBtn" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold">
                                    Continue <i class="feather-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Victory / Completion State -->
                    <div id="victoryState" class="victory-card" style="display: none;">
                        <div class="victory-trophy">🏆</div>
                        <h2 class="font-weight-bold text-dark-title mb-2">Quiz 100% Mastered!</h2>
                        <p class="text-muted mb-4" style="max-width: 500px; margin-inline: auto;">
                            Outstanding achievement! You have successfully mastered every single question in <strong>{{ $session->quiz->title }}</strong>.
                        </p>

                        <!-- Stats Grid -->
                        <div class="row g-3 justify-content-center mb-5">
                            <div class="col-4">
                                <div class="p-3 rounded-4" style="background: rgba(3, 198, 187, 0.1);">
                                    <div class="h3 font-weight-bold mb-0" style="color: #009e95;" id="finalMasteredCount">
                                        {{ $session->total_questions }}
                                    </div>
                                    <div class="small text-muted">Questions</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 rounded-4" style="background: rgba(79, 70, 229, 0.1);">
                                    <div class="h3 font-weight-bold mb-0" style="color: #4f46e5;" id="finalAttemptsCount">
                                        {{ $session->total_attempts }}
                                    </div>
                                    <div class="small text-muted">Total Attempts</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 rounded-4" style="background: rgba(245, 158, 11, 0.1);">
                                    <div class="h3 font-weight-bold mb-0" style="color: #d97706;" id="finalAccuracyPercent">
                                        {{ $session->total_attempts > 0 ? round(($session->correct_attempts / $session->total_attempts) * 100) : 100 }}%
                                    </div>
                                    <div class="small text-muted">Accuracy</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <button type="button" id="practiceAgainBtn" class="btn btn-outline-primary rounded-pill px-4 py-3 font-weight-bold d-inline-flex align-items-center gap-2">
                                <i class="feather-rotate-ccw"></i> <span>Practice Again</span>
                            </button>
                            <a href="{{ route('practice_quiz.review', $session->id) }}" class="btn btn-secondary rounded-pill px-4 py-3 font-weight-bold d-inline-flex align-items-center gap-2">
                                <i class="feather-book-open"></i> <span>Review Explanations</span>
                            </a>
                            <a href="{{ route('user.myaccount.dashboard') }}" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold d-inline-flex align-items-center gap-2">
                                <i class="feather-grid"></i> <span>Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Canvas Confetti for Celebration -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let sessionId = {{ $session->id }};
    const targetRepetitions = {{ $session->quiz->target_repetitions }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';

    let currentQuestion = null;
    let currentStreak = 0;
    let isSubmitting = false;
    let isSoundEnabled = true;

    // Web Audio API Synthesizer for instant crisp sound effects
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    let audioCtx = null;

    function playTone(type) {
        if (!isSoundEnabled) return;
        try {
            if (!audioCtx) audioCtx = new AudioContext();
            if (audioCtx.state === 'suspended') audioCtx.resume();

            if (type === 'correct') {
                // Happy high chime (E5 -> A5)
                const now = audioCtx.currentTime;
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(659.25, now); // E5
                osc.frequency.exponentialRampToValueAtTime(880, now + 0.15); // A5
                gain.gain.setValueAtTime(0.15, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.3);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start(now);
                osc.stop(now + 0.3);
            } else if (type === 'incorrect') {
                // Low soft thud
                const now = audioCtx.currentTime;
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(220, now);
                osc.frequency.exponentialRampToValueAtTime(140, now + 0.2);
                gain.gain.setValueAtTime(0.2, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start(now);
                osc.stop(now + 0.25);
            }
        } catch (e) {
            console.log('Audio error:', e);
        }
    }

    // Toggle Sound Button
    const soundToggleBtn = document.getElementById('soundToggleBtn');
    const soundIcon = document.getElementById('soundIcon');
    soundToggleBtn.addEventListener('click', function () {
        isSoundEnabled = !isSoundEnabled;
        if (isSoundEnabled) {
            soundIcon.className = 'feather-volume-2';
        } else {
            soundIcon.className = 'feather-volume-x';
        }
    });

    // Elements
    const loadingState = document.getElementById('loadingState');
    const questionState = document.getElementById('questionState');
    const victoryState = document.getElementById('victoryState');
    const questionText = document.getElementById('questionText');
    const optionsContainer = document.getElementById('optionsContainer');
    const feedbackPanel = document.getElementById('feedbackPanel');
    const feedbackTitle = document.getElementById('feedbackTitle');
    const feedbackSubBadge = document.getElementById('feedbackSubBadge');
    const feedbackMessage = document.getElementById('feedbackMessage');
    const explanationContainer = document.getElementById('explanationContainer');
    const explanationText = document.getElementById('explanationText');
    const nextQuestionBtn = document.getElementById('nextQuestionBtn');
    const streakCount = document.getElementById('streakCount');
    const questionRepetitionText = document.getElementById('questionRepetitionText');
    const sessionProgressLabel = document.getElementById('sessionProgressLabel');
    const sessionProgressFill = document.getElementById('sessionProgressFill');

    // Update Repetition Dots for current question
    function updateRepetitionDots(correctCount) {
        questionRepetitionText.textContent = `Mastery: ${correctCount}/${targetRepetitions}`;
        for (let i = 0; i < targetRepetitions; i++) {
            const dot = document.getElementById(`repDot-${i}`);
            if (dot) {
                if (i < correctCount) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            }
        }
    }

    // Load Next Question
    function loadNextQuestion(excludeId = 0) {
        isSubmitting = false;
        loadingState.style.display = 'block';
        questionState.style.display = 'none';
        feedbackPanel.style.display = 'none';

        fetch(`/api/practice-quiz/next/${sessionId}?exclude_id=${excludeId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            loadingState.style.display = 'none';

            if (data.session_completed) {
                showVictoryScreen(data.stats);
                return;
            }

            currentQuestion = data.question;
            renderQuestion(data.question);
            updateSessionProgress(data.session);
            questionState.style.display = 'block';
        })
        .catch(err => {
            console.error('Error fetching question:', err);
            loadingState.innerHTML = '<div class="alert alert-danger">Error loading question. Please refresh the page.</div>';
        });
    }

    // Render Question & Options
    function renderQuestion(q) {
        questionText.textContent = q.question;
        updateRepetitionDots(q.correct_count);

        optionsContainer.innerHTML = '';
        const letters = ['A', 'B', 'C', 'D', 'E'];
        const options = [
            { num: 1, text: q.optn1 },
            { num: 2, text: q.optn2 },
            { num: 3, text: q.optn3 },
            { num: 4, text: q.optn4 },
            { num: 5, text: q.optn5 }
        ];

        options.forEach((opt, idx) => {
            if (opt.text && opt.text.trim() !== '') {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'option-btn';
                btn.dataset.option = opt.num;
                btn.innerHTML = `
                    <span class="option-letter">${letters[idx]}</span>
                    <span class="option-content flex-grow-1">${opt.text}</span>
                `;
                btn.addEventListener('click', () => handleOptionClick(opt.num, btn));
                optionsContainer.appendChild(btn);
            }
        });
    }

    // Handle Option Selection
    function handleOptionClick(selectedOption, clickedBtn) {
        if (isSubmitting) return;
        isSubmitting = true;

        // Disable all option buttons
        const allButtons = optionsContainer.querySelectorAll('.option-btn');
        allButtons.forEach(btn => btn.disabled = true);

        // Submit via AJAX
        fetch(`/api/practice-quiz/submit/${sessionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                question_id: currentQuestion.id,
                selected_option: selectedOption
            })
        })
        .then(res => res.json())
        .then(res => {
            handleAnswerResult(res, clickedBtn, allButtons);
        })
        .catch(err => {
            console.error('Error submitting answer:', err);
            isSubmitting = false;
            allButtons.forEach(btn => btn.disabled = false);
        });
    }

    // Handle Answer Result & Feedback
    function handleAnswerResult(res, clickedBtn, allButtons) {
        // Highlight correct and incorrect options
        allButtons.forEach(btn => {
            const btnOpt = parseInt(btn.dataset.option);
            if (btnOpt === res.right_ans) {
                if (res.is_correct) {
                    btn.classList.add('selected-correct');
                } else {
                    btn.classList.add('reveal-correct');
                }
            } else if (btnOpt === res.selected_option && !res.is_correct) {
                btn.classList.add('selected-incorrect');
            }
        });

        // Update Repetition Dots
        updateRepetitionDots(res.correct_count);

        // Update Session Progress Bar
        updateSessionProgress({
            mastered_questions: res.mastered_questions,
            total_questions: res.total_questions,
            progress_percent: res.progress_percent
        });

        if (res.is_correct) {
            playTone('correct');
            currentStreak++;
            streakCount.textContent = currentStreak;

            feedbackPanel.className = 'feedback-panel correct';
            feedbackTitle.innerHTML = '<i class="feather-check-circle text-success" style="font-size: 24px;"></i> Correct Answer!';
            
            if (res.question_mastered) {
                feedbackSubBadge.className = 'badge bg-success text-white';
                feedbackSubBadge.textContent = '🌟 Question Mastered!';
                feedbackMessage.textContent = `You have answered this correctly ${res.correct_count} times! This question is now permanently mastered.`;
                // Micro confetti celebration
                if (typeof confetti === 'function') {
                    confetti({ particleCount: 40, spread: 60, origin: { y: 0.7 } });
                }
            } else {
                feedbackSubBadge.className = 'badge bg-primary text-white';
                feedbackSubBadge.textContent = `Progress: ${res.correct_count}/${res.target_repetitions}`;
                feedbackMessage.textContent = `Great job! Answer correctly ${res.target_repetitions - res.correct_count} more time(s) to master it.`;
            }

            if (res.explanation) {
                explanationContainer.style.display = 'block';
                explanationText.textContent = res.explanation;
            } else {
                explanationContainer.style.display = 'none';
            }

        } else {
            playTone('incorrect');
            currentStreak = 0;
            streakCount.textContent = currentStreak;

            feedbackPanel.className = 'feedback-panel incorrect';
            feedbackTitle.innerHTML = '<i class="feather-x-circle text-danger" style="font-size: 24px;"></i> Incorrect';
            feedbackSubBadge.className = 'badge bg-danger text-white';
            feedbackSubBadge.textContent = 'Will Repeat Later';
            feedbackMessage.textContent = 'Don\'t worry! Review the correct answer below. This question will appear again randomly so you can practice it.';

            if (res.explanation) {
                explanationContainer.style.display = 'block';
                explanationText.textContent = res.explanation;
            } else {
                explanationContainer.style.display = 'none';
            }
        }

        feedbackPanel.style.display = 'block';

        // When user clicks Continue
        nextQuestionBtn.onclick = function () {
            if (res.session_completed) {
                loadNextQuestion(); // Will trigger victory screen
            } else {
                loadNextQuestion(currentQuestion.id);
            }
        };
    }

    // Update session progress indicators
    function updateSessionProgress(session) {
        if (!session) return;
        sessionProgressLabel.textContent = `${session.mastered_questions}/${session.total_questions} Mastered (${session.progress_percent}%)`;
        sessionProgressFill.style.width = `${session.progress_percent}%`;
    }

    // Show Victory Screen
    function showVictoryScreen(stats) {
        questionState.style.display = 'none';
        loadingState.style.display = 'none';
        feedbackPanel.style.display = 'none';

        if (stats) {
            document.getElementById('finalMasteredCount').textContent = stats.mastered_questions;
            document.getElementById('finalAttemptsCount').textContent = stats.total_attempts;
            document.getElementById('finalAccuracyPercent').textContent = `${stats.accuracy}%`;
        }

        victoryState.style.display = 'block';

        // Big celebratory confetti barrage!
        if (typeof confetti === 'function') {
            confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
            setTimeout(() => {
                confetti({ particleCount: 60, angle: 60, spread: 55, origin: { x: 0 } });
                confetti({ particleCount: 60, angle: 120, spread: 55, origin: { x: 1 } });
            }, 400);
        }
    }

    // Handle Practice Again button
    const practiceAgainBtn = document.getElementById('practiceAgainBtn');
    if (practiceAgainBtn) {
        practiceAgainBtn.addEventListener('click', function () {
            const btn = this;
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Restarting...';

            fetch(`/practice-quiz/restart/${sessionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.session_id) {
                    sessionId = data.session_id;
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', `/practice-quiz/play/${data.session_id}`);
                    }
                }

                // Hide victory state
                victoryState.style.display = 'none';
                feedbackPanel.style.display = 'none';

                // Reset local metrics
                currentStreak = 0;
                streakCount.textContent = '0';
                updateRepetitionDots(0);
                updateSessionProgress({
                    mastered_questions: 0,
                    total_questions: {{ $session->total_questions }},
                    progress_percent: 0
                });

                // Load first question
                loadNextQuestion();
            })
            .catch(err => {
                console.error('AJAX restart error, falling back:', err);
                window.location.href = "{{ route('practice_quiz.restart', $session->id) }}";
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        });
    }

    // Initial Load
    loadNextQuestion();
});
</script>
@endsection
