<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Image;

class TestimonialController extends Controller
{
    public function all_testimonial(){
        $datas = DB::table('testimonials')->orderBy('id', 'desc')->get();
        return view('cms.testimonial.all_testimonial', compact('datas'));
    }

    // Add Category Function
    public function addTestimonial(Request $request){

        $request->validate([
            'name' => 'required|unique:testimonials',
            // 'url' => 'required|unique:categories',
            'image' => 'required',

        ]);
        // dd($request);

        $cat_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
        Image::make($cat_image)->resize(74, 74)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;


        $data = array();
        $data['name'] = $request->name;
        $data['designation'] = $request->designation;
        $data['description'] = $request->description;
        $data['image'] = $last_img;
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();

        DB::table('testimonials')->insert($data);

        return Redirect()->back()->with('status', 'Added Successfully');

    }

    // Deactive Category Function
    public function deactiveTestimonial($id){

        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = Carbon::now();
        DB::table('testimonials')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Deactive Successfully');

    }

    // Active Category Function
    public function ActiveTestimonial($id){

        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = Carbon::now();
        DB::table('testimonials')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Active Successfully');

    }

    // Edit Category Function
    public function EditTestimonial($id){
        $data = DB::table('testimonials')-> where('id', $id) ->first();
        return view('cms.testimonial.edit_testimonial', compact('data'));
    }

    // Update Category Function
    public function UpdateTestimonial(Request $request, $id){

        $old_image = $request->old_image;

        // $brand_image = $request->file('brand_image');
        $cat_image = $request->file('image');

        if($cat_image){

            $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
            Image::make($cat_image)->resize(64, 64)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;


            if($old_image){
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            $data = array();
            $data['name'] = $request->name;
            $data['designation'] = $request->designation;
            $data['description'] = $request->description;
            $data['image'] = $last_img;
            $data['updated_at'] = Carbon::now();

            DB::table('testimonials')-> where('id', $id) ->update($data);
            return Redirect() -> route('all.testimonial')->with('status', 'Update Successfully');
        }
        else {
            $data = array();
            $data['name'] = $request->name;
            $data['designation'] = $request->designation;
            $data['description'] = $request->description;
            $data['updated_at'] = Carbon::now();
            DB::table('testimonials')-> where('id', $id) ->update($data);
            return Redirect() -> route('all.testimonial')->with('status', 'Update Successfully');
        }
    }
}
