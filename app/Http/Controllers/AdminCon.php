<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestMail;
use App\Models\admin;
use App\Models\Course;

class AdminCon extends Controller
{
    public function index(){
        return view('cms.pages.dashboard');
    }

    //Begin::Cms profile
    public function CMSProfile(){

        $admin_id = session()->get('admin_id');
        $admin_info = DB::table('admins')->where(['id'=>$admin_id])->first();
        return view('cms.pages.profile', compact('admin_info'));
    }
    //End::Cms profile



    // Login
    public function login(Request $request){

        $email = $request->email;
        $password =   $request->password;
        // $pin = $request->pin;

        $result = DB::table('admins')->where(['email'=>$email])->first();

        if(!empty($result->email)){
            if(Hash::check($password, $result->password)) {
                if($result->active == 1){
                    $request ->session()->put('admin_id', $result->id);
                    return redirect('/cms')->with('status', 'Login Successfully');
                }
                else {
                    $request->session()->flash('error', 'User Is Deactive!!');
                    return Redirect()->back();
                }
            } else {
                $request->session()->flash('error', 'Invalid User Information! Please Try Again');
                return Redirect()->back();
            }
        }
        else {
            $request->session()->flash('error', 'Invalid User Information! Please Try Again');
            return Redirect()->back();
        }


    }

    public function adminRegister(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins|max:255',
            'password' => 'required|confirmed|min:3',

        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['created_at'] = Carbon::now();

        DB::table('admins')->insert($data);
        return Redirect('/cms/login');


    }

    public function admin_logout(Request $request){
        $request->session()->flush();
        return redirect('/cms/login');

    }

    //Begin:: About us
    public function AboutUsIndex() {
        $aboutInfo = DB::table('about_infos')->first();
        return view('cms.pages.about_setup', compact('aboutInfo'));
    }
    //End:: About us

    //Begin:: Add About us
    public function Add_about_us_info(Request $request) {
        $request->validate([
            'image' => 'required',
        ]);

        $about_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$about_image->getClientOriginalExtension();
        Image::make($about_image)->resize(520, 410)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['aboutDes'] = $request->editor1;
        $data['image'] = $last_img;
        $data['created_at'] = Carbon::now();

        DB::table('about_infos')->insert($data);
        return Redirect() -> route('cms.about_us')->with('status', 'About Info Added Successfully');
    }
    //End:: Add About us

    //Begin:: Add About us
    public function Update_about_us_info(Request $request, $id) {

        $old_image = $request->old_image;
        $data = array();

        $about_image = $request->file('image');

        if($about_image){
            $name_gen = hexdec(uniqid()).".".$about_image->getClientOriginalExtension();
            Image::make($about_image)->resize(520, 410)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;

            if ($old_image) {
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }

            $data['image'] = $last_img;
        }

        $about_image = $request->file('image');

        $data['aboutDes'] = $request->editor1;
        $data['updated_at'] = Carbon::now();

        DB::table('about_infos')->where('id', $id)->update($data);
        return Redirect() -> route('cms.about_us')->with('status', 'About Info Update Successfully');
    }
    //End:: Add About us

    //Begin:: All Students
    public function All_students() {
        $students = DB::table('users')->orderBy('id', 'desc')->get();
        return view('cms.students.all_students', compact('students'));
    }
    //End:: All Students

    public function editStudent($id) {
        $student = DB::table('users')->where('id', $id)->first();
        return view('cms.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id) {
        // dd($request->all());
        DB::table('users')->where('id', $id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('cms.students.all')->with('status', 'Password Updated Successfully');
    }

    //Begin:: All Orders
    public function All_orders() {
        $Orders = DB::table('orders')->where(function($query) {
            $query->where('status', 'Processing')
                  ->orWhere('status',  'Complete');
        })
        ->get();
        return view('cms.orders.all_order', compact('Orders'));
    }
    //End:: All Orders

    //Begin:: News and Notice
    public function all_news_and_notice() {
        $news = DB::table('notice')->orderBy('id', 'desc')->get();
        return view('cms.notice.all_notice', compact('news'));
    }

    public function Add_news_and_notice(Request $request) {
        $request->validate([
            'title' => 'required',
        ]);

        $data = array();
        $data['title'] = $request->title;
        $data['active'] = $request->active;


        DB::table('notice')->insert($data);
        return Redirect()->back()->with('status', 'New Notice Added Successfully');
    }

    public function Edit_notice($id) {
        $news = DB::table('notice')->where('id', $id)->first();
        return view('cms.notice.edit_notice', compact('news'));
    }

    public function Update_News_notice(Request $request, $id) {
        $data = array();
        $data['title'] = $request->title;
        $data['active'] = $request->active;


        DB::table('notice')->where('id', $id)->update($data);
        return Redirect()->route('cms.news_notice')->with('status', 'Notice Update Successfully');
    }

    public function delete_notice($id) {
        // Retrieve the teacher record to get the image path
        DB::table('notice')->where('id', $id)->first();

        DB::table('notice')->where('id', $id)->delete();

        return redirect()->back()->with('status', 'Book Deleted Successfully');
    }
    //End:: News and Notice

    //Begin:: Books
    public function all_books() {
        $books = DB::table('books')->orderBy('id', 'desc')->get();
        return view('cms.books.all_books', compact('books'));
    }

    public function Add_Books(Request $request) {

        $book_image = $request->file('image');
        $name_gen = hexdec(uniqid()).".".$book_image->getClientOriginalExtension();
        Image::make($book_image)->resize(600, 600)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['image'] = $last_img;
        $data['active'] = $request->active;

        DB::table('books')->insert($data);
        return Redirect()->back()->with('status', 'New Books Added Successfully');
    }

    public function Edit_Books($id) {
        $books = DB::table('books')->where('id', $id)->first();
        return view('cms.books.edit_books', compact('books'));
    }

    public function Update_Books(Request $request, $id) {
        $old_image = $request->old_image;

        $data = array();

        $book_image = $request->file('image');

        if($book_image){

            $name_gen = hexdec(uniqid()).".".$book_image->getClientOriginalExtension();
            Image::make($book_image)->resize(600, 600)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;

            if ($old_image) {
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }


            $data['image'] = $last_img;
        }

        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['active'] = $request->active;

        DB::table('books')->where('id', $id)->update($data);
        return Redirect()->route('cms.books')->with('status', 'Books Update Successfully');

    }

    public function Delete_Books($id) {
        // Retrieve the teacher record to get the image path
        $book = DB::table('books')->where('id', $id)->first();

        if ($book) {
            // Delete the image file if it exists
            if (file_exists($book->image)) {
                unlink($book->image);
            }

            // Delete the teacher record from the database
            DB::table('books')->where('id', $id)->delete();

            return redirect()->route('cms.books')->with('status', 'Book Deleted Successfully');
        }

        return redirect()->route('cms.books')->with('error', 'Teacher Not Found');
    }
    //End:: Books

    //BEgin:: Books orders
    public function all_orders_books() {
        $orders = DB::table('books_order')->orderBy('id', 'desc')->get();
        return view('cms.orders.books_all_order', compact('orders'));
    }
    public function all_orders_course() {
        $orders = DB::table('courses_order')->orderBy('id', 'desc')->get();
        return view('cms.orders.course_all_order', compact('orders'));
    }

    public function Book_order_details($id) {
        $orders_info = DB::table('books_order')->where('id', $id)->first();
        return view('cms.orders.orderDetails', compact('orders_info'));
    }

    public function Course_order_details($id) {
        $orders_info = DB::table('courses_order')->where('id', $id)->first();
        $gateway = null;
        if ($orders_info && !empty($orders_info->payment_gateway_id)) {
            $gateway = \App\Models\PaymentGateway::find($orders_info->payment_gateway_id);
        }
        return view('cms.orders.courseorderDetails', compact('orders_info', 'gateway'));
    }

    public function Update_admin_order_status(Request $request) {
        // dd($request->all());
        $order_status = $request->order_status;
        $invID = $request->invID;

        $data = array();
        $data['status'] = $order_status;
       if ($order_status=="delivered") {
        $data['payment_status'] = 'paid';
       }

        DB::table('books_order')->where('id', $invID)->update($data);
        return Redirect()->back()->with('status', 'Order Status Update Successfully.');
    }
    public function Update_admin_courses_order_status(Request $request) {
        $order_status = $request->order_status;
        $invID = $request->invID;

        $data = array();
        $data['status'] = $order_status;
        if ($order_status == "enrolled" || $order_status == "delivered" || $order_status == "approved") {
            $data['payment_status'] = 'paid';
        } elseif ($order_status == "rejected" || $order_status == "canceled") {
            $data['payment_status'] = 'rejected';
        } elseif ($order_status == "pending") {
            $data['payment_status'] = 'pending';
        }

        if ($request->filled('admin_note')) {
            $data['admin_note'] = $request->admin_note;
        }

        DB::table('courses_order')->where('id', $invID)->update($data);
        return Redirect()->back()->with('status', 'Course enrollment payment status updated successfully.');
    }

    //End:: Books orders

    // Learning English Setting
    public function Set_learning_english(Request $request) {

        $book_image = $request->file('image');
        $name_gen = hexdec(uniqid()).".".$book_image->getClientOriginalExtension();
        Image::make($book_image)->resize(600, 370)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['image'] = $last_img;
        $data['text'] = $request->editor1;

        DB::table('learning_english_setting')->insert($data);
        return Redirect()->back()->with('status', 'Learning English Set Successfully');
    }

    public function Edit_larning_english_setting($id) {
        $info = DB::table('learning_english_setting')->where('id', $id)->first();
        return view('cms.setting.edit_learning_setting', compact('info'));
    }

    public function Update_learning_english(Request $request, $id) {
        $old_image = $request->old_image;

        $data = array();

        $image = $request->file('image');

        if($image){
            $name_gen = hexdec(uniqid()).".".$image->getClientOriginalExtension();
            Image::make($image)->resize(600, 370)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;

            if($old_image){
                unlink($old_image);
            }
            $data['image'] = $last_img;
        }

        $data['text'] = $request->editor1;

        DB::table('learning_english_setting')->where('id', $id)->update($data);
        return Redirect()->route('cms.learning_english')->with('status', 'Learning English Update Successfully');
    }


    //Begin:: User Password Reset
    public function UserPassResetCheckEmail(Request $request) {
        $randomId       =   random_int(1000, 9999);

        $result = DB::table('admins')->where(['email'=>$request->email])->first();
        if($result){
     $uid=$result->id;
     $email=$result->email;

       $user=admin::find($result->id);
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
            return view('cms.auth.otp_code',compact('uid','email'));

        }

    }else {
        return redirect()->back()->with('notAllow', 'Sorry Invalid Email!');
    }

    }


        //Begin:: otp verify Password Reset
        public function otpverify (Request $request) {

            $uid=$request->uid;
             $user=admin::find($request->uid);
              $getotp=$user->otp;

              if(( $getotp == $request->otp)) {

                  return view('cms.auth.password_reset',compact('uid'));

              }
              else {
                  $request->session()->flash('pass', 'otp invalid');


                  return redirect('/admin/password-reset');
              }

          }
          //End:: otp verify Password Reset

       //Begin::  Password Reset
       public function passreset (Request $request) {

        $uid=$request->uid;
         $user=admin::find($request->uid);
          $getotp=$user->otp;

          if((  $request->password== $request->password_confirmation)) {

              $user=admin::find($request->uid);
              $user->password=Hash::make($request->password);
              $user->save();

             return redirect('/cms');

          }
          else {
              $request->session()->flash('pass', 'please enter same password');


              return back();
          }

      }
      //End::  Password Reset
      public function form_submit_list() {
        $Orders = DB::table('contact_us')->get();
        return view('cms.pages.all_data_form', compact('Orders'));
    }



    public function deleteStudent($id) {
        // Retrieve the teacher record to get the image path
        $user = DB::table('users')-> where('id', $id) ->first();

        if ($user) {
            // Delete the image file if it exists
            if (file_exists($user->image)) {
                unlink($user->image);
            }

            // Delete the teacher record from the database
            DB::table('users')->where('id', $id)->delete();

            return redirect()->route('cms.students.all')->with('status', 'User Deleted Successfully');
        }

        return redirect()->route('cms.students.all')->with('error', 'User Not Found');
    }

}
