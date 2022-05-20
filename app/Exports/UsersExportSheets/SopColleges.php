<?php

namespace App\Exports\UsersExportSheets;

use App\Models\College;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SopColleges implements FromCollection, WithTitle, WithHeadings
{
    protected $options = [];
    protected $columns = [];
    protected $sop_colleges = [];
    protected $colleges = [];
    protected $college_ids = [];
    protected $users = [];

    public function __construct($users, array $sop_colleges)
    {
        $this->users = $users;
        $this->sop_colleges = $sop_colleges;
        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
        ];

        $this->colleges = College::query()
            ->whereIn('id', $this->sop_colleges)
            ->where('id', '!=', '0')
            ->where('created_by_user', 'no')
            ->get();

        foreach ($this->colleges as $college) {
            $this->columns["college_$college->id"] = $college->name;
        }

        if(in_array(0,$sop_colleges)){
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
        $college_ids = [];
        $other_colleges = [];

        foreach ($users as $user) {
            $user_id = $user->id;
            $result["rf_$user_id"] = [
                "user_id" => @$user->id,
                "user_name" => @$user->name,
                "user_email" => @$user->email,
            ];
            $college_ids["rf_$user_id"] = $user->sop_colleges->pluck('college_id')->toArray();
            foreach ($this->colleges as $college) {
                $result["rf_$user_id"]["college_$college->id"] = in_array($college->id, $college_ids["rf_$user_id"])? "Yes": "No";
            }
            $other_colleges["rf_$user_id"] = $user->sop_colleges()
                ->join('colleges', 'colleges.id', 'student_sop_colleges.college_id')
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
        return 'Sop Colleges';
    }
}
