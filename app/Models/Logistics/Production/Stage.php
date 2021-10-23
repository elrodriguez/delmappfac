<?php

namespace App\Models\Logistics\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date_start',
        'date_end',
        'state',
        'project_id',
        'number_order'
    ];
}
