<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employees_id';

    protected $fillable = [
        'employees_id'
    ];
}
