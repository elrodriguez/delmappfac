<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoCustomerMessages extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'customer_id',
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'customer_message_id',
        'message_id',
        'send'
    ];
}
