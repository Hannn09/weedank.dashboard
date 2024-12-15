<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'idCustomers',
        'idProducts',
        'expDate',
        'qty',
        'price',
        'total',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProducts', 'id');
    }

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomers', 'id');
    }

    // Accessor for Status Text
    public function getStatusTextAttribute()
    {
        $statuses = [
            0 => 'Draft',
            1 => 'Send',
            2 => 'Confirmed',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute()
    {
        $badgeClasses = [
            0 => 'bg-secondary', // Draft
            1 => 'bg-primary',   // Sent
            2 => 'bg-success',   // Confirmed
        ];

        return $badgeClasses[$this->status] ?? 'bg-dark'; // Default jika status tidak dikenal
    }
}
