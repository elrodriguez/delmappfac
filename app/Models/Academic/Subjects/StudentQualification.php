<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_test_id',
        'class_activitie_id',
        'class_activity_test_question_id',
        'class_activity_test_answer_id',
        'class_activity_test_question',
        'class_activity_test_answer',
        'point'
    ];
}
