<?php

namespace App\Models\Logistics\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOtherExpenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'expense_id'
    ];
}
