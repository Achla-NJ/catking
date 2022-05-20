<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSopColleges extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $fillable = ["user_id", "college_id", "file"];

    protected $appends = ['college_name', 'file_link'];

    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function college():? BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function getCollegeNameAttribute($key)
    {
        return @$this->college->name;
    }

    public function getFileLinkAttribute()
    {
        if(!$this->file){
            return null;
        }
        if(file_exists(storage_path("app".DIRECTORY_SEPARATOR.User::FILES_PATH.DIRECTORY_SEPARATOR.$this->file))){
            return route("user-files", $this->file);
        }
        return "https://profile.catking.in/lib/{$this->file}";
    }
}
