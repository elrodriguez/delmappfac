<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTopic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'course_id',
        'state',
        'number',
        'user_id',
        'person_id',
        'teacher_course_id'
    ];
}
