<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTicketChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_ticket_id',
        'user_id',
        'user',
        'html',
        'message'
    ];
}
