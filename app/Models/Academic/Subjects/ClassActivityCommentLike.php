<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassActivityCommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_activity_comment_id'
    ];
}
