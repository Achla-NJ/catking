<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentEducation;
use App\Models\StudentWork;
use App\Models\StudentDreamCollege;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\College;
use App\Models\UserMeta;
use App\Models\StudentSopColleges;
use App\Models\StudentInterviewDate;
use App\Models\StudentReceivedCallCollege;
use App\Models\StudentConvertedCallCollege;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $user->load(["education", "work", "exams", "sop_colleges","dream_colleges"]);

        $colleges = College::where('created_by_user','no')->where('status','active')->get();

        //education Gap
        $education_gap = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "education_gap")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($education_gap) > 0) {
            $education_gap = $education_gap->groupBy("relation");
        }

        //student education
        $education_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "education")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($education_data) > 0) {
            $education_data = $education_data->groupBy("relation");
        } else {
            $education_data = collect(UserMeta::getEducationStaticFields());
        }

        $education_board_type = UserMeta::EDUCATION_BOARD_TYPES;

        //student work

        $work_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "work")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($work_data) > 0) {
            $work_data = $work_data->groupBy("relation");
        } else {
            $work_data = collect(UserMeta::getWorkStaticFields());
        }

        //student curricular
        $curricular_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "curricular")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($curricular_data) > 0) {
            $new_cdata = [];
            foreach ($curricular_data as $cur) {
                $new_cdata[$cur->relation][] = $cur;
            }
            $curricular_data = collect($new_cdata);
        } else {
            $curricular_data = collect(UserMeta::getCurricularStaticFields());
        }

        //dream college data
        $dream_college_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "dream_college")
            ->first();
        if ($dream_college_data) {
            $dream_college_data = explode(",", $dream_college_data->value);
        } else {
            $dream_college_data = [];
        }

        //student exam
        $exam_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "exam")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($exam_data) > 0) {
            $exam_data = $exam_data->groupBy("relation");
        } else {
            $exam_data = collect(UserMeta::getExamStaticFields());
        }

        //received calls data
        $received_call_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "received_call")
            ->first();

        $received_call_data = $received_call_data ? explode(",", $received_call_data->value) : [];

        //Interview Dates
        $interview_date_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "interview_date")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($interview_date_data) > 0) {
            $interview_date_data = $interview_date_data->groupBy("relation");
        }

        //Converted Calls
        $converted_call_data = UserMeta::query()
            ->where("user_id", Auth::id())
            ->where("group", "converted_call")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($converted_call_data) > 0) {
            $converted_call_data = $converted_call_data->groupBy("relation");
        }

        return view(
            "user.profile.index",
            compact(
                "user",
                "colleges",
                "education_data",
                "education_board_type",
                "work_data",
                "curricular_data",
                "dream_college_data",
                "received_call_data",
                "education_gap",
                "exam_data",
                "interview_date_data",
                "converted_call_data"
            )
        );
    }

    public function account($user_id='')
    {
        if(!empty($user_id)){
            $user = User::query()->where('id',$user_id)->first();
        }else{
            $user = Auth::user();
            $user_id = Auth::id();
        }

        $user->load(["education", "work", "exams", "sop_colleges","dream_colleges"]);

        $colleges = College::where('created_by_user','no')->where('status','active')->get();
        //education Gap

        $education_gap = UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "education_gap")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($education_gap) > 0) {
            $education_gap = $education_gap->groupBy("relation");
        }

        //student education
        $education_data = UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "education")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($education_data) > 0) {
            $education_data = $education_data->groupBy("relation");
        } else {
            $education_data = collect(UserMeta::getEducationStaticFields());
        }

        $education_board_type = UserMeta::EDUCATION_BOARD_TYPES;

        //student work

        $work_data = UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "work")
            ->orderBy("sort", "ASC")
            ->get();
        if (count($work_data) > 0) {
            $work_data = $work_data->groupBy("relation");
        } else {
            $work_data = collect(UserMeta::getWorkStaticFields());
        }

        //student curricular
        $curricular_data = UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "curricular")
            ->orderBy("sort", "ASC")
            ->get();

        if (count($curricular_data) > 0) {
            $new_cdata = [];
            foreach ($curricular_data as $cur) {
                $new_cdata[$cur->relation][] = $cur;
            }
            $curricular_data = collect($new_cdata);
        } else {
            $curricular_data = collect(UserMeta::getCurricularStaticFields());
        }

        //dream college data
        $dream_college_data = UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "dream_college")
            ->first();
        if ($dream_college_data) {
            $dream_college_data = explode(",", $dream_college_data->value);
        } else {
            $dream_college_data = [];
        }

        $user->load('education');
        if(count($user->education) == 0){
            $educations = [];
            foreach (StudentEducation::getSchemaColumns() as $value) {
                $educations[$value] = "";
            }

            $educations1 = $educations2 = $educations3 = $educations;

            $educations1['class_type'] = 'matric';
            $educations2['class_type'] = 'secondary';
            $educations3['class_type'] = 'graduation';

            $user->education = json_decode(json_encode([
                $educations1,
                $educations2,
                $educations3,
            ]));
        }

        return view(
            "user.profile.account",
            compact(
                "user",
                "colleges",
                "education_data",
                "education_board_type",
                "work_data",
                "curricular_data",
                "dream_college_data",
                "education_gap",
                "user_id"
            )
        );
    }

    public function updateProfile(Request $request)
    {
        if ($request->file("avatar")) {
            $validatedData = $request->validate([
                "avatar" => "required|image|mimes:jpg,png,jpeg",
            ]);

            if ($validatedData) {
                // $filename = time().'_'.$file->getClientOriginalName();
                $upload = $request->file("avatar")->store(User::FILES_PATH);
                auth()
                    ->user()
                    ->update([
                        "avatar" => ltrim(
                            str_replace(User::FILES_PATH, "", $upload),
                            "/"
                        ),
                    ]);
            }
        }
        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function userFiles($file_name)
    {
        $file = storage_path("app".DIRECTORY_SEPARATOR.User::FILES_PATH.DIRECTORY_SEPARATOR.$file_name);
        if(!file_exists($file)) {
            abort(404, __("app.file_not_exists"));
        }
        return response()->file($file);
    }

    public function updatePersonalInfo(Request $request)
    {
        if(!empty($request->user_id)){
            $user = User::query()->where('id',$request->user_id)->first();
        }else{
            $user = Auth::user();
        }
        $user->name = $request->input("name");
        $user->mobile_number = $request->input("mobile_number");
        $user->whatsapp_number = $request->input("whatsapp_number");
        $user->is_catking_student = $request->input("is_catking_student");
        $user->dob = $request->input("dob");
        $user->address = $request->input("address");
        $user->city = $request->input("city");
        $user->state = $request->input("state");
        $user->update();
        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function updateEducation(Request $request)
    {
        if(!empty($request->user_id)){
            $user = User::query()->where('id', $request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        StudentEducation::query()->where('user_id', $user->id)->delete();

        foreach($request->input('educations') as $data){
            $board_name = !@$data['board_type'] || @$data['board_type'] == "other"? @$data['board_name']: @UserMeta::EDUCATION_BOARD_TYPES[@$data['class_type']][@$data['board_type']];
            $edu = new StudentEducation;
            $edu->user_id = $user->id;
            $edu->class_name = @$data['class_name'];
            $edu->class_type = @$data['class_type'] ?: "other";
            $edu->board_type = @$data['board_type'] ?: "other";
            $edu->board_name = $board_name;
            $edu->start_date = @$data['start_date'];
            $edu->end_date = @$data['end_date'];
            $edu->marks = @$data['marks'];
            $edu->school = @$data['school'];
            $edu->cgpa = @$data['cgpa'];
            $edu->passing_year = @$data['passing_year'];
            $edu->month = $request->input('month');
            $edu->gap = $request->input('gap');
            $edu->summary =  @$data['summary'];
            $edu->save();
        }

        return response()->json(["success" => true, "message" => __("app.success") ]);
    }

    public function updateWorkExperience(Request $request)
    {
        if(!empty($request->user_id)){
            $user = User::query()->where('id', $request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        StudentWork::query()->where('user_id', $user->id)->delete();
        foreach($request->input('works') as $data){
            $work = new StudentWork;
            $work->user_id = $user->id;
            $work->work_type = @$data['work_type'];
            $work->company_name = @$data['company_name'];
            $work->role = @$data['role'];
            $work->responsibilities = @$data['responsibilities'];
            $work->join_date = @$data['join_date'];
            $work->leave_date = @$data['leave_date'];
            $work->working_presently = @$data['working_presently'];
            $work->save();
        }
        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function updateCurricular(Request $request)
    {
        if(!empty($request->user_id)){
            $user_id = $request->user_id;
        }else{
            $user_id = Auth::id();
        }

        UserMeta::query()
            ->where("user_id", $user_id)
            ->where("group", "curricular")
            ->delete();

        $index = 1;
        foreach ($request->input("curricular") as $relation => $data) {
            foreach ($data as $value) {
                UserMeta::query()->create([
                    "user_id" => $user_id,
                    "key" => "curricular",
                    "value" => $value,
                    "relation" => $relation,
                    "sort" => $index,
                    "group" => "curricular",
                ]);
            }
            $index++;
        }
        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function updateDreamCollege(Request $request)
    {
        if(!empty($request->user_id)){
            $user = User::query()->where('id', $request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        StudentDreamCollege::query()->where('user_id', $user->id)->delete();

        foreach($request->input('dream_colleges') as $college){
            if(!is_numeric($college)){
                $chk_college = College::where("name",$college)->get();
                if(count($chk_college)>0){
                    $college_id = $chk_college[0]->id;
                }
                else{
                    $new_college = new College;
                    $new_college->name = $college;
                    $new_college->created_by_user = 'yes';
                    $new_college->save();
                    $college_id=$new_college->id;
                }
            }else{
                $college_id=$college;
            }
            $dream = new StudentDreamCollege;
            $dream->user_id = $user->id;
            $dream->college_id =  @$college_id;
            $dream->save();
        }

        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function Sops($user_id='')
    {
        if(!empty($user_id)){
            $user = User::query()->where('id',$user_id)->first();
        }else{
            $user = Auth::user();
            $user_id = Auth::id();
        }

        $user->load([
            "sop_colleges",
        ]);

        return view("user.profile.sops", compact("user",'user_id'));
    }

    public function sop(Request $request)
    {
        $filename = "";
        if ($request->hasFile("files")) {
            $validatedData = $request->validate([
                "files" => "required|mimes:pdf,doc,docx",
            ]);

            if ($validatedData) {
                $upload = $request->file("files")->store(User::FILES_PATH);
                $filename = ltrim(
                    str_replace(User::FILES_PATH, "", $upload),
                    "/"
                );
            }
        }
        return response()->json(["success" => true, "message" => $filename,"url"=>route('user-files', $filename)]);
    }

    public function updateSop(Request $request)
    {
        $request->validate(
            ["sop.*.*" => "required"],
            ['sop.*.*.required' => 'File Field is required']
        );

        if(!empty($request->user_id)){
            $user = User::query()->where('id', $request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        StudentSopColleges::query()
            ->where("user_id", $user->id)
            ->delete();

        foreach($request->input('sop') as $data){
            $sop = new StudentSopColleges;
            $sop->user_id = $user->id;
            $sop->college_id =   @$data['college'];
            $sop->file =   @$data['sop_file'];
            $sop->save();
        }

        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function call(Request $request)
    {
        $filename = "";
        if ($request->hasFile("files")) {
            $validatedData = $request->validate([
                "files" => "required|mimes:pdf,doc,docx",
            ]);

            if ($validatedData) {
                $upload = $request->file("files")->store(User::FILES_PATH);
                $filename = ltrim(
                    str_replace(User::FILES_PATH, "", $upload),
                    "/"
                );
            }
        }
        return response()->json(["success" => true, "message" => $filename,"url"=>route('user-files', $filename)]);
    }
    public function ReceivedCall($user_id='')
    {
        if(!empty($user_id)){
            $user = User::query()->where('id',$user_id)->first();
        }else{
            $user = Auth::user();
            $user_id = Auth::id();
        }
        $colleges = College::where('created_by_user','no')->where('status','active')->get();

        $user->load([
            "interview_dates",
            "converted_call_colleges",
            "received_call_colleges"
        ]);

        return view(
            "user.profile.receivedcall",
            compact(
                "user",
                "colleges",
                "user_id"
            )
        );
    }

    public function updateAllCall(Request $request)
    {

        if(!empty($request->user_id)){
            $user = User::query()->where('id', $request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        StudentReceivedCallCollege::query()->where('user_id', $user->id)->delete();
        StudentInterviewDate::query()->where('user_id', $user->id)->delete();
        StudentConvertedCallCollege::query()->where('user_id', $user->id)->delete();

        if(!empty($request->input('received_call'))){
            foreach($request->input('received_call') as $college){
                if(!is_numeric($college)){
                    $chk_college = College::where("name",$college)->get();
                    if(count($chk_college)>0){
                        $college_id = $chk_college[0]->id;
                    }
                    else{
                        $new_college = new College;
                        $new_college->name = $college;
                        $new_college->created_by_user = 'yes';
                        $new_college->save();
                        $college_id=$new_college->id;
                    }
                }else{
                    $college_id=$college;
                }

                $dream = new StudentReceivedCallCollege;
                $dream->user_id = $user->id;
                $dream->college_id =  @$college_id;
                $dream->save();
            }
        }

        if(!empty($request->input('interview'))){
            $request->validate(
                ["interview.*.*" => "required"],
                ['interview.*.*.required' => 'Interview date is required']
            );

            foreach($request->input('interview') as $data){
                $interview = new StudentInterviewDate;
                $interview->user_id = $user->id;
                $interview->college_id =   @$data['college'];
                $interview->date =   @$data['interview_date'];
                $interview->save();
            }
        }

        if(!empty($request->input('converted_call'))){
            $request->validate(
                ["converted_call.*.call_file" => "required"],
                ['converted_call.*.call_file.required' => 'converted call file is required']
            );
            foreach($request->input('converted_call') as $data){
                $converted_call = new StudentConvertedCallCollege;
                $converted_call->user_id = $user->id;
                $converted_call->college_id =   @$data['college'];
                $converted_call->file =   @$data['call_file'];
                $converted_call->save();
            }
        }

        return response()->json([
            "success" => true,
            "message" => __("app.success"),
        ]);
    }

    public function addEducation(Request $request)
    {
        $data = $request->input("education");
        $relation = $request->input("education_relation");
        return view("components.education", [
            "data" => $data,
            "relation" => $relation,
        ]);
    }

    public function addWork(Request $request)
    {
        $relation = $request->input("work_relation");
        return view("components.studentwork", ["relation" => $relation]);
    }

    public function updateExam(Request $request)
    {
        if(!empty($request->user_id)){
            $user = User::query()->where('id',$request->user_id)->first();
        }else{
            $user = Auth::user();
        }

        $user_id = $user->id;

        StudentExam::query()->where('user_id',$user_id)->delete();

        foreach($request->input('exam') ?? [] as $data){
            $ex = Exam::query()->where('slug', $data['exam_type'])->limit(1)->get()->first();
            /* if(!$ex){
                continue;
            } */
            $exam_type = @$ex->slug?: 'other';
            $exam = new StudentExam;
            $exam->user_id = $user_id;
            $exam->type = $exam_type;
            $exam->name = @$data['name'] ?: @$ex->name;
            $exam->took_exam = $exam_type == 'other'? 'yes': @$data['took_exam'];
            $exam->score = @$data['score'];
            $exam->percentile = @$data['percentile'];
            $exam->score_card_file = @$data['score_card'];
            $exam->save();
        }
        return response()->json(["success" => true, "message" => __("app.success") ]);
    }

    public function addDreamCollege(Request $request)
    {
        $college_id = $request->input("college_id");

        foreach($college_id as $key=> $clg){
            if(!is_numeric($clg)){
                $chk_college = College::where("name",$clg)->get();
                if(count($chk_college)>0){
                    $college_id[$key] = $chk_college[0]->id;
                }
                else{
                    $new_college = new College;
                    $new_college->name = $clg;
                    $new_college->created_by_user = 'yes';
                    $new_college->save();
                    $college_id[$key] =$new_college->id;
                }
            }
        }


        $relation = $request->input("dream_college_relation");
        $college = College::query()->get(["id", "name"]);
        return view("components.dreamcollege", [
            "college" => $college,
            "college_id" => $college_id,
            "relation" => $relation,
        ]);
    }

    public function addCall(Request $request)
    {
        $college_id = $request->input("college_id");

        foreach($college_id as $key=> $clg){
            if(!is_numeric($clg)){
                $chk_college = College::where("name",$clg)->get();
                if(count($chk_college)>0){
                    $college_id[$key]= $chk_college[0]->id;

                }
                else{
                    $new_college = new College;
                    $new_college->name = $clg;
                    $new_college->created_by_user = 'yes';
                    $new_college->save();
                    $college_id[$key] =$new_college->id;
                }
            }
        }
        $relation = $request->input("converted_call_relation");
        $college = College::query()->get(["id", "name"]);
        return view("components.call", [
            "college" => $college,
            "college_id" => $college_id,
            "relation" => $relation,
        ]);
    }

    public function addCurricular(Request $request)
    {
        $relation = $request->input("rel");
        return view("components.co_curricular", ["relation" => $relation]);
    }


    public function addCollege(Request $request)
    {
        $college = $request->input("college");

        foreach($college as $key => $clg){
            if(!is_numeric($clg)){
                $chk_college = College::where("name",$clg)->get();
                if(count($chk_college)>0){
                    $college[$key] = $chk_college[0]->id;
                }
                else{
                    $new_college = new College;
                    $new_college->name = $clg;
                    $new_college->created_by_user = 'yes';
                    $new_college->save();
                    $college[$key] =$new_college->id;
                }
            }
        }


        $relation = $request->input("sop_relation");
        return view("components.college", [
            "college" => $college,
            "relation" => $relation,
        ]);
    }

    public function addExam(Request $request)
    {
        $exam = $request->input("exam");
        $relation = $request->input("exam_relation");
        return view("components.exam", [
            "exam" => $exam,
            "relation" => $relation,
        ]);
    }

    public function addOtherInput(Request $request)
    {
        $relation = $request->input("relation");
        return view("components.otherinput", ["relation" => $relation]);
    }

    public function Exams($user_id='')
    {
        if(!empty($user_id)){
            $user = User::query()->where('id',$user_id)->first();
        }else{
            $user = Auth::user();
            $user_id = Auth::id();
        }

        $user->load([
//            "education",
            "work",
//            "exams",
            "sop_colleges",
            "interview_dates",
            "converted_call_colleges",
        ]);

        return view("user.profile.exam", compact("user",'user_id'));
    }

    public function scoreCard(Request $request)
    {
        $filename = "";
        if ($request->hasFile("files")) {
            $validatedData = $request->validate([
                "files" => "required|mimes:pdf,doc,docx",
            ]);
            if ($validatedData) {
                $upload = $request->file("files")->store(User::FILES_PATH);
                $filename = ltrim(
                    str_replace(User::FILES_PATH, "", $upload),
                    "/"
                );
            }
        }
        return response()->json(["success" => true, "message" => $filename, "url" => route('user-files', $filename)]);
    }


    public function review()
    {
        $user = Auth::user();
        return view("user.profile.review", compact("user"));
    }

    public function watpi()
    {
        $user = Auth::user();
        return view("user.watpi", compact("user"));
    }

    public function changePassword(){
        return view('user.profile.change-password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password'=>'required'
        ]);
        if($request->confirm_password == $request->new_password){

                $email = Auth::user()->email;
                $user = User::query()->where('email',$email)->first();

                if(Hash::check($request->old_password,Auth::user()->password)){
                    $user->password = Hash::make($request->new_password);
                    $update = $user->update();
                    if($update){
                        $msg ='Password Update Successfully';
                        $request->session()->flash('success-msg',$msg);
                        return redirect()->route('profile.change-password');
                    }
                }
                else{
                    $msg ='Current Password does not match';
                    $request->session()->flash('error-msg',$msg);
                    return redirect()->route('profile.change-password');
                }
            }
            else{
                $msg ='New Password does not match with confirm password';
                $request->session()->flash('error-msg',$msg);
                return redirect()->route('profile.change-password');
            }

        return view('user.profile.change-password');
    }


    public function changeAdminPassword(){
        return view('admin.change-password');
    }

    public function updateAdminPassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password'=>'required'
        ]);
        if($request->confirm_password == $request->new_password){

                $email = Auth::user()->email;
                $user = User::query()->where('email',$email)->first();

                if(Hash::check($request->old_password,Auth::user()->password)){
                    $user->password = Hash::make($request->new_password);
                    $update = $user->update();
                    if($update){
                        $msg ='Password Update Successfully';
                        $request->session()->flash('success-msg',$msg);
                        return redirect()->route('users.change-password');
                    }
                }
                else{
                    $msg ='Old Password doent not match';
                    $request->session()->flash('error-msg',$msg);
                    return redirect()->route('users.change-password');
                }
            }
            else{
                $msg ='password does not match with confirm password';
                $request->session()->flash('error-msg',$msg);
                return redirect()->route('users.change-password');
            }

        return view('user.profile.change-password');
    }


    public function message(){
        $msg = User::query()->where('role','admin')->get(['msg_title','msg_description']);
        return view('admin.message',compact('msg'));
    }

    public function updateMessage(Request $request)
    {
        $data = $request->validate([
            "msg_title" => "required",
            "msg_description" => "required",
        ]);
        $data = User::query()->where('role','admin')->first();
        $data->msg_title = $request->msg_title;
        $data->msg_description = $request->msg_description;
        $status = $data->update();

        if ($status) {
            return redirect()
                ->route("users.message")
                ->with("success", "Page Updated successfully");
        }
        return back();
    }
}
