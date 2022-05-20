<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentInterviewDate extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function college():? BelongsTo
    {
        return $this->belongsTo(College::class);
    }
}
