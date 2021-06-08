<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'rfc', 'delivery_address', 'fiscal_address', 'clabe', 'active'];
    // Relacion con las terminales
    public function terminals()
    {
        return $this->belongsToMany(Terminal::class, 'companies_terminals');
    }
}
