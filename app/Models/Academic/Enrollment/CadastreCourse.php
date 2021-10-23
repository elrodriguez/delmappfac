<?php

namespace App\Models\Academic\Enrollment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastreCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastre_id',
        'course_id',
        'state',
        'teacher_id'
    ];
}
