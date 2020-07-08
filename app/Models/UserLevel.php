<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    protected $table = 'user_level';
    protected $primaryKey = 'level_id';

    protected $fillable = [
        'level_id'
    ];
}
