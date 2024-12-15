<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = ['salesOrderCode', 'quotationCode', 'idCustomers', 'total', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomers');
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesOrderCode', 'code');
    }

    public function quotation()
    {
        return $this->hasMany(SalesQuotation::class, 'code', 'quotationCode');
    }
}
