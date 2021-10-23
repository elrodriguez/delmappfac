<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $table = 'kardex';

    protected $fillable = [
        'date_of_issue',
        'type',
        'item_id',
        'purchase_id',
        'quantity'
    ];

}
