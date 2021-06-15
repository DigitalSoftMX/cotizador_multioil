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
    public function fit()
    {
        return $this->belongsTo('App\Fit', 'id', 'terminal_id');
    }

    public function competitions()
    {
        return $this->hasMany('App\Competition');
    }

    public function policons()
    {
        return $this->hasMany('App\Policon');
    }

    public function impulsas()
    {
        return $this->hasMany('App\Impulsa');
    }

    public function valeros()
    {
        return $this->hasMany('App\Valero');
    }

    public function hamses()
    {
        return $this->hasMany('App\Hamse');
    }

    public function potestas()
    {
        return $this->hasMany('App\Potesta');
    }

    public function energos()
    {
        return $this->hasMany('App\Energo');
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
