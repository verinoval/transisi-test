<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'employee_id', 'jabatan_id', 'employee_name', 'employee_salary', 'employee_age'
    ];

    public function jabatan(){
        return $this->hasOne('App\Models\Jabatan','jabatan_id','jabatan_id');
    }
}
