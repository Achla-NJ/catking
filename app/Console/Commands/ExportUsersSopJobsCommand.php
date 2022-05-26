<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use App\Models\ExportSop;
use App\Models\User;
use App\Models\StudentSopColleges;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use File;
use ZipArchive;

class ExportUsersSopJobsCommand extends Command
{
    protected $signature = 'export:sops';

    protected $description = 'Preparing users export data';


    public function handle()
    {
        $files=[];
        $exports = ExportSop::query()
            ->where('status', 'pending')
            ->limit(1)
            ->latest()
            ->get();

        $this->info("Started ".count($exports)." Exports File(s)");

        $storage_path = "app".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR;

        foreach ($exports as $export) {
            $sops = StudentSopColleges::query()
                ->whereNotNull('file')
                ->where('file', '!=', '')
                ->whereBetween('updated_at', [$export->from_date, $export->to_date])
                ->get();

            foreach($sops as $key =>  $sop){
                if(!empty($sop->file)){
                    $file = storage_path($storage_path."user-files".DIRECTORY_SEPARATOR.$sop->file);
                    if(file_exists($file)) {
                        $files[$key] = $file;
                    }
                }
            }

            $fileName = 'users-sop-id-'.$export->id.'-time-'.Carbon::create($export->created_at)->format('H-i-s-a-d-m-Y').'--'.microtime(true).'.zip';

            $zip_path = storage_path($storage_path."export-sops".DIRECTORY_SEPARATOR.$fileName);

            if(count($files)>0){
                $export->update([
                    'status' => 'preparing',
                ]);

                $zip = new ZipArchive();
                if ($zip->open($zip_path, ZipArchive::CREATE) == TRUE) {
                    foreach ($files as $file){
                        $relativeName = basename($file);
                        $zip->addFile($file, $relativeName);
                    }
                    $zip->close();
                }

                $export->update([
                    'file' => $fileName,
                    'status' => 'completed',
                ]);
            }else{
                $export->update([
                    'file' => '',
                    'status' => 'files_not_exists',
                ]);
            }


        }

        $this->info("Completed ".count($exports)." Exports File(s)");
    }
}
