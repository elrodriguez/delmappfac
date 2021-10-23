<?php

namespace App\Models\Academic\Enrollment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cadastre extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'academic_level_id',
        'academic_section_id',
        'academic_year_id',
        'cadastre_situation_id',
        'year',
        'date_register',
        'person_id',
        'attorney_id',
        'course_id',
        'document_id',
        'observation',
        'state',
        'academic_season_id',
        'curricula_id'
    ];
}
