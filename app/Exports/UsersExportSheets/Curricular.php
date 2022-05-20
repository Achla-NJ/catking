<?php

namespace App\Exports\UsersExportSheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Curricular implements FromCollection, WithTitle, WithHeadings
{
    protected $columns = [];
    protected $exams = [];
    protected $users = [];
    protected $other_exams_count = 0;

    public function __construct($users)
    {
        $this->users = $users;
        $this->columns = [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
            'co_curricular_details' => 'Co-Curricular Details',
            'extra_curricular_details' => 'Extra Curricular Details',
            'other_curricular_details' => 'Other Curricular Details',
        ];
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
            $ccd = $user->meta('curricular', 'curricular', 'co');
            $ecd = $user->meta('curricular', 'curricular', 'extra');
            $ocd = $user->meta('curricular', 'curricular', 'other');

            $ccdt = "";
            foreach ($ccd as $key => $item) {
                $ccdt .= ($key + 1).") $item ";
            }
            $ccdt = trim($ccdt);

            $ecdt = "";
            foreach ($ecd as $key => $item) {
                $ecdt .= ($key + 1).") $item ";
            }
            $ecdt = trim($ecdt);

            $ocdt = "";
            foreach ($ocd as $key => $item) {
                $ocdt .= ($key + 1).") $item ";
            }
            $ocdt = trim($ocdt);

            $result_row = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'co_curricular_details' => $ccdt,
                'extra_curricular_details' => $ecdt,
                'other_curricular_details' => $ocdt,
            ];

            $result[] = $result_row;
        }
        return collect($result);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Curricular';
    }
}
