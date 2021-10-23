<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityHomework extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'course_id',
        'class_activity_id',
        'class_activity_homework_id',
        'description',
        'points',
        'file_name',
        'state'
    ];
}
