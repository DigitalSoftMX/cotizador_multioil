<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceImpulsa extends Model
{
    protected $fillable = [
        'id', 'impulsa_id', 'precio_regular', 'precio_premium', 'precio_disel', 'created_at', 'updated_at',
    ];
    // relacion con la tabla impulsas
    public function impulsa()
    {
        return $this->belongsTo(Impulsa::class);
    }
}
