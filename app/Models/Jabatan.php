<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'jabatan_id';

    protected $fillable = [
        'jabatan_id'
    ];
}
