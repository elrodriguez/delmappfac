<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocumentType extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'active','description'
    ];
}
