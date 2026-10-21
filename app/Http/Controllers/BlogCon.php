<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Image;

class BlogCon extends Controller
{
    // Blog index page
    public function indexBangla(){
        $blogs = DB::table('blogs')->where('language', 'bangla')->orderBy('id', 'DESC')->get();
        return view('cms.blog.bangla_blog', compact('blogs'));
    }

    public function indexEnglish(){
        $blogs = DB::table('blogs')->where('language', 'english')->orderBy('id', 'DESC')->get();
        return view('cms.blog.english_blog', compact('blogs'));
    }


    // Add Blog Function
    public function Add_new_blog(Request $request){

        $request->validate([
            'title' => 'required|unique:blogs',
            'url' => 'required|unique:blogs',
            'image' => 'required',
        ]);

        $blog_image = $request->file('image');
        $name_gen = hexdec(uniqid()).".".$blog_image->getClientOriginalExtension();
        Image::make($blog_image)->resize(740, 490)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;


        $data = array();
        $data['language'] = $request->language;
        $data['title'] = $request->title;
        $data['url'] = $request->url;
        $data['image'] = $last_img;
        $data['alt'] = $request->alt;
        $data['description'] = $request->editor1;
        $data['meta_title'] = $request->meta_title;
        $data['meta_description'] = $request->editor2;
        $data['author'] = $request->author;
        $data['date'] = $request->date;
        $data['created_at'] = Carbon::now();

        DB::table('blogs')->insert($data);
        if($request->language == 'english') {
            return Redirect()->route('cms.englishBlog')->with('status', 'New Blog Added Successfully');
        }
        else {
            return Redirect()->route('cms.banglaBlog')->with('status', 'New Blog Added Successfully');
        }


    }


    // Edit Blog Function
    public function EditBlog($id){
        $blog = DB::table('blogs')-> where('id', $id) ->first();
        return view('cms.blog.edit_blog', compact('blog'));
    }

    // Update Blog Function
    public function Update_Blog(Request $request, $id){

        $old_image = $request->old_image;
        $data = array();

        $blog_image = $request->file('image');

        if($blog_image){
            $name_gen = hexdec(uniqid()).".".$blog_image->getClientOriginalExtension();
            Image::make($blog_image)->resize(740, 490)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;

            if ($old_image && file_exists($old_image)) {
                unlink($old_image);
            }
            $data['image'] = $last_img;
        }

        $data['language'] = $request->language;
        $data['title'] = $request->title;
        $data['url'] = $request->url;
        $data['alt'] = $request->alt;
        $data['description'] = $request->editor1;
        $data['meta_title'] = $request->meta_title;
        $data['meta_description'] = $request->editor2;
        $data['author'] = $request->author;
        $data['date'] = $request->date;
        $data['created_at'] = Carbon::now();

        DB::table('blogs')->where('id', $id)->update($data);

        if($request->language == 'english') {
            return Redirect()->route('cms.englishBlog')->with('status', 'Blog Update Successfully');
        }
        else {
            return Redirect()->route('cms.banglaBlog')->with('status', 'Blog Update Successfully');
        }
    }

    public function Delete_Blog($id) {
        // Retrieve the teacher record to get the image path
        $blog = DB::table('blogs')-> where('id', $id)->first();

        if ($blog) {
            // Delete the image file if it exists
            if (file_exists($blog->image)) {
                unlink($blog->image);
            }

            // Delete the teacher record from the database
            DB::table('blogs')-> where('id', $id)->delete();

            return redirect()->back()->with('status', 'Blog Deleted Successfully');
        }

        return redirect()->back()->with('error', 'Teacher Not Found');
    }
    // Begin:: USer Blog
    public function UserBlogIndex() {
        $blogs = DB::table('blogs')->orderBy('id', 'DESC')->paginate(5);
        return view('user.pages.blog.all_blog', compact('blogs'));
    }
    // End:: USer Blog

    // Begin:: USer Blog
    public function UserBlogIndexBangla() {
        $blogs = DB::table('blogs')->where('language', 'bangla')->orderBy('id', 'DESC')->limit(6)->get();
        return view('user.pages.blog.bangla_blog', compact('blogs'));
    }
    // End:: USer Blog

    // Begin:: USer English Blog
    public function UserBlogIndexEnglish() {
        $blogs = DB::table('blogs')->where('language', 'english')->orderBy('id', 'DESC')->limit(6)->get();
        return view('user.pages.blog.english_blog', compact('blogs'));
    }
    // End:: USer English Blog





    // Begin:: USer Blog Load More button
    public function BlogLoad_more_ajax() {
        $lastID = $_GET['lastID'];
        $languige = $_GET['lang'];

        $updatedlastID = 0;
        $output = '';

        $blogs = DB::table('blogs')
                    ->where('id', '<', $lastID)
                    ->where('language', $languige)
                    ->orderBy('id', 'desc')
                    ->limit(6)
                    ->get();

        if(!$blogs->isEmpty()) {
            $noMorePSts = 'yes';

            foreach($blogs as $blog) {
                $output .= '<div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="articles_grid_style">
                                <div class="articles_grid_thumb">
                                    <a href="/blog/'.$blog->id.'/'.$blog->url.'"><img src="'.asset($blog->image).'"
                                            class="img-fluid" alt="'.$blog->alt.'"></a>
                                </div>
                                <div class="articles_grid_caption">
                                    <a href="/blog/'.$blog->id.'/'.$blog->url.'">
                                        <h4>'.$blog->title.'</h4>
                                    </a>
                                    <div class="articles_grid_author">
                                        <h4><span class="theme-cl text-bold">Author: </span> '.$blog->author.', <span
                                                class="theme-cl text-bold">Date:</span> '.date('d M, Y', strtotime($blog->date)).'
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        $updatedlastID = $blog->id;
                        }
                    }
                    else {
                        $noMorePSts = 'no';
                        $output .= '<div class="col-md-12" id="load_more">
                                        <div style="text-align: center;" class="text-center"><h2><b>Sorry, No Data Found</b></h2></div>
                                    </div>';
                    }

                    $res = [
                        'output' => $output,
                        'upLastID' => $updatedlastID,
                        'noMorePSts' => $noMorePSts,
                    ];
                    return response()->json($res);

    }
    // End:: USer Blog Load More button

    //Begin:: User Blog Details
    public function UserBlogDetails($id) {
        $blog = DB::table('blogs')->where('id', $id)->first();
        return view('user.pages.blog.blog_details', compact('blog'));
    }
    //Begin:: User Blog Details
}
