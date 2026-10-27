<?php

namespace App\Http\Controllers;

use Log;
use Image;
use App\Models\User;
use App\Models\Course;
use App\Mail\MyTestMail;
use App\Models\CourseModule;
use Illuminate\Http\Request;
use App\Models\WrittenResult;
use App\Models\CourseCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\WrittenResultsParent;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class FrontCon extends Controller
{
    //Beging:: User About us page
    public function User_AboutUs() {
        return view('user.pages.about.about_us');
    }
    //End:: User About us page

    //Beging:: User Contact us page
    public function User_ContactUs() {
        $company_info = DB::table('company_settings')->first();
        return view('user.pages.extra.contact_us', compact('company_info'));
    }
    //End:: User Contact us page



    //Beging:: User Mission and Vission
    public function User_mission_and_vission() {
        $company_info = DB::table('company_settings')->first();
        return view('user.pages.extra.mission_vission', compact('company_info'));
    }
    //End:: User Mission and Vission

    //Beging:: User privacy-policy
    public function User_privacy_policy() {
        $company_info = DB::table('company_settings')->first();
        return view('user.pages.extra.privacy_policy', compact('company_info'));
    }
    //End:: User privacy-policy
    //Beging:: User_return_policy
    public function User_return_policy() {
        return view('user.pages.extra.return_policy');
    }
    //End:: User_return_policy

    //Beging:: certificate_number
    public function certificate_number() {
        return view('user.pages.extra.certificate_number');
    }
    //End:: certificate_number

    //Beging:: User Trams & Conditions
    public function User_trams_and_conditions() {
        $company_info = DB::table('company_settings')->first();
        return view('user.pages.extra.trams_conditions', compact('company_info'));
    }
    //End:: User Trams & Conditions

    //Beging:: Category to Exams page
    public function Category_To_CAT_exam_page($id) {
        $catInfo = DB::table('categories')->where('id', $id)->first();
        $MCQexams = DB::table('exams')->where('catID', $id)->where('mcq_written', 'mcq')->where('active', 1)->get();
        $WrittenExams = DB::table('exams')->where('catID', $id)->where('mcq_written', 'written')->where('active', 1)->get();
        return view('user.pages.exams.cat_all_exams', compact('MCQexams', 'WrittenExams', 'catInfo'));
    }
    //End:: Category to Exams page
    //Beging:: Course page
    public function course() {

        $courses = DB::table('courses')->paginate(3);

        return view('user.pages.extra.course_category', compact('courses'));
    }
    //End:: Category to Course page
    //Beging:: Course page
    public function all_courses()
    {
        return view('user.pages.all_courses.all_courses');
    }
    public function course_details($id) {
        $courseInfo = Course::with('courseModules')->findOrFail($id);
        $userID = Cookie::get('user_id');
        $order = DB::table('courses_order')
            ->where('course_id', $id)
            ->where('user_id', $userID)
            ->first(); // Will be null if no order found
        // dd($order);
        return view('user.pages.extra.course_details', compact('courseInfo', 'order'));
    }
    public function free_lession($id) {
        if (!is_numeric($id)) {
            abort(404, 'Course not found');
        }
    
        // Fetch course information
        $courseInfo = DB::table('courses')->where('id', $id)->first();
    
        // Check if course exists
        if (!$courseInfo) {
            abort(404, 'Course not found');
        }
    
        // Fetch modules for the course
        $modules = CourseModule::where('course_id', $id)
            ->where('free_paid', 'free')
            ->get();
    
        // Optionally, you might fetch the course order if needed
        // Remove this if not used
        // $courseOrder = DB::table('courses_order')->where('pid', $courseInfo->id)->get();
    
        // Return view with course information and modules
        return view('user.pages.extra.free_lession', compact('courseInfo', 'modules'));
    }
    public function course_lession($id) {
        $userID = Cookie::get('user_id');
        $userName = Cookie::get('user_name');
        $courseInfo = DB::table('courses')->where('id', $id)->first();
        $modules = CourseModule::where('course_id' ,$id)->get();
        $courseOrder = DB::table('courses_order')->where('pid',$courseInfo->id)->get();

        return view('user.pages.extra.lession', compact('courseInfo','modules'));
    }
    public function course_cats($id) {
        $course_category = CourseCategory::with('courses')->where('id', $id)->firstOrFail();
        $courses = $course_category->courses()->paginate(6);

        return view('user.pages.extra.course', compact('course_category', 'courses'));
    }

    //End:: Category to Course page

    //Begin::User Register
    public function UserRegister(Request $request){
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|unique:users|max:255',
            'phone' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|min:5',

        ]);

        $data = array();
        $data['name'] = $request->name;
        // $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['password'] = Hash::make($request->password);
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();
        DB::table('users')->insert($data);

        $result = DB::table('users')->Where('phone', $request->phone)->first();
        $cTime = 3000;
        Cookie::queue(Cookie::make('user_id', $result->id, $cTime));
        Cookie::queue(Cookie::make('user_name', $result->name, $cTime));
        return redirect('/')->with('userSuccess', 'Sing Up and Sign In Successfully');



    }
    //End::User Register

    //Begin:: User Login
    public function UserLogin(Request $request){
        $email_or_phone = $request->email_or_phone;
        $password =   $request->password;


        $result = DB::table('users')
        ->where(['email'=>$email_or_phone])
        ->orWhere('phone', $email_or_phone)
        ->first();

        if(!empty($result->phone)){

            if(Hash::check($password, $result->password)) {
                if($result->active == 1){
                    $cTime = 3000;
                    Cookie::queue(Cookie::make('user_id', $result->id, $cTime));
                    Cookie::queue(Cookie::make('user_name', $result->name, $cTime));
                    return redirect('/')->with('userSuccess', 'Login Successfully');
                }
                else {
                    return redirect()->back()->with('notAllow', 'User is Deactive!');
                }
            } else {
                return redirect()->back()->with('notAllow', 'Wrong User Information!');
            }
        }
        else {
            return redirect()->back()->with('notAllow', 'Wrong User Information!');
        }
    }
    //End:: User Login

    // Begin:: Update User Profile
    public function UpdateUserProfile(Request $request, $id){
        $request->validate([
            'name' => 'nullable',
            'address' => 'nullable',
            'password' => 'required',
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['password'] = Hash::make($request->password);
        $data['updated_at'] = Carbon::now();

        DB::table('users')->where('id', $id)->update($data);
        return Redirect()->route('user.myaccount')->with('userSuccess', 'Profile Update Successfully');;

    }
    // End:: Update User Profile


    // Begin:: User Logout
    public function UserLogout(){
        setcookie('user_id', '' , time() - 3600, "/");
        setcookie('user_name', '' , time() - 3600, "/");
        return redirect('/')->with('userSuccess', 'Logout Successfully');
    }
    // End:: User Logout

    //Begin:: User Password Reset
    public function UserPassResetCheckEmail(Request $request) {
        $randomId       =   random_int(1000, 9999);

        $result = DB::table('users')->where(['email'=>$request->email])->first();
        if($result){
     $uid=$result->id;
     $email=$result->email;

       $user=User::find($result->id);
        $user->otp= $randomId;
        $user->save();
        if(!empty($result->id)) {
            // $code = str_random(15);

            // dd($randomId);
            $details = [
                'title' => 'Mail From English Exploeres BD',
                'body' => 'Your Security code is - '. $randomId,
            ];

            Mail::to($request->email)->send(new MyTestMail($details));
            return view('user.pages.account.otp_code',compact('uid','email'));

        }

    }else {
        return redirect()->back()->with('notAllow', 'Sorry Invalid Email!');
    }

    }
    //End:: User Password Reset
    //Begin:: otp verify Password Reset
    public function otpverify (Request $request) {

      $uid=$request->uid;
       $user=User::find($request->uid);
        $getotp=$user->otp;

        if(( $getotp == $request->otp)) {

            return view('user.pages.account.password_reset',compact('uid'));

        }
        else {
            $request->session()->flash('pass', 'otp invalid');


            return redirect('/password-reset');
        }

    }
    //End:: otp verify Password Reset
    //Begin::  Password Reset
    public function passreset (Request $request) {

      $uid=$request->uid;
       $user=User::find($request->uid);
        $getotp=$user->otp;

        if((  $request->password== $request->password_confirmation)) {

            $user=User::find($request->uid);
            $user->password=Hash::make($request->password);
            $user->save();

           return redirect('/');

        }
        else {
            $request->session()->flash('pass', 'please enter same password');


            return back();
        }

    }
    //End::  Password Reset

    // Begin:: MyAccount page
    public function MyAccountPage(){
        return view('user.pages.account.myaccount');
    }
    public function MyAccountPagepro(){
        return view('user.pages.account.profile');
    }
    public function MyAccountPageprosetting(){
        return view('user.pages.account.profile_setting');
    }
    public function MyAccountPagecourses(){
        return view('user.pages.account.courses');
    }
    public function MyAccountPageexam(){
        return view('user.pages.account.exam');
    }
    public function MyAccountPageorder(){
        return view('user.pages.account.order');
    }
    public function MyAccountPagedashboard(){
        return view('user.pages.account.dashboard');
    }
    // End:: MyAccount page




    // Begin:: Start MCQ Exam page
    public function StartExamUser($id){
        $userID = Cookie::get('user_id');
        $userExamCheck = DB::table('results')->where('userID', $userID)->where('examID', $id)->first();
        if(!empty($userExamCheck->id)) {
            // user already attend this mcq exam, this will go user result page
            $examID = $id;
            return view('user.pages.exams.mcq_result', compact('examID', 'userID'));
        }
        else {

            $examInfo = DB::table('exams')
                        ->join('categories', 'exams.catID', 'categories.id')
                        ->select('exams.*', 'categories.*', 'exams.id as exam_id', 'categories.id as catID', 'categories.free_paid as cat_free_paid')
                        ->where('exams.id', $id)
                        ->where('exams.active', 1)
                        ->first();
            if(!empty($examInfo->exam_id)) {
                $questions = DB::table('mcq_questions')->where('examID', $examInfo->exam_id)->get();
                $ordersInfo = DB::table('orders')->where('userID', $userID)->where('examID', $examInfo->catID)->first(); // Here ExamID change to cat id, due to update client QC

                if($examInfo->cat_free_paid == 'free') {
                    return view('user.pages.exams.start_mcq_exam', compact('examInfo', 'questions', 'userID'));
                }
                else if($examInfo->cat_free_paid == 'paid') {
                    $pageFrom = 'm';
                    if(!empty($ordersInfo->id)) {
                        return view('user.pages.exams.start_mcq_exam', compact('examInfo', 'questions', 'userID'));
                    }
                    else {
                        $catInfo = DB::table('categories')->where('id', $examInfo->catID)->first();
                        return view('user.pages.exams.category_payment', compact('catInfo', 'userID'));

                    }
                }
            }
            else {
                return redirect()->back()->with('notAllow', 'Exam is not deactive now!');
            }



        }
    }
    // End:: Start MCQ Exam page

    //Begin:: category page to cat payment page
    function Category_page_to_payment_page($id) {
        $userID = Cookie::get('user_id');
        $catInfo = DB::table('categories')->where('id', $id)->first();

        return view('user.pages.exams.category_payment', compact('catInfo', 'userID'));
    }
    //End:: category page to cat payment page

    //Begin::Special --------------------------------------------------Special-------------Special-----Special -------- Special >>>>>

    public function Running_MCQ_Special_exam($id) {
        $userID = Cookie::get('user_id');
        $OrdersQ = DB::table('orders')->where('examID', $id)->where('userID', $userID)->where(function($query) {
            $query->where('status', 'Processing')
                  ->orWhere('status',  'Complete');
        })
        ->first();

        if(!empty($OrdersQ->id)) {
            $examInfo = DB::table('exams')->where('id', $id)->where('active', 1)->first();
            $questions = DB::table('mcq_questions')->where('examID', $examInfo->id)->get();
            return view('user.pages.exams.start_mcq_exam', compact('examInfo', 'questions', 'userID'));
        }
        else {
            return redirect()->back()->with('notAllow', 'Payment is not complete! Please Pay first');
        }

    }

    public function Running_Written_Special_exam($id) {
        $userID = Cookie::get('user_id');
        $OrdersQ = DB::table('orders')->where('examID', $id)->where('userID', $userID)->where(function($query) {
            $query->where('status', 'Processing')
                  ->orWhere('status',  'Complete');
        })
        ->first();

        if(!empty($OrdersQ->id)) {
            $examInfo = DB::table('exams')->where('id', $id)->where('active', 1)->first();
            return view('user.pages.exams.start_written_exam', compact('examInfo', 'userID'));
        }
        else {
            return redirect()->back()->with('notAllow', 'Payment is not complete! Please Pay first');
        }

    }


    //End::Special --------------------------------------------------Special-------------Special-----Special -------- Special >>>>>


    // Begin:: MCQ exam Confirm
    public function MCQ_exam_confirm(Request $request){

        $count = count($request->qid);
        $examID = $request->examID;
        $userID = $request->userID;


        $checkresultInfo=DB::table('mcq_results_parents')->where(['examID'=>$examID,'userID'=>$request->userID])->first();
        if(!is_null($checkresultInfo)){
             return redirect()->back();

         }


        $mcq_result_parent = array();
        $mcq_result_parent['examID'] = $examID;
        $mcq_result_parent['userID'] = $request->userID;
        $mcq_result_parent['created_at'] = Carbon::now();
        DB::table('mcq_results_parents')->insert($mcq_result_parent);

        $resultInfo=DB::table('mcq_results_parents')->where(['examID'=>$examID,'userID'=>$request->userID])->first();



        // dd($checkresultInfo);

            $data = array();



            for($i = 0; $i < $count; $i++) {
                $selectedOptn = 'selectedOption'.$request->qid[$i];
                $qid = $request->qid[$i];
                $userAns = $request->$selectedOptn;

                // echo $userAns."<br>";
                if(!empty($userAns)) {
                   if($request->r[$i] == $userAns) {
                        $data['obtained_mark'] = $request->mark[$i];
                    }
                    else {
                        $data['obtained_mark'] = $request->negativeMark[$i];
                    }
                }
                else {
                    $data['obtained_mark'] = 0;
                }






                $data['examID'] = $examID;
                $data['userID'] = $request->userID;
                $data['qid'] = $qid;
                $data['userAns'] = $userAns;
                $data['rightAns'] = $request->r[$i];
                $data['mark'] = $request->mark[$i];
                $data['negativeMark'] = $request->negativeMark[$i];
                $data['mcq_results_parent_id']=$resultInfo->id;
                $data['created_at'] = Carbon::now();
                DB::table('mcq_results')->insert($data);

            }


            $resultData = array();
            $resultData['examID'] = $examID;
            $resultData['userID'] = $request->userID;
            $resultData['mcq_written'] = 'mcq';
            $resultData['created_at'] = Carbon::now();
            DB::table('results')->insert($resultData);



            return view('user.pages.exams.mcq_result', compact('examID', 'userID'));
        // return 'hello paul';
    }
    // End:: MCQ exam Confirm

    //Begin::MCQ exam result
    public function McQ_Exam_result($id) {
        $userID = Cookie::get('user_id');
        $examID = $id;
        return view('user.pages.exams.mcq_result', compact('examID', 'userID'));
    }
    //End::MCQ exam result



    // Begin:: Start Written Exam page
    public function StartWrittenExamUser($id){


        $userID = Cookie::get('user_id');
        $userExamCheck = DB::table('results')->where('userID', $userID)->where('examID', $id)->first();
        if(!empty($userExamCheck->id)) {
            // user already attend this written exam, this will go user result page
            $examID = $id;
            return view('user.pages.exams.written_result', compact('examID', 'userID'));
        }
        else {

            $examInfo = DB::table('exams')
                        ->join('categories', 'exams.catID', 'categories.id')
                        ->select('exams.*', 'categories.*', 'exams.id as exam_id', 'categories.id as catID', 'categories.free_paid as cat_free_paid')
                        ->where('exams.id', $id)
                        ->where('exams.active', 1)
                        ->first();
            if(!empty($examInfo->exam_id)) {
                //$questions = DB::table('mcq_questions')->where('examID', $examInfo->exam_id)->get();
                $ordersInfo = DB::table('orders')->where('userID', $userID)->where('examID', $examInfo->catID)->first(); // Here ExamID change to cat id, due to update client QC

                if($examInfo->cat_free_paid == 'free') {
                    return view('user.pages.exams.start_written_exam', compact('examInfo', 'userID'));
                    //return view('user.pages.exams.start_mcq_exam', compact('examInfo', 'questions', 'userID'));
                }
                else if($examInfo->cat_free_paid == 'paid') {
                    $pageFrom = 'm';
                    if(!empty($ordersInfo->id)) {
                        //return view('user.pages.exams.start_mcq_exam', compact('examInfo', 'questions', 'userID'));
                        return view('user.pages.exams.start_written_exam', compact('examInfo', 'userID'));
                    }
                    else {
                        $catInfo = DB::table('categories')->where('id', $examInfo->catID)->first();
                        return view('user.pages.exams.category_payment', compact('catInfo', 'userID'));

                    }
                }
            }
            else {
                return redirect()->back()->with('notAllow', 'Exam is not deactive now!');
            }




        }
    }
    // End:: Start Written Exam page

    // Begin:: Written exam Confirm
    public function Written_exam_confirm(Request $request)
{
    // dd($request->all());
    // Validate the file uploads and other inputs
    $request->validate([
        'file_path.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        'qid.*' => 'required',
        'ans.*' => 'required',
        'mark.*' => 'required',
    ]);

    $examID = $request->examID;
    $userID = $request->userID;

    // Insert answers into written_results
    $count = count($request->qid);
    for ($i = 0; $i < $count; $i++) {

        $imageName = null;
        // Check if a file is uploaded for this particular question
        if ($request->hasFile("file_path.$i") && $request->file("file_path.$i")->isValid()) {
            // Generate a unique name for the file
            $imageName = time().'_'.$i.'.'.$request->file("file_path.$i")->extension();
            // Move the uploaded file to a public directory
            $request->file("file_path.$i")->move(public_path('file_path'), $imageName);
        }

        WrittenResult::create([
            'examID' => $examID,
            'userID' => $userID,
            'qid' => $request->qid[$i],
            'userAns' => $request->ans[$i],
            'mark' => $request->mark[$i],
            'file_path' => $imageName,
        ]);
    }

    // Insert a record into results
    DB::table('results')->insert([
        'examID' => $examID,
        'userID' => $userID,
        'mcq_written' => 'written',
        'written_status' => 'pending',
        'created_at' => Carbon::now(),
    ]);

    // Redirect to user account with success message
    return redirect()->route('user.myaccount')->with('message', 'Congratulations! Your exam is complete. We will review this answer.');
}



    // End:: Written exam Confirm

    //Begin::written exam result
    public function Written_Exam_result($id) {
        $userID = Cookie::get('user_id');
        $examID = $id;
        return view('user.pages.exams.written_result', compact('examID', 'userID'));
    }
    //End::written exam result


    // Begin:: Books
    public function User_books() {
        $books = DB::table('books')->orderBy('id', 'desc')->get();

        return view('user.pages.extra.books', compact('books'));
    }
    public function User_shop() {
        $products = DB::table('books')->orderBy('id', 'desc')->paginate(8);

        return view('user.pages.extra.shop', compact('products'));
    }

    public function User_book_details($id) {
        $book_info = DB::table('books')->where('id', $id)->first();
        return view('user.pages.extra.book_info', compact('book_info'));
    }
    public function User_product_details($id) {
        $product_info = DB::table('books')->where('id', $id)->first();
        return view('user.pages.extra.product_info', compact('product_info'));
    }

    public function Checkout() {
        $pid = $_GET['productID'];
        $quantity = $_GET['quantity'];
        //$book_info = DB::table('books')->where('id', $id)->first();
        return view('user.pages.extra.checkout', compact('pid', 'quantity'));
    }
    public function CheckoutSub() {
        $pid = $_GET['productID'];
        $plan = $_GET['plan_type'];
        //$book_info = DB::table('books')->where('id', $id)->first();
        return view('user.pages.extra.checkout_sub', compact('pid', 'plan'));
    }
    public function checkout1(Request $request) {
        $pid = $request->input('productID');
        $quantity = $request->input('quantity'); // Default value if key does not exist
    
        $product_info = DB::table('books')->where('id', $pid)->first();
        $userID = Cookie::get('user_id');
        $user_info = DB::table('users')->where('id', $userID)->first();
    
        return view('user.pages.extra.checkout1', compact('pid', 'quantity', 'product_info', 'user_info'));
    }
    public function buycourse() {
        $user = Cookie::get('user_id');
        if($user){
            $courseid = request()->query('productID');
            $gateways = PaymentGateway::where('status', 1)->orderBy('id', 'asc')->get();
            return view('user.pages.extra.buycourse', compact('courseid', 'gateways'));
        }else{
            return redirect('/user-signin-singup')->with('adminError', 'Please sign in first to purchase this course');
        }
    }

    public function Confirm_Checkout(Request $request) {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            // 'radio' => 'required',
        ]);

        $total_order = DB::table('books_order')->count('id');
        $current_order = $total_order + 1;
        $order_num = 'EP'.date("dmy").$current_order;

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['pid'] = $request->pid;
        $data['price'] = $request->price;
        $data['quantity'] = $request->quantity;
        $data['orderNum'] = $order_num;
        $data['status'] = 'pending';
        $data['date'] = Carbon::now();

    // if ($request->order=="cash") {

    // }
        DB::table('books_order')->insert($data);

        return redirect('/ordres-info/'.$order_num)->with('userSuccess', 'Order Confirmed Successfully.');

    }

    public function Check_orders($orderNum) {
        $orders_info = DB::table('books_order')->where('orderNum', $orderNum)->first();

        return view('user.pages.extra.orders_info', compact('orders_info'));
    }
    public function complete_orders($orderNum) {
        $orders_info = DB::table('books_order')->where('orderNum', $orderNum)->first();

        return view('user.pages.extra.order_info', compact('orders_info'));
    }

    // End:: Books

    public function contact_form(Request $request) {
        $data = array();
        $data['name'] = $request->name;
        $data['number'] = $request->phone;
        $data['created_at'] = Carbon::now();
        DB::table('contact_us')->insert($data);

        return back()->with('userSuccess', 'Submitted Successfully.');

    }

    public function courseOrder(Request $request) {
        $user = Cookie::get('user_id') ?? $request->cookie('user_id');
        
        if (!$user) {
            return redirect('/user-signin-singup')->with('adminError', 'Please sign in to complete your course enrollment.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'course_id' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'payment_gateway_id' => 'required|exists:payment_gateways,id',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'trx_id' => 'required|string|max:255',
        ];

        $gateway = PaymentGateway::findOrFail($request->payment_gateway_id);

        if ($gateway->type === 'mfs') {
            $rules['sender_number'] = 'required|string|max:50';
        } else {
            $rules['bank_name'] = 'required|string|max:255';
            $rules['bank_account_number'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = 'pay_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/payments'), $filename);
            $screenshotPath = 'uploads/payments/' . $filename;
        }

        $total_order = DB::table('courses_order')->count('id');
        $order_num = 'EOD' . date("dmy") . ($total_order + 1);

        $data = [
            'pid' => $request->course_id,
            'course_id' => $request->course_id,
            'user_id' => $user,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address ?? '',
            'price' => $request->price,
            'amount' => $request->price,
            'currency' => 'BDT',
            'orderNum' => $order_num,
            'transaction_id' => $request->trx_id,
            'trx_id' => $request->trx_id,
            'payment_gateway_id' => $gateway->id,
            'payment_method' => $gateway->name,
            'payment_type' => $gateway->type,
            'sender_number' => $request->sender_number ?? null,
            'bank_name' => $request->bank_name ?? ($gateway->type === 'bank' ? $gateway->bank_name : null),
            'bank_account_number' => $request->bank_account_number ?? null,
            'screenshot' => $screenshotPath,
            'status' => 'pending',
            'payment_status' => 'pending',
            'date' => now(),
        ];

        try {
            DB::table('courses_order')->insert($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while placing the order: ' . $e->getMessage());
        }

        return redirect()->route('user.myaccount.order')->with('userSuccess', 'Payment submitted successfully! Your manual payment is under verification by our team. Once approved, the course will be unlocked immediately.');
    }
    
}
