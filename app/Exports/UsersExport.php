<?php

namespace App\Exports;

use App\Exports\UsersExportSheets\Curricular;
use App\Exports\UsersExportSheets\DreamColleges;
use App\Exports\UsersExportSheets\ExamsScore;
use App\Exports\UsersExportSheets\SopColleges;
use App\Exports\UsersExportSheets\InterviewDateColleges;
use App\Exports\UsersExportSheets\ConvertedCallColleges;
use App\Exports\UsersExportSheets\Education;
use App\Exports\UsersExportSheets\Work;
use App\Exports\UsersExportSheets\PersonalInfo;
use App\Exports\UsersExportSheets\ReceivedCallColleges;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersExport implements WithMultipleSheets
{
    use Exportable;

    protected $options = [];

    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $users = User::query();

        if(!empty(@$this->options['education'])){
            $users = $users->with('education');
        }
        // if(!empty(@$this->options['exams_score'])){
        //     $users = $users->with('exams');
        // }
        if(!empty(@$this->options['work'])){
            $users = $users->with('work');
        }
        if(!empty(@$this->options['dream_colleges'])){
            $users = $users->with('dream_colleges');
        }
        if(!empty(@$this->options['interview_date_colleges'])){
            $users = $users->with('interview_dates');
        }

        $users = $users->oldest()->get();
        $sheets = [];
        $sheets[] = new PersonalInfo($users, @$this->options['personal_info'] ?? []);

        if(!empty(@$this->options['education'])){
            $sheets[] = new Education($users);
        }
        if(!empty(@$this->options['work'])){
            $sheets[] = new Work($users);
        }
        if(!empty(@$this->options['curricular'])){
            $sheets[] = new Curricular($users);
        }
        if(!empty(@$this->options['dream_colleges'] ?? [])){
            $sheets[] = new DreamColleges($users, $this->options['dream_colleges'] ?? []);
        }
        if(!empty(@$this->options['exams_score'] ?? [])){
            $sheets[] = new ExamsScore($users,$this->options['exams_score'] ?? []);
        }
        if(!empty(@$this->options['sop_colleges'] ?? [])){
            $sheets[] = new SopColleges($users, $this->options['sop_colleges'] ?? []);
        }
        if(!empty(@$this->options['received_call_colleges'] ?? [])){
            $sheets[] = new ReceivedCallColleges($users, $this->options['received_call_colleges'] ?? []);
        }
        if(!empty(@$this->options['interview_date_colleges'] ?? [])){
            $sheets[] = new InterviewDateColleges($users, $this->options['interview_date_colleges'] ?? []);
        }
        if(!empty(@$this->options['converted_call_colleges'] ?? [])){
            $sheets[] = new ConvertedCallColleges($users, $this->options['converted_call_colleges'] ?? []);
        }
        return $sheets;
    }
}
