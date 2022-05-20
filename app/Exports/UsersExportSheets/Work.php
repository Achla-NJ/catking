<?php

namespace App\Exports\UsersExportSheets;

use App\Models\StudentWork;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Work implements  FromCollection, WithTitle, WithHeadings
{
    protected $options = [];
    protected $columns = [];
    protected $users = [];
    protected $diploma_work_count = 0;

    public function __construct($users)
    {
        $this->users = $users;

        $student_work_count = StudentWork::query()
            ->with('user')
            ->selectRaw('COUNT(*) as count, user_id')
            ->groupBy('user_id')
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()->first();

        if(intval($student_work_count->count ?? 0) > 0){
            $this->diploma_work_count = $student_work_count->count;
        }

        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',

            'work_type' => 'Work Type',
            'company_name' => 'Company Name',
            'role' => 'Role',
            'join_date' => 'Join Date',
            'leave_date' => 'Leave Date',

            'responsibilities' => 'Responsibilities',
            'working_presently' => 'Working Presently',
            // 'summary' => 'Summary',
        ];


        for ($i = 1; $i < $this->diploma_work_count; $i++){
            $wrk = $i > 0? "Work ": "Work";
            $this->columns["work_type_$i"] = "$wrk Type (".($i+1).")";
            $this->columns["company_name_$i"] = "$wrk Company Name (".($i+1).")";
            $this->columns["role_$i"] = "$wrk Designation (".($i+1).")";
            $this->columns["join_date_$i"] = "$wrk Join Date (".($i+1).")";
            $this->columns["leave_date_$i"] = "$wrk Leave Date (".($i+1).")";
            $this->columns["responsibilities_$i"] = "$wrk Responsibilities (".($i+1).")";
            $this->columns["working_presently_$i"] = "$wrk Working Presently (".($i+1).")";
            // $this->columns["summary_$i"] = "$wrk Summary";
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
            $works = $user->work;

            $result_row = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ];

            for ($i = 0; $i < $this->diploma_work_count; $i++){
                $pg = @$works[$i];
                $result_row = $result_row + [
                    "work_type_$i"=>  str_replace('_',' ',@$pg["work_type"]),
                    "company_name_$i"=>  @$pg["company_name"],
                    "role_$i"=>  @$pg["role"],
                    "join_date_$i"=>  @$pg["join_date"] == null ? '' :date('d M, Y',strtotime(@$pg["join_date"])),
                    "leave_date_$i"=>  @$pg["leave_date"] == null ? '' :date('d M, Y',strtotime(@$pg["leave_date"])),
                    "responsibilities_$i"=>  @$pg["responsibilities"],
                    "working_presently_$i"=> @$pg["working_presently"],
                    // "summary_$i"=>  @$pg["summary"],
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
        return 'Work';
    }
}
