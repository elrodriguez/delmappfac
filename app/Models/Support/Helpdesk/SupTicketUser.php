<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SupTicketUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_ticket_id',
        'user_id',
        'type',
        'incharge',
        'sup_service_area_id',
        'stars'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
