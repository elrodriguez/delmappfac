<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTicketRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_ticket_id',
        'user_id',
        'from_area_id',
        'from_group_id',
        'to_area_id',
        'to_group_id',
        'description',
        'state',
        'establishment_id'
    ];
}
