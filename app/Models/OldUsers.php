<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldUsers extends Model
{
    protected $connection = 'old_db';

    protected $table = "users";
}
