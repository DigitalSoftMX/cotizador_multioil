<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $fillable = ['latitude', 'longitude', 'name', 'status', 'postcode', 'name_road', 'n_outsice', 'town', 'state'];
    // Relacion con los fees
    public function fits()
    {
        return $this->hasMany(Fee::class);
    }
    // Relacion con los precios
    public function prices()
    {
        return $this->hasMany(CompetitionPrice::class);
    }
    // Relacion con la empresa
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_terminals');
    }
    // Relacion con los precios
    public function precios()
    {
        return $this->hasMany(CompetitionPrice::class);
    }
}
