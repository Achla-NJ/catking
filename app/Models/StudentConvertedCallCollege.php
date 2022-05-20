<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentConvertedCallCollege extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $fillable = ["user_id", "college_id", "file"];

    protected $appends = ['college_name'];

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
}
