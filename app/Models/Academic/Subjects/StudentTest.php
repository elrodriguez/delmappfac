<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_activitie_id',
        'student_id',
        'user_id',
        'score',
        'state',
        'duration'
    ];
}
