<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'stock', 'price', 'img'];


    public function materials()
    {
        return $this->hasOne(Materials::class, 'idIngredients', 'id');
    }
}

