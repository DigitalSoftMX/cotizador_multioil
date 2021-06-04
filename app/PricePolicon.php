<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricePolicon extends Model
{
    protected $fillable = [
        'id', 'policon_id', 'precio_regular', 'precio_premium', 'precio_disel', 'created_at', 'updated_at',
    ];
    // Relacion con la tabla policon
    public function policon()
    {
        return $this->belongsTo(Policon::class);
    }
}
