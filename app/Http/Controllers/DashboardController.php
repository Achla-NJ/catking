<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\College;
use App\Models\Exam;
use App\Models\ExportUser;
use App\Models\ExportSop;
use App\Models\Setting;
use App\Models\State;
use App\Models\StudentConvertedCallCollege;
use App\Models\StudentDreamCollege;
use App\Models\StudentExam;
use App\Models\Review;
use App\Models\StudentInterviewDate;
use App\Models\StudentWork;
use App\Models\StudentReceivedCallCollege;
use App\Models\StudentSopColleges;
use App\Models\StudentEducation;
use DB;
class DashboardController extends Controller
{
    public function cal_percentage($num_amount, $num_total) {
        if($num_amount != 0){
            return round(($num_amount/$num_total)*100,3);
            // return round(abs(($num_amount - $num_total) * 100) / $num_total,2);
        }else{
            return 0;
        }

    }
     
    public function presentStudent(Request $request){
        $date = explode('-',$request->date);
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        return $total_student = User::query()->whereBetween('updated_at', [$from, $to])->where('role','student')->get()->count();
    }

    public function catkingStudent(Request $request){
        $catking=[];
        $date = explode('-',$request->date);
        $state = $request->state;
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        $total_student = User::query()->get()->count();

        if($state !=''){
            $catking['total_catking_student'] = User::query()->whereBetween('updated_at', [$from, $to])->whereIn('is_catking_student',['yes','mocks','gddpi'])->where('state',$state)->get()->count();
            $catking['total_non_catking_student'] = User::query()->whereBetween('updated_at', [$from, $to])->where('is_catking_student','no')->where('state',$state)->get()->count();
        }
        else{
            $catking['total_catking_student'] = User::query()->whereBetween('updated_at', [$from, $to])->whereIn('is_catking_student',['yes','mocks','gddpi'])->get()->count();
            $catking['total_non_catking_student'] = User::query()->whereBetween('updated_at', [$from, $to])->where('is_catking_student','no')->get()->count();
        }
        
        $catking['catking_percent']['catking'] =$this->cal_percentage($catking['total_catking_student'],$total_student);
        $catking['catking_percent']['non_catking'] =$this->cal_percentage($catking['total_non_catking_student'] ,$total_student);
        return $catking;
    }

    public function exam(Request $request){
        $user_exam=[];
        
        $date = explode('-',$request->date);
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        if(!empty($request->exam)){
            $exams = StudentExam::whereIn('type',$request->exam)->get();
            foreach($exams as $exam){
                $exam_name = strtoupper($exam->type);
                $user_exam[$exam_name] = StudentExam::query()->whereBetween('updated_at', [$from, $to])->where('type',$exam_name)->get()->count();
            }
        }else{
            $exams = StudentExam::all();

            foreach($exams as $exam){
                $exam_name = strtoupper($exam->type);
                $user_exam[$exam->type] = StudentExam::query()->whereBetween('updated_at', [$from, $to])->where('type',$exam_name)->get()->count();
            }
        }
        return response()->json([
            "success" => true,
            "result" => $user_exam,
        ]);
    }
    public function score2(Request $request){
        $score=[];
        $date = explode('-',$request->date);
        $rexam = $request->exam;
        $fifty=$sixty=$seventy=$eighty=$ninty=$hund=0;
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        
        $exams = StudentExam::query()->whereBetween('updated_at', [$from, $to])->where('type',$rexam)->where('score','!=','')->get();

        foreach($exams ?? [] as $exam){
            $score[$exam->type]['below 60'] = ($exam->score <60) ? $fifty++ : $fifty;
            $score[$exam->type]['60-70'] = ($exam->score >=60 && $exam->score <70) ? $sixty++ : $sixty;
            $score[$exam->type]['70-80'] = ($exam->score >=70 && $exam->score <80) ? $seventy++ : $seventy;
            $score[$exam->type]['80-90'] = ($exam->score >=80 && $exam->score <90) ? $eighty++ : $eighty;
            $score[$exam->type]['90-100'] = ($exam->score >=90 && $exam->score <100) ? $ninty++ : $ninty;
           
        }
        if(count($score)== 0){
            $score[$rexam]['below 60'] = 0;
            $score[$rexam]['60-70'] = 0;
            $score[$rexam]['70-80'] = 0;
            $score[$rexam]['80-90'] = 0;
            $score[$rexam]['90-100'] = 0;
        }
        
        return response()->json([
            "success" => true,
            "result" => $score,
        ]);
    }
    public function call(Request $request){
        $call=[];
        $date = explode('-',$request->date);
        
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));
        $college = $request->college;
        
        if(!empty($college)){
            $colleges = College::where('created_by_user','no')->whereIn('id',$college)->get();

        }else{
            $colleges = College::where('created_by_user','no')->get();
        }
        foreach($colleges as $college){
            $call['college_call_received'][$college->name] = StudentReceivedCallCollege::query()->whereBetween('updated_at', [$from, $to])->where('college_id',$college->id)->get()->count();
            $call['college_call_converted'][$college->name] = StudentConvertedCallCollege::query()->whereBetween('updated_at', [$from, $to])->where('college_id',$college->id)->get()->count();
            $call['dream_college'][$college->name] = StudentDreamCollege::query()->whereBetween('updated_at', [$from, $to])->where('college_id',$college->id)->get()->count();
        }
        $call['received'] = StudentReceivedCallCollege::query()->whereBetween('updated_at', [$from, $to])->get()->count();
        $call['converted'] = StudentConvertedCallCollege::query()->whereBetween('updated_at', [$from, $to])->get()->count();
        $call['dream'] = StudentDreamCollege::query()->whereBetween('updated_at', [$from, $to])->get()->count();


        
        
        return response()->json([
            "success" => true,
            "result" => $call,
        ]);       

    }

    public function work(Request $request){ 
        $total_student = User::query()->get()->count();

        $user_work=[];
        $date = explode('-',$request->date);
        $work = $request->work;
        $work_name = str_replace('_',' ',$work);
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        $user_work['part_time'] = StudentWork::query()->whereBetween('updated_at', [$from, $to])->where('work_type','part_time')->get()->count();
        $user_work['full_time'] = StudentWork::query()->whereBetween('updated_at', [$from, $to])->where('work_type','full_time')->get()->count();
        $user_work['internship'] = StudentWork::query()->whereBetween('updated_at', [$from, $to])->where('work_type','internship')->get()->count();
        $user_work['percent']['part_time'] =$this->cal_percentage($user_work['part_time'],$total_student);
        $user_work['percent']['full_time'] =$this->cal_percentage($user_work['full_time'],$total_student);
        $user_work['percent']['internship'] =$this->cal_percentage($user_work['internship'],$total_student);
        
        return response()->json([
            "success" => true,
            "result" => $user_work,
        ]);
    }

    public function interview(Request $request){
        $date = explode('-',$request->date);
        
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        $total_student = User::query()->get()->count();

        $interview = StudentInterviewDate::query()->whereBetween('updated_at', [$from, $to])->get()->count();

        return response()->json([
            "success" => true,
            "result" => $interview,
        ]);
    }
    public function profileReview(Request $request){
       
        $date = explode('-',$request->date);
        
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        $total_student = User::query()->get()->count();

        $profile_review = Review::query()->whereBetween('updated_at', [$from, $to])->get()->count();

      
        return response()->json([
            "success" => true,
            "result" => $profile_review,
        ]);
    }


    public function sop(Request $request){
        $sop=[];
        $date = explode('-',$request->date);
        
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        $total_student = StudentSopColleges::query()->get()->count();
        
        $college = $request->college;
        
        if(!empty($college)){
            $colleges = College::where('created_by_user','no')->whereIn('id',$college)->get();

        }else{
            $colleges = College::where('created_by_user','no')->get();
        }
        foreach($colleges as $college){
            $sop['college_sop_upload'][$college->name] = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->where('college_id',$college->id)->get()->count();
            $sop['college_sop_reviews'][$college->name] = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->where('college_id',$college->id)->where('review','!=','')->get()->count();
        }
        $sop['upload'] = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->get()->count();
        $sop['review'] = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->where('review','!=','')->get()->count();

        
        return response()->json([
            "success" => true,
            "result" => $sop,
        ]);
    }
    public function score(Request $request){
        $score=[];
        $date = explode('-',$request->date);
        $rexam = $request->exam;
        $type = $request->type;
        $from_score = (int)$request->from;
        $to_score = (int)$request->to;
        $fifty=$sixty=$seventy=$eighty=$ninty=$hund=0;
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));

        
        $exams = StudentExam::query()
                ->whereBetween('updated_at', [$from, $to])
                ->where('type',$rexam)
                ->where($type,'!=','')
                ->whereBetween($type, [$from_score, $to_score])
                ->get()
                ->count();
        $range = $from_score.'-'.$to_score;
        $score[$rexam][$range] = $exams;
        
        
        return response()->json([
            "success" => true,
            "result" => $score,
        ]);
    }

    

    public function studentGrowth(Request $request){
        $total_student = User::query()->get()->count();
        $growth=[];
        $year = $request->date;
    
        for($i=1;$i<=12;$i++){
            if($i==1){
                $last_total[$i]         =       User::whereYear('created_at', '=', $year-1)
                                                ->whereMonth('created_at', '=', 12)
                                                ->get()
                                                ->count();
                $cat_last_total[$i]     =       User::whereYear('created_at', '=', $year-1)
                                                ->whereMonth('created_at', '=', 12)
                                                ->whereIn('is_catking_student',['yes','mocks','gddpi'])
                                                ->get()
                                                ->count();
                $non_cat_last_total[$i] =       User::whereYear('created_at', '=', $year-1)
                                                ->whereMonth('created_at', '=', 12)
                                                ->where('is_catking_student','no')
                                                ->get()
                                                ->count();
            }else{
                $last_total[$i]         =   User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i-1)
                                            ->get()
                                            ->count();
                $cat_last_total[$i]     =   User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i-1)
                                            ->whereIn('is_catking_student',['yes','mocks','gddpi'])
                                            ->get()
                                            ->count();
                $non_cat_last_total[$i] =    User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i-1)
                                            ->where('is_catking_student','no')
                                            ->count();
            }
            $cur_total[$i]              =   User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i)
                                            ->get()
                                            ->count();
            $cat_cur_total[$i]          =   User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i)
                                            ->whereIn('is_catking_student',['yes','mocks','gddpi'])
                                            ->get()
                                            ->count();
            $non_cat_cur_total[$i]      =   User::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $i)
                                            ->where('is_catking_student','no')
                                            ->get()
                                            ->count();
            
            if($last_total[$i] != 0){
                $growth['total'][date("M", mktime(0, 0, 0, $i, 10))]=round(((($cur_total[$i]-$last_total[$i])*100)/$last_total[$i]),2);
            }else{
                $growth['total'][date("M", mktime(0, 0, 0, $i, 10))]=0;
            }

            if($cat_last_total[$i] != 0){
                $growth['catking'][date("M", mktime(0, 0, 0, $i, 10))]=round(((($cat_cur_total[$i]-$cat_last_total[$i])*100)/$cat_last_total[$i]),2);
            }else{
                $growth['catking'][date("M", mktime(0, 0, 0, $i, 10))]=0;
            }

            if($non_cat_last_total[$i] != 0){
                $growth['non_catking'][date("M", mktime(0, 0, 0, $i, 10))]=round(((($non_cat_cur_total[$i]-$non_cat_last_total[$i])*100)/$non_cat_last_total[$i]),2);
            }else{
                $growth['non_catking'][date("M", mktime(0, 0, 0, $i, 10))]=0;
            }

            // $growth['catking'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->where('is_catking_student','yes')
            // ->whereMonth('created_at', '=', $i)
            // ->get()->count();

            // $growth['non_catking'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->where('is_catking_student','no')
            // ->whereMonth('created_at', '=', $i)
            // ->get()->count();

            // $growth['total'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)
            // ->get()->count();
        }
        return response()->json([
            "success" => true,
            "result" => $growth,
        ]);
        
    }

    public function catkingGrowth(Request $request){
        $catking_growth=[];
        $year = $request->date;
        for($i=1;$i<=12;$i++){
            $catking_growth['catking'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->whereIn('is_catking_student',['yes','mocks','gddpi'])
            ->whereMonth('created_at', '=', $i)
            ->get()->count();

            $catking_growth['non_catking'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->where('is_catking_student','no')
            ->whereMonth('created_at', '=', $i)
            ->get()->count();

            $catking_growth['total'][date("M", mktime(0, 0, 0, $i, 10))] = User::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)
            ->get()->count();
        }
        return response()->json([
            "success" => true,
            "result" => $catking_growth,
        ]);
        
    }

    public function profileGrowth(Request $request){
        $profile_growth=[];
        $year = $request->date;
        for($i=1;$i<=12;$i++){
            $profile_growth[date("M", mktime(0, 0, 0, $i, 10))] = Review::where('type','profile')->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $i)
            ->get()->count();
        }
        return response()->json([
            "success" => true,
            "result" => $profile_growth,
        ]);
        
    }

    public function studentDegree(Request $request){ 
        $student_degree=[];
        $date = $request->date;
        $date = explode('-',$request->date);
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));
        $degrees = ['bcom','bca','btech','bba','bsc','other'];
        
        foreach($degrees as $degree){
           $student_degree[strtoupper($degree)]= StudentEducation::whereBetween('updated_at', [$from, $to])->where('board_type',$degree)->get()->count();
        }
        return response()->json([
            "success" => true,
            "result" => $student_degree,
        ]);
        
    }
    public function target(Request $request){
        $target=[];
        $target_no = $request->target_no ?? 100000;
        

        // $target['actual_no'] = User::query()->get()->count();

        // $target['percent']['target'] = $this->cal_percentage($target['actual_no'],$target_no);
        // $target['percent']['target2'] = 0;
        // $target['percent']['target3'] = 100-$target['percent']['target'];
        
        for($i = date('Y'); $i >= 2020; $i--){
            $target['actual'][$i] = User::whereYear('created_at', '=', $i)
            ->get()->count();
            $target['target'][$i]= $target_no;
        }

        return response()->json([
            "success" => true,
            "result" => $target,
        ]);
    }
    public function sopSubmit(Request $request){
        $date = explode('-',$request->date);
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));
        return $total_sop = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->get()->count();
    }

    public function sopReview(Request $request){
        $date = explode('-',$request->date);
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));
        return $total_review = StudentSopColleges::query()->whereBetween('updated_at', [$from, $to])->where('review','!=','')->get()->count();
    }
    public function callGet(Request $request){
        $date = explode('-',$request->date);
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));
        return $total_call_get=  StudentReceivedCallCollege::query()->whereBetween('updated_at', [$from, $to])->get()->count();
    }

    public function sopPerformance(Request $request){
        $sop_perform=[];
   
        $sop_perform['upload'] = StudentSopColleges::query()->count();
        $sop_perform['review'] = StudentSopColleges::query()->where('review','!=','')->get()->count();
        $sop_perform['non_review'] = StudentSopColleges::query()->where('review','')->get()->count();

        
        return response()->json([
            "success" => true,
            "result" => $sop_perform,
        ]);
    }
    public function callPerformance(Request $request){
        $call_perform=[];
   
        $call_perform['dream'] = StudentDreamCollege::query()->count();
        $call_perform['receive'] = StudentReceivedCallCollege::query()->count();
        $call_perform['convert'] = StudentConvertedCallCollege::query()->count();

        
        return response()->json([
            "success" => true,
            "result" => $call_perform,
        ]);
    }
    public function topState(Request $request){
        $top_states=[];
        $html="";
        $date = explode('-',$request->date);
        
        
        $from = date('Y-m-d', strtotime('-1 day', strtotime($date[0])));
        $to = date('Y-m-d', strtotime('+1 day', strtotime($date[1])));


        $top_states['total_student'] = User::query()->groupBy('state')
                                                    ->selectRaw('count(*) as total, state')
                                                    ->whereBetween('updated_at', [$from, $to])
                                                     ->orderBy('total', 'DESC')
                                                    ->limit(5)
                                                    ->get();

        
        $state_arr =[];
        
        foreach ($top_states as  $top_state) {
            foreach ($top_state as $sts) {
                $single_state=State::where('id',$sts->state)->get('name');
                foreach ($single_state as $state) {
                    $html .=    "<tr>
                                <td>".$state['name']."</td>
                                <td>".User::query()->where("state",$sts->state)->whereIn('is_catking_student',['yes','mocks','gddpi'])
                                ->get()->count()."</td>
                                <td>".User::query()->where("state",$sts->state)->where('is_catking_student','no')->get()->count()."</td>
                                <td>".User::query()->where("state",$sts->state)->get()->count()."</td>
                            </tr>";
                            
                            // $state_arr['catking'][$single_state[0]['name']]=User::query()->where("state",$sts->state)->where('is_catking_student','yes')->get()->count();
                            // $state_arr['non_catking'][$single_state[0]['name']]=User::query()->where("state",$sts->state)->where('is_catking_student','no')->get()->count();
                            // $state_arr['total'][$single_state[0]['name']]=User::query()->where("state",$sts->state)->get()->count();
                }
            }
        }

        if($html ==''){
            $html = "<tr><td colspan='4' style='text-align:center'>No Record Found</td></tr>";
        }
        return response()->json([
            "success" => true,
            "result" => $html,
        ]);
    }
}
