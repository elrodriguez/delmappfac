<?php

namespace App\Models\Logistics\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEmployees extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'employee_id',
        'salary',
        'state',
        'occupation_id',
        'project_id',
        'stage_id'
    ];
}
