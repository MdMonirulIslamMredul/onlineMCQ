<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Image;

class TeachersCon extends Controller
{
    // Teachers index page
    public function index(){
        $teachers = DB::table('teachers')->get();
        return view('cms.teachers.all_teachers', compact('teachers'));
    }

    // Add Teachers Function
    public function Add_teachers(Request $request){
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            
        ]);

        $Teachers_image = $request->file('image');
        $name_gen = hexdec(uniqid()).".".$Teachers_image->getClientOriginalExtension();
        Image::make($Teachers_image)->resize(400, 400)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['name'] = $request->name;
        $data['subject'] = $request->subject;
        $data['job_title'] = $request->job_title;
        $data['image'] = $last_img;
        $data['active'] = $request->active;
        $data['created_at'] = Carbon::now();

        DB::table('teachers')->insert($data);
        return Redirect()->back()->with('status', 'New Teachers Added Successfully');

    }

    // Edit Teachers Function
    public function EditTeacher($id){
        $teacher = DB::table('teachers')-> where('id', $id) ->first();
        return view('cms.teachers.edit_teacher', compact('teacher'));
    }

    // Update Teachers Function
    public function UpdateTeachers(Request $request, $id){

        $old_image = $request->old_image;
        $teachers_image = $request->file('image');
        $data = array();

        if($teachers_image){
            $name_gen = hexdec(uniqid()).".".$teachers_image->getClientOriginalExtension();
            Image::make($teachers_image)->resize(400, 400)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;
            if($old_image){
                unlink($old_image);
            }
            $data['image'] = $last_img;
        }

        $data['name'] = $request->name;
        $data['subject'] = $request->subject;
        $data['job_title'] = $request->job_title;
        $data['active'] = $request->active;

        DB::table('teachers')-> where('id', $id) ->update($data);
        return Redirect() -> route('cms.teachers')->with('status', 'Teacher Info Update Successfully');

    }

    // User All Teachers Function
    public function UserTeachers(){
        $teachers = DB::table('teachers')->where('active', 1)->get();
        return view('user.pages.teachers.all_teachers', compact('teachers'));
    }

    // Add this method to your TeachersCon controller
    public function DeleteTeacher($id) {
        // Retrieve the teacher record to get the image path
        $teacher = DB::table('teachers')->where('id', $id)->first();

        if ($teacher) {
            // Delete the image file if it exists
            if (file_exists($teacher->image)) {
                unlink($teacher->image);
            }

            // Delete the teacher record from the database
            DB::table('teachers')->where('id', $id)->delete();

            return redirect()->route('cms.teachers')->with('status', 'Teacher Deleted Successfully');
        }

        return redirect()->route('cms.teachers')->with('error', 'Teacher Not Found');
    }

}

