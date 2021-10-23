<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'class_activity_id',
        'class_activity_answer_id',
        'answer_text',
        'points'
    ];
}
