<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'idIngredients',
        'idVendor',
        'qtyIngredients',
        'orderDate',
        'total',
        'status',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredients::class, 'idIngredients');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'idVendor');
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'idQuotation');
    }
}
