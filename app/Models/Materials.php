<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'idProducts',
        'idIngredients',
        'qtyBom',
        'qtyProduct',
        'productCost',
        'bomCost'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProducts', 'id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredients::class, 'idIngredients', 'id');
    }

    public function manufacturing()
    {
        return $this->hasOne(Manufacturing::class, 'idMaterials', 'id');
    }
}
