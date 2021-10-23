<?php

namespace App\Models\Academic\Enrollment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentCommitments extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastre_id',
        'package_id',
        'package_item_detail_id',
        'student_id',
        'person_id',
        'package_item_detail',
        'state',
        'payment_date'
    ];
}
