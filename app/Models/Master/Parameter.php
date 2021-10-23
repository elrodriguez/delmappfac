<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type','code_sql','id_parameter','description','value_default'
    ];
}
