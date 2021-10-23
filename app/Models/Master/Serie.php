<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'correlative',
        'establishment_id',
        'user_id',
        'document_type_id',
        'state'
    ];
}
