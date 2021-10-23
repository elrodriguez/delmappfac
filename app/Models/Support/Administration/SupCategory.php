<?php

namespace App\Models\Support\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_description',
        'detailed_description',
        'state',
        'sup_category_id',
        'minutes',
        'hours',
        'days'
    ];
}
