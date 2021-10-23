<?php

namespace App\Models\Academic\Subjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicTypeActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'state'
    ];
}
