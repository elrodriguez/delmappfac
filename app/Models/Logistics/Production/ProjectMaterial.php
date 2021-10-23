<?php

namespace App\Models\Logistics\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'project_id',
        'stage_id',
        'quantity',
        'unit_price',
        'expenses',
        'state',
        'brand_id',
        'obsolete_quantity',
        'lost_quantity',
        'pending_quantity',
        'leftovers_quantity',
        'observations',
    ];
}
