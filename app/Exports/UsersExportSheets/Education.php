<?php

namespace App\Exports\UsersExportSheets;

use App\Models\StudentEducation;
use App\Models\UserMeta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Education implements FromCollection, WithTitle, WithHeadings
{
    protected $options = [];
    protected $columns = [];
    protected $users = [];
    protected $college_ids = [];
    protected $post_graduations_count = 0;
    protected $other_educations_count = 0;
    protected $diploma_educations_count = 0;

    public function __construct($users)
    {
        $this->users = $users;

        $highest_post_graduated_count = StudentEducation::query()
            ->with('user')
            ->selectRaw('COUNT(*) as count, user_id')
            ->where('class_type', 'post_graduation')
            ->groupBy('user_id')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()->first();

        if(intval($highest_post_graduated_count->count ?? 0) > 0){
            $this->post_graduations_count = $highest_post_graduated_count->count;
        }

        $highest_other_graduated_count = StudentEducation::query()
            ->with('user')
            ->selectRaw('COUNT(*) as count, user_id')
            ->where('class_type', 'other')
            ->groupBy('user_id')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()->first();

        if(intval($highest_other_graduated_count->count ?? 0) > 0){
            $this->other_educations_count = $highest_other_graduated_count->count;
        }

        $highest_diploma_graduated_count = StudentEducation::query()
            ->with('user')
            ->selectRaw('COUNT(*) as count, user_id')
            ->where('class_type', 'diploma')
            ->groupBy('user_id')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()->first();

        if(intval($highest_diploma_graduated_count->count ?? 0) > 0){
            $this->diploma_educations_count = $highest_diploma_graduated_count->count;
        }

        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',

            'education_10th_board' => '10th Board',
            'education_10th_school' => '10th School',
            'education_10th_marks' => '10th Marks',
            'education_10th_cgpa' => '10th CGPA',
            'education_10th_passing_year' => '10th Passing Year',

            'education_12th_board' => '12th Board',
            'education_12th_school' => '12th School',
            'education_12th_marks' => '12th Marks',
            'education_12th_cgpa' => '12th CGPA',
            'education_12th_passing_year' => '12th Passing Year',

            'education_graduation_board' => 'Graduation Degree',
            'education_graduation_school' => 'Graduation College',
            'education_graduation_marks' => 'Graduation Marks',
            'education_graduation_cgpa' => 'Graduation CGPA',
            'education_graduation_passing_year' => 'Graduation Passing Year',
            'education_graduation_gap_in_months' => 'Graduation Gap In Months',
        ];

        for ($i = 0; $i < $this->post_graduations_count; $i++){
            $edu = $i > 0? "Post Graduation (".($i+1).")": "Post Graduation";
            $this->columns["education_post_graduation_board_$i"] = "$edu Degree";
            $this->columns["education_post_graduation_school_$i"] = "$edu College";
            $this->columns["education_post_graduation_marks_$i"] = "$edu Marks";
            $this->columns["education_post_graduation_cgpa_$i"] = "$edu CGPA";
            $this->columns["education_post_graduation_passing_year_$i"] = "$edu Passing Year";
        }

        for ($i = 0; $i < $this->other_educations_count; $i++){
            $edu = $i > 0? "Other Certifications (".($i+1).")": "Other Certifications";
            $this->columns["education_other_board_$i"] = "$edu Course";
            $this->columns["education_other_start_date_$i"] = "$edu Start Date";
            $this->columns["education_other_end_date_$i"] = "$edu End Date";
        }

        for ($i = 0; $i < $this->diploma_educations_count; $i++){
            $edu = $i > 0? "Diploma (".($i+1).")": "Diploma";
            $this->columns["education_diploma_board_$i"] = "$edu Course";
            $this->columns["education_diploma_school_$i"] = "$edu Institute";
            $this->columns["education_diploma_marks_$i"] = "$edu Marks";
            $this->columns["education_diploma_cgpa_$i"] = "$edu CGPA";
            $this->columns["education_diploma_passing_year_$i"] = "$edu Passing Year";
        }
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    private function getBoardName($edu)
    {
        $edu = is_array($edu)?$edu:json_decode($edu, true);
        if(@$edu['board_type'] == "other" && !empty($edu['board_name'])){
            return @$edu['board_name'];
        }
        return @UserMeta::EDUCATION_BOARD_TYPES[$edu['class_type']][$edu['board_type']];
    }

    public function collection():? Collection
    {
        $users = collect($this->users);
        $result = [];
        foreach ($users as $user) {
            $educations = $user->education;
            $e10th =  $educations->where('class_type', 'matric')->first();
            $e12th =  $educations->where('class_type', 'secondary')->first();
            $graduation =  $educations->where('class_type', 'graduation')->first();
            $post_graduations =  array_values($educations->where('class_type', 'post_graduation')->toArray());
            $other_educations =  array_values($educations->where('class_type', 'other')->toArray());
            $diploma_educations =  array_values($educations->where('class_type', 'diploma')->toArray());

            $result_row = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,

                'education_10th_board' => $this->getBoardName($e10th),
                'education_10th_school' => @$e10th->school,
                'education_10th_marks' => @$e10th->marks,
                'education_10th_cgpa' => @$e10th->cgpa,
                'education_10th_passing_year' => @$e10th->passing_year,

                'education_12th_board' => $this->getBoardName($e12th),
                'education_12th_school' => @$e12th->school,
                'education_12th_marks' => @$e12th->marks,
                'education_12th_cgpa' => @$e12th->cgpa,
                'education_12th_passing_year' => @$e12th->passing_year,

                'education_graduation_board' => $this->getBoardName($graduation),
                'education_graduation_school' => @$graduation->school,
                'education_graduation_marks' => @$graduation->marks,
                'education_graduation_cgpa' => @$graduation->cgpa,
                'education_graduation_passing_year' => @$graduation->passing_year,
                'education_graduation_gap_in_months' => @$graduation->gap == "yes"? @$graduation->month: "no",
            ];

            for ($i = 0; $i < $this->post_graduations_count; $i++){
                $pg = @$post_graduations[$i];
                $result_row = $result_row + [
                    "education_post_graduation_board_$i" => $this->getBoardName($pg),
                    "education_post_graduation_school_$i" => @$pg["school"],
                    "education_post_graduation_marks_$i" => @$pg["marks"],
                    "education_post_graduation_cgpa_$i" => @$pg["cgpa"],
                    "education_post_graduation_passing_year_$i" => @$pg["passing_year"],
                ];
            }

            for ($i = 0; $i < $this->other_educations_count; $i++){
                $oe = @$other_educations[$i];
                $result_row = $result_row + [
                    "education_other_board_$i" => $this->getBoardName($oe),
                    "education_other_start_date_$i" => @$oe["start_date"],
                    "education_other_end_date_$i" => @$oe["end_date"],
                ];
            }

            for ($i = 0; $i < $this->diploma_educations_count; $i++){
                $dp = @$diploma_educations[$i];
                $result_row = $result_row + [
                    "education_diploma_board_$i" => $this->getBoardName($dp),
                    "education_diploma_school_$i" => @$dp["school"],
                    "education_diploma_marks_$i" => @$dp["marks"],
                    "education_diploma_cgpa_$i" => @$dp["cgpa"],
                    "education_diploma_passing_year_$i" => @$dp["passing_year"],
                ];
            }

            $result[] = $result_row;
        }
        return collect($result);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Education';
    }
}
