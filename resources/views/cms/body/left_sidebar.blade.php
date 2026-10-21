<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/cms">
                @if(!empty($company_info->company_name))
                {{-- <span class="logo-name"
                    style="font-size: 15px; text-shadow: 2px 2px 4px #F50057; font-weight: bold;">{{ $company_info->company_name }}</span> --}}
                    <img class="logo-name" src="{{ asset(optional($company_info)->logo) }}" alt="" style="height: 50px">
                @else
                <span class="logo-name text-danger">SetUp Setting</span>
                @endif

            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
                <a href="" class="has-dropdown"><i class="fas fa-home"></i><span>Dashboard & Setting</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ url('/cms') }}">Dashboard</a></li>
                    <li><a class="nav-link" href="{{ route('admin_setting') }}">Setting</a></li>
                    <li><a class="nav-link" href="{{ route('cms.learning_english') }}">Learning English setting</a></li>
                    <li><a class="nav-link" href="{{ route('cms.home_banner') }}">Home Banner</a></li>
                    <li><a class="nav-link" href="{{ route('cms.about_us') }}">About Us Setting</a></li>
                </ul>
            </li>
            <li class="menu-header"></li>
            <li><a class="nav-link" href="{{ route('cms.students.all') }}"><i class="fas fa-graduation-cap"></i><span>All Students</span></a></li>
            <li><a class="nav-link" href="{{ route('cms.news_notice') }}"><i class="fas fa-bullhorn"></i><span>News & Notice</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-sort-amount-up"></i><span>Enrollments</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.orders.all') }}">All Enrollments</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i></i><span>Books & Orders</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.books') }}">Books</a></li>
                    <li><a class="nav-link" href="{{ route('cms.orders.books') }}">Orders</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-copyright"></i><span>Categories</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('all_cat') }}">Exam Category</a></li>
                    <li><a class="nav-link" href="{{ route('all_course_cat') }}">Course Category</a></li>

                </ul>
            </li>
            {{-- <li><a class="nav-link" href="{{ route('all_cat') }}"><i
                        class="fas fa-copyright"></i><span>Categories</span></a></li> --}}
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-graduate"></i><span>Exams</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('cms.add_exams')}}">Add New Exam</a></li>
                    <li><a class="nav-link" href="{{route('cms.permanent_exams')}}">Permanent Exams</a></li>
                    <li><a class="nav-link" href="{{route('cms.temporary_exams')}}">Temporary Exams</a></li>
                    <li><a class="nav-link" href="{{route('cms.questions.csv')}}">CSV Upload Questions</a></li>

                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-gamepad"></i><span>Practice Quizzes</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('cms.practice_quiz.create')}}">Add Practice Quiz</a></li>
                    <li><a class="nav-link" href="{{route('cms.practice_quizzes')}}">All Practice Quizzes</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-graduate"></i><span>Course</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('cms.add_course')}}">Add New Course</a></li>
                    <li><a class="nav-link" href="{{route('cms.course.list')}}">Course List</a></li>
                      <li><a class="nav-link" href="{{ route('cms.orders.course') }}">Enroll Course</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-clipboard"></i><span>Blog</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.add_blog_page') }}">Add Blog</a></li>
                    <li><a class="nav-link" href="{{ route('cms.banglaBlog') }}">Bangla Blogs</a></li>
                    <li><a class="nav-link" href="{{ route('cms.englishBlog') }}">English Blogs</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="{{ route('cms.teachers') }}"><i
                        class="fas fa-chalkboard-teacher"></i><span>Teachers</span></a></li>
                <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-list-alt"></i><span>Results</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.student_mcq_result_page') }}">MCQ Results</a></li>
                    <li><a class="nav-link" href="{{ route('cms.student_written_result_page') }}">Written Results</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-address-book"></i><span>Contact Form</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.contact.list') }}">All Submitted Data</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-image"></i><span>Sliders</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('cms.slider_info') }}">Slider Info</a></li>
                    <li><a class="nav-link" href="{{ route('cms.slider_img') }}">Slider Image</a></li>

                </ul>
            </li>
            <li><a class="nav-link" href="{{ route('all.testimonial') }}"><i
                        class="fas fa-comment"></i><span>Testimonial</span></a></li>
            <li><a class="nav-link" href="{{ route('all.subscription') }}"><i
                            class="fas fa-comment"></i><span>Subscription</span></a></li>
        </ul>
    </aside>
</div>
