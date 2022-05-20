<?php

namespace App\Exports\UsersExportSheets;

use App\Models\College;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class InterviewDateColleges implements FromCollection, WithTitle, WithHeadings
{
    protected $options = [];
    protected $columns = [];
    protected $interview_dates = [];
    protected $colleges = [];
    protected $college_ids = [];
    protected $users = [];

    public function __construct($users, array $interview_dates)
    {
        $this->users = $users;
        $this->interview_dates = $interview_dates;
        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
        ];

        $this->colleges = College::query()
            ->whereIn('id', $this->interview_dates)
            ->where('id', '!=', '0')
            ->where('created_by_user', 'no')
            ->get();

        foreach ($this->colleges as $college) {
            $this->columns["college_$college->id"] = $college->name;
        }
        if(in_array(0,$interview_dates)){
            $this->columns["college_others"] = "Others";
        }
        $this->college_ids = $this->colleges->pluck('id')->toArray();
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
            $user_id = $user->id;
            $result["rf_$user_id"] = [
                "user_id" => @$user->id,
                "user_name" => @$user->name,
                "user_email" => @$user->email,
            ];
            foreach ($this->colleges as $college) {
                $date = $user->interview_dates()->where('college_id',$college->id)->pluck('date')->first();
                $result["rf_$user_id"]["college_$college->id"] = $date ?: "No";
            }
            $other_colleges["rf_$user_id"] = $user->interview_dates()
                ->join('colleges', 'colleges.id', 'student_interview_dates.college_id')
                ->where('colleges.created_by_user', 'yes')
                ->get();
            $other_colleges["rf_$user_id"] = $other_colleges["rf_$user_id"] ? $other_colleges["rf_$user_id"]->pluck('college_name')->implode(', '): "";
            $result["rf_$user_id"]["college_others"] = $other_colleges["rf_$user_id"];
        }
        return collect($result);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Interview Dates';
    }
}
