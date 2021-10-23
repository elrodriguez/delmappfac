<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFishingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'brand_id',
        'quantity',
        'unit_type_id',
        'item',
        'fishing_id',
        'document_fishing_id'
    ];

}
