<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_id',
        'document_id',
        'sale_note_id',
        'expense_payment_id'
    ];

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

    public function expense_payment()
    {
        return $this->belongsTo(\App\Models\Catalogue\CatExpenseMethodTypes::class);
    }
}
