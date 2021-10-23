<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_activity_test_question_id',
        'answer_text',
        'correct'
    ];
}
