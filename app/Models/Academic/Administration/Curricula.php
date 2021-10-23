<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curricula extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
        'state',
        'academic_level_id'
    ];
}
