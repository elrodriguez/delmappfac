<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'observation',
        'state',
        'id_company',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'web_page',
        'email',
        'urbanization'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
