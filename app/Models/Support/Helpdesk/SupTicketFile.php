<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTicketFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_table_id',
        'sup_table_type',
        'original_name',
        'url',
        'extension',
        'user_id'
    ];
}
