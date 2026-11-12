@php
$sidebarUserId = Cookie::get('user_id');
$sidebarUserName = Cookie::get('user_name') ?: 'Student';
$sidebarUser = DB::table('users')->where('id', $sidebarUserId)->first();

$sidebarUnfinishedQuizzes = \App\Models\PracticeSession::where('user_id', optional($sidebarUser)->id)
    ->where('status', 'in_progress')
    ->count();
@endphp

<div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border" style="top: 100px;">
    <div class="inner">
        <div class="content-item-content">
            <div class="rbt-default-sidebar-wrapper">
                <div class="section-title mb--20">
                    <h6 class="rbt-title-style-2">Welcome, {{ $sidebarUserName }}</h6>
                </div>
                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li class="{{ request()->routeIs('user.myaccount.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.dashboard') }}">
                                <i class="feather-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.myaccount.profile') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.profile') }}">
                                <i class="feather-user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.myaccount.courses') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.courses') }}">
                                <i class="feather-book-open"></i>
                                <span>Enrolled Courses</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.myaccount.exam') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.exam') }}">
                                <i class="feather-help-circle"></i>
                                <span>My Quiz Attempts</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('practice_quiz.*') ? 'active' : '' }}">
                            <a href="{{ route('practice_quiz.index') }}">
                                <i class="feather-zap"></i>
                                <span>Preparation Quizzes</span>
                                @if($sidebarUnfinishedQuizzes > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 10px; padding: 2px 7px;">{{ $sidebarUnfinishedQuizzes }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.myaccount.order') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.order') }}">
                                <i class="feather-shopping-bag"></i>
                                <span>Payment & Orders</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('user.myaccount.my_books*') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.my_books') }}">
                                <i class="feather-book"></i>
                                <span>My E-Books</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="section-title mt--40 mb--20">
                    <h6 class="rbt-title-style-2">User</h6>
                </div>
                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li class="{{ request()->routeIs('user.myaccount.psetting') ? 'active' : '' }}">
                            <a href="{{ route('user.myaccount.psetting') }}">
                                <i class="feather-settings"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.logout') }}">
                                <i class="feather-log-out"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
