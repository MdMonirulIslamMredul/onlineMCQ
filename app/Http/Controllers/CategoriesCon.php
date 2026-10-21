<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class CategoriesCon extends Controller
{
    // Category index page
    public function index(){
        $categories = DB::table('categories')->orderBy('id', 'desc')->get();
        return view('cms.categories.all_category', compact('categories'));
    }

    // Add Category Function
    public function addCategory(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:categories',
            'url' => 'required|unique:categories',
            'rank' => 'required',
            'image' => 'required',

        ]);


        $cat_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
        Image::make($cat_image)->resize(400, 400)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;


        $data = array();
        $data['name'] = $request->name;
        $data['free_paid'] = $request->free_paid;
        $data['tk'] = $request->tk;
        $data['url'] = $request->url;
        $data['rank'] = $request->rank;
        $data['image'] = $last_img;
        $data['active'] = 1;
        $data['created_at'] = date("Y-m-d");

        DB::table('categories')->insert($data);


        return Redirect()->back()->with('status', 'Category Added Successfully');

    }

    // Deactive Category Function
    public function deactiveCategory($id){

        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = date("Y-m-d");
        DB::table('categories')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Category Deactive Successfully');

    }

    // Active Category Function
    public function ActiveCategory($id){

        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = date("Y-m-d");
        DB::table('categories')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Category Active Successfully');

    }

    // Edit Category Function
    public function EditCategory($id){
        $category = DB::table('categories')-> where('id', $id) ->first();
        return view('cms.categories.edit_category', compact('category'));
    }

    // Update Category Function
    public function UpdateCategory(Request $request, $id){

        $old_image = $request->old_image;

        // $brand_image = $request->file('brand_image');
        $cat_image = $request->file('image');

        if($cat_image){

            $name_gen = hexdec(uniqid()).".".$cat_image->getClientOriginalExtension();
            Image::make($cat_image)->resize(400, 400)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;


            if($old_image){
                unlink($old_image);
            }
            $data = array();
            $data['name'] = $request->name;
            $data['free_paid'] = $request->free_paid;
            $data['tk'] = $request->tk;
            $data['image'] = $last_img;
            $data['rank'] = $request->rank;
            $data['updated_at'] = Carbon::now();

            DB::table('categories')-> where('id', $id) ->update($data);
            return Redirect() -> route('all_cat')->with('status', 'Category Update Successfully');
        }
        else {
            $data = array();
            $data['name'] = $request->name;
            $data['free_paid'] = $request->free_paid;
            $data['tk'] = $request->tk;
            $data['url'] = $request->url;
            $data['rank'] = $request->rank;
            $data['updated_at'] = Carbon::now();
            DB::table('categories')-> where('id', $id) ->update($data);
            return Redirect() -> route('all_cat')->with('status', 'Category Update Successfully');
        }
    }

    public function deleteCategory($id) {
        // Retrieve the teacher record to get the image path
        $category = DB::table('categories')-> where('id', $id) ->first();

        if ($category) {
            // Delete the image file if it exists
            if (file_exists($category->image)) {
                unlink($category->image);
            }

            // Delete the teacher record from the database
            DB::table('categories')->where('id', $id)->delete();

            return redirect()->route('all_cat')->with('status', 'Category Deleted Successfully');
        }

        return redirect()->route('all_cat')->with('error', 'Category Not Found');
    }
}
