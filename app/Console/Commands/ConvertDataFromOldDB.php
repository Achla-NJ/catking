<?php
/** @noinspection ALL */

namespace App\Console\Commands;

use App\Models\College;
use App\Models\OldUsers;
use App\Models\StudentReceivedCallCollege;
use App\Models\StudentConvertedCallCollege;
use App\Models\StudentDreamCollege;
use App\Models\StudentEducation;
use App\Models\StudentExam;
use App\Models\StudentSopColleges;
use App\Models\StudentWork;
use App\Models\User;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ConvertDataFromOldDB extends Command
{
    protected $signature = 'data:convert-from-old-db';

    protected $description = 'Convert database from old database';

    /**
     * @param number $offset
     * @param number $limit
     * @return Builder[]|Collection
     */
    private function getOldUsers($offset, $limit = 1000)
    {
        return OldUsers::query()->offset($offset)->limit($limit)->get();
    }

    public function handle()
    {
        /*
         * Todo: Enable [
                $users_count = OldUsers::query()->count();
                for ($i = 0; $i < $users_count; $i+=1000){
                    $users = $this->getOldUsers($i);
                    foreach ($users as $user){
                        $this->convertUser($user);
                    }
                }
            ]
        */

        \DB::statement('Delete FROM `users` where id not in (4, 5, 11, 12);');

        $users = OldUsers::query()->limit(1000)->get();
        foreach ($users as $user){
            $this->convertUser($user);
        }
        dd("completed!");
    }

    private function convertUser($old_user)
    {
        if(!$old_user){
            return false;
        }

        $dob = "";
        try{
            $dob = Carbon::create(str_replace('/', '-', $old_user->dob))->toDateTimeString();
        }catch (\Exception $e){}

        $user = User::query()->updateOrCreate(['old_id' => $old_user->id],[
            'old_id' => $old_user->id,
            'name' => $old_user->name,
            'email' => $old_user->email,
            'password' =>  bcrypt($old_user->password),
            'mobile_number' => $old_user->phone,
            'avatar' => $this->getImportedFile($old_user->photo),
            'whatsapp_number' => $old_user->whatsapp,
            'address' => $old_user->address,
            'dob' => $dob,
            'is_catking_student' => strtolower($old_user->catkingstudent) == 'yes'? 'yes': 'no',
        ]);

        if(!$user){return false;}

        $educations = [
            [
                "class_type" => "matric",
                "board" => $old_user->tenthboard,
                "school" => $old_user->tenthschool,
                "marks" => $old_user->tenth,
            ],
            [
                "class_type" => "secondary",
                "board" => $old_user->twelveboard,
                "school" => $old_user->twelveschool,
                "marks" => $old_user->twelve,
            ],
            [
                "class_type" => "graduation",
                "board" => "Other",
                "school" => $old_user->gradschool,
                "marks" => $old_user->graduation,
                "passing_year" => Carbon::create($old_user->gradyear)->year
            ],
            [
                "class_type" => "other",
                "board" => "Other",
                "school" => null,
                "marks" => null,
                "passing_year" => null,
                "summary" => $old_user->certificates,
            ],
        ];

        foreach ($educations as $education) {
            $this->addEducation($user, $education["class_type"], $education["board"], $education["school"], $education["marks"], @$education["passing_year"]);
        }

        StudentWork::query()->create([
            "user_id" => $user->id,
            "work_type" => strtolower($old_user->full_time_job) == "yes"? "full_time": (!empty($old_user->internship)? "internship": "part_time"),
            "summary" => $old_user->internship,
        ]);

        $exams = [
            [
                "exam" => "cat",
                "score" => trim($old_user->cat) && is_int(trim($old_user->cat))? trim($old_user->cat): $old_user->catscore,
                "sc" => $old_user->cat_scorecard
            ],
            [
                "exam" => "nmat",
                "score" => $old_user->nmat,
                "sc" => $old_user->nmat_scorecard
            ],
            [
                "exam" => "snap",
                "score" => $old_user->snap,
                "sc" => $old_user->snap_scorecard
            ],
            [
                "exam" => "cet",
                "score" => $old_user->cet,
                "sc" => $old_user->cet_scorecard
            ],
            [
                "exam" => "cmat",
                "score" => $old_user->cmat,
                "sc" => $old_user->cmat_scorecard
            ],
            [
                "exam" => "xat",
                "score" => $old_user->xat,
                "sc" => $old_user->xat_scorecard
            ],
            [
                "exam" => "micat",
                "score" => $old_user->micat,
                "sc" => $old_user->micat_scorecard
            ],
            [
                "exam" => "tissnet",
                "score" => $old_user->tissnet,
                "sc" => $old_user->tissnet_scorecard
            ],
            [
                "exam" => "iift",
                "score" => $old_user->iift,
                "sc" => $old_user->iift_scorecard
            ],
        ];
        foreach ($exams as $exam) {
            $this->addExam($user, $exam["exam"], $exam["score"], $exam["sc"]);
        }

        $dream_colleges = explode("\n", $old_user->dream_college);
        $dream_colleges = count($dream_colleges) > 1 ? $dream_colleges: explode(",", $old_user->dream_college);
        foreach ($dream_colleges as $college) {
            // TODO: change like if records mismatch
            $cid = College::query()->select('id')->where("name", "LIKE", "%$college%")->first();
            if(@$cid->id){
                StudentDreamCollege::query()->create([
                    "user_id" => $user->id,
                    "college_id" => $cid->id,
                ]);
            }
        }

        $received_call = $old_user->college_calls_list; // always, imploded by comma
        if(trim($old_user->college_calls)){
            $calls = explode("\n", $old_user->college_calls);
            $received_call .= ",".implode(",", $calls);
        }
        foreach (explode(",", $received_call) as $college) {
            // TODO: change like if records mismatch
            $cid = College::query()->select('id')->where("name", "LIKE", "%$college%")->first();
            if(@$cid->id){
                StudentReceivedCallCollege::query()->create([
                    "user_id" => $user->id,
                    "college_id" => $cid->id,
                ]);
            }
        }

        $_converted_call = trim($old_user->college_converts);
        $converted_call = explode("\n", $_converted_call);
        $converted_call = count($converted_call) > 1 ? $converted_call: explode(",", $_converted_call);
        foreach ($converted_call as $college){
            $college = strip_tags(trim($college));
            // TODO: change like if records mismatch
            $cid = College::query()->select('id')->where("name", "LIKE", "%$college%")->first();
            if(@$cid->id){
                StudentConvertedCallCollege::query()->create([
                    "user_id" => $user->id,
                    "college_id" => $cid->id,
                ]);
            }
        }

        $sops = [
            ["college" => "SP Jain", "file" => $old_user->e4],
            ["college" => "NMIMS", "file" => $old_user->nmimssop],
            ["college" => "Other", "file" => $old_user->sop1],
            ["college" => "Other", "file" => $old_user->sop2],
            ["college" => "Other", "file" => $old_user->sop3],
            ["college" => "Other", "file" => $old_user->app1],
            ["college" => "Other", "file" => $old_user->app2],
            ["college" => "FMS", "file" => $old_user->fmssop],
            ["college" => "IIM Ahmedabad", "file" => $old_user->IIM_Ahmedabad_Form],
            ["college" => "IIM Indore", "file" => $old_user->IIM_Indore_Form],
            ["college" => "IIM Shillong", "file" => $old_user->IIM_Shillong_Form],
            ["college" => "SIBM Pune", "file" => $old_user->SIBM_Pune_Form],
        ];

        foreach ($sops as $sop) {
            $cid = College::query()->select('id')->where("name", "LIKE", "%".$sop["college"]."%")->first();
            if(!empty($sop["file"]) && @$cid->id){
                StudentSopColleges::query()->create([
                    "user_id" => $user->id,
                    "college_id" => $cid->id,
                    "file" => @$sop["file"]
                ]);
            }
        }
    }

    private function getImportedFile($file):? string
    {
        return $file;
        return "https://profile.catking.in/lib/".$file;
    }

    private function examScore($default_score, $score)
    {
        return trim($score) && is_int(trim($score))? trim($score): trim($default_score);
    }

    /**
     * @param  User  $user
     * @param $exam
     * @param $score
     * @param $score_card
     * @return void
     */
    private function addExam(User $user, $exam, $score, $score_card): void
    {
        $score = trim($score);
        $score_card = trim($score_card);
        if ($score || $score_card) {
            $rel = strtolower($exam)."_".rand(111111, 999999);
            StudentExam::query()->create([
                "user_id" => $user->id,
                "type" => $exam,
                "took_exam" => "yes",
                "score" => $score,
                "score_card_file" => $this->getImportedFile($score_card),
            ]);
        }
    }

    /**
     * @param  User  $user
     * @param $exam
     * @param $score
     * @param $score_card
     * @return void
     */
    private function addEducation(User $user, $class_type, $board, $school, $marks, $passing_year = "", $summary = ""): void
    {
        $mb = UserMeta::EDUCATION_BOARD_TYPES[$class_type];
        $mbf = array_flip($mb);
        $r = $class_type."_".rand(1111, 9999);
        StudentEducation::query()->create([
            "user_id" => $user->id,
            "class_type" => $class_type,
            "class_name" => @User::STUDY_CLASSES[$class_type],
            "board_type" => @$mbf[$board],
            "board_name" => @$mb[@$mbf[$board]],
            "school" => $school,
            "marks" => $marks,
            "cgpa" => "",
            "passing_year" => $passing_year,
            "summary" => $summary,
        ]);
    }
}
