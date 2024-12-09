<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['code', 'name', 'stock', 'profit', 'img'];

    public function materials()
    {
        return $this->hasOne(Materials::class, 'idProducts', 'id');
    }
}
