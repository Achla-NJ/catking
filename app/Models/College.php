<?php

namespace App\Models;

use App\Traits\ExtraFeaturesOfModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory, ExtraFeaturesOfModel;

    protected $guarded = [];
}
