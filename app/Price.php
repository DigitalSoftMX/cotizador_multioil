<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'id', 'competition_id', 'precio_regular', 'precio_premium', 'precio_disel', 'created_at', 'updated_at',
    ];
    // relacion con la tabla competitions
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
