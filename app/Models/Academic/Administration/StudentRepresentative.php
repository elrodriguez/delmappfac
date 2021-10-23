<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentRepresentative extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'representative_id',
        'student_id',
        'person_student_id',
        'lives',
        'live_with_the_student',
        'state'
    ];
}
