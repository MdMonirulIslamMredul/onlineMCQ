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
        padding: 10px 0;
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
        background: linear-gradient(90deg, #007A55 0%, #4f46e5 100%);
        border-radius: 10px;
        transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
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
        transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1),
                    background 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                    border-color 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .option-btn:hover:not(:disabled) {
        border-color: #007A55;
        background: #f0fdfa;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 122, 85, 0.16);
    }
    .option-btn:active:not(:disabled) {
        transform: scale(0.985);
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
        background: #007A55;
        color: #ffffff;
    }

    /* Staggered option entrance animation */
    @keyframes optionEntrance {
        from {
            opacity: 0;
            transform: translateY(12px) scale(0.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .option-btn-animated {
        animation: optionEntrance 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    /* Option States with Spring Easing */
    .option-btn.selected-correct {
        background: #ecfdf5 !important;
        border-color: #10b981 !important;
        color: #065f46 !important;
        animation: springCorrect 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }
    .option-btn.selected-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    .option-btn.selected-incorrect {
        background: #fef2f2 !important;
        border-color: #ef4444 !important;
        color: #991b1b !important;
        animation: springShake 0.45s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
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
        animation: pulseSoftGlow 1.6s infinite ease-in-out;
    }
    .option-btn.reveal-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    @keyframes springShake {
        0%, 100% { transform: translateX(0); }
        15% { transform: translateX(-6px); }
        30% { transform: translateX(5px); }
        45% { transform: translateX(-4px); }
        60% { transform: translateX(2px); }
        75% { transform: translateX(-1px); }
    }
    @keyframes springCorrect {
        0% { transform: scale(1); }
        30% { transform: scale(1.025); }
        60% { transform: scale(0.995); }
        100% { transform: scale(1); }
    }
    @keyframes pulseSoftGlow {
        0%, 100% { border-color: #10b981; }
        50% { border-color: #34d399; }
    }

    /* Top Quick Continue Button Bar */
    @keyframes slideUpSmooth {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes continueGlow {
        0%, 100% {
            box-shadow: 0 4px 14px rgba(0, 122, 85, 0.35);
        }
        50% {
            box-shadow: 0 6px 24px rgba(0, 122, 85, 0.6);
        }
    }
    .top-continue-bar {
        margin-top: 18px;
        margin-bottom: 20px;
        animation: slideUpSmooth 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    .btn-top-continue {
        background: linear-gradient(135deg, #007A55 0%, #4f46e5 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 16px;
        padding: 14px 28px;
        border-radius: 50px;
        animation: continueGlow 2.5s infinite ease-in-out;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
    }
    .btn-top-continue:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 26px rgba(0, 122, 85, 0.6);
        color: #ffffff !important;
    }
    .btn-top-continue:active {
        transform: translateY(0) scale(0.99);
    }
    .btn-top-continue i {
        font-size: 18px;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-top-continue:hover i {
        transform: translateX(5px);
    }

    /* Feedback & Explanation Card (Desktop side-panel and mobile stacked card) */
    .feedback-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 32px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .feedback-card.correct {
        background: linear-gradient(180deg, #ecfdf5 0%, #ffffff 50%);
        border-color: #a7f3d0;
        border-top: 6px solid #10b981;
    }
    .feedback-card.incorrect {
        background: linear-gradient(180deg, #fef2f2 0%, #ffffff 50%);
        border-color: #fecaca;
        border-top: 6px solid #ef4444;
    }
    .explanation-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        transition: all 0.3s ease;
    }

    /* Animations: desktop slide-in from right vs mobile slide-up with smooth spring curve */
    @keyframes smoothSlideInRight {
        from {
            opacity: 0;
            transform: translateX(36px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }
    @keyframes smoothSlideUp {
        from {
            opacity: 0;
            transform: translateY(22px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    @media (min-width: 992px) {
        .feedback-card-animate {
            animation: smoothSlideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    }
    @media (max-width: 991.98px) {
        .feedback-card-animate {
            animation: smoothSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    }

    /* Repetition Dots with Pop & Spring curve */
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
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.3s ease, box-shadow 0.3s ease;
    }
    .repetition-dot.active {
        background: #f59e0b;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.6);
        transform: scale(1.28);
        animation: dotPop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes dotPop {
        0% { transform: scale(0.8); }
        50% { transform: scale(1.45); }
        100% { transform: scale(1.28); }
    }

    /* Streak Badge Pop */
    @keyframes bumpScale {
        0% { transform: scale(1); }
        40% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
    .streak-bump {
        animation: bumpScale 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
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

    /* Explicit Light Mode Base Colors */
    html:not(.dark-theme):not([data-theme="dark"]) .game-card {
        background: #ffffff !important;
        border-color: #e2e8f0 !important;
    }
    html:not(.dark-theme):not([data-theme="dark"]) .question-title {
        color: #0f172a !important;
    }
    html:not(.dark-theme):not([data-theme="dark"]) .option-btn {
        background: #ffffff !important;
        border-color: #e2e8f0 !important;
        color: #1e293b !important;
    }
    html:not(.dark-theme):not([data-theme="dark"]) .option-content {
        color: #1e293b !important;
    }

    /* ========================================================
       DARK MODE THEME SYSTEM
       Supports: html.dark-theme, [data-theme="dark"], body.dark, body.dark-theme
       ======================================================== */
    html.dark-theme .game-wrapper,
    [data-theme="dark"] .game-wrapper,
    body.dark .game-wrapper,
    body.dark-theme .game-wrapper {
        background: #0b1120 !important;
    }

    html.dark-theme .game-card,
    [data-theme="dark"] .game-card,
    body.dark .game-card,
    body.dark-theme .game-card {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
    }

    html.dark-theme .question-title,
    [data-theme="dark"] .question-title,
    body.dark .question-title,
    body.dark-theme .question-title {
        color: #f8fafc !important;
    }

    html.dark-theme #questionRepetitionText,
    [data-theme="dark"] #questionRepetitionText,
    body.dark #questionRepetitionText,
    body.dark-theme #questionRepetitionText {
        color: #94a3b8 !important;
    }

    html.dark-theme .repetition-dot,
    [data-theme="dark"] .repetition-dot,
    body.dark .repetition-dot,
    body.dark-theme .repetition-dot {
        background: #334155 !important;
    }

    html.dark-theme .repetition-dot.active,
    [data-theme="dark"] .repetition-dot.active,
    body.dark .repetition-dot.active,
    body.dark-theme .repetition-dot.active {
        background: #f59e0b !important;
        box-shadow: 0 0 8px rgba(245, 158, 11, 0.7) !important;
    }

    html.dark-theme .game-badge-streak,
    [data-theme="dark"] .game-badge-streak,
    body.dark .game-badge-streak,
    body.dark-theme .game-badge-streak {
        background: rgba(249, 115, 22, 0.15) !important;
        border: 1px solid rgba(249, 115, 22, 0.35) !important;
        color: #fdba74 !important;
    }

    html.dark-theme .game-mastery-meter,
    [data-theme="dark"] .game-mastery-meter,
    body.dark .game-mastery-meter,
    body.dark-theme .game-mastery-meter {
        background: #0f172a !important;
    }

    html.dark-theme #sessionProgressLabel,
    [data-theme="dark"] #sessionProgressLabel,
    body.dark #sessionProgressLabel,
    body.dark-theme #sessionProgressLabel {
        color: #2dd4bf !important;
    }

    html.dark-theme .option-btn,
    [data-theme="dark"] .option-btn,
    body.dark .option-btn,
    body.dark-theme .option-btn {
        background: #0f172a !important;
        border: 2px solid #334155 !important;
        color: #f8fafc !important;
    }

    html.dark-theme .option-content,
    [data-theme="dark"] .option-content,
    body.dark .option-content,
    body.dark-theme .option-content {
        color: #f8fafc !important;
    }

    html.dark-theme .option-btn:hover:not(:disabled),
    [data-theme="dark"] .option-btn:hover:not(:disabled),
    body.dark .option-btn:hover:not(:disabled),
    body.dark-theme .option-btn:hover:not(:disabled) {
        background: #16243b !important;
        border-color: #007A55 !important;
        color: #ffffff !important;
    }

    html.dark-theme .option-letter,
    [data-theme="dark"] .option-letter,
    body.dark .option-letter,
    body.dark-theme .option-letter {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        color: #38bdf8 !important;
    }

    html.dark-theme .option-btn:hover:not(:disabled) .option-letter,
    [data-theme="dark"] .option-btn:hover:not(:disabled) .option-letter,
    body.dark .option-btn:hover:not(:disabled) .option-letter,
    body.dark-theme .option-btn:hover:not(:disabled) .option-letter {
        background: #007A55 !important;
        border-color: #007A55 !important;
        color: #ffffff !important;
    }

    /* Option States in Dark Mode */
    html.dark-theme .option-btn.selected-correct,
    [data-theme="dark"] .option-btn.selected-correct,
    body.dark .option-btn.selected-correct,
    body.dark-theme .option-btn.selected-correct {
        background: rgba(16, 185, 129, 0.2) !important;
        border-color: #10b981 !important;
        color: #a7f3d0 !important;
    }
    html.dark-theme .option-btn.selected-correct .option-letter,
    [data-theme="dark"] .option-btn.selected-correct .option-letter,
    body.dark .option-btn.selected-correct .option-letter,
    body.dark-theme .option-btn.selected-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    html.dark-theme .option-btn.selected-incorrect,
    [data-theme="dark"] .option-btn.selected-incorrect,
    body.dark .option-btn.selected-incorrect,
    body.dark-theme .option-btn.selected-incorrect {
        background: rgba(239, 68, 68, 0.2) !important;
        border-color: #ef4444 !important;
        color: #fca5a5 !important;
    }
    html.dark-theme .option-btn.selected-incorrect .option-letter,
    [data-theme="dark"] .option-btn.selected-incorrect .option-letter,
    body.dark .option-btn.selected-incorrect .option-letter,
    body.dark-theme .option-btn.selected-incorrect .option-letter {
        background: #ef4444 !important;
        color: #ffffff !important;
    }

    html.dark-theme .option-btn.reveal-correct,
    [data-theme="dark"] .option-btn.reveal-correct,
    body.dark .option-btn.reveal-correct,
    body.dark-theme .option-btn.reveal-correct {
        background: rgba(16, 185, 129, 0.2) !important;
        border-color: #10b981 !important;
        border-style: dashed !important;
        color: #a7f3d0 !important;
    }
    html.dark-theme .option-btn.reveal-correct .option-letter,
    [data-theme="dark"] .option-btn.reveal-correct .option-letter,
    body.dark .option-btn.reveal-correct .option-letter,
    body.dark-theme .option-btn.reveal-correct .option-letter {
        background: #10b981 !important;
        color: #ffffff !important;
    }

    /* Feedback Card in Dark Mode */
    html.dark-theme .feedback-card,
    [data-theme="dark"] .feedback-card,
    body.dark .feedback-card,
    body.dark-theme .feedback-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        color: #f8fafc !important;
    }
    html.dark-theme .feedback-card.correct,
    [data-theme="dark"] .feedback-card.correct,
    body.dark .feedback-card.correct,
    body.dark-theme .feedback-card.correct {
        background: linear-gradient(180deg, rgba(6, 78, 59, 0.45) 0%, #1e293b 60%) !important;
        border-color: #059669 !important;
        border-top: 6px solid #10b981 !important;
    }
    html.dark-theme .feedback-card.correct #feedbackTitle,
    [data-theme="dark"] .feedback-card.correct #feedbackTitle,
    body.dark .feedback-card.correct #feedbackTitle,
    body.dark-theme .feedback-card.correct #feedbackTitle {
        color: #34d399 !important;
    }

    html.dark-theme .feedback-card.incorrect,
    [data-theme="dark"] .feedback-card.incorrect,
    body.dark .feedback-card.incorrect,
    body.dark-theme .feedback-card.incorrect {
        background: linear-gradient(180deg, rgba(127, 29, 29, 0.45) 0%, #1e293b 60%) !important;
        border-color: #dc2626 !important;
        border-top: 6px solid #ef4444 !important;
    }
    html.dark-theme .feedback-card.incorrect #feedbackTitle,
    [data-theme="dark"] .feedback-card.incorrect #feedbackTitle,
    body.dark .feedback-card.incorrect #feedbackTitle,
    body.dark-theme .feedback-card.incorrect #feedbackTitle {
        color: #f87171 !important;
    }

    html.dark-theme #feedbackMessage,
    [data-theme="dark"] #feedbackMessage,
    body.dark #feedbackMessage,
    body.dark-theme #feedbackMessage {
        color: #f1f5f9 !important;
    }

    html.dark-theme .explanation-box,
    [data-theme="dark"] .explanation-box,
    body.dark .explanation-box,
    body.dark-theme .explanation-box {
        background: #0f172a !important;
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark-theme .explanation-box #explanationText,
    [data-theme="dark"] .explanation-box #explanationText,
    body.dark .explanation-box #explanationText,
    body.dark-theme .explanation-box #explanationText {
        color: #e2e8f0 !important;
    }
    html.dark-theme #feedbackCardHeader,
    [data-theme="dark"] #feedbackCardHeader {
        border-color: rgba(255, 255, 255, 0.12) !important;
    }

    /* Sound Button in Dark Mode */
    html.dark-theme .sound-toggle-btn,
    [data-theme="dark"] .sound-toggle-btn,
    body.dark .sound-toggle-btn,
    body.dark-theme .sound-toggle-btn {
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    html.dark-theme .sound-toggle-btn:hover,
    [data-theme="dark"] .sound-toggle-btn:hover,
    body.dark .sound-toggle-btn:hover,
    body.dark-theme .sound-toggle-btn:hover {
        background: #334155 !important;
        color: #ffffff !important;
    }

    /* Victory Card in Dark Mode */
    html.dark-theme .victory-card h2,
    [data-theme="dark"] .victory-card h2,
    body.dark .victory-card h2,
    body.dark-theme .victory-card h2 {
        color: #f8fafc !important;
    }
    html.dark-theme .victory-card p,
    [data-theme="dark"] .victory-card p,
    body.dark .victory-card p,
    body.dark-theme .victory-card p {
        color: #94a3b8 !important;
    }
    html.dark-theme .btn-outline-secondary,
    [data-theme="dark"] .btn-outline-secondary,
    body.dark .btn-outline-secondary,
    body.dark-theme .btn-outline-secondary {
        border-color: #334155 !important;
        color: #cbd5e1 !important;
    }
    html.dark-theme .btn-outline-secondary:hover,
    [data-theme="dark"] .btn-outline-secondary:hover,
    body.dark .btn-outline-secondary:hover,
    body.dark-theme .btn-outline-secondary:hover {
        background: #334155 !important;
        color: #ffffff !important;
    }

    /* Top Continue Button in Dark Mode */
    html.dark-theme .btn-top-continue,
    [data-theme="dark"] .btn-top-continue,
    body.dark .btn-top-continue,
    body.dark-theme .btn-top-continue {
        background: linear-gradient(135deg, #007A55 0%, #6366f1 100%) !important;
        box-shadow: 0 4px 15px rgba(0, 122, 85, 0.3) !important;
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
<div class="game-wrapper">
    <div class="container" style="max-width: 1260px;">
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

        <div class="row g-4 justify-content-center" id="gameLayoutRow">
            <div class="col-lg-8 col-md-10 col-12" id="questionCol" style="transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
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
                                    Streak: 0/{{ $session->quiz->target_repetitions }}
                                </span>
                                <div class="repetition-pills" id="repetitionPillsContainer">
                                    @for($i = 0; $i < $session->quiz->target_repetitions; $i++)
                                        <span class="repetition-dot" id="repDot-{{ $i }}"></span>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div class="small font-weight-bold" style="color: #007A55;" id="sessionProgressLabel">
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

                        <!-- Top Quick Continue Bar (Immediately accessible right below options so students don't have to scroll) -->
                        <div id="topContinueBar" class="top-continue-bar" style="display: none;">
                            <div class="d-flex justify-content-end">
                                <button type="button" id="topNextQuestionBtn" class="btn-top-continue w-100 w-sm-auto">
                                    <span>Continue</span> <i class="feather-arrow-right"></i>
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
                                <div class="p-3 rounded-4" style="background: rgba(0, 122, 85, 0.1);">
                                    <div class="h3 font-weight-bold mb-0" style="color: #005a3e;" id="finalMasteredCount">
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

            <!-- Right Column: Dedicated Feedback & Explanation Panel for Desktop (Stacks below on mobile) -->
            <div class="col-lg-5 col-12" id="feedbackCol" style="display: none;">
                <div class="feedback-card" id="feedbackPanel">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" id="feedbackCardHeader">
                        <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2" id="feedbackTitle">
                            <!-- Correct or Incorrect icon and title -->
                        </h5>
                        <span class="badge" id="feedbackSubBadge" style="font-size: 13px;"></span>
                    </div>

                    <p class="mb-3 font-weight-500" id="feedbackMessage" style="font-size: 15px; line-height: 1.6;"></p>
                    
                    <!-- Explanation Block -->
                    <div id="explanationContainer" class="explanation-box mb-4" style="display: none;">
                        <div class="small font-weight-bold mb-2 text-primary d-flex align-items-center gap-1">
                            <i class="feather-book-open"></i> Explanation & Discussion:
                        </div>
                        <div class="small" id="explanationText" style="line-height: 1.7; font-size: 14.5px;"></div>
                    </div>

                    <div class="text-end mt-auto pt-3 border-top" style="border-color: rgba(0,0,0,0.06);">
                        <button type="button" id="nextQuestionBtn" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold shadow-sm">
                            <span>Continue</span> <i class="feather-arrow-right"></i>
                        </button>
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
    const questionCol = document.getElementById('questionCol');
    const feedbackCol = document.getElementById('feedbackCol');
    const feedbackPanel = document.getElementById('feedbackPanel');
    const feedbackTitle = document.getElementById('feedbackTitle');
    const feedbackSubBadge = document.getElementById('feedbackSubBadge');
    const feedbackMessage = document.getElementById('feedbackMessage');
    const explanationContainer = document.getElementById('explanationContainer');
    const explanationText = document.getElementById('explanationText');
    const nextQuestionBtn = document.getElementById('nextQuestionBtn');
    const topContinueBar = document.getElementById('topContinueBar');
    const topNextQuestionBtn = document.getElementById('topNextQuestionBtn');
    let canPressContinue = false;
    const streakCount = document.getElementById('streakCount');
    const questionRepetitionText = document.getElementById('questionRepetitionText');
    const sessionProgressLabel = document.getElementById('sessionProgressLabel');
    const sessionProgressFill = document.getElementById('sessionProgressFill');

    // Update Repetition Dots for current question
    function updateRepetitionDots(correctCount) {
        questionRepetitionText.textContent = `Streak: ${correctCount}/${targetRepetitions}`;
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
        canPressContinue = false;
        isSubmitting = false;
        topContinueBar.style.display = 'none';
        if (feedbackCol) {
            feedbackCol.style.display = 'none';
            feedbackCol.style.opacity = '';
            feedbackCol.style.transform = '';
            feedbackCol.style.transition = '';
        }
        if (feedbackPanel) feedbackPanel.className = 'feedback-card';
        if (questionCol) questionCol.className = 'col-lg-8 col-md-10 col-12';

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

            // Smooth entrance animation
            questionState.style.transition = 'none';
            questionState.style.opacity = '0';
            questionState.style.transform = 'translateY(12px)';
            questionState.style.display = 'block';

            // Trigger reflow to apply smooth transition
            void questionState.offsetWidth;

            questionState.style.transition = 'opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1), transform 0.28s cubic-bezier(0.16, 1, 0.3, 1)';
            questionState.style.opacity = '1';
            questionState.style.transform = 'translateY(0)';
        })
        .catch(err => {
            console.error('Error fetching question:', err);
            loadingState.innerHTML = '<div class="alert alert-danger">Error loading question. Please refresh the page.</div>';
            loadingState.style.display = 'block';
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
                btn.className = 'option-btn option-btn-animated';
                btn.style.animationDelay = `${idx * 0.045}s`;
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

            // Subtle bounce on streak badge
            const streakBadge = document.getElementById('streakBadge');
            if (streakBadge) {
                streakBadge.classList.remove('streak-bump');
                void streakBadge.offsetWidth;
                streakBadge.classList.add('streak-bump');
            }

            feedbackPanel.className = 'feedback-card correct';
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
                feedbackSubBadge.textContent = `Streak: ${res.correct_count}/${res.target_repetitions}`;
                feedbackMessage.textContent = `Great job! Answer correctly ${res.target_repetitions - res.correct_count} more time(s) in a row to master it.`;
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

            feedbackPanel.className = 'feedback-card incorrect';
            feedbackTitle.innerHTML = '<i class="feather-x-circle text-danger" style="font-size: 24px;"></i> Incorrect';
            feedbackSubBadge.className = 'badge bg-danger text-white';
            feedbackSubBadge.textContent = `Streak Reset (0/${res.target_repetitions})`;
            feedbackMessage.textContent = `Streak reset to 0/${res.target_repetitions}! You need ${res.target_repetitions} consecutive correct answers in a row to master this question.`;

            if (res.explanation) {
                explanationContainer.style.display = 'block';
                explanationText.textContent = res.explanation;
            } else {
                explanationContainer.style.display = 'none';
            }
        }

        topContinueBar.style.display = 'block';
        if (questionCol) questionCol.className = 'col-lg-7 col-12';
        if (feedbackCol) {
            feedbackCol.style.opacity = '';
            feedbackCol.style.transform = '';
            feedbackCol.style.transition = '';
            feedbackCol.style.display = 'block';
            feedbackCol.className = 'col-lg-5 col-12 feedback-card-animate';
        }
        canPressContinue = true;

        // When user proceeds to Continue (via top button, bottom button, or keyboard Enter/Space)
        function proceedNext() {
            if (!canPressContinue && isSubmitting) return;
            canPressContinue = false;
            topNextQuestionBtn.onclick = null;
            nextQuestionBtn.onclick = null;

            // Trigger smooth exit transition
            questionState.style.transition = 'opacity 0.18s cubic-bezier(0.16, 1, 0.3, 1), transform 0.18s cubic-bezier(0.16, 1, 0.3, 1)';
            questionState.style.opacity = '0';
            questionState.style.transform = 'translateY(-8px)';

            if (feedbackCol && feedbackCol.style.display !== 'none') {
                feedbackCol.style.transition = 'opacity 0.18s cubic-bezier(0.16, 1, 0.3, 1), transform 0.18s cubic-bezier(0.16, 1, 0.3, 1)';
                feedbackCol.style.opacity = '0';
                feedbackCol.style.transform = 'translateX(24px)';
            }

            setTimeout(() => {
                if (res.session_completed) {
                    loadNextQuestion(); // Will trigger victory screen
                } else {
                    loadNextQuestion(currentQuestion.id);
                }
            }, 180);
        }

        topNextQuestionBtn.onclick = proceedNext;
        nextQuestionBtn.onclick = proceedNext;
    }

    // Keyboard navigation (Enter or Space to continue to next question)
    document.addEventListener('keydown', function (e) {
        if (!canPressContinue) return;
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) return;
        if (e.key === 'Enter' || e.key === ' ' || e.code === 'Space') {
            e.preventDefault();
            if (topNextQuestionBtn && typeof topNextQuestionBtn.onclick === 'function') {
                topNextQuestionBtn.onclick();
            }
        }
    });

    // Update session progress indicators
    function updateSessionProgress(session) {
        if (!session) return;
        sessionProgressLabel.textContent = `${session.mastered_questions}/${session.total_questions} Mastered (${session.progress_percent}%)`;
        sessionProgressFill.style.width = `${session.progress_percent}%`;
    }

    // Show Victory Screen
    function showVictoryScreen(stats) {
        canPressContinue = false;
        questionState.style.display = 'none';
        loadingState.style.display = 'none';
        topContinueBar.style.display = 'none';
        if (feedbackCol) feedbackCol.style.display = 'none';
        if (questionCol) questionCol.className = 'col-lg-8 col-md-10 col-12';

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
