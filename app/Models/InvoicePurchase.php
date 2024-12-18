<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchaseId'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchaseId', 'id');
    }
}
