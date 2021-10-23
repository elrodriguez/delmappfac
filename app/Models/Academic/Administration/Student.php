<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'student_code',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'id_person',
        'number_dni'
    ];
}
