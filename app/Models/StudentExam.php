<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentExam extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $fillable = ["user_id", "type", "took_exam", "score", "score_card_file"];

    protected $appends = ['score_card_file_link'];

    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getScoreCardFileLinkAttribute()
    {
        $file = $this->score_card_file;
        if(!$file){
            return "";
        }
        if(file_exists(storage_path("app".DIRECTORY_SEPARATOR.User::FILES_PATH.DIRECTORY_SEPARATOR.$file))){
            return asset('storage/uploads/user-files/'.$file);
            // return route("user-files", $file);
        }
        return "https://profile.catking.in/lib/$file";
    }

}
