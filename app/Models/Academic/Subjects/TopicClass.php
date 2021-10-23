<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'state',
        'live',
        'course_topic_id',
        'number'
    ];
}
