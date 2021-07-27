<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'alias', 'rfc', 'delivery_address', 'email', 'color', 'main', 'active'];
    // Relacion con las terminales
    public function terminals()
    {
        return $this->belongsToMany(Terminal::class, 'companies_terminals');
    }
    // relacion con los usuarios
    public function user()
    {
        return $this->hasOne(User::class);
    }
    // relacion con los usuarios para el caso ventas
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_companies');
    }
    // relacion con los precios
    public function prices()
    {
        return $this->hasMany(CompetitionPrice::class);
    }
}
