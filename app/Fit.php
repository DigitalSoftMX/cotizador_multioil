<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
    protected $fillable = ['terminal_id', 'company_id', 'comision', 'regular_fit', 'premium_fit', 'disel_fit', 'created_at'];
    // Conexion con la terminal
    public function terminal()
    {
        return $this->hasOne('App\Terminal', 'id', 'terminal_id');
    }
}
