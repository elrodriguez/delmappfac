<?php

namespace App\Models\Academic\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageItemDetail extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable =[
        'package_id',
        'item_id',
        'discount_id',
        'order_number',
        'date_payment',
        'to_block'
    ];
}
