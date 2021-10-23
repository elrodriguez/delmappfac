<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_opening',
        'time_opening',
        'date_closed',
        'time_closed',
        'beginning_balance',
        'final_balance',
        'income',
        'state',
        'reference_number'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    //obtiene documentos y notas venta
    public function cash_documents()
    {
        return $this->hasMany(CashDocument::class);
    }

    public function scopeWhereTypeUser($query)
    {
        $user = auth()->user();
        return ($user->type == 'seller') ? $query->where('user_id', $user->id) : null;
    }

    public function global_destination()
    {
        return $this->morphMany(GlobalPayment::class, 'destination');
    }

    public function cash_transaction()
    {
        return $this->hasOne(CashTransaction::class);
    }

    public function getCurrencyTypeIdAttribute()
    {
        return 'PEN';
    }

    public function getNumberFullAttribute()
    {

        if($this->cash_transaction){
            return "{$this->cash_transaction->description} - Caja chica".($this->reference_number ? ' N° '.$this->reference_number:'');
        }

        return '-';

    }
}
