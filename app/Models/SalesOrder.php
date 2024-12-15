<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'quotationCode',
        'idCustomers',
        'total',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomers');
    }

    public function quotation()
    {
        return $this->hasMany(SalesQuotation::class, 'code', 'quotationCode');
    }
}
