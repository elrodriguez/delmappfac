<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTestAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_test_id',
        'class_activitie_id',
        'class_activity_test_question_id',
        'class_activity_test_answer_id',
        'point',
        'answer_text'
    ];
}
