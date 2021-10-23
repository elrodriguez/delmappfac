<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassActivity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
        'body',
        'state',
        'academic_type_activitie_id',
        'topic_class_id',
        'number',
        'user_id',
        'date_start',
        'date_end',
        'duration',
        'url_file',
        'name_file',
        'extension',
        'size'
    ];
}
