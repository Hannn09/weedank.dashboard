<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'idQuotation',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'idQuotation');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'idPurchase');
    }

    
}

