<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Image ;
use App\Models\Course;
use App\Models\CourseModule;

class ExamCon extends Controller
{
    // Exam index page
    public function indexParment(){
        $exams = DB::table('exams')
        ->join('categories', 'exams.catID', 'categories.id')
        ->select('exams.*', 'categories.*', 'exams.id as exam_id', 'exams.active as exam_active')
        ->where('exams.type', 'permanent')
        ->orderBy('exams.id', 'DESC')
        ->get();
        return view('cms.exam.permanent_exam', compact('exams'));
    }

    public function indexTemporary(){
        $exams = DB::table('exams')
        ->join('categories', 'exams.catID', 'categories.id')
        ->select('exams.*', 'categories.*', 'exams.id as exam_id', 'exams.active as exam_active')
        ->where('exams.type', 'temporary')
        ->orderBy('exams.id', 'DESC')
        ->get();
        return view('cms.exam.temporary_exam', compact('exams'));
    }

    //Begin:: cms add exam page
    public function Add_exams() {
        $categories = DB::table('categories')->get();
        return view('cms.exam.add_exam', compact('categories'));
    }
    //End:: cms add exam page

    // Add Exam Confirm Function
    public function Add_exams_Confirm(Request $request){

        $request->validate([
            'exam_name' => 'required|unique:exams',
        ]);

        $data = array();
        $data['catID'] = $request->catID;
        $data['exam_name'] = $request->exam_name;
        $data['mcq_written'] = $request->mcq_written;
        $data['free_paid'] = 'null';
        $data['tk'] = 0;
        $data['type'] = $request->type;
        $data['startDate'] = $request->startDate;
        $data['examTime'] = $request->examTime;
        $data['active'] = $request->active;
        $data['written_paragraph'] = $request->editor1;
        $data['created_at'] = Carbon::now();

        DB::table('exams')->insert($data);
        if($request->type != 'temporary') {
            return Redirect()->route('cms.permanent_exams')->with('status', 'New Exam Added Successfully');
        }
        else {
            return Redirect()->route('cms.temporary_exams')->with('status', 'New Exam Added Successfully');
        }


    }

    // Edit Exam Function
    public function EditExam($id){
        $categories = DB::table('categories')->get();
        $exam = DB::table('exams')-> where('id', $id) ->first();
        return view('cms.exam.edit_exam', compact('exam', 'categories'));
    }
    // Edit result Function
    public function allresult($id){

        $exam_info = DB::table('exams')->where('id', $id)->first();

       if($exam_info->mcq_written == 'mcq') {
           $mcqExams = DB::table('mcq_results')
                   ->select('userID', DB::raw("SUM(obtained_mark) as total"))
                   ->groupBy('userID')
                   ->where('examID', $id)
                   ->orderBy('total', 'DESC')
                   ->get();
       }
       else if($exam_info->mcq_written == 'written') {
           $mcqExams = DB::table('written_results')
                   ->select('userID', DB::raw("SUM(rightansMark) as total"))
                   ->groupBy('userID')
                   ->where('examID', $id)
                   ->orderBy('total', 'DESC')
                   ->get();
       }

        return view('cms.exam.mcq_result_view', compact('mcqExams', 'exam_info'));
    }

    //Begin::Update Exam Function
    public function UpdateExams(Request $request, $id){

        $data = array();
        $data['catID'] = $request->catID;
        $data['exam_name'] = $request->exam_name;
        $data['mcq_written'] = $request->mcq_written;
        $data['free_paid'] = 'null';
        $data['tk'] = 0;
        $data['type'] = $request->type;
        $data['startDate'] = $request->startDate;
        $data['examTime'] = $request->examTime;
        $data['active'] = $request->active;
        $data['written_paragraph'] = $request->editor1;
        $data['created_at'] = Carbon::now();

        DB::table('exams')->where('id', $id)->update($data);
        if($request->type != 'temporary') {
            return Redirect()->route('cms.permanent_exams')->with('status', 'Exam Update Successfully');
        }
        else {
            return Redirect()->route('cms.temporary_exams')->with('status', 'Exam Update Successfully');
        }
    }

    public function DeleteExams($id) {
        // dd($id);
        // Retrieve the teacher record to get the image path
        DB::table('exams')->where('id', $id)->first();

        DB::table('exams')->where('id', $id)->delete();
        

        return redirect()->back()->with('status', 'Exam Deleted Successfully');
    }
    //End::Update Exam Function


    //Begin::Exam MCQ questions page
    public function Exam_MCQ_Questions_Page($id){
        $exam = DB::table('exams')->where('id', $id)->first();
        $mcqQuestions = DB::table('mcq_questions')->where('examID', $id)->get();
        return view('cms.exam.mcq_questions', compact('exam', 'mcqQuestions'));
    }
    public function Exam_written_Questions_Page_edit($id){

        $WrittenQuestions = DB::table('written_questions')->find($id);
         $exam = DB::table('exams')->where('id', $WrittenQuestions->examID)->first();
        return view('cms.exam.wrritten_questions_edit', compact('exam', 'WrittenQuestions'));
    }
    public function Exam_MCQ_Questions_Page_edit($id){

        $mcqQuestions = DB::table('mcq_questions')->find($id);
         $exam = DB::table('exams')->where('id', $mcqQuestions->examID)->first();
        return view('cms.exam.mcq_questions_edit', compact('exam', 'mcqQuestions'));
    }
    public function addd_MCQ_Questions_Page ($id){
       $exam = DB::table('exams')->where('id', $id)->first();
        $mcqQuestions = DB::table('mcq_questions')->where('examID', $id)->get();
        return view('cms.exam.add_mcq_questions', compact('exam', 'mcqQuestions'));
    }
    //End::Exam MCQ questions page

    //Begin::Add MCQ questions Confirm
    public function Add_MCQ_Questions(Request $request){

        if(!empty($request->QID)) {
            $count = count($request->QID);
            $data = array();

            for($i = 0; $i < $count; $i++) {
                if($request->QID[$i] == 0){ // New Questions

                    $data['examID'] = $request->examID;
                    $data['questions'] = $request->questions[$i];
                    $data['optn1'] = $request->optn1[$i];
                    $data['optn2'] = $request->optn2[$i];
                    $data['optn3'] = $request->optn3[$i];
                    $data['optn4'] = $request->optn4[$i];
                    $data['optn5'] = $request->optn5[$i];
                    $data['rightAns'] = $request->rightAns[$i];
                    $data['mark'] = $request->mark[$i];
                    $data['negativeMark'] = $request->negativeMark[$i];
                    $data['writeAnsDes'] = $request->writeAnsDes[$i];
                    $data['created_at'] = Carbon::now();

                    DB::table('mcq_questions')->insert($data);

                }
                else {
                    $data['questions'] = $request->questions[$i];
                    $data['optn1'] = $request->optn1[$i];
                    $data['optn2'] = $request->optn2[$i];
                    $data['optn3'] = $request->optn3[$i];
                    $data['optn4'] = $request->optn4[$i];
                    $data['optn5'] = $request->optn5[$i];
                    $data['rightAns'] = $request->rightAns[$i];
                    $data['mark'] = $request->mark[$i];
                    $data['negativeMark'] = $request->negativeMark[$i];
                    $data['writeAnsDes'] = $request->writeAnsDes[$i];
                    $data['updated_at'] = Carbon::now();
                    DB::table('mcq_questions')-> where('id', $request->QID[$i])->update($data);
                }
            }

            return back()->with('status', 'MCQ Questions Update Successfully');


        }
        else {
            return Redirect()->back();
        }
    }
    //End::Add MCQ questions Confirm

    //Begin::Exam Written questions page
    public function Exam_Written_Questions_Page($id){
        $exam = DB::table('exams')->where('id', $id)->first();
        $WrittenQuestions = DB::table('written_questions')->where('examID', $id)->get();
        return view('cms.exam.written_questions', compact('exam', 'WrittenQuestions'));
    }
    public function add_written_Questions_Page($id){
        $exam = DB::table('exams')->where('id', $id)->first();
        $WrittenQuestions = DB::table('written_questions')->where('examID', $id)->get();
        return view('cms.exam.add_written_questions', compact('exam', 'WrittenQuestions'));
    }
    //End::Exam Written questions page

    //Begin::Add Written questions Confirm
    public function Add_Written_Questions(Request $request){

        if(!empty($request->QID)) {
            $count = count($request->QID);
            $data = array();

            for($i = 0; $i < $count; $i++) {
                if($request->QID[$i] == 0){ // New Questions

                    $data['examID'] = $request->examID;
                    $data['questions'] = $request->questions[$i];
                    $data['mark'] = $request->mark[$i];
                    $data['ans'] = $request->ans[$i];
                    $data['created_at'] = Carbon::now();
                    DB::table('written_questions')->insert($data);

                }
                else {
                    $data['examID'] = $request->examID;
                    $data['questions'] = $request->questions[$i];
                    $data['mark'] = $request->mark[$i];
                    $data['ans'] = $request->ans[$i];
                    $data['updated_at'] = Carbon::now();
                    DB::table('written_questions')-> where('id', $request->QID[$i])->update($data);
                }
            }
            return Redirect()->back()->with('status', 'Written Questions Update Successfully');
        }
        else {
            return Redirect()->back();
        }
    }
    //End::Add Written questions Confirm

    // Begin:: MCQ CSV Confirm
    public function MCQ_questions_CSV_Confirm(Request $request) {
        $filename= $request->csvFile;
        $file = fopen($filename, "r");
        $i = 1;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

            if(!empty($getData[0])) {
                $examCheck = DB::table('exams')->where('id', $getData[0])->first();
                $existQcheck = DB::table('mcq_questions')->where('questions', $getData[1])->where('examID', $getData[0])->first();
                if(!empty($examCheck->id) && ($examCheck->mcq_written == 'mcq') && empty($existQcheck->id) && !empty($getData[1]) && !empty($getData[2]) && !empty($getData[3]) && !empty($getData[4]) && !empty($getData[7])) {
                    if($getData[8] == ''){
                        $mark = 1;
                    }
                    else {
                        $mark = $getData[8];
                    }

                    if($getData[9] == ''){
                        $Negativemark = '-1';
                    }
                    else {
                        $Negativemark = $getData[9];
                    }

                    $data = array();

                    $data['examID'] = $examCheck->id;
                    $data['questions'] = $getData[1];
                    $data['optn1'] = $getData[2];
                    $data['optn2'] = $getData[3];
                    $data['optn3'] = $getData[4];
                    $data['optn4'] = $getData[5];
                    $data['optn5'] = $getData[6];
                    $data['rightAns'] = $getData[7];
                    $data['mark'] = $mark;
                    $data['negativeMark'] = $Negativemark;
                    $data['writeAnsDes'] = $getData[10];
                    $data['created_at'] = Carbon::now();

                    DB::table('mcq_questions')->insert($data);
                    $i++;
                }

            }

        $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
        }
        fclose($file);

        if($i > 1){
            return Redirect()->route('/cms')->with('status', 'MCQ Questions Upload Successfully.');
        }
        else {
            return Redirect()->back()->with('adminError', 'No MCQ Questions Uploaded!');
        }

    }
    // End:: MCQ CSV Confirm

    // Begin:: Written CSV Confirm
    public function Written_questions_CSV_Confirm(Request $request) {
        $filename= $request->csvFile;
        $file = fopen($filename, "r");
        $i = 1;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

            if(!empty($getData[0])) {
                $examCheck = DB::table('exams')->where('id', $getData[0])->first();
                $existQcheck = DB::table('written_questions')->where('questions', $getData[1])->where('examID', $getData[0])->first();
                if(!empty($examCheck->id) && ($examCheck->mcq_written == 'written') && empty($existQcheck->id) && !empty($getData[1]) && !empty($getData[2]) && !empty($getData[3])) {

                    $data = array();
                    $data['examID'] = $examCheck->id;
                    $data['questions'] = $getData[1];
                    $data['mark'] = $getData[2];
                    $data['ans'] = $getData[3];
                    $data['created_at'] = Carbon::now();

                    DB::table('written_questions')->insert($data);
                    $i++;
                }

            }

        $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
        }
        fclose($file);

        if($i > 1){
            return Redirect()->route('/cms')->with('status', 'Written Questions Upload Successfully.');
        }
        else {
            return Redirect()->back()->with('adminError', 'No Written Questions Uploaded!');
        }

    }
    // End:: Written CSV Confirm


    // Begin:: Student MCQ Reports page
    public function student_mcq_result_page() {
        $mcqExams = DB::table('results')
                    ->join('exams', 'results.examID', 'exams.id')
                    ->select('results.*', 'exams.exam_name')
                    ->where('results.mcq_written', 'mcq')
                    ->orderBy('results.id', 'desc')
                    ->latest()->get();
        return view('cms.exam.mcq_result', compact('mcqExams'));

    }

    public function delete_mcq_result_page($id) {
        // Retrieve the teacher record to get the image path
        DB::table('results')-> where('id', $id)->first();
        DB::table('results')-> where('id', $id)->delete();

        return redirect()->back()->with('status', 'Blog Deleted Successfully');
    }
    // End:: Student MCQ Reports page

    // Begin:: Student Written Reports page
    public function student_written_result_page() {
        $writtenExams = DB::table('results')
                    ->join('exams', 'results.examID', 'exams.id')
                    ->select('results.*', 'exams.exam_name')
                    ->where('results.mcq_written', 'written')
                    ->orderBy('results.id', 'desc')
                    ->latest()->get();
        return view('cms.exam.written_result', compact('writtenExams'));

    }
    // End:: Student Written Reports page

    // Begin:: Student Written Exam review page
    public function review_written_exam_cms($id) {
        $writtenExam = DB::table('results')
                    ->join('exams', 'results.examID', 'exams.id')
                    ->select('results.*', 'exams.exam_name')
                    ->where('results.id', $id)
                    ->first();
        return view('cms.exam.review_written_exam', compact('writtenExam'));

    }
    // End:: Student Written Exam review page

    // Begin:: Set written exam mark
    public function set_written_exam_mark() {
        $qid = $_GET['qid'];
        $userID = $_GET['userID'];
        $mark = $_GET['mark'];

        $data = array();
        $data['rightansMark'] = $mark;
        $data['updated_at'] = Carbon::now();

        DB::table('written_results')->where('id', $qid)->where('userID', $userID)->update($data);

        $sts = [
            'status' => 'yes',
        ];
        return response()->json($sts);
    }
    // End:: Set written exam mark

    // Begin:: Set written exam Review Status
    public function SET_written_exam_review_status() {
        $status = $_GET['status'];
        $userID = $_GET['userID'];
        $examID = $_GET['examID'];

        $data = array();
        $data['written_status'] = $status;
        $data['updated_at'] = Carbon::now();

        DB::table('results')->where('examID', $examID)->where('userID', $userID)->update($data);

        $sts = [
            'status' => 'yes',
        ];
        return response()->json($sts);
    }
    // End:: Set written exam Review Status

    // Begin:: Set written exam Note
    public function SET_written_exam_note() {
        $note = $_GET['note'];
        $qid = $_GET['qid'];
        $userID = $_GET['userID'];


        $data = array();
        $data['note'] = $note;
        $data['updated_at'] = Carbon::now();

        DB::table('written_results')->where('id', $qid)->where('userID', $userID)->update($data);

        $sts = [
            'status' => 'yes',
        ];
        return response()->json($sts);
    }
    // End:: Set written exam Note



    // Begin:: Sum written exam Result
    public function Sum_written_exam() {
        $userID = $_GET['userID'];
        $examID = $_GET['examID'];


        $totalSum = DB::table('written_results')->where('examID', $examID)->where('userID', $userID)->sum('rightansMark');

        $sts = [
            'status' => 'yes',
            'totalSum' => $totalSum,
        ];
        return response()->json($sts);
    }
     // End:: Sum written exam Result


    public function add_course () {
        $categories = DB::table('course_categories')->get();
       return view('cms.course.create',compact('categories'));
    }
    public function course_list() {

        $courses=Course::all();

       return view('cms.course.list',compact('courses'));
    }
    public function Add_course_Confirm(Request $request) {


        $course=new Course;
        $course->catID=$request->catID;
        $course->name=$request->name;
        $course->price=$request->price;
         $course->description=$request->description;
        $course->active=1;
        $about_image = $request->file('image');

        $name_gen = hexdec(uniqid()).".".$about_image->getClientOriginalExtension();
        Image::make($about_image)->resize(800, 630)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;
          $course->image=$last_img;
          $course->save();
        CourseModule::newModule($request->titles, $request->links, $request->free_paid, $course->id);

       return redirect('/cms/course/list')->with('status', 'New Course Added Successfully');
    }
    public function update_course_Confirm(Request $request, $id)
{
    $course = Course::find($id);
    $course->catID = $request->catID;
    $course->name = $request->name;
    $course->price = $request->price;
    $course->description = $request->description;
    $course->rank = $request->rank;
    $course->active = 1;
    $about_image = $request->file('image');

    if ($about_image) {
        if (!empty($course->image) && file_exists($course->image)) {
            unlink($course->image);
        }
        $name_gen = hexdec(uniqid()) . "." . $about_image->getClientOriginalExtension();
        Image::make($about_image)->resize(800, 630)->save('images/' . $name_gen);
        $course->image = 'images/' . $name_gen;
    }

    $course->save();

    // Handle Course Modules
    $existingModules = CourseModule::where('course_id', $course->id)->get();
    $submittedTitles = $request->titles;
    $submittedLinks = $request->links;
    $submittedFreePaid = $request->free_paid;

    // foreach ($existingModules as $module) {
    //     if (!in_array($module->title, $submittedTitles)) {
    //         $module->delete(); // Delete module if it's not in the submitted data
    //     }
    // }

    foreach ($submittedTitles as $index => $title) {
        // Check if the module already exists
        $module = CourseModule::where('course_id', $course->id)
                              ->where('title', $title)
                              ->first();

        if ($module) {
            // Update existing module
            $module->link = $submittedLinks[$index];
            $module->free_paid = $submittedFreePaid[$index];
            $module->save();
        } else {
            // Create new module
            CourseModule::create([
                'course_id' => $course->id,
                'title' => $title,
                'link' => $submittedLinks[$index],
                'free_paid' => $submittedFreePaid[$index],
            ]);
        }
    }

    return redirect()->back()->with('status', 'Course Updated Successfully');
}

    public function deactivecourse($id) {

        $course=Course::find($id);
        $course->active=0;
          $course->save();
       return back()->with('status', 'Deactive Successfully');;
    }
    public function activecourse($id) {

        $course=Course::find($id);
        $course->active=1;
          $course->save();
       return back()->with('status', 'Active Successfully');;
    }

    public function editcourse($id) {

        $course=Course::find($id);
        $categories = DB::table('course_categories')->get();
        $modules = CourseModule::where('course_id',$id)->get();

       return view('cms.course.edit',compact('course','categories','modules'));
    }

    public function deleteCourse($id) {
        // Retrieve the teacher record to get the image path
        $course=Course::find($id);

        if ($course) {
            // Delete the image file if it exists
            if (file_exists($course->image)) {
                unlink($course->image);
            }

            // Delete the teacher record from the database
            $course->delete();

            return redirect()->route('cms.course.list')->with('status', 'Course Deleted Successfully');
        }

        return redirect()->route('cms.course.list')->with('error', 'Course Not Found');
    }

    public function editCourseModule(Request $request)
    {
        $module = CourseModule::find($request->id);
        if ($module) {
            $module->title = $request->title;
            $module->link = $request->link;
            $module->free_paid = $request->free_paid;
            $module->save();

            return response()->json(['status' => 'Module updated successfully']);
        }
        return response()->json(['status' => 'Module not found'], 404);
    }

    public function deleteCourseModule(Request $request)
    {
        $module = CourseModule::find($request->id);
        if ($module) {
            $module->delete();
            return response()->json(['status' => 'Module deleted successfully']);
        }
        return response()->json(['status' => 'Module not found'], 404);
    }



}
