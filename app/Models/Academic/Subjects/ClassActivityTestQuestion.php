<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityTestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'course_id',
        'class_activity_id',
        'question_text',
        'points',
        'question_type'
    ];
}
