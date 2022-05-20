<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentWork extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $fillable = ["user_id", "company_name", "role", "join_date", "leave_date", "work_type", "responsibilities", "summary"];

    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
