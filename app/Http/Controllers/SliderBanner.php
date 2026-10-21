<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Image;

class SliderBanner extends Controller
{
    // Home banner index page
    public function index(){
        $banners = DB::table('slider_banners')->get();
        return view('cms.slider.all_slider', compact('banners'));
    }

    // Add Home banner Function
    public function AddBanner(Request $request){
        $request->validate([
            'title' => 'required|unique:slider_banners',
            'image' => 'required',

        ]);


        $banner_image = $request->file('image');
        $name_gen = hexdec(uniqid()).".".$banner_image->getClientOriginalExtension();
        Image::make($banner_image)->resize(2260, 600)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['title'] = $request->title;
        $data['alt'] = $request->alt;
        $data['image'] = $last_img;
        $data['active'] = $request->active;
        $data['created_at'] = Carbon::now();

        DB::table('slider_banners')->insert($data);
        return Redirect()->back()->with('status', 'New Home Banner Added Successfully');

    }

    // Edit Home banner Function
    public function EditBanner($id){
        $banner = DB::table('slider_banners')-> where('id', $id) ->first();
        return view('cms.slider.edit_slider', compact('banner'));
    }

    // Update Home banner Function
    public function UpdateBanner(Request $request, $id){

        $old_image = $request->old_image;
        $banne_image = $request->file('image');
        $data = array();

        if($banne_image){
            $name_gen = hexdec(uniqid()).".".$banne_image->getClientOriginalExtension();
            Image::make($banne_image)->resize(2260, 600)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;
            if($old_image){
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            $data['image'] = $last_img;
        }

        $data['title'] = $request->title;
        $data['alt'] = $request->alt;
        $data['active'] = $request->active;
        $data['updated_at'] = Carbon::now();

        DB::table('slider_banners')-> where('id', $id) ->update($data);
        return Redirect() -> route('cms.home_banner')->with('status', 'Home Banner Update Successfully');

    }



    public function slider_info(){
        $infos = DB::table('slider_infos')->orderBy('id', 'desc')->get();
        return view('cms.slider_info.all_info', compact('infos'));
    }


    // Add Category Function
    public function AddInfo(Request $request){

        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();
        DB::table('slider_infos')->insert($data);

        return Redirect()->back()->with('status', 'Info Added Successfully');

    }

    // Deactive Category Function
    public function deactiveInfo($id){

        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = date("Y-m-d");
        DB::table('slider_infos')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Deactive Successfully');

    }

    // Active Category Function
    public function ActiveInfo($id){

        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = date("Y-m-d");
        DB::table('slider_infos')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Active Successfully');

    }

    // Edit Category Function
    public function EditInfo($id){

        $category = DB::table('slider_infos')-> where('id', $id) ->first();
        // dd($category);
        return view('cms.slider_info.edit_info', compact('category'));
    }

    // Update Category Function
    public function UpdateInfo(Request $request, $id){

            $data = array();
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $data['updated_at'] = Carbon::now();
            DB::table('slider_infos')-> where('id', $id) ->update($data);
            return Redirect() -> route('cms.slider_info')->with('status', 'Update Successfully');

    }


    public function slider_img(){
        $data = DB::table('slider_infos')->get();
        $infos = DB::table('slider_images')->orderBy('id', 'desc')->get();
        // dd($infos);
        return view('cms.slider_img.all_img', compact('infos','data'));
    }


    // Add Category Function
    public function AddImg(Request $request){

        $cat_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
        Image::make($cat_image)->resize(860, 600)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;


        $data = array();
        $data['slider_info_id'] = $request->slider_info_id;
        $data['image'] = $last_img;
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();
        DB::table('slider_images')->insert($data);

        return Redirect()->back()->with('status', 'Info Added Successfully');

    }

    // Deactive Category Function
    public function deactiveImg($id){

        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = date("Y-m-d");
        DB::table('slider_images')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Deactive Successfully');

    }

    // Active Category Function
    public function ActiveImg($id){

        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = date("Y-m-d");
        DB::table('slider_images')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Active Successfully');

    }

    // Edit Category Function
    public function EditImg($id){
        $data = DB::table('slider_infos')->get();

        $info = DB::table('slider_images')-> where('id', $id) ->first();
        // dd($category);
        return view('cms.slider_img.edit_img', compact('info','data'));
    }

    // Update Category Function
    public function UpdateImg(Request $request, $id){

        $old_image = $request->old_image;

        // $brand_image = $request->file('brand_image');
        $cat_image = $request->file('image');

        if($cat_image){

            $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
            Image::make($cat_image)->resize(860, 600)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;


            if($old_image){
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
            $data = array();
            $data['slider_info_id'] = $request->slider_info_id;
            $data['image'] = $last_img;
            $data['updated_at'] = Carbon::now();

            DB::table('slider_images')-> where('id', $id) ->update($data);
            return Redirect() -> route('cms.slider_img')->with('status', 'Update Successfully');
        }
        else {
            $data = array();
            $data['slider_info_id'] = $request->slider_info_id;
            $data['updated_at'] = Carbon::now();
            DB::table('slider_images')-> where('id', $id) ->update($data);
            return Redirect() -> route('cms.slider_img')->with('status', 'Update Successfully');
        }
    }

}
