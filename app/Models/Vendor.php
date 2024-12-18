<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'address', 'email', 'phone', 'img'];

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'idVendor', 'id');
    }
}
