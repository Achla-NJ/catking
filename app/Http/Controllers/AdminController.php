<?php

namespace App\Http\Controllers;

use App\Http\Resources\DataTableCollectionResource;
use App\Models\College;
use App\Models\Exam;
use App\Models\ExportUser;
use App\Models\ExportSop;
use App\Models\Setting;
use App\Models\State;
use App\Models\StudentConvertedCallCollege;
use App\Models\StudentDreamCollege;
use App\Models\StudentExam;
use App\Models\StudentReceivedCallCollege;
use App\Models\StudentSopColleges;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class AdminController extends Controller
{
    public function getColleges(Request $request)
    {
        $colleges = College::query()->where('created_by_user', 'no');
        if($created_by_user = $request->input('created_by_user')){
            $colleges = $colleges->where('created_by_user', $created_by_user);
        }
        return response()->json($colleges->get());
    }

    public function getStates()
    {
        return response()->json(State::all());
    }

    public function getExams()
    {
        return response()->json(Exam::all());
    }

    public function getUsersTableData(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column', 'id') ?: 'id';
        $orderByDir = $request->input('dir', 'desc');
        $filters = $request->input('filters');
        $is_default_load = $request->input('is_default_load', false);

        $columns = [
            ["key" => "id", "label" => "ID", "sortable" => true, "stickyColumn" => true, "variant" => 'primary' ],
            ["key" => "name", "label" => "Name", "sortable" => true,"stickyColumn" => true ,"variant" => 'info'],
            ["key" => "email", "label" => "Email", "sortable" => true],
            ["key" => "mobile_number", "label" => "Phone", "sortable" => true ],
        ];

        $data = User::query()
            ->with([
                'dream_colleges',
                'received_call_colleges',
                'converted_call_colleges',
                'sop_colleges',
            ])
            ->select('u.*')
            ->from('users', 'u')
            ->where('u.role','student');

        $name = @$filters['name'];
        if($name){
            $data = $data->where(function ($query) use ($name) {
                $query->where("u.name", "LIKE", "%$name%");
                $query->orWhere("u.email", "LIKE", "%$name%");
            });
        }

        $profile_update_from = @$filters['profile_update_from'];
        $profile_update_to = @$filters['profile_update_to'];
        if($profile_update_from && $profile_update_to){
            $data = $data->whereBetween("u.updated_at", [$profile_update_from, $profile_update_to]);
        }

        $dream_colleges = @$filters['dream_colleges']?:[];
        if(count($dream_colleges) > 0){
            $data = $data->leftJoin(StudentDreamCollege::getSchema().' as dc', 'u.id', '=', 'dc.user_id')
                ->whereIn('dc.college_id', $dream_colleges);
        }

        $received_call_colleges = @$filters['received_call_colleges']?:[];
        if(count($received_call_colleges) > 0){
            $data = $data->leftJoin(StudentReceivedCallCollege::getSchema().' as rcc', 'u.id', '=', 'rcc.user_id')
                ->whereIn('rcc.college_id', $received_call_colleges)
            ;
        }

        $converted_call_colleges = @$filters['converted_call_colleges']?:[];
        if(count($converted_call_colleges) > 0){
            $data = $data->leftJoin(StudentConvertedCallCollege::getSchema().' as ccc', 'u.id', '=', 'ccc.user_id')
                ->whereIn('ccc.college_id', $converted_call_colleges)
            ;
        }

        $sop_college_id = @$filters['sop_college'];
        $sop_college = College::query()->find($sop_college_id ?? 17);
        if($sop_college_id){
            $data = $data
                ->leftJoin(StudentSopColleges::getSchema().' as sc', 'u.id', '=', 'sc.user_id')
                ->where('sc.college_id', $sop_college_id);

            $sop_reviewed = @$filters['sop_reviewed']?:'both';

            if($sop_reviewed=='yes'){
                $data = $data->where('sc.college_id', $sop_college_id)->where('review','!=','');
            }elseif($sop_reviewed=='no'){
                $data = $data->where('sc.college_id', $sop_college_id)->where('review','');
            }
        }
        /*else{
            $sop_reviewed = @$filters['sop_reviewed']?:'both';
            if($sop_reviewed=='yes'){
                $data = $data
                ->leftJoin(StudentSopColleges::getSchema().' as sc', 'u.id', '=', 'sc.user_id')
                ->where('sc.review','!=','');
            }elseif($sop_reviewed=='no'){
                $data = $data->leftJoin(StudentSopColleges::getSchema().' as sc', 'u.id', '=', 'sc.user_id')
                ->where('sc.review','');
            }
        } */

        $states = @$filters['states'] ?? [];
        if(count($states) > 0){
            $data = $data->whereIn("u.state", $states);
        }

        $is_catking_student = @$filters['is_catking_student']?:'both';
        if($filters['is_catking_student'] == 'yes'){
            $data = $data->whereIn("u.is_catking_student",['yes','mocks','gdpi']);
            
        }else{
            if(in_array($is_catking_student, ['yes', 'no'])){
                $data = $data->where("u.is_catking_student", $is_catking_student);
            }
        }
        

        $exams = @$filters['exams']?:[];

        if($is_default_load || empty($exams)){
            $columns[] = ["key" => "exams_score.cat", "label" => "CAT Score", "sortable" => false ];
            $columns[] = ["key" => "exams_score.nmat", "label" => "NMAT Score", "sortable" => false ];
        }
        $u_exams = [];
        foreach ($exams as $exam) {
            $e_name = @$exam['name'];
            $score_from = @$exam['score_from'];
            $score_to = @$exam['score_to'];
            $percentile_from = @$exam['percentile_from'];
            $percentile_to = @$exam['percentile_to'];

            if($e_name && !in_array($e_name, $u_exams)) {
                $as = strtolower($e_name);
                $columns[] = ["key" => "exams_score.{$as}", "label" => "$e_name Score", "sortable" => true ];
                if($percentile_from > 0 || $percentile_to > 0){
                    $columns[] = ["key" => "exams_percentile.{$as}", "label" => "$e_name Percentile", "sortable" => true ];
                }
                $u_exams[] = $e_name;
                $tb2 = "eum".rand(222,9999);
                $data = $data
                    ->join(StudentExam::getSchema()." as $tb2", "u.id", "=", "$tb2.user_id")
                    ->selectRaw("$tb2.score + 0.0 as {$as}_score")
                    ->selectRaw("$tb2.percentile + 0.0 as {$as}_percentile")
                    ->where("$tb2.type", "=", $as)
                ;

                if($score_from){
                    $data = $data->whereRaw("$tb2.score >= $score_from");
                }
                if($score_to){
                    $data = $data->whereRaw("$tb2.score < $score_to");
                }
                if($percentile_from){
                    $data = $data->whereRaw("$tb2.percentile > $percentile_from");
                }
                if($percentile_to){
                    $data = $data->whereRaw("$tb2.percentile < $percentile_to");
                }
            }
        }

        $data = $data->groupBy('u.id');

        /**
         * Implementing columns (START)
         */

        $columns[] = ["key" => "dream_colleges", "label" => "Dream Colleges", "sortable" => false ];
        $columns[] = ["key" => "received_call_colleges", "label" => "Received Calls Colleges", "sortable" => false ];
        $columns[] = ["key" => "converted_call_college", "label" => "Converted Calls Colleges", "sortable" => false ];

        $columns[] = ["key" => "sop_college", "label" => "SOP ($sop_college->name)", "sortable" => false ];

        $columns[] = ["key" => "action", "label" => "Action" ];

        $orderByColumns = User::getSchemaColumns();
        if(in_array($orderBy, $orderByColumns)){
            $orderBy = "u.$orderBy";
        }

//        $data->dd();


        $data = $data->orderBy($orderBy, $orderByDir)->paginate($length, 'u.*');

        return new DataTableCollectionResource($data, $columns);
    }

    public function broadcastMessage(Request $request)
    {
        $broadcast = Setting::val(['broadcast_message_title', 'broadcast_message_description']);
        $title = @$broadcast->broadcast_message_title;
        $description = @$broadcast->broadcast_message_description;

        return view('admin.broadcast-message',compact('title', 'description'));
    }

    public function updateBroadcastMessage(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Setting::val('broadcast_message_title', $data['title']);
        Setting::val('broadcast_message_description', $data['description']);

        return redirect()
            ->route("admin.broadcast-message")
            ->with("success", __("app.success"));
    }

    public function generateUsersExportFile(Request $request)
    {
        $data = $request->validate([
            'options' => 'required'
        ]);

        ExportUser::query()->create([
            'options' => json_encode($data['options']),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => __('app.export_preparing')
        ]);
    }

    public function getUsersExportTableData(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column', 'id') ?: 'id';
        $orderByDir = $request->input('dir', 'desc');
        $data = ExportUser::query()
            ->select('id', 'file', 'status', 'created_at')
            ->orderBy($orderBy, $orderByDir)
            ->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function deleteUsersExportFile(Request $request, $id)
    {
        $export = ExportUser::query()->where('id', $id)->get();
        if($export){
            $export->first()->delete();
        }

        return response()->json([
            "success" => true,
            "message" => __("app.export_file_deleted"),
        ]);
    }

    public function downloadUsersExportFile($file_name)
    {
        return response()->file(storage_path('app/'.ExportUser::FILES_PATH.DIRECTORY_SEPARATOR.$file_name));
    }

    public function downloadUsersSopExportFile($file_name)
    {
        return response()->file(storage_path('app/'.ExportSop::FILES_PATH.DIRECTORY_SEPARATOR.$file_name));
    }

    public function generateUsersSopExportFile(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);

        $date = explode("-",$request->date);
        $from_date = date('Y-m-d',strtotime($date[0]));$to_date = date('Y-m-d',strtotime($date[1]));

        $sops = StudentSopColleges::query()
            ->whereBetween('updated_at', [$from_date, $to_date])
            ->whereNotNull('file')
            ->where('file', '!=', '')
            ->get();

        if(count($sops)>0){
            $export_sop = new ExportSop();
            $export_sop->from_date = $from_date;
            $export_sop->to_date=$to_date;
            $export_sop->status = "pending";
            $export_sop->save();

            return response()->json([
                'success' => true,
                'message' => __('app.export_preparing')
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => __('app.export_error')
            ]);
        }
    }

    public function getUsersSopExportTableData(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column', 'id') ?: 'id';
        $orderByDir = $request->input('dir', 'desc');
        $data = ExportSop::query()
            ->select('id', 'file', 'from_date','to_date','status', 'created_at')
            ->orderBy($orderBy, $orderByDir)
            ->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function deleteUsersSopExportFile(Request $request, $id)
    {
        $export = ExportSop::query()->where('id', $id)->get();
        if($export){
            $export->first()->delete();
        }

        return response()->json([
            "success" => true,
            "message" => __("app.export_file_deleted"),
        ]);
    }

    public function getUsersSopData(Request $request){
        return StudentSopColleges::where('id',$request->input('id'))->get();
    }

    public function sopReview(Request $request)
    {
        $data =  $request->modal_data;
        $sop = StudentSopColleges::query()->find($data['id']);
        if($sop && @$sop->user){
            $sop->review_by = $data['review_by'];
            $sop->review_date = $data['review_date'];
            $sop->review = $data['review'];
            $status = $sop->save();
            /*
            Temp: disabled
            \Mail::to($sop->user->email)->send(new \App\Mail\Mail([
                'title' => 'Sop Review',
                'body' => 'College Sop has been reviewed.',
            ]));
            */

            return response()->json([
                "success" => true,
                "message" => __("app.success"),
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => __("app.record_error"),
        ]);
    }


    public function sopMail(Request $request){
        $sop = StudentSopColleges::query()->find($request->id);
        $college = College::query()->find($sop->college_id);

        if($sop && @$sop->user){
            $details = [
                'email' =>$sop->user->email,
                'college' => $college->name,
                'type'=>'sop'
            ];
            $subject="CATKing $college->name SOP Review is Done. Check your Feedback on MyCATKing";

            \Mail::to($sop->user->email)->send(new \App\Mail\Mail($details,$subject));
            return response()->json([
                "success" => true,
                "message" => __("app.mail"),
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => __("app.record_error"),
        ]);
    }

    public function userExport(){
        if(Auth::user()->role == 'admin'){
            return view('admin.export');
        }
        else{
            abort(401, 'Unauthorized');
        }
    }

    public function sopExport(){
        if(Auth::user()->role == 'admin'){
            return view('admin.sopexport');
        }
        else{
            abort(401, 'Unauthorized');
        }
    }
}
