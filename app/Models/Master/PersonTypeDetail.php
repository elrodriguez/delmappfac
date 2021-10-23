<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonTypeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'person_type_id'
    ];
}
