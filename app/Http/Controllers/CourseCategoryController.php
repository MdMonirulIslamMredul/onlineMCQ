<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CourseCategoryController extends Controller
{
    // Category index page
    public function course_all(){
        $categories = DB::table('course_categories')->orderBy('id', 'desc')->get();
        return view('cms.course_category.all_category', compact('categories'));
    }

    // Add Category Function
    public function addCourseCategory(Request $request){
    // dd($request->all());
        $request->validate([
            'name' => 'required|unique:categories',
            // 'url' => 'required|unique:categories',
            'image' => 'required',

        ]);
        // dd($request);

        $cat_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
        Image::make($cat_image)->resize(400, 400)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;


        $data = array();
        $data['name'] = $request->name;
        // $data['free_paid'] = $request->free_paid;
        // $data['tk'] = $request->tk;
        $data['url'] = $request->url;
        $data['image'] = $last_img;
        $data['rank'] = $request->rank;
        $data['active'] = 1;
        $data['created_at'] = date("Y-m-d");

        DB::table('course_categories')->insert($data);


        return Redirect()->back()->with('status', 'Category Added Successfully');

    }

    // Deactive Category Function
    public function deactiveCourseCategory($id){

        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = date("Y-m-d");
        DB::table('course_categories')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Category Deactive Successfully');

    }

    // Active Category Function
    public function ActiveCategoryCourse($id){

        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = date("Y-m-d");
        DB::table('course_categories')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Category Active Successfully');

    }

    // Edit Category Function
    public function EditCourseCategory($id){
        $category = DB::table('course_categories')-> where('id', $id) ->first();
        return view('cms.course_category.edit_category', compact('category'));
    }

    // Update Category Function
    public function UpdateCourseCategory(Request $request, $id){
        // dd($request->all());
        $old_image = $request->old_image;

        // $brand_image = $request->file('brand_image');
        $cat_image = $request->file('image');

        if($cat_image){

            $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
            Image::make($cat_image)->resize(400, 400)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;


            if($old_image){
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            $data = array();
            $data['name'] = $request->name;
            // $data['free_paid'] = $request->free_paid;
            // $data['tk'] = $request->tk;
            $data['image'] = $last_img;
            $data['rank'] = $request->rank;
            $data['updated_at'] = Carbon::now();

            DB::table('course_categories')-> where('id', $id) ->update($data);
            return Redirect() -> route('all_course_cat')->with('status', 'Category Update Successfully');
        }
        else {
            $data = array();
            $data['name'] = $request->name;
            // $data['free_paid'] = $request->free_paid;
            // $data['tk'] = $request->tk;
            $data['url'] = $request->url;
            $data['rank'] = $request->rank;
            $data['updated_at'] = Carbon::now();
            DB::table('course_categories')-> where('id', $id) ->update($data);
            return Redirect() -> route('all_course_cat')->with('status', 'Category Update Successfully');
        }
    }

    public function deleteCourseCategory($id) {
        // Retrieve the teacher record to get the image path
        $category = DB::table('course_categories')-> where('id', $id) ->first();

        if ($category) {
            // Delete the image file if it exists
            if (file_exists($category->image)) {
                unlink($category->image);
            }

            // Delete the teacher record from the database
            DB::table('course_categories')->where('id', $id)->delete();

            return redirect()->route('all_course_cat')->with('status', 'Category Deleted Successfully');
        }

        return redirect()->route('all_course_cat')->with('error', 'Category Not Found');
    }
}
