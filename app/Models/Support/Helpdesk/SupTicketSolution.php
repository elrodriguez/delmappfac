<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTicketSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_category_id',
        'sup_ticket_id',
        'user_id',
        'solution_description',
        'points',
        'user_id_like'
    ];
}
