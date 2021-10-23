<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherCourse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'academic_level_id',
        'academic_year_id',
        'academic_section_id',
        'teacher_id',
        'course_id',
        'academic_season_id',
        'curricula_id',
        'state'
    ];
}
