@extends('user.pages.test_master')
@section('content')
@php
$userID = Cookie::get('user_id');
$userQ = DB::table('users')->where('id', $userID)->first();
$ordersInfo = DB::table('orders')->where('userID', optional($userQ)->id)->where('examID', $catInfo->id)->first();
$isUnlocked = (!empty($ordersInfo->id) || $catInfo->free_paid == 'free');
@endphp

<!-- Start Hero / Breadcrumb Area -->
<div class="student-hero" style="padding: 60px 0 70px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-12">
                <nav aria-label="breadcrumb">
                    <ul class="d-flex align-items-center gap-2 p-0 mb-3" style="list-style: none; font-size: 14px;">
                        <li><a href="{{ route('/') }}" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li><a href="{{ route('all.courses') }}" style="color: #94a3b8; text-decoration: none;">Exams</a></li>
                        <li style="color: #64748b;"><i class="feather-chevron-right"></i></li>
                        <li style="color: #03c6bb; font-weight: 600;">{{ $catInfo->name }}</li>
                    </ul>
                </nav>
                <div class="student-hero-badge">
                    <i class="feather-award"></i> Model Test Portal
                </div>
                <h1 class="student-hero-title mb-3" style="font-size: clamp(28px, 3.8vw, 42px);">
                    {{ $catInfo->name }}
                </h1>
                <p class="student-hero-desc mb-0" style="max-width: 650px;">
                    Take real-time competitive practice tests, evaluate your preparation with precision metrics, and achieve top ranking.
                </p>
            </div>
            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                <!-- Enrollment Status Card -->
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: #94a3b8; font-size: 14px; font-weight: 500;">Access Status</span>
                        @if($catInfo->free_paid == 'paid')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 12px; padding: 6px 12px; border-radius: 9999px;">
                                Premium Category
                            </span>
                        @else
                            <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 12px; padding: 6px 12px; border-radius: 9999px;">
                                100% Free
                            </span>
                        @endif
                    </div>

                    @if($catInfo->free_paid == 'paid')
                        <div class="mb-3">
                            <div style="color: #cbd5e1; font-size: 13px;">Enrollment Fee</div>
                            <div style="font-family: var(--font-heading); font-size: 28px; font-weight: 800; color: #ffffff;">
                                ৳{{ number_format($catInfo->tk, 2) }}
                            </div>
                        </div>

                        @if($isUnlocked)
                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;">
                                <i class="feather-check-circle" style="font-size: 20px;"></i>
                                <span style="font-weight: 600;">Category Unlocked! You have full access.</span>
                            </div>
                        @else
                            <a href="{{ url('/user/unlock-category/'.$catInfo->id.'/'.$catInfo->name) }}" class="rbt-btn btn-gradient icon-hover radius-round w-100 text-center">
                                <span class="btn-text">Unlock This Category</span>
                                <span class="btn-icon"><i class="feather-lock"></i></span>
                            </a>
                        @endif
                    @else
                        <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399;">
                            <i class="feather-check-circle" style="font-size: 20px;"></i>
                            <span style="font-weight: 600;">Free Access! Choose an exam below to start.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Area -->

<!-- Start Exams Listing Area -->
<div class="rbt-section-gap bg-color-white">
    <div class="container">
        <div class="row g-5">
            <!-- MCQ Exams Column -->
            <div class="col-lg-6 col-12">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h3 class="mb-1" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                            <i class="feather-check-square me-2" style="color: #03c6bb;"></i> MCQ Practice Exams
                        </h3>
                        <p class="text-muted mb-0" style="font-size: 14px;">Timed interactive multiple-choice tests</p>
                    </div>
                    <span class="badge" style="background: rgba(3, 198, 187, 0.12); color: #03c6bb; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                        {{ $MCQexams->count() }} Available
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($MCQexams as $exam)
                        @php
                            $Eurl = str_replace(" ","-", $exam->exam_name);
                            $key = rand(10000, 199999);
                        @endphp
                        <div class="p-3 rounded-4 transition-all" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.25s ease;">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background: rgba(3, 198, 187, 0.1); color: #03c6bb; font-size: 20px;">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1" style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                            {{ $exam->exam_name }}
                                        </h5>
                                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 13px;">
                                            <span><i class="feather-clock me-1"></i> {{ $exam->examTime ?? '30' }} Mins</span>
                                            <span><i class="feather-help-circle me-1"></i> MCQ Format</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($isUnlocked)
                                        <a href="{{ url('/start-mcq-exam/'.$exam->id.'/'.$Eurl.'/'.$key) }}" class="rbt-btn btn-sm btn-gradient radius-round">
                                            <span>Start Test</span>
                                            <i class="feather-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" onclick="unlock_category()" class="rbt-btn btn-sm btn-border radius-round" style="color: #64748b;">
                                            <i class="feather-lock me-1"></i> Locked
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <i class="feather-folder text-muted" style="font-size: 32px;"></i>
                            <p class="mt-2 text-muted mb-0">No MCQ exams currently available in this category.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Written Exams Column -->
            <div class="col-lg-6 col-12">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                    <div>
                        <h3 class="mb-1" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                            <i class="feather-edit-3 me-2" style="color: #4f46e5;"></i> Written Model Exams
                        </h3>
                        <p class="text-muted mb-0" style="font-size: 14px;">Descriptive and subjective evaluation</p>
                    </div>
                    <span class="badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                        {{ $WrittenExams->count() }} Available
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($WrittenExams as $Wexam)
                        @php
                            $Eurl = str_replace(" ","-", $Wexam->exam_name);
                            $key = rand(10000, 199999);
                        @endphp
                        <div class="p-3 rounded-4 transition-all" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.25s ease;">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; font-size: 20px;">
                                        <i class="feather-edit"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1" style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                            {{ $Wexam->exam_name }}
                                        </h5>
                                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 13px;">
                                            <span><i class="feather-clock me-1"></i> {{ $Wexam->examTime ?? '60' }} Mins</span>
                                            <span><i class="feather-file-text me-1"></i> Written Format</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($isUnlocked)
                                        <a href="{{ url('/start-written-exam/'.$Wexam->id.'/'.$Eurl.'/'.$key) }}" class="rbt-btn btn-sm btn-gradient radius-round">
                                            <span>Start Test</span>
                                            <i class="feather-arrow-right ms-1"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" onclick="unlock_category()" class="rbt-btn btn-sm btn-border radius-round" style="color: #64748b;">
                                            <i class="feather-lock me-1"></i> Locked
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                            <i class="feather-folder text-muted" style="font-size: 32px;"></i>
                            <p class="mt-2 text-muted mb-0">No written exams currently available in this category.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Exams Listing Area -->

<script>
    function unlock_category() {
        alert("This category is locked. Please click 'Unlock This Category' to enroll and access these exams.");
    }
</script>

@endsection
