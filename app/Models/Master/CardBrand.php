<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CardBrand extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'description',
        'id',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('active', 1);
    //     });
    // }
}
