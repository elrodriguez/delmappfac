<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tradename',
        'logo',
        'withdrawal_account',
        'id_management_type',
        'user_id',
        'identity_document_type_id',
        'number',
        'soap_type_id',
        'soap_username',
        'soap_password',
        'certificate',
        'certificate_due',
        'operation_amazonia',
        'detraction_account',
        'logo_store',
        'soap_send_id',
        'soap_url'
    ];

}
