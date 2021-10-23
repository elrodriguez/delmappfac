<?php

namespace App\Models\Support\Helpdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_id',
        'sup_panic_level_id',
        'sup_service_area_id',
        'sup_category_id',
        'sup_reception_mode_id',
        'establishment_id',
        'description_of_problem',
        'ip_pc',
        'browser',
        'derivation_return_description',
        'description_completion_rejection',
        'version_sicmact',
        'state',
        'date_application',
        'date_attended',
        'date_finished',
        'sup_service_area_group_id',
        'minutes',
        'hours',
        'days'
    ];
}
