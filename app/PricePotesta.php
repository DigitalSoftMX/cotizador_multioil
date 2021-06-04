<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricePotesta extends Model
{
    protected $fillable = [
        'id', 'potesta_id', 'precio_regular', 'precio_premium', 'precio_disel', 'created_at', 'updated_at',
    ];
    // Relacion con la tabla potesta
    public function potesta()
    {
        return $this->belongsTo(Potesta::class);
    }
}
