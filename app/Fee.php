<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = ['terminal_id', 'company_id', 'base_id', 'regular_fit', 'premium_fit', 'diesel_fit', 'active', 'created_at'];
    // conexion con las empresas
    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    // conexion con las terminales
    public function terminals()
    {
        return $this->belongsTo(Terminal::class, 'terminal_id', 'id');
    }
    // Relacion con los precios base del fee
    public function base()
    {
        return $this->belongsTo(Company::class, 'base_id', 'id');
    }
}
