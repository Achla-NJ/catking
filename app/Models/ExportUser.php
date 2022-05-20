<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExportUser extends Model
{
    protected $fillable = ['options', 'file', 'status'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'date',
        'download_file_link',
    ];

    public const FILES_PATH = 'public/uploads/export-users';


    public function getDateAttribute()
    {
        return Carbon::create($this->created_at)->format(config('app.display_date_format'));
    }

    public function getDownloadFileLinkAttribute()
    {
        if($this->file){
            return route('admin.users-export-download-file', $this->file);
        }
        return '';
    }
}
