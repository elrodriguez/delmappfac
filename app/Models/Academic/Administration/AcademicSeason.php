<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicSeason extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'description',
        'state'
    ];
}
