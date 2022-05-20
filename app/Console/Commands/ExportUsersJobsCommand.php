<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use App\Models\ExportUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportUsersJobsCommand extends Command
{
    protected $signature = 'export:users';

    protected $description = 'Preparing users export data';


    public function handle()
    {
        $exports = ExportUser::query()
            ->where('status', 'pending')
            ->limit(10)
            ->latest()
            ->get();

        $this->info("Started ".count($exports)." Exports File(s)");

        foreach ($exports as $export) {
            $export->update([
                'status' => 'preparing',
            ]);
            $options = json_decode($export->options, true);
            $file = 'users-export-id-'.$export->id.'-time-'.Carbon::create($export->created_at)->format('H-i-s-a-d-m-Y').'--'.microtime(true).'.xlsx';
            Excel::store(new UsersExport($options), ExportUser::FILES_PATH.DIRECTORY_SEPARATOR.$file);
            $export->update([
                'file' => $file,
                'status' => 'completed',
            ]);
        }

        $this->info("Completed ".count($exports)." Exports File(s)");
    }
}
