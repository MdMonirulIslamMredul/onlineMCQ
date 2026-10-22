<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCon;
use App\Http\Controllers\ShopSettingCon;
use App\Http\Controllers\SliderBanner;
use App\Http\Controllers\CategoriesCon;
use App\Http\Controllers\BlogCon;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\TeachersCon;
use App\Http\Controllers\FrontCon;
use App\Http\Controllers\ExamCon;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PracticeQuizAdminController;
use App\Http\Controllers\PracticeQuizController;
use App\Models\CourseCategory;

// Begin:: Frontend Route
Route::get('/t', function () {
    return view('user.pages.home');
})->name('thome');
Route::get('/', function () {
    return view('user.thome');
})->name('/');

//Begin:: User Blog
Route::get('/blog', [BlogCon::class,"UserBlogIndex"])->name('user.blog');

Route::get('/blog-bangla', [BlogCon::class,"UserBlogIndexBangla"])->name('user.blog.bangla');
Route::get('/blog-english', [BlogCon::class,"UserBlogIndexEnglish"])->name('user.blog.english');

Route::get('/Blog_load_more_using_ajax', [BlogCon::class,"BlogLoad_more_ajax"]);
Route::get('/blog/{id}/{url}', [BlogCon::class,"UserBlogDetails"]);
//End:: User Blog

//Begin:: User Teachers
Route::get('/teachers', [TeachersCon::class,"UserTeachers"])->name('user.teachers');
//End:: User Teachers

//Begin:: About US
Route::get('/about-us', [FrontCon::class,"User_AboutUs"])->name('user.about_us');
//End:: About US

//Begin:: Contact US
Route::get('/contact-us', [FrontCon::class,"User_ContactUs"])->name('user.contact_us');
//End:: Contact US



//Begin:: mission-vission
Route::get('/mission-vission', [FrontCon::class,"User_mission_and_vission"])->name('user.mission_and_vission');
//End:: mission-vission

//Begin:: privacy-policy
Route::get('/privacy-policy', [FrontCon::class,"User_privacy_policy"])->name('user.privacy_and_policy');
Route::get('/return-policy', [FrontCon::class,"User_return_policy"])->name('user.return_and_refund_policy');
Route::get('/certificate_number', [FrontCon::class,"certificate_number"])->name('user.certificate_number');
//End:: privacy-policy

//Begin:: Trams & Conditions
Route::get('/trams-and-conditions', [FrontCon::class,"User_trams_and_conditions"])->name('user.trams_and_conditions');
//End:: Trams & Conditions

//Begin:: Category to Exams page
Route::get('/category/{id}/{url}', [FrontCon::class,"Category_To_CAT_exam_page"]);
Route::get('/course', [FrontCon::class,"course"])->name('course');
// Route::get('/course', [FrontCon::class,"course"])->name('course.category');
Route::get('/course/{id}', [FrontCon::class,"course_details"])->name('course.detail');
Route::get('/course-category/{id}', [FrontCon::class,"course_cats"])->name('cat');
Route::post('/contact-form', [FrontCon::class,"contact_form"])->name('contact.form');
Route::get('/all_courses', [FrontCon::class,"all_courses"])->name('all.courses');

// Practice Quiz (Gamified Spaced-Repetition)
Route::get('/practice-quizzes', [PracticeQuizController::class, 'index'])->name('practice_quiz.index');
Route::get('/practice-quiz/{slug}', [PracticeQuizController::class, 'show'])->name('practice_quiz.show');

Route::get('/buycourse',[FrontCon::class,"buycourse"])->name('user.buycourse');
//End:: Category to Exams page

//Begin:: User Registration page
Route::get('/register', function() {
    return view('user.pages.account.register');
})->name('user.register.page');
//End:: User Registration page

//Begin:: User Register
Route::post('/user-register',[FrontCon::class,"UserRegister"])->name('user.register');
//End:: User Register

//Begin:: User Login
Route::any('/user/login',[FrontCon::class,"UserLogin"])->name('user.login');
//End:: User Login

//Begin:: User Logout
Route::get('/user/logout',[FrontCon::class,"UserLogout"])->name('user.logout');
//End:: User Logout

//Begin:: User password reset
Route::get('/password-reset', function() {
    return view('user.pages.account.forgotpass');
})->name('user.password.reset');

Route::post('/user-pass-reset-step-one',[FrontCon::class,"UserPassResetCheckEmail"])->name('user.pass_set_step_one');
Route::post('/verify/otp',[FrontCon::class,"otpverify"])->name('verify.otp');
Route::post('/pass/reset',[FrontCon::class,"passreset"])->name('user.pass_reset');

// admin forget pass
Route::get('/admin/password-reset', function() {
    return view('cms.auth.forgotpass');
})->name('admin.password.reset');
Route::post('/admin/user-pass-reset-step-one',[AdminCon::class,"UserPassResetCheckEmail"])->name('admin.pass_set_step_one');
Route::post('/admin/verify/otp',[AdminCon::class,"otpverify"])->name('admin.verify.otp');
Route::post('/admin/pass/reset',[AdminCon::class,"passreset"])->name('admin.pass_reset');



Route::get('/user-signin-singup', function() {
    //return "hello paul";
    return view('user.pages.account.login_or_signup');
    //return view('user.pages.extra.login_or_signup');
})->name('user.login_or_signup');


//End:: User password reset

//Begin:: User Books
Route::get('/books',[FrontCon::class,"User_books"])->name('user.books');
Route::get('/shop',[FrontCon::class,"User_shop"])->name('shop');

Route::get('/book-details/{id}/{slug}',[FrontCon::class,"User_book_details"]);
Route::get('/product-details/{id}/{slug}',[FrontCon::class,"User_product_details"]);

Route::get('/checkout',[FrontCon::class,"Checkout"])->name('user.checkout');
Route::get('/checkout',[FrontCon::class,"CheckoutSub"])->name('subscription.checkout');
Route::get('/checkout1',[FrontCon::class,"checkout1"])->name('checkout');
Route::post('/confirm-checkout',[FrontCon::class,"Confirm_Checkout"])->name('user.confirm.checkout');
Route::get('/ordres-info/{orderNum}',[FrontCon::class,"Check_orders"]);
Route::get('/orders-info/{orderNum}',[FrontCon::class,"complete_orders"]);


//End:: User Books

//Begin:: User Learning English
Route::get('/learning-english', function() {
    return view('user.pages.extra.learning_english');
})->name('user.learning_english');
//End:: User Learning English







Route::group(['middleware'=>'user_auth'], function() {
    Route::get('/my-account', [FrontCon::class, 'MyAccountPage'])->name('user.myaccount');
    Route::get('/my-account-profile', [FrontCon::class, 'MyAccountPagepro'])->name('user.myaccount.profile');
    Route::get('/my-account-setting', [FrontCon::class, 'MyAccountPageprosetting'])->name('user.myaccount.psetting');
    Route::get('/my-account-courses', [FrontCon::class, 'MyAccountPagecourses'])->name('user.myaccount.courses');
    Route::get('/my-account-exams', [FrontCon::class, 'MyAccountPageexam'])->name('user.myaccount.exam');
    Route::get('/my-account-orders', [FrontCon::class, 'MyAccountPageorder'])->name('user.myaccount.order');
    Route::get('/my-account-dashboard', [FrontCon::class, 'MyAccountPagedashboard'])->name('user.myaccount.dashboard');
    Route::get('/free-lession/{id}', [FrontCon::class,"free_lession"])->name('free.lession');
    Route::get('/lession/{id}/{userID}', [FrontCon::class,"course_lession"])->name('lession')->middleware('enroll_check');

    //Course Order
    Route::post('course_order', [FrontCon::class,"courseOrder"])->name('course.order');







    Route::get('/account-update', [FrontCon::class, 'UserEditAccount'])->name('user.editAccount');
    Route::post('/update-userprofile/{id}', [FrontCon::class, 'UpdateUserProfile']);

    //mcq exam
    Route::get('/start-mcq-exam/{id}/{examName}/{key}', [FrontCon::class, 'StartExamUser']);
    Route::post('/user/confirm-mcq-exam', [FrontCon::class, 'MCQ_exam_confirm'])->name('user.mcq_exam.confirm');
    //mcq exam

    //wirtten exam
    Route::get('/start-written-exam/{id}/{examName}/{key}', [FrontCon::class, 'StartWrittenExamUser']);
    Route::post('/user/confirm-written-exam', [FrontCon::class, 'Written_exam_confirm'])->name('user.written_exam.confirm');
    //wirtten exam

    //MCQ exam result
    Route::get('/mcq-result/{id}/{examName}', [FrontCon::class, 'McQ_Exam_result']);
    Route::get('/written-result/{id}/{examName}', [FrontCon::class, 'Written_Exam_result']);
    //MCQ exam result

    //Begin::Special Exam page
    Route::get('/running-mcq-exam/{id}/{name}', [FrontCon::class, 'Running_MCQ_Special_exam']);
    Route::get('/running-written-exam/{id}/{name}', [FrontCon::class, 'Running_Written_Special_exam']);
    //End:: Special Exam Page
    // Practice Quiz Game & Progress
    Route::get('/practice-quiz/start/{id}', [PracticeQuizController::class, 'start'])->name('practice_quiz.start');
    Route::get('/practice-quiz/play/{id}', [PracticeQuizController::class, 'play'])->name('practice_quiz.play');
    Route::get('/api/practice-quiz/next/{id}', [PracticeQuizController::class, 'apiGetNextQuestion'])->name('practice_quiz.api.next');
    Route::post('/api/practice-quiz/submit/{id}', [PracticeQuizController::class, 'apiSubmitAnswer'])->name('practice_quiz.api.submit');
    Route::match(['get', 'post'], '/practice-quiz/restart/{id}', [PracticeQuizController::class, 'restartSession'])->name('practice_quiz.restart');
    Route::get('/practice-quiz/review/{id}', [PracticeQuizController::class, 'review'])->name('practice_quiz.review');
});


Route::get('/paul', function() {
    return view('exampleEasycheckout');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/buybook/pay', [SslCommerzPaymentController::class, 'buybookpay']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END






       Route::post('/buycourse/pay', [SslCommerzPaymentController::class, 'buycoursepay']);
// Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);





// End:: Frontend Route















// Begin:: Backend Route

Route::group(['middleware'=>'admin_auth'], function() {

    Route::get('/cms', [AdminCon::class, 'index'])->name('/cms');
    Route::get('/cms-profile', [AdminCon::class, 'CMSProfile'])->name('cms.profile');


    // Begin:: setting
    Route::get('/cms/company-setting', function() {
        return view('cms.setting.shop_setting');
    })->name('admin_setting');

    Route::post('/cms/add-company-setting', [ShopSettingCon::class, 'addSetting'])->name('company_info_set');
    Route::get('/cms/edit-company-setting/{id}', [ShopSettingCon::class, 'EditShopSetting']);
    Route::post('/cms/update_company_setting/{id}', [ShopSettingCon::class, 'UpdateShopSetting']);
    // End:: Setting

    // Begin:: About us
    Route::get('/cms/about-us', [AdminCon::class, 'AboutUsIndex'])->name('cms.about_us');
    Route::post('/cms/add-about-us-info', [AdminCon::class, 'Add_about_us_info'])->name('cms.add_about_us');
    Route::post('/cms/about_info_update/{id}', [AdminCon::class, 'Update_about_us_info']);
    // End:: About us

    // Begin:: Categories
    Route::get('/cms/all-category', [CategoriesCon::class, 'index'])->name('all_cat');
    Route::post('/category/add-category', [CategoriesCon::class, 'addCategory'])->name('add_category');
    Route::get('/deactiveCategory/{id}', [CategoriesCon::class, 'deactiveCategory']);
    Route::get('/activeCat/{id}', [CategoriesCon::class, 'ActiveCategory']);
    Route::get('/editCategory/{id}', [CategoriesCon::class, 'EditCategory']);
    Route::post('/update_category/{id}', [CategoriesCon::class, 'UpdateCategory']);
    Route::delete('/delete_category/{id}', [CategoriesCon::class, 'deleteCategory'])->name('delete.category');
    // End:: Categories

    // Begin::Course Categories
    Route::get('/cms/all-course-category', [CourseCategoryController::class, 'course_all'])->name('all_course_cat');
    Route::post('/course/add-category', [CourseCategoryController::class, 'addCourseCategory'])->name('course.add_category');
    Route::get('/deactiveCourseCategory/{id}', [CourseCategoryController::class, 'deactiveCourseCategory']);
    Route::get('/activeCatCourse/{id}', [CourseCategoryController::class, 'ActiveCategoryCourse']);
    Route::get('/editCourseCategory/{id}', [CourseCategoryController::class, 'EditCourseCategory']);
    Route::post('/update_course_category/{id}', [CourseCategoryController::class, 'UpdateCourseCategory']);
    Route::delete('/delete_course_category/{id}', [CourseCategoryController::class, 'deleteCourseCategory'])->name('delete.course.category');
    // End::Course Categories

    // Begin:: Home banner
    Route::get('/cms/home-banner', [SliderBanner::class, 'index'])->name('cms.home_banner');
    Route::post('/cms/home/add-banner', [SliderBanner::class, 'AddBanner'])->name('cms.add_home_banner');
    Route::get('/cms/editbanner/{id}', [SliderBanner::class, 'EditBanner']);
    Route::post('/cms/update_banner/{id}', [SliderBanner::class, 'UpdateBanner']);
    // End:: Home banner
    // Begin::  Slider
    Route::get('/cms/slider-info', [SliderBanner::class, 'slider_info'])->name('cms.slider_info');
    Route::post('/cms/home/add-info', [SliderBanner::class, 'AddInfo'])->name('cms.add_info');
    Route::get('/deactiveInfo/{id}', [SliderBanner::class, 'deactiveInfo']);
    Route::get('/activeInfo/{id}', [SliderBanner::class, 'ActiveInfo']);
    Route::get('/cms/editinfo/{id}', [SliderBanner::class, 'EditInfo']);
    Route::post('/cms/update_info/{id}', [SliderBanner::class, 'UpdateInfo']);

    Route::get('/cms/slider-img', [SliderBanner::class, 'slider_img'])->name('cms.slider_img');
    Route::post('/cms/slider/add-img', [SliderBanner::class, 'AddImg'])->name('cms.add_img');
    Route::get('/deactiveImg/{id}', [SliderBanner::class, 'deactiveImg']);
    Route::get('/activeImg/{id}', [SliderBanner::class, 'ActiveImg']);
    Route::get('/cms/editimg/{id}', [SliderBanner::class, 'EditImg']);
    Route::post('/cms/update_img/{id}', [SliderBanner::class, 'UpdateImg']);
    // End::  Slider
    //Begin :: Feedback
    Route::get('/cms/all-testimonial', [TestimonialController::class, 'all_testimonial'])->name('all.testimonial');
    Route::post('/course/add-testimonial', [TestimonialController::class, 'addTestimonial'])->name('add.testimonial');
    Route::get('/deactiveTestimonial/{id}', [TestimonialController::class, 'deactiveTestimonial']);
    Route::get('/activeTestimonial/{id}', [TestimonialController::class, 'ActiveTestimonial']);
    Route::get('/edittestimonial/{id}', [TestimonialController::class, 'EditTestimonial']);
    Route::post('/update_testimonial/{id}', [TestimonialController::class, 'UpdateTestimonial']);
    //End :: Feedback

    //Begin :: Subscription
    Route::get('/cms/all-subscription', [SubscriptionController::class, 'all_subscription'])->name('all.subscription');
    Route::post('/course/add-subscription', [SubscriptionController::class, 'addSubscription'])->name('add.subscription');
    Route::get('/deactiveSubscription/{id}', [SubscriptionController::class, 'deactiveSubscription']);
    Route::get('/activeSubscription/{id}', [SubscriptionController::class, 'ActiveSubscription']);
    Route::get('/editSubscription/{id}', [SubscriptionController::class, 'EditSubscription']);
    Route::post('/update_subscription/{id}', [SubscriptionController::class, 'UpdateSubscription']);
    //End ::  Subscription


    // Begin:: Blog
    Route::get('/cms/all-bangla-blog', [BlogCon::class, 'indexBangla'])->name('cms.banglaBlog');
    Route::get('/cms/all-english-blog', [BlogCon::class, 'indexEnglish'])->name('cms.englishBlog');


    Route::get('/cms/add-blog', function() {
        return view('cms.blog.add_blog');
    })->name('cms.add_blog_page');

    Route::post('/cms/add-ads-banner', [BlogCon::class, 'Add_new_blog'])->name('cms.add_blog');
    Route::get('/cms/edit-blog/{id}', [BlogCon::class, 'EditBlog']);
    Route::post('/cms/update-blog/{id}', [BlogCon::class, 'Update_Blog']);
    Route::delete('/cms/delete-blog/{id}', [BlogCon::class, 'Delete_Blog'])->name('cms.delete.blog');
    // End::  Blog

    // Begin:: Teachers
    Route::get('/cms/teachers', [TeachersCon::class, 'index'])->name('cms.teachers');
    Route::post('/cms/add-teachers', [TeachersCon::class, 'Add_teachers'])->name('cms.add_teachers');
    Route::get('/cms/editteacher/{id}', [TeachersCon::class, 'EditTeacher']);
    Route::post('/cms/update_teacher/{id}', [TeachersCon::class, 'UpdateTeachers']);
    // Add this to your routes file (web.php)
    Route::delete('/cms/delete-teacher/{id}', [TeachersCon::class, 'DeleteTeacher'])->name('cms.delete_teacher');
    // End:: Teachers

    // Begin:: Exams
    Route::get('/cms/permanent-exams', [ExamCon::class, 'indexParment'])->name('cms.permanent_exams');
    Route::get('/cms/temporary-exams', [ExamCon::class, 'indexTemporary'])->name('cms.temporary_exams');
    Route::get('/cms/add-exams', [ExamCon::class, 'Add_exams'])->name('cms.add_exams');
    Route::post('/cms/add-exams-confirm', [ExamCon::class, 'Add_exams_Confirm'])->name('cms.add_exam_confirm');
    Route::get('/cms/edit-exam/{id}', [ExamCon::class, 'EditExam']);
    Route::get('/cms/result/{id}', [ExamCon::class, 'allresult']);
    Route::get('/cms/parmanent/result/{id}', [ExamCon::class, 'allresult']);
    Route::post('/cms/update-exam/{id}', [ExamCon::class, 'UpdateExams']);
    Route::delete('/cms/delete-exam/{id}', [ExamCon::class, 'DeleteExams'])->name('cms.delete.exam');
    // End:: Exams
    // Begin:: Course

    Route::get('/cms/add-course', [ExamCon::class, 'add_course'])->name('cms.add_course');
    Route::get('/cms/course/list', [ExamCon::class, 'course_list'])->name('cms.course.list');
    Route::get('/deactiveCourse/{id}', [ExamCon::class, 'deactivecourse']);
    Route::get('/editCourse/{id}', [ExamCon::class, 'editcourse']);
    Route::get('/activeCourse/{id}', [ExamCon::class, 'activecourse']);
    Route::post('/cms/add-course-confirm', [ExamCon::class, 'Add_course_Confirm'])->name('cms.add_course_confirm');
    Route::post('/cms/update-course/{id}', [ExamCon::class, 'update_course_Confirm'])->name('cms.update_course_confirm');
    Route::delete('/cms/delete-course/{id}', [ExamCon::class, 'deleteCourse'])->name('cms.delete.course');

    //Edit & Delete Module
    Route::post('/cms/edit-course-module', [ExamCon::class, 'editCourseModule'])->name('cms.edit_course_module');
    Route::post('/cms/delete-course-module', [ExamCon::class, 'deleteCourseModule'])->name('cms.delete_course_module');


    // End:: Exams

    // Begin:: Exams Questions
    Route::get('/cms/exam-mcq-questions/{id}', [ExamCon::class, 'Exam_MCQ_Questions_Page']);
    Route::get('/cms/add_mcq_question/{id}', [ExamCon::class, 'addd_MCQ_Questions_Page']);
    Route::get('/cms/add_written_question/{id}', [ExamCon::class, 'add_written_Questions_Page']);
    Route::get('/cms/exam-mcq-questions/edit/{id}', [ExamCon::class, 'Exam_MCQ_Questions_Page_edit']);
    Route::get('/cms/exam-written-questions/edit/{id}', [ExamCon::class, 'Exam_written_Questions_Page_edit']);
    Route::post('/cms/add-mcq-questions', [ExamCon::class, 'Add_MCQ_Questions'])->name('cms.add_mcq_confirm');
    Route::get('/cms/exam-written-questions/{id}', [ExamCon::class, 'Exam_Written_Questions_Page']);
    Route::post('/cms/add-written-questions', [ExamCon::class, 'Add_Written_Questions'])->name('cms.add_written_questions_confirm');
    // End:: Exams Questions


    // Begin:: Questions CSV
    Route::get('/cms/questions-csv', function() {
        return view('cms.exam.questions_csv');
    })->name('cms.questions.csv');

    Route::post('/cms/mcq-questions-csv-confirm', [ExamCon::class, 'MCQ_questions_CSV_Confirm'])->name('cms.mcq_questions_csv_confirm');
    Route::post('/cms/written-questions-csv-confirm', [ExamCon::class, 'Written_questions_CSV_Confirm'])->name('cms.written_questions_csv_confirm');
    // End:: Questions CSV

    // Begin:: Practice Quizzes (Gamified Preparation)
    Route::get('/cms/practice-quizzes', [PracticeQuizAdminController::class, 'index'])->name('cms.practice_quizzes');
    Route::get('/cms/practice-quizzes/create', [PracticeQuizAdminController::class, 'create'])->name('cms.practice_quiz.create');
    Route::post('/cms/practice-quizzes/store', [PracticeQuizAdminController::class, 'store'])->name('cms.practice_quiz.store');
    Route::get('/cms/practice-quizzes/edit/{id}', [PracticeQuizAdminController::class, 'edit'])->name('cms.practice_quiz.edit');
    Route::post('/cms/practice-quizzes/update/{id}', [PracticeQuizAdminController::class, 'update'])->name('cms.practice_quiz.update');
    Route::match(['get', 'delete'], '/cms/practice-quizzes/delete/{id}', [PracticeQuizAdminController::class, 'destroy'])->name('cms.practice_quiz.delete');
    Route::get('/cms/practice-quizzes/toggle/{id}', [PracticeQuizAdminController::class, 'toggleStatus'])->name('cms.practice_quiz.toggle');
    Route::get('/cms/practice-quizzes/{id}/questions', [PracticeQuizAdminController::class, 'questionsIndex'])->name('cms.practice_quiz.questions');
    Route::post('/cms/practice-quizzes/{id}/questions/save', [PracticeQuizAdminController::class, 'saveQuestions'])->name('cms.practice_quiz.questions.save');
    Route::match(['get', 'delete'], '/cms/practice-quizzes/{quizId}/questions/{questionId}', [PracticeQuizAdminController::class, 'deleteQuestion'])->name('cms.practice_quiz.questions.delete');
    Route::match(['get', 'delete'], '/cms/practice-quizzes/{quizId}/questions/{questionId}/delete', [PracticeQuizAdminController::class, 'deleteQuestion']);
    Route::post('/cms/practice-quizzes/{id}/questions/upload-csv', [PracticeQuizAdminController::class, 'uploadCsv'])->name('cms.practice_quiz.upload_csv');
    // End:: Practice Quizzes

    // Begin:: All student And Student Reports page
    Route::get('/cms/students', [AdminCon::class, 'All_students'])->name('cms.students.all');
    Route::get('/cms/edit-student/{id}', [AdminCon::class, 'editStudent'])->name('cms.edit.student');
    Route::put('/cms/update-student/{id}', [AdminCon::class, 'updateStudent'])->name('cms.update.student');
    Route::delete('/cms/delete-student/{id}', [AdminCon::class, 'deleteStudent'])->name('cms.delete.student');

    Route::get('/cms/student-mcq-reports', [ExamCon::class, 'student_mcq_result_page'])->name('cms.student_mcq_result_page');
    Route::delete('/cms/delete-mcq-reports/{id}', [ExamCon::class, 'delete_mcq_result_page'])->name('cms.delete.mcq.result.page');

    Route::get('/cms/student-written-reports', [ExamCon::class, 'student_written_result_page'])->name('cms.student_written_result_page');
    // Route::delete('/cms/delete-written-reports/{id}', [ExamCon::class, 'delete_written_result_page'])->name('cms.delete.written.result.page');

    Route::get('/cms-review-written-exam/{id}', [ExamCon::class, 'review_written_exam_cms']);
    Route::get('/cms/set-written-ans-mark', [ExamCon::class, 'set_written_exam_mark']);
    Route::get('/cms/set-written-result-status', [ExamCon::class, 'SET_written_exam_review_status']);
    Route::get('/cms/sum-written-result', [ExamCon::class, 'Sum_written_exam']);
    Route::get('/cms/set-written-ans-note', [ExamCon::class, 'SET_written_exam_note']);
    

    // End:: Student Reports page

    //Begin:: CMS Orders
    Route::get('/cms/all-orders', [AdminCon::class, 'All_orders'])->name('cms.orders.all');
    //End:: CMS Orders

    // Begin:: News and Notice
    Route::get('/cms/news-and-notice', [AdminCon::class, 'all_news_and_notice'])->name('cms.news_notice');
    Route::post('/cms/add-news-and-notice', [AdminCon::class, 'Add_news_and_notice'])->name('cms.add_notice');
    Route::get('/cms/edit-notice/{id}', [AdminCon::class, 'Edit_notice']);
    Route::post('/cms/update_news_notice/{id}', [AdminCon::class, 'Update_News_notice']);
    Route::delete('/cms/delete_notice/{id}', [AdminCon::class, 'delete_notice'])->name('cms.delete.notice');
    // End:: News and Notice

    // Begin:: Books
    Route::get('/cms/books', [AdminCon::class, 'all_books'])->name('cms.books');
    Route::post('/cms/add-books', [AdminCon::class, 'Add_Books'])->name('cms.add_books');
    Route::get('/cms/edit-books/{id}', [AdminCon::class, 'Edit_Books']);
    Route::post('/cms/update_books/{id}', [AdminCon::class, 'Update_Books']);
    Route::delete('/cms/delete-books/{id}', [AdminCon::class, 'Delete_Books'])->name('cms.delete.books');

    // End:: Books

    // Begin:: Orders
    Route::get('/cms/orders', [AdminCon::class, 'all_orders_books'])->name('cms.orders.books');
    Route::get('/cms/course/enroll', [AdminCon::class, 'all_orders_course'])->name('cms.orders.course');
    Route::get('/cms/orderDetails/{id}', [AdminCon::class, 'Book_order_details']);
    Route::get('/cms/course/orderDetails/{id}', [AdminCon::class, 'Course_order_details']);
    Route::post('/cms/admin-books-order-change', [AdminCon::class, 'Update_admin_order_status'])->name('cms.admin_order_change');
    Route::post('/cms/admin-courses-order-change', [AdminCon::class, 'Update_admin_courses_order_status'])->name('cms.admin_courses_order_change');
    // End:: Orders

    // Begin:: English lerning
    Route::get('/cms/learning-english', function() {
        return view('cms.setting.learning_setting');
    })->name('cms.learning_english');

    Route::post('/cms/set-learning-english', [AdminCon::class, 'Set_learning_english'])->name('cms.set_learning_english');
    Route::get('/cms/edit-learning-english-setting/{id}', [AdminCon::class, 'Edit_larning_english_setting']);
    Route::post('/cms/update-learning-english-setting/{id}', [AdminCon::class, 'Update_learning_english']);
    // End:: English lerning
    Route::get('/cms/contact-submit-list', [AdminCon::class, 'form_submit_list'])->name('cms.contact.list');

























});




Route::get('/cms/login', function () {
    return view('cms.auth.login');
})->name('/cms/login');

Route::get('/cms/register', function () {
    return view('cms.auth.cms_register');
})->name('/cms/register');

Route::post('admin.login', [AdminCon::class, 'login'])->name('admin.login');
Route::post('admin.register', [AdminCon::class, 'adminRegister'])->name('admin.register');
Route::get('/admin_logout', [AdminCon::class, 'admin_logout'])->name('admin_logout');





// End:: Backend Route


