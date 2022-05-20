<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentEducation extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $fillable = [
        "user_id", 
        "class_type", 
        "class_name",
        "board_type", 
        "board_name",
        "school", 
        "marks", 
        "cgpa",
        "passing_year", 
        "start_date", 
        "end_date",
        "gap", 
        "month", 
        "summary"
    ];

    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
