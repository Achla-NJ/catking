<?php

namespace App\Exports\UsersExportSheets;

use App\Models\Exam;
use App\Models\StudentExam;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExamsScore implements FromCollection, WithTitle, WithHeadings
{
    protected $columns = [];
    protected $exams = [];
    protected $users = [];
    protected $exams_score = [];
    protected $other_exams_count = 0;
 
    public function __construct($users,array $exams_score)
    {
        $this->users = $users;
        $this->exams_score = $exams_score;
        $this->exams = Exam::query()->whereIn('id', $this->exams_score)->get();
        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
        ];

        foreach ($this->exams as $exam) {
            $this->columns["exam_{$exam->slug}_score"] = "$exam->name Score";
            $this->columns["exam_{$exam->slug}_percentile"] = "$exam->name Percentile";
            $this->columns["exam_{$exam->slug}_score_card"] = "$exam->name Score Card";
        }

        $highest_other_exam_count = StudentExam::query()
            ->with('user')
            ->selectRaw('COUNT(*) as count, user_id')
            ->where('type', 'other')
            ->groupBy('user_id')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()->first();
        if(in_array(0,$exams_score)){
            if(intval($highest_other_exam_count->count ?? 0) > 0){
                $this->other_exams_count = $highest_other_exam_count->count;
            }
        }

        for ($i = 0; $i < $this->other_exams_count; $i++){
            $ex = $i > 0? "Other (".($i+1).")": "Other";
            $this->columns["exam_other_name_$i"] = "$ex Exam Name";
            $this->columns["exam_other_score_$i"] = "$ex Score";
            $this->columns["exam_other_percentile_$i"] = "$ex Percentile";
            $this->columns["exam_other_score_card_$i"] = "$ex Score Card";
        }
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    public function collection():? Collection
    {
        $users = collect($this->users);
        $result = [];
        foreach ($users as $user) {
            $exams = $user->exams;

            $result_row = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ];

            foreach ($this->exams as $exam) {
                $ex =  $exams->where('type', $exam->slug)->first();
                $result_row = $result_row + [
                    "exam_{$exam->slug}_score" => @$ex->score,
                    "exam_{$exam->slug}_percentile" => @$ex->percentile,
                    "exam_{$exam->slug}_score_card" => @$ex->score_card_file_link,
                ];
            }

            $other_exams =  array_values($exams->where('type', 'other')->toArray());

            for ($i = 0; $i < $this->other_exams_count; $i++){
                $oe = @$other_exams[$i];
                $result_row = $result_row + [
                    "exam_other_name_$i" => @$oe['name'],
                    "exam_other_score_$i" => @$oe['score'],
                    "exam_other_percentile_$i" => @$oe['percentile'],
                    "exam_other_score_card_$i" => @$oe['score_card_file_link'],
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
        return 'Exams Scores';
    }
}
