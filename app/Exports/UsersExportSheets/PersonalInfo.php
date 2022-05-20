<?php

namespace App\Exports\UsersExportSheets;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PersonalInfo implements FromCollection, WithTitle, WithHeadings
{
    protected $options = [];
    protected $columns = [];
    protected $users = [];

    public function __construct($users, array $options)
    {
        $this->users = $users;
        $this->columns['id'] = 'ID';

        collect($options)->map(function ($val, $key) {
            if($val){
                $this->columns[$key] = Str::replace('_', ' ', Str::title($key));
            }
        });

        $this->columns['created_at'] = 'Created At';
        $this->columns['updated_at'] = 'Updated At';
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
            $cols = $user->only(array_keys($this->columns));
            $cols['state'] = @$user->get_state->name;
            $cols['created_at'] = Carbon::create($user->created_at)->format('H:i:s Y-m-d');
            $cols['updated_at'] = Carbon::create($user->updated_at)->format('H:i:s Y-m-d');
            $result[] = $cols;
        }
        return collect($result);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Personal Info';
    }
}
