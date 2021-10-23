<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAssistanceStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'student_id',
        'academic_level_id',
        'academic_year_id',
        'academic_section_id',
        'course_id',
        'curricula_id',
        'academic_season_id',
        'assistance_year',
        'assistance_month',
        'assistance_day',
        'assistance_date',
        'attended',
        'justified',
        'observation'
    ];
}
