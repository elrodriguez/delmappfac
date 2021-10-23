<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'class_activity_id',
        'comment',
        'likes',
        'heart'
    ];
}
