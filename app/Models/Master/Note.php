<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $with = ['affected_document', 'note_credit_type', 'note_debit_type'];

    protected $fillable = [
        'document_id',
        'note_type',
        'note_credit_type_id',
        'note_debit_type_id',
        'note_description',
        'affected_document_id',        
        'data_affected_document'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function affected_document()
    {
        return $this->belongsTo(Document::class, 'affected_document_id');
    }

    public function note_credit_type()
    {
        return $this->belongsTo(\App\Models\Catalogue\NoteCreditType::class, 'note_credit_type_id');
    }

    public function note_debit_type()
    {
        return $this->belongsTo(\App\Models\Catalogue\NoteDebitType::class, 'note_debit_type_id');
    }

    public function getDataAffectedDocumentAttribute($value)
    {
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setDataAffectedDocumentAttribute($value)
    {
        $this->attributes['data_affected_document'] = (is_null($value))?null:json_encode($value);
    }
}
