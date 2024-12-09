<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    use HasFactory;

    protected $fillable = [
        'idMaterials',
        'qty',
        'status'
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class, 'idMaterials', 'id');
    }

}
