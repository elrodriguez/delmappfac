<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'description',
        'number',
        'currency_type_id',
        'cci',
        'status',
        'initial_balance'
    ];
    
    public $timestamps = false;

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function global_destination()
    {
        return $this->morphMany(GlobalPayment::class, 'destination')->with(['payment']);
    }


}
